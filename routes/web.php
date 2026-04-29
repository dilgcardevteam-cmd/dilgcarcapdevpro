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
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AccessController;
use App\Http\Controllers\MediaController;

Route::get('/', function () {
    $displayUsers = \App\Models\User::where('display_type', 'our_team')->get();
    $certifications = \App\Models\Certification::where('display_on_landing_page', true)->get();
    $pastTrainees = \App\Models\User::where('display_type', 'past_trainees')->get();
    return view('landing', compact('displayUsers', 'certifications', 'pastTrainees'));
});

Route::get('/media/{path}', [MediaController::class, 'public'])
    ->where('path', '.*')
    ->name('media.public');

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

Route::get('/logout', function () {
    return redirect('/');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::post('/session/keep-alive', [AuthController::class, 'keepAlive'])->name('session.keep-alive');

    Route::get('/create-account', [DashboardController::class, 'setupProfile'])->name('create-account');
    Route::get('/profile/setup', [DashboardController::class, 'setupProfile'])->name('profile.setup');
    Route::post('/profile/setup', [DashboardController::class, 'storeProfileSetup'])->name('profile.setup.store');
    Route::get('/pending-approval', [DashboardController::class, 'pendingApproval'])->name('pending.approval');
    Route::get('/users/{user}', [DashboardController::class, 'publicProfile'])->name('users.profile');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', \App\Http\Middleware\EnsureProfileCompleted::class])
    ->name('dashboard');

Route::get('/participant-dashboard-preview', [DashboardController::class, 'participantPreview'])
    ->middleware(['auth', \App\Http\Middleware\EnsureProfileCompleted::class])
    ->name('participant.dashboard.preview');
// Roles management
Route::resource('/admin/roles', RoleController::class)
    ->only(['index','store','update','destroy'])
    ->middleware(['auth'])
    ->names('admin.roles');
// Access management (permissions matrix) - Super Admin only
Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::post('/admin/access', [AccessController::class, 'update'])->name('admin.access.update');
    Route::get('/access-control', function () {
        return redirect()->route('dashboard', ['tab' => 'access-management']);
    })->name('access-control');
});
Route::get('/stats/users-by-province', [DashboardController::class, 'userCountsByProvince'])->middleware(['auth'])->name('stats.users.by-province');
Route::get('/stats/users-by-region', [DashboardController::class, 'userCountsByRegion'])->middleware(['auth'])->name('stats.users.by-region');
Route::get('/stats/users-gender-by-region', [DashboardController::class, 'userGenderCountsByRegion'])->middleware(['auth'])->name('stats.users.gender-by-region');
Route::get('/stats/users-gender-by-province', [DashboardController::class, 'userGenderCountsByProvince'])->middleware(['auth'])->name('stats.users.gender-by-province');
Route::get('/stats/region-analytics', [DashboardController::class, 'regionAnalytics'])->middleware(['auth'])->name('stats.region.analytics');
Route::get('/stats/province-analytics', [DashboardController::class, 'provinceAnalytics'])->middleware(['auth'])->name('stats.province.analytics');
Route::get('/stats/monthly-growth', [DashboardController::class, 'monthlyGrowth'])->middleware(['auth'])->name('stats.monthly.growth');
Route::get('/admin/courses/create', [CourseController::class, 'create'])->middleware(['auth'])->name('admin.courses.create');
Route::get('/admin/courses/{course}/edit', [CourseController::class, 'edit'])->middleware(['auth'])->name('admin.courses.edit');
// Place pending BEFORE the dynamic {course} route to avoid shadowing

