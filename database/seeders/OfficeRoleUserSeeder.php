<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class OfficeRoleUserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Central Office Admin', 'email' => 'co_admin@gmail.com', 'role' => 'central_office_admin'],
            ['name' => 'Central Office Training Manager', 'email' => 'co_tm@gmail.com', 'role' => 'central_office_training_manager'],
            ['name' => 'Central Office Coach', 'email' => 'co_coach@gmail.com', 'role' => 'central_office_coach'],
            ['name' => 'Central Office Participant', 'email' => 'co_participant@gmail.com', 'role' => 'central_office_participants'],
            ['name' => 'Regional Office Admin', 'email' => 'ro_admin@gmail.com', 'role' => 'regional_office_admin'],
            ['name' => 'Regional Office Training Manager', 'email' => 'ro_tm@gmail.com', 'role' => 'regional_office_training_manager'],
            ['name' => 'Regional Office Coach', 'email' => 'ro_coach@gmail.com', 'role' => 'regional_office_coach'],
            ['name' => 'Regional Office Participant', 'email' => 'ro_participant@gmail.com', 'role' => 'regional_office_participants'],
            ['name' => 'Provincial Office Admin', 'email' => 'po_admin@gmail.com', 'role' => 'provincial_office_admin'],
            ['name' => 'Provincial Office Training Manager', 'email' => 'po_tm@gmail.com', 'role' => 'provincial_office_training_manager'],
            ['name' => 'Provincial Office Coach', 'email' => 'po_coach@gmail.com', 'role' => 'provincial_office_coach'],
            ['name' => 'Provincial Office Participant', 'email' => 'po_participant@gmail.com', 'role' => 'provincial_office_participants'],
        ];
        foreach ($users as $u) {
            User::updateOrCreate(
                ['email' => $u['email']],
                [
                    'name' => $u['name'],
                    'password' => Hash::make('password123'),
                    'role' => $u['role'],
                    'region' => in_array($u['role'], ['central_office_admin','central_office_training_manager','central_office_coach','central_office_participants']) ? 'DILG Central Office'
                        : (in_array($u['role'], ['regional_office_admin','regional_office_training_manager','regional_office_coach','regional_office_participants']) ? 'DILG Regional Office'
                        : 'DILG Provincial Office'),
                    'province' => in_array($u['role'], ['central_office_admin','central_office_training_manager','central_office_coach','central_office_participants']) ? 'Bureaus' : 'DILG Cordillera Administrative Region (CAR) Office',
                    'city' => in_array($u['role'], ['central_office_admin','central_office_training_manager','central_office_coach','central_office_participants']) ? 'Bureau of Local Government Development (BLGD)' : null,
                    'barangay' => null,
                    'status' => 'active',
                    'profile_completed' => true,
                    'profile_completed_at' => now(),
                ]
            );
        }
    }
}
