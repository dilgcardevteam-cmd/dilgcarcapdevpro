<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assessment;
use App\Models\Grade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AssessmentAnswerController extends Controller
{
    public function take(Assessment $assessment)
    {
        $user = Auth::user();
        if(!$user){ abort(401); }
        $questions = is_array($assessment->questions_json)
            ? $assessment->questions_json
            : (json_decode($assessment->questions_json, true) ?: []);
        // Auto-recover if questions are missing
        if(empty($questions)){
            try{
                $path = 'assessment_backups/assessment_'.$assessment->id.'_latest.json';
                if(Storage::disk('local')->exists($path)){
                    $json = json_decode(Storage::disk('local')->get($path), true) ?: [];
                    $qs = $json['questions_json'] ?? [];
                    if(!empty($qs)){
                        $questions = $qs;
                        $assessment->update(['questions_json'=>json_encode($qs)]);
                    }
                }
                if(empty($questions)){
                    $tpl = \App\Models\AssessmentTemplate::where('title',$assessment->title)
                        ->where('type',$assessment->type)->orderBy('updated_at','desc')->first();
                    if($tpl){
                        $qs = is_array($tpl->questions_json) ? $tpl->questions_json : (json_decode($tpl->questions_json,true) ?: []);
                        if(!empty($qs)){
                            $questions = $qs;
                            $assessment->update(['questions_json'=>json_encode($qs)]);
                        }
                    }
                }
            }catch(\Throwable $e){
                Log::warning('Auto recover take() failed', ['assessment_id'=>$assessment->id,'message'=>$e->getMessage()]);
            }
        }
        if ($user && strtolower($user->email) === 'ro_participant@gmail.com') {
            return view('roparticipant.assessment-take', [
                'assessment' => $assessment,
                'questions' => $questions,
            ]);
        }
        return view('trainee.assessment-take', [
            'assessment' => $assessment,
            'questions' => $questions,
        ]);
    }

    public function submit(Request $request, Assessment $assessment)
    {
        $user = Auth::user();
        if(!$user){ abort(401); }
        $attemptNo = Grade::where('assessment_id', $assessment->id)
            ->where('user_id', $user->id)
            ->count() + 1;
        $answers = $request->input('answers', []);
        $questions = is_array($assessment->questions_json)
            ? $assessment->questions_json
            : (json_decode($assessment->questions_json, true) ?: []);
        $score = 0;
        $total = 0;
        $manualPending = [];
        foreach($questions as $idx => $q){
            $type = (string) ($q['type'] ?? '');
            $ans = $answers[$idx] ?? null;
            if($type === 'identification' || $type === 'enumeration' || $type === 'essay'){
                $manualPending[] = [
                    'question_index' => $idx,
                    'type' => $type,
                    'status' => 'pending',
                    'answer' => $ans,
                ];
                continue;
            }

            $total++;
            if($type === 'multiple_choice' || $type === 'multiple_choice_single'){
                if(isset($q['answer_index']) && (string)$ans === (string)$q['answer_index']) $score++;
            }elseif($type === 'multiple_choice_multiple'){
                $expected = array_map('strval', (array) ($q['correct_answers'] ?? $q['answers'] ?? []));
                $submitted = array_map('strval', is_array($ans) ? $ans : ($ans === null || $ans === '' ? [] : [$ans]));
                sort($expected);
                sort($submitted);
                if($expected === $submitted) $score++;
            }elseif($type === 'true_false'){
                $truth = !empty($q['answer']);
                if(($ans === '1') || ($ans === 'true') || ($ans === 1) || ($ans === true)){ $ansBool = true; }
                else { $ansBool = false; }
                if($truth === $ansBool) $score++;
            }
        }
        $percent = $total > 0 ? round(($score / $total) * 100, 2) : 0;
        Grade::create([
            'assessment_id' => $assessment->id,
            'user_id' => $user->id,
            'score' => $percent,
            'feedback' => json_encode([
                'answers' => $answers,
                'objective_score' => $score,
                'objective_total' => $total,
                'manual_pending_count' => count($manualPending),
                'manual_reviews' => $manualPending,
                'status' => count($manualPending) > 0 ? 'pending_review' : 'completed',
            ]),
            'attempt_no' => $attemptNo,
            'is_retake' => $attemptNo > 1,
        ]);
        $passingScore = $assessment->passing_score ?? 75;
        $message = count($manualPending) > 0
            ? 'Submitted. Objective score: '.$percent.'%. Manual-checking answers are pending review.'
            : ($percent >= $passingScore
                ? 'Submitted. Your score: '.$percent.'%'
                : 'Submitted. Your score: '.$percent.'%.');
        return redirect()->route('trainee.assessments.take', $assessment)
            ->with('success', $message);
    }
}