// DILG Central Office data endpoints (bureaus and services)
Route::middleware('auth')->group(function(){
    Route::get('/dilg/central/bureaus', [DashboardController::class, 'centralBureausJson'])->name('dilg.central.bureaus');
    Route::get('/dilg/central/services', [DashboardController::class, 'centralServicesJson'])->name('dilg.central.services');
});
Route::get('/admin/courses/pending', [CourseController::class, 'pending'])->middleware(['auth'])->name('admin.courses.pending');
Route::resource('courses', CourseController::class)->only(['store', 'update', 'destroy'])->middleware(['auth']);
Route::get('/admin/courses/{course}', [CourseController::class, 'adminShow'])->middleware(['auth'])->name('admin.courses.show');
Route::post('/admin/courses/clone', [CourseController::class, 'clone'])->middleware(['auth'])->name('admin.courses.clone');
// Trainer course creation (submit for admin approval)
Route::get('/trainer/courses/create', [CourseController::class, 'trainerCreate'])->middleware(['auth', \App\Http\Middleware\EnsureProfileCompleted::class])->name('trainer.courses.create');
Route::post('/trainer/courses', [CourseController::class, 'trainerStore'])->middleware(['auth', \App\Http\Middleware\EnsureProfileCompleted::class])->name('trainer.courses.store');
Route::post('/courses/{id}/restore', [CourseController::class, 'restore'])->middleware(['auth'])->name('courses.restore');
Route::delete('/courses/{id}/force', [CourseController::class, 'forceDelete'])->middleware(['auth'])->name('courses.force-delete');
// Registrar participants management
Route::get('/registrar/courses/{course}/participants', [CourseController::class, 'participants'])->middleware(['auth'])->name('registrar.courses.participants');
Route::get('/trainee/courses/{course}', [CourseController::class, 'traineeShow'])->middleware(['auth'])->name('trainee.courses.show');
Route::get('/trainee/courses/{course}/outline', [CourseController::class, 'traineeOutline'])->middleware(['auth'])->name('trainee.courses.outline');
// Trainer: enter class (landing replicates trainee view with trainer capabilities)
Route::get('/trainer/courses/{course}', [CourseController::class, 'trainerLanding'])->withTrashed()->middleware(['auth', \App\Http\Middleware\EnsureProfileCompleted::class])->name('trainer.courses.enter');
// Trainer view-only course outline page
Route::get('/trainer/courses/{course}/view', [CourseController::class, 'trainerView'])->withTrashed()->middleware(['auth', \App\Http\Middleware\EnsureProfileCompleted::class])->name('trainer.courses.view');
// Trainer: update course banner image only
Route::post('/trainer/courses/{course}/image', [CourseController::class, 'trainerUpdateImage'])->middleware(['auth', \App\Http\Middleware\EnsureProfileCompleted::class])->name('trainer.courses.image');
// Admin: set course expiration date
Route::put('/admin/courses/{course}/expiration', [CourseController::class, 'setExpirationDate'])->middleware(['auth'])->name('admin.courses.expiration');
// Registrar: set enrollment schedule
Route::put('/registrar/courses/{course}/enrollment-schedule', [CourseController::class, 'setEnrollmentSchedule'])->middleware(['auth'])->name('registrar.courses.enrollment-schedule');
// Module Exam submissions and results
Route::post('/courses/{course}/module-exam/submit', [CourseController::class, 'submitModuleExam'])->middleware(['auth'])->name('courses.module-exam.submit');
Route::get('/courses/{course}/module-exam/results', [CourseController::class, 'moduleExamResults'])->middleware(['auth'])->name('courses.module-exam.results');
Route::get('/courses/{course}/module-exam/attempt', [CourseController::class, 'moduleExamAttempt'])->middleware(['auth'])->name('courses.module-exam.attempt');
Route::post('/courses/{course}/module-exam/restart', [CourseController::class, 'restartModuleExamProgress'])->middleware(['auth'])->name('courses.module-exam.restart');
Route::post('/courses/{course}/module-exam/request-retake', [CourseController::class, 'requestModuleExamRetake'])->middleware(['auth'])->name('courses.module-exam.request-retake');
Route::post('/courses/{course}/module-exam/approve-retake', [CourseController::class, 'approveModuleExamRetake'])->middleware(['auth'])->name('courses.module-exam.approve-retake');
Route::post('/courses/{course}/module-exam/review', [CourseController::class, 'reviewModuleExamEssay'])->middleware(['auth'])->name('courses.module-exam.review');
// Participants progress (trainer gradebook)
Route::get('/trainer/courses/{course}/participants-progress', [CourseController::class, 'participantsProgress'])->middleware(['auth', \App\Http\Middleware\EnsureProfileCompleted::class])->name('trainer.courses.participants-progress');
Route::post('/trainer/courses/{course}/notify-incomplete', [CourseController::class, 'notifyIncompleteParticipants'])->middleware(['auth', \App\Http\Middleware\EnsureProfileCompleted::class])->name('trainer.courses.notify-incomplete');
// Content image upload for editors
Route::post('/courses/content-image', [CourseController::class, 'uploadContentImage'])->middleware(['auth'])->name('courses.content-image.upload');
Route::post('/courses/content-pdf', [CourseController::class, 'uploadContentPDF'])->middleware(['auth'])->name('courses.content-pdf.upload');
// Admin System Settings
Route::post('/admin/system-settings/location/import', [DashboardController::class, 'importLocationMaster'])->middleware(['auth'])->name('admin.settings.location.import');
Route::get('/admin/system-settings/location/export', [DashboardController::class, 'exportLocationMaster'])->middleware(['auth'])->name('admin.settings.location.export');
Route::post('/admin/system-settings/backup/create', [DashboardController::class, 'createBackup'])->middleware(['auth'])->name('admin.settings.backup.create');
Route::get('/admin/system-settings/backup/download/{file}', [DashboardController::class, 'downloadBackup'])->middleware(['auth'])->name('admin.settings.backup.download');
Route::delete('/admin/system-settings/backup/delete/{file}', [DashboardController::class, 'deleteBackup'])->middleware(['auth'])->name('admin.settings.backup.delete');
Route::post('/admin/system-settings/backup/restore', [DashboardController::class, 'restoreBackup'])->middleware(['auth'])->name('admin.settings.backup.restore');

