<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certification;
use App\Models\User;
use App\Models\Course;
use App\Models\ReflectionResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Dompdf\Dompdf;
use Dompdf\Options;

class CertificationController extends Controller
{
    protected function certificateBgPath(): ?string
    {
        $candidates = [
            public_path('images/capdevcert.png'),
            public_path('images/capdevcert.jpg'),
            public_path('images/capdev cert.png'),
            public_path('images/capdev cert.jpg'),
        ];
        foreach ($candidates as $p) {
            if (file_exists($p)) return $p;
        }
        return null;
    }
    protected function certificateBgUrl(): ?string
    {
        $pairs = [
            'images/capdevcert.png',
            'images/capdevcert.jpg',
            'images/capdev cert.png',
            'images/capdev cert.jpg',
        ];
        foreach ($pairs as $rel) {
            $path = public_path($rel);
            if (file_exists($path)) {
                return asset($rel);
            }
        }
        return null;
    }
    protected function certificateBgFileUri(): ?string
    {
        $pairs = [
            public_path('images/capdevcert.png'),
            public_path('images/capdevcert.jpg'),
            public_path('images/capdev cert.png'),
            public_path('images/capdev cert.jpg'),
        ];
        foreach ($pairs as $path) {
            if (file_exists($path)) {
                return 'file://' . str_replace('\\','/',$path);
            }
        }
        return null;
    }
    protected function certificateStoragePath(int $courseId, int $certId, string $certificateNumber): string
    {
        $safe = preg_replace('/[^A-Za-z0-9_\-]/', '_', $certificateNumber);
        return "certificates/course_{$courseId}/cert_{$certId}/{$safe}.pdf";
    }

    protected function buildCertificateHtml(array $items, string $bgPath): string
    {
        return view('admin.certificates.pdf', ['items'=>$items, 'bgPath'=>$bgPath])->render();
    }

