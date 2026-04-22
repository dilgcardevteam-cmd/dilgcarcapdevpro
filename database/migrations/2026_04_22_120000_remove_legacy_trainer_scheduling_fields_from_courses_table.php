<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('courses')) {
            return;
        }

        if (
            Schema::hasColumn('courses', 'enrollment_start_date')
            && Schema::hasColumn('courses', 'enrollment_start')
        ) {
            DB::table('courses')
                ->whereNull('enrollment_start_date')
                ->whereNotNull('enrollment_start')
                ->update(['enrollment_start_date' => DB::raw('DATE(enrollment_start)')]);
        }

        if (
            Schema::hasColumn('courses', 'enrollment_end_date')
            && Schema::hasColumn('courses', 'enrollment_end')
        ) {
            DB::table('courses')
                ->whereNull('enrollment_end_date')
                ->whereNotNull('enrollment_end')
                ->update(['enrollment_end_date' => DB::raw('DATE(enrollment_end)')]);
        }

        if (
            Schema::hasColumn('courses', 'enrollment_start_at')
            && Schema::hasColumn('courses', 'enrollment_end_at')
        ) {
            try {
                Schema::table('courses', function (Blueprint $table) {
                    $table->dropIndex('courses_enrollment_window_idx');
                });
            } catch (\Throwable $e) {
                // The legacy index may not exist in databases migrated at different times.
            }
        }

        Schema::table('courses', function (Blueprint $table) {
            $columns = array_values(array_filter([
                Schema::hasColumn('courses', 'trainer_ready') ? 'trainer_ready' : null,
                Schema::hasColumn('courses', 'enrollment_start') ? 'enrollment_start' : null,
                Schema::hasColumn('courses', 'enrollment_end') ? 'enrollment_end' : null,
                Schema::hasColumn('courses', 'enrollment_start_at') ? 'enrollment_start_at' : null,
                Schema::hasColumn('courses', 'enrollment_end_at') ? 'enrollment_end_at' : null,
            ]));

            if ($columns) {
                $table->dropColumn($columns);
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('courses')) {
            return;
        }

        Schema::table('courses', function (Blueprint $table) {
            if (!Schema::hasColumn('courses', 'trainer_ready')) {
                $table->boolean('trainer_ready')->default(false);
            }
            if (!Schema::hasColumn('courses', 'enrollment_start')) {
                $table->dateTime('enrollment_start')->nullable();
            }
            if (!Schema::hasColumn('courses', 'enrollment_end')) {
                $table->dateTime('enrollment_end')->nullable();
            }
            if (!Schema::hasColumn('courses', 'enrollment_start_at')) {
                $table->date('enrollment_start_at')->nullable();
            }
            if (!Schema::hasColumn('courses', 'enrollment_end_at')) {
                $table->date('enrollment_end_at')->nullable();
            }
        });
    }
};
