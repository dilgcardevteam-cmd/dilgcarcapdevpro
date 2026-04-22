<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use App\Traits\LogsActivity;

class Course extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $appends = ['image_url', 'enrollment_status', 'course_active_status', 'can_enroll', 'can_access'];

    public function getEnrollmentStatusAttribute()
    {
        if (!$this->is_published) return 'Draft';

        if (!$this->course_expiration_date) return 'Waiting for Admin';

        if (!$this->enrollment_start_date || !$this->enrollment_end_date) {
            return 'Waiting for Registrar/TM';
        }

        $now = now()->startOfDay();
        $start = $this->enrollment_start_date->startOfDay();
        $end = $this->enrollment_end_date->startOfDay();
        $expiry = $this->course_expiration_date->startOfDay();

        if ($now->gt($expiry)) return 'Expired';

        if ($now->lt($start)) return 'Upcoming';

        if ($now->lte($end)) return 'Open for Enrollment';

        return 'Enrollment Closed';
    }

    public function getCourseActiveStatusAttribute()
    {
        if (!$this->is_published) return 'Draft';
        if (!$this->start_date) return 'Waiting for Start Date';
        
        $now = now()->startOfDay();
        $start = $this->start_date->startOfDay();
        $expiry = $this->course_expiration_date ? $this->course_expiration_date->startOfDay() : null;

        if ($expiry && $now->gt($expiry)) return 'Expired';
        if ($now->lt($start)) return 'Not Yet Started';
        
        return 'Active';
    }

    public function getCanEnrollAttribute()
    {
        return $this->enrollment_status === 'Open for Enrollment';
    }

    public function getCanAccessAttribute()
    {
        return $this->course_active_status === 'Active';
    }

    protected $fillable = [
        'name',
        'description',
        'subject_area',
        'academic_year',
        'video_url',
        'image_path',
        'modules',
        'video_path',
        'is_published',
        'enrollment_start_at',
        'enrollment_end_at',
        'enrollment_start_date',
        'enrollment_end_date',
        'course_expiration_date',
        'trainer_id',
        'start_date',
        'end_date',
        'trainer_ready',
        'enrollment_start',
        'enrollment_end',
        'certification_id',
        'course_type',
        'access_code',
        'academic_year_id',
    ];

    /**
     * Get the academic year for the course.
     */
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function certification()
    {
        return $this->belongsTo(Certification::class);
    }

    protected $casts = [
        'modules' => 'array',
        'is_published' => 'boolean',
        'enrollment_start_at' => 'date',
        'enrollment_end_at' => 'date',
        'enrollment_start_date' => 'date',
        'enrollment_end_date' => 'date',
        'course_expiration_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        'trainer_ready' => 'boolean',
        'enrollment_start' => 'datetime',
        'enrollment_end' => 'datetime',
    ];

    public static function subjectAreaOptions(): array
    {
        return [
            'Public Administrative & Financial',
            'Technical & Infrastructure',
            'Information & Technology',
            'Health & Social Services',
            'Public Safety & Regulation',
            'Legal & Governance',
            'Business & Economic Development',
            'Environment & Agriculture',
            'Education, Culture & Community',
        ];
    }

    public static function legacySubjectAreaMap(): array
    {
        return [
            'Core Governance & Administration' => 'Public Administrative & Financial',
            'Finance & Compliance' => 'Public Administrative & Financial',
            'Digital Transformation' => 'Information & Technology',
            'ICT & Technical Skills' => 'Information & Technology',
            'Economic & Business Development' => 'Business & Economic Development',
            'Social Governance' => 'Legal & Governance',
            'Human Capital & Leadership' => 'Education, Culture & Community',
            'Community & Development Planning' => 'Education, Culture & Community',
        ];
    }

    public static function normalizeSubjectAreaLabel(string $label): string
    {
        $clean = trim($label);
        if ($clean === '') {
            return '';
        }
        $map = self::legacySubjectAreaMap();
        return $map[$clean] ?? $clean;
    }

    public static function decodeSubjectAreas(?string $raw): array
    {
        $rawStr = trim((string) ($raw ?? ''));
        if ($rawStr === '') {
            return [];
        }
        $decoded = json_decode($rawStr, true);
        if (is_array($decoded)) {
            return array_values(array_filter(array_map(function ($v) {
                return is_string($v) ? trim($v) : '';
            }, $decoded)));
        }
        return array_values(array_filter(array_map('trim', preg_split('/\s*,\s*/', $rawStr) ?: [])));
    }

    public static function normalizeSubjectAreas(?string $raw): array
    {
        $allowed = array_fill_keys(self::subjectAreaOptions(), true);
        $out = [];
        foreach (self::decodeSubjectAreas($raw) as $label) {
            $norm = self::normalizeSubjectAreaLabel($label);
            if ($norm !== '' && isset($allowed[$norm])) {
                $out[$norm] = true;
            }
        }
        return array_keys($out);
    }

    public function subjectAreas(): array
    {
        return self::decodeSubjectAreas($this->subject_area);
    }

    public function subjectAreasNormalized(): array
    {
        return self::normalizeSubjectAreas($this->subject_area);
    }

    public function subjectAreaText(): string
    {
        $areas = $this->subjectAreasNormalized();
        if (empty($areas)) {
            $areas = $this->subjectAreas();
        }
        return implode(', ', array_values(array_filter(array_map('trim', $areas))));
    }

    /**
     * Check if the course is currently enrollable.
     */
    public function isEnrollable()
    {
        if (!$this->is_published) {
            return false;
        }

        // If trainer hasn't set their schedule yet, we fallback to Registrar's schedule if available,
        // or just check trainer_ready flag based on your new double-gated requirement.
        if (!$this->trainer_ready) {
            return false;
        }

        $now = now();
        
        // Use the enrollment dates set by Registrar (which are saved in enrollment_start/end via the new method)
        if ($this->enrollment_start && $now->lt($this->enrollment_start)) {
            return false;
        }

        if ($this->enrollment_end && $now->gt($this->enrollment_end)) {
            return false;
        }

        return true;
    }

    /**
     * Get the trainer/creator of the course.
     */
    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    /**
     * Get the dynamic status of the course based on its duration.
     */
    public function getCourseStatusAttribute()
    {
        $now = now()->startOfDay();
        
        if (!$this->start_date || !$this->end_date) {
            return 'Schedule not set';
        }

        if ($now->lt($this->start_date)) {
            return 'Upcoming';
        }

        if ($now->gte($this->start_date) && $now->lte($this->end_date)) {
            return 'Ongoing';
        }

        if ($now->gt($this->end_date)) {
            return 'Completed';
        }

        return 'Unknown';
    }

    public function getImageUrlAttribute(): string
    {
        $path = trim((string) ($this->image_path ?? ''));
        if ($path === '') {
            return 'data:image/svg+xml;utf8,' . rawurlencode(
                '<svg xmlns="http://www.w3.org/2000/svg" width="600" height="300" viewBox="0 0 600 300"><rect width="600" height="300" rx="24" fill="#eef4ff"/><path d="M210 112h180a16 16 0 0 1 16 16v30a16 16 0 0 1-16 16H210a16 16 0 0 1-16-16v-30a16 16 0 0 1 16-16Z" fill="#dbe7fb"/><circle cx="244" cy="143" r="22" fill="#93c5fd"/><path d="M218 210l54-52 44 38 44-58 68 72H218Z" fill="#bfdbfe"/><text x="300" y="256" text-anchor="middle" fill="#1d4ed8" font-family="Arial, sans-serif" font-size="24" font-weight="700">No Image</text></svg>'
            );
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            $parsedPath = (string) (parse_url($path, PHP_URL_PATH) ?? '');
            if (str_contains($parsedPath, '/storage/')) {
                $after = substr($parsedPath, strpos($parsedPath, '/storage/') + strlen('/storage/'));
                $after = ltrim($after, '/');
                if ($after !== '') {
                    $v = optional($this->updated_at)->timestamp ?? time();
                    return route('media.public', ['path' => $after], false) . '?v=' . $v;
                }
            }
            return $path;
        }

        $normalized = ltrim($path, '/');
        if (str_starts_with($normalized, 'storage/')) {
            $normalized = substr($normalized, strlen('storage/'));
        }
        if (str_starts_with($normalized, 'public/')) {
            $normalized = substr($normalized, strlen('public/'));
        }
        $extension = strtolower(pathinfo($normalized, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];

        if ($extension === '' || !in_array($extension, $allowedExtensions, true)) {
            return 'data:image/svg+xml;utf8,' . rawurlencode(
                '<svg xmlns="http://www.w3.org/2000/svg" width="600" height="300" viewBox="0 0 600 300"><rect width="600" height="300" rx="24" fill="#eef4ff"/><path d="M210 112h180a16 16 0 0 1 16 16v30a16 16 0 0 1-16 16H210a16 16 0 0 1-16-16v-30a16 16 0 0 1 16-16Z" fill="#dbe7fb"/><circle cx="244" cy="143" r="22" fill="#93c5fd"/><path d="M218 210l54-52 44 38 44-58 68 72H218Z" fill="#bfdbfe"/><text x="300" y="256" text-anchor="middle" fill="#1d4ed8" font-family="Arial, sans-serif" font-size="24" font-weight="700">No Preview</text></svg>'
            );
        }

        if (!Storage::disk('public')->exists($normalized)) {
            return 'data:image/svg+xml;utf8,' . rawurlencode(
                '<svg xmlns="http://www.w3.org/2000/svg" width="600" height="300" viewBox="0 0 600 300"><rect width="600" height="300" rx="24" fill="#eef4ff"/><path d="M210 112h180a16 16 0 0 1 16 16v30a16 16 0 0 1-16 16H210a16 16 0 0 1-16-16v-30a16 16 0 0 1 16-16Z" fill="#dbe7fb"/><circle cx="244" cy="143" r="22" fill="#93c5fd"/><path d="M218 210l54-52 44 38 44-58 68 72H218Z" fill="#bfdbfe"/><text x="300" y="256" text-anchor="middle" fill="#1d4ed8" font-family="Arial, sans-serif" font-size="24" font-weight="700">Missing Image</text></svg>'
            );
        }

        $v = optional($this->updated_at)->timestamp ?? time();
        return route('media.public', ['path' => $normalized], false) . '?v=' . $v;
    }

    public function users()
    {
        $pivotColumns = ['status'];
        if (Schema::hasColumn('course_user', 'current_module')) {
            $pivotColumns[] = 'current_module';
        }
        if (Schema::hasColumn('course_user', 'progress_percentage')) {
            $pivotColumns[] = 'progress_percentage';
        }
        if (Schema::hasColumn('course_user', 'retake_requested')) {
            $pivotColumns[] = 'retake_requested';
        }
        if (Schema::hasColumn('course_user', 'retake_approved')) {
            $pivotColumns[] = 'retake_approved';
        }

        return $this->belongsToMany(User::class, 'course_user')
            ->withPivot($pivotColumns)
            ->withTimestamps();
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }

    public function getCourseProgress(User $user)
    {
        $totalAssessments = $this->assessments()->count();
        $gradedAssessments = 0;
        foreach ($this->assessments as $assessment) {
            $latestGrade = $assessment->grades()
                ->where('user_id', $user->id)
                ->orderBy('score', 'desc') // Check highest score
                ->first();
            
            if ($latestGrade) {
                $passingScore = $assessment->passing_score ?? 70; // default 70 if not set
                if ($latestGrade->score >= $passingScore) {
                    $gradedAssessments++;
                }
            }
        }

        // Also calculate topic completion from ReflectionResponses
        $mods = is_array($this->modules) ? $this->modules : [];
        $reflectionRows = \App\Models\ReflectionResponse::where('user_id', $user->id)
            ->where('course_id', $this->id)
            ->get(['module_index', 'topic_index', 'answers_json']);
        
        $topicDoneSet = [];
        foreach ($reflectionRows as $r) {
            $answers = is_array($r->answers_json) ? $r->answers_json : [];
            $val = array_key_exists('learned', $answers) && is_string($answers['learned'])
                ? trim($answers['learned'])
                : '';
            if ($val === '') continue;
            $topicDoneSet["{$r->module_index}_{$r->topic_index}"] = true;
        }

        $totalTopics = 0;
        $doneTopics = 0;
        foreach ($mods as $mi => $m) {
            $topics = isset($m['topics']) && is_array($m['topics']) ? $m['topics'] : [];
            $totalTopics += count($topics);
            foreach ($topics as $ti => $_t) {
                if (!empty($topicDoneSet["{$mi}_{$ti}"])) {
                    $doneTopics++;
                }
            }
        }

        $totalItems = $totalAssessments + $totalTopics;
        $completedItems = $gradedAssessments + $doneTopics;

        if ($totalItems === 0) {
            return [
                'completed' => 0,
                'total' => 0,
                'percentage' => 0,
                'topics_completed' => 0,
                'topics_total' => 0,
                'assessments_completed' => 0,
                'assessments_total' => 0,
            ];
        }

        return [
            'completed' => $completedItems,
            'total' => $totalItems,
            'percentage' => ($completedItems / $totalItems) * 100,
            'topics_completed' => $doneTopics,
            'topics_total' => $totalTopics,
            'assessments_completed' => $gradedAssessments,
            'assessments_total' => $totalAssessments,
        ];
    }
}
