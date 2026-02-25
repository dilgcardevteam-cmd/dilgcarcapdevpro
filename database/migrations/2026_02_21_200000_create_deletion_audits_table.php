<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('deletion_audits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id')->nullable()->index();
            $table->unsignedBigInteger('actor_id')->nullable()->index();
            $table->string('entity_type', 20);
            $table->unsignedBigInteger('entity_id');
            $table->string('action', 20); // soft_delete | force_delete
            $table->text('meta_json')->nullable();
            $table->timestamps();
            $table->index(['entity_type','entity_id']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('deletion_audits');
    }
};
