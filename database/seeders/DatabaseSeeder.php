<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Batches
        $batch2026 = DB::table('batches')->insertGetId([
            'batch_name' => 'Angkatan 2026 - Gelombang 1',
            'period_year' => 2026,
            'start_date' => '2026-11-16',
            'end_date' => '2027-04-16',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $batch2025 = DB::table('batches')->insertGetId([
            'batch_name' => 'Angkatan 2025 - Gelombang 2',
            'period_year' => 2025,
            'start_date' => '2025-10-01',
            'end_date' => '2026-03-31',
            'is_active' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Users
        $siswaId = DB::table('users')->insertGetId([
            'batch_id' => $batch2026,
            'account_id' => '93777',
            'username' => '93777',
            'name' => 'Alyzza Nazwa',
            'email' => 'alyzza@tms.co.id',
            'password' => Hash::make('tmshebatsukses'),
            'role' => 'siswa',
            'school_origin' => 'SMKN 1 Ciamis',
            'major' => 'PPLG (Pengembangan Perangkat Lunak & Gim)',
            'phone_number' => '081234567890',
            'avatar' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $mentorId = DB::table('users')->insertGetId([
            'batch_id' => null,
            'account_id' => '16827',
            'username' => '16827',
            'name' => 'Farhan Ramadhan',
            'email' => 'mentor@tms.co.id',
            'password' => Hash::make('tmshebatsukses'),
            'role' => 'mentor',
            'school_origin' => 'PT. Teknologi Multi Sistem',
            'major' => 'Senior Software Engineer / Tech Lead',
            'headline' => 'Senior Software Engineer / Tech Lead',
            'bio' => 'Lead Engineer di PT. TMS, membidangi arsitektur web modern, cloud architecture, dan pembimbingan teknis siswa PKL.',
            'phone_number' => '085223035426',
            'location' => 'Lab Software TMS',
            'avatar' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $mentorAlif = DB::table('users')->insertGetId([
            'batch_id' => null,
            'name' => 'Alif Maulana, S.Kom',
            'email' => 'alif@tms.co.id',
            'password' => Hash::make('password'),
            'role' => 'mentor',
            'school_origin' => 'PT. Teknologi Multi Sistem',
            'major' => 'Senior Backend Engineer & Cloud Architect',
            'headline' => 'Senior Backend Engineer & Cloud Architect',
            'bio' => 'Spesialis RESTful API, database optimization, CI/CD pipeline, dan arsitektur backend TMS.',
            'phone_number' => '081398765432',
            'location' => 'Lab Software TMS',
            'avatar' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $mentorDina = DB::table('users')->insertGetId([
            'batch_id' => null,
            'name' => 'Dina Septiani, M.Cs',
            'email' => 'dina@tms.co.id',
            'password' => Hash::make('password'),
            'role' => 'mentor',
            'school_origin' => 'PT. Teknologi Multi Sistem',
            'major' => 'Lead UI/UX Designer & Frontend Engineer',
            'headline' => 'Lead UI/UX Designer & Frontend Engineer',
            'bio' => 'Memfokuskan pada riset pengalaman pengguna, design system modern, dan frontend framework.',
            'phone_number' => '082145678901',
            'location' => 'Lab Software TMS',
            'avatar' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $mentorHendra = DB::table('users')->insertGetId([
            'batch_id' => null,
            'name' => 'Hendra Wijaya, S.T.',
            'email' => 'hendra@tms.co.id',
            'password' => Hash::make('password'),
            'role' => 'mentor',
            'school_origin' => 'PT. Teknologi Multi Sistem',
            'major' => 'Mobile App & Flutter Specialist',
            'headline' => 'Mobile App & Flutter Specialist',
            'bio' => 'Membimbing integrasi REST API dengan aplikasi mobile Flutter dan Android Native.',
            'phone_number' => '085278901234',
            'location' => 'Lab Software TMS',
            'avatar' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $adminId = DB::table('users')->insertGetId([
            'batch_id' => null,
            'account_id' => 'admin',
            'username' => 'admin',
            'name' => 'Admin TMS',
            'email' => 'admin@tms.co.id',
            'password' => Hash::make('tmsadmin123'),
            'role' => 'admin_tms',
            'school_origin' => 'PT. Teknologi Multi Sistem',
            'major' => 'Human Resources & Internship Coordinator',
            'phone_number' => '081234595426',
            'must_change_password' => 0,
            'avatar' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Tasks
        $task1 = DB::table('tasks')->insertGetId([
            'mentor_id' => $mentorId,
            'batch_id' => $batch2026,
            'title' => 'Modul 01: Setup Arsitektur MVC & Deployment Serverless Vercel',
            'description' => 'Membangun blog engineering TechPulse menggunakan framework Laravel 12, Blade components, SQLite database, dan konfigurasi serverless runtime vercel-php.',
            'deadline' => '2026-11-16 14:00:00',
            'priority' => 'tinggi',
            'attachment_file' => 'modul-01-tms-mvc.pdf',
            'status' => 'selesai',
            'created_at' => now()->subDay(),
            'updated_at' => now()->subDay(),
        ]);

        $task2 = DB::table('tasks')->insertGetId([
            'mentor_id' => $mentorId,
            'batch_id' => $batch2026,
            'title' => 'Modul 02: Implementasi CRUD Komentar Dinamis & Relasi Eloquent',
            'description' => 'Menambahkan fitur manajemen komentar lengkap (Create, Read, Update, Delete) melalui dropdown interaktif dan dialog modal, serta menangani error handling database read-only.',
            'deadline' => '2026-11-16 16:30:00',
            'priority' => 'tinggi',
            'attachment_file' => 'modul-02-crud-comments.pdf',
            'status' => 'aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $task3 = DB::table('tasks')->insertGetId([
            'mentor_id' => $mentorId,
            'batch_id' => $batch2026,
            'title' => 'Modul 03: Desain UI Shell Khas KOCI & Floating Bottom Dock',
            'description' => 'Merancang layout antarmuka khas sistem TMS / KOCI: running info marquee banner, card grid 2-kolom dengan ikon melingkar berbingkai merah, dan navigasi dock melayang.',
            'deadline' => '2026-11-17 15:00:00',
            'priority' => 'sedang',
            'attachment_file' => null,
            'status' => 'aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 4. Task Submissions
        DB::table('task_submissions')->insert([
            'task_id' => $task1,
            'user_id' => $siswaId,
            'repo_url' => 'https://github.com/pradipta/blog-pradipta',
            'demo_url' => 'https://blog-pradipta-pkl.vercel.app',
            'submission_notes' => 'Proyek TechPulse berhasil dideploy ke serverless Vercel menggunakan runtime 0.8.0 dan SQLite database seeded.',
            'status' => 'approved',
            'score' => 95,
            'feedback' => 'Implementasi sangat rapi, arsitektur MVC dan responsive layout berjalan sangat mulus. Pertahankan!',
            'submitted_at' => '2026-11-16 13:45:00',
            'created_at' => now()->subDay(),
            'updated_at' => now()->subDay(),
        ]);

        DB::table('task_submissions')->insert([
            'task_id' => $task2,
            'user_id' => $siswaId,
            'repo_url' => 'https://github.com/pradipta/blog-pradipta/commit/crud',
            'demo_url' => 'https://blog-pradipta-pkl.vercel.app/posts/prinsip-desain',
            'submission_notes' => 'CRUD komentar dinamis telah berjalan dengan modal update dan delete confirmation. Error 500 SQLite telah dibungkus try-catch.',
            'status' => 'submitted',
            'score' => null,
            'feedback' => null,
            'submitted_at' => '2026-11-16 15:00:00',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 5. Daily Journals
        DB::table('daily_journals')->insert([
            'user_id' => $siswaId,
            'journal_date' => '2026-11-16',
            'activity_title' => 'Briefing SOP, Orientasi Magang & Setup Blog TechPulse',
            'activity_detail' => 'Mengikuti meeting briefing bersama mentor teknis terkait budaya kerja industri di PT. Teknologi Multi Sistem. Melanjutkan pembangunan blog engineering TechPulse menggunakan Laravel 12 dan deploy ke Vercel.',
            'challenges' => 'Menghadapi kendala konfigurasi runtime PHP 8.4/8.5 di environment Vercel serverless serta issue SQLite database read-only.',
            'solution' => 'Mengupdate vercel.json dengan runtime vercel-php@0.8.0 dan membungkus logic penulisan analytics views_count ke dalam blok try-catch.',
            'evidence_photo' => 'suasana_kerja_tms_hari_1.jpg',
            'commit_url' => 'https://github.com/pradipta/blog-pradipta/commit/init-release',
            'status' => 'approved',
            'mentor_id' => $mentorId,
            'mentor_feedback' => 'Problem solving teknis sangat bagus dan terstruktur. Dokumentasi di logbook jelas dan tepat sasaran.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 6. Showcase Projects
        DB::table('showcase_projects')->insert([
            'batch_id' => $batch2026,
            'creator_id' => $siswaId,
            'team_members' => 'Pradipta Endra Maulana (Lead Dev)',
            'title' => 'TechPulse Engineering Blog',
            'tech_stack' => 'Laravel 12, Tailwind CSS, SQLite, Vercel Serverless',
            'short_description' => 'Platform publikasi artikel teknologi dan dokumentasi riset engineering internal untuk sharing knowledge developer di TMS.',
            'full_description' => 'TechPulse dibangun sebagai sarana riset dan publikasi teknis internal. Memiliki fitur filter kategori, search real-time, transisi tema dark mode / matrix, dan komentar CRUD interaktif.',
            'thumbnail' => 'mockup_techpulse.jpg',
            'live_url' => 'https://blog-pradipta-pkl.vercel.app',
            'repo_url' => 'https://github.com/pradipta/blog-pradipta',
            'is_featured' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('showcase_projects')->insert([
            'batch_id' => $batch2025,
            'creator_id' => $siswaId,
            'team_members' => 'Tim PPLG SMKN 1 Ciamis (Angkatan 2025)',
            'title' => 'MAS-PKL (Sistem Informasi PKL Sekolah)',
            'tech_stack' => 'Laravel 11, Bootstrap 5, MySQL',
            'short_description' => 'Sistem manajemen terpadu pembimbing sekolah, penempatan siswa di industri, dan rekapitulasi nilai berskala SMK.',
            'full_description' => 'Aplikasi web yang mengelola presensi siswa, buku jurnal harian sekolah, rekapitulasi nilai pokja, dan persuratan resmi.',
            'thumbnail' => 'mockup_maspkl.jpg',
            'live_url' => 'https://pkl.smkn1ciamis.id',
            'repo_url' => 'https://github.com/smkn1ciamis/mas-pkl',
            'is_featured' => false,
            'created_at' => now()->subMonths(6),
            'updated_at' => now()->subMonths(6),
        ]);

        // 7. Evaluations
        DB::table('evaluations')->insert([
            'user_id' => $siswaId,
            'mentor_id' => $mentorId,
            'technical_skill' => 92,
            'discipline' => 95,
            'teamwork' => 90,
            'initiative' => 94,
            'final_score' => 92.75,
            'certificate_number' => 'TMS/PKL-2026/XI-PPLG/001',
            'general_notes' => 'Pradipta memiliki kemampuan analisis logika koding yang sangat cepat, adaptif dengan teknologi modern (Laravel 12, serverless), dan inisiatif tinggi dalam problem solving.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
