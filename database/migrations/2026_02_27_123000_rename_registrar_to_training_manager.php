<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')->where('role', 'registrar')->update(['role' => 'training_manager']);
    }

    public function down(): void
    {
        DB::table('users')->where('role', 'training_manager')->update(['role' => 'registrar']);
    }
};
