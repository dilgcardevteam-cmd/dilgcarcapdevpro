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

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $forceProfile = !$user->profile_completed;

        switch ($user->role) {
            case 'admin':
                $userCount = User::count();
                $courseCount = Course::count(); // Counts only active
                $courses = Course::orderBy('created_at', 'desc')->get();
                $archivedCourses = Course::onlyTrashed()->get();
                $certifications = Certification::all();
                $recentCourses = Course::latest()->take(5)->get();
                $pendingCourses = \App\Models\Course::onlyTrashed()
                    ->whereHas('users', function($q){
                        $q->whereIn('role', ['coach','trainer']);
                    })
                    ->get();
                $pendingCoursesCount = \App\Models\Course::onlyTrashed()
                    ->whereHas('users', function($q){
                        $q->whereIn('role', ['coach','trainer']);
                    })
                    ->count();
                $activeUsersCount = User::where('status', 'active')->count();
                $pendingUsersTotal = User::where('status', 'pending')->count();
                $frozenUsersCount = User::where('status', 'freeze')->count();
                $trainersCount = User::whereIn('role', ['coach','trainer'])->count();
                $traineesCount = User::whereIn('role', ['participant','trainee'])->count();
                $adminsCount = User::where('role', 'admin')->count();
                $registrarsCount = User::where('role', 'registrar')->count();
                $archivedCoursesCount = Course::onlyTrashed()->count();
                $certificationCount = Certification::count();
                
                $query = User::query();

                // Search by Name
                if ($request->filled('search')) {
                    $query->where('name', 'like', '%' . $request->search . '%');
                }

                // Filter by Role
                if ($request->has('roles')) {
                    $query->whereIn('role', $request->roles);
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

                if ($request->ajax()) {
                    return view('admin.partials.users-table', compact('users'))->render();
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
                    'recentCourses'
                ));
            case 'registrar':
                $unapprovedCount = User::where('status', 'pending')->count();
                $approvedCount = User::where('status', 'active')->count();
                $pendingTraineesCount = User::whereIn('role', ['participant','trainee'])->where('status', 'pending')->count();
                $totalCourses = Course::count();
                $courses = Course::with('users')->get();
                $potentialParticipants = User::whereIn('role', ['coach','trainer', 'participant','trainee'])->where('status', 'active')->get();
                
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
                        if ($r === 'trainer' && !in_array('coach', $roles, true)) $expanded[] = 'coach';
                        if ($r === 'coach' && !in_array('trainer', $roles, true)) $expanded[] = 'trainer';
                        if ($r === 'trainee' && !in_array('participant', $roles, true)) $expanded[] = 'participant';
                        if ($r === 'participant' && !in_array('trainee', $roles, true)) $expanded[] = 'trainee';
                        if ($r === 'training_manager' && !in_array('registrar', $roles, true)) $expanded[] = 'registrar';
                        if ($r === 'registrar' && !in_array('training_manager', $roles, true)) $expanded[] = 'training_manager';
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
            case 'coach':
            case 'trainer':
                // Get courses where the trainer is assigned (assuming pivot table handles this)
                // Also eager load materials and assessments
                $myCourses = $user->courses()
                    ->orderBy('courses.created_at', 'desc')
                    ->with(['users', 'materials', 'assessments.grades'])
                    ->get();
                
                $totalCoursesTeaching = $myCourses->count();
                
                // Count total unique students across all courses
                $totalStudents = $myCourses->flatMap(function ($course) {
                    return $course->users->where('role', 'trainee');
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
            case 'training_manager':
                // Reuse registrar dashboard logic for training manager
                $unapprovedCount = User::where('status', 'pending')->count();
                $approvedCount = User::where('status', 'active')->count();
                $pendingTraineesCount = User::whereIn('role', ['participant','trainee'])->where('status', 'pending')->count();
                $totalCourses = Course::count();
                $courses = Course::with('users')->get();
                $potentialParticipants = User::whereIn('role', ['coach','trainer', 'participant','trainee'])->where('status', 'active')->get();
                $notifications = Notification::where('user_id', $user->id)->orderBy('created_at', 'desc')->take(10)->get();
                $unreadNotificationsCount = Notification::where('user_id', $user->id)->where('is_read', false)->count();
                $query = User::query();
                if ($request->filled('search')) $query->where('name', 'like', '%' . $request->search . '%');
                if ($request->has('roles')) $query->whereIn('role', $request->roles);
                if ($request->has('statuses')) $query->whereIn('status', $request->statuses);
                $sort = $request->get('sort', 'newest');
                if ($sort === 'oldest') $query->orderBy('created_at', 'asc');
                elseif ($sort === 'alpha') $query->orderBy('name', 'asc');
                else $query->orderBy('created_at', 'desc');
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
            case 'participant':
            case 'trainee':
                // Get enrolled courses (active status)
                // Eager load relationships for dashboard display
                $myCourses = $user->courses()
                    ->wherePivot('status', 'active')
                    ->orderBy('courses.created_at', 'desc')
                    ->with(['users' => function($q) {
                        $q->whereIn('role', ['coach','trainer']);
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
                $availableCourses = Course::with(['users' => function($q) {
                        $q->where('role', 'trainer');
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
            $validated = $request->validate([
                'role' => 'required|string|in:admin,registrar,training_manager,coach,trainer,participant,trainee',
                'status' => 'required|string|in:active,freeze,pending',
            ]);
            $user->update($validated);
            return redirect()->route('dashboard', ['tab' => 'user-management'])->with('success_user', 'User role/status updated.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string|in:admin,registrar,training_manager,coach,trainer,participant,trainee',
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
        if (!$actor || $actor->role !== 'admin') {
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
        if (!$actor || $actor->role !== 'admin') {
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
        $trainees = $course->users()
            ->where('role', 'trainee')
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

    public function importLocationMaster(Request $request)
    {
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
        $cols = array_map(function($c){ return strtolower(trim((string)$c)); }, $header);
        $iRegionCode = array_search('region_code', $cols);
        $iRegionName = array_search('region_name', $cols);
        $iProvinceCode = array_search('province_code', $cols);
        $iProvinceName = array_search('province_name', $cols);
        if ($iRegionCode === false || $iRegionName === false) {
            return response()->json(['ok' => false, 'error' => 'Missing region headers'], 422);
        }
        $regionsInserted = 0;
        $provincesInserted = 0;
        \DB::beginTransaction();
        try {
            $regionIdByCode = [];
            for ($ri = 1; $ri < count($rows); $ri++) {
                $row = $rows[$ri];
                $regionCode = isset($row[$iRegionCode]) ? trim($row[$iRegionCode]) : '';
                $regionName = isset($row[$iRegionName]) ? trim($row[$iRegionName]) : '';
                if ($regionCode && $regionName) {
                    $existing = \DB::table('regions')->where('region_code', $regionCode)->first();
                    if ($existing) {
                        \DB::table('regions')->where('id', $existing->id)->update(['region_name' => $regionName, 'updated_at' => now()]);
                        $regionIdByCode[$regionCode] = $existing->id;
                    } else {
                        $id = \DB::table('regions')->insertGetId(['region_code' => $regionCode, 'region_name' => $regionName, 'created_at' => now(), 'updated_at' => now()]);
                        $regionIdByCode[$regionCode] = $id;
                        $regionsInserted++;
                    }
                }
                if ($iProvinceCode !== false && $iProvinceName !== false) {
                    $provCode = isset($row[$iProvinceCode]) ? trim($row[$iProvinceCode]) : '';
                    $provName = isset($row[$iProvinceName]) ? trim($row[$iProvinceName]) : '';
                    if ($provCode && $provName && $regionCode) {
                        $regionId = $regionIdByCode[$regionCode] ?? (\DB::table('regions')->where('region_code', $regionCode)->value('id'));
                        if ($regionId) {
                            $existingP = \DB::table('provinces')->where('province_code', $provCode)->first();
                            if ($existingP) {
                                \DB::table('provinces')->where('id', $existingP->id)->update(['province_name' => $provName, 'region_id' => $regionId, 'updated_at' => now()]);
                            } else {
                                \DB::table('provinces')->insert(['region_id' => $regionId, 'province_code' => $provCode, 'province_name' => $provName, 'created_at' => now(), 'updated_at' => now()]);
                                $provincesInserted++;
                            }
                        }
                    }
                }
            }
            \DB::commit();
        } catch (\Throwable $e) {
            \DB::rollBack();
            return response()->json(['ok' => false, 'error' => 'Import error'], 500);
        }
        return response()->json(['ok' => true, 'regions' => $regionsInserted, 'provinces' => $provincesInserted]);
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
