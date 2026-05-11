<?php

namespace App\Services;

use App\Models\User;
use App\Models\Course;
use App\Models\Certification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardService
{
    public function getAdminStats($managedRoles, $levelRoles, $managedCoachRoles, $selectedYearId)
    {
        $baseCourseQuery = Course::whereHas('users', function($q) use ($levelRoles) {
            $q->whereIn('role', $levelRoles);
        });

        if ($selectedYearId !== 'all') {
            $baseCourseQuery->where('academic_year_id', $selectedYearId);
        }

        $pendingCoursesQuery = Course::withTrashed()
            ->whereHas('users', function($q) use ($managedCoachRoles) {
                $q->whereIn(DB::raw('LOWER(role)'), array_map('strtolower', $managedCoachRoles));
            });
        if (Schema::hasColumn('courses', 'approval_status')) {
            $pendingCoursesQuery->where(function ($query) {
                $query->where('approval_status', 'pending')
                    ->orWhere(function ($legacy) {
                        $legacy->whereNull('approval_status')->where('is_published', false);
                    });
            });
        } else {
            $pendingCoursesQuery->where('is_published', false);
        }

        if ($selectedYearId !== 'all') {
            $pendingCoursesQuery->where('academic_year_id', $selectedYearId);
        }

        $rejectedCoursesQuery = Course::withTrashed()
            ->whereHas('users', function($q) use ($managedCoachRoles) {
                $q->whereIn(DB::raw('LOWER(role)'), array_map('strtolower', $managedCoachRoles));
            });
        if (Schema::hasColumn('courses', 'approval_status')) {
            $rejectedCoursesQuery->where('approval_status', 'rejected');
        } else {
            $rejectedCoursesQuery->whereRaw('1 = 0');
        }

        if ($selectedYearId !== 'all') {
            $rejectedCoursesQuery->where('academic_year_id', $selectedYearId);
        }

        return [
            'userCount' => User::whereIn('role', $managedRoles)->where('profile_completed', true)->count(),
            'courseCount' => (clone $baseCourseQuery)->count(),
            'courses' => (clone $baseCourseQuery)->orderBy('created_at', 'desc')->get(),
            'archivedCourses' => (clone $baseCourseQuery)->onlyTrashed()->get(),
            'recentCourses' => (clone $baseCourseQuery)->latest()->take(5)->get(),
            'pendingCourses' => (clone $pendingCoursesQuery)->with('users')->orderByDesc('created_at')->get(),
            'pendingCoursesCount' => (clone $pendingCoursesQuery)->count(),
            'rejectedCourses' => (clone $rejectedCoursesQuery)->with('users')->orderByDesc('rejected_at')->orderByDesc('updated_at')->get(),
            'rejectedCoursesCount' => (clone $rejectedCoursesQuery)->count(),
            'activeUsersCount' => User::whereIn('role', $managedRoles)->where('profile_completed', true)->where('status', 'active')->count(),
            'pendingUsersTotal' => User::whereIn('role', $managedRoles)->where('profile_completed', true)->where('status', 'pending')->count(),
            'frozenUsersCount' => User::whereIn('role', $managedRoles)->where('profile_completed', true)->where('status', 'freeze')->count(),
            'publishedCoursesCount' => (clone $baseCourseQuery)->where('is_published', true)->count(),
            'unpublishedCoursesCount' => (clone $baseCourseQuery)->where('is_published', false)->count(),
            'certifications' => Certification::all(),
        ];
    }
}
