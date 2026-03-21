<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class UnifiedPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $perms = [
            // Admin Core
            'view_users', 'create_users', 'edit_users', 'delete_users',
            'view_courses', 'create_courses', 'edit_courses', 'delete_courses',
            'view_certifications', 'create_certifications', 'edit_certifications', 'delete_certifications',
            'view_monitoring', 'view_access_control', 'edit_access_control',
            
            // Training Manager Core
            'view_users_tm', 'update_users_tm',
            'view_training', 'add_training', 'update_training', 'delete_training',
            'view_course_monitoring', 'view_reports',
            
            // Coach Core
            'view_courses_coach', 'add_courses_coach', 'update_courses_coach',
            'view_classes', 'add_classes', 'update_classes', 'delete_classes',
            'view_students', 'update_students',
            'view_communication', 'add_communication', 'update_communication', 'delete_communication',
            
            // Participant Core
            'view_modules', 'view_assessments', 'add_assessments', 'view_progress', 'view_engagement',
            'add_engagement', 'update_engagement', 'delete_engagement'
        ];

        foreach ($perms as $name) {
            $displayName = ucwords(str_replace('_', ' ', $name));
            Permission::updateOrCreate(['name' => $name], ['display_name' => $displayName]);
        }
    }
}
