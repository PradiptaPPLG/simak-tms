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
        // 1. Partner Institutions (Asal Sekolah / Kampus Mitra PT. TMS)
        if (!Schema::hasTable('partner_institutions')) {
            Schema::create('partner_institutions', function (Blueprint $table) {
                $table->id();
                $table->string('name', 150);
                $table->string('type', 50)->default('SMK'); // SMK, Universitas, Politeknik
                $table->text('address')->nullable();
                $table->string('city', 100)->nullable()->default('Ciamis');
                $table->string('pic_name', 150)->nullable(); // Guru / Dosen Pembimbing
                $table->string('pic_phone', 30)->nullable();
                $table->string('pic_email', 100)->nullable();
                $table->string('mou_number', 100)->nullable();
                $table->date('mou_date')->nullable();
                $table->string('status', 30)->default('aktif');
                $table->timestamps();
            });
        }

        // 2. Extra columns in users (NIS/NIM, Periode PKL, Status Kelulusan & Alumni)
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'nis_nim')) {
                $table->string('nis_nim', 50)->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'internship_period')) {
                $table->string('internship_period', 120)->nullable()->default('1 Juli 2026 – 31 Desember 2026');
            }
            if (!Schema::hasColumn('users', 'status')) {
                $table->string('status', 30)->default('aktif'); // 'aktif', 'selesai', 'alumni'
            }
            if (!Schema::hasColumn('users', 'alumni_status')) {
                $table->string('alumni_status', 50)->nullable(); // 'kuliah', 'bekerja', 'direkrut_tms', 'mencari_kerja'
            }
            if (!Schema::hasColumn('users', 'alumni_current_at')) {
                $table->string('alumni_current_at', 150)->nullable();
            }
        });

        // 3. Extra columns in showcase_projects (Kategori & Status Deploy Project)
        Schema::table('showcase_projects', function (Blueprint $table) {
            if (!Schema::hasColumn('showcase_projects', 'project_category')) {
                $table->string('project_category', 80)->default('Web Application');
            }
            if (!Schema::hasColumn('showcase_projects', 'status')) {
                $table->string('status', 50)->default('Completed & Deployed');
            }
        });

        // 4. Extra columns in evaluations (Tanggal Terbit & Status Sertifikat)
        Schema::table('evaluations', function (Blueprint $table) {
            if (!Schema::hasColumn('evaluations', 'issue_date')) {
                $table->date('issue_date')->nullable();
            }
            if (!Schema::hasColumn('evaluations', 'is_published')) {
                $table->boolean('is_published')->default(true);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partner_institutions');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nis_nim', 'internship_period', 'status', 'alumni_status', 'alumni_current_at']);
        });

        Schema::table('showcase_projects', function (Blueprint $table) {
            $table->dropColumn(['project_category', 'status']);
        });

        Schema::table('evaluations', function (Blueprint $table) {
            $table->dropColumn(['issue_date', 'is_published']);
        });
    }
};