// Academic Year Management
Route::post('/admin/system-settings/academic-year', [DashboardController::class, 'storeAcademicYear'])->middleware(['auth'])->name('admin.settings.academic-year.store');
Route::post('/admin/system-settings/academic-year/{academicYear}/activate', [DashboardController::class, 'activateAcademicYear'])->middleware(['auth'])->name('admin.settings.academic-year.activate');
Route::delete('/admin/system-settings/academic-year/{academicYear}', [DashboardController::class, 'destroyAcademicYear'])->middleware(['auth'])->name('admin.settings.academic-year.destroy');

// Field of Work Management
Route::get('/admin/system-settings/field-of-work', [DashboardController::class, 'getFieldOfWorks'])->middleware(['auth'])->name('admin.settings.field-of-work.index');
Route::post('/admin/system-settings/field-of-work', [DashboardController::class, 'storeFieldOfWork'])->middleware(['auth'])->name('admin.settings.field-of-work.store');
Route::put('/admin/system-settings/field-of-work/{fieldOfWork}', [DashboardController::class, 'updateFieldOfWork'])->middleware(['auth'])->name('admin.settings.field-of-work.update');
Route::delete('/admin/system-settings/field-of-work/{fieldOfWork}', [DashboardController::class, 'destroyFieldOfWork'])->middleware(['auth'])->name('admin.settings.field-of-work.destroy');
// Trainer create classwork page
Route::get('/trainer/courses/{course}/classwork/create', [CourseController::class, 'trainerClassworkCreate'])->middleware(['auth', \App\Http\Middleware\EnsureProfileCompleted::class])->name('trainer.courses.classwork.create');
// Trainer create material/assessment dedicated pages
Route::get('/trainer/courses/{course}/materials/create', [CourseController::class, 'trainerMaterialCreate'])->middleware(['auth', \App\Http\Middleware\EnsureProfileCompleted::class])->name('trainer.courses.materials.create');
Route::get('/trainer/courses/{course}/assessments/create', [CourseController::class, 'trainerAssessmentCreate'])->middleware(['auth', \App\Http\Middleware\EnsureProfileCompleted::class])->name('trainer.courses.assessments.create');
// Trainer module status toggle (lock/unlock)
Route::post('/trainer/courses/{course}/modules/{index}/status', [CourseController::class, 'setModuleStatus'])->middleware(['auth', \App\Http\Middleware\EnsureProfileCompleted::class])->name('trainer.modules.set-status');
// Modules status snapshot (for auto-refresh on outline pages)
Route::get('/courses/{course}/modules-status', [CourseController::class, 'modulesStatus'])->middleware(['auth'])->name('courses.modules.status');
Route::get('/courses/{course}/access-state', [CourseController::class, 'accessState'])->middleware(['auth'])->name('courses.access-state');
// Full modules JSON for fallback rendering
Route::get('/courses/{course}/modules-json', [CourseController::class, 'modulesJson'])->middleware(['auth'])->name('courses.modules.json');
Route::get('/courses/{course}/details-ajax', [CourseController::class, 'getCourseDetailsAjax'])->middleware(['auth'])->name('courses.details.ajax');
// AJAX save for Course Exam editor
Route::post('/courses/{course}/exam', [CourseController::class, 'saveExamAjax'])->middleware(['auth'])->name('courses.exam.save');
// Test bank endpoints
Route::get('/trainer/test-banks', [TrainerController::class, 'listTestBanks'])->middleware(['auth', \App\Http\Middleware\EnsureProfileCompleted::class])->name('trainer.test-banks.index');
Route::post('/trainer/test-banks', [TrainerController::class, 'storeTestBank'])->middleware(['auth', \App\Http\Middleware\EnsureProfileCompleted::class])->name('trainer.test-banks.store');
Route::delete('/trainer/test-banks/{template}', [TrainerController::class, 'destroyTestBank'])->middleware(['auth', \App\Http\Middleware\EnsureProfileCompleted::class])->name('trainer.test-banks.destroy');

