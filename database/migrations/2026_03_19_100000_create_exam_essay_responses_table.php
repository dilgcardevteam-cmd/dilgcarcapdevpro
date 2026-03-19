<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exam_essay_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('trainee_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedInteger('module_index');
            $table->unsignedInteger('question_index');
            $table->text('question_text')->nullable();
            $table->longText('answer_text')->nullable();
            $table->decimal('max_points', 8, 2)->default(1);
            $table->decimal('score', 8, 2)->nullable();
            $table->longText('feedback')->nullable();
            $table->foreignId('checked_by_trainer')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('checked_at')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->string('status', 20)->default('pending');
            $table->timestamps();

            $table->unique(['course_id', 'trainee_id', 'module_index', 'question_index'], 'exam_essay_unique_attempt_question');
            $table->index(['course_id', 'module_index', 'status'], 'exam_essay_status_lookup');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_essay_responses');
    }
};
