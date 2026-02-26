<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\SubjectController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\AssessmentAnswerController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\CalendarEventController;
use App\Http\Controllers\CertificationController;
use App\Http\Controllers\ClassAnnouncementController;
use App\Http\Controllers\DiscussionController;

Route::get('/', function () {
    $displayUsers = \App\Models\User::where('display_type', 'our_team')->get();
    $certifications = \App\Models\Certification::where('display_on_landing_page', true)->get();
    $pastTrainees = \App\Models\User::where('display_type', 'past_trainees')->get();
    return view('landing', compact('displayUsers', 'certifications', 'pastTrainees'));
});

// Serve Philippines provinces GeoJSON at a stable local path with fallback and caching
Route::get('/images/maps/ph-provinces.geojson', function () {
    $localPath = public_path('images/maps/ph-provinces.geojson');
    $dir = dirname($localPath);
    if (!is_dir($dir)) {
        @mkdir($dir, 0775, true);
    }
    if (is_file($localPath) && filesize($localPath) > 0) {
        return response()->file($localPath, ['Content-Type' => 'application/geo+json; charset=UTF-8']);
    }
    $urls = [
        'https://cdn.jsdelivr.net/gh/justinegealogo/philippines-region-province-citymuni-barangay/geojson/philippines-province.geojson',
        'https://raw.githubusercontent.com/justinegealogo/philippines-region-province-citymuni-barangay/master/geojson/philippines-province.geojson',
    ];
    $content = null;
    $fetch = function($url){
        // Prefer cURL for environments where allow_url_fopen is disabled
        if (function_exists('curl_init')) {
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_TIMEOUT => 20,
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_SSL_VERIFYHOST => 2,
                CURLOPT_USERAGENT => 'CapDevPro-GeoJSON-Fetch/1.0',
            ]);
            $data = curl_exec($ch);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if ($code >= 200 && $code < 300 && $data) return $data;
        }
        // Fallback to file_get_contents if cURL not available
        try { return @file_get_contents($url); } catch (\Throwable $e) { return null; }
    };
    foreach ($urls as $u) {
        $content = $fetch($u);
        if ($content && strlen($content) > 1000) { break; }
    }
    if ($content && strlen($content) > 1000) {
        @file_put_contents($localPath, $content);
        return response($content, 200, ['Content-Type' => 'application/geo+json; charset=UTF-8']);
    }
    return response()->json([
        'error' => 'Map data not found',
        'hint' => 'Place GeoJSON at public/images/maps/ph-provinces.geojson or ensure remote source is reachable.',
    ], 404);
});

Route::get('/subject/{slug}', [SubjectController::class, 'show'])->name('subject.show');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/auth/google/redirect', [AuthController::class, 'redirectToGoogle'])->name('auth.google.redirect');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'handleForgotPassword'])->name('password.email');
    Route::post('/forgot-password/verify', [AuthController::class, 'verifyForgotOtp'])->name('password.otp.verify');
    Route::post('/forgot-password/resend', [AuthController::class, 'resendForgotOtp'])->name('password.otp.resend');
    Route::post('/forgot-password/update', [AuthController::class, 'updatePasswordAfterOtp'])->name('password.update.after.otp');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile/setup', [DashboardController::class, 'setupProfile'])->name('profile.setup');
    Route::post('/profile/setup', [DashboardController::class, 'storeProfileSetup'])->name('profile.setup.store');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', \App\Http\Middleware\EnsureProfileCompleted::class])
    ->name('dashboard');
Route::get('/admin/courses/create', [CourseController::class, 'create'])->middleware(['auth'])->name('admin.courses.create');
Route::get('/admin/courses/{course}/edit', [CourseController::class, 'edit'])->middleware(['auth'])->name('admin.courses.edit');
// Place pending BEFORE the dynamic {course} route to avoid shadowing
Route::get('/admin/courses/pending', [CourseController::class, 'pending'])->middleware(['auth'])->name('admin.courses.pending');
Route::resource('courses', CourseController::class)->only(['store', 'update', 'destroy'])->middleware(['auth']);
Route::get('/admin/courses/{course}', [CourseController::class, 'adminShow'])->middleware(['auth'])->name('admin.courses.show');
// Trainer course creation (submit for admin approval)
Route::get('/trainer/courses/create', [CourseController::class, 'trainerCreate'])->middleware(['auth'])->name('trainer.courses.create');
Route::post('/trainer/courses', [CourseController::class, 'trainerStore'])->middleware(['auth'])->name('trainer.courses.store');
Route::post('/courses/{id}/restore', [CourseController::class, 'restore'])->middleware(['auth'])->name('courses.restore');
Route::delete('/courses/{id}/force', [CourseController::class, 'forceDelete'])->middleware(['auth'])->name('courses.force-delete');
// Registrar participants management
Route::get('/registrar/courses/{course}/participants', [CourseController::class, 'participants'])->middleware(['auth'])->name('registrar.courses.participants');
Route::get('/trainee/courses/{course}', [CourseController::class, 'traineeShow'])->middleware(['auth'])->name('trainee.courses.show');
Route::get('/trainee/courses/{course}/outline', [CourseController::class, 'traineeOutline'])->middleware(['auth'])->name('trainee.courses.outline');
// Trainer: enter class (landing replicates trainee view with trainer capabilities)
Route::get('/trainer/courses/{course}', [CourseController::class, 'trainerLanding'])->middleware(['auth'])->name('trainer.courses.enter');
// Trainer view-only course outline page
Route::get('/trainer/courses/{course}/view', [CourseController::class, 'trainerView'])->middleware(['auth'])->name('trainer.courses.view');
// Trainer create classwork page
Route::get('/trainer/courses/{course}/classwork/create', [CourseController::class, 'trainerClassworkCreate'])->middleware(['auth'])->name('trainer.courses.classwork.create');
// Trainer create material/assessment dedicated pages
Route::get('/trainer/courses/{course}/materials/create', [CourseController::class, 'trainerMaterialCreate'])->middleware(['auth'])->name('trainer.courses.materials.create');
Route::get('/trainer/courses/{course}/assessments/create', [CourseController::class, 'trainerAssessmentCreate'])->middleware(['auth'])->name('trainer.courses.assessments.create');
// Test bank endpoints
Route::get('/trainer/test-banks', [TrainerController::class, 'listTestBanks'])->middleware(['auth'])->name('trainer.test-banks.index');
Route::post('/trainer/test-banks', [TrainerController::class, 'storeTestBank'])->middleware(['auth'])->name('trainer.test-banks.store');
Route::delete('/trainer/test-banks/{template}', [TrainerController::class, 'destroyTestBank'])->middleware(['auth'])->name('trainer.test-banks.destroy');

