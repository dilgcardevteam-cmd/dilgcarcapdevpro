<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class UnifiedPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $adminCore = [
            'view_monitoring',
            'view_users', 'edit_users',
            'view_courses', 'create_courses', 'edit_courses', 'delete_courses',
            'view_certifications', 'create_certifications', 'delete_certifications',
        ];

        $trainingManagerCore = [
            'view_training',
            'view_users_tm', 'update_users_tm',
            'add_training', 'update_training',
            'view_course_monitoring',
            'view_reports',
            'view_courses', 'create_courses', 'edit_courses', 'delete_courses',
        ];

        $coachCore = [
            'view_courses_coach',
            'add_courses_coach', 'update_courses_coach', 'delete_courses_coach',
            'view_classes',
            'view_communication',
            'view_certifications', 'create_certifications',
        ];

        $participantCore = [
            'view_modules',
            'view_assessments', 'add_assessments',
            'view_progress',
            'view_engagement', 'add_engagement', 'update_engagement', 'delete_engagement',
        ];

        $superAdminOnly = [
            'view_access_control', 'edit_access_control',
            'view_system_settings',
        ];

        $perms = array_values(array_unique(array_merge(
            $adminCore,
            $trainingManagerCore,
            $coachCore,
            $participantCore,
            $superAdminOnly
        )));

        foreach ($perms as $name) {
            $displayName = ucwords(str_replace('_', ' ', $name));
            Permission::updateOrCreate(['name' => $name], ['display_name' => $displayName]);
        }

        $this->seedDefaultRolePermissions(
            $adminCore,
            $trainingManagerCore,
            $coachCore,
            $participantCore
        );
    }

    private function seedDefaultRolePermissions(
        array $adminCore,
        array $trainingManagerCore,
        array $coachCore,
        array $participantCore
    ): void {
        $roleToPerms = [
            'admin' => $adminCore,
            'central_office_admin' => $adminCore,
            'regional_office_admin' => $adminCore,
            'provincial_office_admin' => $adminCore,

            'training_manager' => $trainingManagerCore,
            'registrar' => $trainingManagerCore,
            'central_office_training_manager' => $trainingManagerCore,
            'regional_office_training_manager' => $trainingManagerCore,
            'provincial_office_training_manager' => $trainingManagerCore,

            'coach' => $coachCore,
            'trainer' => $coachCore,
            'central_office_coach' => $coachCore,
            'regional_office_coach' => $coachCore,
            'provincial_office_coach' => $coachCore,

            'participant' => $participantCore,
            'trainee' => $participantCore,
            'central_office_participants' => $participantCore,
            'regional_office_participants' => $participantCore,
            'provincial_office_participants' => $participantCore,
            'central_office_participant' => $participantCore,
            'regional_office_participant' => $participantCore,
            'provincial_office_participant' => $participantCore,
        ];

        $permIdsByName = function (array $permNames): array {
            return Permission::whereIn('name', $permNames)->pluck('id')->toArray();
        };

        foreach ($roleToPerms as $roleName => $permNames) {
            $role = Role::where('name', $roleName)->first();
            if (!$role) {
                continue;
            }
            $permIds = $permIdsByName($permNames);
            if (empty($permIds)) {
                continue;
            }

            $role->permissions()->sync($permIds);
        }
    }
}
