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
        ];

        foreach ($roles as $r) {
            Role::updateOrCreate(['name' => $r['name']], ['display_name' => $r['display_name']]);
        }
    }
}
