<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Course;
use App\Models\Certification;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountApproved;
use App\Models\Announcement;
use App\Models\CalendarEvent;
use App\Models\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Role;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if (isset($user->email) && strtolower($user->email) === 'co_participant@gmail.com') {
            $notifications = Notification::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();
            $unreadNotificationsCount = Notification::where('user_id', $user->id)
                ->where('is_read', false)
                ->count();
            $myCourses = collect([]);
            $classroomCourses = collect([]);
            $pendingCourses = collect([]);
            $availableCourses = collect([]);
            $completedCoursesCount = 0;
            $activeCoursesCount = 0;
            $announcements = collect([]);
            $calendarEvents = collect([]);
            $totalAvailableCourses = 0;
            $totalCoursesJoined = 0;
            $courseStatuses = [];
            $forceProfile = false;
            $pendingCoursesCount = 0;
            $earnedCertificates = collect([]);
            return view('coparticipant.dashboard', compact(
                'notifications',
                'unreadNotificationsCount',
                'myCourses',
                'classroomCourses',
                'pendingCourses',
                'availableCourses',
                'completedCoursesCount',
                'activeCoursesCount',
                'announcements',
                'calendarEvents',
                'totalAvailableCourses',
                'totalCoursesJoined',
                'courseStatuses',
                'forceProfile',
                'pendingCoursesCount',
                'earnedCertificates'
            ));
        }
        if (isset($user->email) && strtolower($user->email) === 'co_tm@gmail.com') {
            $notifications = Notification::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();
            $unreadNotificationsCount = Notification::where('user_id', $user->id)
                ->where('is_read', false)
                ->count();
            $managedRoles = ['coach','trainer','participant','trainee'];
            $managedCoachRoles = ['coach','trainer'];
            $managedParticipantRoles = ['participant','trainee'];
            $unapprovedCount = \App\Models\User::whereIn('role', $managedRoles)->where('status', 'pending')->count();
            $approvedCount = \App\Models\User::whereIn('role', $managedRoles)->where('status', 'active')->count();
            $pendingTraineesCount = \App\Models\User::whereIn('role', $managedParticipantRoles)->where('status', 'pending')->count();
            $totalCourses = \App\Models\Course::count();
            $courses = \App\Models\Course::with('users')->get();
            $potentialParticipants = \App\Models\User::whereIn('role', array_merge($managedCoachRoles,$managedParticipantRoles))
                ->where('status', 'active')->get();
            $query = \App\Models\User::query()->whereIn('role', $managedRoles);
            if ($request->filled('search')) {
                $query->where('name', 'like', '%' . $request->search . '%');
            }
            if ($request->has('roles')) {
                $query->whereIn('role', array_intersect((array)$request->roles, $managedRoles));
            }
            if ($request->has('statuses')) {
                $query->whereIn('status', $request->statuses);
            }
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
            $forceProfile = false;
            if ($request->ajax()) {
                return view('cotm.partials.users-table', compact('users','roleDisplay'))->render();
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
            return view('cotm.dashboard', compact(
                'notifications',
                'unreadNotificationsCount',
                'unapprovedCount',
                'approvedCount',
                'pendingTraineesCount',
                'totalCourses',
                'users',
                'courses',
                'potentialParticipants',
                'forceProfile',
                'roles',
                'permissions',
                'rolePermissions',
                'roleDisplay'
            ));
        }
        if (isset($user->email) && strtolower($user->email) === 'ro_participant@gmail.com') {
            $notifications = Notification::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();
            $unreadNotificationsCount = Notification::where('user_id', $user->id)
                ->where('is_read', false)
                ->count();
            $myCourses = collect([]);
            $classroomCourses = collect([]);
            $pendingCourses = collect([]);
            $availableCourses = collect([]);
            $completedCoursesCount = 0;
            $activeCoursesCount = 0;
            $announcements = collect([]);
            $calendarEvents = collect([]);
            $totalAvailableCourses = 0;
            $totalCoursesJoined = 0;
            $courseStatuses = [];
            $forceProfile = false;
            $pendingCoursesCount = 0;
            $earnedCertificates = collect([]);
            return view('roparticipant.dashboard', compact(
                'notifications',
                'unreadNotificationsCount',
                'myCourses',
                'classroomCourses',
                'pendingCourses',
                'availableCourses',
                'completedCoursesCount',
                'activeCoursesCount',
                'announcements',
                'calendarEvents',
                'totalAvailableCourses',
                'totalCoursesJoined',
                'courseStatuses',
                'forceProfile',
                'pendingCoursesCount',
                'earnedCertificates'
            ));
        }
        $forceProfile = !$user->profile_completed;
        $adminRoles = ['admin','super_admin','central_office_admin','regional_office_admin','provincial_office_admin'];
        $tmRoles = ['training_manager','central_office_training_manager','regional_office_training_manager','provincial_office_training_manager'];
        $coachRoles = ['coach','trainer','central_office_coach','regional_office_coach','provincial_office_coach'];
        $participantRoles = ['participant','trainee','central_office_participants','regional_office_participants','provincial_office_participants'];

        switch (true) {
            case in_array($user->role, $adminRoles, true):
                $managedRoles = [];
                if ($user->role === 'central_office_admin') {
                    $managedRoles = ['central_office_training_manager','central_office_coach','central_office_participants'];
                } elseif ($user->role === 'regional_office_admin') {
                    $managedRoles = ['regional_office_training_manager','regional_office_coach','regional_office_participants'];
                } elseif ($user->role === 'provincial_office_admin') {
                    $managedRoles = ['provincial_office_training_manager','provincial_office_coach','provincial_office_participants'];
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
                    $managedRoles = ['training_manager','coach','trainer','participant','trainee'];
                }
                $managedCoachRoles = array_values(array_intersect($coachRoles, $managedRoles));
                $managedTMRoles = array_values(array_intersect($tmRoles, $managedRoles));
                $managedParticipantRoles = array_values(array_intersect($participantRoles, $managedRoles));

                $userCount = User::whereIn('role', $managedRoles)->count();
                $courseCount = Course::count(); // Counts only active
                $courses = Course::orderBy('created_at', 'desc')->get();
                $archivedCourses = Course::onlyTrashed()->get();
                $certifications = Certification::all();
                $recentCourses = Course::latest()->take(5)->get();
                $pendingCourses = \App\Models\Course::onlyTrashed()
                    ->whereHas('users', function($q) use ($managedCoachRoles) {
                        $q->whereIn('role', $managedCoachRoles);
                    })
                    ->get();
                $pendingCoursesCount = \App\Models\Course::onlyTrashed()
                    ->whereHas('users', function($q) use ($managedCoachRoles) {
                        $q->whereIn('role', $managedCoachRoles);
                    })
                    ->count();
                $activeUsersCount = User::whereIn('role', $managedRoles)->where('status', 'active')->count();
                $pendingUsersTotal = User::whereIn('role', $managedRoles)->where('status', 'pending')->count();
                $frozenUsersCount = User::whereIn('role', $managedRoles)->where('status', 'freeze')->count();
                $trainersCount = User::whereIn('role', $managedCoachRoles)->count();
                $traineesCount = User::whereIn('role', $managedParticipantRoles)->count();
                $adminsCount = User::whereIn('role', $adminRoles)->count();
                $registrarsCount = User::where('role', 'registrar')->count();
                $archivedCoursesCount = Course::onlyTrashed()->count();
                $certificationCount = Certification::count();
                
                $query = User::query()->whereIn('role', $managedRoles);

                // Search by Name
                if ($request->filled('search')) {
                    $query->where('name', 'like', '%' . $request->search . '%');
                }

                // Filter by Role
                if ($request->has('roles')) {
                    $query->whereIn('role', array_intersect($request->roles, $managedRoles));
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
                    'roleDisplay'
                ));
            case $user->role === 'registrar':
                $unapprovedCount = User::where('status', 'pending')->count();
                $approvedCount = User::where('status', 'active')->count();
                $pendingTraineesCount = User::whereIn('role', $participantRoles)->where('status', 'pending')->count();
                $totalCourses = Course::count();
                $courses = Course::with('users')->get();
                $potentialParticipants = User::whereIn('role', array_merge($coachRoles,$participantRoles))->where('status', 'active')->get();
                
                // Fetch Notifications
                $notifications = Notification::where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->take(10)
                    ->get();
                $unreadNotificationsCount = Notification::where('user_id', $user->id)
                    ->where('is_read', false)
                    ->count();

                $query = User::query();

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

                if ($request->ajax()) {
                    return view('registrar.partials.users-table', compact('users'))->render();
                }

                return view('registrar.dashboard', compact(
                    'unapprovedCount',
                    'approvedCount',
                    'pendingTraineesCount',
                    'totalCourses',
                    'users',
                    'courses',
                    'potentialParticipants',
                    'notifications',
                    'unreadNotificationsCount',
                    'forceProfile'
                ));
            case in_array($user->role, $coachRoles, true):
                // Get courses where the trainer is assigned (assuming pivot table handles this)
                // Also eager load materials and assessments
                $myCourses = $user->courses()
                    ->orderBy('courses.created_at', 'desc')
                    ->with(['users', 'materials', 'assessments.grades'])
                    ->get();
                
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

                // Determine course statuses for current user
                $courseStatuses = $user->courses()->pluck('course_user.status', 'courses.id')->toArray();
                // Available courses (exclude already joined or pending)
                $excludedIds = array_map('intval', array_keys($courseStatuses));
                $availableCoursesQuery = Course::with(['users' => function($q) {
                    $q->where('role', 'trainer');
                }]);
                if (!empty($excludedIds)) {
                    $availableCoursesQuery = $availableCoursesQuery->whereNotIn('id', $excludedIds);
                }
                $availableCourses = $availableCoursesQuery->orderBy('created_at', 'desc')->get();

                $announcements = Announcement::with('user')->latest()->get();
                $calendarEvents = CalendarEvent::where('user_id', $user->id)->orderBy('start_time')->get();

                // Fetch Notifications
                $notifications = Notification::where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->take(10)
                    ->get();
                $unreadNotificationsCount = Notification::where('user_id', $user->id)
                    ->where('is_read', false)
                    ->count();

                return view('trainer.dashboard', compact('myCourses', 'availableCourses', 'courseStatuses', 'totalCoursesTeaching', 'totalStudents', 'announcements', 'calendarEvents', 'notifications', 'unreadNotificationsCount', 'forceProfile'));
            case in_array($user->role, $tmRoles, true):
                $managedRoles = [];
                if ($user->role === 'central_office_training_manager') {
                    $managedRoles = ['central_office_coach','central_office_participants'];
                } elseif ($user->role === 'regional_office_training_manager') {
                    $managedRoles = ['regional_office_coach','regional_office_participants'];
                } elseif ($user->role === 'provincial_office_training_manager') {
                    $managedRoles = ['provincial_office_coach','provincial_office_participants'];
                } else {
                    $managedRoles = ['coach','trainer','participant','trainee'];
                }
                $managedCoachRoles = array_values(array_intersect($coachRoles, $managedRoles));
                $managedParticipantRoles = array_values(array_intersect($participantRoles, $managedRoles));
                $unapprovedCount = User::whereIn('role', $managedRoles)->where('status', 'pending')->count();
                $approvedCount = User::whereIn('role', $managedRoles)->where('status', 'active')->count();
                $pendingTraineesCount = User::whereIn('role', $managedParticipantRoles)->where('status', 'pending')->count();
                $totalCourses = Course::count();
                $courses = Course::with('users')->get();
                $potentialParticipants = User::whereIn('role', array_merge($managedCoachRoles,$managedParticipantRoles))->where('status', 'active')->get();
                $notifications = Notification::where('user_id', $user->id)->orderBy('created_at', 'desc')->take(10)->get();
                $unreadNotificationsCount = Notification::where('user_id', $user->id)->where('is_read', false)->count();
                $query = User::query()->whereIn('role', $managedRoles);
                if ($request->filled('search')) $query->where('name', 'like', '%' . $request->search . '%');
                if ($request->has('roles')) $query->whereIn('role', array_intersect($request->roles, $managedRoles));
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
                return view('registrar.dashboard', compact(
                    'unapprovedCount',
                    'approvedCount',
                    'pendingTraineesCount',
                    'totalCourses',
                    'users',
                    'courses',
                    'potentialParticipants',
                    'notifications',
                    'unreadNotificationsCount',
                    'forceProfile'
                ));
            case 'participant':
            case 'trainee':
                // Get enrolled courses (active status)
                // Eager load relationships for dashboard display
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
                $myCourses = $user->courses()
                    ->wherePivot('status', 'active')
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
                    ->orderBy('courses.created_at', 'desc')
                    ->get();
                $pendingCoursesCount = $pendingCourses->count();
                $classroomCourses = $myCourses->concat($pendingCourses)->sortByDesc('created_at')->values();
                
                // Determine course statuses for current user
                $courseStatuses = $user->courses()->pluck('course_user.status', 'courses.id')->toArray();

                // Get available courses (exclude those already joined or pending)
                $excludedIds = array_map('intval', array_keys($courseStatuses));
                $availableCourses = Course::with(['users' => function($q) use ($myCoachRoles) {
                        $q->whereIn('role', $myCoachRoles);
                    }]);
                if (!empty($excludedIds)) {
                    $availableCourses = $availableCourses->whereNotIn('id', $excludedIds);
                }
                $availableCourses = $availableCourses->orderBy('created_at', 'desc')->get();
                
                $totalAvailableCourses = $availableCourses->count();
                $totalCoursesJoined = $user->courses()->wherePivot('status', 'active')->count();

                $completedByStatus = $user->courses()->wherePivot('status', 'completed')->count();
                $completedByCertification = $user->certifications()
                    ->whereNotNull('certification_user.course_id')
                    ->distinct('certification_user.course_id')
                    ->count('certification_user.course_id');
                $completedCoursesCount = max($completedByStatus, $completedByCertification);
                $activeCoursesCount = $myCourses->count();
                
                $earnedCertificates = $user->certifications()->with('users')->get();
                
                // Fetch Announcements (global or course specific - for now fetching all global)
                $announcements = Announcement::with('user')->orderBy('created_at', 'desc')->take(5)->get();

                // Fetch Calendar Events
                $calendarEvents = CalendarEvent::where('user_id', $user->id)
                    ->orderBy('start_time', 'asc')
                    ->get();

                // Fetch Notifications
                $notifications = Notification::where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->take(10)
                    ->get();
                $unreadNotificationsCount = Notification::where('user_id', $user->id)
                    ->where('is_read', false)
                    ->count();

                return view('trainee.dashboard', compact('myCourses', 'classroomCourses', 'pendingCourses', 'availableCourses', 'completedCoursesCount', 'activeCoursesCount', 'announcements', 'calendarEvents', 'notifications', 'unreadNotificationsCount', 'totalAvailableCourses', 'totalCoursesJoined', 'courseStatuses', 'forceProfile', 'pendingCoursesCount', 'earnedCertificates'));
            default:
                // Fallback for users without a role or unknown role
                return view('trainee.dashboard', compact('forceProfile')); 
        }
    }

    public function updateUser(Request $request, User $user)
    {
        $actor = Auth::user();
        if ($actor && $actor->role === 'registrar') {
            // Registrars may only change role and status
            $allowedRoles = Role::pluck('name')->toArray();
            $validated = $request->validate([
                'role' => 'required|string|in:' . implode(',', $allowedRoles),
                'status' => 'required|string|in:active,freeze,pending',
            ]);
            $user->update($validated);
            return redirect()->route('dashboard', ['tab' => 'user-management'])->with('success_user', 'User role/status updated.');
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

        // Check for status change to active
        $wasNotActive = $user->status !== 'active';
        $becomingActive = isset($validated['status']) && $validated['status'] === 'active';

        $user->update($validated);

        // Send approval email if activated
        if ($wasNotActive && $becomingActive) {
            try {
                Mail::to($user->email)->send(new AccountApproved($user));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to send approval email to ' . $user->email . ': ' . $e->getMessage());
            }
        }

        return redirect()->route('dashboard', ['tab' => 'user-management'])->with('success_user', 'User updated successfully.');
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

        $user->fill($validated);
        if (!$user->profile_completed) {
            $user->profile_completed = true;
            $user->profile_completed_at = now();
        }
        $user->save();

        return redirect()->route('dashboard', ['tab' => 'profile-section'])->with('success_profile', 'Profile updated successfully.');
    }

    public function setupProfile()
    {
        $user = Auth::user();
        if ($user->profile_completed) {
            return redirect()->route('dashboard', ['tab' => 'profile-section']);
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
        $section = $request->input('section', 'info');
        if ($section === 'password') {
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
            'gender' => 'nullable|string|in:Male,Female,Prefer not to say',
            'region' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            'profile_picture_cropped' => 'nullable|string',
        ]);

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
        if (!$user->profile_completed) {
            $user->profile_completed = true;
            $user->profile_completed_at = now();
        }
        $user->save();

        if (!$wasProfileCompleted) {
            $request->session()->flash('success_profile', 'Profile completed successfully.');
            return redirect()->route('dashboard', ['tab' => 'profile-section']);
        }

        return redirect()->route('dashboard', ['tab' => 'profile-section'])->with('success_profile', 'Profile updated successfully.');
    }

    public function markNotificationAsRead(Notification $notification)
    {
        $notification->update(['is_read' => true]);
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
            $key = $g === 'male' ? 'male' : ($g === 'female' ? 'female' : 'other');
            if (!isset($out[$region])) {
                $out[$region] = ['male' => 0, 'female' => 0, 'other' => 0];
            }
            $out[$region][$key] += (int) $row->c;
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
}
