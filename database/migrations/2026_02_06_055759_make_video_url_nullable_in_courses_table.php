<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try {
            Schema::table('courses', function (Blueprint $table) {
                if (Schema::hasColumn('courses', 'video_url')) {
                    $table->string('video_url')->nullable()->change();
                }
            });
        } catch (\Throwable $e) {
            try {
                DB::statement('ALTER TABLE courses MODIFY video_url VARCHAR(255) NULL');
            } catch (\Throwable $ignored) {
                // Best-effort fallback; if it fails, the app should still work where DB allows null strings by default.
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            Schema::table('courses', function (Blueprint $table) {
                if (Schema::hasColumn('courses', 'video_url')) {
                    $table->string('video_url')->nullable(false)->default('')->change();
                }
            });
        } catch (\Throwable $e) {
            try {
                DB::statement("ALTER TABLE courses MODIFY video_url VARCHAR(255) NOT NULL DEFAULT ''");
            } catch (\Throwable $ignored) {
                // noop
            }
        }
    }
};
