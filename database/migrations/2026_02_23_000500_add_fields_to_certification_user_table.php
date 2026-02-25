<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('certification_user', function (Blueprint $table) {
            $table->foreignId('course_id')->nullable()->after('user_id')->constrained()->onDelete('cascade');
            $table->string('certificate_number', 20)->nullable()->unique()->after('course_id');
            $table->timestamp('issued_at')->nullable()->after('certificate_number');
        });
    }

    public function down(): void
    {
        Schema::table('certification_user', function (Blueprint $table) {
            $table->dropConstrainedForeignId('course_id');
            $table->dropColumn('certificate_number');
            $table->dropColumn('issued_at');
        });
    }
};

