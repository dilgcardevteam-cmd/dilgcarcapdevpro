<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessment_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->enum('type', ['seatwork','quiz','exam']);
            $table->text('description')->nullable();
            $table->json('questions_json');
            $table->timestamps();
            $table->index(['user_id','type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessment_templates');
    }
};
