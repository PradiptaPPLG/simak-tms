<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('app_settings')) {
            Schema::create('app_settings', function (Blueprint $table) {
                $table->id();
                $table->string('key', 100)->unique();
                $table->text('value')->nullable();
                $table->timestamps();
            });
        }

        $defaults = [
            'director_name' => 'Dani Ramdhani, S.T.',
            'director_signature_name' => 'Dani Ramdhani',
            'director_title' => 'Direktur Utama PT. TMS',
        ];

        foreach ($defaults as $k => $v) {
            DB::table('app_settings')->updateOrInsert(
                ['key' => $k],
                ['value' => $v, 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('app_settings');
    }
};
