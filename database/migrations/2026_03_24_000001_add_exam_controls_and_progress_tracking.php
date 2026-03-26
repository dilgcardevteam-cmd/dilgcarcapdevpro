<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assessments', function (Blueprint $table) {
            if (!Schema::hasColumn('assessments', 'passing_score')) {
                $table->unsignedInteger('passing_score')->nullable()->after('questions_json');
            }
            if (!Schema::hasColumn('assessments', 'max_attempts')) {
                $table->unsignedInteger('max_attempts')->nullable()->after('passing_score');
            }
        });

        Schema::table('grades', function (Blueprint $table) {
            if (!Schema::hasColumn('grades', 'attempt_no')) {
                $table->unsignedInteger('attempt_no')->default(1)->after('feedback');
            }
            if (!Schema::hasColumn('grades', 'is_retake')) {
                $table->boolean('is_retake')->default(false)->after('attempt_no');
            }
        });

        Schema::table('course_user', function (Blueprint $table) {
            if (!Schema::hasColumn('course_user', 'current_module')) {
                $table->unsignedInteger('current_module')->default(1)->after('status');
            }
            if (!Schema::hasColumn('course_user', 'progress_percentage')) {
                $table->decimal('progress_percentage', 5, 2)->default(0)->after('current_module');
            }
        });
    }

    public function down(): void
    {
        Schema::table('course_user', function (Blueprint $table) {
            if (Schema::hasColumn('course_user', 'progress_percentage')) {
                $table->dropColumn('progress_percentage');
            }
            if (Schema::hasColumn('course_user', 'current_module')) {
                $table->dropColumn('current_module');
            }
        });

        Schema::table('grades', function (Blueprint $table) {
            if (Schema::hasColumn('grades', 'is_retake')) {
                $table->dropColumn('is_retake');
            }
            if (Schema::hasColumn('grades', 'attempt_no')) {
                $table->dropColumn('attempt_no');
            }
        });

        Schema::table('assessments', function (Blueprint $table) {
            if (Schema::hasColumn('assessments', 'max_attempts')) {
                $table->dropColumn('max_attempts');
            }
            if (Schema::hasColumn('assessments', 'passing_score')) {
                $table->dropColumn('passing_score');
            }
        });
    }
};
