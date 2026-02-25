<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('discussion_replies')) {
            Schema::create('discussion_replies', function (Blueprint $table) {
                $table->id();
                $table->foreignId('discussion_id')->constrained('discussions')->onDelete('cascade');
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->text('body');
                $table->timestamps();
                $table->index(['discussion_id', 'created_at']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('discussion_replies');
    }
};
