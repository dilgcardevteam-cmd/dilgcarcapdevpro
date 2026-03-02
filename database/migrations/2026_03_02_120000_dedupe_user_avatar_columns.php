<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('users')) return;

        $extraCols = [];
        foreach (['avatar','profile_image','photo','picture_url'] as $c) {
            if (Schema::hasColumn('users', $c)) $extraCols[] = $c;
        }

        if (!empty($extraCols)) {
            $users = DB::table('users')->select(array_merge(['id','profile_picture','updated_at'], $extraCols))->get();
            foreach ($users as $u) {
                $candidates = [];
                if (!empty($u->profile_picture)) $candidates[] = $u->profile_picture;
                foreach ($extraCols as $c) {
                    if (!empty($u->$c)) $candidates[] = $u->$c;
                }
                if (empty($candidates)) continue;

                $best = null; $bestMtime = -1;
                foreach ($candidates as $p) {
                    $rel = ltrim((string)$p, '/');
                    $mtime = Storage::disk('public')->exists($rel) ? Storage::disk('public')->lastModified($rel) : 0;
                    if ($mtime > $bestMtime) { $bestMtime = $mtime; $best = $rel; }
                }
                if (!$best) $best = $candidates[0];
                DB::table('users')->where('id', $u->id)->update(['profile_picture' => $best]);
            }
        }

        // Drop legacy columns to enforce single source of truth
        Schema::table('users', function (Blueprint $table) {
            foreach (['avatar','profile_image','photo','picture_url'] as $c) {
                if (Schema::hasColumn('users', $c)) {
                    $table->dropColumn($c);
                }
            }
        });
    }

    public function down(): void
    {
        // We won't recreate legacy columns; single source-of-truth remains profile_picture
    }
};

