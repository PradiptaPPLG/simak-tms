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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'routine_off_days')) {
                $table->json('routine_off_days')->nullable()->after('status');
            }
            if (!Schema::hasColumn('users', 'off_day_notes')) {
                $table->string('off_day_notes')->nullable()->after('routine_off_days');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'routine_off_days')) {
                $table->dropColumn('routine_off_days');
            }
            if (Schema::hasColumn('users', 'off_day_notes')) {
                $table->dropColumn('off_day_notes');
            }
        });
    }
};
