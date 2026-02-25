<?php

namespace App\Http\Controllers;

use App\Models\ReflectionResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReflectionController extends Controller
{
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
        $map = [];
        foreach ($rows as $r) {
            $answers = is_array($r->answers_json) ? $r->answers_json : [];
            $val = array_key_exists('learned', $answers) && is_string($answers['learned'])
                ? trim($answers['learned'])
                : '';
            if ($val !== '') {
                $map["{$r->module_index}_{$r->topic_index}_{$r->sub_index}"] = true;
            }
        }
        return response()->json(['map' => $map]);
    }

    public function store(Request $request, $courseId)
    {
        $userId = $this->userId();
        $data = $request->validate([
            'module_index' => 'required|integer|min:0',
            'topic_index' => 'required|integer|min:0',
            'sub_index' => 'nullable|integer|min:0',
            'questions' => 'required|array',
            'answers' => 'required|array',
        ]);

        $learned = '';
        if (isset($data['answers']['learned']) && is_string($data['answers']['learned'])) {
            $learned = trim($data['answers']['learned']);
        }
        if ($learned === '') {
            return response()->json([
                'ok' => false,
                'error' => 'Reflection cannot be empty.'
            ], 422);
        }

        $row = ReflectionResponse::updateOrCreate(
            [
                'user_id' => $userId,
                'course_id' => $courseId,
                'module_index' => $data['module_index'],
                'topic_index' => $data['topic_index'],
                'sub_index' => $data['sub_index'] ?? null,
            ],
            [
                'questions_json' => $data['questions'],
                'answers_json' => $data['answers'],
            ]
        );

        return response()->json(['ok' => true, 'id' => $row->id]);
    }

    public function progress(Request $request, \App\Models\Course $course)
    {
        $userId = $this->userId();
        $mods = is_array($course->modules) ? $course->modules : [];
        $rows = ReflectionResponse::where('user_id', $userId)
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
        $overallTotal = 0;
        $overallDone = 0;
        $modules = [];
        foreach ($mods as $mi => $m) {
            $topics = isset($m['topics']) && is_array($m['topics']) ? $m['topics'] : [];
            $mTotal = 0;
            $mDone = 0;
            foreach ($topics as $ti => $t) {
                $subs = isset($t['subtopics']) && is_array($t['subtopics']) ? $t['subtopics'] : [];
                $mTotal += count($subs);
                foreach ($subs as $si => $_) {
                    if (!empty($doneSet["{$mi}_{$ti}_{$si}"])) {
                        $mDone++;
                    }
                }
            }
            $overallTotal += $mTotal;
            $overallDone += $mDone;
            $modules[] = [
                'index' => $mi,
                'title' => is_array($m) ? ($m['title'] ?? "Module ".($mi+1)) : "Module ".($mi+1),
                'done' => $mDone,
                'total' => $mTotal,
                'percent' => $mTotal ? round(($mDone/$mTotal)*100) : 0,
            ];
        }
        $overallPercent = $overallTotal ? round(($overallDone/$overallTotal)*100) : 0;
        return response()->json([
            'overall' => [
                'done' => $overallDone,
                'total' => $overallTotal,
                'percent' => $overallPercent,
            ],
            'modules' => $modules,
        ]);
    }
}
