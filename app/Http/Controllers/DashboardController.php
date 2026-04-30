<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Course;
use App\Models\Certification;
use App\Models\AcademicYear;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountApproved;
use App\Models\Announcement;
use App\Models\CalendarEvent;
use App\Models\Notification;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\Role;
use App\Models\FieldOfWork;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        if ($request->input('tab') === 'access-management' && ($user?->role !== 'super_admin')) {
            abort(403);
        }
        $forceProfile = !$user->profile_completed;
        $adminRoles = ['admin','super_admin','central_office_admin','regional_office_admin','provincial_office_admin'];
        $tmRoles = ['training_manager','central_office_training_manager','regional_office_training_manager','provincial_office_training_manager'];
        $coachRoles = ['coach','trainer','central_office_coach','regional_office_coach','provincial_office_coach'];
        $participantRoles = ['participant','trainee','central_office_participants','regional_office_participants','provincial_office_participants'];
        $portal = strtolower((string) $request->query('portal', ''));
        $isSuperAdmin = strtolower((string) ($user?->role ?? '')) === 'super_admin';
        if ($isSuperAdmin) {
            $portal = 'admin';
        }
        $canCoachPortal = !$isSuperAdmin && ($user->hasPermission('view_courses_coach') || $user->hasPermission('view_classes') || $user->hasPermission('view_communication'));
        $canParticipantPortal = !$isSuperAdmin && $user->hasPermission('view_modules');
        $canManageCertificationsFromCoach = !$isSuperAdmin && $user->hasPermission('add_courses_coach');
        $canAdminPortal = $user->hasPermission('view_users')
            || $user->hasPermission('create_users')
            || $user->hasPermission('edit_users')
            || $user->hasPermission('delete_users')
            || $user->hasPermission('view_certifications')
            || $canManageCertificationsFromCoach
            || $user->hasPermission('view_monitoring')
            || $user->hasPermission('view_access_control')
            || $user->hasPermission('edit_access_control');
        $canTmPortal = !$isSuperAdmin && ($user->hasPermission('view_training')
            || $user->hasPermission('view_users_tm')
            || $user->hasPermission('update_users_tm'));
        $roleForView = $user->role;
        if ($portal === 'admin' && $canAdminPortal) {
            $roleForView = 'admin';
        }
        if (in_array($portal, ['tm', 'training_manager'], true) && $canTmPortal) {
            $roleForView = 'training_manager';
        }
        if ($portal === 'coach' && $canCoachPortal) {
            $roleForView = 'coach';
        }
        if ($portal === 'participant' && $canParticipantPortal) {
            $roleForView = 'participant';
        }

        $academicYears = AcademicYear::orderBy('year_start', 'desc')->get();
        
        // Ensure only one is active if multiple were found (e.g. from inconsistent data)
        $activeYears = $academicYears->where('is_active', true);
        if ($activeYears->count() > 1) {
            $latestActive = $activeYears->first();
            AcademicYear::where('id', '!=', $latestActive->id)->update(['is_active' => false]);
            $academicYears = AcademicYear::orderBy('year_start', 'desc')->get();
        }

        $activeYear = $academicYears->where('is_active', true)->first();
        $selectedYearId = $request->input('academic_year_id', $activeYear ? $activeYear->id : null);
        $selectedYear = ($selectedYearId === 'all') ? null : $academicYears->find($selectedYearId);
        $showCourses = true; // Default to true, adjust in role checks

        if (in_array($roleForView, array_merge($coachRoles, $participantRoles))) {
            $showCourses = ($selectedYearId === 'all') || ($selectedYear && $selectedYear->is_active);
        }

        switch (true) {
            case in_array($roleForView, $adminRoles, true):
                $managedRoles = [];
                if ($user->role === 'central_office_admin') {
                    $managedRoles = ['central_office_admin', 'central_office_training_manager','central_office_coach','central_office_participants'];
                } elseif ($user->role === 'regional_office_admin') {
                    $managedRoles = ['regional_office_admin', 'regional_office_training_manager','regional_office_coach','regional_office_participants'];
                } elseif ($user->role === 'provincial_office_admin') {
                    $managedRoles = ['provincial_office_admin', 'provincial_office_training_manager','provincial_office_coach','provincial_office_participants'];
                } elseif ($user->role === 'super_admin') {
                    $managedRoles = [
                        'admin','super_admin','registrar',
                        'training_manager','coach','trainer','participant','trainee',
                        'central_office_training_manager','central_office_coach','central_office_participants',
                        'regional_office_training_manager','regional_office_coach','regional_office_participants',
                        'provincial_office_training_manager','provincial_office_coach','provincial_office_participants',
                        'central_office_admin','regional_office_admin','provincial_office_admin',
                    ];
                } else { // ordinary admin
                    $managedRoles = ['admin', 'training_manager','coach','trainer','participant','trainee'];
                }
                $managedCoachRoles = array_values(array_intersect($coachRoles, $managedRoles));
                $managedTMRoles = array_values(array_intersect($tmRoles, $managedRoles));
                $managedParticipantRoles = array_values(array_intersect($participantRoles, $managedRoles));

                $levelRoles = [];
                if ($user->role === 'central_office_admin') {
                    $levelRoles = ['central_office_admin','central_office_training_manager','central_office_coach','central_office_participants'];
                } elseif ($user->role === 'regional_office_admin') {
                    $levelRoles = ['regional_office_admin','regional_office_training_manager','regional_office_coach','regional_office_participants'];
                } elseif ($user->role === 'provincial_office_admin') {
                    $levelRoles = ['provincial_office_admin','provincial_office_training_manager','provincial_office_coach','provincial_office_participants'];
                } elseif ($user->role === 'super_admin') {
                    $levelRoles = [
                        'admin','super_admin','training_manager','coach','trainer','participant','trainee',
                        'central_office_admin','central_office_training_manager','central_office_coach','central_office_participants',
                        'regional_office_admin','regional_office_training_manager','regional_office_coach','regional_office_participants',
                        'provincial_office_admin','provincial_office_training_manager','provincial_office_coach','provincial_office_participants',
                    ];
                } else {
                    $levelRoles = ['admin','training_manager','coach','trainer','participant','trainee'];
                }

                $stats = $this->dashboardService->getAdminStats($managedRoles, $levelRoles, $managedCoachRoles, $selectedYearId);
                extract($stats);

                $trainersCount = User::whereIn('role', $managedCoachRoles)->where('profile_completed', true)->count();
                $traineesCount = User::whereIn('role', $managedParticipantRoles)->where('profile_completed', true)->count();
                $adminsCount = User::whereIn('role', $adminRoles)->where('profile_completed', true)->count();
                $registrarsCount = User::where('role', 'registrar')->count();
                $archivedCoursesCount = Course::onlyTrashed()->count();
                $certificationCount = Certification::count();
                
                $query = User::query()
                    ->whereIn('role', $managedRoles)
                    ->where('profile_completed', true);

                // Search by Name
                if ($request->filled('search')) {
                    $query->where('name', 'like', '%' . $request->search . '%');
                }

                // Filter by Role
                if ($request->has('roles')) {
                    $selectedRoles = $this->expandManagedRoleFilters(
                        (array) $request->roles,
                        $managedRoles,
                        $managedCoachRoles,
                        $managedParticipantRoles,
                        $managedTMRoles,
                        array_values(array_intersect($adminRoles, $managedRoles))
                    );

                    if (!empty($selectedRoles)) {
                        $query->whereIn(DB::raw('LOWER(role)'), array_map('strtolower', $selectedRoles));
                    }
                }

                // Filter by Status
                if ($request->has('statuses')) {
                    $query->whereIn('status', $request->statuses);
                }
                // Sorting
                $sort = $request->get('sort', 'newest');
                if ($sort === 'oldest') {
                    $query->orderBy('created_at', 'asc');
                } elseif ($sort === 'alpha') {
                    $query->orderBy('name', 'asc');
                } else {
                    $query->orderBy('created_at', 'desc');
                }
                $users = $query->paginate(8)->appends($request->query());
                $roleDisplay = \App\Models\Role::pluck('display_name','name')->toArray();

                $activityLogs = ActivityLog::with('user')->latest()->take(30)->get();

                if ($request->ajax()) {
                    return view('admin.partials.users-table', compact('users','roleDisplay'))->render();
                }

                $roles = Role::orderBy('name')->get();
                $permissions = \Illuminate\Support\Facades\Schema::hasTable('permissions')
                    ? \DB::table('permissions')->orderBy('name')->get()
                    : collect();
                $rolePermissions = [];
                if (\Illuminate\Support\Facades\Schema::hasTable('role_permission')) {
                    foreach ($roles as $r) {
                        $rolePermissions[$r->id] = \DB::table('role_permission')
                            ->where('role_id', $r->id)
                            ->pluck('permission_id')
                            ->toArray();
                    }
                }
                $fieldOfWorks = FieldOfWork::orderBy('name', 'asc')->get();

                return view('admin.dashboard', compact(
                    'userCount',
                    'users',
                    'courses',
                    'courseCount',
                    'archivedCourses',
                    'pendingCourses',
                    'certifications',
                    'forceProfile',
                    'pendingCoursesCount',
                    'activeUsersCount',
                    'pendingUsersTotal',
                    'frozenUsersCount',
                    'trainersCount',
                    'traineesCount',
                    'adminsCount',
                    'registrarsCount',
                    'archivedCoursesCount',
                    'certificationCount',
                    'recentCourses',
                    'roles',
                    'permissions',
                    'rolePermissions',
                    'roleDisplay',
                    'publishedCoursesCount',
                    'unpublishedCoursesCount',
                    'academicYears',
                    'selectedYearId',
                    'selectedYear',
                    'activityLogs',
                    'fieldOfWorks'
                ));
            case $roleForView === 'registrar':
                $registrarScope = function ($query) {
                    $query->where(function ($scoped) {
                        $scoped->whereNull('agency')
                            ->orWhere('agency', '!=', 'DILG');
                    });
                };

                $unapprovedCount = User::where('profile_completed', true)->where('status', 'pending')->where($registrarScope)->count();
                $approvedCount = User::where('profile_completed', true)->where('status', 'active')->where($registrarScope)->count();
                $pendingTraineesCount = User::whereIn('role', $participantRoles)->where('profile_completed', true)->where('status', 'pending')->where($registrarScope)->count();
                // Registrar manages coach/trainer and participant roles
                $managedRoles = ['admin', 'training_manager', 'coach', 'trainer', 'participant'];
                
                $courseQuery = Course::query();
                if ($selectedYearId !== 'all') {
                    $courseQuery->where('academic_year_id', $selectedYearId);
                }

                // Show all courses to registrar (including those without assigned users yet)
                $totalCourses = (clone $courseQuery)->count();
                $courses = $courseQuery->with('users')->orderBy('created_at','desc')->get();
                $potentialParticipants = User::whereIn('role', array_merge($coachRoles,$participantRoles))->where('status', 'active')->get();
                
                // Fetch Notifications
                $notifications = Notification::where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->take(10)
                    ->get();
                $unreadNotificationsCount = Notification::where('user_id', $user->id)
                    ->where('is_read', false)
                    ->count();

                $query = User::query()->where('profile_completed', true)->where($registrarScope);
                if ($request->get('tab') === 'user-management') {
                    $excludedRoles = [
                        'provincial_office_coach',
                        'provincial_office_participants',
                        'regional_office_coach',
                        'regional_office_participants',
                        'provincial_office_admin',
                        'central_office_coach',
                        'provincial_office_training_manager',
                        'central_office_participants',
                        'regional_office_admin',
                        'regional_office_training_manager',
                        'central_office_admin',
                        'central_office_training_manager',
                        'super_admin',
                    ];
                    
                    // Don't exclude the current user's role if they are one of these admins
                    $myRole = $user->role;
                    $excludedRoles = array_diff($excludedRoles, [$myRole]);
                    
                    $query->whereNotIn('role', $excludedRoles);
                }

                // Search by Name
                if ($request->filled('search')) {
                    $query->where('name', 'like', '%' . $request->search . '%');
                }

                // Filter by Role
                if ($request->has('roles')) {
                    $roles = (array) $request->roles;
                    // Normalize synonyms so filtering works regardless of alias
                    $expanded = [];
                    foreach ($roles as $r) {
                        $expanded[] = $r;
                        if (in_array($r, ['trainer','coach'], true)) { $expanded = array_merge($expanded, $coachRoles); }
                        if (in_array($r, ['trainee','participant'], true)) { $expanded = array_merge($expanded, $participantRoles); }
                        if (in_array($r, ['training_manager','registrar'], true)) { $expanded = array_merge($expanded, $tmRoles); }
                        if ($r === 'admin') { $expanded = array_merge($expanded, $adminRoles); }
                    }
                    $query->whereIn('role', array_unique($expanded));
                }

                // Filter by Status (Registrar specific: pending/active)
                if ($request->has('statuses')) {
                    $query->whereIn('status', $request->statuses);
                }
                // Sorting
                $sort = $request->get('sort', 'newest');
                if ($sort === 'oldest') {
                    $query->orderBy('created_at', 'asc');
                } elseif ($sort === 'alpha') {
                    $query->orderBy('name', 'asc');
                } else {
                    $query->orderBy('created_at', 'desc');
                }
                $users = $query->paginate(8)->appends($request->query());
                $roleDisplay = \App\Models\Role::pluck('display_name','name')->toArray();

                if ($request->ajax()) {
                    return view('registrar.partials.users-table', compact('users', 'roleDisplay'))->render();
                }

                $availableRoles = \App\Models\Role::whereIn('name', $managedRoles)->get();

                // Calculate counts for the dashboard donut charts
                $userQuery = User::whereIn('role', $managedRoles)->where('profile_completed', true)->where($registrarScope);
                $userCount = $userQuery->count();
                $aActive = (clone $userQuery)->where('status', 'active')->count();
                $aPending = (clone $userQuery)->where('status', 'pending')->count();
                $aBlocked = (clone $userQuery)->where('status', 'freeze')->count();

                $rAdmins = User::where('role', 'admin')->where($registrarScope)->count();
                $rTM = User::where('role', 'training_manager')->where($registrarScope)->count();
                $rCoaches = User::whereIn('role', ['coach', 'trainer'])->where($registrarScope)->count();
                $rParticipants = User::whereIn('role', ['participant', 'trainee'])->where($registrarScope)->count();

                $publishedCoursesCountQuery = Course::where('is_published', true);
                $unpublishedCoursesCountQuery = Course::where('is_published', false);
                if ($selectedYearId !== 'all') {
                    $publishedCoursesCountQuery->where('academic_year_id', $selectedYearId);
                    $unpublishedCoursesCountQuery->where('academic_year_id', $selectedYearId);
                }
                $publishedCoursesCount = $publishedCoursesCountQuery->count();
                $unpublishedCoursesCount = $unpublishedCoursesCountQuery->count();
                $pendingCoursesCount = $unpublishedCoursesCount;

                $certificationsIssuedCountQuery = DB::table('certification_user')
                    ->join('users', 'users.id', '=', 'certification_user.user_id')
                    ->join('courses', 'courses.id', '=', 'certification_user.course_id')
                    ->whereIn('users.role', $participantRoles)
                    ->where('users.profile_completed', true)
                    ->where(function ($scoped) {
                        $scoped->whereNull('users.agency')
                            ->orWhere('users.agency', '!=', 'DILG');
                    });
                if ($selectedYearId !== 'all') {
                    $certificationsIssuedCountQuery->where('courses.academic_year_id', $selectedYearId);
                }
                $certificationsIssuedCount = $certificationsIssuedCountQuery->count();
                $pendingApprovalsCount = $unapprovedCount;
                $totalUsersCount = $userCount;

                $courseQuery = Course::query(); // Registrar sees all for now
                $cActive = $courseQuery->count();
                $cNoCoachNoPart = (clone $courseQuery)->whereDoesntHave('users', function($q){ $q->whereIn('role',['coach','trainer']); })
                    ->whereDoesntHave('users', function($q){ $q->whereIn('role',['participant','trainee']); })
                    ->count();
                $cNoCoachOnly = (clone $courseQuery)->whereDoesntHave('users', function($q){ $q->whereIn('role',['coach','trainer']); })
                    ->whereHas('users', function($q){ $q->whereIn('role',['participant','trainee']); })
                    ->count();
                $cNoParticipantOnly = (clone $courseQuery)->whereHas('users', function($q){ $q->whereIn('role',['coach','trainer']); })
                    ->whereDoesntHave('users', function($q){ $q->whereIn('role',['participant','trainee']); })
                    ->count();
                $cActiveBoth = (clone $courseQuery)->whereHas('users', function($q){ $q->whereIn('role',['coach','trainer']); })
                    ->whereHas('users', function($q){ $q->whereIn('role',['participant','trainee']); })
                    ->count();
                $cWithCoach = (clone $courseQuery)->whereHas('users', function($q){ $q->whereIn('role',['coach','trainer']); })->count();
                $cWithoutCoach = (clone $courseQuery)->whereDoesntHave('users', function($q){ $q->whereIn('role',['coach','trainer']); })->count();

                $fieldOfWorks = FieldOfWork::orderBy('name', 'asc')->get();
                $certifications = Certification::orderByDesc('created_at')->get();

                return view('registrar.dashboard', compact(
                    'unapprovedCount',
                    'approvedCount',
                    'pendingTraineesCount',
                    'totalCourses',
                    'totalUsersCount',
                    'pendingCoursesCount',
                    'certificationsIssuedCount',
                    'pendingApprovalsCount',
                    'users',
                    'courses',
                    'certifications',
                    'potentialParticipants',
                    'notifications',
                    'unreadNotificationsCount',
                    'forceProfile',
                    'availableRoles',
                    'roleDisplay',
                    'userCount', 'aActive', 'aPending', 'aBlocked',
                    'rAdmins', 'rTM', 'rCoaches', 'rParticipants',
                    'cActive', 'cNoCoachNoPart', 'cNoCoachOnly', 'cNoParticipantOnly', 'cActiveBoth',
                    'publishedCoursesCount', 'unpublishedCoursesCount',
                    'cWithCoach', 'cWithoutCoach',
                    'academicYears',
                    'selectedYearId',
                    'selectedYear',
                    'fieldOfWorks'
                ));
            case in_array($roleForView, $coachRoles, true):
                if ($showCourses) {
                    $myCourses = Course::where('trainer_id', $user->id)
                        ->where('academic_year_id', $selectedYearId)
                        ->orderBy('created_at', 'desc')
                        ->with(['users', 'materials', 'assessments.grades'])
                        ->get();
                } else {
                    $myCourses = collect([]);
                }

                $hasSubmittedBy = Schema::hasColumn('courses', 'submitted_by_user_id');
                $submissionField = $hasSubmittedBy ? 'submitted_by_user_id' : 'trainer_id';

                if ($showCourses) {
                    $activeCoachCoursesQuery = Course::query()
                        ->where($submissionField, $user->id)
                        ->where('is_published', true);
                    if ($selectedYearId !== 'all') {
                        $activeCoachCoursesQuery->where('academic_year_id', $selectedYearId);
                    }
                    $activeCoachCourses = $activeCoachCoursesQuery->with('users')->orderByDesc('updated_at')->get();

                    $pendingCoachCoursesQuery = Course::onlyTrashed()
                        ->where($submissionField, $user->id)
                        ->where('is_published', false);
                    if ($selectedYearId !== 'all') {
                        $pendingCoachCoursesQuery->where('academic_year_id', $selectedYearId);
                    }
                    $pendingCoachCourses = $pendingCoachCoursesQuery->with('users')->orderByDesc('created_at')->get();

                    $archivedCoachCoursesQuery = Course::onlyTrashed()
                        ->where($submissionField, $user->id)
                        ->where('is_published', true);
                    if ($selectedYearId !== 'all') {
                        $archivedCoachCoursesQuery->where('academic_year_id', $selectedYearId);
                    }
                    $archivedCoachCourses = $archivedCoachCoursesQuery->with('users')->orderByDesc('created_at')->get();
                } else {
                    $activeCoachCourses = collect([]);
                    $pendingCoachCourses = collect([]);
                    $archivedCoachCourses = collect([]);
                }
                
                $totalCoursesTeaching = $myCourses->count();
                
                // Count total unique students across all courses
                $myParticipantRoles = [];
                if ($user->role === 'central_office_coach') {
                    $myParticipantRoles = ['central_office_participants'];
                } elseif ($user->role === 'regional_office_coach') {
                    $myParticipantRoles = ['regional_office_participants'];
                } elseif ($user->role === 'provincial_office_coach') {
                    $myParticipantRoles = ['provincial_office_participants'];
                } else {
                    $myParticipantRoles = ['participant','trainee'];
                }
                $totalStudents = $myCourses->flatMap(function ($course) use ($myParticipantRoles) {
                    return $course->users->whereIn('role', $myParticipantRoles);
                })->unique('id')->count();

                $courseStatuses = [];
                $excludedIds = [];
                // Limit course visibility to same-level roles (admin/tm/coach/participant)
                $levelRoles = [];
                if ($user->role === 'central_office_coach') {
                    $levelRoles = ['central_office_admin','central_office_training_manager','central_office_coach','central_office_participants'];
                } elseif ($user->role === 'regional_office_coach') {
                    $levelRoles = ['regional_office_admin','regional_office_training_manager','regional_office_coach','regional_office_participants'];
                } elseif ($user->role === 'provincial_office_coach') {
                    $levelRoles = ['provincial_office_admin','provincial_office_training_manager','provincial_office_coach','provincial_office_participants'];
                } else {
                    $levelRoles = ['admin','training_manager','coach','trainer','participant','trainee'];
                }
                
                if ($showCourses) {
                    $availableCoursesQuery = Course::whereHas('users', function($q) use ($levelRoles) {
                            $q->whereIn('role', $levelRoles);
                        })
                        ->where('academic_year_id', $selectedYearId)
                        ->with(['users' => function($q) use ($levelRoles) {
                            $q->whereIn('role', $levelRoles);
                        }]);
                    if (!empty($excludedIds)) {
                        $availableCoursesQuery = $availableCoursesQuery->whereNotIn('id', $excludedIds);
                    }
                    $availableCourses = $availableCoursesQuery->orderBy('created_at', 'desc')->get();
                } else {
                    $availableCourses = collect([]);
                }
                $libraryCoachCourses = $availableCourses->filter(function ($course) {
                    return (bool) ($course->is_published ?? false);
                })->values();

                $announcements = Announcement::with('user')->latest()->get();
                $calendarEvents = CalendarEvent::where('user_id', $user->id)->orderBy('start_time')->get();

                // Add Course start and end dates as calendar events
                foreach ($myCourses as $course) {
                    if ($course->start_date) {
                        $calendarEvents->push(new CalendarEvent([
                            'title' => $course->name . ' (Starts)',
                            'start_time' => $course->start_date->startOfDay(),
                            'type' => 'class',
                        ]));
                    }
                    if ($course->end_date) {
                        $calendarEvents->push(new CalendarEvent([
                            'title' => $course->name . ' (Ends)',
                            'start_time' => $course->end_date->endOfDay(),
                            'type' => 'deadline',
                        ]));
                    }
                }

                // Fetch Notifications
                $notifications = Notification::where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->take(10)
                    ->get();
                $unreadNotificationsCount = Notification::where('user_id', $user->id)
                    ->where('is_read', false)
                    ->count();

                return view('trainer.dashboard', compact('myCourses', 'activeCoachCourses', 'availableCourses', 'libraryCoachCourses', 'pendingCoachCourses', 'archivedCoachCourses', 'courseStatuses', 'totalCoursesTeaching', 'totalStudents', 'announcements', 'calendarEvents', 'notifications', 'unreadNotificationsCount', 'forceProfile', 'academicYears', 'selectedYearId', 'selectedYear'));
            case in_array($roleForView, $tmRoles, true):
                $managedRoles = [];
                $pendingApplicantScope = null;
                if ($user->role === 'central_office_training_manager') {
                    $managedRoles = ['central_office_admin', 'central_office_training_manager', 'central_office_coach', 'central_office_participants'];
                    $pendingApplicantScope = function ($query) {
                        $query->whereNull('role')
                            ->where('status', 'pending')
                            ->where('agency', 'DILG')
                            ->where('region', 'DILG Central Office');
                    };
                } elseif ($user->role === 'regional_office_training_manager') {
                    $managedRoles = ['regional_office_admin', 'regional_office_training_manager', 'regional_office_coach', 'regional_office_participants'];
                    $pendingApplicantScope = function ($query) {
                        $query->whereNull('role')
                            ->where('status', 'pending')
                            ->where('agency', 'DILG')
                            ->where('region', 'DILG Regional Office');
                    };
                } elseif ($user->role === 'provincial_office_training_manager') {
                    $managedRoles = ['provincial_office_admin', 'provincial_office_training_manager', 'provincial_office_coach', 'provincial_office_participants'];
                    $pendingApplicantScope = function ($query) {
                        $query->whereNull('role')
                            ->where('status', 'pending')
                            ->where('agency', 'DILG')
                            ->where('region', 'DILG Provincial Office');
                    };
                } else {
                    $managedRoles = ['admin', 'training_manager', 'coach', 'trainer', 'participant'];
                    $pendingApplicantScope = function ($query) {
                        $query->whereNull('role')
                            ->where('status', 'pending')
                            ->where(function ($scoped) {
                                $scoped->whereNull('agency')
                                    ->orWhere('agency', '!=', 'DILG');
                            });
                    };
                }
                $managedCoachRoles = array_values(array_intersect($coachRoles, $managedRoles));
                $managedParticipantRoles = array_values(array_intersect($participantRoles, $managedRoles));
                $unapprovedCount = User::where('profile_completed', true)
                    ->where(function ($query) use ($managedRoles, $pendingApplicantScope) {
                        $query->whereIn('role', $managedRoles);
                        if ($pendingApplicantScope) {
                            $query->orWhere($pendingApplicantScope);
                        }
                    })
                    ->where('status', 'pending')
                    ->count();
                $approvedCount = User::whereIn('role', $managedRoles)->where('profile_completed', true)->where('status', 'active')->count();
                $pendingTraineesCount = User::whereIn('role', $managedParticipantRoles)->where('profile_completed', true)->where('status', 'pending')->count();
                // Limit visible courses to TM's branch/level
                $levelRoles = [];
                if ($user->role === 'central_office_training_manager') {
                    $levelRoles = ['central_office_admin','central_office_training_manager','central_office_coach','central_office_participants'];
                } elseif ($user->role === 'regional_office_training_manager') {
                    $levelRoles = ['regional_office_admin','regional_office_training_manager','regional_office_coach','regional_office_participants'];
                } elseif ($user->role === 'provincial_office_training_manager') {
                    $levelRoles = ['provincial_office_admin','provincial_office_training_manager','provincial_office_coach','provincial_office_participants'];
                } else {
                    $levelRoles = ['admin','training_manager','coach','trainer','participant','trainee'];
                }

                $courseQuery = Course::whereHas('users', function($q) use ($levelRoles) {
                    $q->whereIn('role', $levelRoles);
                });

                if ($selectedYearId !== 'all') {
                    $courseQuery->where('academic_year_id', $selectedYearId);
                }

                $totalCourses = (clone $courseQuery)->count();
                $courses = (clone $courseQuery)->with('users')->get();
                $publishedCoursesQuery = Course::where('is_published', true)
                    ->whereHas('users', function($q) use ($levelRoles) {
                        $q->whereIn('role', $levelRoles);
                    });
                if ($selectedYearId !== 'all') {
                    $publishedCoursesQuery->where('academic_year_id', $selectedYearId);
                }
                $publishedCourses = $publishedCoursesQuery->orderBy('created_at','desc')->get();
                if ($publishedCourses->isEmpty()) {
                    $publishedCourses = $courses->filter(function($c){
                        return (int)($c->is_published ?? 0) === 1 || $c->is_published === true || $c->is_published === '1';
                    })->values();
                }
                $pendingCoursesQuery = Course::withTrashed()
                    ->where('is_published', false)
                    ->whereHas('users', function($q) use ($managedCoachRoles) {
                        $q->whereIn(DB::raw('LOWER(role)'), array_map('strtolower', $managedCoachRoles));
                    });
                if ($selectedYearId !== 'all') {
                    $pendingCoursesQuery->where('academic_year_id', $selectedYearId);
                }
                $pendingCourses = (clone $pendingCoursesQuery)->with('users')->orderByDesc('created_at')->get();
                $pendingCoursesCount = (clone $pendingCoursesQuery)->count();
                $archivedCoursesQuery = Course::onlyTrashed()
                    ->whereHas('users', function($q) use ($levelRoles) {
                        $q->whereIn('role', $levelRoles);
                    });
                if ($selectedYearId !== 'all') {
                    $archivedCoursesQuery->where('academic_year_id', $selectedYearId);
                }
                $archivedCourses = (clone $archivedCoursesQuery)->with('users')->orderByDesc('created_at')->get();
                $potentialParticipants = User::whereIn('role', array_merge($managedCoachRoles,$managedParticipantRoles))->where('status', 'active')->get();
                $notifications = Notification::where('user_id', $user->id)->orderBy('created_at', 'desc')->take(10)->get();
                $unreadNotificationsCount = Notification::where('user_id', $user->id)->where('is_read', false)->count();
                $query = User::query()
                    ->where('profile_completed', true)
                    ->where(function ($builder) use ($managedRoles, $pendingApplicantScope) {
                        $builder->whereIn('role', $managedRoles);
                        if ($pendingApplicantScope) {
                            $builder->orWhere($pendingApplicantScope);
                        }
                    });
                if ($request->filled('search')) $query->where('name', 'like', '%' . $request->search . '%');
                if ($request->has('roles')) {
                    $selectedRoles = $this->expandManagedRoleFilters(
                        (array) $request->roles,
                        $managedRoles,
                        $managedCoachRoles,
                        $managedParticipantRoles,
                        array_values(array_intersect($tmRoles, $managedRoles)),
                        array_values(array_intersect($adminRoles, $managedRoles))
                    );

                    if (!empty($selectedRoles)) {
                        $query->whereIn(DB::raw('LOWER(role)'), array_map('strtolower', $selectedRoles));
                    }
                }
                if ($request->has('statuses')) $query->whereIn('status', $request->statuses);
                $sort = $request->get('sort', 'newest');
                if ($sort === 'oldest') $query->orderBy('created_at', 'asc');
                elseif ($sort === 'alpha') $query->orderBy('name', 'asc');
                else $query->orderBy('created_at', 'desc');
                $users = $query->paginate(8)->appends($request->query());
                $roleDisplay = \App\Models\Role::pluck('display_name','name')->toArray();
                if ($request->ajax()) {
                    return view('registrar.partials.users-table', compact('users','roleDisplay'))->render();
                }

                $availableRoles = \App\Models\Role::whereIn('name', $managedRoles)->get();

                // Calculate counts for the dashboard donut charts scoped to TM
                $userQuery = User::whereIn('role', $managedRoles)->where('profile_completed', true);
                $userCount = $userQuery->count();
                $aActive = (clone $userQuery)->where('status', 'active')->count();
                $aPending = (clone $userQuery)->where('status', 'pending')->count();
                $aBlocked = (clone $userQuery)->where('status', 'freeze')->count();

                $rAdmins = User::whereIn('role', $adminRoles)->whereIn('role', $managedRoles)->where('profile_completed', true)->count();
                $rTM = User::whereIn('role', $tmRoles)->whereIn('role', $managedRoles)->where('profile_completed', true)->count();
                $rCoaches = User::whereIn('role', $coachRoles)->whereIn('role', $managedRoles)->where('profile_completed', true)->count();
                $rParticipants = User::whereIn('role', $participantRoles)->whereIn('role', $managedRoles)->where('profile_completed', true)->count();

                $publishedCoursesCountQuery = Course::whereHas('users', function($q) use ($levelRoles) {
                    $q->whereIn('role', $levelRoles);
                })->where('is_published', true);
                $unpublishedCoursesCountQuery = Course::whereHas('users', function($q) use ($levelRoles) {
                    $q->whereIn('role', $levelRoles);
                })->where('is_published', false);

                if ($selectedYearId !== 'all') {
                    $publishedCoursesCountQuery->where('academic_year_id', $selectedYearId);
                    $unpublishedCoursesCountQuery->where('academic_year_id', $selectedYearId);
                }

                $publishedCoursesCount = $publishedCoursesCountQuery->count();
                $unpublishedCoursesCount = $unpublishedCoursesCountQuery->count();

                $enrollmentRoles = $managedParticipantRoles;
                if (!in_array($user->role, ['central_office_training_manager','regional_office_training_manager','provincial_office_training_manager'], true)) {
                    $enrollmentRoles = array_values(array_unique(array_merge($enrollmentRoles, ['trainee'])));
                }
                $enrollmentBaseQuery = DB::table('course_user')
                    ->join('users', 'users.id', '=', 'course_user.user_id')
                    ->join('courses', 'courses.id', '=', 'course_user.course_id')
                    ->whereIn('users.role', $enrollmentRoles)
                    ->where('users.profile_completed', true)
                    ->whereNotIn('course_user.status', ['pending']);
                if ($selectedYearId !== 'all') {
                    $enrollmentBaseQuery->where('courses.academic_year_id', $selectedYearId);
                }
                $enrollCompletedCount = (clone $enrollmentBaseQuery)->where('course_user.status', 'completed')->count();
                $enrollNotStartedCount = (clone $enrollmentBaseQuery)->where('course_user.status', 'active')->count();
                $enrollInProgressCount = (clone $enrollmentBaseQuery)->whereNotIn('course_user.status', ['completed', 'active'])->count();

                $certificationRoles = $managedParticipantRoles;
                if (!in_array($user->role, ['central_office_training_manager','regional_office_training_manager','provincial_office_training_manager'], true)) {
                    $certificationRoles = array_values(array_unique(array_merge($certificationRoles, ['trainee'])));
                }

                $certificationsIssuedCountQuery = DB::table('certification_user')
                    ->join('users', 'users.id', '=', 'certification_user.user_id')
                    ->join('courses', 'courses.id', '=', 'certification_user.course_id')
                    ->whereIn('users.role', $certificationRoles)
                    ->where('users.profile_completed', true);
                if ($selectedYearId !== 'all') {
                    $certificationsIssuedCountQuery->where('courses.academic_year_id', $selectedYearId);
                }
                $certificationsIssuedCount = $certificationsIssuedCountQuery->count();
                $pendingApprovalsCount = $unapprovedCount;
                $totalUsersCount = $userCount;

                $courseQuery = Course::whereHas('users', function($q) use ($levelRoles) {
                    $q->whereIn('role', $levelRoles);
                });

                if ($selectedYearId !== 'all') {
                    $courseQuery->where('academic_year_id', $selectedYearId);
                }

                $cActive = (clone $courseQuery)->count();
                $cNoCoachNoPart = (clone $courseQuery)->whereDoesntHave('users', function($q){ $q->whereIn('role',['coach','trainer']); })
                    ->whereDoesntHave('users', function($q){ $q->whereIn('role',['participant','trainee']); })
                    ->count();
                $cNoCoachOnly = (clone $courseQuery)->whereDoesntHave('users', function($q){ $q->whereIn('role',['coach','trainer']); })
                    ->whereHas('users', function($q){ $q->whereIn('role',['participant','trainee']); })
                    ->count();
                $cNoParticipantOnly = (clone $courseQuery)->whereHas('users', function($q){ $q->whereIn('role',['coach','trainer']); })
                    ->whereDoesntHave('users', function($q){ $q->whereIn('role',['participant','trainee']); })
                    ->count();
                $cActiveBoth = (clone $courseQuery)->whereHas('users', function($q){ $q->whereIn('role',['coach','trainer']); })
                    ->whereHas('users', function($q){ $q->whereIn('role',['participant','trainee']); })
                    ->count();
                $cWithCoach = (clone $courseQuery)->whereHas('users', function($q){ $q->whereIn('role',['coach','trainer']); })->count();
                $cWithoutCoach = (clone $courseQuery)->whereDoesntHave('users', function($q){ $q->whereIn('role',['coach','trainer']); })->count();

                $fieldOfWorks = FieldOfWork::orderBy('name', 'asc')->get();

                return view('registrar.dashboard', compact(
                    'unapprovedCount',
                    'approvedCount',
                    'pendingTraineesCount',
                    'totalCourses',
                    'totalUsersCount',
                    'enrollCompletedCount',
                    'enrollInProgressCount',
                    'enrollNotStartedCount',
                    'certificationsIssuedCount',
                    'pendingApprovalsCount',
                    'users',
                    'courses',
                    'publishedCourses',
                    'pendingCourses',
                    'pendingCoursesCount',
                    'archivedCourses',
                    'potentialParticipants',
                    'notifications',
                    'unreadNotificationsCount',
                    'forceProfile',
                    'availableRoles',
                    'roleDisplay',
                    'userCount', 'aActive', 'aPending', 'aBlocked',
                    'rAdmins', 'rTM', 'rCoaches', 'rParticipants',
                    'cActive', 'cNoCoachNoPart', 'cNoCoachOnly', 'cNoParticipantOnly', 'cActiveBoth',
                    'publishedCoursesCount', 'unpublishedCoursesCount',
                    'cWithCoach', 'cWithoutCoach',
                    'academicYears',
                    'selectedYearId',
                    'selectedYear',
                    'fieldOfWorks'
                ));
            case in_array($roleForView, $participantRoles, true):
                // Get enrolled courses (active status)
                // Eager load relationships for dashboard display
                $visibleJoinedStatuses = ['active', 'in_progress', 'ready_for_exam', 'completed', 'failed', 'attempts_exhausted'];
                $myCoachRoles = [];
                if ($user->role === 'central_office_participants') {
                    $myCoachRoles = ['central_office_coach'];
                } elseif ($user->role === 'regional_office_participants') {
                    $myCoachRoles = ['regional_office_coach'];
                } elseif ($user->role === 'provincial_office_participants') {
                    $myCoachRoles = ['provincial_office_coach'];
                } else {
                    $myCoachRoles = ['coach','trainer'];
                }

                if ($showCourses) {
                    $myCourses = $user->courses()
                        ->wherePivotIn('status', $visibleJoinedStatuses)
                        ->where('courses.is_published', true)
                        ->where('courses.academic_year_id', $selectedYearId)
                        ->orderBy('courses.created_at', 'desc')
                        ->with(['users' => function($q) use ($myCoachRoles) {
                            $q->whereIn('role', $myCoachRoles);
                        }, 'materials', 'assessments.grades' => function($q) use ($user) {
                            $q->where('user_id', $user->id);
                        }])
                        ->get();

                    // Get pending courses for display if needed
                    $pendingCourses = $user->courses()
                        ->wherePivot('status', 'pending')
                        ->where('courses.academic_year_id', $selectedYearId)
                        ->orderBy('courses.created_at', 'desc')
                        ->with(['users' => function($q) use ($myCoachRoles) {
                            $q->whereIn('role', $myCoachRoles);
                        }])
                        ->get();
                } else {
                    $myCourses = collect([]);
                    $pendingCourses = collect([]);
                }

                $pendingCoursesCount = $pendingCourses->count();
                $classroomCourses = $myCourses->concat($pendingCourses)->sortByDesc('created_at')->values();
                
                // Determine course statuses for current user
                $courseStatuses = $user->courses()->pluck('course_user.status', 'courses.id')->toArray();

                $progressData = [];
                foreach ($classroomCourses as $course) {
                    $progress = $course->getCourseProgress($user);
                    $progress['total_modules'] = count($course->modules ?? []);
                    $progressData[$course->id] = $progress;
                }

                // Get available courses limited strictly to the participant's branch
                $excludedIds = array_map('intval', array_keys($courseStatuses));
                $levelRoles = [];
                if ($user->role === 'central_office_participants') {
                    $levelRoles = ['central_office_admin','central_office_training_manager','central_office_coach','central_office_participants'];
                } elseif ($user->role === 'regional_office_participants') {
                    $levelRoles = ['regional_office_admin','regional_office_training_manager','regional_office_coach','regional_office_participants'];
                } elseif ($user->role === 'provincial_office_participants') {
                    $levelRoles = ['provincial_office_admin','provincial_office_training_manager','provincial_office_coach','provincial_office_participants'];
                } else {
                    $levelRoles = ['admin','training_manager','coach','trainer','participant','trainee'];
                }
                
                if ($showCourses) {
                    $availableCourses = Course::with(['users', 'trainer', 'submittedBy'])
                        ->where('is_published', true)
                        ->where('academic_year_id', $selectedYearId);
                    if (!empty($excludedIds)) {
                        $availableCourses = $availableCourses->whereNotIn('id', $excludedIds);
                    }
                    $availableCourses = $availableCourses->orderBy('created_at', 'desc')->get();
                    
                    $totalAvailableCourses = $availableCourses->count();
                    $totalCoursesJoined = $user->courses()
                        ->wherePivotIn('status', $visibleJoinedStatuses)
                        ->where('academic_year_id', $selectedYearId)
                        ->count();

                    $completedByStatus = $user->courses()
                        ->wherePivot('status', 'completed')
                        ->where('academic_year_id', $selectedYearId)
                        ->count();
                    $completedByCertification = $user->certifications()
                        ->join('courses', 'certification_user.course_id', '=', 'courses.id')
                        ->where('courses.academic_year_id', $selectedYearId)
                        ->distinct('certification_user.course_id')
                        ->count('certification_user.course_id');
                    $completedCoursesCount = max($completedByStatus, $completedByCertification);
                } else {
                    $availableCourses = collect([]);
                    $totalAvailableCourses = 0;
                    $totalCoursesJoined = 0;
                    $completedCoursesCount = 0;
                }
                
                $activeCoursesCount = $myCourses->count();
                
                $earnedCertificates = $user->certifications()->with('users')->get();
                
                // Fetch Announcements (global or course specific - for now fetching all global)
                $announcements = Announcement::with('user')->orderBy('created_at', 'desc')->take(5)->get();

                // Fetch Calendar Events
                $calendarEvents = CalendarEvent::where('user_id', $user->id)
                    ->orderBy('start_time', 'asc')
                    ->get();

                // Add Course start and end dates as calendar events
                foreach ($myCourses as $course) {
                    if ($course->start_date) {
                        $calendarEvents->push(new CalendarEvent([
                            'title' => $course->name . ' (Starts)',
                            'start_time' => $course->start_date->startOfDay(),
                            'type' => 'class',
                        ]));
                    }
                    if ($course->end_date) {
                        $calendarEvents->push(new CalendarEvent([
                            'title' => $course->name . ' (Ends)',
                            'start_time' => $course->end_date->endOfDay(),
                            'type' => 'deadline',
                        ]));
                    }
                }

                // Fetch Notifications
                $notifications = Notification::where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->take(10)
                    ->get();
                $unreadNotificationsCount = Notification::where('user_id', $user->id)
                    ->where('is_read', false)
                    ->count();

                return view('trainee.dashboard', compact('myCourses', 'classroomCourses', 'pendingCourses', 'availableCourses', 'completedCoursesCount', 'activeCoursesCount', 'announcements', 'calendarEvents', 'notifications', 'unreadNotificationsCount', 'totalAvailableCourses', 'totalCoursesJoined', 'courseStatuses', 'forceProfile', 'pendingCoursesCount', 'earnedCertificates', 'progressData', 'academicYears', 'selectedYearId', 'selectedYear'));
            default:
                // Fallback for users without a role or unknown role
                return view('trainee.dashboard', compact('forceProfile')); 
        }
    }

    /**
     * Preview the Participant Dashboard for Coach/Trainer roles.
     */
    public function participantPreview(Request $request)
    {
        $user = Auth::user();
        $coachRoles = ['coach', 'trainer', 'central_office_coach', 'regional_office_coach', 'provincial_office_coach'];
        $visibleJoinedStatuses = ['active', 'in_progress', 'ready_for_exam', 'completed', 'failed', 'attempts_exhausted'];
        
        if (!in_array($user->role, $coachRoles, true)) {
            abort(403, 'Unauthorized access to participant preview.');
        }

        $forceProfile = !$user->profile_completed;
        
        // Simulate participant data for the coach
        // We can treat them as a generic participant/trainee for the preview
        $myCoachRoles = ['coach', 'trainer', 'central_office_coach', 'regional_office_coach', 'provincial_office_coach'];
        
        $myCourses = $user->courses()
            ->wherePivotIn('status', $visibleJoinedStatuses)
            ->where('courses.is_published', true)
            ->orderBy('courses.created_at', 'desc')
            ->with(['users' => function($q) use ($myCoachRoles) {
                $q->whereIn('role', $myCoachRoles);
            }, 'materials', 'assessments.grades' => function($q) use ($user) {
                $q->where('user_id', $user->id);
            }])
            ->get();

        $pendingCourses = $user->courses()
            ->wherePivot('status', 'pending')
            ->orderBy('courses.created_at', 'desc')
            ->with(['users' => function($q) use ($myCoachRoles) {
                $q->whereIn('role', $myCoachRoles);
            }])
            ->get();
            
        $pendingCoursesCount = $pendingCourses->count();
        $classroomCourses = $myCourses->concat($pendingCourses)->sortByDesc('created_at')->values();
        $courseStatuses = $user->courses()->pluck('course_user.status', 'courses.id')->toArray();

        $progressData = [];
        foreach ($classroomCourses as $course) {
            $progress = $course->getCourseProgress($user);
            $progress['total_modules'] = count($course->modules ?? []);
            $progressData[$course->id] = $progress;
        }

        // For coaches, show all published courses in the preview
        $excludedIds = array_map('intval', array_keys($courseStatuses));
        $availableCourses = Course::with(['users', 'trainer', 'submittedBy'])
            ->where('is_published', true);
        if (!empty($excludedIds)) {
            $availableCourses = $availableCourses->whereNotIn('id', $excludedIds);
        }
        $availableCourses = $availableCourses->orderBy('created_at', 'desc')->get();
        
        $totalAvailableCourses = $availableCourses->count();
        $totalCoursesJoined = $user->courses()->wherePivotIn('status', $visibleJoinedStatuses)->count();
        $completedCoursesCount = $user->courses()->wherePivot('status', 'completed')->count();
        $activeCoursesCount = $myCourses->count();
        $earnedCertificates = $user->certifications()->with('users')->get();
        $announcements = Announcement::with('user')->orderBy('created_at', 'desc')->take(5)->get();
        $calendarEvents = CalendarEvent::where('user_id', $user->id)->orderBy('start_time', 'asc')->get();

        foreach ($myCourses as $course) {
            if ($course->start_date) {
                $calendarEvents->push(new CalendarEvent([
                    'title' => $course->name . ' (Starts)',
                    'start_time' => $course->start_date->startOfDay(),
                    'type' => 'class',
                ]));
            }
            if ($course->end_date) {
                $calendarEvents->push(new CalendarEvent([
                    'title' => $course->name . ' (Ends)',
                    'start_time' => $course->end_date->endOfDay(),
                    'type' => 'deadline',
                ]));
            }
        }

        $notifications = Notification::where('user_id', $user->id)->orderBy('created_at', 'desc')->take(10)->get();
        $unreadNotificationsCount = Notification::where('user_id', $user->id)->where('is_read', false)->count();

        return view('trainee.dashboard', compact(
            'myCourses', 'classroomCourses', 'pendingCourses', 'availableCourses', 
            'completedCoursesCount', 'activeCoursesCount', 'announcements', 'calendarEvents', 
            'notifications', 'unreadNotificationsCount', 'totalAvailableCourses', 
            'totalCoursesJoined', 'courseStatuses', 'forceProfile', 'pendingCoursesCount', 
            'earnedCertificates', 'progressData'
        ));
    }

    // DILG Central Office: Bureaus list
    public function centralBureausJson()
    {
        try {
            if (\Schema::hasTable('bureaus')) {
                $rows = \DB::table('bureaus')
                    ->selectRaw("COALESCE(name, bureau_name) as name")
                    ->orderBy('name')
                    ->get();
                return response()->json($rows);
            }
            if (\Schema::hasTable('central_bureaus')) {
                $rows = \DB::table('central_bureaus')
                    ->selectRaw("COALESCE(name, bureau_name) as name")
                    ->orderBy('name')
                    ->get();
                return response()->json($rows);
            }
        } catch (\Throwable $e) {
            // continue to fallback
        }
        $fallback = [
            ['name' => 'Bureau of Local Government Development (BLGD)'],
            ['name' => 'Bureau of Local Government Supervision (BLGS)'],
            ['name' => 'Bureau of Fire Protection (BFP)'],
            ['name' => 'Bureau of Jail Management and Penology (BJMP)'],
            ['name' => 'National Police Commission (NAPOLCOM)'],
            ['name' => 'Philippine National Police (PNP)'],
            ['name' => 'National Barangay Operations Office (NBOO)'],
            ['name' => 'Office of Project Development Services (OPDS)'],
            ['name' => 'Public Affairs and Communication Service (PACS)'],
        ];
        return response()->json($fallback);
    }

    // DILG Central Office: Services list
    public function centralServicesJson()
    {
        try {
            if (\Schema::hasTable('services')) {
                $rows = \DB::table('services')
                    ->selectRaw("COALESCE(name, service_name) as name")
                    ->orderBy('name')
                    ->get();
                return response()->json($rows);
            }
            if (\Schema::hasTable('central_services')) {
                $rows = \DB::table('central_services')
                    ->selectRaw("COALESCE(name, service_name) as name")
                    ->orderBy('name')
                    ->get();
                return response()->json($rows);
            }
        } catch (\Throwable $e) {
            // continue to fallback
        }
        $fallback = [
            ['name' => 'Administrative Service'],
            ['name' => 'Financial and Management Service'],
            ['name' => 'Information Systems and Technology Management Service'],
            ['name' => 'Internal Audit Service'],
            ['name' => 'Legal Service'],
            ['name' => 'Planning Service'],
            ['name' => 'Policy and Performance Monitoring Service'],
            ['name' => 'Local Government Capability Development Division'],
        ];
        return response()->json($fallback);
    }
    public function updateUser(Request $request, User $user)
    {
        $actor = Auth::user();
        $tmRoles = ['training_manager','central_office_training_manager','regional_office_training_manager','provincial_office_training_manager'];
        $returnTab = (string) $request->input('return_tab', '');
        $redirectToDetails = $returnTab === 'user-details-section';
        
        if ($actor && (in_array($actor->role, $tmRoles) || $actor->role === 'registrar')) {
            if (!$actor->canUpdateUsers()) {
                abort(403, 'Unauthorized action.');
            }
            // Determine managed roles based on the actor's level
            $managedRoles = [];
            if ($actor->role === 'central_office_training_manager') {
                $managedRoles = ['central_office_admin', 'central_office_training_manager', 'central_office_coach', 'central_office_participants'];
            } elseif ($actor->role === 'regional_office_training_manager') {
                $managedRoles = ['regional_office_admin', 'regional_office_training_manager', 'regional_office_coach', 'regional_office_participants'];
            } elseif ($actor->role === 'provincial_office_training_manager') {
                $managedRoles = ['provincial_office_admin', 'provincial_office_training_manager', 'provincial_office_coach', 'provincial_office_participants'];
            } else {
                    $managedRoles = ['admin', 'training_manager', 'coach', 'trainer', 'participant'];
                }

            // Training Managers and Registrars may only change role and status
            $validated = $request->validate([
                'role' => 'required|string|in:' . implode(',', $managedRoles),
                'status' => 'required|string|in:active,freeze,pending',
            ]);

            // Check for status change to active
            $wasNotActive = $user->status !== 'active';
            $becomingActive = $validated['status'] === 'active';

            // Auto-generate Account ID if approving for the first time
            if ($becomingActive && empty($user->account_id)) {
                $validated['account_id'] = User::generateAccountId($validated['role'] ?? $user->role, $user->region);
            }

            $user->update($validated);

            // Send approval email if activated
            if ($wasNotActive && $becomingActive) {
                try {
                    Mail::to($user->email)->send(new AccountApproved($user));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Failed to send approval email to ' . $user->email . ': ' . $e->getMessage());
                }
            }

            $tab = $redirectToDetails ? 'user-details-section' : 'user-management';
            return redirect()->route('dashboard', ['tab' => $tab])->with('success_user', 'User role/status updated.');
        }

        $allowedRoles = Role::pluck('name')->toArray();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string|in:' . implode(',', $allowedRoles),
            'status' => 'required|string|in:active,freeze,pending',
            'region' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'barangay' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = bcrypt($request->password);
        } else {
            unset($validated['password']);
        }

        // Normalize location fields based on Office Level or Role group
        $officeLevel = (string) $request->input('office_level', '');
        $roleName = (string) $request->input('role', $user->role ?? '');
        $centralRoles = ['central_office_admin','central_office_training_manager','central_office_coach','central_office_participants'];
        $regionalRoles = ['regional_office_admin','regional_office_training_manager','regional_office_coach','regional_office_participants'];
        $provincialRoles = ['provincial_office_admin','provincial_office_training_manager','provincial_office_coach','provincial_office_participants'];
        $isCentral = in_array($roleName, $centralRoles, true) || $officeLevel === 'DILG Central Office';
        $isRegional = in_array($roleName, $regionalRoles, true) || $officeLevel === 'DILG Regional Office';
        $isProvincial = in_array($roleName, $provincialRoles, true) || $officeLevel === 'DILG Provincial Office';

        if ($isCentral) {
            // Enforce Central coding: region fixed label; province = Office Type; city = Unit/Service
            $validated['region'] = 'DILG Central Office';
            // province and city already mapped from UI, keep as-is if provided
            $validated['barangay'] = null;
        } elseif ($isRegional) {
            // Enforce Regional coding: region = selected region; clear others
            $validated['province'] = null;
            $validated['city'] = null;
            $validated['barangay'] = null;
        } elseif ($isProvincial) {
            // Keep province as selected "X Office"; clear city/barangay
            $validated['city'] = null;
            $validated['barangay'] = null;
        }

        // Check for status change to active
        $wasNotActive = $user->status !== 'active';
        $becomingActive = isset($validated['status']) && $validated['status'] === 'active';

        if ($becomingActive && empty($user->account_id)) {
            $validated['account_id'] = User::generateAccountId($validated['role'] ?? $user->role, $validated['region'] ?? $user->region);
        }

        $user->update($validated);

        // Update User Role Permissions
        $actor = Auth::user();
        if ($actor && in_array($actor->role, ['super_admin', 'admin'], true)) {
            $roleModel = \App\Models\Role::whereRaw('LOWER(name) = ?', [strtolower($user->role)])->first();
            if ($roleModel) {
                if ($request->has('permissions_data')) {
                    $checkedIds = json_decode($request->input('permissions_data'), true);
                    $allUiIds = json_decode($request->input('all_ui_permissions', '[]'), true);
                    
                    if (is_array($checkedIds) && is_array($allUiIds)) {
                        // Helper to resolve string names to IDs and filter valid IDs
                        $resolveToValidIds = function($ids) {
                            $numeric = array_filter($ids, 'is_numeric');
                            $strings = array_filter($ids, function($v) { return !is_numeric($v); });
                            $found = [];
                            if (!empty($strings)) {
                                $found = \App\Models\Permission::whereIn('name', $strings)->pluck('id')->toArray();
                            }
                            return array_unique(array_merge(array_map('intval', $numeric), $found));
                        };

                        $checkedIds = $resolveToValidIds($checkedIds);
                        $allUiIds = $resolveToValidIds($allUiIds);

                        // 1. Remove permissions that are in the UI list but NOT checked
                        $toRemove = array_diff($allUiIds, $checkedIds);
                        if (!empty($toRemove)) {
                            $roleModel->permissions()->detach($toRemove);
                        }
                        
                        // 2. Add permissions that are checked
                        if (!empty($checkedIds)) {
                            $roleModel->permissions()->syncWithoutDetaching($checkedIds);
                        }
                    }
                } else if ($request->has('permissions')) {
                    // Fallback to traditional multi-checkbox submit
                    $permIds = (array) $request->input('permissions', []);
                    $roleModel->permissions()->sync($permIds);
                }
            }
        }

        // Send approval email if activated
        if ($wasNotActive && $becomingActive) {
            try {
                Mail::to($user->email)->send(new AccountApproved($user));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to send approval email to ' . $user->email . ': ' . $e->getMessage());
            }
        }

        $tab = $redirectToDetails ? 'user-details-section' : 'user-management';
        return redirect()->route('dashboard', ['tab' => $tab])->with('success_user', 'User updated successfully.');
    }

    public function convertRegistrarToTrainingManager(Request $request, User $user)
    {
        $actor = Auth::user();
        if (!$actor || !in_array($actor->role, ['admin','super_admin'])) {
            abort(403);
        }
        if ($user->role !== 'registrar') {
            return redirect()->back()->with('error_user', 'Only registrar accounts can be converted.');
        }
        $request->validate([
            'confirm' => 'required|in:yes',
        ]);
        if ($user->status !== 'active') {
            return redirect()->back()->with('error_user', 'User must be active to convert.');
        }
        if (!$user->profile_completed) {
            return redirect()->back()->with('error_user', 'User must complete their profile before conversion.');
        }
        \DB::beginTransaction();
        try {
            $from = $user->role;
            $user->role = 'training_manager';
            $user->save();
            \App\Models\RoleChangeAudit::create([
                'user_id' => $user->id,
                'actor_id' => $actor->id,
                'from_role' => $from,
                'to_role' => 'training_manager',
                'meta_json' => json_encode(['ip' => $request->ip()]),
            ]);
            foreach (\App\Models\User::where('role','admin')->get() as $admin) {
                \App\Models\Notification::create([
                    'user_id' => $admin->id,
                    'title' => 'Role Change',
                    'message' => "{$user->name} has been converted from Registrar to Training Manager.",
                    'type' => 'role_change',
                    'related_id' => $user->id,
                    'link' => route('dashboard', ['tab' => 'user-management', 'search' => $user->name]),
                ]);
            }
            \App\Models\Notification::create([
                'user_id' => $user->id,
                'title' => 'Role Updated',
                'message' => "Your account has been converted to Training Manager.",
                'type' => 'role_change',
                'related_id' => $user->id,
                'link' => route('dashboard', ['tab' => 'user-management']),
            ]);
            \DB::commit();
            return redirect()->route('dashboard', ['tab' => 'user-management'])->with('success_user', 'Registrar converted to Training Manager.');
        } catch (\Throwable $e) {
            \DB::rollBack();
            return redirect()->back()->with('error_user', 'Conversion failed: '.$e->getMessage());
        }
    }

    public function rollbackTrainingManager(Request $request, User $user)
    {
        $actor = Auth::user();
        if (!$actor || !in_array($actor->role, ['admin','super_admin'])) {
            abort(403);
        }
        $last = \App\Models\RoleChangeAudit::where('user_id',$user->id)->orderBy('id','desc')->first();
        if (!$last || $last->to_role !== 'training_manager' || $last->from_role !== 'registrar') {
            return redirect()->back()->with('error_user', 'No registrar→training_manager change found to rollback.');
        }
        \DB::beginTransaction();
        try {
            $user->role = 'registrar';
            $user->save();
            \App\Models\RoleChangeAudit::create([
                'user_id' => $user->id,
                'actor_id' => $actor->id,
                'from_role' => 'training_manager',
                'to_role' => 'registrar',
                'meta_json' => json_encode(['rollback_of' => $last->id, 'ip' => $request->ip()]),
            ]);
            \DB::commit();
            return redirect()->route('dashboard', ['tab' => 'user-management'])->with('success_user', 'Role rollback to Registrar completed.');
        } catch (\Throwable $e) {
            \DB::rollBack();
            return redirect()->back()->with('error_user', 'Rollback failed: '.$e->getMessage());
        }
    }

    public function updateDisplayDetails(Request $request, User $user)
    {
        if ($request->has('remove_display')) {
            $user->display_type = null;
            $user->save();
            return redirect()->route('dashboard', ['tab' => 'user-management'])->with('success_user', 'User removed from landing page display.');
        }

        $request->validate([
            'additional_details' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            'display_type' => 'nullable|in:our_team,past_trainees',
        ]);

        $user->additional_details = $request->additional_details;
        $user->display_type = $request->display_type;

        if ($request->hasFile('profile_picture')) {
            try {
                $user->setAvatarFromUpload($request->file('profile_picture'));
            } catch (\Throwable $e) {
                return redirect()->route('dashboard', ['tab' => 'user-management'])->with('error_user', 'Failed to save profile image.');
            }
        }

        $user->save();

        return redirect()->route('dashboard', ['tab' => 'user-management'])->with('success_user', 'Landing page display details updated successfully.');
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return redirect()->route('dashboard', ['tab' => 'user-management'])->with('success_user', 'User deleted successfully.');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'region' => 'nullable|string',
            'province' => 'nullable|string',
            'city' => 'nullable|string',
            'barangay' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            'password' => 'nullable|confirmed|min:8',
            'profile_picture_cropped' => 'nullable|string',
        ]);

        if ($request->filled('profile_picture_cropped')) {
            try {
                $user->setAvatarFromDataUrl($request->input('profile_picture_cropped'));
            } catch (\Throwable $e) {
                return redirect()->back()->withErrors(['profile_picture' => 'Failed to save profile image. Please try again.']);
            }
        } elseif ($request->hasFile('profile_picture')) {
            try {
                $user->setAvatarFromUpload($request->file('profile_picture'));
            } catch (\Throwable $e) {
                return redirect()->back()->withErrors(['profile_picture' => 'Failed to save profile image. Please try again.']);
            }
            unset($validated['profile_picture']); // Don't try to update this via fill
        }

        if ($request->filled('password')) {
            $validated['password'] = bcrypt($request->password);
        } else {
            unset($validated['password']);
        }

        // Normalize location by office grouping (match Edit User rules)
        $roleName = (string) ($user->role ?? '');
        $centralRoles = ['central_office_admin','central_office_training_manager','central_office_coach','central_office_participants'];
        $regionalRoles = ['regional_office_admin','regional_office_training_manager','regional_office_coach','regional_office_participants'];
        $provincialRoles = ['provincial_office_admin','provincial_office_training_manager','provincial_office_coach','provincial_office_participants'];
        $isCentral = in_array($roleName, $centralRoles, true) || ($validated['region'] ?? '') === 'DILG Central Office';
        $isRegional = in_array($roleName, $regionalRoles, true) || ($validated['region'] ?? '') === 'DILG Regional Office';
        $isProvincial = in_array($roleName, $provincialRoles, true) || ($validated['region'] ?? '') === 'DILG Provincial Office';

        if ($isCentral) {
            $validated['region'] = 'DILG Central Office';
            $validated['barangay'] = null;
        } elseif ($isRegional) {
            $validated['province'] = null;
            $validated['city'] = null;
            $validated['barangay'] = null;
        } elseif ($isProvincial) {
            $validated['city'] = null;
            $validated['barangay'] = null;
        }

        $user->fill($validated);
        if (!$user->profile_completed) {
            $user->profile_completed = true;
            $user->profile_completed_at = now();
        }
        $user->save();

        return redirect()->route('dashboard', ['tab' => 'profile-section'])->with('success_profile', 'Profile updated successfully.');
    }

    public function setupProfile(Request $request)
    {
        $user = Auth::user();
        $hasCompletedOnboardingProfile = $user->hasCompletedOnboardingProfile();

        if ($user->status === 'pending' && !$hasCompletedOnboardingProfile && $user->profile_completed) {
            $user->profile_completed = false;
            $user->profile_completed_at = null;
            $user->save();
        }

        $fullNameParsed = trim($user->name ?? '');
        $tokens = $fullNameParsed !== '' ? preg_split('/\s+/', $fullNameParsed) : [];
        $firstParsed = $tokens[0] ?? '';
        $lastParsed = count($tokens) > 1 ? $tokens[count($tokens) - 1] : '';
        $middleParsed = count($tokens) > 2 ? implode(' ', array_slice($tokens, 1, -1)) : '';

        if (!$user->profile_completed || !$hasCompletedOnboardingProfile) {
            $isReviewMode = false;
            return view('auth.create-account', compact('user', 'firstParsed', 'middleParsed', 'lastParsed', 'isReviewMode'));
        }

        if ($user->status === 'pending') {
            $isReviewMode = true;
            return view('auth.create-account', compact('user', 'firstParsed', 'middleParsed', 'lastParsed', 'isReviewMode'));
        }

        if ($request->routeIs('create-account')) {
            if ($user->status === 'active') {
                return redirect()->route('dashboard', ['tab' => 'profile-section']);
            }

            if ($user->status === 'pending') {
                return redirect()->route('pending.approval');
            }
        }

        $notifications = Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get();

        return view('profile.setup', compact('notifications'));
    }

    public function publicProfile(User $user)
    {
        return view('profile.public', compact('user'));
    }

    public function storeProfileSetup(Request $request)
    {
        $user = Auth::user();
        $wasProfileCompleted = (bool) $user->profile_completed;
        $isOnboarding = !$wasProfileCompleted;
        $agency = $request->input('agency');
        $section = $request->input('section', 'info');
        if ($section === 'password') {
            if ($isOnboarding) {
                return redirect()->route('create-account');
            }
            $validated = $request->validate([
                'current_password' => 'required|string',
                'password' => 'required|confirmed|min:8',
            ]);
            if (!Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.'])->withInput();
            }
            $user->password = Hash::make($validated['password']);
            $user->save();
            return redirect()->back()->with('success_profile', 'Password updated successfully.');
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'mobile_number' => 'required|string|max:20',
            'gender' => $isOnboarding ? 'required|string|in:Male,Female,Prefer not to say' : 'nullable|string|in:Male,Female,Prefer not to say',
            'region' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'city' => ($isOnboarding && $agency === 'LGU') ? 'required|string|max:255' : 'nullable|string|max:255',
            'barangay' => ($isOnboarding && $agency === 'LGU') ? 'required|string|max:255' : 'nullable|string|max:255',
            'agency' => $isOnboarding ? 'required|string|in:DILG,LGU' : 'nullable|string|in:DILG,LGU',
            'field_of_work' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            'profile_picture_cropped' => 'nullable|string',
        ]);

        if ($request->input('agency') === 'LGU' && (!$request->filled('city') || !$request->filled('barangay'))) {
            return back()->withErrors(['city' => 'City and Barangay are required for LGU accounts.'])->withInput();
        }

        if ($request->input('agency') === 'DILG') {
            $validated['barangay'] = null;
        }

        if ($request->filled('profile_picture_cropped')) {
            $data = $request->input('profile_picture_cropped');
            if ($user->profile_picture) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->profile_picture);
            }
            if (preg_match('/^data:image\\/(png|jpeg);base64,/', $data, $m)) {
                $data = substr($data, strpos($data, ',') + 1);
                $bin = base64_decode($data);
                $ext = $m[1] === 'jpeg' ? 'jpg' : 'png';
                $path = 'profile_pictures/' . Str::uuid() . '.' . $ext;
                \Illuminate\Support\Facades\Storage::disk('public')->put($path, $bin);
                $user->profile_picture = $path;
            }
        } elseif ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->profile_picture);
            }
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        // Build full name from parts
        $fullName = trim(implode(' ', array_filter([
            $validated['first_name'],
            $validated['middle_name'] ?? null,
            $validated['last_name'],
        ])));
        $validated['name'] = $fullName;
        unset($validated['first_name'], $validated['middle_name'], $validated['last_name']);

        $user->fill($validated);
        if ($isOnboarding) {
            $user->role = null;
            $user->status = 'pending';
        }
        if (!$user->profile_completed) {
            $user->profile_completed = true;
            $user->profile_completed_at = now();
        }
        $user->save();

        if ($user->status === 'pending') {
            User::notifyRegistrarsAboutNewUser($user);
            return redirect()->route('pending.approval')->with('success_pending_approval', 'Profile setup complete! Your account is now pending approval.');
        }

        if (!$wasProfileCompleted) {
            $request->session()->flash('success_profile', 'Profile completed successfully.');
            return redirect()->route('dashboard', ['tab' => 'profile-section']);
        }

        return redirect()->route('dashboard', ['tab' => 'profile-section'])->with('success_profile', 'Profile updated successfully.');
    }

    public function pendingApproval()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        if (!$user->profile_completed || !$user->hasCompletedOnboardingProfile()) {
            return redirect()->route('create-account')->with('profile_required', true);
        }

        if ($user->status === 'active') {
            return redirect()->route('dashboard');
        }

        return view('auth.pending-approval');
    }

    public function markNotificationAsRead(Notification $notification)
    {
        $notification->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }

    public function markAllNotificationsAsRead()
    {
        Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }

    public function courseTrainees(\App\Models\Course $course)
    {
        $actor = Auth::user();
        $scopedParticipantRoles = [];
        if ($actor && $actor->role === 'central_office_coach') {
            $scopedParticipantRoles = ['central_office_participants'];
        } elseif ($actor && $actor->role === 'regional_office_coach') {
            $scopedParticipantRoles = ['regional_office_participants'];
        } elseif ($actor && $actor->role === 'provincial_office_coach') {
            $scopedParticipantRoles = ['provincial_office_participants'];
        } else {
            $scopedParticipantRoles = ['participant','trainee'];
        }
        $trainees = $course->users()
            ->whereIn('role', $scopedParticipantRoles)
            ->wherePivot('status', 'active')
            ->select('users.id', 'users.name', 'users.role')
            ->orderBy('users.name')
            ->get();
        return response()->json(['trainees' => $trainees]);
    }
    
    public function userCountsByProvince()
    {
        $counts = User::selectRaw('LOWER(TRIM(COALESCE(province,""))) as province, COUNT(*) as c')
            ->groupBy('province')
            ->pluck('c', 'province');
        return response()->json(['counts' => $counts]);
    }

    public function userCountsByRegion()
    {
        $counts = User::selectRaw('LOWER(TRIM(COALESCE(region,""))) as region, COUNT(*) as c')
            ->groupBy('region')
            ->pluck('c', 'region');
        return response()->json(['counts' => $counts]);
    }

    public function userGenderCountsByRegion()
    {
        $rows = User::selectRaw('LOWER(TRIM(COALESCE(region,""))) as region, LOWER(TRIM(COALESCE(gender,""))) as gender, COUNT(*) as c')
            ->groupBy('region', 'gender')
            ->get();
        $out = [];
        foreach ($rows as $row) {
            $region = $row->region ?? '';
            $g = $row->gender ?? '';
            if (!isset($out[$region])) {
                $out[$region] = [
                    'male_count' => 0,
                    'female_count' => 0,
                    'prefer_not_to_say_count' => 0,
                    'unknown_count' => 0,
                ];
            }
            if ($g === 'male') {
                $out[$region]['male_count'] += (int) $row->c;
            } elseif ($g === 'female') {
                $out[$region]['female_count'] += (int) $row->c;
            } elseif (in_array($g, ['prefer not to say', 'prefer_not_to_say', 'prefer-not-to-say'], true)) {
                $out[$region]['prefer_not_to_say_count'] += (int) $row->c;
            } elseif ($g !== '') {
                $out[$region]['unknown_count'] += (int) $row->c;
            }
        }
        return response()->json(['gender_counts' => $out]);
    }

    public function userGenderCountsByProvince()
    {
        $rows = User::selectRaw('LOWER(TRIM(COALESCE(province,""))) as province, LOWER(TRIM(COALESCE(gender,""))) as gender, COUNT(*) as c')
            ->groupBy('province', 'gender')
            ->get();
        $out = [];
        foreach ($rows as $row) {
            $province = $row->province ?? '';
            $g = $row->gender ?? '';
            if (!isset($out[$province])) {
                $out[$province] = [
                    'male_count' => 0,
                    'female_count' => 0,
                    'prefer_not_to_say_count' => 0,
                    'unknown_count' => 0,
                ];
            }
            if ($g === 'male') {
                $out[$province]['male_count'] += (int) $row->c;
            } elseif ($g === 'female') {
                $out[$province]['female_count'] += (int) $row->c;
            } elseif (in_array($g, ['prefer not to say', 'prefer_not_to_say', 'prefer-not-to-say'], true)) {
                $out[$province]['prefer_not_to_say_count'] += (int) $row->c;
            } elseif ($g !== '') {
                $out[$province]['unknown_count'] += (int) $row->c;
            }
        }
        return response()->json(['gender_counts' => $out]);
    }

    public function regionAnalytics()
    {
        $usersByRegion = User::selectRaw('LOWER(TRIM(COALESCE(region,""))) as region, COUNT(*) as c')
            ->groupBy('region')
            ->pluck('c', 'region');
        $certsByRegion = \Illuminate\Support\Facades\Schema::hasTable('certification_user')
            ? \DB::table('certification_user')
                ->join('users', 'certification_user.user_id', '=', 'users.id')
                ->selectRaw('LOWER(TRIM(COALESCE(users.region,""))) as region, COUNT(*) as c')
                ->groupBy('region')
                ->pluck('c', 'region')
            : collect();
        $completionsByRegion = \Illuminate\Support\Facades\Schema::hasTable('course_user')
            ? \DB::table('course_user')
                ->join('users', 'course_user.user_id', '=', 'users.id')
                ->selectRaw('LOWER(TRIM(COALESCE(users.region,""))) as region, COUNT(*) as c')
                ->whereIn('course_user.status', ['completed', 'finished', 'done'])
                ->groupBy('region')
                ->pluck('c', 'region')
            : collect();
        $out = [];
        $keys = array_unique(array_merge(array_keys($usersByRegion->toArray()), array_keys($certsByRegion->toArray()), array_keys($completionsByRegion->toArray())));
        foreach ($keys as $r) {
            $out[$r] = [
                'users' => (int) ($usersByRegion[$r] ?? 0),
                'courses_completed' => (int) ($completionsByRegion[$r] ?? 0),
                'certs_issued' => (int) ($certsByRegion[$r] ?? 0),
            ];
        }
        return response()->json(['analytics' => $out]);
    }

    public function provinceAnalytics()
    {
        $usersByProvince = User::selectRaw('LOWER(TRIM(COALESCE(province,""))) as province, COUNT(*) as c')
            ->groupBy('province')
            ->pluck('c', 'province');
        $certsByProvince = \Illuminate\Support\Facades\Schema::hasTable('certification_user')
            ? \DB::table('certification_user')
                ->join('users', 'certification_user.user_id', '=', 'users.id')
                ->selectRaw('LOWER(TRIM(COALESCE(users.province,""))) as province, COUNT(*) as c')
                ->groupBy('province')
                ->pluck('c', 'province')
            : collect();
        $completionsByProvince = \Illuminate\Support\Facades\Schema::hasTable('course_user')
            ? \DB::table('course_user')
                ->join('users', 'course_user.user_id', '=', 'users.id')
                ->selectRaw('LOWER(TRIM(COALESCE(users.province,""))) as province, COUNT(*) as c')
                ->whereIn('course_user.status', ['completed', 'finished', 'done'])
                ->groupBy('province')
                ->pluck('c', 'province')
            : collect();
        $out = [];
        $keys = array_unique(array_merge(
            array_keys($usersByProvince->toArray()),
            array_keys($certsByProvince->toArray()),
            array_keys($completionsByProvince->toArray())
        ));
        foreach ($keys as $province) {
            $out[$province] = [
                'users' => (int) ($usersByProvince[$province] ?? 0),
                'courses_completed' => (int) ($completionsByProvince[$province] ?? 0),
                'certs_issued' => (int) ($certsByProvince[$province] ?? 0),
            ];
        }
        return response()->json(['analytics' => $out]);
    }

    public function monthlyGrowth()
    {
        $months = [];
        $regs = [];
        $comps = [];
        $certs = [];
        for ($i = 11; $i >= 0; $i--) {
            $m = \Carbon\Carbon::now()->subMonths($i);
            $months[] = $m->format('M');
            $start = $m->copy()->startOfMonth();
            $end = $m->copy()->endOfMonth();
            $regs[] = User::whereBetween('created_at', [$start, $end])->count();
            if (\Illuminate\Support\Facades\Schema::hasTable('course_user')) {
                $comps[] = \DB::table('course_user')->whereBetween('updated_at', [$start, $end])->whereIn('status', ['completed', 'finished', 'done'])->count();
            } else {
                $comps[] = 0;
            }
            if (\Illuminate\Support\Facades\Schema::hasTable('certification_user')) {
                $certs[] = \DB::table('certification_user')->whereBetween('issued_at', [$start, $end])->count();
            } else {
                $certs[] = 0;
            }
        }
        return response()->json(['months' => $months, 'registrations' => $regs, 'completions' => $comps, 'certificates' => $certs]);
    }

    public function importLocationMaster(Request $request)
    {
        @set_time_limit(300);
        $request->validate([
            'psgc_file' => 'required|file',
        ]);
        $file = $request->file('psgc_file');
        $path = $file->getRealPath();
        $ext = strtolower(pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION));
        $rows = [];
        if (in_array($ext, ['csv', 'txt'])) {
            $fh = fopen($path, 'r');
            if (!$fh) {
                return response()->json(['ok' => false, 'error' => 'Cannot open file'], 422);
            }
            $header = fgetcsv($fh);
            if (!$header) {
                return response()->json(['ok' => false, 'error' => 'Empty file'], 422);
            }
            $rows[] = $header;
            while (($r = fgetcsv($fh)) !== false) {
                $rows[] = $r;
            }
            fclose($fh);
        } elseif (in_array($ext, ['xlsx'])) {
            $rows = $this->parseXlsxToRows($path);
            if (!$rows || !is_array($rows) || count($rows) < 2) {
                return response()->json(['ok' => false, 'error' => 'Unable to read Excel file'], 422);
            }
        } else {
            return response()->json(['ok' => false, 'error' => 'Unsupported file type'], 422);
        }

        $header = $rows[0];
        $norm = function($s){
            $s = strtolower(trim((string)$s));
            $s = str_replace(['/', '-', ' '], '_', $s);
            return $s;
        };
        $canonical = function(string $name): string {
            $n = trim($name);
            $ln = strtolower($n);
            if (in_array($ln, ['baguio city','city of baguio','baguio'], true)) {
                return 'City of Baguio';
            }
            return $n;
        };
        $cols = array_map($norm, $header);
        $iRegionCode = array_search('region_code', $cols);
        $iRegionName = array_search('region_name', $cols);
        if ($iRegionName === false) $iRegionName = array_search('region', $cols);
        $iProvinceCode = array_search('province_code', $cols);
        $iProvinceName = array_search('province_name', $cols);
        if ($iProvinceName === false) $iProvinceName = array_search('province', $cols);
        $iCityCode = array_search('city_code', $cols);
        $iCityName = array_search('city_munacipility', $cols);
        if ($iCityName === false) $iCityName = array_search('city_municipality', $cols);
        if ($iCityName === false) $iCityName = array_search('city', $cols);
        if ($iCityName === false) $iCityName = array_search('municipality', $cols);
        $iBarangayCode = array_search('barangay_code', $cols);
        $iBarangayName = array_search('barangay_name', $cols);
        if ($iBarangayName === false) $iBarangayName = array_search('barangay', $cols);
        if ($iRegionName === false) {
            return response()->json(['ok' => false, 'error' => 'Missing region header'], 422);
        }
        $regionsInserted = 0;
        $provincesInserted = 0;
        $citiesInserted = 0;
        $barangaysInserted = 0;
        $makeCode = function($name){
            $h = sha1(strtolower(trim((string)$name)));
            return strtoupper(substr($h, 0, 10));
        };
        $mode = strtolower(trim((string)($request->input('mode','insert_update'))));
        if (!in_array($mode, ['insert_only','insert_update','replace_all'], true)) {
            $mode = 'insert_update';
        }
        $totalRows = max(0, count($rows) - 1);
        $inserted = 0;
        $updated = 0;
        $skipped = 0;
        $errors = 0;

        \DB::beginTransaction();
        try {
            if ($mode === 'replace_all') {
                \DB::table('barangays')->delete();
                \DB::table('cities')->delete();
                \DB::table('provinces')->delete();
                \DB::table('regions')->delete();
            }
            $existingCombos = [];
            if ($mode !== 'replace_all') {
                $ex = \DB::table('barangays as b')
                    ->join('cities as c', 'b.city_id', '=', 'c.id')
                    ->join('provinces as p', 'c.province_id', '=', 'p.id')
                    ->join('regions as r', 'p.region_id', '=', 'r.id')
                    ->selectRaw('UPPER(r.region_name) as region, UPPER(p.province_name) as province, UPPER(c.city_name) as city, UPPER(b.barangay_name) as barangay')
                    ->get();
                foreach ($ex as $row) {
                    $key = "{$row->region}|{$row->province}|{$row->city}|{$row->barangay}";
                    $existingCombos[$key] = true;
                }
            }
            $regionSet = [];
            $provinceSet = [];
            $citySet = [];
            $barangaySet = [];
            for ($ri = 1; $ri < count($rows); $ri++) {
                $row = $rows[$ri];
                $regionName = $iRegionName !== false && isset($row[$iRegionName]) ? trim($row[$iRegionName]) : '';
                $regionCode = $iRegionCode !== false && isset($row[$iRegionCode]) ? trim($row[$iRegionCode]) : '';
                if (!$regionCode && $regionName) $regionCode = $makeCode($regionName);
                $regionNameU = strtoupper($regionName);
                if ($regionNameU) {
                    $regionSet[$regionCode] = ['region_code' => $regionCode, 'region_name' => $regionNameU, 'created_at' => now(), 'updated_at' => now()];
                }
                $provName = $iProvinceName !== false && isset($row[$iProvinceName]) ? trim($row[$iProvinceName]) : '';
                $provCode = $iProvinceCode !== false && isset($row[$iProvinceCode]) ? trim($row[$iProvinceCode]) : '';
                if (!$provCode && $provName) $provCode = $makeCode($provName);
                $provNameU = strtoupper($canonical($provName));
                if ($provNameU && $regionCode) {
                    $provinceSet[$provCode] = ['province_code' => $provCode, 'province_name' => $provNameU, 'region_code' => $regionCode, 'created_at' => now(), 'updated_at' => now()];
                }
                $cityName = $iCityName !== false && isset($row[$iCityName]) ? trim($row[$iCityName]) : '';
                $cityCode = $iCityCode !== false && isset($row[$iCityCode]) ? trim($row[$iCityCode]) : '';
                if (!$cityCode && $cityName) $cityCode = $makeCode($cityName);
                $cityNameU = strtoupper($canonical($cityName));
                if ($cityNameU && $provCode) {
                    // Special instruction: if city is City of Baguio, set province also to City of Baguio
                    if ($cityNameU === 'CITY OF BAGUIO') {
                        $provinceSet[$provCode] = ['province_code' => $provCode, 'province_name' => 'CITY OF BAGUIO', 'region_code' => $regionCode, 'created_at' => now(), 'updated_at' => now()];
                    }
                    $citySet[$cityCode] = ['city_code' => $cityCode, 'city_name' => $cityNameU, 'province_code' => $provCode, 'created_at' => now(), 'updated_at' => now()];
                }
                $barangayName = $iBarangayName !== false && isset($row[$iBarangayName]) ? trim($row[$iBarangayName]) : '';
                $barangayCode = $iBarangayCode !== false && isset($row[$iBarangayCode]) ? trim($row[$iBarangayCode]) : '';
                if (!$barangayCode && $barangayName) $barangayCode = $makeCode($barangayName);
                $barangayNameU = strtoupper($barangayName);
                if ($barangayNameU && $cityCode) {
                    $key = "{$regionNameU}|{$provNameU}|{$cityNameU}|{$barangayNameU}";
                    if ($mode === 'insert_only' && isset($existingCombos[$key])) {
                        $skipped++;
                        continue;
                    } elseif ($mode === 'insert_update' && isset($existingCombos[$key])) {
                        $updated++;
                    } else {
                        $inserted++;
                    }
                    $barangaySet[$barangayCode ?: $barangayNameU] = ['barangay_code' => $barangayCode, 'barangay_name' => $barangayNameU, 'city_code' => $cityCode, 'created_at' => now(), 'updated_at' => now()];
                }
            }
            if (!empty($regionSet)) {
                $chunks = array_chunk(array_values($regionSet), 1000);
                foreach ($chunks as $chunk) {
                    \DB::table('regions')->upsert($chunk, ['region_code'], ['region_name','updated_at']);
                }
                $regionsInserted = count($regionSet);
            }
            $regionIds = \DB::table('regions')->whereIn('region_code', array_keys($regionSet))->pluck('id','region_code')->toArray();
            $provinceRows = [];
            foreach ($provinceSet as $pc => $p) {
                $rid = $regionIds[$p['region_code']] ?? null;
                if ($rid) {
                    $provinceRows[] = ['province_code' => $p['province_code'], 'province_name' => $p['province_name'], 'region_id' => $rid, 'created_at' => $p['created_at'], 'updated_at' => $p['updated_at']];
                }
            }
            if (!empty($provinceRows)) {
                $chunks = array_chunk($provinceRows, 1000);
                foreach ($chunks as $chunk) {
                    \DB::table('provinces')->upsert($chunk, ['province_code'], ['province_name','region_id','updated_at']);
                }
                $provincesInserted = count($provinceRows);
            }
            $provinceIds = \DB::table('provinces')->whereIn('province_code', array_column($provinceRows, 'province_code'))->pluck('id','province_code')->toArray();
            $cityRows = [];
            foreach ($citySet as $cc => $c) {
                $pid = $provinceIds[$c['province_code']] ?? null;
                if ($pid) {
                    $cityRows[] = ['city_code' => $c['city_code'], 'city_name' => $c['city_name'], 'province_id' => $pid, 'created_at' => $c['created_at'], 'updated_at' => $c['updated_at']];
                }
            }
            if (!empty($cityRows)) {
                $chunks = array_chunk($cityRows, 1000);
                foreach ($chunks as $chunk) {
                    \DB::table('cities')->upsert($chunk, ['city_code'], ['city_name','province_id','updated_at']);
                }
                $citiesInserted = count($cityRows);
            }
            $cityIds = \DB::table('cities')->whereIn('city_code', array_column($cityRows, 'city_code'))->pluck('id','city_code')->toArray();
            $barangayRows = [];
            foreach ($barangaySet as $bk => $b) {
                $cid = $cityIds[$b['city_code']] ?? null;
                if ($cid) {
                    $barangayRows[] = ['barangay_code' => $b['barangay_code'], 'barangay_name' => $b['barangay_name'], 'city_id' => $cid, 'created_at' => $b['created_at'], 'updated_at' => $b['updated_at']];
                }
            }
            if (!empty($barangayRows)) {
                $chunks = array_chunk($barangayRows, 1000);
                foreach ($chunks as $chunk) {
                    \DB::table('barangays')->upsert($chunk, ['barangay_code'], ['barangay_name','city_id','updated_at']);
                }
                $barangaysInserted = count($barangayRows);
            }
            $baguioCityId = \DB::table('cities')->where('city_name', 'City of Baguio')->value('id');
            if (!$baguioCityId) {
                $baguioProvinceId = \DB::table('provinces')->where('province_name', 'City of Baguio')->value('id');
                if ($baguioProvinceId) {
                    $baguioCityId = \DB::table('cities')->insertGetId(['province_id' => $baguioProvinceId, 'city_code' => $makeCode('City of Baguio'), 'city_name' => 'City of Baguio', 'created_at' => now(), 'updated_at' => now()]);
                }
            }
            if ($baguioCityId) {
                $baguioList = [
                    'APUGAN-LOAKAN','ASIN ROAD','ATOK TRAIL','BAKAKENG CENTRAL','BAKAKENG NORTH','HAPPY HOLLOW','BALSIGAN','BAYAN PARK WEST','BAYAN PARK EAST','BROOKSPOINT','BROOKSIDE','CABINET HILL-TEACHER\'S CAMP','CAMP ALLEN','CAMP 7','CAMP 8','CAMPO FILIPINO','CITY CAMP CENTRAL','CITY CAMP PROPER','COUNTRY CLUB VILLAGE','CRESENCIA VILLAGE','DAGSIAN, UPPER','DPS AREA','DIZON SUBDIVISION','QUIRINO HILL, EAST','ENGINEERS\' HILL','FAIRVIEW VILLAGE','FORT DEL PILAR','GENERAL LUNA, UPPER','GENERAL LUNA, LOWER','GIBRALTAR','GREENWATER VILLAGE','GUISAD CENTRAL','GUISAD SORONG','HILLSIDE','HOLY GHOST EXTENSION','HOLY GHOST PROPER','IMELDA VILLAGE','IRISAN','KAYANG EXTENSION','KIAS','KAGITINGAN','LOAKAN PROPER','LOPEZ JAENA','LOURDES SUBDIVISION EXTENSION','DAGSIAN, LOWER','LOURDES SUBDIVISION, LOWER','QUIRINO HILL, LOWER','GENERAL EMILIO F. AGUINALDO','LUALHATI','LUCNAB','MAGSAYSAY, LOWER','MAGSAYSAY PRIVATE ROAD','AURORA HILL PROPER','BAL-MARCOVILLE','QUIRINO HILL, MIDDLE','MILITARY CUT-OFF','MINES VIEW PARK','MODERN SITE, EAST','MODERN SITE, WEST','NEW LUCBAN','AURORA HILL, NORTH CENTRAL','SANITARY CAMP, NORTH','OUTLOOK DRIVE','PACDAL','PINGET','PINSAO PILOT PROJECT','PINSAO PROPER','POLIWES','PUCSUSAN','MRR-QUEEN OF PEACE','ROCK QUARRY, LOWER','SALUD MITRA','SAN ANTONIO VILLAGE','SAN LUIS VILLAGE','SAN ROQUE VILLAGE','SAN VICENTE','SANTA ESCOLASTICA','SANTO ROSARIO','SANTO TOMAS SCHOOL AREA','SANTO TOMAS PROPER','SCOUT BARRIO','SESSION ROAD AREA','SLAUGHTER HOUSE AREA','SANITARY CAMP, SOUTH','SAINT JOSEPH VILLAGE','TEODORA ALONZO','TRANCOVILLE','ROCK QUARRY, UPPER','VICTORIA VILLAGE','QUIRINO HILL, WEST','ANDRES BONIFACIO','LEGARDA-BURNHAM-KISAD','IMELDA R. MARCOS','LOURDES SUBDIVISION, PROPER','QUIRINO-MAGSAYSAY, UPPER','A. BONIFACIO-CAGUIOA-RIMANDO','AMBIONG','AURORA HILL, SOUTH CENTRAL','ABANAO-ZANDUETA-KAYONG-CHUGUM-OTEK','BAGONG LIPUNAN','BGH COMPOUND','BAYAN PARK VILLAGE','CAMDAS SUBDIVISION','PALMA-URBANO','DOMINICAN HILL-MIRADOR','ALFONSO TABORA','DONTOGAN','FERDINAND','HAPPY HOMES','HARRISON-CLAUDIO CARANTES','HONEYMOON','KABAYANIHAN','KAYANG-HILLTOP','GABRIELA SILANG','LIWANAG-LOAKAN','MALCOLM SQUARE-PERFECTO','MANUEL A. ROXAS','PADRE BURGOS','QUEZON HILL, UPPER','ROCK QUARRY, MIDDLE','PHIL-AM','QUEZON HILL PROPER','MIDDLE QUEZON HILL SUBDIVISION','RIZAL MONUMENT AREA','SLU-SVP HOUSING VILLAGE','SOUTH DRIVE','MAGSAYSAY, UPPER','MARKET SUBDIVISION, UPPER','PADRE ZAMORA'
                ];
                foreach ($baguioList as $bn) {
                    $exists = \DB::table('barangays')->where('barangay_name', $bn)->first();
                    if ($exists) {
                        if ($exists->city_id != $baguioCityId) {
                            \DB::table('barangays')->where('id', $exists->id)->update(['city_id' => $baguioCityId, 'updated_at' => now()]);
                        }
                    } else {
                        \DB::table('barangays')->insert(['city_id' => $baguioCityId, 'barangay_code' => $makeCode($bn), 'barangay_name' => $bn, 'created_at' => now(), 'updated_at' => now()]);
                        $inserted++;
                    }
                }
            }
            \DB::commit();
        } catch (\Throwable $e) {
            \DB::rollBack();
            \Log::error('Location import failed', ['msg' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['ok' => false, 'error' => $e->getMessage()], 500);
        }
        return response()->json([
            'ok' => true,
            'regions' => $regionsInserted,
            'provinces' => $provincesInserted,
            'cities' => $citiesInserted,
            'barangays' => $barangaysInserted,
            'total_rows' => $totalRows,
            'inserted' => $inserted,
            'updated' => $updated,
            'skipped' => $skipped,
            'errors' => $errors,
        ]);
    }

    public function exportLocationMaster(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'super_admin') {
            abort(403);
        }
        $filename = 'location_master_' . now()->format('Y_m_d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        $callback = function () {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Region','Province','City / Municipality','Barangay','PSGC Code']);
            $rows = \DB::table('barangays as b')
                ->join('cities as c', 'b.city_id', '=', 'c.id')
                ->join('provinces as p', 'c.province_id', '=', 'p.id')
                ->join('regions as r', 'p.region_id', '=', 'r.id')
                ->selectRaw('r.region_name as region, p.province_name as province, c.city_name as city, b.barangay_name as barangay, COALESCE(b.barangay_code, c.city_code) as psgc_code')
                ->orderBy('r.region_name')->orderBy('p.province_name')->orderBy('c.city_name')->orderBy('b.barangay_name')
                ->cursor();
            foreach ($rows as $row) {
                fputcsv($out, [$row->region, $row->province, $row->city, $row->barangay, $row->psgc_code]);
            }
            fclose($out);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function createBackup(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'super_admin') {
            abort(403);
        }
        @set_time_limit(600);
        $dir = storage_path('app/backups');
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }
        $file = 'backup_' . now()->format('Y_m_d_His') . '.zip';
        $zipPath = $dir . DIRECTORY_SEPARATOR . $file;
        $zip = new \ZipArchive();
        if ($zip->open($zipPath, \ZipArchive::CREATE) !== true) {
            return redirect()->back()->with('error_settings', 'Failed to initialize backup archive.');
        }
        $dbName = \DB::getDatabaseName();
        $tables = array_map(function($r){ return $r->TABLE_NAME; }, \DB::select('SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = ?', [$dbName]));
        foreach ($tables as $table) {
            try {
                $cols = array_map(function($c){ return $c->Field; }, \DB::select('SHOW COLUMNS FROM `'.$table.'`'));
                $csv = fopen('php://temp', 'w+');
                fputcsv($csv, $cols);
                $chunkSize = 1000;
                $offset = 0;
                while (true) {
                    $rows = \DB::table($table)->offset($offset)->limit($chunkSize)->get();
                    if ($rows->isEmpty()) break;
                    foreach ($rows as $row) {
                        $line = [];
                        foreach ($cols as $c) {
                            $line[] = isset($row->$c) ? $row->$c : null;
                        }
                        fputcsv($csv, $line);
                    }
                    $offset += $chunkSize;
                }
                rewind($csv);
                $content = stream_get_contents($csv);
                fclose($csv);
                $zip->addFromString($table.'.csv', $content);
            } catch (\Throwable $e) {
                // skip table on error, continue backup
            }
        }
        $zip->close();
        return redirect()->route('dashboard', ['tab' => 'system-settings'])->with('success_settings', 'Backup created: '.$file);
    }

    public function downloadBackup(string $file)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'super_admin') {
            abort(403);
        }
        $safe = basename($file);
        $path = storage_path('app/backups/'.$safe);
        if (!is_file($path)) {
            abort(404);
        }
        return response()->download($path);
    }

    public function deleteBackup(string $file)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'super_admin') {
            abort(403);
        }
        $safe = basename($file);
        $path = storage_path('app/backups/'.$safe);
        if (is_file($path)) {
            @unlink($path);
        }
        return redirect()->route('dashboard', ['tab' => 'system-settings'])->with('success_settings', 'Backup deleted.');
    }

    public function restoreBackup(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'super_admin') {
            abort(403);
        }
        @set_time_limit(600);
        $request->validate([
            'backup_file' => 'required|file',
            'confirm' => 'required|in:yes',
        ]);
        $file = $request->file('backup_file');
        $ext = strtolower($file->getClientOriginalExtension());
        if ($ext === 'zip') {
            $zip = new \ZipArchive();
            if ($zip->open($file->getRealPath()) !== true) {
                return redirect()->back()->with('error_settings', 'Failed to open backup zip.');
            }
            \DB::statement('SET FOREIGN_KEY_CHECKS=0');
            try {
                for ($i = 0; $i < $zip->numFiles; $i++) {
                    $name = $zip->getNameIndex($i);
                    if (!preg_match('/\.csv$/i', $name)) continue;
                    $table = basename($name, '.csv');
                    $csvContent = $zip->getFromIndex($i);
                    $fh = fopen('php://temp', 'r+');
                    fwrite($fh, $csvContent);
                    rewind($fh);
                    $header = fgetcsv($fh);
                    if (!$header || !is_array($header)) { fclose($fh); continue; }
                    // truncate table
                    try { \DB::table($table)->truncate(); } catch (\Throwable $e) {}
                    $rows = [];
                    $batch = 0;
                    while (($r = fgetcsv($fh)) !== false) {
                        $row = [];
                        foreach ($header as $idx => $col) {
                            $row[$col] = $r[$idx] ?? null;
                        }
                        $rows[] = $row;
                        if (count($rows) >= 1000) {
                            \DB::table($table)->insert($rows);
                            $rows = [];
                        }
                    }
                    if (!empty($rows)) {
                        \DB::table($table)->insert($rows);
                    }
                    fclose($fh);
                }
                \DB::statement('SET FOREIGN_KEY_CHECKS=1');
            } catch (\Throwable $e) {
                \DB::statement('SET FOREIGN_KEY_CHECKS=1');
                return redirect()->back()->with('error_settings', 'Restore failed: '.$e->getMessage());
            }
            $zip->close();
            return redirect()->route('dashboard', ['tab' => 'system-settings'])->with('success_settings', 'Restore completed successfully.');
        } else {
            return redirect()->back()->with('error_settings', 'Unsupported backup format. Upload a .zip file created by this system.');
        }
    }

    public function storeAcademicYear(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'super_admin') {
            abort(403);
        }

        $request->validate([
            'year_start' => 'required|integer|min:2000|max:2100|unique:academic_years,year_start',
        ]);

        AcademicYear::create([
            'year_start' => $request->year_start,
            'year_end' => $request->year_start, // Set same as year_start for one-year format
            'is_active' => false, // New ones are inactive by default
        ]);

        return redirect()->route('dashboard', ['tab' => 'system-settings'])->with('success_settings', 'Academic year created successfully.');
    }

    public function activateAcademicYear(AcademicYear $academicYear)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'super_admin') {
            abort(403);
        }

        // Deactivate all others explicitly by ID to avoid any confusion
        AcademicYear::where('id', '!=', $academicYear->id)->update(['is_active' => false]);

        // Activate this one
        $academicYear->update(['is_active' => true]);

        return redirect()->route('dashboard', ['tab' => 'system-settings'])->with('success_settings', "Academic Year {$academicYear->year_start} is now active.");
    }

    public function destroyAcademicYear(AcademicYear $academicYear)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'super_admin') {
            abort(403);
        }

        if ($academicYear->is_active) {
            return redirect()->route('dashboard', ['tab' => 'system-settings'])
                ->with('error_settings', 'Cannot delete the active academic year.');
        }

        if ($academicYear->courses()->exists()) {
            return redirect()->route('dashboard', ['tab' => 'system-settings'])
                ->with('error_settings', 'Cannot delete this academic year because courses are already linked to it.');
        }

        $label = $academicYear->year_start;
        $academicYear->delete();

        return redirect()->route('dashboard', ['tab' => 'system-settings'])
            ->with('success_settings', "Academic Year {$label} deleted successfully.");
    }

    public function regionsJson()
    {
        $rows = \DB::table('regions')->orderBy('region_name')->get(['region_code as code','region_name as name']);
        return response()->json($rows);
    }
    public function provincesByRegionJson(string $regionCode)
    {
        $regionId = \DB::table('regions')->where('region_code', $regionCode)->value('id');
        if (!$regionId) return response()->json([]);
        $rows = \DB::table('provinces')->where('region_id', $regionId)->orderBy('province_name')->get(['province_code as code','province_name as name']);
        return response()->json($rows);
    }
    public function citiesByRegionJson(string $regionCode)
    {
        $regionId = \DB::table('regions')->where('region_code', $regionCode)->value('id');
        if (!$regionId) return response()->json([]);
        $provinceIds = \DB::table('provinces')->where('region_id', $regionId)->pluck('id')->toArray();
        if (empty($provinceIds)) return response()->json([]);
        $rows = \DB::table('cities')->whereIn('province_id', $provinceIds)->orderBy('city_name')->get(['city_code as code','city_name as name']);
        return response()->json($rows);
    }
    public function citiesByProvinceJson(string $provinceCode)
    {
        $provinceId = \DB::table('provinces')->where('province_code', $provinceCode)->value('id');
        if (!$provinceId) return response()->json([]);
        $rows = \DB::table('cities')->where('province_id', $provinceId)->orderBy('city_name')->get(['city_code as code','city_name as name']);
        return response()->json($rows);
    }
    public function barangaysByCityJson(string $cityCode)
    {
        $cityId = \DB::table('cities')->where('city_code', $cityCode)->value('id');
        if (!$cityId) return response()->json([]);
        $rows = \DB::table('barangays')->where('city_id', $cityId)->orderBy('barangay_name')->get(['barangay_code as code','barangay_name as name']);
        return response()->json($rows);
    }
    private function parseXlsxToRows(string $filePath): array
    {
        $rows = [];
        $zip = new \ZipArchive();
        if ($zip->open($filePath) !== true) {
            return $rows;
        }
        $sheetXml = null;
        // Prefer sheet1.xml; fallback to first worksheet
        $sheetXmlIndex = $zip->locateName('xl/worksheets/sheet1.xml', \ZipArchive::FL_NODIR);
        if ($sheetXmlIndex !== false) {
            $sheetXml = $zip->getFromIndex($sheetXmlIndex);
        } else {
            // Find first worksheets/sheet*.xml
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $name = $zip->getNameIndex($i);
                if (preg_match('#^xl/worksheets/sheet\d+\.xml$#', $name)) {
                    $sheetXml = $zip->getFromIndex($i);
                    break;
                }
            }
        }
        if (!$sheetXml) {
            $zip->close();
            return $rows;
        }
        $sharedStrings = [];
        $sstIdx = $zip->locateName('xl/sharedStrings.xml', \ZipArchive::FL_NODIR);
        if ($sstIdx !== false) {
            $sstXml = $zip->getFromIndex($sstIdx);
            $sst = new \SimpleXMLElement($sstXml);
            foreach ($sst->si as $si) {
                // concatenate t parts for rich text
                $text = '';
                if (isset($si->t)) {
                    $text = (string) $si->t;
                } elseif (isset($si->r)) {
                    foreach ($si->r as $r) {
                        $text .= (string) $r->t;
                    }
                }
                $sharedStrings[] = $text;
            }
        }
        $xml = new \SimpleXMLElement($sheetXml);
        $sheetData = $xml->sheetData;
        $rowMap = [];
        foreach ($sheetData->row as $row) {
            $rIndex = intval($row['r']);
            $rowMap[$rIndex] = [];
            foreach ($row->c as $c) {
                $ref = (string) $c['r']; // e.g., A1
                preg_match('/([A-Z]+)(\d+)/', $ref, $m);
                $colLetters = $m[1] ?? 'A';
                $colIndex = $this->xlsxColToIndex($colLetters);
                $t = (string) $c['t'];
                $v = (string) $c->v;
                $val = '';
                if ($t === 's') {
                    $idx = intval($v);
                    $val = $sharedStrings[$idx] ?? '';
                } elseif ($t === 'inlineStr' && isset($c->is->t)) {
                    $val = (string) $c->is->t;
                } else {
                    $val = $v;
                }
                $rowMap[$rIndex][$colIndex] = $val;
            }
        }
        // Normalize to sequential arrays
        ksort($rowMap);
        foreach ($rowMap as $r) {
            if (!empty($r)) {
                $maxCol = max(array_keys($r));
                $arr = [];
                for ($i = 0; $i <= $maxCol; $i++) {
                    $arr[] = isset($r[$i]) ? $r[$i] : '';
                }
                $rows[] = $arr;
            }
        }
        $zip->close();
        return $rows;
    }

    private function xlsxColToIndex(string $letters): int
    {
        $letters = strtoupper($letters);
        $n = 0;
        for ($i = 0; $i < strlen($letters); $i++) {
            $n = $n * 26 + (ord($letters[$i]) - 64);
        }
        return max(0, $n - 1);
    }

    public function helpSupport()
    {
        return view('help_support');
    }

    public function storeSupportRequest(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validateWithBag('supportRequest', [
            'request_type' => ['required', 'in:ticket,contact'],
            'subject' => ['required', 'string', 'max:150'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $entry = [
            'submitted_at' => now()->toDateTimeString(),
            'request_type' => $validated['request_type'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'user' => [
                'id' => $user?->id,
                'name' => $user?->name,
                'email' => $user?->email,
                'role' => $user?->role,
            ],
            'ip_address' => $request->ip(),
            'user_agent' => (string) $request->userAgent(),
        ];

        Storage::disk('local')->makeDirectory('support');
        Storage::disk('local')->append(
            'support/support-requests.log',
            json_encode($entry, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
        );

        try {
            Mail::raw(
                "Support request type: {$validated['request_type']}\n"
                ."From: {$user?->name} <{$user?->email}>\n"
                ."Role: {$user?->role}\n"
                ."Subject: {$validated['subject']}\n\n"
                ."{$validated['message']}",
                function ($message) use ($validated, $user) {
                    $message->to(env('SUPPORT_CONTACT_EMAIL', env('MAIL_FROM_ADDRESS', 'dilgcarcapdevpro@gmail.com')))
                        ->subject('[CAPDEV PRO] '.$validated['subject']);

                    if (!empty($user?->email)) {
                        $message->replyTo($user->email, $user->name ?? null);
                    }
                }
            );

        } catch (\Throwable $e) {
            Log::error('Support request mail send failed.', [
                'message' => $e->getMessage(),
                'request_type' => $validated['request_type'],
                'subject' => $validated['subject'],
                'recipient' => env('SUPPORT_CONTACT_EMAIL', env('MAIL_FROM_ADDRESS', 'dilgcarcapdevpro@gmail.com')),
                'user_id' => $user?->id,
                'user_email' => $user?->email,
            ]);

            return back()
                ->withInput()
                ->with('error_help_support', 'Support request was saved, but email sending failed. Please check the mail configuration or Laravel log.');
        }

        return back()->with(
            'success_help_support',
            $validated['request_type'] === 'ticket'
                ? 'Support ticket submitted successfully.'
                : 'Support message sent successfully.'
        );
    }

    protected function expandManagedRoleFilters(
        array $requestedRoles,
        array $managedRoles,
        array $managedCoachRoles = [],
        array $managedParticipantRoles = [],
        array $managedTMRoles = [],
        array $managedAdminRoles = []
    ): array {
        $managedLookup = [];
        foreach ($managedRoles as $managedRole) {
            $managedLookup[strtolower((string) $managedRole)] = $managedRole;
        }

        $expanded = [];
        foreach ($requestedRoles as $requestedRole) {
            $role = strtolower(trim((string) $requestedRole));
            if ($role === '') {
                continue;
            }

            if (in_array($role, ['coach', 'trainer'], true)) {
                $expanded = array_merge($expanded, $managedCoachRoles);
                continue;
            }

            if (in_array($role, ['participant', 'trainee', 'user', 'users'], true)) {
                $expanded = array_merge($expanded, $managedParticipantRoles);
                continue;
            }

            if (in_array($role, ['training_manager', 'registrar'], true)) {
                $expanded = array_merge($expanded, $managedTMRoles);
                if (isset($managedLookup['registrar'])) {
                    $expanded[] = $managedLookup['registrar'];
                }
                continue;
            }

            if (in_array($role, ['admin', 'super_admin'], true)) {
                $expanded = array_merge($expanded, $managedAdminRoles);
                continue;
            }

            if (isset($managedLookup[$role])) {
                $expanded[] = $managedLookup[$role];
            }
        }

        $normalized = [];
        foreach ($expanded as $role) {
            $key = strtolower((string) $role);
            if ($key === '' || !isset($managedLookup[$key])) {
                continue;
            }

            $normalized[$key] = $managedLookup[$key];
        }

        return array_values($normalized);
    }

    public function getFieldOfWorks()
    {
        if (Auth::user()->role !== 'super_admin') {
            abort(403);
        }
        return response()->json(FieldOfWork::orderBy('name', 'asc')->get());
    }

    public function storeFieldOfWork(Request $request)
    {
        if (Auth::user()->role !== 'super_admin') {
            abort(403);
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:field_of_works,name',
            'tooltip_content' => 'nullable|string',
        ]);

        FieldOfWork::create($validated);

        return back()->with('success', 'Field of Work added successfully.');
    }

    public function updateFieldOfWork(Request $request, FieldOfWork $fieldOfWork)
    {
        if (Auth::user()->role !== 'super_admin') {
            abort(403);
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:field_of_works,name,' . $fieldOfWork->id,
            'tooltip_content' => 'nullable|string',
        ]);

        $fieldOfWork->update($validated);

        return back()->with('success', 'Field of Work updated successfully.');
    }

    public function destroyFieldOfWork(FieldOfWork $fieldOfWork)
    {
        if (Auth::user()->role !== 'super_admin') {
            abort(403);
        }
        $fieldOfWork->delete();

        return back()->with('success', 'Field of Work removed successfully.');
    }
}
