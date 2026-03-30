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
        Schema::table('course_user', function (Blueprint $table) {
            if (!Schema::hasColumn('course_user', 'retake_requested')) {
                $table->boolean('retake_requested')->default(false)->after('status');
            }
            if (!Schema::hasColumn('course_user', 'retake_approved')) {
                $table->boolean('retake_approved')->default(false)->after('retake_requested');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_user', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('course_user', 'retake_requested')) {
                $columns[] = 'retake_requested';
            }
            if (Schema::hasColumn('course_user', 'retake_approved')) {
                $columns[] = 'retake_approved';
            }
            if ($columns) {
                $table->dropColumn($columns);
            }
        });
    }
};
