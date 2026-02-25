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
                $courses = Course::all();
                $archivedCourses = Course::onlyTrashed()->get();
                $certifications = Certification::all();
                $recentCourses = Course::latest()->take(5)->get();
                $pendingCourses = \App\Models\Course::onlyTrashed()
                    ->whereHas('users', function($q){
                        $q->where('role', 'trainer');
                    })
                    ->get();
                $pendingCoursesCount = \App\Models\Course::onlyTrashed()
                    ->whereHas('users', function($q){
                        $q->where('role', 'trainer');
                    })
                    ->count();
                $activeUsersCount = User::where('status', 'active')->count();
                $pendingUsersTotal = User::where('status', 'pending')->count();
                $frozenUsersCount = User::where('status', 'freeze')->count();
                $trainersCount = User::where('role', 'trainer')->count();
                $traineesCount = User::where('role', 'trainee')->count();
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
                $pendingTraineesCount = User::where('role', 'trainee')->where('status', 'pending')->count();
                $totalCourses = Course::count();
                $courses = Course::with('users')->get();
                $potentialParticipants = User::whereIn('role', ['trainer', 'trainee'])->where('status', 'active')->get();
                
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
                    $query->whereIn('role', $request->roles);
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
            case 'trainer':
                // Get courses where the trainer is assigned (assuming pivot table handles this)
                // Also eager load materials and assessments
                $myCourses = $user->courses()->with(['users', 'materials', 'assessments.grades'])->get();
                
                $totalCoursesTeaching = $myCourses->count();
                
                // Count total unique students across all courses
                $totalStudents = $myCourses->flatMap(function ($course) {
                    return $course->users->where('role', 'trainee');
                })->unique('id')->count();

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

                return view('trainer.dashboard', compact('myCourses', 'totalCoursesTeaching', 'totalStudents', 'announcements', 'calendarEvents', 'notifications', 'unreadNotificationsCount', 'forceProfile'));
            case 'trainee':
                // Get enrolled courses (active status)
                // Eager load relationships for dashboard display
                $myCourses = $user->courses()
                    ->wherePivot('status', 'active')
                    ->with(['users' => function($q) {
                        $q->where('role', 'trainer');
                    }, 'materials', 'assessments.grades' => function($q) use ($user) {
                        $q->where('user_id', $user->id);
                    }])
                    ->get();

                // Get pending courses for display if needed
                $pendingCourses = $user->courses()
                    ->wherePivot('status', 'pending')
                    ->get();
                $pendingCoursesCount = $pendingCourses->count();
                $classroomCourses = $myCourses->concat($pendingCourses);
                
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
                $availableCourses = $availableCourses->get();
                
                $totalAvailableCourses = $availableCourses->count();
                $totalCoursesJoined = $user->courses()->wherePivot('status', 'active')->count();

                $completedByStatus = $user->courses()->wherePivot('status', 'completed')->count();
                $completedByCertification = $user->certifications()
                    ->whereNotNull('certification_user.course_id')
                    ->distinct('certification_user.course_id')
                    ->count('certification_user.course_id');
                $completedCoursesCount = max($completedByStatus, $completedByCertification);
                $activeCoursesCount = $myCourses->count();
                
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

                return view('trainee.dashboard', compact('myCourses', 'classroomCourses', 'pendingCourses', 'availableCourses', 'completedCoursesCount', 'activeCoursesCount', 'announcements', 'calendarEvents', 'notifications', 'unreadNotificationsCount', 'totalAvailableCourses', 'totalCoursesJoined', 'courseStatuses', 'forceProfile', 'pendingCoursesCount'));
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
                'role' => 'required|string|in:admin,registrar,trainer,trainee',
                'status' => 'required|string|in:active,freeze,pending',
            ]);
            $user->update($validated);
            return redirect()->route('dashboard', ['tab' => 'user-management'])->with('success_user', 'User role/status updated.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string|in:admin,registrar,trainer,trainee',
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
            // Delete old picture if exists
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
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
        ]);

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
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

        return redirect()->back()->with('success_profile', 'Profile updated successfully.');
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
        ]);

        if ($request->hasFile('profile_picture')) {
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
}
