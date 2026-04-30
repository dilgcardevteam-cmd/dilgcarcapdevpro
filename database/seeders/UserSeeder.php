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
                'mobile_number' => '09999999999',
                'gender' => 'Male',
                'agency' => 'LGU',
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
                'mobile_number' => '09999999998',
                'gender' => 'Female',
                'agency' => 'LGU',
                'region' => 'CAR (Cordillera Administrative Region)',
                'province' => 'Benguet',
                'city' => 'City of Baguio',
                'barangay' => 'Balsigan',
            ],
            [
                'name' => 'Training Manager User',
                'email' => 'trainingmanager@gmail.com',
                'password' => 'trainingmanager123',
                'role' => 'training_manager',
                'mobile_number' => '09999999997',
                'gender' => 'Male',
                'agency' => 'LGU',
                'region' => 'CAR (Cordillera Administrative Region)',
                'province' => 'Benguet',
                'city' => 'City of Baguio',
                'barangay' => 'Balsigan',
            ],
            [
                'name' => 'Coach User',
                'email' => 'coach@gmail.com',
                'password' => 'coach123',
                'role' => 'coach',
                'mobile_number' => '09999999996',
                'gender' => 'Female',
                'agency' => 'LGU',
                'region' => 'CAR (Cordillera Administrative Region)',
                'province' => 'Benguet',
                'city' => 'City of Baguio',
                'barangay' => 'Balsigan',
            ],
            [
                'name' => 'Participant User',
                'email' => 'participant@gmail.com',
                'password' => 'participant123',
                'role' => 'participant',
                'mobile_number' => '09999999995',
                'gender' => 'Male',
                'agency' => 'LGU',
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
                    'mobile_number' => $userData['mobile_number'] ?? null,
                    'gender' => $userData['gender'] ?? null,
                    'agency' => $userData['agency'] ?? null,
                    'region' => $userData['region'],
                    'province' => $userData['province'],
                    'city' => $userData['city'],
                    'barangay' => $userData['barangay'],
                    'status' => 'active',
                    'profile_completed' => true,
                    'profile_completed_at' => now(),
                ]
            );
        }
    }
}
