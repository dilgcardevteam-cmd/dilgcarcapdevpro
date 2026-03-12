<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            if (!Schema::hasColumn('courses', 'is_published')) {
                $table->boolean('is_published')->default(false)->after('modules');
                $table->index('is_published');
            }
        });
        try {
            if (Schema::hasColumn('courses', 'is_published')) {
                DB::table('courses')->update(['is_published' => true]);
            }
        } catch (\Throwable $e) {
            // ignore
        }
    }
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            if (Schema::hasColumn('courses', 'is_published')) {
                $table->dropIndex(['is_published']);
                $table->dropColumn('is_published');
            }
        });
    }
};
