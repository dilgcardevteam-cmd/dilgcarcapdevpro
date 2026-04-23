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
        Schema::table('exam_essay_responses', function (Blueprint $table) {
            $table->unsignedInteger('topic_index')->nullable()->after('module_index');
            $table->unsignedInteger('sub_index')->nullable()->after('topic_index');
            
            // Drop old unique constraint
            $table->dropUnique('exam_essay_unique_attempt_question');
            
            // Add new unique constraint including topic and sub index
            $table->unique(['course_id', 'trainee_id', 'module_index', 'topic_index', 'sub_index', 'question_index'], 'exam_essay_full_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exam_essay_responses', function (Blueprint $table) {
            $table->dropUnique('exam_essay_full_unique');
            $table->unique(['course_id', 'trainee_id', 'module_index', 'question_index'], 'exam_essay_unique_attempt_question');
            
            $table->dropColumn(['topic_index', 'sub_index']);
        });
    }
};
