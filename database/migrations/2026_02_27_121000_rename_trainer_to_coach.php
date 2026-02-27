<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')->where('role', 'trainer')->update(['role' => 'coach']);
    }

    public function down(): void
    {
        DB::table('users')->where('role', 'coach')->update(['role' => 'trainer']);
    }
};
