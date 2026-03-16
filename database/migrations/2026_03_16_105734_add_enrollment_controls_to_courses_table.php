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
            if (!Schema::hasColumn('courses', 'trainer_ready')) {
                $table->boolean('trainer_ready')->default(false);
            }
            if (!Schema::hasColumn('courses', 'enrollment_start')) {
                $table->dateTime('enrollment_start')->nullable();
            }
            if (!Schema::hasColumn('courses', 'enrollment_end')) {
                $table->dateTime('enrollment_end')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['trainer_ready', 'enrollment_start', 'enrollment_end']);
        });
    }
};
