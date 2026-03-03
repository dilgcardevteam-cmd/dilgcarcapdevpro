<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('certificate_generation_audits', function (Blueprint $table) {
            $table->id();
            $table->string('template_source', 256)->nullable();
            $table->string('recipient_name');
            $table->string('course_name');
            $table->string('certificate_number');
            $table->date('issued_at')->nullable();
            $table->unsignedBigInteger('generated_by')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('certificate_generation_audits');
    }
};

