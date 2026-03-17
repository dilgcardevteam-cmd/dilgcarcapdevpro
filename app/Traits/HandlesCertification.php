<?php

namespace App\Traits;

use App\Models\User;
use App\Models\Course;
use App\Models\Certification;
use App\Models\ReflectionResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Dompdf\Dompdf;
use Dompdf\Options;

trait HandlesCertification
{
    /**
     * Issue a certificate if the trainee has completed 100% of the course.
     */
    public function issueCertificateIfCompleted(User $user, Course $course): bool
    {
        // 1. Calculate overall progress
        $mods = is_array($course->modules) ? $course->modules : [];
        $overallTotal = 0;
        foreach ($mods as $m) {
            $topics = isset($m['topics']) && is_array($m['topics']) ? $m['topics'] : [];
            foreach ($topics as $t) {
                $subs = isset($t['subtopics']) && is_array($t['subtopics']) ? $t['subtopics'] : [];
                $overallTotal += count($subs);
            }
        }

        if ($overallTotal === 0) return false;

        $rows = ReflectionResponse::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->get(['module_index', 'topic_index', 'sub_index', 'answers_json']);
        
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

        $percent = round((count($doneSet) / $overallTotal) * 100);

        // 2. Check if progress is 100%
        if ($percent < 100) return false;

        // 3. Find the certification associated with this course
        $certId = $course->certification_id;
        if (!$certId) {
            // Fallback to first available certification if course doesn't have one linked
            $cert = Certification::orderBy('id')->first();
            if (!$cert) return false;
            $certId = $cert->id;
        } else {
            $cert = Certification::find($certId);
        }

        if (!$cert) return false;

        // 4. Check if already certified for this course
        $alreadyCertified = $user->certifications()
            ->where('certification_id', $certId)
            ->wherePivot('course_id', $course->id)
            ->exists();

        if ($alreadyCertified) return false;

        // 5. Issue the certificate
        $certNumber = $this->generateUniqueCertificateNumber();
        $user->certifications()->attach($certId, [
            'course_id' => $course->id,
            'certificate_number' => $certNumber,
            'issued_at' => now(),
        ]);

        // 6. Generate and store PDF
        try {
            $bgUri = $this->getCertificateBgFileUri();
            if ($bgUri) {
                $items = [[
                    'name' => $user->name,
                    'course' => $course->name,
                    'cert_number' => $certNumber,
                    'issued_at' => now()->toDateString(),
                ]];
                
                $html = view('admin.certificates.pdf', [
                    'items' => $items,
                    'bgPath' => $bgUri,
                ])->render();

                $pdf = $this->renderPdfFromHtml($html);
                $path = "certificates/course_{$course->id}/cert_{$certId}/" . preg_replace('/[^A-Za-z0-9_\-]/', '_', $certNumber) . ".pdf";
                Storage::disk('public')->put($path, $pdf);
            }
        } catch (\Throwable $e) {
            \Log::error("Auto certification PDF generation failed: " . $e->getMessage());
        }
        
        return true; // Indicate that a certificate was newly issued
    }

    protected function generateUniqueCertificateNumber(): string
    {
        $maxSeq = DB::table('certification_user')
            ->selectRaw("MAX(CAST(REPLACE(certificate_number, 'Cert ', '') AS UNSIGNED)) as max_num")
            ->whereNotNull('certificate_number')
            ->where('certificate_number', 'like', 'Cert %')
            ->value('max_num');
        $next = (int) ($maxSeq ?? 0) + 1;
        return 'Cert ' . str_pad((string)$next, 4, '0', STR_PAD_LEFT);
    }

    protected function getCertificateBgFileUri(): ?string
    {
        $pairs = [
            public_path('images/capdevcert.png'),
            public_path('images/capdevcert.jpg'),
            public_path('images/capdev cert.png'),
            public_path('images/capdev cert.jpg'),
        ];
        foreach ($pairs as $path) {
            if (file_exists($path)) {
                return 'file://' . str_replace('\\', '/', $path);
            }
        }
        return null;
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
}
