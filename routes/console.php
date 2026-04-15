<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('users:normalize-account-ids {--dry-run}', function () {
    $dryRun = (bool) $this->option('dry-run');
    $total = 0;
    $updated = 0;

    User::query()->orderBy('id')->chunkById(200, function ($users) use (&$total, &$updated, $dryRun) {
        foreach ($users as $user) {
            $total++;
            $changed = $user->normalizeRoleForOffice();
            $changed = $user->ensureStandardAccountId() || $changed;
            if ($changed) {
                $updated++;
                if (!$dryRun) {
                    $user->saveQuietly();
                }
            }
        }
    });

    $this->info("Checked {$total} users. Updated {$updated}.");
})->purpose('Normalize user account_id to YY-RANDOMNUMBER-ROLECODE for active users');