// Trainee assessment answering
Route::middleware('auth')->group(function(){
    Route::get('/trainee/assessments/{assessment}/take', [AssessmentAnswerController::class, 'take'])->name('trainee.assessments.take');
    Route::post('/trainee/assessments/{assessment}/submit', [AssessmentAnswerController::class, 'submit'])->name('trainee.assessments.submit');
});

// Material viewing
Route::get('/materials/{material}', [TrainerController::class, 'showMaterial'])->middleware(['auth'])->name('materials.show');

// Restore and recovery for assessments
Route::post('/trainer/assessments/{assessment}/restore', [TrainerController::class, 'restoreAssessment'])->middleware(['auth'])->name('trainer.assessments.restore');
Route::post('/trainer/assessments/recover-missing', [TrainerController::class, 'recoverMissingAssessments'])->middleware(['auth'])->name('trainer.assessments.recover-missing');
Route::get('/trainer/assessments/{assessment}', [TrainerController::class, 'showAssessment'])->middleware(['auth'])->name('trainer.assessments.show');
// Material management
Route::put('/trainer/materials/{material}', [TrainerController::class, 'updateMaterial'])->middleware(['auth'])->name('trainer.materials.update');
Route::delete('/trainer/materials/{material}', [TrainerController::class, 'destroyMaterial'])->middleware(['auth'])->name('trainer.materials.destroy');
Route::get('/trainer/materials/{material}/edit', [TrainerController::class, 'editMaterial'])->middleware(['auth'])->name('trainer.materials.edit');
// Assessment management
Route::put('/trainer/assessments/{assessment}', [TrainerController::class, 'updateAssessment'])->middleware(['auth'])->name('trainer.assessments.update');
Route::delete('/trainer/assessments/{assessment}', [TrainerController::class, 'destroyAssessment'])->middleware(['auth'])->name('trainer.assessments.destroy');
Route::get('/trainer/assessments/{assessment}/edit', [TrainerController::class, 'editAssessment'])->middleware(['auth'])->name('trainer.assessments.edit');
Route::get('/trainer/courses/{course}/assessments/{assessment}/edit', [TrainerController::class, 'editAssessmentForCourse'])->middleware(['auth'])->name('trainer.courses.assessments.edit');
Route::get('/trainer/assessments/{assessment}/download', [TrainerController::class, 'downloadAssessment'])->middleware(['auth'])->name('trainer.assessments.download');
// Reflections
Route::get('/courses/{course}/reflections-map', [\App\Http\Controllers\ReflectionController::class, 'map'])->middleware(['auth'])->name('courses.reflections.map');
Route::post('/courses/{course}/reflect', [\App\Http\Controllers\ReflectionController::class, 'store'])->middleware(['auth'])->name('courses.reflect.store');
Route::get('/courses/{course}/progress', [\App\Http\Controllers\ReflectionController::class, 'progress'])->middleware(['auth'])->name('courses.progress.json');
Route::post('/courses/{course}/enroll', [CourseController::class, 'enrollUser'])->middleware(['auth'])->name('courses.enroll');
Route::delete('/courses/{course}/detach/{user}', [CourseController::class, 'detachUser'])->middleware(['auth'])->name('courses.detach');
Route::post('/courses/{course}/join', [CourseController::class, 'join'])->middleware(['auth'])->name('courses.join');
Route::put('/courses/{course}/participants', [CourseController::class, 'updateParticipants'])->name('courses.updateParticipants');
Route::put('/users/{user}', [DashboardController::class, 'updateUser'])->middleware(['auth'])->name('users.update');
Route::put('/users/{user}/display-details', [DashboardController::class, 'updateDisplayDetails'])->middleware(['auth'])->name('users.update-display-details');
Route::delete('/users/{user}', [DashboardController::class, 'deleteUser'])->middleware(['auth'])->name('users.delete');
Route::put('/profile', [DashboardController::class, 'updateProfile'])->middleware(['auth'])->name('profile.update');
Route::post('/notifications/{notification}/mark-as-read', [DashboardController::class, 'markNotificationAsRead'])->middleware(['auth'])->name('notifications.mark-as-read');