// Public PSGC-like location endpoints for signup
Route::get('/psgc/regions', [DashboardController::class, 'regionsJson'])->name('psgc.regions');
Route::get('/psgc/regions/{code}/provinces', [DashboardController::class, 'provincesByRegionJson'])->name('psgc.provinces.by-region');
Route::get('/psgc/regions/{code}/cities', [DashboardController::class, 'citiesByRegionJson'])->name('psgc.cities.by-region');
Route::get('/psgc/provinces/{code}/cities', [DashboardController::class, 'citiesByProvinceJson'])->name('psgc.cities.by-province');
Route::get('/psgc/cities/{code}/barangays', [DashboardController::class, 'barangaysByCityJson'])->name('psgc.barangays.by-city');

// Role conversion: Registrar -> Training Manager
Route::post('/admin/users/{user}/convert-registrar-to-training-manager', [DashboardController::class, 'convertRegistrarToTrainingManager'])->middleware(['auth'])->name('admin.users.convert_to_training_manager');
Route::post('/admin/users/{user}/rollback-training-manager', [DashboardController::class, 'rollbackTrainingManager'])->middleware(['auth'])->name('admin.users.rollback_training_manager');
// Trainee assessment answering and shared Help & Support
Route::middleware('auth')->group(function(){
    Route::get('/help-support', [DashboardController::class, 'helpSupport'])->name('help.support');
    Route::post('/help-support/request', [DashboardController::class, 'storeSupportRequest'])->name('help.support.request');
    Route::get('/trainee/assessments/{assessment}/take', [AssessmentAnswerController::class, 'take'])->name('trainee.assessments.take');
    Route::post('/trainee/assessments/{assessment}/submit', [AssessmentAnswerController::class, 'submit'])->name('trainee.assessments.submit');
});

// Material viewing
Route::get('/materials/{material}', [TrainerController::class, 'showMaterial'])->middleware(['auth'])->name('materials.show');

