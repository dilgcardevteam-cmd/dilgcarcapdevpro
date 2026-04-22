<?php

namespace App\Http\Controllers;

use App\Models\ReflectionResponse;
use App\Models\Course;
use App\Traits\HandlesCertification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReflectionController extends Controller
{
    use HandlesCertification;

    protected function userId()
    {
        return Auth::id();
    }

    public function map(Request $request, $courseId)
    {
        $userId = $this->userId();
        $rows = ReflectionResponse::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->get(['module_index','topic_index','sub_index','answers_json']);
        // Aggregate to TOPIC level: consolidate all subtopic reflections under sub_index = -1
        $agg = [];
        foreach ($rows as $r) {
            $answers = is_array($r->answers_json) ? $r->answers_json : [];
            $val = array_key_exists('learned', $answers) && is_string($answers['learned'])
                ? trim($answers['learned'])
                : '';
            $topicKey = "{$r->module_index}_{$r->topic_index}_-1";
            if (!isset($agg[$topicKey])) $agg[$topicKey] = [];
            if ($val !== '') {
                $agg[$topicKey][] = $val;
            }
        }
        $map = [];
        foreach ($agg as $k => $list) {
            // Consolidate with blank line separation
            $map[$k] = ['submitted' => true, 'learned' => implode("\n\n", array_values(array_unique($list)))];
        }
        return response()->json(['map' => $map]);
    }

    public function store(Request $request, $courseId)
    {
        $userId = $this->userId();
        $data = $request->validate([
            'module_index' => 'required|integer|min:0',
            'topic_index' => 'required|integer|min:0',
            // Topic-level reflections indicated by sub_index = -1
            'sub_index' => 'required|integer|min:-1',
            'questions' => 'required|array',
            'answers' => 'required|array',
        ]);

        $learned = '';
        if (isset($data['answers']['learned']) && is_string($data['answers']['learned'])) {
            $learned = trim($data['answers']['learned']);
        }
        $data['answers']['learned'] = $learned;

        // Normalize topic-level to a safe stored sub_index (avoid negative on unsigned columns)
        $si = $data['sub_index'] ?? 0;
        if ($si < 0) $si = 0;
        $row = ReflectionResponse::updateOrCreate(
            [
                'user_id' => $userId,
                'course_id' => $courseId,
                'module_index' => $data['module_index'],
                'topic_index' => $data['topic_index'],
                'sub_index' => $si,
            ],
            [
                'questions_json' => $data['questions'],
                'answers_json' => $data['answers'],
            ]
        );

        // Check if course is now 100% complete and issue certificate
        $course = Course::find($courseId);
        $user = Auth::user();
        $completed = false;
        if ($course && $user) {
            $mods = is_array($course->modules) ? $course->modules : (json_decode((string) $course->modules, true) ?: []);
            $contentIndexes = [];
            foreach ((array) $mods as $moduleIndex => $module) {
                $topics = isset($module['topics']) && is_array($module['topics']) ? $module['topics'] : [];
                if (!empty($topics)) {
                    $contentIndexes[] = $moduleIndex;
                }
            }
            $completedModules = 0;
            foreach ($contentIndexes as $position => $moduleIndex) {
                $module = $mods[$moduleIndex] ?? [];
                $topics = isset($module['topics']) && is_array($module['topics']) ? $module['topics'] : [];
                $doneTopics = ReflectionResponse::where('user_id', $user->id)
                    ->where('course_id', $courseId)
                    ->where('module_index', $moduleIndex)
                    ->get(['topic_index'])
                    ->pluck('topic_index')
                    ->unique()
                    ->count();
                if ($doneTopics >= count($topics)) {
                    $completedModules = $position + 1;
                    continue;
                }
                break;
            }
            $totalModules = count($contentIndexes);
            $currentModule = $totalModules > 0 ? min($completedModules + 1, $totalModules) : 1;
            $progress = $totalModules > 0 ? round(($completedModules / $totalModules) * 100, 2) : 0;
            $status = $completedModules >= $totalModules && $totalModules > 0 ? 'ready_for_exam' : 'in_progress';
            $course->users()->updateExistingPivot($user->id, [
                'current_module' => $currentModule,
                'progress_percentage' => $progress,
                'status' => $status,
            ]);
            $completed = $this->issueCertificateIfCompleted($user, $course);
        }

        return response()->json(['ok' => true, 'id' => $row->id, 'completed' => $completed]);
    }

    public function progress(Request $request, \App\Models\Course $course)
    {
        $user = Auth::user();
        $progress = $course->getCourseProgress($user);
        
        // Prepare module-specific progress for the AJAX response
        $mods = is_array($course->modules) ? $course->modules : [];
        $reflectionRows = \App\Models\ReflectionResponse::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->get(['module_index', 'topic_index', 'answers_json']);
        
        $topicDoneSet = [];
        foreach ($reflectionRows as $r) {
            $topicDoneSet["{$r->module_index}_{$r->topic_index}"] = true;
        }

        $modules = [];
        foreach ($mods as $mi => $m) {
            $topics = isset($m['topics']) && is_array($m['topics']) ? $m['topics'] : [];
            $mTotal = count($topics);
            $mDone = 0;
            foreach ($topics as $ti => $_t) {
                if (!empty($topicDoneSet["{$mi}_{$ti}"])) {
                    $mDone++;
                }
            }
            
            $isExam = isset($m['exam']) && is_array($m['exam']) && !empty($m['exam']['questions']);
            $modules[] = [
                'index' => $mi,
                'title' => is_array($m) ? ($m['title'] ?? "Module ".($mi+1)) : "Module ".($mi+1),
                'done' => $mDone,
                'total' => $mTotal,
                'percent' => $mTotal ? round(($mDone/$mTotal)*100) : 0,
                'is_exam' => $isExam,
                'exam_title' => $isExam ? (string)($m['exam']['title'] ?? '') : '',
            ];
        }

        return response()->json([
            'overall' => [
                'done' => $progress['completed'],
                'total' => $progress['total'],
                'percent' => round($progress['percentage']),
                'topics_done' => $progress['topics_completed'],
                'topics_total' => $progress['topics_total'],
                'assessments_done' => $progress['assessments_completed'],
                'assessments_total' => $progress['assessments_total'],
            ],
            'modules' => $modules,
        ]);
    }
}
