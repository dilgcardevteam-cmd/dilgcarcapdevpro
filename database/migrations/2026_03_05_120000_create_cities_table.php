<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('cities')) {
            return;
        }
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('province_id')->constrained('provinces')->cascadeOnDelete();
            $table->string('city_code', 15)->nullable()->unique();
            $table->string('city_name');
            $table->timestamps();
            $table->unique(['province_id', 'city_name']);
            $table->index('province_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
