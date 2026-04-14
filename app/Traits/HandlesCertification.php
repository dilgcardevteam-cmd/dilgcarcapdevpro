<?php

namespace App\Traits;

use App\Models\User;
use App\Models\Course;
use App\Models\Certification;
use App\Models\ReflectionResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Dompdf\Dompdf;
use Dompdf\Options;

trait HandlesCertification
{
    /**
     * Issue a certificate if the trainee has completed 100% of the course (both modules and exams).
     */
    public function issueCertificateIfCompleted(User $user, Course $course): bool
    {
        // 1. Calculate overall progress using Course model helper
        $progress = $course->getCourseProgress($user);
        Log::info('Checking certificate eligibility.', [
            'course_id' => $course->id,
            'user_id' => $user->id,
            'progress_percentage' => $progress['percentage'] ?? null,
            'progress_total' => $progress['total'] ?? null,
        ]);
        
        if ($progress['total'] === 0) return false;

        // 2. Check if progress is 100%
        if ($progress['percentage'] < 100) return false;

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
        Log::info('Certificate issued.', [
            'course_id' => $course->id,
            'user_id' => $user->id,
            'certification_id' => $certId,
            'certificate_number' => $certNumber,
        ]);

        // 6. Generate and store PDF
        try {
            $bgUri = $this->getCertificateBgFileUri($cert);
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
                Log::info('Certificate PDF stored.', [
                    'course_id' => $course->id,
                    'user_id' => $user->id,
                    'certification_id' => $certId,
                    'path' => $path,
                ]);
            } else {
                Log::warning('Certificate background not found. Falling back to on-demand generation only.', [
                    'course_id' => $course->id,
                    'user_id' => $user->id,
                    'certification_id' => $certId,
                ]);
            }
        } catch (\Throwable $e) {
            Log::error('Auto certification PDF generation failed.', [
                'course_id' => $course->id,
                'user_id' => $user->id,
                'certification_id' => $certId,
                'error' => $e->getMessage(),
            ]);
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

    protected function getCertificateBgFileUri(?Certification $certification = null): ?string
    {
        $templatePath = trim((string) ($certification?->file_path ?? ''));
        if ($templatePath !== '') {
            $storagePath = Storage::disk('public')->path($templatePath);
            $extension = strtolower(pathinfo($storagePath, PATHINFO_EXTENSION));
            if (is_file($storagePath) && in_array($extension, ['jpg', 'jpeg', 'png', 'webp'], true)) {
                return 'file://' . str_replace('\\', '/', $storagePath);
            }
        }

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
