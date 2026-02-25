<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('discussion_reply_reactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('discussion_reply_id');
            $table->unsignedBigInteger('user_id');
            $table->enum('type', ['like','dislike']);
            $table->timestamps();
            $table->foreign('discussion_reply_id')->references('id')->on('discussion_replies')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['discussion_reply_id','user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discussion_reply_reactions');
    }
};
