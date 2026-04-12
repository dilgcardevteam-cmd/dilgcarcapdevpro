<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Course;
use App\Models\Material;
use App\Models\Assessment;
use App\Models\Grade;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TrainerController extends Controller
{
    protected function ensureTrainer()
    {
        if (!auth()->check()) {
            abort(403);
        }
        $role = auth()->user()->role ?? null;
        if ($role !== 'trainer' && $role !== 'coach') {
            abort(403);
        }
    }
    public function uploadMaterial(Request $request)
    {
        $this->ensureTrainer();
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|max:10240', // 10MB max
        ]);

        $path = $request->file('file')->store('materials', 'public');

        Material::create([
            'course_id' => $request->course_id,
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $path,
        ]);

        return redirect()->route('trainer.courses.enter', ['course' => $request->course_id, 'tab' => 'Classwork'])
            ->with('success', 'Material uploaded successfully.');
    }
    public function updateMaterial(Request $request, Material $material)
    {
        $this->ensureTrainer();
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|max:10240',
        ]);
        $data = [
            'title' => $request->title,
            'description' => $request->description,
        ];
        if ($request->hasFile('file')) {
            if ($material->file_path) {
                Storage::disk('public')->delete($material->file_path);
            }
            $data['file_path'] = $request->file('file')->store('materials', 'public');
        }
        $material->update($data);
        return redirect()->route('trainer.courses.enter', ['course' => $material->course_id, 'tab' => 'Classwork'])
            ->with('success', 'Material updated.');
    }
    public function destroyMaterial(Material $material)
    {
        $this->ensureTrainer();
        $courseId = $material->course_id;
        if ($material->file_path) {
            Storage::disk('public')->delete($material->file_path);
        }
        $material->delete();
        return redirect()->route('trainer.courses.enter', ['course' => $courseId, 'tab' => 'Classwork'])
            ->with('success', 'Material deleted.');
    }
    public function editMaterial(Material $material)
    {
        $this->ensureTrainer();
        $course = $material->course;
        return view('trainer.material-edit', compact('material','course'));
    }
    public function showMaterial(Material $material)
    {
        $course = $material->course;
        return view('materials.show', ['material'=>$material,'course'=>$course]);
    }

    public function createAssessment(Request $request)
    {
        $this->ensureTrainer();
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'type' => 'required|in:seatwork,quiz,exam',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'questions_json' => 'required|string',
            'passing_score' => 'nullable|integer|min:1|max:100',
        ]);

        // Guard against empty question sets
        $qs = json_decode($request->questions_json ?? '[]', true) ?: [];
        if (empty($qs)) {
            return back()->withInput()->with('error', 'Please add at least one question before creating the assessment.');
        }

        $assessment = Assessment::create([
            'course_id' => $request->course_id,
            'title' => $request->title,
            'type' => $request->type,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'questions_json' => $request->questions_json,
            'passing_score' => $request->filled('passing_score') ? (int) $request->passing_score : null,
        ]);
        $this->backupAssessment($assessment);

        return redirect()->route('trainer.courses.enter', ['course' => $request->course_id, 'tab' => 'Classwork'])
            ->with('success', 'Assessment created successfully.');
    }
    public function updateAssessment(Request $request, Assessment $assessment)
    {
        $this->ensureTrainer();
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'nullable|in:seatwork,quiz,exam',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'questions_json' => 'nullable|string',
            'passing_score' => 'nullable|integer|min:1|max:100',
        ]);
        $update = [
            'title' => $request->title,
            'type' => $request->type ?? $assessment->type,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'passing_score' => $request->filled('passing_score') ? (int) $request->passing_score : null,
        ];
        if($request->filled('questions_json')){
            $update['questions_json'] = $request->questions_json;
        }
        $assessment->update($update);
        $this->backupAssessment($assessment);
        if($request->wantsJson()){
            return response()->json(['ok'=>true,'id'=>$assessment->id]);
        }
        if($request->input('return_to') === 'show'){
            return redirect()->route('trainer.assessments.show', $assessment)->with('success', 'Assessment updated.');
        }
        return redirect()->route('trainer.courses.enter', ['course' => $assessment->course_id, 'tab' => 'Classwork'])->with('success', 'Assessment updated.');
    }
    public function destroyAssessment(Assessment $assessment)
    {
        $this->ensureTrainer();
        $courseId = $assessment->course_id;
        $assessment->delete();
        return redirect()->route('trainer.courses.enter', ['course' => $courseId, 'tab' => 'Classwork'])
            ->with('success', 'Assessment deleted.');
    }
    public function downloadAssessment(Assessment $assessment)
    {
        $this->ensureTrainer();
        $data = [
            'title' => $assessment->title,
            'type' => $assessment->type,
            'description' => $assessment->description,
            'due_date' => $assessment->due_date,
            'questions' => is_array($assessment->questions_json)
                ? $assessment->questions_json
                : (json_decode($assessment->questions_json, true) ?: []),
        ];
        $filename = Str::slug($assessment->title ?: 'assessment', '_').'.json';
        return response()->streamDownload(function() use ($data) {
            echo json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        }, $filename, ['Content-Type'=>'application/json']);
    }
    public function editAssessment(Assessment $assessment)
    {
        $this->ensureTrainer();
        $assessment->loadMissing('course');
        $course = $assessment->course;
        return view('trainer.assessment-edit', compact('assessment','course'));
    }
    public function editAssessmentForCourse(Course $course, Assessment $assessment)
    {
        $this->ensureTrainer();
        $assessment->loadMissing('course');
        return view('trainer.assessment-edit', [
            'assessment' => $assessment,
            'course' => $course,
        ]);
    }
    public function showAssessment(Assessment $assessment)
    {
        $this->ensureTrainer();
        $course = $assessment->course;
        $questions = is_array($assessment->questions_json)
            ? $assessment->questions_json
            : (json_decode($assessment->questions_json, true) ?: []);
        $responses = $assessment->grades()->with('user')->orderBy('updated_at','desc')->get();
        return view('trainer.assessment-show', [
            'assessment' => $assessment,
            'course' => $course,
            'questions' => $questions,
            'responses' => $responses,
        ]);
    }
    protected function backupAssessment(Assessment $assessment): void
    {
        try{
            $dir = 'assessment_backups';
            $payload = [
                'id' => $assessment->id,
                'title' => $assessment->title,
                'type' => $assessment->type,
                'description' => $assessment->description,
                'due_date' => $assessment->due_date,
                'questions_json' => is_array($assessment->questions_json) ? $assessment->questions_json : (json_decode($assessment->questions_json, true) ?: []),
                'ts' => now()->toDateTimeString(),
            ];
            $name = $dir.'/assessment_'.$assessment->id.'_'.now()->format('Ymd_His').'.json';
            Storage::disk('local')->put($name, json_encode($payload, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
            Storage::disk('local')->put($dir.'/assessment_'.$assessment->id.'_latest.json', json_encode($payload, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
        }catch(\Throwable $e){
            Log::warning('backupAssessment failed', ['assessment_id'=>$assessment->id,'message'=>$e->getMessage()]);
        }
    }
    public function restoreAssessment(Request $request, Assessment $assessment)
    {
        $this->ensureTrainer();
        $source = $request->input('source','backup');
        $restored = false; $from = null;
        try{
            if($source==='backup'){
                $path = 'assessment_backups/assessment_'.$assessment->id.'_latest.json';
                if(Storage::disk('local')->exists($path)){
                    $json = json_decode(Storage::disk('local')->get($path), true) ?: [];
                    if(!empty($json['questions_json'])){
                        $assessment->update(['questions_json' => json_encode($json['questions_json'])]);
                        $restored = true; $from = 'backup';
                    }
                }
            }
            if(!$restored){
                $tplId = $request->input('template_id');
                $tpl = null;
                if($tplId){
                    $tpl = \App\Models\AssessmentTemplate::find($tplId);
                }else{
                    $tpl = \App\Models\AssessmentTemplate::where('user_id', auth()->id())
                        ->where('title', $assessment->title)
                        ->where('type', $assessment->type)
                        ->orderBy('updated_at','desc')->first();
                }
                if($tpl){
                    $qs = is_array($tpl->questions_json) ? $tpl->questions_json : (json_decode($tpl->questions_json,true) ?: []);
                    if(!empty($qs)){
                        $assessment->update(['questions_json' => json_encode($qs)]);
                        $restored = true; $from = 'test bank';
                    }
                }
            }
        }catch(\Throwable $e){
            Log::error('restoreAssessment failed', ['assessment_id'=>$assessment->id,'message'=>$e->getMessage()]);
        }
        if($restored){
            $this->backupAssessment($assessment);
            return redirect()->route('trainer.assessments.edit', $assessment)->with('success', 'Questions restored from '.$from.'.');
        }
        return redirect()->route('trainer.assessments.edit', $assessment)->with('error', 'No questions found to restore.');
    }
    public function recoverMissingAssessments()
    {
        $this->ensureTrainer();
        $assessments = Assessment::whereNull('questions_json')->orWhere('questions_json','[]')->get();
        $fixed=0;
        foreach($assessments as $a){
            try{
                $qs=[];
                $path = 'assessment_backups/assessment_'.$a->id.'_latest.json';
                if(Storage::disk('local')->exists($path)){
                    $json = json_decode(Storage::disk('local')->get($path), true) ?: [];
                    $qs = $json['questions_json'] ?? [];
                }
                if(empty($qs)){
                    $tpl = \App\Models\AssessmentTemplate::where('user_id', auth()->id())
                        ->where('title', $a->title)->where('type', $a->type)->orderBy('updated_at','desc')->first();
                    if($tpl){
                        $qs = is_array($tpl->questions_json) ? $tpl->questions_json : (json_decode($tpl->questions_json,true) ?: []);
                    }
                }
                if(!empty($qs)){
                    $a->update(['questions_json'=>json_encode($qs)]);
                    $this->backupAssessment($a);
                    $fixed++;
                }
            }catch(\Throwable $e){
                Log::warning('recoverMissing failed', ['assessment_id'=>$a->id,'message'=>$e->getMessage()]);
            }
        }
        return redirect()->back()->with('success', 'Recovered questions for '.$fixed.' assessments.');
    }

    public function listTestBanks(Request $request)
    {
        $items = \App\Models\AssessmentTemplate::where('user_id', auth()->id())
            ->orderBy('updated_at', 'desc')
            ->get(['id','title','type','description','questions_json','updated_at']);
        return response()->json(['ok'=>true,'items'=>$items]);
    }

    public function storeTestBank(Request $request)
    {
        try {
            $data = $request->validate([
                'title' => 'required|string|max:255',
                'type' => 'required|in:seatwork,quiz,exam',
                'description' => 'nullable|string',
                'questions_json' => 'required|string',
            ]);
            $tpl = \App\Models\AssessmentTemplate::updateOrCreate(
                ['user_id'=>auth()->id(),'title'=>$data['title'],'type'=>$data['type']],
                [
                    'description' => $data['description'] ?? null,
                    'questions_json' => $data['questions_json'],
                ]
            );
            return response()->json(['ok'=>true,'template'=>$tpl]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['ok'=>false,'errors'=>$e->errors()], 422);
        } catch (\Throwable $e) {
            Log::error('storeTestBank failed', [
                'user_id' => auth()->id(),
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['ok'=>false,'message'=>'Internal error'], 500);
        }
    }

    public function destroyTestBank(\App\Models\AssessmentTemplate $template)
    {
        try{
            if($template->user_id !== auth()->id()){
                return response()->json(['ok'=>false,'message'=>'Forbidden'], 403);
            }
            $template->delete();
            return response()->json(['ok'=>true]);
        }catch(\Throwable $e){
            Log::error('destroyTestBank failed', [
                'user_id' => auth()->id(),
                'template_id' => $template->id ?? null,
                'message' => $e->getMessage(),
            ]);
            return response()->json(['ok'=>false,'message'=>'Internal error'], 500);
        }
    }


    public function updateGrade(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'assessment_id' => 'required|exists:assessments,id',
            'score' => 'required|numeric|min:0',
        ]);

        Grade::updateOrCreate(
            [
                'user_id' => $request->student_id,
                'assessment_id' => $request->assessment_id,
            ],
            [
                'score' => $request->score,
            ]
        );

        return response()->json(['success' => true]);
    }
    
}
