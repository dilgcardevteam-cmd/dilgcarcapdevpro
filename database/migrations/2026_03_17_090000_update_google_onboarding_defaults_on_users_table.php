<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'agency')) {
                $table->string('agency')->nullable()->after('gender');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->nullable()->default(null)->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('trainee')->change();
        });

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'agency')) {
                $table->dropColumn('agency');
            }
        });
    }
};
