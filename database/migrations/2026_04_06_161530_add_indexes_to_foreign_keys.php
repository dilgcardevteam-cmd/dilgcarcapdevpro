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
        /*
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role')) {
                $table->index('role');
            }
            if (Schema::hasColumn('users', 'status')) {
                $table->index('status');
            }
        });
        Schema::table('course_user', function (Blueprint $table) {
            if (Schema::hasColumn('course_user', 'status')) {
                $table->index('status');
            }
        });
        Schema::table('notifications', function (Blueprint $table) {
            if (Schema::hasColumn('notifications', 'is_read')) {
                $table->index('is_read');
            }
        });
        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role')) {
                $table->dropIndex(['role']);
            }
            if (Schema::hasColumn('users', 'status')) {
                $table->dropIndex(['status']);
            }
        });
        Schema::table('course_user', function (Blueprint $table) {
            if (Schema::hasColumn('course_user', 'status')) {
                $table->dropIndex(['status']);
            }
        });
        Schema::table('notifications', function (Blueprint $table) {
            if (Schema::hasColumn('notifications', 'is_read')) {
                $table->dropIndex(['is_read']);
            }
        });
    }
};
