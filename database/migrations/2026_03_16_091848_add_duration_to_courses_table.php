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
            if (!Schema::hasColumn('courses', 'trainer_id')) {
                $table->foreignId('trainer_id')->nullable()->constrained('users')->onDelete('set null');
            }
            if (!Schema::hasColumn('courses', 'start_date')) {
                $table->date('start_date')->nullable();
            }
            if (!Schema::hasColumn('courses', 'end_date')) {
                $table->date('end_date')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['trainer_id']);
            $table->dropColumn(['trainer_id', 'start_date', 'end_date']);
        });
    }
};
