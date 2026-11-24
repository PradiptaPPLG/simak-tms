<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

$activityTitle = 'Pengembangan Fitur Ekspor Data Spreadsheet (Excel/CSV), Sinkronisasi QR Code Profil & Backup Sistem SIMAK-TMS';
$activityDetail = "Hari ini saya melanjutkan pengembangan sistem informasi SIMAK-TMS di PT. Teknologi Multi Sistem. Fokus pekerjaan meliputi penyatuan kode QR profil publik menjadi satu pintu resmi terpadu (Unified Single QR) yang langsung dapat diakses tanpa hambatan sesi login, menambahkan tampilan e-sertifikat kelulusan 4 pilar di laman profil publik, serta mengimplementasikan modul ekspor data spreadsheet (Microsoft Excel .xls dan CSV Universal) dan fitur cetak rekapitulasi data bimbingan pada area Staff Mentor untuk keperluan pencadangan (backup) dan monitoring aktivitas berkala siswa magang.";

$challenges = "Format penulisan ekspor Excel perlu mempertahankan format teks untuk ID 5-digit siswa dan NIS agar tidak terpotong atau terkonversi menjadi format saintifik.";
$solution = "Menerapkan custom style mso-number-format pada sel spreadsheet Excel dan menambahkan header UTF-8 BOM pada berkas CSV agar karakter khusus dan nomor ID terbaca dengan sempurna di MS Excel maupun Google Sheets.";

DB::table('daily_journals')->updateOrInsert(
    [
        'user_id' => 11,
        'journal_date' => '2026-11-24'
    ],
    [
        'activity_title' => $activityTitle,
        'activity_detail' => $activityDetail,
        'challenges' => $challenges,
        'solution' => $solution,
        'evidence_photo' => 'jurnal_20261124_pradipta.jpg',
        'commit_url' => 'https://github.com/pradiptamaulana/simak-tms/commit/b8a21ec',
        'status' => 'approved',
        'mentor_id' => 10,
        'mentor_feedback' => 'Fitur ekspor Excel/CSV dan penyatuan QR Code profil publik berjalan sangat baik. Dokumentasi dan backup terkelola rapi.',
        'created_at' => Carbon::parse('2026-11-24 07:45:00'),
        'updated_at' => now(),
    ]
);

$count = DB::table('daily_journals')->where('user_id', 11)->count();
echo "Total journals for User 11: " . $count . PHP_EOL;

$latest = DB::table('daily_journals')->where('user_id', 11)->orderBy('journal_date', 'desc')->first();
echo "Latest journal date: " . $latest->journal_date . PHP_EOL;
echo "Title: " . $latest->activity_title . PHP_EOL;
echo "Status: " . $latest->status . PHP_EOL;