// Restore and recovery for assessments
Route::post('/trainer/assessments/{assessment}/restore', [TrainerController::class, 'restoreAssessment'])->middleware(['auth', \App\Http\Middleware\EnsureProfileCompleted::class])->name('trainer.assessments.restore');
Route::post('/trainer/assessments/recover-missing', [TrainerController::class, 'recoverMissingAssessments'])->middleware(['auth', \App\Http\Middleware\EnsureProfileCompleted::class])->name('trainer.assessments.recover-missing');
Route::get('/trainer/assessments/{assessment}', [TrainerController::class, 'showAssessment'])->middleware(['auth', \App\Http\Middleware\EnsureProfileCompleted::class])->name('trainer.assessments.show');
// Material management
Route::put('/trainer/materials/{material}', [TrainerController::class, 'updateMaterial'])->middleware(['auth', \App\Http\Middleware\EnsureProfileCompleted::class])->name('trainer.materials.update');
Route::delete('/trainer/materials/{material}', [TrainerController::class, 'destroyMaterial'])->middleware(['auth', \App\Http\Middleware\EnsureProfileCompleted::class])->name('trainer.materials.destroy');
Route::get('/trainer/materials/{material}/edit', [TrainerController::class, 'editMaterial'])->middleware(['auth', \App\Http\Middleware\EnsureProfileCompleted::class])->name('trainer.materials.edit');
// Assessment management
Route::put('/trainer/assessments/{assessment}', [TrainerController::class, 'updateAssessment'])->middleware(['auth', \App\Http\Middleware\EnsureProfileCompleted::class])->name('trainer.assessments.update');
Route::delete('/trainer/assessments/{assessment}', [TrainerController::class, 'destroyAssessment'])->middleware(['auth', \App\Http\Middleware\EnsureProfileCompleted::class])->name('trainer.assessments.destroy');
Route::get('/trainer/assessments/{assessment}/edit', [TrainerController::class, 'editAssessment'])->middleware(['auth', \App\Http\Middleware\EnsureProfileCompleted::class])->name('trainer.assessments.edit');
Route::get('/trainer/courses/{course}/assessments/{assessment}/edit', [TrainerController::class, 'editAssessmentForCourse'])->middleware(['auth', \App\Http\Middleware\EnsureProfileCompleted::class])->name('trainer.courses.assessments.edit');
Route::get('/trainer/assessments/{assessment}/download', [TrainerController::class, 'downloadAssessment'])->middleware(['auth', \App\Http\Middleware\EnsureProfileCompleted::class])->name('trainer.assessments.download');
// Reflections
Route::get('/courses/{course}/reflections-map', [\App\Http\Controllers\ReflectionController::class, 'map'])->middleware(['auth'])->name('courses.reflections.map');
Route::post('/courses/{course}/reflect', [\App\Http\Controllers\ReflectionController::class, 'store'])->middleware(['auth'])->name('courses.reflect.store');
Route::get('/courses/{course}/progress', [\App\Http\Controllers\ReflectionController::class, 'progress'])->middleware(['auth'])->name('courses.progress.json');
Route::post('/courses/{course}/participants', [CourseController::class, 'enrollUser'])->middleware(['auth'])->name('courses.participants.enroll');
Route::post('/courses/{course}/participants/manual', [CourseController::class, 'enrollManual'])->middleware(['auth'])->name('courses.participants.manual');
Route::delete('/courses/{course}/participants/{user}', [CourseController::class, 'detachUser'])->middleware(['auth'])->name('courses.participants.detach');
Route::post('/courses/{course}/join', [CourseController::class, 'join'])->middleware(['auth'])->name('courses.join');
Route::post('/courses/{course}/enroll-free', [CourseController::class, 'enrollFree'])->middleware(['auth'])->name('courses.enroll.free');
Route::post('/courses/{course}/enroll-controlled', [CourseController::class, 'enrollControlled'])->middleware(['auth'])->name('courses.enroll.controlled');
Route::put('/courses/{course}/participants', [CourseController::class, 'updateParticipants'])->name('courses.updateParticipants');
// Publish/Unpublish course
Route::post('/courses/{course}/publish', [CourseController::class, 'setPublished'])->middleware(['auth'])->name('courses.publish');
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
    Route::get('/certifications/{certification}/download', [CertificationController::class, 'downloadTemplate'])->name('certifications.download');
    Route::post('/certifications/certify-user', [CertificationController::class, 'certifyUser'])->name('certifications.certify-user');
    Route::post('/admin/certifications/preview/generate', [\App\Http\Controllers\CertificationController::class, 'generateFromTemplate'])->name('admin.certifications.preview.generate');
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
    Route::post('/trainer/upload-material', [TrainerController::class, 'uploadMaterial'])->middleware(\App\Http\Middleware\EnsureProfileCompleted::class)->name('trainer.upload-material');
    Route::post('/trainer/create-assessment', [TrainerController::class, 'createAssessment'])->middleware(\App\Http\Middleware\EnsureProfileCompleted::class)->name('trainer.create-assessment');
    Route::post('/trainer/update-grade', [TrainerController::class, 'updateGrade'])->middleware(\App\Http\Middleware\EnsureProfileCompleted::class)->name('trainer.update-grade');
    Route::post('/trainer/announcements', [AnnouncementController::class, 'store'])->middleware(\App\Http\Middleware\EnsureProfileCompleted::class)->name('trainer.announcements.store');
    Route::post('/trainer/calendar-events', [CalendarEventController::class, 'store'])->middleware(\App\Http\Middleware\EnsureProfileCompleted::class)->name('trainer.calendar-events.store');
    Route::delete('/trainer/calendar-events/{event}', [CalendarEventController::class, 'destroy'])->middleware(\App\Http\Middleware\EnsureProfileCompleted::class)->name('trainer.calendar-events.destroy');

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
