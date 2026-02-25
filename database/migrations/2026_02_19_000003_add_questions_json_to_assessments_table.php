<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('assessments', 'questions_json')) {
            Schema::table('assessments', function (Blueprint $table) {
                $table->json('questions_json')->nullable()->after('description');
            });
        }
        if (Schema::hasColumn('assessments', 'file_path')) {
            Schema::table('assessments', function (Blueprint $table) {
                $table->dropColumn('file_path');
            });
        }
    }

    public function down(): void
    {
        Schema::table('assessments', function (Blueprint $table) {
            if (!Schema::hasColumn('assessments', 'file_path')) {
                $table->string('file_path')->nullable();
            }
            if (Schema::hasColumn('assessments', 'questions_json')) {
                $table->dropColumn('questions_json');
            }
        });
    }
};
