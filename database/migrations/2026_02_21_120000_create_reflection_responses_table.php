<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reflection_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('module_index');
            $table->unsignedInteger('topic_index');
            $table->unsignedInteger('sub_index')->nullable();
            $table->json('questions_json')->nullable();
            $table->json('answers_json')->nullable();
            $table->timestamps();
            $table->unique(['user_id','course_id','module_index','topic_index','sub_index'], 'uniq_reflection_scope');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reflection_responses');
    }
};

