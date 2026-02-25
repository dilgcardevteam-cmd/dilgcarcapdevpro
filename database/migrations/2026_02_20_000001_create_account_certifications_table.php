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
        Schema::create('account_certifications', function (Blueprint $table) {
            $table->id();
            // 'account_id' maps to users.id, following the user's requested naming
            $table->foreignId('account_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('certification_id')->constrained('certifications')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['account_id', 'certification_id'], 'account_certifications_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_certifications');
    }
};

