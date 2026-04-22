<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            if (!Schema::hasColumn('courses', 'course_expiration_date')) {
                $table->date('course_expiration_date')->nullable();
            }
            if (!Schema::hasColumn('courses', 'enrollment_start_date')) {
                $table->date('enrollment_start_date')->nullable();
            }
            if (!Schema::hasColumn('courses', 'enrollment_end_date')) {
                $table->date('enrollment_end_date')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['course_expiration_date', 'enrollment_start_date', 'enrollment_end_date']);
        });
    }
};
