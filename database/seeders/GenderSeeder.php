<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class GenderSeeder extends Seeder
{
    public function run(): void
    {
        $this->command?->info('Seeding gender values for users');

        $regions = User::selectRaw('COALESCE(region, "") as region')->distinct()->pluck('region');
        $updated = 0;

        foreach ($regions as $region) {
            $users = User::where('region', $region)->orderBy('id')->get();
            if ($users->isEmpty()) {
                continue;
            }
            $i = 0;
            foreach ($users as $user) {
                // Skip if already has gender
                $g = strtolower(trim((string) $user->gender));
                if (in_array($g, ['male', 'female'])) {
                    continue;
                }
                $user->gender = ($i % 2 === 0) ? 'Male' : 'Female';
                $user->save();
                $updated++;
                $i++;
            }
        }

        $this->command?->info("Gender seeding done. Updated {$updated} user(s).");
    }
}
