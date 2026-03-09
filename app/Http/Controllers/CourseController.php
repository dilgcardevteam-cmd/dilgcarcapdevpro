<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    /**
     * Remove large inline media from rich HTML to keep JSON small and safe.
     * - Strips <img src="data:..."> and replaces with a small placeholder
     * - Strips <video>...</video> and <source src="blob:...">
     * - Trims excessive whitespace
     */
    protected function scrubHtml(?string $html): string
    {
        if (!$html) return '';
        // Remove <img> tags that embed base64 data
        $html = preg_replace('/<img[^>]*src="data:[^"]+"[^>]*>/i', '<p>[image removed]</p>', $html);
        // Remove <source> tags with blob URLs
        $html = preg_replace('/<source[^>]*src="blob:[^"]+"[^>]*>/i', '', $html);
        // Remove entire <video> blocks
        $html = preg_replace('/<video[^>]*>.*?<\/video>/is', '<p>[video removed]</p>', $html);
        // Safety: collapse long spaces
        $html = preg_replace('/\s{2,}/', ' ', $html);
        // Optional safety cap to avoid oversized payloads
        if (strlen($html) > 50000) {
            $html = substr($html, 0, 50000) . '…';
        }
        return $html;
    }

    /**
     * Sanitize an array of field objects in-place.
     */
    protected function sanitizeFields(?array $fields): ?array
    {
        if (!$fields || !is_array($fields)) return $fields;
        foreach ($fields as &$f) {
            if (isset($f['type']) && $f['type'] === 'text') {
                $f['html'] = $this->scrubHtml($f['html'] ?? '');
            }
        }
        return $fields;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        if (auth()->check() && auth()->user()->role === 'admin' && !$request->boolean('embedded')) {
            return redirect()->route('dashboard', [
                'tab' => 'course-create',
            ]);
        }

        return view('admin.course-create');
    }

    public function edit(Course $course)
    {
        return view('admin.course-edit', compact('course'));
    }

    public function trainerCreate()
    {
        $forTrainer = true;
        return view('admin.course-create', compact('forTrainer'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validateWithBag('create_course', [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'subject_area' => 'required|string',
            'video_url' => 'nullable|url',
            'video' => 'nullable|mimetypes:video/mp4,video/webm,video/ogg|max:204800',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
        ]);

        // Ensure DB columns that may be NOT NULL receive safe defaults
        if (!$request->filled('video_url')) {
            $validated['video_url'] = '';
        }

        if ($request->hasFile('image')) {
            try {
                Storage::disk('public')->makeDirectory('course_images');
                $file = $request->file('image');
                if (!$file->isValid()) {
                    $code = $file->getError();
                    $map = [
                        UPLOAD_ERR_INI_SIZE => 'Image exceeds server limit.',
                        UPLOAD_ERR_FORM_SIZE => 'Image exceeds form limit.',
                        UPLOAD_ERR_PARTIAL => 'Image was only partially uploaded.',
                        UPLOAD_ERR_NO_FILE => 'No image was uploaded.',
                        UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder on server.',
                        UPLOAD_ERR_CANT_WRITE => 'Failed to write image to disk.',
                        UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.',
                    ];
                    $msg = $map[$code] ?? 'Image upload error.';
                    return back()->withErrors(['image' => $msg], 'create_course')->withInput();
                }
                $imagePath = $file->store('course_images', 'public');
                $validated['image_path'] = $imagePath;
            } catch (\Throwable $e) {
                \Log::error('Course image upload failed', ['error' => $e->getMessage()]);
                return back()
                    ->withErrors(['image' => 'Image upload failed on server. Check storage permissions or disk space.'], 'create_course')
                    ->withInput();
            }
        }
        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('course_videos', 'public');
            $validated['video_path'] = $videoPath;
        }

        $modulesInput = $request->input('modules', []);
        $modules = [];
        foreach ($modulesInput as $i => $module) {
            $topics = [];
            $topicInput = $module['topics'] ?? [];
            foreach ($topicInput as $j => $topic) {
                // Support nested subtopics with fields; fallback to legacy topic.fields
                $subtopics = [];
                if (!empty($topic['subtopics']) && is_array($topic['subtopics'])) {
                    foreach ($topic['subtopics'] as $s) {
                        $sFields = null;
                        if (isset($s['fields_json'])) {
                            $sFields = json_decode($s['fields_json'], true);
                            $sFields = $this->sanitizeFields($sFields);
                        }
                        $subtopics[] = [
                            'title' => $s['title'] ?? '',
                            'fields' => $sFields,
                        ];
                    }
                }
                if (!empty($subtopics)) {
                    $topics[] = [
                        'title' => $topic['title'] ?? '',
                        'subtopics' => $subtopics,
                    ];
                } else {
                    $fields = null;
                    if (isset($topic['fields_json'])) {
                        $fields = json_decode($topic['fields_json'], true);
                        $fields = $this->sanitizeFields($fields);
                    } else {
                        // Backward compatibility: map old materials/questions into fields
                        $fields = [];
                        if (!empty($topic['materials_html'])) {
                            $fields[] = ['type' => 'text', 'html' => $this->scrubHtml($topic['materials_html'])];
                        }
                        if (isset($topic['questions_json'])) {
                            $qs = json_decode($topic['questions_json'], true) ?: [];
                            foreach ($qs as $q) {
                                $fields[] = ['type' => 'question', 'question' => $q];
                            }
                        }
                        if (empty($fields)) $fields = null;
                    }
                    $topics[] = [
                        'title' => $topic['title'] ?? '',
                        'fields' => $fields,
                    ];
                }
            }
            $exam = null;
            if (isset($module['exam_json'])) {
                $e = json_decode($module['exam_json'], true);
                if (is_array($e)) {
                    // Optional: strip essay types if present
                    $qs = array_values(array_filter(($e['questions'] ?? []), function($q){
                        return isset($q['type']) && in_array($q['type'], ['multiple_choice','identification','true_false'], true);
                    }));
                    $exam = [
                        'title' => (string) ($e['title'] ?? ''),
                        'description' => (string) ($e['description'] ?? ''),
                        'timer_minutes' => (int) ($e['timer_minutes'] ?? 0),
                        'questions' => $qs,
                    ];
                }
            }
            $mArr = [
                'title' => $module['title'] ?? '',
                'topics' => $topics,
                'status' => 'locked',
            ];
            if ($exam) { $mArr['exam'] = $exam; }
            $modules[] = $mArr;
        }
        // Append course-level exam as a special tail module if provided
        $cexam = $request->input('course_exam_json');
        if ($cexam) {
            $e = json_decode($cexam, true);
            if (is_array($e)) {
                $qs = array_values(array_filter(($e['questions'] ?? []), function($q){
                    return isset($q['type']) && in_array($q['type'], ['multiple_choice','identification','true_false'], true);
                }));
                $modules[] = [
                    'title' => 'Course Exam',
                    'topics' => [],
                    'exam' => [
                        'timer_minutes' => (int) ($e['timer_minutes'] ?? 0),
                        'questions' => $qs,
                    ],
                ];
            }
        }
        if (!empty($modules)) {
            $validated['modules'] = $modules;
        }

        $course = Course::create($validated);

        // Link the creator to the course so we can display "Created by"
        if (auth()->check()) {
            if (!$course->users()->where('user_id', auth()->id())->exists()) {
                $course->users()->attach(auth()->id(), ['status' => 'active']);
            }
        }

        if ($request->boolean('embedded')) {
            $target = route('dashboard', ['tab' => 'course-management']);
            $encodedTarget = json_encode($target, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
            return response(
                "<!doctype html><html><body><script>window.top.location.href={$encodedTarget};</script></body></html>",
                200,
                ['Content-Type' => 'text/html; charset=UTF-8']
            );
        }

        return redirect()->route('dashboard', ['tab' => 'course-management'])
            ->with('success_course', 'Course created successfully.');
    }

    public function trainerStore(Request $request)
    {
        $validated = $request->validateWithBag('create_course', [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'subject_area' => 'required|string',
            'video_url' => 'nullable|url',
            'video' => 'nullable|mimetypes:video/mp4,video/webm,video/ogg|max:204800',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
        ]);

        if (!$request->filled('video_url')) {
            $validated['video_url'] = '';
        }
        if ($request->hasFile('image')) {
            try {
                Storage::disk('public')->makeDirectory('course_images');
                $file = $request->file('image');
                if (!$file->isValid()) {
                    $code = $file->getError();
                    $map = [
                        UPLOAD_ERR_INI_SIZE => 'Image exceeds server limit.',
                        UPLOAD_ERR_FORM_SIZE => 'Image exceeds form limit.',
                        UPLOAD_ERR_PARTIAL => 'Image was only partially uploaded.',
                        UPLOAD_ERR_NO_FILE => 'No image was uploaded.',
                        UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder on server.',
                        UPLOAD_ERR_CANT_WRITE => 'Failed to write image to disk.',
                        UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.',
                    ];
                    $msg = $map[$code] ?? 'Image upload error.';
                    return back()->withErrors(['image' => $msg], 'create_course')->withInput();
                }
                $validated['image_path'] = $file->store('course_images', 'public');
            } catch (\Throwable $e) {
                \Log::error('Trainer course image upload failed', ['error' => $e->getMessage()]);
                return back()
                    ->withErrors(['image' => 'Image upload failed on server. Check storage permissions or disk space.'], 'create_course')
                    ->withInput();
            }
        }
        if ($request->hasFile('video')) {
            $validated['video_path'] = $request->file('video')->store('course_videos', 'public');
        }

        $modulesInput = $request->input('modules', []);
        $modules = [];
        foreach ($modulesInput as $module) {
            $topics = [];
            $topicInput = $module['topics'] ?? [];
            foreach ($topicInput as $topic) {
                $subtopics = [];
                if (!empty($topic['subtopics']) && is_array($topic['subtopics'])) {
                    foreach ($topic['subtopics'] as $s) {
                        $sFields = null;
                        if (isset($s['fields_json'])) {
                            $sFields = json_decode($s['fields_json'], true);
                            $sFields = $this->sanitizeFields($sFields);
                        }
                        $subtopics[] = [
                            'title' => $s['title'] ?? '',
                            'fields' => $sFields,
                        ];
                    }
                }
                if (!empty($subtopics)) {
                    $topics[] = [
                        'title' => $topic['title'] ?? '',
                        'subtopics' => $subtopics,
                    ];
                } else {
                    $fields = null;
                    if (isset($topic['fields_json'])) {
                        $fields = json_decode($topic['fields_json'], true);
                        $fields = $this->sanitizeFields($fields);
                    } else {
                        $fields = [];
                        if (!empty($topic['materials_html'])) {
                            $fields[] = ['type' => 'text', 'html' => $this->scrubHtml($topic['materials_html'])];
                        }
                        if (isset($topic['questions_json'])) {
                            $qs = json_decode($topic['questions_json'], true) ?: [];
                            foreach ($qs as $q) {
                                $fields[] = ['type' => 'question', 'question' => $q];
                            }
                        }
                        if (empty($fields)) $fields = null;
                    }
                    $topics[] = [
                        'title' => $topic['title'] ?? '',
                        'fields' => $fields,
                    ];
                }
            }
            $exam = null;
            if (isset($module['exam_json'])) {
                $e = json_decode($module['exam_json'], true);
                if (is_array($e)) {
                    $qs = array_values(array_filter(($e['questions'] ?? []), function($q){
                        return isset($q['type']) && in_array($q['type'], ['multiple_choice','identification','true_false'], true);
                    }));
                    $exam = [
                        'title' => (string) ($e['title'] ?? ''),
                        'description' => (string) ($e['description'] ?? ''),
                        'timer_minutes' => (int) ($e['timer_minutes'] ?? 0),
                        'questions' => $qs,
                    ];
                }
            }
            $mArr = [
                'title' => $module['title'] ?? '',
                'topics' => $topics,
                'status' => $existing['status'] ?? 'locked',
            ];
            if ($exam) { $mArr['exam'] = $exam; }
            $modules[] = $mArr;
        }
        // Append/replace course-level exam on update if provided
        $cexam = $request->input('course_exam_json');
        if ($cexam) {
            $e = json_decode($cexam, true);
            if (is_array($e)) {
                $qs = array_values(array_filter(($e['questions'] ?? []), function($q){
                    return isset($q['type']) && in_array($q['type'], ['multiple_choice','identification','true_false'], true);
                }));
                // Remove previous 'Course Exam' module if exists
                $modules = array_values(array_filter($modules, function($m){
                    return !(isset($m['exam']) && is_array($m['exam']) && isset($m['topics']) && empty($m['topics']));
                }));
                $modules[] = [
                    'title' => 'Course Exam',
                    'topics' => [],
                    'exam' => [
                        'timer_minutes' => (int) ($e['timer_minutes'] ?? 0),
                        'questions' => $qs,
                    ],
                ];
            }
        }
        if (!empty($modules)) {
            $validated['modules'] = $modules;
        }

        $course = Course::create($validated);

        if (auth()->check()) {
            if (!$course->users()->where('user_id', auth()->id())->exists()) {
                $course->users()->attach(auth()->id(), ['status' => 'active']);
            }
        }

        // Soft-archive until admin approval
        $course->delete();

        // Notify admins
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title' => 'New Course Submission',
                'message' => "Trainer ".auth()->user()->name." submitted '{$course->name}' for review.",
                'type' => 'course_submission',
                'related_id' => $course->id,
                'link' => route('dashboard', ['tab' => 'course-management']),
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Course submitted to admin for review.');
    }

    public function adminShow($course)
    {
        $course = Course::withTrashed()->findOrFail($course);
        // Ensure a creator is recorded for legacy courses without any linked user
        if ($course->users()->count() === 0 && auth()->check()) {
            if (!$course->users()->where('user_id', auth()->id())->exists()) {
                $course->users()->attach(auth()->id(), ['status' => 'active']);
            }
            $course->load('users');
        }
        return view('admin.course-show', compact('course'));
    }

    public function traineeShow(Course $course)
    {
        \Illuminate\Support\Facades\Log::info('traineeShow: loading course users', ['course_id' => $course->id]);
        if (auth()->check() && in_array(auth()->user()->role ?? null, ['trainer','coach'], true)) {
            return redirect()->route('trainer.courses.enter', $course);
        }
        $course->load(['users', 'materials', 'assessments']);
        \Illuminate\Support\Facades\Log::info('traineeShow: loaded users', [
            'course_id' => $course->id,
            'user_count' => $course->users->count(),
            'roles' => $course->users->pluck('role')->all(),
        ]);
        $announcements = \App\Models\ClassAnnouncement::with(['user','comments.user'])
            ->where('course_id', $course->id)
            ->orderBy('created_at', 'desc')
            ->get();
        $discussions = \App\Models\Discussion::with([
                'user',
                'replies.user',
                'replies.children.user',
                'replies.reactions',
                'replies.children.reactions'
            ])
            ->withCount(['replies as replies_count' => function($q){
                $q->whereNull('deleted_at');
            }])
            ->where('course_id', $course->id)
            ->latest()
            ->get();
        $status = null;
        if (auth()->check()) {
            $pivot = $course->users()->where('user_id', auth()->id())->first();
            if ($pivot) {
                $status = $pivot->pivot->status ?? 'active';
            }
        }
        // Compute overall completion for current user
        $completion = 0;
        if (auth()->check()) {
            $mods = is_array($course->modules) ? $course->modules : [];
            $rows = \App\Models\ReflectionResponse::where('user_id', auth()->id())
                ->where('course_id', $course->id)
                ->get(['module_index','topic_index','sub_index','answers_json']);
            $doneSet = [];
            foreach ($rows as $r) {
                $answers = is_array($r->answers_json) ? $r->answers_json : [];
                $val = array_key_exists('learned', $answers) && is_string($answers['learned'])
                    ? trim($answers['learned'])
                    : '';
                if ($val !== '') {
                    $doneSet["{$r->module_index}_{$r->topic_index}_{$r->sub_index}"] = true;
                }
            }
            $total=0; $done=0;
            foreach ($mods as $mi => $m) {
                $topics = isset($m['topics']) && is_array($m['topics']) ? $m['topics'] : [];
                foreach ($topics as $ti => $t) {
                    $subs = isset($t['subtopics']) && is_array($t['subtopics']) ? $t['subtopics'] : [];
                    $total += count($subs);
                    foreach ($subs as $si => $_) {
                        if (!empty($doneSet["{$mi}_{$ti}_{$si}"])) $done++;
                    }
                }
            }
            $completion = $total ? round(($done / $total) * 100) : 0;
        }
        // Build participants lists for view
        $coachRoles = ['coach','trainer','central_office_coach','regional_office_coach','provincial_office_coach'];
        $participantRoles = ['participant','trainee','central_office_participants','regional_office_participants','provincial_office_participants'];
        $coaches = ($course->users ?? collect([]))->filter(function($u) use ($coachRoles){
            return in_array($u->role ?? '', $coachRoles, true);
        })->values();
        $classmates = ($course->users ?? collect([]))->filter(function($u) use ($participantRoles){
            return in_array($u->role ?? '', $participantRoles, true);
        })->values();
        \Illuminate\Support\Facades\Log::info('traineeShow: participants resolved', [
            'course_id' => $course->id,
            'coaches' => $coaches->pluck('id')->all(),
            'classmates' => $classmates->pluck('id')->all(),
        ]);
        if (auth()->check() && strtolower(auth()->user()->email ?? '') === 'ro_participant@gmail.com') {
            return view('roparticipant.course-landing', [
                'course' => $course,
                'status' => $status,
                'announcements' => $announcements,
                'discussions' => $discussions,
                'completion' => $completion,
                'coaches' => $coaches,
                'classmates' => $classmates,
            ]);
        }
        return view('trainee.course-landing', [
            'course' => $course,
            'status' => $status,
            'announcements' => $announcements,
            'discussions' => $discussions,
            'completion' => $completion,
            'coaches' => $coaches,
            'classmates' => $classmates,
        ]);
    }
    
    public function trainerView(Course $course)
    {
        $course->load(['users', 'materials', 'assessments']);
        return view('trainee.course-show', [
            'course' => $course,
            'status' => 'active',
            'viewOnly' => true,
        ]);
    }
    public function trainerLanding(Course $course)
    {
        \Illuminate\Support\Facades\Log::info('trainerLanding: loading course users', ['course_id' => $course->id]);
        $course->load(['users', 'materials', 'assessments']);
        \Illuminate\Support\Facades\Log::info('trainerLanding: loaded users', [
            'course_id' => $course->id,
            'user_count' => $course->users->count(),
            'roles' => $course->users->pluck('role')->all(),
        ]);
        $announcements = \App\Models\ClassAnnouncement::with(['user','comments.user'])
            ->where('course_id', $course->id)
            ->orderBy('created_at', 'desc')
            ->get();
        $discussions = \App\Models\Discussion::with([
                'user',
                'replies.user',
                'replies.children.user',
                'replies.reactions',
                'replies.children.reactions'
            ])
            ->withCount(['replies as replies_count' => function($q){
                $q->whereNull('deleted_at');
            }])
            ->where('course_id', $course->id)
            ->latest()
            ->get();
        // Compute overall completion for trainer view as well (uses current user)
        $completion = 0;
        if (auth()->check()) {
            $mods = is_array($course->modules) ? $course->modules : [];
            $rows = \App\Models\ReflectionResponse::where('user_id', auth()->id())
                ->where('course_id', $course->id)
                ->get(['module_index','topic_index','sub_index','answers_json']);
            $doneSet = [];
            foreach ($rows as $r) {
                $answers = is_array($r->answers_json) ? $r->answers_json : [];
                $val = array_key_exists('learned', $answers) && is_string($answers['learned'])
                    ? trim($answers['learned'])
                    : '';
                if ($val !== '') {
                    $doneSet["{$r->module_index}_{$r->topic_index}_{$r->sub_index}"] = true;
                }
            }
            $total=0; $done=0;
            foreach ($mods as $mi => $m) {
                $topics = isset($m['topics']) && is_array($m['topics']) ? $m['topics'] : [];
                foreach ($topics as $ti => $t) {
                    $subs = isset($t['subtopics']) && is_array($t['subtopics']) ? $t['subtopics'] : [];
                    $total += count($subs);
                    foreach ($subs as $si => $_) {
                        if (!empty($doneSet["{$mi}_{$ti}_{$si}"])) $done++;
                    }
                }
            }
            $completion = $total ? round(($done / $total) * 100) : 0;
        }
        // Build participants lists for trainer landing as well
        $coachRoles = ['coach','trainer','central_office_coach','regional_office_coach','provincial_office_coach'];
        $participantRoles = ['participant','trainee','central_office_participants','regional_office_participants','provincial_office_participants'];
        $coaches = ($course->users ?? collect([]))->filter(function($u) use ($coachRoles){
            return in_array($u->role ?? '', $coachRoles, true);
        })->values();
        $classmates = ($course->users ?? collect([]))->filter(function($u) use ($participantRoles){
            return in_array($u->role ?? '', $participantRoles, true);
        })->values();
        \Illuminate\Support\Facades\Log::info('trainerLanding: participants resolved', [
            'course_id' => $course->id,
            'coaches' => $coaches->pluck('id')->all(),
            'classmates' => $classmates->pluck('id')->all(),
        ]);
        return view('trainee.course-landing', [
            'course' => $course,
            'status' => 'active',
            'announcements' => $announcements,
            'discussions' => $discussions,
            'asTrainer' => true,
            'completion' => $completion,
            'coaches' => $coaches,
            'classmates' => $classmates,
        ]);
    }
    public function traineeOutline(Course $course)
    {
        if (auth()->check() && in_array(auth()->user()->role ?? null, ['trainer','coach'], true)) {
            return redirect()->route('trainer.courses.view', $course);
        }
        $course->load(['users', 'materials', 'assessments']);
        $status = null;
        if (auth()->check()) {
            $pivot = $course->users()->where('user_id', auth()->id())->first();
            if ($pivot) {
                $status = $pivot->pivot->status ?? 'active';
            }
        }
        if (auth()->check() && strtolower(auth()->user()->email ?? '') === 'ro_participant@gmail.com') {
            return view('roparticipant.course-show', [
                'course' => $course,
                'status' => $status,
                'viewOnly' => $status !== 'active',
            ]);
        }
        return view('trainee.course-show', [
            'course' => $course,
            'status' => $status,
            'viewOnly' => $status !== 'active',
        ]);
    }
    public function trainerClassworkCreate(Course $course)
    {
        return view('trainer.classwork-select', ['course' => $course]);
    }
    public function trainerMaterialCreate(Course $course)
    {
        return view('trainer.material-create', ['course' => $course]);
    }
    public function trainerAssessmentCreate(Course $course)
    {
        return view('trainer.assessment-create', ['course' => $course]);
    }
    public function pending()
    {
        return redirect()->route('dashboard', ['tab' => 'pending-courses']);
    }

    public function participants(Course $course)
    {
        $course->load('users');
        $currentCourseTraineeIds = $course->users()->whereIn('role', ['participant','trainee'])->pluck('users.id')->toArray();
        $potentialTrainers = User::whereIn('role', ['coach','trainer'])
            ->where('status', 'active')
            ->get();
        // Only trainees already enrolled (pivot exists) for this course
        $potentialTrainees = User::whereIn('role', ['participant','trainee'])
            ->whereIn('id', $currentCourseTraineeIds)
            ->get();
        // For summary, show ALL active trainers with their courses (not only assigned)
        $assignedTrainers = User::whereIn('role', ['coach','trainer'])
            ->where('status', 'active')
            ->with('courses')
            ->get();
        // Trainees summary mirroring trainers summary
        $assignedTrainees = User::whereIn('role', ['participant','trainee'])
            ->whereIn('id', $currentCourseTraineeIds)
            ->with('courses')
            ->get();
        // Header notifications to match registrar dashboard header
        $notifications = Notification::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        $unreadNotificationsCount = Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->count();
        return view('registrar.course-participants', compact(
            'course',
            'potentialTrainers',
            'potentialTrainees',
            'assignedTrainers',
            'assignedTrainees',
            'notifications',
            'unreadNotificationsCount'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validateWithBag('update_course', [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'subject_area' => 'required|string',
            'video_url' => 'nullable|url',
            'video' => 'nullable|mimetypes:video/mp4,video/webm,video/ogg|max:204800',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($course->image_path) {
                Storage::disk('public')->delete($course->image_path);
            }
            try {
                Storage::disk('public')->makeDirectory('course_images');
                $file = $request->file('image');
                if (!$file->isValid()) {
                    $code = $file->getError();
                    $map = [
                        UPLOAD_ERR_INI_SIZE => 'Image exceeds server limit.',
                        UPLOAD_ERR_FORM_SIZE => 'Image exceeds form limit.',
                        UPLOAD_ERR_PARTIAL => 'Image was only partially uploaded.',
                        UPLOAD_ERR_NO_FILE => 'No image was uploaded.',
                        UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder on server.',
                        UPLOAD_ERR_CANT_WRITE => 'Failed to write image to disk.',
                        UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.',
                    ];
                    $msg = $map[$code] ?? 'Image upload error.';
                    return back()->withErrors(['image' => $msg], 'update_course')->withInput();
                }
                $imagePath = $file->store('course_images', 'public');
                $validated['image_path'] = $imagePath;
            } catch (\Throwable $e) {
                return back()
                    ->withErrors(['image' => 'Image upload failed on server. Check storage permissions or disk space.'], 'update_course')
                    ->withInput();
            }
        }
        if ($request->hasFile('video')) {
            if ($course->video_path) {
                Storage::disk('public')->delete($course->video_path);
            }
            $videoPath = $request->file('video')->store('course_videos', 'public');
            $validated['video_path'] = $videoPath;
        }

        $modulesInput = $request->input('modules', []);
        $modules = [];
        foreach ($modulesInput as $i => $module) {
            $topics = [];
            $topicInput = $module['topics'] ?? [];
            foreach ($topicInput as $j => $topic) {
                $existing = $course->modules[$i]['topics'][$j] ?? [];
                $fields = null;
                if (isset($topic['fields_json'])) {
                    $fields = json_decode($topic['fields_json'], true);
                } else {
                    // Backward compatibility
                    if (isset($topic['questions_json']) || isset($topic['materials_html'])) {
                        $fields = [];
                        if (!empty($topic['materials_html'])) {
                            $fields[] = ['type' => 'text', 'html' => $topic['materials_html']];
                        }
                        if (isset($topic['questions_json'])) {
                            $qs = json_decode($topic['questions_json'], true) ?: [];
                            foreach ($qs as $q) {
                                $fields[] = ['type' => 'question', 'question' => $q];
                            }
                        }
                    } else {
                        $fields = $existing['fields'] ?? null;
                    }
                }
                $topics[] = [
                    'title' => $topic['title'] ?? ($existing['title'] ?? ''),
                    'fields' => $fields,
                ];
            }
            $modules[] = [
                'title' => $module['title'] ?? '',
                'topics' => $topics,
            ];
        }
        if (!empty($modules)) {
            $validated['modules'] = $modules;
        }

        $course->update($validated);

        return redirect()->route('dashboard', ['tab' => 'course-management'])
            ->with('success_course', 'Course updated successfully.');
    }

    public function setModuleStatus(\Illuminate\Http\Request $request, \App\Models\Course $course, int $index)
    {
        $role = auth()->user()->role ?? null;
        if (!in_array($role, ['trainer','coach','super_admin','admin'], true)) {
            return response()->json(['ok' => false, 'error' => 'Unauthorized'], 403);
        }
        $status = $request->input('status');
        if (!in_array($status, ['locked','unlocked'], true)) {
            return response()->json(['ok' => false, 'error' => 'Invalid status'], 422);
        }
        $mods = is_array($course->modules) ? $course->modules : [];
        if (!array_key_exists($index, $mods)) {
            return response()->json(['ok' => false, 'error' => 'Module not found'], 404);
        }
        $mods[$index]['status'] = $status;
        $course->modules = $mods;
        $course->save();
        return response()->json(['ok' => true, 'status' => $status, 'module' => $mods[$index]]);
    }

    public function modulesStatus(\App\Models\Course $course)
    {
        $mods = is_array($course->modules) ? $course->modules : [];
        $out = [];
        foreach ($mods as $m) {
            $out[] = [
                'title' => (string)($m['title'] ?? ''),
                'status' => (string)($m['status'] ?? 'unlocked'),
            ];
        }
        return response()->json(['ok' => true, 'modules' => $out]);
    }

    public function modulesJson(\App\Models\Course $course)
    {
        $mods = $course->modules;
        if (is_string($mods)) {
            try { $mods = json_decode($mods, true); } catch (\Throwable $e) { $mods = []; }
        }
        if (!is_array($mods)) $mods = [];
        return response()->json(['ok' => true, 'modules' => $mods]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Course $course)
    {
        // Don't delete image immediately as we are soft deleting
        // if ($course->image_path) {
        //    Storage::disk('public')->delete($course->image_path);
        // }
        
        $course->delete();

        if ($request->boolean('embedded')) {
            session()->flash('success_course', 'Course archived successfully.');
            $target = route('dashboard', ['tab' => 'course-management']);
            $encodedTarget = json_encode($target, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
            return response(
                "<!doctype html><html><body><script>
                    try {
                        if (window.top && window.top !== window) {
                            if (typeof window.top.closeViewCourseModal === 'function') {
                                window.top.closeViewCourseModal();
                            }
                            window.top.location.href = {$encodedTarget};
                        } else {
                            window.location.href = {$encodedTarget};
                        }
                    } catch (e) {
                        window.location.href = {$encodedTarget};
                    }
                </script></body></html>",
                200,
                ['Content-Type' => 'text/html; charset=UTF-8']
            );
        }

        return redirect()->route('dashboard', ['tab' => 'course-management'])
            ->with('success_course', 'Course archived successfully.');
    }

    public function restore(Request $request, $id)
    {
        $course = Course::onlyTrashed()->findOrFail($id);
        $course->restore();

        // Activate coach/trainer pivot so they can enter class after admin approval
        try {
            $coachIds = $course->users()
                ->whereIn('role', ['coach','trainer'])
                ->pluck('users.id')
                ->toArray();
            foreach ($coachIds as $uid) {
                $course->users()->updateExistingPivot($uid, ['status' => 'active']);
            }
        } catch (\Throwable $e) {
            \Log::warning('Failed to activate coach/trainer pivot on restore', [
                'course_id' => $course->id,
                'error' => $e->getMessage(),
            ]);
        }

        if ($request->boolean('embedded')) {
            session()->flash('success_course', 'Course unarchived successfully.');
            $target = route('dashboard', ['tab' => 'course-management']);
            $encodedTarget = json_encode($target, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
            return response(
                "<!doctype html><html><body><script>
                    try {
                        if (window.top && window.top !== window) {
                            if (typeof window.top.closeViewCourseModal === 'function') {
                                window.top.closeViewCourseModal();
                            }
                            window.top.location.href = {$encodedTarget};
                        } else {
                            window.location.href = {$encodedTarget};
                        }
                    } catch (e) {
                        window.location.href = {$encodedTarget};
                    }
                </script></body></html>",
                200,
                ['Content-Type' => 'text/html; charset=UTF-8']
            );
        }

        return redirect()->route('dashboard', ['tab' => 'course-management'])
            ->with('success_course', 'Course unarchived successfully.');
    }

    public function forceDelete($id)
    {
        $course = Course::withTrashed()->findOrFail($id);
        if (!$course->trashed()) {
            $course->delete();
            return redirect()->route('dashboard', ['tab' => 'course-management'])
                ->with('success_course', 'Course archived. Open Archived Courses to delete permanently.')
                ->with('open_archived_modal', true);
        }
        try {
            \DB::transaction(function () use ($course) {
                // Detach users
                $course->users()->detach();
                // Remove assessments and grades
                $course->assessments()->each(function ($a) {
                    $a->grades()->delete();
                    $a->delete();
                });
                // Remove materials
                $course->materials()->delete();
                // Remove announcements and comments
                \App\Models\ClassAnnouncement::where('course_id', $course->id)->get()->each(function ($ann) {
                    \App\Models\ClassComment::where('class_announcement_id', $ann->id)->delete();
                    $ann->delete();
                });
                // Remove discussions (including soft-deleted)
                \App\Models\Discussion::withTrashed()->where('course_id', $course->id)->forceDelete();
                // Delete media files
                if ($course->image_path) {
                    Storage::disk('public')->delete($course->image_path);
                }
                if ($course->video_path) {
                    Storage::disk('public')->delete($course->video_path);
                }
                // Permanently delete course
                $course->forceDelete();
            });
            return redirect()->route('dashboard', ['tab' => 'course-management'])
                ->with('success_course', 'Course permanently deleted.')
                ->with('open_archived_modal', true);
        } catch (\Throwable $e) {
            \Log::error('Force delete course failed', ['course_id' => $course->id, 'error' => $e->getMessage()]);
            return redirect()->route('dashboard', ['tab' => 'course-management'])
                ->with('error_course', 'Failed to permanently delete course. Some related records may prevent deletion.')
                ->with('open_archived_modal', true);
        }
    }

    public function updateParticipants(Request $request, Course $course)
    {
        $request->validate([
            'trainer_ids' => 'nullable|array',
            'trainer_ids.*' => 'exists:users,id',
            'trainee_ids' => 'nullable|array',
            'trainee_ids.*' => 'exists:users,id',
        ]);

        // 1. Sync Trainers
        // Get current trainers associated with the course
        // We filter by the User's role 'trainer' to ensure we are managing the right subset of users
        // assuming the relationship is just users() and we distinguish by User role.
        $currentTrainerIds = $course->users()->get()->filter(function($user) {
            return in_array($user->role, ['coach','trainer']);
        })->pluck('id')->toArray();
        
        $newTrainerIds = $request->trainer_ids ?? [];

        $trainersToAttach = array_diff($newTrainerIds, $currentTrainerIds);
        $trainersToDetach = array_diff($currentTrainerIds, $newTrainerIds);

        if (!empty($trainersToAttach)) {
            $course->users()->attach($trainersToAttach, ['status' => 'active']);
            
            // Notify new coaches
            foreach ($trainersToAttach as $trainerId) {
                Notification::create([
                    'user_id' => $trainerId,
                    'title' => 'Course Assignment',
                    'message' => "You have been assigned as a coach for the course: {$course->name}.",
                    'type' => 'course_assignment',
                    'related_id' => $course->id,
                    'link' => route('dashboard'), // Trainers see their courses on dashboard
                ]);
            }
        }
        if (!empty($trainersToDetach)) {
            $course->users()->detach($trainersToDetach);
        }
        $trainersToUpdate = array_intersect($newTrainerIds, $currentTrainerIds);
        foreach ($trainersToUpdate as $id) {
            $pivot = $course->users()->where('user_id', $id)->first()->pivot;
            if (($pivot->status ?? null) !== 'active') {
                $course->users()->updateExistingPivot($id, ['status' => 'active']);
            }
        }

        // 2. Sync Trainees
        $currentTraineeIds = $course->users()->get()->filter(function($user) {
            return in_array($user->role, ['participant','trainee']);
        })->pluck('id')->toArray();
        
        $newTraineeIds = $request->trainee_ids ?? [];

        $traineesToAttach = array_diff($newTraineeIds, $currentTraineeIds);
        $traineesToDetach = array_diff($currentTraineeIds, $newTraineeIds);

        if (!empty($traineesToAttach)) {
            // Attach new ones as active
            $course->users()->attach($traineesToAttach, ['status' => 'active']);
            
            // Notify new participants
            foreach ($traineesToAttach as $traineeId) {
                Notification::create([
                    'user_id' => $traineeId,
                    'title' => 'Course Enrollment',
                    'message' => "You have been enrolled as a participant in the course: {$course->name}.",
                    'type' => 'enrollment_approved',
                    'related_id' => $course->id,
                    'link' => route('dashboard'), // Trainees see their courses on dashboard
                ]);
            }
        }

        // Update existing ones to active (specifically those moving from pending to active)
        $traineesToUpdate = array_intersect($newTraineeIds, $currentTraineeIds);
        foreach ($traineesToUpdate as $id) {
            // Check if status was pending before updating (optional optimization but good for correct notification context)
            $pivot = $course->users()->where('user_id', $id)->first()->pivot;
            if ($pivot->status !== 'active') {
                $course->users()->updateExistingPivot($id, ['status' => 'active']);
                
                // Notify updated participants
                Notification::create([
                    'user_id' => $id,
                    'title' => 'Course Enrollment Approved',
                    'message' => "Your request to join the course {$course->name} has been approved.",
                    'type' => 'enrollment_approved',
                    'related_id' => $course->id,
                    'link' => route('dashboard'),
                ]);
            }
        }

        if (!empty($traineesToDetach)) {
            $course->users()->detach($traineesToDetach);
        }

        return redirect()->route('dashboard', ['tab' => 'trainer-trainee-management'])
            ->with('success_enroll', 'Participants updated successfully.');
    }

    public function enrollUser(Request $request, Course $course)
    {
        $request->validate([
            'trainer_id' => 'nullable|exists:users,id',
            'trainee_ids' => 'nullable|array',
            'trainee_ids.*' => 'exists:users,id',
        ]);

        $count = 0;

        // Handle Coach
        if ($request->filled('trainer_id')) {
            if (!$course->users()->where('user_id', $request->trainer_id)->exists()) {
                $course->users()->attach($request->trainer_id, ['status' => 'active']);
                $count++;

                // Notify Coach
                Notification::create([
                    'user_id' => $request->trainer_id,
                    'title' => 'Course Assignment',
                    'message' => "You have been assigned as a coach for the course: {$course->name}.",
                    'type' => 'course_assignment',
                    'related_id' => $course->id,
                    'link' => route('dashboard'),
                ]);
            }
        }

        // Handle Trainees
        if ($request->filled('trainee_ids')) {
            foreach ($request->trainee_ids as $id) {
                if (!$course->users()->where('user_id', $id)->exists()) {
                    $course->users()->attach($id);
                    $count++;

                    // Notify Trainee
                    Notification::create([
                        'user_id' => $id,
                        'title' => 'Course Enrollment',
                        'message' => "You have been enrolled in the course: {$course->name}.",
                        'type' => 'enrollment_approved',
                        'related_id' => $course->id,
                        'link' => route('dashboard'),
                    ]);
                }
            }
        }

        if ($count > 0) {
            return redirect()->route('dashboard', ['tab' => 'trainer-trainee-management'])
                ->with('success_enroll', $count . ' participant(s) enrolled successfully.');
        }

        return redirect()->route('dashboard', ['tab' => 'trainer-trainee-management'])
            ->with('info', 'No new participants were added.');
    }

    public function detachUser(Course $course, User $user)
    {
        $course->users()->detach($user->id);
        return redirect()->route('dashboard', ['tab' => 'trainer-trainee-management'])
            ->with('success_detach', 'User removed from course successfully.');
    }

    public function join(Course $course)
    {
        $user = auth()->user();

        // Check if already enrolled or pending
        if ($course->users()->where('user_id', $user->id)->exists()) {
            return redirect()->route('dashboard', ['tab' => 'my-courses'])->with('error', 'You have already requested to join or are enrolled in this course.');
        }

        // Attach with pending status
        $course->users()->attach($user->id, ['status' => 'pending']);

        // Notify Registrars
        $registrars = User::where('role', 'registrar')->get();
        foreach ($registrars as $registrar) {
            Notification::create([
                'user_id' => $registrar->id,
                'title' => 'Course Enrollment Request',
                'message' => "User {$user->name} requested to join course {$course->name}.",
                'type' => 'enrollment',
                'related_id' => $user->id, // Or course->id, but user is more relevant for approval
                'link' => route('dashboard', ['tab' => 'trainer-trainee-management']), // Maybe deep link to course modal if possible, but tab is fine
            ]);
        }

        return redirect()->route('dashboard', ['tab' => 'my-courses'])->with('success_join', 'Enrollment request submitted successfully. Please wait for approval.');
    }
}
