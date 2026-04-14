<?php

namespace App\Services;

use App\Models\User;
use App\Models\Course;
use App\Models\Certification;
use App\Models\AcademicYear;
use Illuminate\Support\Facades\Auth;

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

        $adminRoles = ['admin','super_admin','central_office_admin','regional_office_admin','provincial_office_admin'];

        $pendingCoursesQuery = Course::onlyTrashed()
            ->where(function ($query) use ($managedCoachRoles) {
                $query->whereIn('trainer_id', User::whereIn('role', $managedCoachRoles)->select('id'))
                    ->orWhereHas('users', function($q) use ($managedCoachRoles) {
                        $q->whereIn('role', $managedCoachRoles);
                    });
            });

        if ($selectedYearId !== 'all') {
            $pendingCoursesQuery->where('academic_year_id', $selectedYearId);
        }

        return [
            'userCount' => User::whereIn('role', $managedRoles)->where('profile_completed', true)->count(),
            'courseCount' => (clone $baseCourseQuery)->count(),
            'courses' => (clone $baseCourseQuery)->orderBy('created_at', 'desc')->get(),
            'archivedCourses' => (clone $baseCourseQuery)->onlyTrashed()->get(),
            'recentCourses' => (clone $baseCourseQuery)->latest()->take(5)->get(),
            'pendingCourses' => (clone $pendingCoursesQuery)->get(),
            'pendingCoursesCount' => (clone $pendingCoursesQuery)->count(),
            'activeUsersCount' => User::whereIn('role', $managedRoles)->where('profile_completed', true)->where('status', 'active')->count(),
            'pendingUsersTotal' => User::whereIn('role', $managedRoles)->where('profile_completed', true)->where('status', 'pending')->count(),
            'frozenUsersCount' => User::whereIn('role', $managedRoles)->where('profile_completed', true)->where('status', 'freeze')->count(),
            'publishedCoursesCount' => (clone $baseCourseQuery)->where('is_published', true)->count(),
            'unpublishedCoursesCount' => (clone $baseCourseQuery)->where('is_published', false)->count(),
            'certifications' => Certification::all(),
        ];
    }
}
