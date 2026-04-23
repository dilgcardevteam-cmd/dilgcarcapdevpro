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

        Schema::table('courses', function (Blueprint $table) {
            if (!Schema::hasColumn('courses', 'submitted_by_user_id')) {
                $table->foreignId('submitted_by_user_id')->nullable()->after('trainer_id')->constrained('users')->nullOnDelete();
                $table->index('submitted_by_user_id');
            }
        });

        if (Schema::hasColumn('courses', 'submitted_by_user_id') && Schema::hasTable('notifications')) {
            try {
                DB::table('courses')
                    ->whereNull('submitted_by_user_id')
                    ->whereNotNull('trainer_id')
                    ->whereExists(function ($q) {
                        $q->select(DB::raw(1))
                            ->from('notifications')
                            ->where('notifications.type', 'course_submission')
                            ->whereRaw('notifications.related_id = courses.id');
                    })
                    ->update(['submitted_by_user_id' => DB::raw('trainer_id')]);
            } catch (\Throwable $e) {
            }
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('courses')) {
            return;
        }

        if (Schema::hasColumn('courses', 'submitted_by_user_id')) {
            Schema::table('courses', function (Blueprint $table) {
                try { $table->dropForeign(['submitted_by_user_id']); } catch (\Throwable $e) {}
                try { $table->dropIndex(['submitted_by_user_id']); } catch (\Throwable $e) {}
                $table->dropColumn('submitted_by_user_id');
            });
        }
    }
};

