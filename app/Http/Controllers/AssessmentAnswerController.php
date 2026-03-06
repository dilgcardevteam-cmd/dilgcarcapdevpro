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
        $answers = $request->input('answers', []);
        $questions = is_array($assessment->questions_json)
            ? $assessment->questions_json
            : (json_decode($assessment->questions_json, true) ?: []);
        $score = 0;
        $total = 0;
        foreach($questions as $idx => $q){
            $total++;
            $ans = $answers[$idx] ?? null;
            if($q['type'] === 'multiple_choice'){
                if(isset($q['answer_index']) && (string)$ans === (string)$q['answer_index']) $score++;
            }elseif($q['type'] === 'identification'){
                if(is_string($ans) && is_string($q['answer'] ?? null) && mb_strtolower(trim($ans)) === mb_strtolower(trim($q['answer']))) $score++;
            }elseif($q['type'] === 'true_false'){
                $truth = !empty($q['answer']);
                if(($ans === '1') || ($ans === 'true') || ($ans === 1) || ($ans === true)){ $ansBool = true; }
                else { $ansBool = false; }
                if($truth === $ansBool) $score++;
            }else{
                // essay: no auto score
            }
        }
        $percent = $total > 0 ? round(($score / $total) * 100, 2) : 0;
        Grade::updateOrCreate(
            ['assessment_id' => $assessment->id, 'user_id' => $user->id],
            ['score' => $percent, 'feedback' => json_encode(['answers'=>$answers])]
        );
        return redirect()->route('trainee.assessments.take', $assessment)
            ->with('success', 'Submitted. Your score: '.$percent.'%');
    }
}
