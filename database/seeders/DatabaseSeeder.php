<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with complete, production-ready dummy data for every role:
     * 1. Admin TMS (admin_tms)
     * 2. Mentor Industri (mentor)
     * 3. Siswa PKL (siswa) - Aktif (Bersertifikat & Portofolio), Alumni, dan Registrasi Baru
     */
    public function run(): void
    {
        $now = Carbon::now();

        // ==========================================
        // 1. DATA ANGKATAN / BATCHES
        // ==========================================
        $batch2026Id = DB::table('batches')->updateOrInsert(
            ['period_year' => 2026],
            [
                'batch_name' => 'Angkatan 2026',
                'start_date' => '2026-11-16',
                'end_date' => '2027-04-16',
                'is_active' => true,
                'updated_at' => $now,
            ]
        );
        $batch2026 = DB::table('batches')->where('period_year', 2026)->first();

        $batch2025Id = DB::table('batches')->updateOrInsert(
            ['period_year' => 2025],
            [
                'batch_name' => 'Angkatan 2025',
                'start_date' => '2025-10-01',
                'end_date' => '2026-03-31',
                'is_active' => false,
                'updated_at' => $now,
            ]
        );
        $batch2025 = DB::table('batches')->where('period_year', 2025)->first();

        // ==========================================
        // 2. SEKOLAH & KAMPUS MITRA (PARTNER INSTITUTIONS)
        // ==========================================
        $partners = [
            [
                'name' => 'SMKN 1 Ciamis',
                'type' => 'SMK',
                'address' => 'Jl. Jend. Soedirman No. 269, Ciamis',
                'city' => 'Ciamis',
                'pic_name' => 'Bpk. Dani Ramdhani, S.Kom.',
                'pic_phone' => '081223456789',
                'pic_email' => 'pplg@smkn1ciamis.sch.id',
                'mou_number' => 'MoU/TMS-SMKN1CMS/2026/014',
                'mou_date' => '2026-01-10',
                'status' => 'aktif',
            ],
            [
                'name' => 'SMKN 2 Ciamis',
                'type' => 'SMK',
                'address' => 'Jl. Sadananya No. 21, Ciamis',
                'city' => 'Ciamis',
                'pic_name' => 'Ibu Rina Susilawati, M.Kom.',
                'pic_phone' => '085223344556',
                'pic_email' => 'rpl@smkn2ciamis.sch.id',
                'mou_number' => 'MoU/TMS-SMKN2CMS/2025/088',
                'mou_date' => '2025-07-15',
                'status' => 'aktif',
            ],
            [
                'name' => 'Universitas Galuh',
                'type' => 'Universitas',
                'address' => 'Jl. K.H. Ahmad Dahlan No. 150, Ciamis',
                'city' => 'Ciamis',
                'pic_name' => 'Dr. Hendra Permana, M.T.',
                'pic_phone' => '081399887766',
                'pic_email' => 'ti@unigal.ac.id',
                'mou_number' => 'MoU/TMS-UNIGAL/2025/009',
                'mou_date' => '2025-02-20',
                'status' => 'aktif',
            ],
        ];

        foreach ($partners as $p) {
            DB::table('partner_institutions')->updateOrInsert(
                ['name' => $p['name']],
                array_merge($p, ['updated_at' => $now])
            );
        }

        // ==========================================
        // 3. ROLE 1: ADMINISTRATOR TMS (admin_tms)
        // ==========================================
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@tms.co.id'],
            [
                'account_id' => 'admin',
                'username' => 'admintms',
                'name' => 'Admin TMS',
                'password' => Hash::make('tmsadmin123'),
                'role' => 'admin_tms',
                'status' => 'aktif',
                'school_origin' => 'PT. Teknologi Multi Sistem',
                'major' => 'Human Resources & Internship Coordinator',
                'phone_number' => '081234595426',
                'location' => 'Kantor Pusat PT. TMS',
                'headline' => 'HR & Internship Operational Lead',
                'bio' => 'Koordinator resmi program magang dan kemitraan vokasi PT. Teknologi Multi Sistem.',
                'profile_hash' => '3672a8ee1e8803d9',
                'must_change_password' => 0,
                'avatar' => null,
                'updated_at' => $now,
            ]
        );
        $admin = DB::table('users')->where('email', 'admin@tms.co.id')->first();

        // ==========================================
        // 4. ROLE 2: MENTOR INDUSTRI (mentor)
        // ==========================================
        // Mentor Utama (Farhan Ramadhan / Mentor Test 1)
        DB::table('users')->updateOrInsert(
            ['account_id' => '27848'],
            [
                'username' => 'mentortest',
                'name' => 'Mentor Test 1',
                'email' => 'mentor@tms.co.id',
                'password' => Hash::make('tmshebatsukses'),
                'role' => 'mentor',
                'status' => 'aktif',
                'batch_id' => $batch2026->id,
                'school_origin' => 'PT. Teknologi Multi Sistem',
                'major' => 'Senior Software Engineer & Tech Lead',
                'headline' => 'Senior Software Engineer & Tech Lead',
                'bio' => 'Tech Lead di PT. TMS, membidangi arsitektur web modern Laravel, integrasi REST API, dan pembimbingan teknis siswa PKL.',
                'phone_number' => '085223035426',
                'location' => 'Lab Software TMS',
                'profile_hash' => 'c756a6f506203ba3',
                'must_change_password' => 0,
                'avatar' => null,
                'updated_at' => $now,
            ]
        );
        $mentor1 = DB::table('users')->where('account_id', '27848')->first();

        // Mentor 2 (Alif Maulana - Backend Specialist)
        DB::table('users')->updateOrInsert(
            ['email' => 'alif@tms.co.id'],
            [
                'account_id' => '16827',
                'username' => 'alifmaulana',
                'name' => 'Alif Maulana, S.Kom',
                'password' => Hash::make('tmshebatsukses'),
                'role' => 'mentor',
                'status' => 'aktif',
                'batch_id' => $batch2026->id,
                'school_origin' => 'PT. Teknologi Multi Sistem',
                'major' => 'Senior Backend Engineer & Cloud Architect',
                'headline' => 'Senior Backend Engineer & Cloud Architect',
                'bio' => 'Spesialis RESTful API, database optimization, CI/CD pipeline, dan arsitektur backend TMS.',
                'phone_number' => '081398765432',
                'location' => 'Lab Software TMS',
                'profile_hash' => 'a1b2c3d4e5f60718',
                'must_change_password' => 0,
                'avatar' => null,
                'updated_at' => $now,
            ]
        );
        $mentor2 = DB::table('users')->where('email', 'alif@tms.co.id')->first();

        // Mentor 3 (Dina Septiani - UI/UX Specialist)
        DB::table('users')->updateOrInsert(
            ['email' => 'dina@tms.co.id'],
            [
                'account_id' => '34912',
                'username' => 'dinaseptiani',
                'name' => 'Dina Septiani, M.Cs',
                'password' => Hash::make('tmshebatsukses'),
                'role' => 'mentor',
                'status' => 'aktif',
                'batch_id' => $batch2026->id,
                'school_origin' => 'PT. Teknologi Multi Sistem',
                'major' => 'Lead UI/UX Designer & Frontend Engineer',
                'headline' => 'Lead UI/UX Designer & Frontend Engineer',
                'bio' => 'Memfokuskan pada riset pengalaman pengguna, design system modern, dan frontend framework.',
                'phone_number' => '082145678901',
                'location' => 'Lab Software TMS',
                'profile_hash' => 'f8e7d6c5b4a31209',
                'must_change_password' => 0,
                'avatar' => null,
                'updated_at' => $now,
            ]
        );

        // ==========================================
        // 5. ROLE 3: SISWA MAGANG / PKL (siswa)
        // ==========================================

        // Siswa 1: Pradipta Endra Maulana (Siswa Aktif Berprestasi, Lulus Rapor & Bersertifikat)
        DB::table('users')->updateOrInsert(
            ['account_id' => '20239'],
            [
                'username' => 'pradipta',
                'name' => 'Pradipta Endra Maulana',
                'email' => 'pradipta02032009@gmail.com',
                'password' => Hash::make('tmshebatsukses'),
                'role' => 'siswa',
                'status' => 'aktif',
                'batch_id' => $batch2026->id,
                'mentor_id' => $mentor1->id,
                'school_origin' => 'SMKN 1 Ciamis',
                'major' => 'PPLG (Pengembangan Perangkat Lunak & Gim)',
                'phone_number' => '081234567890',
                'location' => 'Ciamis, Jawa Barat, ID',
                'headline' => 'Software Engineer Intern @ PT. Teknologi Multi Sistem',
                'bio' => 'Siswa Rekayasa Perangkat Lunak SMKN 1 Ciamis yang berfokus pada ekosistem Laravel, Tailwind CSS, REST API, dan modern web architecture.',
                'skills' => 'PHP, Laravel 11, Tailwind CSS, MySQL, JavaScript, Git, REST API',
                'github_url' => 'https://github.com/pradiptamaulana',
                'linkedin_url' => 'https://linkedin.com/in/pradiptaendra',
                'instagram_url' => 'https://instagram.com/pradiptam',
                'website_url' => 'https://pradipta.dev',
                'profile_hash' => 'ef6acc7a13b94831',
                'avatar' => '/uploads/avatars/avatar_11_d116346da495ba1a64bf.jpg',
                'must_change_password' => 0,
                'updated_at' => $now,
            ]
        );
        $siswa1 = DB::table('users')->where('account_id', '20239')->first();

        // Siswa 2: Aditya Pratama Putra (Siswa Alumni / Telah Lulus Magang)
        DB::table('users')->updateOrInsert(
            ['account_id' => '19468'],
            [
                'username' => 'adityapratama',
                'name' => 'Aditya Pratama Putra',
                'email' => 'aditya.pratama@gmail.com',
                'password' => Hash::make('tmshebatsukses'),
                'role' => 'siswa',
                'status' => 'alumni',
                'batch_id' => $batch2026->id,
                'mentor_id' => $mentor1->id,
                'school_origin' => 'SMKN 1 Ciamis',
                'major' => 'Rekayasa Perangkat Lunak (RPL)',
                'phone_number' => '081234567891',
                'location' => 'Ciamis, Jawa Barat, ID',
                'headline' => 'Fullstack Developer Alumnus @ PT. TMS',
                'bio' => 'Alumni PKL PT. TMS yang menyelesaikan proyek sistem enterprise dan web service.',
                'skills' => 'PHP, CodeIgniter, Laravel, Bootstrap, MySQL',
                'profile_hash' => 'd9d80d4a15fa7b98',
                'must_change_password' => 0,
                'avatar' => null,
                'updated_at' => $now,
            ]
        );
        $siswa2 = DB::table('users')->where('account_id', '19468')->first();

        // Siswa 3: Alyzza Nazwa Aulia (Siswa Baru / Menunggu Penetapan Mentor)
        DB::table('users')->updateOrInsert(
            ['email' => 'alyzza@gmail.com'],
            [
                'account_id' => null, // Sengaja null: mencontohkan status (belum terdaftar / pending)
                'username' => 'alyzzanazwa',
                'name' => 'Alyzza Nazwa Aulia',
                'password' => Hash::make('tmshebatsukses'),
                'role' => 'siswa',
                'status' => 'pending',
                'batch_id' => $batch2026->id,
                'mentor_id' => null,
                'school_origin' => 'SMKN 1 Ciamis',
                'major' => 'PPLG (Pengembangan Perangkat Lunak & Gim)',
                'phone_number' => '081234567892',
                'profile_hash' => 'd76bb6664c4e33eb',
                'must_change_password' => 1,
                'avatar' => null,
                'updated_at' => $now,
            ]
        );
        $siswa3 = DB::table('users')->where('email', 'alyzza@gmail.com')->first();

        // Siswa 4: Murid 1 / Rian Hidayat (Alumni Bimbingan)
        DB::table('users')->updateOrInsert(
            ['account_id' => '51589'],
            [
                'username' => 'murid1',
                'name' => 'Murid 1 (Rian Hidayat)',
                'email' => 'murid1@gmail.com',
                'password' => Hash::make('tmshebatsukses'),
                'role' => 'siswa',
                'status' => 'alumni',
                'batch_id' => $batch2026->id,
                'mentor_id' => $mentor1->id,
                'school_origin' => 'SMKN 1 Ciamis',
                'major' => 'PPLG',
                'phone_number' => '081234567893',
                'profile_hash' => 'c7937e3f51a968c1',
                'must_change_password' => 0,
                'avatar' => null,
                'updated_at' => $now,
            ]
        );
        $siswa4 = DB::table('users')->where('account_id', '51589')->first();

        // ==========================================
        // 6. ENROLLMENT BATCH & EVALUASI 4 PILAR (batch_students)
        // ==========================================
        // Pradipta (Angkatan 2026)
        DB::table('batch_students')->updateOrInsert(
            [
                'batch_id' => $batch2026->id,
                'user_id' => $siswa1->id,
            ],
            [
                'mentor_id' => $mentor1->id,
                'institution_name' => 'SMKN 1 Ciamis',
                'major' => 'PPLG (Pengembangan Perangkat Lunak & Gim)',
                'role_title' => 'Software Engineer Intern',
                'status' => 'aktif',
                'technical_skill' => 92,
                'discipline' => 95,
                'teamwork' => 90,
                'initiative' => 91,
                'final_score' => 92.00,
                'grade' => 'A',
                'mentor_notes' => 'Kinerja teknis sangat memuaskan pada batch ini.',
                'certificate_number' => 'TMS-TEST-20239',
                'issue_date' => '2026-11-18',
                'is_published' => true,
                'updated_at' => $now,
            ]
        );

        // Aditya (Angkatan 2026 - Lulus)
        DB::table('batch_students')->updateOrInsert(
            [
                'batch_id' => $batch2026->id,
                'user_id' => $siswa2->id,
            ],
            [
                'mentor_id' => $mentor1->id,
                'institution_name' => 'SMKN 1 Ciamis',
                'major' => 'Rekayasa Perangkat Lunak (RPL)',
                'role_title' => 'Software Engineer Intern',
                'status' => 'lulus',
                'technical_skill' => 85,
                'discipline' => 90,
                'teamwork' => 88,
                'initiative' => 85,
                'final_score' => 87.00,
                'grade' => 'A',
                'mentor_notes' => 'Menunjukkan dedikasi tinggi selama magang di PT. TMS.',
                'certificate_number' => 'TMS-CERT-2026-19468',
                'issue_date' => '2026-11-23',
                'is_published' => true,
                'updated_at' => $now,
            ]
        );

        // Murid 1 (Angkatan 2026 - Lulus)
        DB::table('batch_students')->updateOrInsert(
            [
                'batch_id' => $batch2026->id,
                'user_id' => $siswa4->id,
            ],
            [
                'mentor_id' => $mentor1->id,
                'institution_name' => 'SMKN 1 Ciamis',
                'major' => 'PPLG',
                'role_title' => 'Software Engineer Intern',
                'status' => 'lulus',
                'technical_skill' => 85,
                'discipline' => 90,
                'teamwork' => 88,
                'initiative' => 85,
                'final_score' => 87.00,
                'grade' => 'A',
                'mentor_notes' => 'Menyelesaikan modul tepat waktu.',
                'certificate_number' => 'TMS-CERT-2026-51589',
                'issue_date' => '2026-11-23',
                'is_published' => true,
                'updated_at' => $now,
            ]
        );

        // ==========================================
        // 7. EVALUASI RESMI & E-SERTIFIKAT (evaluations)
        // ==========================================
        DB::table('evaluations')->updateOrInsert(
            ['user_id' => $siswa1->id],
            [
                'mentor_id' => $mentor1->id,
                'technical_skill' => 92,
                'discipline' => 95,
                'teamwork' => 90,
                'initiative' => 91,
                'final_score' => 92.00,
                'certificate_number' => 'TMS-TEST-20239',
                'general_notes' => 'Pradipta memiliki kemampuan analisis logika koding yang sangat cepat, adaptif dengan teknologi modern (Laravel 12, serverless), dan inisiatif tinggi dalam problem solving.',
                'issue_date' => '2026-11-18',
                'is_published' => true,
                'updated_at' => $now,
            ]
        );

        // ==========================================
        // 8. LOGBOOK JURNAL HARIAN (daily_journals)
        // ==========================================
        $journals = [
            [
                'journal_date' => '2026-11-16',
                'activity_title' => 'Orientasi Budaya Kerja & Setup Lingkungan Dev',
                'activity_detail' => 'Mengikuti pengarahan SOP industri, instalasi tools development (PHP 8.2, Composer, Node.js, Git), dan setup awal project SIMAK-TMS.',
                'challenges' => 'Penyesuaian konfigurasi environment lokal dan ekstensi PHP.',
                'solution' => 'Mengaktifkan ekstensi curl, pdo_sqlite, dan mbstring pada php.ini.',
                'commit_url' => 'https://github.com/pradiptamaulana/simak-tms/commit/init',
                'status' => 'approved',
            ],
            [
                'journal_date' => '2026-11-17',
                'activity_title' => 'Implementasi Arsitektur Database & Relasi Eloquent',
                'activity_detail' => 'Merancang skema database tabel users, batches, partner_institutions, daily_journals, dan showcase_projects.',
                'challenges' => 'Memastikan integritas relasi foreign key pada SQLite.',
                'solution' => 'Menambahkan indeks foreignId cascadeOnDelete dan testing via artisan migrate:fresh.',
                'commit_url' => 'https://github.com/pradiptamaulana/simak-tms/commit/database-schema',
                'status' => 'approved',
            ],
            [
                'journal_date' => '2026-11-18',
                'activity_title' => 'Desain Antarmuka Glassmorphism & UI Shell',
                'activity_detail' => 'Membangun layout dashboard interaktif dengan Tailwind CSS, styling khas TMS merah-putih-hitam, dan integrasi Lucide Icons.',
                'challenges' => 'Mengoptimalkan responsiveness layout pada resolusi layar mobile.',
                'solution' => 'Menerapkan grid breakpoint responsive sm:, md:, dan lg: serta collapsible sidebar.',
                'commit_url' => 'https://github.com/pradiptamaulana/simak-tms/commit/ui-shell',
                'status' => 'approved',
            ],
            [
                'journal_date' => '2026-11-19',
                'activity_title' => 'Autentikasi Multi-Role & QR Profil Siswa',
                'activity_detail' => 'Membangun rute login aman dengan rate-limiting, otentikasi role admin/mentor/siswa, dan modul QR code profil publik.',
                'challenges' => 'Mencegah bypass login dan pengamanan rute public profile read-only.',
                'solution' => 'Menggunakan middleware auth pada zona privat dan mengisolasi rute publik dengan hash URI.',
                'commit_url' => 'https://github.com/pradiptamaulana/simak-tms/commit/auth-qr',
                'status' => 'approved',
            ],
            [
                'journal_date' => '2026-11-20',
                'activity_title' => 'Validasi Input, Anti-Bot Throttle & Keamanan Upload Foto',
                'activity_detail' => 'Menambahkan validasi ketat MIME image pada upload avatar/evidence, pembatasan 2MB, dan mekanisme crop 1:1 auto.',
                'challenges' => 'Pemeriksaan integritas bitmap gambar nyata dari base64/file stream.',
                'solution' => 'Validasi getimagesizefromstring dan unlink foto lokal lama saat foto baru diunggah.',
                'commit_url' => 'https://github.com/pradiptamaulana/simak-tms/commit/validation-security',
                'status' => 'approved',
            ],
            [
                'journal_date' => '2026-11-23',
                'activity_title' => 'Refactoring Relasi Angkatan, Penilaian 4 Pilar & Kalender Mentor',
                'activity_detail' => 'Membangun tabel batch_students untuk multi-angkatan siswa magang, modul penilaian 4 pilar independen oleh mentor, serta kalender monitoring jurnal mentor.',
                'challenges' => 'Menyinkronkan data profil publik dengan data penilaian mentor secara real-time.',
                'solution' => 'Membangun query eager-loading batchStudents dan kalender interaktif mentor dengan deteksi bolong otomatis.',
                'commit_url' => 'https://github.com/pradiptamaulana/simak-tms/commit/d319fa1',
                'status' => 'approved',
            ],
        ];

        foreach ($journals as $j) {
            DB::table('daily_journals')->updateOrInsert(
                [
                    'user_id' => $siswa1->id,
                    'journal_date' => $j['journal_date'],
                ],
                array_merge($j, [
                    'mentor_id' => $mentor1->id,
                    'mentor_feedback' => 'Pengerjaan modul sangat rapi, dokumentasi terstruktur dan tepat waktu.',
                    'updated_at' => $now,
                ])
            );
        }

        // ==========================================
        // 9. PORTOFOLIO KARYA SISWA (showcase_projects)
        // ==========================================
        $projects = [
            [
                'batch_id' => $batch2026->id,
                'creator_id' => $siswa1->id,
                'team_members' => 'Pradipta Endra Maulana (Lead Dev), Mentor Test 1 (Mentor)',
                'title' => 'SIMAK-TMS (Sistem Informasi Manajemen Aktivitas & Karya Siswa PKL)',
                'tech_stack' => 'Laravel 11, Tailwind CSS, SQLite, Lucide Icons, Chart.js',
                'short_description' => 'Platform komprehensif monitoring magang industri, pencatatan logbook jurnal harian, repositori karya angkatan, dan penerbitan e-sertifikat terverifikasi QR code.',
                'full_description' => 'Dibangun khusus untuk PT. Teknologi Multi Sistem dengan standar tata kelola software house profesional. Mendukung role Siswa PKL, Mentor Pembimbing Industri, dan Manajemen Admin TMS.',
                'live_url' => 'http://127.0.0.1:8000/',
                'repo_url' => 'https://github.com/pradiptam/simak-tms',
                'is_featured' => true,
                'project_category' => 'Enterprise LMS & Activity Tracker',
                'status' => 'Completed & Deployed',
            ],
            [
                'batch_id' => $batch2026->id,
                'creator_id' => $siswa1->id,
                'team_members' => 'Pradipta Endra Maulana (Fullstack), Tim Siswa Batch 2026',
                'title' => 'TechPulse Engineering Portal & Mas-PKL Hub',
                'tech_stack' => 'Laravel, Tailwind CSS, REST API, SQLite, Alpine.js',
                'short_description' => 'Portal publik rekayasa software dan media showcasing portofolio siswa magang PT. TMS untuk sekolah mitra industri.',
                'full_description' => 'Sistem portal publik yang menyajikan artikel teknis, studi kasus pengembangan software house, dan dokumentasi arsitektur microservices.',
                'live_url' => 'https://techpulse.tms.co.id',
                'repo_url' => 'https://github.com/pradiptam/techpulse-portal',
                'is_featured' => true,
                'project_category' => 'Engineering Blog & Documentation',
                'status' => 'Completed & Deployed',
            ],
            [
                'batch_id' => $batch2026->id,
                'creator_id' => $siswa1->id,
                'team_members' => 'Pradipta Endra Maulana, Tim Software Lab TMS',
                'title' => 'TMS Cloud Attendance & Geofencing System',
                'tech_stack' => 'Node.js, Express, Leaflet Geofence, SQLite, PWA',
                'short_description' => 'Sistem presensi masuk lab industri otomatis dengan geofencing radius 50m lab software TMS dan validasi IP jaringan internal.',
                'full_description' => 'Memastikan integritas kehadiran peserta magang di lab fisik software house PT. TMS dengan teknologi deteksi koordinat dan verifikasi biometrik.',
                'live_url' => 'https://presensi.tms.co.id',
                'repo_url' => 'https://github.com/pradiptam/tms-geofence-presensi',
                'is_featured' => false,
                'project_category' => 'Internal Lab Geofencing Attendance',
                'status' => 'Completed & Deployed',
            ],
            [
                'batch_id' => $batch2025->id,
                'creator_id' => $siswa1->id,
                'team_members' => 'Alumni Batch 2025, Senior Software Team TMS',
                'title' => 'TMS Client Billing & SLA Monitor',
                'tech_stack' => 'PHP 8.2, Bootstrap 5, SQLite, Midtrans API',
                'short_description' => 'Aplikasi invoice tagihan otomatis dan monitoring uptime server SLA untuk 50+ klien enterprise PT. TMS.',
                'full_description' => 'Solusi finansial internal PT. TMS untuk otomasi penerbitan invoice recurring dan tracking performa server hosting klien.',
                'live_url' => 'https://billing.tms.co.id',
                'repo_url' => 'https://github.com/tms-industri/client-billing',
                'is_featured' => false,
                'project_category' => 'Fintech & SLA Dashboard',
                'status' => 'Completed & Deployed',
            ],
        ];

        foreach ($projects as $pr) {
            DB::table('showcase_projects')->updateOrInsert(
                ['title' => $pr['title']],
                array_merge($pr, ['updated_at' => $now])
            );
        }

        // ==========================================
        // 10. PENDAFTARAN PKL DUMMY (pkl_registrations)
        // ==========================================
        $registrations = [
            [
                'registration_code' => 'REG-TMS-2026-001',
                'full_name' => 'Pradipta Endra Maulana',
                'gender' => 'L',
                'nis' => '20239',
                'birth_place' => 'Ciamis',
                'birth_date' => '2009-03-02',
                'religion' => 'Islam',
                'skill_competency' => 'PPLG (Pengembangan Perangkat Lunak & Gim)',
                'school_origin' => 'SMKN 1 Ciamis',
                'email' => 'pradipta02032009@gmail.com',
                'phone_number' => '081234567890',
                'status' => 'accepted',
            ],
            [
                'registration_code' => 'REG-TMS-2026-002',
                'full_name' => 'Alyzza Nazwa Aulia',
                'gender' => 'P',
                'nis' => '93777',
                'birth_place' => 'Ciamis',
                'birth_date' => '2008-08-15',
                'religion' => 'Islam',
                'skill_competency' => 'PPLG (Pengembangan Perangkat Lunak & Gim)',
                'school_origin' => 'SMKN 1 Ciamis',
                'email' => 'alyzza@gmail.com',
                'phone_number' => '081234567892',
                'status' => 'pending',
            ],
        ];

        foreach ($registrations as $r) {
            DB::table('pkl_registrations')->updateOrInsert(
                ['registration_code' => $r['registration_code']],
                array_merge($r, ['updated_at' => $now])
            );
        }
    }
}
