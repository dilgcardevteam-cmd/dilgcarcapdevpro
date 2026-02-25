<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('class_comments')) {
            Schema::create('class_comments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('class_announcement_id')->constrained('class_announcements')->onDelete('cascade');
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->text('body');
                $table->timestamps();
                $table->index(['class_announcement_id', 'created_at']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('class_comments');
    }
};