    protected function renderPdfFromHtml(string $html): string
    {
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'DejaVu Sans');
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        return $dompdf->output();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|in:Core Governance & Administration,Finance & Compliance,Digital Transformation,ICT & Technical Skills,Human Capital & Leadership,Community & Development Planning,Economic & Business Development,Social Governance',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,docx|max:10240',
        ]);

        // Determine template path: uploaded file or standard certificate background
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('certifications', 'public');
        } else {
            $bg = $this->certificateBgPath();
            if (!$bg) {
                return redirect()->back()->with('error_certification', 'Certificate template is required. Upload a file or ensure the standard template image exists.')->withInput();
            }
            // Copy the standard background into public storage so listing links work
            $ext = pathinfo($bg, PATHINFO_EXTENSION) ?: 'png';
            $dest = 'certifications/standard_' . uniqid() . '.' . $ext;
            \Illuminate\Support\Facades\Storage::disk('public')->put($dest, file_get_contents($bg));
            $path = $dest;
        }

        Certification::create([
            'name' => $validated['name'],
            'category' => $validated['category'],
            'file_path' => $path,
            'display_on_landing_page' => false,
        ]);

        return redirect()->back()->with('success_certification', 'Certification created successfully.');
    }

    public function downloadTemplate(Request $request, Certification $certification)
    {
        $path = $certification->file_path;
        if (!Storage::disk('public')->exists($path)) {
            return back()->with('error_certification', 'Template file not found.');
        }
        $content = Storage::disk('public')->get($path);
        $mime = Storage::disk('public')->mimeType($path) ?: 'application/octet-stream';
        $ext = pathinfo($path, PATHINFO_EXTENSION) ?: 'bin';
        $filename = Str::slug($certification->name ?: 'certificate-template') . '.' . $ext;
        if ($request->query('inline')) {
            return response($content, 200, ['Content-Type' => $mime]);
        }
        return response($content, 200, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }

    public function generateFromTemplate(Request $request)
    {
        $data = $request->validate([
            'template_bg_data' => ['required','string','regex:/^data:(image|application)\\/[A-Za-z0-9.+-]+;base64,.*$/'],
            'recipient_name' => 'required|string|max:255',
            'course_name' => 'required|string|max:255',
            'completion_date' => 'nullable|date',
            'certificate_number' => 'required|string|max:255',
            'pos.name.x' => 'nullable|integer',
            'pos.name.y' => 'nullable|integer',
            'pos.course.x' => 'nullable|integer',
            'pos.course.y' => 'nullable|integer',
            'pos.number.x' => 'nullable|integer',
            'pos.number.y' => 'nullable|integer',
            'pos.date.x' => 'nullable|integer',
            'pos.date.y' => 'nullable|integer',
            'font.name' => 'nullable|integer',
            'font.course' => 'nullable|integer',
            'font.number' => 'nullable|integer',
            'font.date' => 'nullable|integer',
        ]);
        $bgUri = $data['template_bg_data'];
        $items = [[
            'name' => $data['recipient_name'],
            'course' => $data['course_name'],
            'cert_number' => $data['certificate_number'],
            'issued_at' => !empty($data['completion_date']) ? \Carbon\Carbon::parse($data['completion_date'])->toDateString() : null,
        ]];
        $html = view('admin.certificates.pdf', [
            'items' => $items,
            'bgPath' => $bgUri,
            'posName' => ['x' => $data['pos']['name']['x'] ?? null, 'y' => $data['pos']['name']['y'] ?? null],
            'posCourse' => ['x' => $data['pos']['course']['x'] ?? null, 'y' => $data['pos']['course']['y'] ?? null],
            'posNumber' => ['x' => $data['pos']['number']['x'] ?? null, 'y' => $data['pos']['number']['y'] ?? null],
            'posDate' => ['x' => $data['pos']['date']['x'] ?? null, 'y' => $data['pos']['date']['y'] ?? null],
            'fontName' => $data['font']['name'] ?? null,
            'fontCourse' => $data['font']['course'] ?? null,
            'fontNumber' => $data['font']['number'] ?? null,
            'fontDate' => $data['font']['date'] ?? null,
        ])->render();
        $pdf = $this->renderPdfFromHtml($html);
        if (!Schema::hasTable('certificate_generation_audits')) {
            Schema::create('certificate_generation_audits', function ($table) {
                $table->id();
                $table->string('template_source', 256)->nullable();
                $table->string('recipient_name');
                $table->string('course_name');
                $table->string('certificate_number');
                $table->date('issued_at')->nullable();
                $table->unsignedBigInteger('generated_by')->nullable();
                $table->timestamps();
            });
        }
        \App\Models\CertificateGenerationAudit::create([
            'template_source' => substr($bgUri, 0, 64).'…',
            'recipient_name' => $data['recipient_name'],
            'course_name' => $data['course_name'],
            'certificate_number' => $data['certificate_number'],
            'issued_at' => !empty($data['completion_date']) ? \Carbon\Carbon::parse($data['completion_date'])->toDateString() : null,
            'generated_by' => auth()->id(),
        ]);
        return response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="certificate_preview.pdf"',
        ]);
    }

    public function coursePage(Course $course)
    {
        $certifications = Certification::all();
        // Align roles with system-wide definitions (coaches and participant variants)
        $coachRoles = ['coach','trainer','central_office_coach','regional_office_coach','provincial_office_coach'];
        $participantRoles = ['participant','trainee','central_office_participants','regional_office_participants','provincial_office_participants'];
        $trainers = $course->users()->whereIn('role', $coachRoles)->get();
        $trainees = $course->users()
            ->whereIn('role', $participantRoles)
            ->wherePivot('status','active')
            ->get();
        // compute total subtopics
        $mods = is_array($course->modules) ? $course->modules : [];
        $overallTotal = 0;
        foreach ($mods as $m) {
            $topics = isset($m['topics']) && is_array($m['topics']) ? $m['topics'] : [];
            foreach ($topics as $t) {
                $subs = isset($t['subtopics']) && is_array($t['subtopics']) ? $t['subtopics'] : [];
                $overallTotal += count($subs);
            }
        }
        $progress = [];
        foreach ($trainees as $u) {
            $rows = ReflectionResponse::where('user_id', $u->id)
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
            $done = count($doneSet);
            $percent = $overallTotal ? round(($done/$overallTotal)*100) : 0;
            $progress[$u->id] = $percent;
        }
        return view('admin.certify-course', compact('course','trainers','trainees','certifications','progress'));
    }

    public function bulkCertify(Request $request, Course $course)
    {
        $data = $request->validate([
            'certification_id' => 'nullable|exists:certifications,id',
            'user_ids' => 'required|array',
            'user_ids.*' => 'integer|exists:users,id',
            'only_completed' => 'nullable|boolean',
        ]);
        $cert = !empty($data['certification_id'])
            ? Certification::findOrFail($data['certification_id'])
            : Certification::query()->orderBy('id')->first();
        if (!$cert) {
            return back()->with('error_certification', 'No certification available to assign.');
        }
        $ids = collect($data['user_ids'])->unique()->values();
        if ($ids->isEmpty()) {
            return back()->with('error_certification', 'No users selected.');
        }
        $participantRoles = ['participant','trainee','central_office_participants','regional_office_participants','provincial_office_participants'];
        $enrolled = $course->users()
            ->whereIn('role', $participantRoles)
            ->wherePivot('status','active')
            ->whereIn('users.id', $ids)
            ->get(['users.id']);
        $mods = is_array($course->modules) ? $course->modules : [];
        $overallTotal = 0;
        foreach ($mods as $m) {
            $topics = isset($m['topics']) && is_array($m['topics']) ? $m['topics'] : [];
            foreach ($topics as $t) {
                $subs = isset($t['subtopics']) && is_array($t['subtopics']) ? $t['subtopics'] : [];
                $overallTotal += count($subs);
            }
        }
        $attached = 0;
        foreach ($enrolled as $u) {
            $userModel = User::find($u->id);
            if (!$userModel) continue;

            if ($request->boolean('only_completed')) {
                $progress = $course->getCourseProgress($userModel);
                if ($progress['percentage'] < 100) {
                    continue;
                }
            }
            
            if (!$userModel->certifications()->where('certification_id', $cert->id)->wherePivot('course_id',$course->id)->exists()) {
                $user->certifications()->attach($cert->id, [
                    'course_id' => $course->id,
                    'certificate_number' => $this->generateCertificateNumber(),
                    'issued_at' => now(),
                ]);
                $attached++;
                // Generate and store the PDF immediately
                try {
                    $pivot = DB::table('certification_user')
                        ->where('user_id',$user->id)
                        ->where('course_id',$course->id)
                        ->where('certification_id',$cert->id)
                        ->first();
                    if ($pivot) {
                        $bgUri = $this->certificateBgFileUri();
                        if ($bgUri) {
                            $items = [[
                                'name' => $user->name,
                                'course' => $course->name,
                                'cert_number' => $pivot->certificate_number,
                                'issued_at' => $pivot->issued_at ? \Carbon\Carbon::parse($pivot->issued_at)->toDateString() : null,
                            ]];
                            $html = $this->buildCertificateHtml($items, $bgUri);
                            $pdf = $this->renderPdfFromHtml($html);
                            $path = $this->certificateStoragePath($course->id, $cert->id, $pivot->certificate_number);
                            Storage::disk('public')->put($path, $pdf);
                        }
                    }
                } catch (\Throwable $e) {
                    // swallow errors to avoid blocking certification; optionally log
                }
            }
        }
        return redirect()->route('admin.certifications.course', $course)
            ->with('success_certification', "Certified {$attached} user(s).");
    }

    protected function generateCertificateNumber(): string
    {
        $maxSeq = \Illuminate\Support\Facades\DB::table('certification_user')
            ->selectRaw("MAX(CAST(REPLACE(certificate_number, 'Cert ', '') AS UNSIGNED)) as max_num")
            ->whereNotNull('certificate_number')
            ->where('certificate_number', 'like', 'Cert %')
            ->value('max_num');
        $next = (int) ($maxSeq ?? 0) + 1;
        return 'Cert ' . str_pad((string)$next, 4, '0', STR_PAD_LEFT);
    }

    public function statusForCourse(Request $request, Course $course)
    {
        $certId = (int) $request->query('certification_id');
        $participantRoles = ['participant','trainee','central_office_participants','regional_office_participants','provincial_office_participants'];
        $trainees = $course->users()
            ->whereIn('role', $participantRoles)
            ->wherePivot('status','active')
            ->get(['users.id','users.name','users.email','users.account_id']);
        $q = \Illuminate\Support\Facades\DB::table('certification_user')
            ->where('course_id',$course->id);
        if ($certId) {
            $q->where('certification_id',$certId);
        }
        $certifiedRows = $q->orderByDesc('issued_at')->get(['user_id','certification_id','certificate_number','issued_at']);
        $certified = [];
        foreach ($certifiedRows as $row) {
            if (isset($certified[$row->user_id])) {
                continue;
            }
            $certified[$row->user_id] = [
                'certification_id' => $row->certification_id,
                'certificate_number' => $row->certificate_number,
                'issued_at' => $row->issued_at ? \Carbon\Carbon::parse($row->issued_at)->toDateString() : null,
            ];
        }
        $mods = is_array($course->modules) ? $course->modules : [];
        $overallTotal = 0;
        foreach ($mods as $m) {
            $topics = isset($m['topics']) && is_array($m['topics']) ? $m['topics'] : [];
            foreach ($topics as $t) {
                $subs = isset($t['subtopics']) && is_array($t['subtopics']) ? $t['subtopics'] : [];
                $overallTotal += count($subs);
            }
        }
        $notCert = [];
        $haveCert = [];
        foreach ($trainees as $t) {
            $progress = $course->getCourseProgress($t);
            $pct = $progress['percentage'];
            $row = ['id'=>$t->id,'name'=>$t->name,'email'=>$t->email,'account_id'=>$t->account_id,'percent'=>$pct];
            if (array_key_exists($t->id, $certified)) {
                $row['certification_id'] = $certified[$t->id]['certification_id'] ?? null;
                $row['certificate_number'] = $certified[$t->id]['certificate_number'] ?? null;
                $row['issued_at'] = $certified[$t->id]['issued_at'] ?? null;
                $haveCert[] = $row;
            } else {
                $notCert[] = $row;
            }
        }
        return response()->json(['not_certified'=>$notCert,'certified'=>$haveCert]);
    }

    public function updateCertificate(Request $request, Course $course, User $user)
    {
        $data = $request->validate([
            'certification_id' => 'required|exists:certifications,id',
            'certificate_number' => 'nullable|string|max:20',
            'issued_at' => 'nullable|date',
        ]);
        $exists = DB::table('certification_user')
            ->where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->where('certification_id', $data['certification_id'])
            ->exists();
        if (!$exists) {
            return response()->json(['message' => 'Certification record not found.'], 404);
        }
        if (!empty($data['certificate_number'])) {
            $dupe = DB::table('certification_user')
                ->where('certificate_number', $data['certificate_number'])
                ->where(function($q) use ($user, $course, $data){
                    $q->where('user_id', '!=', $user->id)
                      ->orWhere('course_id', '!=', $course->id)
                      ->orWhere('certification_id', '!=', $data['certification_id']);
                })
                ->exists();
            if ($dupe) {
                return response()->json(['message'=>'Certificate number already in use.'], 422);
            }
        }
        DB::table('certification_user')
            ->where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->where('certification_id', $data['certification_id'])
            ->update([
                'certificate_number' => $data['certificate_number'],
                'issued_at' => $data['issued_at'],
                'updated_at' => now(),
            ]);
        return response()->json(['ok' => true]);
    }

    public function deleteCertificate(Request $request, Course $course, User $user)
    {
        $data = $request->validate([
            'certification_id' => 'required|exists:certifications,id',
        ]);
        DB::table('certification_user')
            ->where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->where('certification_id', $data['certification_id'])
            ->delete();
        return response()->json(['ok'=>true]);
    }

    public function previewCertificate(Course $course, Certification $certification, User $user)
    {
        $pivot = DB::table('certification_user')
            ->where('user_id',$user->id)
            ->where('course_id',$course->id)
            ->where('certification_id',$certification->id)
            ->first();
        if (!$pivot) {
            abort(404);
        }
        $bgUri = $this->certificateBgFileUri();
        if (!$bgUri) {
            abort(404);
        }
        return view('admin.certificates.preview', [
            'name' => $user->name,
            'course' => $course->name,
            'cert_number' => $pivot->certificate_number,
            'issued_at' => $pivot->issued_at ? \Carbon\Carbon::parse($pivot->issued_at)->toDateString() : null,
            'bgUrl' => $bgUri,
        ]);
    }

    public function downloadCertificate(Course $course, Certification $certification, User $user)
    {
        $pivot = DB::table('certification_user')
            ->where('user_id',$user->id)
            ->where('course_id',$course->id)
            ->where('certification_id',$certification->id)
            ->first();
        if (!$pivot) {
            return back()->with('error_certification', 'Certification record not found.');
        }
        // Serve stored PDF if present; otherwise generate on the fly
        $stored = $this->certificateStoragePath($course->id, $certification->id, $pivot->certificate_number);
        if (Storage::disk('public')->exists($stored)) {
            $content = Storage::disk('public')->get($stored);
            return response($content, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="certificate_'.$user->id.'.pdf"',
            ]);
        }
        $bgUri = $this->certificateBgFileUri();
        if (!$bgUri) {
            return back()->with('error_certification', 'Certificate template image is missing.');
        }
        $items = [[
            'name' => $user->name,
            'course' => $course->name,
            'cert_number' => $pivot->certificate_number,
            'issued_at' => $pivot->issued_at ? \Carbon\Carbon::parse($pivot->issued_at)->toDateString() : null,
        ]];
        $html = $this->buildCertificateHtml($items, $bgUri);
        $pdf = $this->renderPdfFromHtml($html);
        return response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="certificate_'.$user->id.'.pdf"',
        ]);
    }

    public function downloadCertificatesBatch(Request $request, Course $course)
    {
        $data = $request->validate([
            'certification_id' => 'required|exists:certifications,id',
            'user_ids' => 'nullable|array',
            'user_ids.*' => 'integer|exists:users,id',
        ]);
        $bgUri = $this->certificateBgFileUri();
        if (!$bgUri) {
            return back()->with('error_certification', 'Certificate template image is missing.');
        }
        $q = DB::table('certification_user')
            ->join('users','users.id','=','certification_user.user_id')
            ->where('certification_user.course_id',$course->id)
            ->where('certification_user.certification_id',$data['certification_id'])
            ->select('users.id as uid','users.name as uname','certification_user.certificate_number','certification_user.issued_at');
        if (!empty($data['user_ids'])) {
            $q->whereIn('users.id', $data['user_ids']);
        }
        $rows = $q->get();
        if ($rows->isEmpty()) {
            return back()->with('error_certification', 'No certified users found.');
        }
        $items = [];
        foreach ($rows as $r) {
            $items[] = [
                'name' => $r->uname,
                'course' => $course->name,
                'cert_number' => $r->certificate_number,
                'issued_at' => $r->issued_at ? \Carbon\Carbon::parse($r->issued_at)->toDateString() : null,
            ];
        }
        $html = view('admin.certificates.pdf', ['items'=>$items, 'bgPath'=>$bgUri])->render();
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'DejaVu Sans');
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $fname = 'certificates_course_'.$course->id.'_cert_'.$data['certification_id'].'.pdf';
        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="'.$fname.'"',
        ]);
    }
    public function toggleDisplay(Certification $certification)
    {
        $certification->display_on_landing_page = !$certification->display_on_landing_page;
        $certification->save();

        $status = $certification->display_on_landing_page ? 'displayed' : 'hidden';
        return redirect()->back()->with('success_certification', "Certification is now $status on landing page.");
    }

    public function destroy(Certification $certification)
    {
        if (Storage::disk('public')->exists($certification->file_path)) {
            Storage::disk('public')->delete($certification->file_path);
        }
        
        $certification->delete();

        return redirect()->back()->with('success_certification', 'Certification deleted successfully.');
    }

    public function certifyUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'certification_id' => 'required|exists:certifications,id',
        ]);

        $user = User::findOrFail($request->user_id);
        $certification = Certification::findOrFail($request->certification_id);

        // Check if already certified
        if ($user->certifications()->where('certification_id', $certification->id)->exists()) {
            return redirect()->back()->with('error_certification', 'User is already certified with this certification.');
        }

        $user->certifications()->attach($certification->id);

        return redirect()->back()->with('success_certification', "User {$user->name} has been certified.");
    }
}
