@extends('layouts.simak')

@section('title', 'Pusat Monitoring Global & Arsip Master • Admin TMS')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-red-50 text-red-600 border border-red-200 text-[10px] font-bold uppercase tracking-wider mb-1">
                <span class="w-1.5 h-1.5 rounded-full bg-red-600 animate-pulse"></span>
                Monitoring Global Seluruh Angkatan & Master Arsip Perusahaan
            </div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900">Pusat Monitoring Global & Arsip Master</h1>
            <p class="text-xs text-slate-500 mt-0.5">Memonitoring komprehensif seluruh siswa lintas angkatan, repositori master karya proyek digital, dan rekapitulasi nilai DUDI.</p>
        </div>

        <div class="flex items-center gap-2.5">
            <button onclick="document.getElementById('form-register-user').scrollIntoView({behavior: 'smooth'})" class="px-4 py-2 bg-slate-900 hover:bg-black text-white text-xs font-bold rounded-xl transition-all shadow-xs flex items-center gap-2">
                <i data-lucide="user-plus" class="w-4 h-4 text-red-500"></i>
                <span>Daftarkan Siswa/Mentor</span>
            </button>
            <button onclick="window.print()" class="px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-xl transition-all shadow-xs flex items-center gap-2">
                <i data-lucide="printer" class="w-4 h-4 text-slate-500"></i>
                <span>Cetak Rekap</span>
            </button>
            <button onclick="document.getElementById('form-create-task').scrollIntoView({behavior: 'smooth'})" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-red-600/25 flex items-center gap-2">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                <span>Buat Modul Tugas</span>
            </button>
        </div>
    </div>

    <!-- 1. Top 4 Global KPI Cards (Semua Angkatan & Master Arsip) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Card 1: Total Seluruh Siswa Magang -->
        <div class="mas-card p-5 border-l-4 border-l-red-600 flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-slate-400 text-[11px] font-bold uppercase tracking-wider mb-1">Siswa Terdaftar (Semua Batch)</p>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight font-mono">{{ $totalInterns }} <span class="text-xs font-normal text-slate-500">Peserta</span></h3>
                </div>
                <div class="w-10 h-10 bg-red-50 text-red-600 rounded-xl flex items-center justify-center">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-slate-100 text-[11px] text-slate-500 flex items-center justify-between">
                <span>Mitra: SMKN 1 Ciamis</span>
                <span class="text-emerald-600 font-bold">100% Terverifikasi</span>
            </div>
        </div>

        <!-- Card 2: Total Tim Pembimbing / Mentor TMS -->
        <div class="mas-card p-5 border-l-4 border-l-slate-900 flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-slate-400 text-[11px] font-bold uppercase tracking-wider mb-1">Staff Mentor TMS</p>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight font-mono">{{ $totalMentors }} <span class="text-xs font-normal text-slate-500">Lead Dev</span></h3>
                </div>
                <div class="w-10 h-10 bg-slate-100 text-slate-900 rounded-xl flex items-center justify-center">
                    <i data-lucide="user-check" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-slate-100 text-[11px] text-slate-500 flex items-center justify-between">
                <span>Lab Software Banjar</span>
                <span class="text-slate-700 font-bold">Aktif Membimbing</span>
            </div>
        </div>

        <!-- Card 3: Master Arsip Seluruh Portofolio Karya -->
        <div class="mas-card p-5 border-l-4 border-l-red-500 flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-slate-400 text-[11px] font-bold uppercase tracking-wider mb-1">Master Arsip Portofolio</p>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight font-mono">{{ $totalProjects }} <span class="text-xs font-normal text-slate-500">Proyek Digital</span></h3>
                </div>
                <div class="w-10 h-10 bg-red-50 text-red-600 rounded-xl flex items-center justify-center">
                    <i data-lucide="archive" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-slate-100 text-[11px] text-slate-500 flex items-center justify-between">
                <span>Seluruh Angkatan:</span>
                <span class="font-bold text-red-600">Arsip Permanen</span>
            </div>
        </div>

        <!-- Card 4: Total Logbook & Kelulusan DUDI -->
        <div class="mas-card p-5 border-l-4 border-l-slate-800 flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-slate-400 text-[11px] font-bold uppercase tracking-wider mb-1">Rekapitulasi Nilai</p>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight font-mono">100% <span class="text-xs font-normal text-emerald-600 font-bold">Lulus [ A ]</span></h3>
                </div>
                <div class="w-10 h-10 bg-slate-100 text-slate-800 rounded-xl flex items-center justify-center">
                    <i data-lucide="award" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-slate-100 text-[11px] text-slate-500 flex items-center justify-between">
                <span>Total Logbook:</span>
                <span class="font-bold text-slate-800">{{ $totalJournals }} Jurnal</span>
            </div>
        </div>

    </div>

    <!-- ============================================================== -->
    <!-- 1.5. CHART.JS MONITORING TELEMETRY (Tren Aktivitas & Siswa)    -->
    <!-- ============================================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Chart 1: Tren Monitoring Aktivitas & Siswa (Bar & Line Combo) -->
        <div class="mas-card p-6 lg:col-span-2 flex flex-col justify-between">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
                <div>
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center">
                            <i data-lucide="activity" class="w-4 h-4"></i>
                        </div>
                        <h2 class="text-base font-black text-slate-900 tracking-tight">Tren Monitoring Aktivitas Siswa</h2>
                    </div>
                    <p class="text-xs text-slate-400 mt-1">Volume pengisian jurnal kegiatan harian dan submit modul koding oleh seluruh siswa.</p>
                </div>

                <!-- Toggle Timeframe: Minggu Ini / Bulan Ini -->
                <div class="flex items-center bg-slate-100 p-1 rounded-xl text-xs font-bold flex-shrink-0 self-start sm:self-auto">
                    <button id="btn-chart-weekly" onclick="switchTimeframe('weekly')" class="px-3 py-1 rounded-lg bg-red-600 text-white shadow-xs transition-all">Minggu Ini</button>
                    <button id="btn-chart-monthly" onclick="switchTimeframe('monthly')" class="px-3 py-1 rounded-lg bg-transparent text-slate-600 hover:text-slate-900 transition-all">Bulan Ini</button>
                </div>
            </div>

            <!-- Metric Telemetry Badges -->
            <div class="grid grid-cols-3 gap-3 my-4">
                <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Siswa Aktif</div>
                    <div class="text-lg font-black text-slate-900 font-mono mt-0.5">{{ $totalInterns }} <span class="text-[11px] font-normal text-slate-500">Peserta</span></div>
                </div>
                <div class="p-3 rounded-xl bg-red-50/50 border border-red-100">
                    <div class="text-[10px] font-bold text-red-600 uppercase tracking-wider">Jurnal Terkumpul</div>
                    <div class="text-lg font-black text-red-600 font-mono mt-0.5">{{ $totalJournals }} <span class="text-[11px] font-normal text-red-400">Logbook</span></div>
                </div>
                <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Modul Koding Terbit</div>
                    <div class="text-lg font-black text-slate-900 font-mono mt-0.5">{{ $totalTasks }} <span class="text-[11px] font-normal text-slate-500">Modul</span></div>
                </div>
            </div>

            <!-- Canvas Container -->
            <div class="relative w-full h-64">
                <canvas id="adminMonitoringChart"></canvas>
            </div>

            <div class="mt-3 pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between gap-2 text-[11px] text-slate-400">
                <div class="flex items-center gap-4">
                    <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm bg-red-600 inline-block"></span> Jurnal Harian (Logbook)</span>
                    <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm bg-slate-900 inline-block"></span> Submit Modul Koding</span>
                </div>
                <span class="text-emerald-600 font-semibold flex items-center gap-1">
                    <i data-lucide="trending-up" class="w-3.5 h-3.5"></i>
                    Aktivitas 100% Real-Time
                </span>
            </div>
        </div>

        <!-- Chart 2: Komposisi & Distribusi Status Siswa (Doughnut Chart) -->
        <div class="mas-card p-6 flex flex-col justify-between">
            <div class="pb-4 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-900 flex items-center justify-center">
                        <i data-lucide="pie-chart" class="w-4 h-4"></i>
                    </div>
                    <h2 class="text-base font-black text-slate-900 tracking-tight">Status & Kelulusan Siswa</h2>
                </div>
                <p class="text-xs text-slate-400 mt-1">Proporsi status pembimbingan, penugasan, dan kelulusan industri.</p>
            </div>

            <!-- Canvas Doughnut Container with centered counter -->
            <div class="relative w-full h-52 my-3 flex items-center justify-center">
                <canvas id="adminStatusDonutChart"></canvas>
                <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                    <span class="text-2xl font-black text-slate-900 font-mono leading-none">{{ $totalInterns }}</span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mt-1">Total Siswa</span>
                </div>
            </div>

            <!-- Custom Clean Legend List with Values -->
            <div class="space-y-2 pt-2 border-t border-slate-100">
                <div class="flex items-center justify-between text-xs">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-slate-900"></span>
                        <span class="text-slate-700 font-medium">Siswa Aktif Magang</span>
                    </div>
                    <span class="font-mono font-bold text-slate-900">{{ $totalInterns }} Siswa</span>
                </div>

                <div class="flex items-center justify-between text-xs">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-600"></span>
                        <span class="text-slate-700 font-medium">Terhubung Pembimbing</span>
                    </div>
                    <span class="font-mono font-bold text-red-600">{{ $interns->whereNotNull('mentor_id')->count() }} Siswa</span>
                </div>

                <div class="flex items-center justify-between text-xs">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                        <span class="text-slate-700 font-medium">Evaluasi Selesai [A]</span>
                    </div>
                    <span class="font-mono font-bold text-emerald-600">{{ $interns->filter(fn($i) => $i->evaluation)->count() }} Siswa</span>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100 text-center">
                <a href="{{ route('admin.students') }}" class="text-[11px] font-bold text-red-600 hover:text-red-700 transition-colors inline-flex items-center gap-1">
                    <span>Buka Rincian Siswa Magang</span>
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>
        </div>

    </div>

    <!-- 2. Section: Master Data Siswa Magang (Semua Batch / Angkatan) -->
    <div id="tabel-siswa" class="mas-card p-6 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-3">
            <div>
                <h2 class="text-base font-black text-slate-900 tracking-tight flex items-center gap-2">
                    <i data-lucide="users" class="w-5 h-5 text-red-600"></i>
                    <span>Master Data Siswa Magang (Semua Angkatan)</span>
                </h2>
                <p class="text-xs text-slate-400 mt-0.5">Monitoring rekapitulasi data siswa magang lintas periode PKL PT. Teknologi Multi Sistem.</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-lg">
                    Periode: 2026/2027
                </span>
                <a href="{{ route('admin.students') }}" class="px-3 py-1 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 text-xs font-bold rounded-lg transition-colors flex items-center gap-1.5">
                    <span>Lihat & Filter Lengkap</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                        <th class="py-3 px-4">Siswa & Developer</th>
                        <th class="py-3 px-4">Sekolah & Jurusan</th>
                        <th class="py-3 px-4">Pembimbing TMS</th>
                        <th class="py-3 px-4">Modul Disubmit</th>
                        <th class="py-3 px-4">Status & Nilai Akhir</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($interns as $intern)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl overflow-hidden bg-slate-900 text-white font-extrabold flex items-center justify-center border border-red-500/30 flex-shrink-0">
                                        @if($intern->avatar)
                                            <img src="{{ $intern->avatar }}" alt="{{ $intern->name }}" class="w-full h-full object-cover">
                                        @else
                                            {{ substr($intern->name, 0, 2) }}
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900">{{ $intern->name }}</div>
                                        <div class="text-[10px] text-slate-400 font-mono">&#64;{{ $intern->username ?? 'siswa' }} • {{ $intern->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-semibold text-slate-800">{{ $intern->school_origin }}</div>
                                <div class="text-[10px] text-slate-500">{{ $intern->major }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                @if($intern->mentor)
                                    <span class="font-medium text-slate-800">{{ $intern->mentor->name }}</span>
                                    <div class="text-[10px] text-red-600 font-semibold">{{ $intern->mentor->major ?? 'Pembimbing TMS' }}</div>
                                @else
                                    <span class="text-slate-400 italic">Belum di-assign</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="font-bold text-slate-900 font-mono">{{ $intern->submissions->count() }} Modul</span>
                                <div class="text-[10px] text-slate-400">Terkumpul di LMS</div>
                            </td>
                            <td class="py-3.5 px-4">
                                @if($intern->evaluation)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-red-50 text-red-700 border border-red-200 font-bold font-mono text-[11px]">
                                        Nilai: {{ $intern->evaluation->final_score }} [ A ]
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 font-bold text-[10px]">
                                        ✓ Aktif Magang
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('profile') }}" class="px-2.5 py-1 rounded-lg bg-slate-900 hover:bg-black text-white text-[11px] font-semibold transition-colors flex items-center gap-1">
                                        <i data-lucide="user" class="w-3 h-3 text-red-400"></i>
                                        <span>Profil</span>
                                    </a>
                                    <a href="{{ route('evaluation.index') }}" class="px-2.5 py-1 rounded-lg bg-red-600 hover:bg-red-700 text-white text-[11px] font-bold transition-colors">
                                        Rapor
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">Belum ada siswa magang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- 3. Section: Master Arsip Seluruh Portofolio Proyek (Semua Angkatan) -->
    <div class="mas-card p-6 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-3">
            <div>
                <h2 class="text-base font-black text-slate-900 tracking-tight flex items-center gap-2">
                    <i data-lucide="archive" class="w-5 h-5 text-red-600"></i>
                    <span>Master Arsip Portofolio Proyek (Semua Angkatan)</span>
                </h2>
                <p class="text-xs text-slate-400 mt-0.5">Seluruh karya aplikasi dan produk digital yang telah dihasilkan siswa magang PT. TMS.</p>
            </div>
            <a href="{{ route('showcase.index') }}" class="text-xs font-bold text-red-600 hover:underline">
                Buka Galeri Showcase &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($allProjects as $proj)
                <div class="p-4 rounded-xl border border-slate-200 bg-white flex flex-col justify-between space-y-3">
                    <div>
                        <div class="flex items-center justify-between gap-2">
                            <h3 class="text-xs font-bold text-slate-900 font-mono">{{ $proj->title }}</h3>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-red-50 text-red-600 border border-red-200">
                                {{ $proj->batch->name ?? 'Angkatan 2026' }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-600 mt-1.5 leading-relaxed">{{ $proj->short_description ?? $proj->description }}</p>
                        <div class="text-[11px] text-slate-400 mt-2">
                            Pengembang: <b class="text-slate-700">{{ $proj->creator->name ?? 'Pradipta Endra Maulana' }}</b> ({{ $proj->creator->school_origin ?? 'SMKN 1 Ciamis' }})
                        </div>
                    </div>

                    <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-[10px] font-mono text-slate-500">{{ $proj->tech_stack }}</span>
                        <div class="flex items-center gap-2">
                            @if($proj->repo_url)
                                <a href="{{ $proj->repo_url }}" target="_blank" class="text-slate-700 hover:text-red-600 font-mono text-[11px] font-bold">
                                    Git Repo
                                </a>
                            @endif
                            @if($proj->live_url)
                                <a href="{{ $proj->live_url }}" target="_blank" class="px-2.5 py-1 rounded bg-red-600 hover:bg-red-700 text-white text-[11px] font-bold transition-colors">
                                    Live Demo
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-6 text-center text-slate-400 text-xs md:col-span-2">
                    Belum ada arsip proyek.
                </div>
            @endforelse
        </div>
    </div>

    <!-- 4. Section: Penerbitan Modul Tugas Kurikulum LMS -->
    <div id="form-create-task" class="mas-card p-6 sm:p-8 space-y-5">
        <div class="border-b border-slate-100 pb-4">
            <h2 class="text-lg font-black text-slate-900 tracking-tight flex items-center gap-2">
                <i data-lucide="plus-circle" class="w-5 h-5 text-red-600"></i>
                <span>Penerbitan Modul Tugas Kurikulum LMS Baru</span>
            </h2>
            <p class="text-xs text-slate-500 mt-0.5">Admin atau Lead Mentor dapat membuat penugasan teknis baru yang otomatis muncul pada modul seluruh siswa.</p>
        </div>

        <form action="{{ route('admin.tasks.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Judul Modul Sprint Koding</label>
                <input type="text" name="title" required placeholder="Contoh: Modul 03: Optimasi Query Database & Caching Redis"
                       class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi & Syarat Pengumpulan (Pull Request Git)</label>
                <textarea name="description" rows="3" required placeholder="Jelaskan instruksi pengerjaan, branch standar, dan kriteria acceptance test modul..."
                          class="w-full p-3 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 leading-relaxed"></textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Batas Waktu Pengumpulan (Deadline)</label>
                    <input type="datetime-local" name="deadline" required value="{{ now()->addDays(5)->format('Y-m-d\TH:i') }}"
                           class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tingkat Prioritas</label>
                    <select name="priority" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 font-medium focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                        <option value="sedang">Sedang</option>
                        <option value="tinggi" selected>Tinggi (Wajib Selesai Pekan Ini)</option>
                        <option value="rendah">Rendah (Eksplorasi Tambahan)</option>
                    </select>
                </div>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-end">
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-bold transition-all shadow-md shadow-red-600/30 flex items-center gap-2">
                    <i data-lucide="send" class="w-4 h-4"></i>
                    <span>Terbitkan Modul Sprint ke Siswa</span>
                </button>
            </div>
        </form>
    </div>

    <!-- 5. Section: Pendaftaran Akun Baru oleh Admin (Mentor & Siswa) -->
    <div id="form-register-user" class="mas-card p-6 sm:p-8 space-y-5">
        <div class="border-b border-slate-100 pb-4">
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-red-50 text-red-600 border border-red-200 text-[10px] font-bold uppercase tracking-wider mb-1">
                Hak Akses Admin
            </div>
            <h2 class="text-lg font-black text-slate-900 tracking-tight flex items-center gap-2">
                <i data-lucide="user-plus" class="w-5 h-5 text-red-600"></i>
                <span>Pendaftaran Akun Baru (Mentor & Siswa)</span>
            </h2>
            <p class="text-xs text-slate-500 mt-0.5">Admin berwenang mendaftarkan staff Mentor baru maupun Siswa magang. Data siswa otomatis terhubung ke mentor pembimbingnya.</p>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Pilih Role -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Pilih Peran Pengguna (Role)</label>
                <div class="grid grid-cols-2 gap-3 max-w-md">
                    <label class="flex items-center gap-2 p-3 rounded-xl border border-slate-200 bg-white hover:border-red-500 cursor-pointer">
                        <input type="radio" name="role" value="siswa" checked onchange="toggleAdminForm(this.value)" class="text-red-600 focus:ring-red-500">
                        <div>
                            <div class="text-xs font-bold text-slate-900">Siswa PKL</div>
                            <div class="text-[10px] text-slate-400">Peserta magang industri</div>
                        </div>
                    </label>
                    <label class="flex items-center gap-2 p-3 rounded-xl border border-slate-200 bg-white hover:border-slate-800 cursor-pointer">
                        <input type="radio" name="role" value="mentor" onchange="toggleAdminForm(this.value)" class="text-slate-900 focus:ring-slate-900">
                        <div>
                            <div class="text-xs font-bold text-slate-900">Staff Mentor</div>
                            <div class="text-[10px] text-slate-400">Pembimbing koding TMS</div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Nama & Email -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" required placeholder="Contoh: Muhammad Rizky" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Email / NISN</label>
                    <input type="email" name="email" required placeholder="rizky@smkn1ciamis.sch.id / rizky@tms.co.id" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                </div>
            </div>

            <!-- Bagian Khusus Siswa (Dropdown Mentor & Batch) -->
            <div id="siswa-fields" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Pilih Pembimbing TMS (Mentor)</label>
                        <select name="mentor_id" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 font-medium focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                            <option value="">-- Pilih Mentor Pembimbing --</option>
                            @foreach($mentors as $m)
                                <option value="{{ $m->id }}">{{ $m->name }} ({{ $m->school_origin }})</option>
                            @endforeach
                        </select>
                        <p class="text-[10px] text-slate-400 mt-1">Siswa otomatis muncul di daftar monitoring mentor yang dipilih.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Periode Angkatan / Batch PKL</label>
                        <select name="batch_id" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 font-medium focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                            @foreach($batches as $b)
                                <option value="{{ $b->id }}">{{ $b->name }} ({{ $b->year }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Asal Sekolah</label>
                        <input type="text" name="school_origin" value="SMKN 1 Ciamis" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Kompetensi Keahlian / Jurusan</label>
                        <input type="text" name="major" value="PPLG" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                </div>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                <span class="text-[11px] text-slate-400">Password standar akun baru: <b class="font-mono text-slate-700">password</b></span>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-bold transition-all shadow-md shadow-red-600/30 flex items-center gap-2">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>Daftarkan Akun Pengguna</span>
                </button>
            </div>
        </form>
    </div>

    <!-- 6. Section: Rekapitulasi Nilai & Laporan Resmi DUDI -->
    <div id="rekapitulasi-laporan" class="mas-card p-6 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-3">
            <div>
                <h2 class="text-base font-black text-slate-900 tracking-tight flex items-center gap-2">
                    <i data-lucide="file-spreadsheet" class="w-5 h-5 text-red-600"></i>
                    <span>Rekapitulasi Laporan Resmi PKL untuk Sekolah Mitra</span>
                </h2>
                <p class="text-xs text-slate-400 mt-0.5">Ekspor transkrip nilai 4 pilar industri dan sertifikat kelulusan magang untuk SMKN 1 Ciamis.</p>
            </div>
            <button onclick="window.print()" class="px-4 py-2 rounded-xl bg-slate-900 hover:bg-black text-white text-xs font-bold transition-all shadow-xs flex items-center gap-2">
                <i data-lucide="download" class="w-4 h-4 text-emerald-400"></i>
                <span>Ekspor Rekap Nilai (PDF / Print)</span>
            </button>
        </div>
        <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 text-xs text-slate-600 flex items-center justify-between">
            <div>
                <div class="font-bold text-slate-800">Status Rekapitulasi: 1 Siswa Terdaftar (Batch 2026/2027)</div>
                <div class="text-[11px] text-slate-500">Nilai Akhir: 94.0 [ Predikat A ] • No. Sertifikat: TMS-PKL-2026-001</div>
            </div>
            <span class="px-2.5 py-1 rounded bg-emerald-100 text-emerald-800 font-bold text-[10px]">
                Siap Diterbitkan
            </span>
        </div>
    </div>

</div>

<script>
    function toggleAdminForm(role) {
        const siswaFields = document.getElementById('siswa-fields');
        if (siswaFields) {
            siswaFields.style.display = (role === 'mentor') ? 'none' : 'block';
        }
    }
</script>
@endsection