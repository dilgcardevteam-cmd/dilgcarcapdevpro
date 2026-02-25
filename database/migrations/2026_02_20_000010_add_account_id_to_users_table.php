<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('account_id', 12)->unique()->nullable()->after('id');
        });

        $users = DB::table('users')->orderBy('created_at')->get();
        $counters = [];

        foreach ($users as $u) {
            if (!empty($u->account_id)) {
                continue;
            }
            $createdAt = $u->created_at ?? now();
            $yy = \Carbon\Carbon::parse($createdAt)->format('y');
            $counters[$yy] = ($counters[$yy] ?? 0) + 1;
            $num = $counters[$yy];
            $lead4 = str_pad((string) intdiv($num, 1000), 4, '0', STR_PAD_LEFT);
            $tail3 = str_pad((string) ($num % 1000), 3, '0', STR_PAD_LEFT);
            $accountId = $yy . '-' . $lead4 . '-' . $tail3;
            DB::table('users')->where('id', $u->id)->update(['account_id' => $accountId]);
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['account_id']);
            $table->dropColumn('account_id');
        });
    }
};

