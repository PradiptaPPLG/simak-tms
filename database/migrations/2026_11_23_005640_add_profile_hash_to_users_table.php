<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_hash', 64)->nullable()->unique()->after('account_id');
        });

        // Generate profile_hash untuk seluruh data user yang ada
        $users = DB::table('users')->get();
        $appKey = config('app.key') ?: 'simak_tms_secret_key';
        foreach ($users as $user) {
            $hash = substr(hash_hmac('sha256', 'simak_user_' . $user->id . '_' . ($user->account_id ?? 'acc'), $appKey), 0, 16);
            DB::table('users')->where('id', $user->id)->update(['profile_hash' => $hash]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('profile_hash');
        });
    }
};
