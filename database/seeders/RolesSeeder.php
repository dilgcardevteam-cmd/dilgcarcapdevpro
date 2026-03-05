<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'super_admin', 'display_name' => 'Super Admin'],
            ['name' => 'admin', 'display_name' => 'Admin'],
            ['name' => 'registrar', 'display_name' => 'Registrar'],
            ['name' => 'training_manager', 'display_name' => 'Training Manager'],
            ['name' => 'coach', 'display_name' => 'Coach'],
            ['name' => 'trainer', 'display_name' => 'Trainer'],
            ['name' => 'participant', 'display_name' => 'Participant'],
            ['name' => 'trainee', 'display_name' => 'Trainee'],
            // Office-level variants
            ['name' => 'central_office_admin', 'display_name' => 'Central Office Admin'],
            ['name' => 'regional_office_admin', 'display_name' => 'Regional Office Admin'],
            ['name' => 'provincial_office_admin', 'display_name' => 'Provincial Office Admin'],
            ['name' => 'central_office_training_manager', 'display_name' => 'Central Office Training Manager'],
            ['name' => 'regional_office_training_manager', 'display_name' => 'Regional Office Training Manager'],
            ['name' => 'provincial_office_training_manager', 'display_name' => 'Provincial Office Training Manager'],
            ['name' => 'central_office_coach', 'display_name' => 'Central Office Coach'],
            ['name' => 'regional_office_coach', 'display_name' => 'Regional Office Coach'],
            ['name' => 'provincial_office_coach', 'display_name' => 'Provincial Office Coach'],
            ['name' => 'central_office_participants', 'display_name' => 'Central Office Participants'],
            ['name' => 'regional_office_participants', 'display_name' => 'Regional Office Participants'],
            ['name' => 'provincial_office_participants', 'display_name' => 'Provincial Office Participants'],
        ];

        foreach ($roles as $r) {
            Role::updateOrCreate(['name' => $r['name']], ['display_name' => $r['display_name']]);
        }
    }
}
