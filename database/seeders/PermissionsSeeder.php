<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $perms = [
            ['name' => 'view_dashboard', 'display_name' => 'View Dashboard'],
            ['name' => 'manage_users', 'display_name' => 'Manage Users'],
            ['name' => 'edit_user', 'display_name' => 'Edit User'],
            ['name' => 'delete_user', 'display_name' => 'Delete User'],
            ['name' => 'manage_courses', 'display_name' => 'Manage Courses'],
            ['name' => 'create_course', 'display_name' => 'Create Course'],
            ['name' => 'approve_course', 'display_name' => 'Approve Course'],
            ['name' => 'edit_course', 'display_name' => 'Edit Course'],
            ['name' => 'delete_course', 'display_name' => 'Delete Course'],
            ['name' => 'manage_certifications', 'display_name' => 'Manage Certifications'],
            ['name' => 'issue_certificates', 'display_name' => 'Issue Certificates'],
            ['name' => 'edit_certificates', 'display_name' => 'Edit Certificates'],
            ['name' => 'manage_materials', 'display_name' => 'Manage Materials'],
            ['name' => 'manage_assessments', 'display_name' => 'Manage Assessments'],
            ['name' => 'manage_discussions', 'display_name' => 'Manage Discussions'],
            ['name' => 'manage_notifications', 'display_name' => 'Manage Notifications'],
        ];
        foreach ($perms as $p) {
            Permission::updateOrCreate(['name' => $p['name']], ['display_name' => $p['display_name']]);
        }
    }
}