// Certification Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/certifications', [CertificationController::class, 'store'])->name('certifications.store');
    Route::delete('/certifications/{certification}', [CertificationController::class, 'destroy'])->name('certifications.destroy');
    Route::post('/certifications/{certification}/toggle-display', [CertificationController::class, 'toggleDisplay'])->name('certifications.toggle-display');
    Route::post('/certifications/certify-user', [CertificationController::class, 'certifyUser'])->name('certifications.certify-user');
Route::get('/admin/courses/{course}/trainees', [\App\Http\Controllers\DashboardController::class, 'courseTrainees'])->middleware(['auth'])->name('admin.courses.trainees');
Route::get('/admin/certifications/courses/{course}', [\App\Http\Controllers\CertificationController::class, 'coursePage'])->middleware(['auth'])->name('admin.certifications.course');
Route::post('/admin/certifications/courses/{course}/certify', [\App\Http\Controllers\CertificationController::class, 'bulkCertify'])->middleware(['auth'])->name('admin.certifications.course.certify');
Route::get('/admin/certifications/courses/{course}/status', [\App\Http\Controllers\CertificationController::class, 'statusForCourse'])->middleware(['auth'])->name('admin.certifications.course.status');
Route::post('/admin/certifications/courses/{course}/certified/{user}/update', [\App\Http\Controllers\CertificationController::class, 'updateCertificate'])->middleware(['auth'])->name('admin.certifications.course.cert.update');
Route::delete('/admin/certifications/courses/{course}/certified/{user}', [\App\Http\Controllers\CertificationController::class, 'deleteCertificate'])->middleware(['auth'])->name('admin.certifications.course.cert.delete');
Route::get('/admin/certifications/courses/{course}/preview/{certification}/{user}', [\App\Http\Controllers\CertificationController::class, 'previewCertificate'])->middleware(['auth'])->name('admin.certifications.course.preview.single');
Route::get('/admin/certifications/courses/{course}/download/{certification}/{user}', [\App\Http\Controllers\CertificationController::class, 'downloadCertificate'])->middleware(['auth'])->name('admin.certifications.course.download.single');
Route::get('/admin/certifications/courses/{course}/download-batch', [\App\Http\Controllers\CertificationController::class, 'downloadCertificatesBatch'])->middleware(['auth'])->name('admin.certifications.course.download.batch');
});

// Trainer Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/trainer/upload-material', [TrainerController::class, 'uploadMaterial'])->name('trainer.upload-material');
    Route::post('/trainer/create-assessment', [TrainerController::class, 'createAssessment'])->name('trainer.create-assessment');
    Route::post('/trainer/update-grade', [TrainerController::class, 'updateGrade'])->name('trainer.update-grade');
    Route::post('/trainer/announcements', [AnnouncementController::class, 'store'])->name('trainer.announcements.store');
    Route::post('/trainer/calendar-events', [CalendarEventController::class, 'store'])->name('trainer.calendar-events.store');
    Route::delete('/trainer/calendar-events/{event}', [CalendarEventController::class, 'destroy'])->name('trainer.calendar-events.destroy');

    Route::post('/courses/{course}/class-announcements', [ClassAnnouncementController::class, 'store'])->name('courses.class-announcements.store');
    Route::post('/class-announcements/{announcement}/comments', [ClassAnnouncementController::class, 'comment'])->name('class-announcements.comments.store');

    Route::post('/courses/{course}/discussions', [DiscussionController::class, 'store'])->name('courses.discussions.store');
    Route::get('/discussions/{discussion}', [DiscussionController::class, 'show'])->name('discussions.show');
    Route::post('/discussions/{discussion}/react', [DiscussionController::class, 'reactDiscussion'])->name('discussions.react');
    Route::post('/discussions/{discussion}/replies', [DiscussionController::class, 'reply'])->name('discussions.replies.store');
    Route::post('/replies/{reply}/react', [DiscussionController::class, 'react'])->name('discussions.replies.react');
    Route::delete('/replies/{reply}', [DiscussionController::class, 'destroy'])->name('discussions.replies.destroy');
    Route::delete('/discussions/{discussion}', [DiscussionController::class, 'destroyDiscussion'])->name('discussions.destroy');
    Route::delete('/admin/discussions/{discussion}/force', [DiscussionController::class, 'forceDestroyDiscussion'])->name('discussions.force-destroy');
    Route::get('/courses/{course}/discussions/updates', [DiscussionController::class, 'updates'])->name('courses.discussions.updates');
});
