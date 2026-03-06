<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('barangays')) {
            return;
        }
        Schema::create('barangays', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->constrained('cities')->cascadeOnDelete();
            $table->string('barangay_code', 15)->nullable()->unique();
            $table->string('barangay_name');
            $table->timestamps();
            $table->unique(['city_id', 'barangay_name']);
            $table->index('city_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barangays');
    }
};
