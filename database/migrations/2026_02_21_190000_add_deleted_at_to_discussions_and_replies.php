<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('discussions', function (Blueprint $table) {
            if (!Schema::hasColumn('discussions', 'deleted_at')) {
                $table->softDeletes();
            }
        });
        Schema::table('discussion_replies', function (Blueprint $table) {
            if (!Schema::hasColumn('discussion_replies', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }
    public function down(): void
    {
        Schema::table('discussions', function (Blueprint $table) {
            if (Schema::hasColumn('discussions', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
        Schema::table('discussion_replies', function (Blueprint $table) {
            if (Schema::hasColumn('discussion_replies', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
};
