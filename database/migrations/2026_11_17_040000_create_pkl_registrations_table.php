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
        if (!Schema::hasTable('pkl_registrations')) {
            Schema::create('pkl_registrations', function (Blueprint $table) {
                $table->id();
                $table->string('registration_code', 30)->unique();
                $table->string('full_name', 100);
                $table->string('gender', 20); // Laki-laki / Perempuan
                $table->string('nis', 40);
                $table->string('birth_place', 100)->nullable();
                $table->date('birth_date')->nullable();
                $table->string('religion', 50)->nullable();
                $table->string('skill_competency', 100); // PPLG, RPL, TKJ, dll
                $table->string('school_origin', 150)->nullable()->default('SMKN 1 Ciamis');
                $table->string('email', 150);
                $table->string('phone_number', 30);
                $table->string('status', 30)->default('pending'); // pending, approved, rejected
                $table->text('rejection_reason')->nullable();
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pkl_registrations');
    }
};
