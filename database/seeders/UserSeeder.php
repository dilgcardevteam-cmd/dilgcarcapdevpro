<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin User',
                'email' => 'superadmin@gmail.com',
                'password' => 'superadmin123',
                'role' => 'super_admin',
                'region' => 'CAR (Cordillera Administrative Region)',
                'province' => 'Benguet',
                'city' => 'City of Baguio',
                'barangay' => 'Balsigan',
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'password' => 'admin123',
                'role' => 'admin',
                'region' => 'CAR (Cordillera Administrative Region)',
                'province' => 'Benguet',
                'city' => 'City of Baguio',
                'barangay' => 'Balsigan',
            ],
            [
                'name' => 'Registrar User',
                'email' => 'registrar@gmail.com',
                'password' => 'registrar123',
                'role' => 'registrar',
                'region' => 'CAR (Cordillera Administrative Region)',
                'province' => 'Benguet',
                'city' => 'City of Baguio',
                'barangay' => 'Balsigan',
            ],
            [
                'name' => 'Trainer User',
                'email' => 'trainer@gmail.com',
                'password' => 'trainer123',
                'role' => 'trainer',
                'region' => 'CAR (Cordillera Administrative Region)',
                'province' => 'Benguet',
                'city' => 'City of Baguio',
                'barangay' => 'Balsigan',
            ],
            [
                'name' => 'Trainee User',
                'email' => 'trainee@gmail.com',
                'password' => 'trainee123',
                'role' => 'trainee',
                'region' => 'CAR (Cordillera Administrative Region)',
                'province' => 'Benguet',
                'city' => 'City of Baguio',
                'barangay' => 'Balsigan',
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']], // Check by email to avoid duplicates
                [
                    'name' => $userData['name'],
                    'password' => Hash::make($userData['password']),
                    'role' => $userData['role'],
                    'region' => $userData['region'],
                    'province' => $userData['province'],
                    'city' => $userData['city'],
                    'barangay' => $userData['barangay'],
                    'status' => 'active',
                ]
            );
        }
    }
}
