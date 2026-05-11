<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('courses')) {
            return;
        }

        Schema::table('courses', function (Blueprint $table) {
            if (!Schema::hasColumn('courses', 'approval_status')) {
                $table->string('approval_status', 32)->nullable()->after('is_published')->index();
            }

            if (!Schema::hasColumn('courses', 'rejected_at')) {
                $table->timestamp('rejected_at')->nullable()->after('approval_status');
            }

            if (!Schema::hasColumn('courses', 'rejected_by_user_id')) {
                $table->foreignId('rejected_by_user_id')->nullable()->after('rejected_at')->constrained('users')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('courses')) {
            return;
        }

        Schema::table('courses', function (Blueprint $table) {
            if (Schema::hasColumn('courses', 'rejected_by_user_id')) {
                try {
                    $table->dropForeign(['rejected_by_user_id']);
                } catch (Throwable $e) {
                    //
                }
                $table->dropColumn('rejected_by_user_id');
            }

            if (Schema::hasColumn('courses', 'rejected_at')) {
                $table->dropColumn('rejected_at');
            }

            if (Schema::hasColumn('courses', 'approval_status')) {
                $table->dropColumn('approval_status');
            }
        });
    }
};
