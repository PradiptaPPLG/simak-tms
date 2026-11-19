@extends('layouts.simak')

@section('title', 'Panduan & Tutorial Sistem • SIMAK-TMS')

@section('content')
<div class="space-y-6">

    <!-- 1. Header Banner -->
    <div class="mas-card p-6 sm:p-8 bg-gradient-to-br from-white via-slate-50 to-red-50/20 border-slate-200">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="space-y-1">
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-slate-900">
                    Panduan Penggunaan & Tutorial Alur Kerja
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 max-w-3xl leading-relaxed">
                    Panduan komprehensif mengenai tugas & tanggung jawab per role (Siswa, Mentor, Admin TMS), fungsi seluruh menu sidebar, dan SOP lab industri PT. TMS.
                </p>
            </div>

            <!-- Quick Action: Cek Sertifikat Modal -->
            <div class="flex items-center gap-2 self-start md:self-auto shrink-0">
                <button type="button" onclick="openVerifyModal()" class="px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-black text-white text-xs font-bold transition-all shadow-md flex items-center gap-2 cursor-pointer">
                    <i data-lucide="shield-check" class="w-4 h-4 text-emerald-400"></i>
                    <span>Cek Sertifikat (In-Page)</span>
                </button>
            </div>
        </div>
    </div>

    <!-- 2. Navigasi Tab Kategori Panduan -->
    <div class="flex items-center gap-2 overflow-x-auto pb-1 no-scrollbar border-b border-slate-200">
        <button type="button" onclick="switchGuideTab('tab-roles')" id="btn-tab-roles" class="guide-tab-btn px-4 py-2 rounded-xl text-xs font-bold transition-all bg-red-600 text-white shadow-xs flex items-center gap-2 shrink-0">
            <i data-lucide="users" class="w-3.5 h-3.5"></i>
            <span>Tugas & Tanggung Jawab Per Role</span>
        </button>
        <button type="button" onclick="switchGuideTab('tab-sidebar')" id="btn-tab-sidebar" class="guide-tab-btn px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 transition-all flex items-center gap-2 shrink-0">
            <i data-lucide="layout-grid" class="w-3.5 h-3.5"></i>
            <span>Fungsi Lengkap Per Menu Sidebar</span>
        </button>
        <button type="button" onclick="switchGuideTab('tab-sop')" id="btn-tab-sop" class="guide-tab-btn px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 transition-all flex items-center gap-2 shrink-0">
            <i data-lucide="clipboard-check" class="w-3.5 h-3.5"></i>
            <span>SOP & Aturan Kerja Lab TMS</span>
        </button>
        <button type="button" onclick="switchGuideTab('tab-security')" id="btn-tab-security" class="guide-tab-btn px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 transition-all flex items-center gap-2 shrink-0">
            <i data-lucide="shield-alert" class="w-3.5 h-3.5"></i>
            <span>Keamanan Akun & Sandi</span>
        </button>
    </div>

    <!-- ================================================================= -->
    <!-- TAB 1: TUGAS & TANGGUNG JAWAB PER ROLE                            -->
    <!-- ================================================================= -->
    <div id="tab-roles" class="guide-tab-content space-y-6">

        <!-- Grid 3 Kolom: Siswa, Mentor, Admin -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- 1. ROLE SISWA PKL -->
            <div class="mas-card p-6 space-y-5 border-t-4 border-t-red-600 flex flex-col justify-between">
                <div class="space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-red-50 text-red-600 flex items-center justify-center font-bold">
                                <i data-lucide="graduation-cap" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900">Role: Siswa PKL</h3>
                                <p class="text-[11px] text-slate-400">Peserta Magang Industri DUDI</p>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded-full bg-red-100 text-red-700 text-[10px] font-bold">Siswa</span>
                    </div>

                    <div class="space-y-3 text-xs text-slate-600">
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 space-y-1">
                            <b class="text-slate-800 flex items-center gap-1.5 text-xs">
                                <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-red-600"></i>
                                <span>1. Isi Jurnal & Logbook Harian</span>
                            </b>
                            <p class="text-[11px] text-slate-500 leading-relaxed">
                                Wajib mencatat ringkasan aktivitas teknis, capaian tugas, kendala yang dihadapi, serta tautan commit Git setiap hari kerja sebelum pukul 17.00 WIB.
                            </p>
                        </div>

                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 space-y-1">
                            <b class="text-slate-800 flex items-center gap-1.5 text-xs">
                                <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-red-600"></i>
                                <span>2. Bangun Proyek & Repositori Git</span>
                            </b>
                            <p class="text-[11px] text-slate-500 leading-relaxed">
                                Berkolaborasi dalam tim software batch untuk membangun proyek nyata industri, mengunggah repositori kode, dan meluncurkan link live demo.
                            </p>
                        </div>

                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 space-y-1">
                            <b class="text-slate-800 flex items-center gap-1.5 text-xs">
                                <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-red-600"></i>
                                <span>3. Lengkapi Profil Developer Ala GitHub</span>
                            </b>
                            <p class="text-[11px] text-slate-500 leading-relaxed">
                                Mengisi biodata keahlian (*tech stack*), akun GitHub/LinkedIn, dan mengecek QR Code verifikasi e-sertifikat yang terhubung ke portofolio.
                            </p>
                        </div>

                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 space-y-1">
                            <b class="text-slate-800 flex items-center gap-1.5 text-xs">
                                <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-red-600"></i>
                                <span>4. Pantau Evaluasi Nilai Industri</span>
                            </b>
                            <p class="text-[11px] text-slate-500 leading-relaxed">
                                Memantau skor performa dari mentor pada 4 pilar: Kompetensi Teknis, Etika Kerja, Disiplin, dan Soft Skill.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 text-[11px] text-slate-400">
                    Menu Utama: <b>Dasbor Siswa, Jurnal Kegiatan, Arsip Portofolio, Evaluasi Nilai, Profil Developer</b>
                </div>
            </div>

            <!-- 2. ROLE STAF MENTOR -->
            <div class="mas-card p-6 space-y-5 border-t-4 border-t-slate-900 flex flex-col justify-between">
                <div class="space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-900 flex items-center justify-center font-bold">
                                <i data-lucide="user-check" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900">Role: Mentor Industri</h3>
                                <p class="text-[11px] text-slate-400">Pembimbing Teknis Lab PT. TMS</p>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded-full bg-slate-900 text-white text-[10px] font-bold">Mentor</span>
                    </div>

                    <div class="space-y-3 text-xs text-slate-600">
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 space-y-1">
                            <b class="text-slate-800 flex items-center gap-1.5 text-xs">
                                <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-slate-900"></i>
                                <span>1. Monitoring Siswa Bimbingan</span>
                            </b>
                            <p class="text-[11px] text-slate-500 leading-relaxed">
                                Memantau kehadiran, aktivitas harian, dan pembagian divisi kerja siswa bimbingan (misal: IT / Software Engineering).
                            </p>
                        </div>

                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 space-y-1">
                            <b class="text-slate-800 flex items-center gap-1.5 text-xs">
                                <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-slate-900"></i>
                                <span>2. Sisipkan Catatan & Feedback Logbook</span>
                            </b>
                            <p class="text-[11px] text-slate-500 leading-relaxed">
                                Meninjau isi logbook kegiatan siswa dan menyisipkan catatan/feedback langsung untuk perbaikan kualitas kerja tanpa birokrasi rumit.
                            </p>
                        </div>

                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 space-y-1">
                            <b class="text-slate-800 flex items-center gap-1.5 text-xs">
                                <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-slate-900"></i>
                                <span>3. Penilaian Rapor DUDI Berkala</span>
                            </b>
                            <p class="text-[11px] text-slate-500 leading-relaxed">
                                Mengisi evaluasi nilai industri untuk dimasukkan ke transkrip resmi sertifikat magang PT. TMS.
                            </p>
                        </div>

                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 space-y-1">
                            <b class="text-slate-800 flex items-center gap-1.5 text-xs">
                                <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-slate-900"></i>
                                <span>4. Bimbingan Teknis & Code Review</span>
                            </b>
                            <p class="text-[11px] text-slate-500 leading-relaxed">
                                Membimbing standar penulisan kode, arsitektur framework Laravel/Tailwind, dan standar Git flow tim.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 text-[11px] text-slate-400">
                    Menu Utama: <b>Dashboard Mentor, Siswa Bimbingan, Validasi Logbook, Rapor Nilai, Galeri Karya</b>
                </div>
            </div>

            <!-- 3. ROLE ADMIN TMS -->
            <div class="mas-card p-6 space-y-5 border-t-4 border-t-emerald-600 flex flex-col justify-between">
                <div class="space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                                <i data-lucide="shield-check" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900">Role: Admin TMS / HR</h3>
                                <p class="text-[11px] text-slate-400">Pengelola Operasional & Master Data</p>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded-full bg-emerald-600 text-white text-[10px] font-bold">Admin</span>
                    </div>

                    <div class="space-y-3 text-xs text-slate-600">
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 space-y-1">
                            <b class="text-slate-800 flex items-center gap-1.5 text-xs">
                                <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-emerald-600"></i>
                                <span>1. Data Angkatan & Project (>1 Proyek)</span>
                            </b>
                            <p class="text-[11px] text-slate-500 leading-relaxed">
                                Mengelola batch/cohort magang dan mendaftarkan proyek perangkat lunak per angkatan (1 angkatan dapat mengerjakan lebih dari 1 project).
                            </p>
                        </div>

                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 space-y-1">
                            <b class="text-slate-800 flex items-center gap-1.5 text-xs">
                                <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-emerald-600"></i>
                                <span>2. Kelola Data Siswa & Divisi Kerja</span>
                            </b>
                            <p class="text-[11px] text-slate-500 leading-relaxed">
                                Mendaftarkan akun siswa, mengatur bidang/divisi kerja (misal: IT/Marketing), menetapkan mentor pendamping, dan status alumni.
                            </p>
                        </div>

                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 space-y-1">
                            <b class="text-slate-800 flex items-center gap-1.5 text-xs">
                                <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-emerald-600"></i>
                                <span>3. Instansi Sekolah & Kampus Mitra</span>
                            </b>
                            <p class="text-[11px] text-slate-500 leading-relaxed">
                                Mendokumentasikan sekolah/kampus asal siswa, kontak guru pembimbing, dan riwayat kerja sama MoU jangka panjang.
                            </p>
                        </div>

                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 space-y-1">
                            <b class="text-slate-800 flex items-center gap-1.5 text-xs">
                                <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-emerald-600"></i>
                                <span>4. Penerbitan & Cetak E-Sertifikat QR</span>
                            </b>
                            <p class="text-[11px] text-slate-500 leading-relaxed">
                                Menyetel nomor unik sertifikat otomatis dan mencetak sertifikat digital dengan QR code verifikasi anti-pemalsuan.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 text-[11px] text-slate-400">
                    Menu Utama: <b>Monitoring Global, Pendaftaran PKL, Data Siswa, Data Mentor, Angkatan & Project DUDI, Sekolah Mitra, Laporan Rekap</b>
                </div>
            </div>

        </div>

        <!-- Alur Operasional: Verifikasi Pendaftaran PKL & Penerbitan ID Akun Siswa -->
        <div class="mas-card p-6 bg-gradient-to-r from-red-50/50 via-white to-amber-50/40 border border-slate-200 space-y-4">
            <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100">
                <div class="w-9 h-9 rounded-xl bg-red-600 text-white flex items-center justify-center font-bold shadow-xs">
                    <i data-lucide="user-check" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-sm font-black text-slate-900">Alur Verifikasi Pendaftaran PKL & Penerbitan ID Akun Siswa</h3>
                    <p class="text-[11px] text-slate-500">Standar operasional penerimaan siswa magang baru dari antrian online hingga resmi memiliki ID akun industri.</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                <!-- Step 1 -->
                <div class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-2xs space-y-2 relative overflow-hidden">
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center gap-1 font-mono font-bold text-red-600 text-[11px]">
                            <span class="w-5 h-5 rounded-lg bg-red-100 text-red-700 flex items-center justify-center text-[10px]">1</span>
                            LANGKAH 01
                        </span>
                        <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 font-mono text-[10px] font-bold">Portal Publik</span>
                    </div>
                    <h4 class="font-bold text-slate-900 text-xs">Calon Siswa Mendaftar Online</h4>
                    <p class="text-[11px] text-slate-500 leading-relaxed">
                        Calon siswa mendaftar di <code class="px-1.5 py-0.5 rounded bg-slate-100 text-red-600 font-mono font-bold">/registry-pkl</code> & mendapatkan <b>Kode Antrian</b> unik.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-2xs space-y-2 relative overflow-hidden">
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center gap-1 font-mono font-bold text-amber-600 text-[11px]">
                            <span class="w-5 h-5 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center text-[10px]">2</span>
                            LANGKAH 02
                        </span>
                        <span class="px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 font-mono text-[10px] font-bold">Review Admin</span>
                    </div>
                    <h4 class="font-bold text-slate-900 text-xs">Persetujuan Formulir Masuk</h4>
                    <p class="text-[11px] text-slate-500 leading-relaxed">
                        Klik <strong>"Setujui"</strong> untuk menerima pendaftar. Sistem otomatis meng-autofill biodata ke <strong>Data Siswa</strong> dengan status <code class="px-1.5 py-0.5 rounded bg-amber-100 text-amber-800 font-mono font-bold">(belum terdaftar)</code>.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-2xs space-y-2 relative overflow-hidden">
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center gap-1 font-mono font-bold text-emerald-600 text-[11px]">
                            <span class="w-5 h-5 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-[10px]">3</span>
                            LANGKAH 03
                        </span>
                        <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 font-mono text-[10px] font-bold">Penerbitan ID</span>
                    </div>
                    <h4 class="font-bold text-slate-900 text-xs">Tetapkan Mentor & Terbitkan ID</h4>
                    <p class="text-[11px] text-slate-500 leading-relaxed">
                        Buka menu <strong>Data Siswa</strong>, klik tombol <strong>"Edit"</strong> untuk memilih <strong>Mentor Pembimbing TMS</strong>. Saat disimpan, sistem akan secara resmi menerbitkan <strong>ID Akun 5-Digit</strong> unik siswa!
                    </p>
                </div>
            </div>
        </div>

    </div>

    <!-- ================================================================= -->
    <!-- TAB 2: FUNGSI LENGKAP PER MENU SIDEBAR                            -->
    <!-- ================================================================= -->
    <div id="tab-sidebar" class="guide-tab-content hidden space-y-6">

        <div class="mas-card p-6 space-y-4">
            <div class="flex items-center gap-2 pb-3 border-b border-slate-100">
                <i data-lucide="layout-grid" class="w-5 h-5 text-red-600"></i>
                <h3 class="text-sm font-black text-slate-900 uppercase tracking-tight">Kamus Fungsi Menu Sidebar SIMAK-TMS</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-slate-200 text-slate-400 uppercase text-[10px] tracking-wider bg-slate-50">
                            <th class="py-3 px-3">Ikon & Menu</th>
                            <th class="py-3 px-3">Hak Akses Role</th>
                            <th class="py-3 px-3">Tujuan & Fungsi Fitur</th>
                            <th class="py-3 px-3">Petunjuk Pemakaian</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr>
                            <td class="py-3 px-3 font-bold text-slate-900 flex items-center gap-2">
                                <i data-lucide="layout-dashboard" class="w-4 h-4 text-red-600"></i>
                                <span>Dashboard Siswa</span>
                            </td>
                            <td class="py-3 px-3"><span class="px-2 py-0.5 rounded bg-red-50 text-red-600 font-bold text-[10px]">Siswa</span></td>
                            <td class="py-3 px-3 text-slate-600">Pusat ringkasan aktivitas siswa, status masuk lab hari ini, jumlah logbook terisi, dan karya terdaftar.</td>
                            <td class="py-3 px-3 text-slate-500">Gunakan sebagai beranda awal setiap hari kerja untuk cek status presensi dan progres.</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-3 font-bold text-slate-900 flex items-center gap-2">
                                <i data-lucide="book-open" class="w-4 h-4 text-red-600"></i>
                                <span>Jurnal Kegiatan</span>
                            </td>
                            <td class="py-3 px-3"><span class="px-2 py-0.5 rounded bg-red-50 text-red-600 font-bold text-[10px]">Siswa</span></td>
                            <td class="py-3 px-3 text-slate-600">Formulir logbook kegiatan harian, catatan capaian, kendala, serta commit Git.</td>
                            <td class="py-3 px-3 text-slate-500">Klik tombol "Tambah Logbook Baru", isi deskripsi kegiatan dan tautan commit GitHub.</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-3 font-bold text-slate-900 flex items-center gap-2">
                                <i data-lucide="folder-git-2" class="w-4 h-4 text-red-600"></i>
                                <span>Arsip Portofolio</span>
                            </td>
                            <td class="py-3 px-3"><span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 font-bold text-[10px]">Semua Role</span></td>
                            <td class="py-3 px-3 text-slate-600">Galeri showcase karya perangkat lunak hasil kreasi siswa PKL yang siap diuji publik.</td>
                            <td class="py-3 px-3 text-slate-500">Filter berdasarkan angkatan, klik tombol "Repo" untuk source code dan "Live" untuk demo.</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-3 font-bold text-slate-900 flex items-center gap-2">
                                <i data-lucide="award" class="w-4 h-4 text-red-600"></i>
                                <span>Evaluasi & Nilai</span>
                            </td>
                            <td class="py-3 px-3"><span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 font-bold text-[10px]">Semua Role</span></td>
                            <td class="py-3 px-3 text-slate-600">Rapor penilaian industri mencakup 4 pilar kompetensi, grafik radar keahlian, dan transkrip.</td>
                            <td class="py-3 px-3 text-slate-500">Siswa dapat melihat rapor; Mentor/Admin berwenang mengisi dan memperbarui nilai siswa.</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-3 font-bold text-slate-900 flex items-center gap-2">
                                <i data-lucide="user" class="w-4 h-4 text-red-600"></i>
                                <span>Profil Developer</span>
                            </td>
                            <td class="py-3 px-3"><span class="px-2 py-0.5 rounded bg-red-50 text-red-600 font-bold text-[10px]">Siswa</span></td>
                            <td class="py-3 px-3 text-slate-600">Halaman biodata profesional ala GitHub, heatmap kontribusi, QR Code e-sertifikat, dan link medsos.</td>
                            <td class="py-3 px-3 text-slate-500">Gunakan form di bawah halaman untuk melengkapi URL GitHub, LinkedIn, dan foto profil.</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-3 font-bold text-slate-900 flex items-center gap-2">
                                <i data-lucide="users" class="w-4 h-4 text-slate-900"></i>
                                <span>Siswa Bimbingan</span>
                            </td>
                            <td class="py-3 px-3"><span class="px-2 py-0.5 rounded bg-slate-900 text-white font-bold text-[10px]">Mentor</span></td>
                            <td class="py-3 px-3 text-slate-600">Daftar siswa magang yang berada di bawah bimbingan teknis mentor bersangkutan.</td>
                            <td class="py-3 px-3 text-slate-500">Pantau presensi, divisi kerja, dan akses langsung rapor serta logbook tiap siswa.</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-3 font-bold text-slate-900 flex items-center gap-2">
                                <i data-lucide="check-check" class="w-4 h-4 text-emerald-600"></i>
                                <span>Validasi Logbook</span>
                            </td>
                            <td class="py-3 px-3"><span class="px-2 py-0.5 rounded bg-slate-900 text-white font-bold text-[10px]">Mentor</span></td>
                            <td class="py-3 px-3 text-slate-600">Antarmuka review cepat untuk memeriksa jurnal harian siswa dan menyisipkan catatan mentor.</td>
                            <td class="py-3 px-3 text-slate-500">Tulis saran di kolom catatan atau klik rekomendasi cepat, lalu klik "Simpan Catatan".</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-3 font-bold text-slate-900 flex items-center gap-2">
                                <i data-lucide="clipboard-list" class="w-4 h-4 text-emerald-600"></i>
                                <span>Pendaftaran PKL</span>
                            </td>
                            <td class="py-3 px-3"><span class="px-2 py-0.5 rounded bg-emerald-600 text-white font-bold text-[10px]">Admin</span></td>
                            <td class="py-3 px-3 text-slate-600">Portal verifikasi antrian pendaftaran magang online, pemeriksaan berkas administrasi, dan seleksi calon peserta PKL.</td>
                            <td class="py-3 px-3 text-slate-500">Gunakan tombol titik-tiga Aksi untuk Setujui atau Tolak pendaftar. Klik Setujui untuk memindahkan calon siswa ke Data Siswa.</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-3 font-bold text-slate-900 flex items-center gap-2">
                                <i data-lucide="users" class="w-4 h-4 text-emerald-600"></i>
                                <span>Data Siswa (Semua Batch)</span>
                            </td>
                            <td class="py-3 px-3"><span class="px-2 py-0.5 rounded bg-emerald-600 text-white font-bold text-[10px]">Admin</span></td>
                            <td class="py-3 px-3 text-slate-600">Master database seluruh siswa magang lintas periode, penetapan mentor pembimbing, divisi, dan status alumni.</td>
                            <td class="py-3 px-3 text-slate-500">Klik "Edit Data" untuk menetapkan mentor & menerbitkan ID 5-digit resmi, atau kelola status kelulusan alumni.</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-3 font-bold text-slate-900 flex items-center gap-2">
                                <i data-lucide="graduation-cap" class="w-4 h-4 text-emerald-600"></i>
                                <span>Direktori Alumni PKL</span>
                            </td>
                            <td class="py-3 px-3"><span class="px-2 py-0.5 rounded bg-emerald-600 text-white font-bold text-[10px]">Admin</span></td>
                            <td class="py-3 px-3 text-slate-600">Galeri grid talenta alumni lulusan PKL, tracking karir pasca-magang (bekerja/kuliah/usaha), dan rekam jejak angkatan.</td>
                            <td class="py-3 px-3 text-slate-500">Filter berdasarkan angkatan tahun, cari nama alumni, klik profil untuk membuka portofolio lengkap, atau perbarui karir.</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-3 font-bold text-slate-900 flex items-center gap-2">
                                <i data-lucide="user-check" class="w-4 h-4 text-emerald-600"></i>
                                <span>Data Mentor & Staff</span>
                            </td>
                            <td class="py-3 px-3"><span class="px-2 py-0.5 rounded bg-emerald-600 text-white font-bold text-[10px]">Admin</span></td>
                            <td class="py-3 px-3 text-slate-600">Manajemen akun instruktur/mentor industri TMS, keahlian divisi, dan alokasi kapasitas bimbingan siswa.</td>
                            <td class="py-3 px-3 text-slate-500">Tambah akun mentor baru, atur divisi teknis, pantau rasio beban pembimbingan siswa tiap mentor.</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-3 font-bold text-slate-900 flex items-center gap-2">
                                <i data-lucide="folder-git-2" class="w-4 h-4 text-emerald-600"></i>
                                <span>Angkatan & Project</span>
                            </td>
                            <td class="py-3 px-3"><span class="px-2 py-0.5 rounded bg-emerald-600 text-white font-bold text-[10px]">Admin</span></td>
                            <td class="py-3 px-3 text-slate-600">Pusat manajemen gelombang magang (cohort) dan repositori proyek tim (1 angkatan > 1 project).</td>
                            <td class="py-3 px-3 text-slate-500">Tambah batch baru, daftarkan project perangkat lunak, isi tech stack dan anggota tim.</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-3 font-bold text-slate-900 flex items-center gap-2">
                                <i data-lucide="building-2" class="w-4 h-4 text-emerald-600"></i>
                                <span>Sekolah & Kampus Mitra</span>
                            </td>
                            <td class="py-3 px-3"><span class="px-2 py-0.5 rounded bg-emerald-600 text-white font-bold text-[10px]">Admin</span></td>
                            <td class="py-3 px-3 text-slate-600">Direktori SMK/Kampus mitra, nomor kontak guru pembimbing sekolah, dan dokumen MoU.</td>
                            <td class="py-3 px-3 text-slate-500">Simpan kontak guru pembimbing dan detail kerjasama untuk rekrutmen jangka panjang.</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-3 font-bold text-slate-900 flex items-center gap-2">
                                <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600"></i>
                                <span>Verifikasi Sertifikat</span>
                            </td>
                            <td class="py-3 px-3"><span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 font-bold text-[10px]">Semua Role</span></td>
                            <td class="py-3 px-3 text-slate-600">Popup modal in-page untuk memverifikasi keaslian sertifikat tanpa berpindah halaman.</td>
                            <td class="py-3 px-3 text-slate-500">Cukup klik menu di sidebar, ketik nomor sertifikat/NIS, dan hasil langsung tampil seketika.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- ================================================================= -->
    <!-- TAB 3: STANDAR OPERASIONAL PROSEDUR (SOP) LAB TMS                 -->
    <!-- ================================================================= -->
    <div id="tab-sop" class="guide-tab-content hidden space-y-6">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="mas-card p-6 space-y-4">
                <div class="flex items-center gap-2 pb-3 border-b border-slate-100">
                    <i data-lucide="clock" class="w-5 h-5 text-red-600"></i>
                    <h3 class="text-sm font-bold text-slate-900">1. Jam Kerja & Kehadiran Lab</h3>
                </div>
                <ul class="space-y-2.5 text-xs text-slate-600 list-disc list-inside">
                    <li>Jam operasional magang adalah <b>Senin – Jumat, pukul 08.00 – 17.00 WIB</b>.</li>
                    <li>Siswa wajib berada di ruang software lab TMS sebelum sesi *daily standup* dimulai.</li>
                    <li>Presensi masuk dan pulang otomatis tercatat melalui sistem geofencing jaringan lab.</li>
                    <li>Izin sakit atau keperluan mendesak wajib mengonfirmasi mentor teknis dan staf HR via WhatsApp.</li>
                </ul>
            </div>

            <div class="mas-card p-6 space-y-4">
                <div class="flex items-center gap-2 pb-3 border-b border-slate-100">
                    <i data-lucide="git-branch" class="w-5 h-5 text-slate-900"></i>
                    <h3 class="text-sm font-bold text-slate-900">2. Standar Commit Git & Dokumentasi</h3>
                </div>
                <ul class="space-y-2.5 text-xs text-slate-600 list-disc list-inside">
                    <li>Setiap progres pekerjaan fitur wajib dibuat branch tersendiri (format: <code class="bg-slate-100 px-1 py-0.5 rounded font-mono">feature/nama-fitur</code>).</li>
                    <li>Gunakan pesan commit deskriptif (contoh: <code class="bg-slate-100 px-1 py-0.5 rounded font-mono">feat: implementasi qr verification modal</code>).</li>
                    <li>Tautan commit atau pull request GitHub disalin ke formulir logbook harian SIMAK-TMS.</li>
                    <li>Dilarang melakukan force push (<code class="bg-slate-100 px-1 py-0.5 rounded font-mono">git push -f</code>) pada branch <code class="font-mono">main</code> atau <code class="font-mono">staging</code>.</li>
                </ul>
            </div>

            <div class="mas-card p-6 space-y-4">
                <div class="flex items-center gap-2 pb-3 border-b border-slate-100">
                    <i data-lucide="file-text" class="w-5 h-5 text-emerald-600"></i>
                    <h3 class="text-sm font-bold text-slate-900">3. Ketentuan Pengisian Logbook</h3>
                </div>
                <ul class="space-y-2.5 text-xs text-slate-600 list-disc list-inside">
                    <li>Logbook harian diisi setiap hari kerja sebagai bukti riil keikutsertaan program magang.</li>
                    <li>Hindari deskripsi singkat seperti "ngoding" atau "belajar". Jabarkan modul teknis yang dikerjakan.</li>
                    <li>Mentor akan menyisipkan catatan dan rekomendasi perbaikan langsung di logbook tersebut.</li>
                    <li>Logbook yang lengkap menjadi prasyarat kelulusan penerbitan sertifikat magang.</li>
                </ul>
            </div>

            <div class="mas-card p-6 space-y-4">
                <div class="flex items-center gap-2 pb-3 border-b border-slate-100">
                    <i data-lucide="award" class="w-5 h-5 text-amber-600"></i>
                    <h3 class="text-sm font-bold text-slate-900">4. Kriteria Kelulusan E-Sertifikat</h3>
                </div>
                <ul class="space-y-2.5 text-xs text-slate-600 list-disc list-inside">
                    <li>Kehadiran kumulatif minimal <b>85%</b> selama periode magang berlangsung.</li>
                    <li>Menyelesaikan dan mendeploy minimal 1 proyek nyata ke dalam galeri showcase angkatan.</li>
                    <li>Memperoleh nilai rata-rata akhir minimal <b>75.0 (Memuaskan / B)</b> dari mentor.</li>
                    <li>Sertifikat resmi terbit berformat digital lengkap dengan QR code dan verifikasi publik.</li>
                </ul>
            </div>

            <!-- 5. Alur Verifikasi Pendaftaran PKL Online & Penerbitan ID Akun Siswa -->
            <div class="mas-card p-6 space-y-4 md:col-span-2 bg-gradient-to-r from-red-50/50 via-white to-amber-50/40 border border-slate-200">
                <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100">
                    <div class="w-8 h-8 rounded-lg bg-red-600 text-white flex items-center justify-center font-bold shadow-xs">
                        <i data-lucide="user-check" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-slate-900">5. Alur Verifikasi Pendaftaran PKL Online & Penerbitan ID Akun Siswa</h3>
                        <p class="text-[11px] text-slate-500">Standar operasional penerimaan siswa magang baru dari formulir online hingga aktif memiliki ID akun resmi.</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs">
                    <div class="p-3.5 rounded-xl bg-white border border-slate-200/80 space-y-1.5 shadow-2xs">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-red-600 font-mono text-[11px]">LANGKAH 01</span>
                            <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-600 font-mono text-[10px]">Publik</span>
                        </div>
                        <h4 class="font-bold text-slate-900 text-xs">Calon Siswa Mendaftar Online</h4>
                        <p class="text-[11px] text-slate-500 leading-relaxed">
                            Calon siswa mendaftar di <code class="px-1 py-0.5 rounded bg-slate-100 text-red-600 font-mono">/registry-pkl</code> & mendapatkan <b>Kode Antrian</b> unik.
                        </p>
                    </div>

                    <div class="p-3.5 rounded-xl bg-white border border-slate-200/80 space-y-1.5 shadow-2xs">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-amber-600 font-mono text-[11px]">LANGKAH 02</span>
                            <span class="px-2 py-0.5 rounded bg-amber-50 text-amber-700 font-mono text-[10px]">Admin Review</span>
                        </div>
                        <h4 class="font-bold text-slate-900 text-xs">Klik "Setujui" di Pendaftaran</h4>
                        <p class="text-[11px] text-slate-500 leading-relaxed">
                            Klik <strong>"Setujui"</strong> untuk menerima pendaftar. Sistem otomatis meng-autofill biodata ke <strong>Data Siswa</strong> dengan status <code class="px-1 py-0.5 rounded bg-amber-100 text-amber-800 font-mono font-bold">(belum terdaftar)</code>.
                        </p>
                    </div>

                    <div class="p-3.5 rounded-xl bg-white border border-slate-200/80 space-y-1.5 shadow-2xs">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-emerald-600 font-mono text-[11px]">LANGKAH 03</span>
                            <span class="px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 font-mono text-[10px]">Terbitkan ID</span>
                        </div>
                        <h4 class="font-bold text-slate-900 text-xs">Tetapkan Mentor & Terbitkan ID</h4>
                        <p class="text-[11px] text-slate-500 leading-relaxed">
                            Buka menu <strong>Data Siswa</strong>, klik tombol <strong>"Edit"</strong> untuk memilih <strong>Mentor Pembimbing TMS</strong>. Saat disimpan, sistem akan secara resmi menerbitkan <strong>ID Akun 5-Digit</strong> unik siswa!
                        </p>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- ================================================================= -->
    <!-- TAB 4: KEAMANAN AKUN & KATA SANDI                                 -->
    <!-- ================================================================= -->
    <div id="tab-security" class="guide-tab-content hidden space-y-6">

        <div class="mas-card p-6 space-y-5">
            <div class="flex items-center gap-2 pb-3 border-b border-slate-100">
                <i data-lucide="shield-check" class="w-5 h-5 text-red-600"></i>
                <h3 class="text-sm font-bold text-slate-900">Pedoman Keamanan & Akses Akun SIMAK-TMS</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                    <b class="text-slate-800 text-sm flex items-center gap-1.5">
                        <i data-lucide="key" class="w-4 h-4 text-red-600"></i>
                        <span>Format Login Menggunakan ID (Bukan @)</span>
                    </b>
                    <p class="text-slate-600 leading-relaxed">
                        Akun Siswa dan Mentor di-generate menggunakan nomor identifikasi 5-digit khusus (contoh: <code class="font-bold text-red-600">19364</code>), bukan menggunakan email atau awalan <code class="font-mono">@</code>.
                    </p>
                </div>

                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                    <b class="text-slate-800 text-sm flex items-center gap-1.5">
                        <i data-lucide="lock" class="w-4 h-4 text-red-600"></i>
                        <span>Kata Sandi Default & Kewajiban Ganti</span>
                    </b>
                    <p class="text-slate-600 leading-relaxed">
                        Kata sandi bawaan awal adalah <code class="bg-red-50 text-red-600 px-1 py-0.5 rounded font-mono font-bold">tmshebatsukses</code>. Pada login pertama, siswa dan mentor diwajibkan memperbarui sandi pribadi (minimal 6 karakter bebas).
                    </p>
                </div>

                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                    <b class="text-slate-800 text-sm flex items-center gap-1.5">
                        <i data-lucide="check-square" class="w-4 h-4 text-red-600"></i>
                        <span>Fitur Ingat Sesi Saya (Remember Me)</span>
                    </b>
                    <p class="text-slate-600 leading-relaxed">
                        Centang kotak <b>"Ingat sesi saya"</b> saat login agar peramban menyimpan sesi kerja Anda sehingga tidak perlu melakukan login ulang berulang kali.
                    </p>
                </div>

                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                    <b class="text-slate-800 text-sm flex items-center gap-1.5">
                        <i data-lucide="rotate-ccw" class="w-4 h-4 text-red-600"></i>
                        <span>Reset Sandi oleh Admin TMS</span>
                    </b>
                    <p class="text-slate-600 leading-relaxed">
                        Bila siswa atau mentor lupa kata sandi, hubungi Admin TMS. Admin dapat mereset sandi kembali ke bawaan pabrik <code class="font-mono text-red-600">tmshebatsukses</code> lewat menu titik tiga more pada tabel pengguna.
                    </p>
                </div>
            </div>

            <!-- Box Pusat Bantuan Login -->
            <div class="p-4 rounded-xl bg-red-50/60 border border-red-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-red-600 text-white flex items-center justify-center shrink-0">
                        <i data-lucide="help-circle" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-red-900">Kendala Akses Sebelum Masuk Akun?</div>
                        <div class="text-[11px] text-red-700">Pusat bantuan publik untuk kendala login dapat diakses langsung dari halaman login.</div>
                    </div>
                </div>
                <a href="{{ route('faq') }}" target="_blank" class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white text-xs font-bold transition-colors shrink-0 flex items-center gap-1.5 self-start sm:self-auto shadow-xs">
                    <span>Buka FAQ Login</span>
                    <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                </a>
            </div>
        </div>

    </div>

</div>

<script>
    function switchGuideTab(tabId) {
        // Hide all contents
        document.querySelectorAll('.guide-tab-content').forEach(el => el.classList.add('hidden'));
        // Show target
        const target = document.getElementById(tabId);
        if (target) target.classList.remove('hidden');

        // Reset button styles
        document.querySelectorAll('.guide-tab-btn').forEach(btn => {
            btn.className = 'guide-tab-btn px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 transition-all flex items-center gap-2 shrink-0';
        });

        // Activate clicked button
        const activeBtn = document.getElementById('btn-' + tabId);
        if (activeBtn) {
            activeBtn.className = 'guide-tab-btn px-4 py-2 rounded-xl text-xs font-bold transition-all bg-red-600 text-white shadow-xs flex items-center gap-2 shrink-0';
        }

        if (window.lucide) lucide.createIcons();
    }
</script>
@endsection
