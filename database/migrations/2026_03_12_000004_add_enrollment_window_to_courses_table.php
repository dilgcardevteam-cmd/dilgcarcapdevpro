<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            if (!Schema::hasColumn('courses', 'enrollment_start_at')) {
                $table->date('enrollment_start_at')->nullable()->after('is_published');
            }
            if (!Schema::hasColumn('courses', 'enrollment_end_at')) {
                $table->date('enrollment_end_at')->nullable()->after('enrollment_start_at');
            }
            if (Schema::hasColumn('courses', 'enrollment_start_at') && Schema::hasColumn('courses', 'enrollment_end_at')) {
                $table->index(['enrollment_start_at', 'enrollment_end_at'], 'courses_enrollment_window_idx');
            }
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            if (Schema::hasIndex('courses', 'courses_enrollment_window_idx')) {
                $table->dropIndex('courses_enrollment_window_idx');
            }
            if (Schema::hasColumn('courses', 'enrollment_end_at')) {
                $table->dropColumn('enrollment_end_at');
            }
            if (Schema::hasColumn('courses', 'enrollment_start_at')) {
                $table->dropColumn('enrollment_start_at');
            }
        });
    }
};
