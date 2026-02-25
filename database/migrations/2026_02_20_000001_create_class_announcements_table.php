<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('class_announcements')) {
            Schema::create('class_announcements', function (Blueprint $table) {
                $table->id();
                $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->string('title');
                $table->text('body');
                $table->timestamps();
                $table->index(['course_id', 'created_at']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('class_announcements');
    }
};
