@extends('layouts.simak')

@section('title', 'Pusat Monitoring Global & Arsip Master • Admin TMS')

@section('content')
<div class="space-y-6 min-w-0 max-w-full">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-black tracking-tight text-slate-900">Pusat Monitoring Global & Arsip Master</h1>
            <p class="text-xs text-slate-500 mt-0.5">Monitoring komprehensif seluruh siswa lintas angkatan, repositori proyek digital, dan rekapitulasi nilai DUDI.</p>
        </div>

        <div class="grid grid-cols-2 sm:flex sm:items-center gap-2 w-full sm:w-auto">
            <button onclick="document.getElementById('form-register-user').scrollIntoView({behavior: 'smooth'})" class="col-span-2 sm:col-auto px-3.5 py-2 bg-slate-900 hover:bg-black text-white text-xs font-bold rounded-xl transition-all shadow-xs flex items-center justify-center gap-2">
                <i data-lucide="user-plus" class="w-4 h-4 text-red-500 shrink-0"></i>
                <span>Daftarkan Siswa / Mentor</span>
            </button>
            <button onclick="window.print()" class="px-3 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-xl transition-all shadow-xs flex items-center justify-center gap-2">
                <i data-lucide="printer" class="w-4 h-4 text-slate-500 shrink-0"></i>
                <span class="truncate">Cetak Rekap</span>
            </button>
            <a href="{{ route('showcase.index') }}" class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-red-600/25 flex items-center justify-center gap-2">
                <i data-lucide="folder-git-2" class="w-4 h-4 shrink-0"></i>
                <span class="truncate">Galeri Karya</span>
            </a>
        </div>
    </div>

    <!-- 1. Top 4 Global KPI Cards: Formasi 2x2 (2 Atas, 2 Bawah) -->
    <div class="grid grid-cols-2 gap-3 sm:gap-4">
        
        <!-- Card 1: Total Seluruh Siswa Magang (Atas Kiri) -->
        <div class="mas-card p-3.5 sm:p-5 border-l-4 border-l-red-600 flex flex-col justify-between">
            <div class="flex items-start justify-between gap-2">
                <div class="min-w-0">
                    <p class="text-slate-400 text-[10px] sm:text-xs font-bold uppercase tracking-wider mb-1 truncate">Siswa Terdaftar (Semua Batch)</p>
                    <h3 class="text-xl sm:text-3xl font-black text-slate-900 tracking-tight font-mono">{{ $totalInterns }} <span class="text-xs sm:text-sm font-normal text-slate-500">Peserta</span></h3>
                </div>
                <div class="w-8 h-8 sm:w-11 sm:h-11 bg-red-50 text-red-600 rounded-xl flex items-center justify-center shrink-0">
                    <i data-lucide="users" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                </div>
            </div>
            <div class="mt-3 pt-2.5 border-t border-slate-100 text-[10px] sm:text-xs text-slate-500 flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                <span class="truncate">Mitra: SMKN 1 Ciamis</span>
                <span class="text-emerald-600 font-bold shrink-0">100% Terverifikasi</span>
            </div>
        </div>

        <!-- Card 2: Total Tim Pembimbing / Mentor TMS (Atas Kanan) -->
        <div class="mas-card p-3.5 sm:p-5 border-l-4 border-l-slate-900 flex flex-col justify-between">
            <div class="flex items-start justify-between gap-2">
                <div class="min-w-0">
                    <p class="text-slate-400 text-[10px] sm:text-xs font-bold uppercase tracking-wider mb-1 truncate">Staff Mentor TMS</p>
                    <h3 class="text-xl sm:text-3xl font-black text-slate-900 tracking-tight font-mono">{{ $totalMentors }} <span class="text-xs sm:text-sm font-normal text-slate-500">Lead Dev</span></h3>
                </div>
                <div class="w-8 h-8 sm:w-11 sm:h-11 bg-slate-100 text-slate-900 rounded-xl flex items-center justify-center shrink-0">
                    <i data-lucide="user-check" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                </div>
            </div>
            <div class="mt-3 pt-2.5 border-t border-slate-100 text-[10px] sm:text-xs text-slate-500 flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                <span class="truncate">Lab Software Banjar</span>
                <span class="text-slate-700 font-bold shrink-0">Aktif Membimbing</span>
            </div>
        </div>

        <!-- Card 3: Master Arsip Seluruh Portofolio Karya (Bawah Kiri) -->
        <div class="mas-card p-3.5 sm:p-5 border-l-4 border-l-red-500 flex flex-col justify-between">
            <div class="flex items-start justify-between gap-2">
                <div class="min-w-0">
                    <p class="text-slate-400 text-[10px] sm:text-xs font-bold uppercase tracking-wider mb-1 truncate">Master Arsip Portofolio</p>
                    <h3 class="text-xl sm:text-3xl font-black text-slate-900 tracking-tight font-mono">{{ $totalProjects }} <span class="text-xs sm:text-sm font-normal text-slate-500 whitespace-nowrap">Proyek</span></h3>
                </div>
                <div class="w-8 h-8 sm:w-11 sm:h-11 bg-red-50 text-red-600 rounded-xl flex items-center justify-center shrink-0">
                    <i data-lucide="archive" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                </div>
            </div>
            <div class="mt-3 pt-2.5 border-t border-slate-100 text-[10px] sm:text-xs text-slate-500 flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                <span class="truncate">Seluruh Angkatan:</span>
                <span class="font-bold text-red-600 shrink-0">Arsip Permanen</span>
            </div>
        </div>

        <!-- Card 4: Total Logbook & Kelulusan DUDI (Bawah Kanan) -->
        <div class="mas-card p-3.5 sm:p-5 border-l-4 border-l-slate-800 flex flex-col justify-between">
            <div class="flex items-start justify-between gap-2">
                <div class="min-w-0">
                    <p class="text-slate-400 text-[10px] sm:text-xs font-bold uppercase tracking-wider mb-1 truncate">Rekapitulasi Nilai & Lulus</p>
                    <h3 class="text-xl sm:text-3xl font-black text-slate-900 tracking-tight font-mono">100% <span class="text-xs sm:text-sm font-normal text-emerald-600 font-bold whitespace-nowrap">Lulus [A]</span></h3>
                </div>
                <div class="w-8 h-8 sm:w-11 sm:h-11 bg-slate-100 text-slate-800 rounded-xl flex items-center justify-center shrink-0">
                    <i data-lucide="award" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                </div>
            </div>
            <div class="mt-3 pt-2.5 border-t border-slate-100 text-[10px] sm:text-xs text-slate-500 flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                <span class="truncate">Total Logbook: {{ $totalJournals }} Jurnal</span>
                <span class="font-bold text-slate-800 shrink-0">Siap Cetak Rapor</span>
            </div>
        </div>

    </div>

    <!-- ============================================================== -->
    <!-- 1.5. CHART.JS MONITORING TELEMETRY (Tren Aktivitas & Siswa)    -->
    <!-- ============================================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Chart 1: Tren Monitoring Aktivitas & Siswa (Bar & Line Combo) -->
        <div class="mas-card p-4 sm:p-6 lg:col-span-2 flex flex-col justify-between overflow-hidden self-start w-full transition-all">
            <div id="chart-trend-header" class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100 transition-all">
                <div class="flex items-center justify-between gap-2 w-full sm:w-auto">
                    <div class="min-w-0">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center shrink-0 aspect-square">
                                <i data-lucide="activity" class="w-4 h-4"></i>
                            </div>
                            <h2 class="text-sm sm:text-base font-black text-slate-900 tracking-tight">Tren Monitoring Aktivitas Siswa</h2>
                        </div>
                        <p id="chart-trend-sub" class="text-xs text-slate-400 mt-1">Volume pengisian jurnal kegiatan harian dan presensi kehadiran seluruh siswa.</p>
                    </div>

                    <!-- Tombol Panah Mobile (Sisi Kanan Atas) -->
                    <button type="button" onclick="toggleChartCard('chart-trend')" class="sm:hidden w-7 h-7 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-700 flex items-center justify-center transition-all cursor-pointer shrink-0" title="Sembunyikan Grafik">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </button>
                </div>

                <!-- Kontrol Timeframe & Tombol Panah Desktop -->
                <div class="flex items-center gap-2 self-start sm:self-auto shrink-0 w-full sm:w-auto justify-between sm:justify-end">
                    <div id="chart-trend-controls" class="flex items-center bg-slate-100 p-1 rounded-xl text-xs font-bold">
                        <button id="btn-chart-weekly" onclick="switchTimeframe('weekly')" class="px-3 py-1 rounded-lg bg-red-600 text-white shadow-xs transition-all">Minggu Ini</button>
                        <button id="btn-chart-monthly" onclick="switchTimeframe('monthly')" class="px-3 py-1 rounded-lg bg-transparent text-slate-600 hover:text-slate-900 transition-all">Bulan Ini</button>
                    </div>

                    <!-- Tombol Panah Desktop (Sisi Kanan Atas Kecil Warna Abu) -->
                    <button type="button" onclick="toggleChartCard('chart-trend')" class="hidden sm:flex w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-700 items-center justify-center transition-all cursor-pointer shrink-0" title="Sembunyikan Grafik">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>

            <!-- Konten Grafik (Bisa Disembunyikan) -->
            <div id="chart-trend-body" class="space-y-4">
                <!-- Metric Telemetry Badges (Compact & Truncate Safe on Mobile) -->
                <div class="grid grid-cols-3 gap-2 sm:gap-3 mt-4 mb-2">
                    <div class="p-2 sm:p-3 rounded-xl bg-slate-50 border border-slate-100 min-w-0">
                        <div class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider truncate">Total Siswa</div>
                        <div class="text-base sm:text-lg font-black text-slate-900 font-mono mt-0.5 truncate">{{ $totalInterns }} <span class="text-[10px] sm:text-[11px] font-normal text-slate-500">Peserta</span></div>
                    </div>
                    <div class="p-2 sm:p-3 rounded-xl bg-red-50/50 border border-red-100 min-w-0">
                        <div class="text-[9px] sm:text-[10px] font-bold text-red-600 uppercase tracking-wider truncate">Jurnal Masuk</div>
                        <div class="text-base sm:text-lg font-black text-red-600 font-mono mt-0.5 truncate">{{ $totalJournals }} <span class="text-[10px] sm:text-[11px] font-normal text-red-400">Logbook</span></div>
                    </div>
                    <div class="p-2 sm:p-3 rounded-xl bg-slate-50 border border-slate-100 min-w-0">
                        <div class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider truncate">Portofolio</div>
                        <div class="text-base sm:text-lg font-black text-slate-900 font-mono mt-0.5 truncate">{{ $totalProjects }} <span class="text-[10px] sm:text-[11px] font-normal text-slate-500">Proyek</span></div>
                    </div>
                </div>

                <!-- Canvas Container -->
                <div class="relative w-full max-w-full h-64 overflow-hidden">
                    <canvas id="adminMonitoringChart"></canvas>
                </div>

                <div class="pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between gap-2 text-[11px] text-slate-400">
                    <div class="flex items-center gap-4">
                        <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm bg-red-600 inline-block"></span> Jurnal Harian (Logbook)</span>
                        <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm bg-slate-900 inline-block"></span> Presensi Masuk Lab</span>
                    </div>
                    <span class="text-emerald-600 font-semibold flex items-center gap-1">
                        <i data-lucide="trending-up" class="w-3.5 h-3.5"></i>
                        Aktivitas 100% Real-Time
                    </span>
                </div>
            </div>
        </div>

        <!-- Chart 2: Komposisi & Distribusi Status Siswa (Doughnut Chart) -->
        <div class="mas-card p-4 sm:p-6 flex flex-col justify-between overflow-hidden self-start w-full transition-all">
            <div id="chart-status-header" class="flex items-center justify-between gap-3 pb-4 border-b border-slate-100 transition-all">
                <div class="min-w-0">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-900 flex items-center justify-center shrink-0 aspect-square">
                            <i data-lucide="pie-chart" class="w-4 h-4"></i>
                        </div>
                        <h2 class="text-sm xl:text-base font-black text-slate-900 tracking-tight whitespace-nowrap">Status & Kelulusan Siswa</h2>
                    </div>
                    <p id="chart-status-sub" class="text-xs text-slate-400 mt-1">Proporsi status pembimbingan, penugasan, dan kelulusan industri.</p>
                </div>

                <!-- Tombol Panah (Sisi Kanan Atas Kecil Warna Abu) -->
                <button type="button" onclick="toggleChartCard('chart-status')" class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-700 flex items-center justify-center transition-all cursor-pointer shrink-0" title="Sembunyikan Grafik">
                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                </button>
            </div>

            <!-- Konten Grafik Donut (Bisa Disembunyikan) -->
            <div id="chart-status-body" class="space-y-3">
                <!-- Canvas Doughnut Container with centered counter -->
                <div class="relative w-full max-w-full h-52 my-3 flex items-center justify-center overflow-hidden">
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
                        <span class="font-mono font-bold text-slate-900">{{ $interns->whereNotNull('mentor_id')->where('status', '!=', 'alumni')->count() }} Siswa</span>
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

    </div>

    <!-- 2. Section: Master Data Siswa Magang (Semua Batch / Angkatan) -->
    <div id="tabel-siswa" class="mas-card p-4 sm:p-6 space-y-4 overflow-hidden">
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

        <!-- Mobile Card List (Responsive < 768px, sama seperti Kelola Siswa) -->
        <div class="md:hidden divide-y divide-slate-100">
            @forelse($interns as $intern)
                @php
                    $hasCert = !empty($intern->account_id) && !empty($intern->mentor_id) && !empty($intern->evaluation) && $intern->evaluation->is_published;
                @endphp
                <div class="p-4 space-y-3 hover:bg-slate-50/70 transition-colors">
                    <!-- Row 1: Avatar, Name, ID & Status -->
                    <div class="flex items-start justify-between gap-2.5">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <div class="w-10 h-10 rounded-xl overflow-hidden bg-slate-900 text-white font-extrabold flex items-center justify-center border border-red-500/30 shrink-0 text-xs">
                                @if($intern->avatar)
                                    <img src="{{ $intern->avatar }}" alt="{{ $intern->name }}" class="w-full h-full object-cover">
                                @else
                                    {{ substr($intern->name, 0, 2) }}
                                @endif
                            </div>
                            <div class="min-w-0">
                                <div class="font-bold text-slate-900 text-xs truncate">{{ $intern->name }}</div>
                                <div class="flex items-center flex-wrap gap-1 mt-0.5">
                                    @if(!empty($intern->account_id))
                                        <span class="font-mono text-red-600 font-bold text-[10px]">ID: {{ $intern->account_id }}</span>
                                    @else
                                        <span class="font-mono text-amber-700 bg-amber-100/90 px-1.5 py-0.5 rounded text-[9px] font-bold border border-amber-300">(belum terdaftar)</span>
                                    @endif
                                    <span class="text-[10px] text-slate-400 truncate max-w-[140px]">• {{ $intern->email }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="shrink-0">
                            @if($intern->status === 'alumni')
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200 font-bold text-[9.5px]">Alumni</span>
                            @elseif(empty($intern->account_id) || empty($intern->mentor_id))
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-amber-50 text-amber-800 border border-amber-200 font-bold text-[9.5px]">Pending</span>
                            @elseif($intern->evaluation)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-red-50 text-red-700 border border-red-200 font-bold font-mono text-[10px]">Nilai: {{ $intern->evaluation->final_score }}</span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 font-bold text-[9.5px]">✓ Aktif</span>
                            @endif
                        </div>
                    </div>

                    <!-- Row 2: School & Mentor Grid -->
                    <div class="grid grid-cols-2 gap-2 text-[11px] bg-slate-50/80 p-2.5 rounded-xl border border-slate-100">
                        <div class="min-w-0">
                            <div class="text-[9.5px] font-bold text-slate-400 uppercase">Sekolah & Jurusan</div>
                            <div class="font-semibold text-slate-800 truncate mt-0.5">{{ $intern->school_origin ?? 'SMKN 1 Ciamis' }}</div>
                            <div class="text-[10px] text-slate-500 truncate">{{ $intern->major ?? 'PPLG' }}</div>
                        </div>
                        <div class="min-w-0">
                            <div class="text-[9.5px] font-bold text-slate-400 uppercase">Pembimbing TMS</div>
                            @if($intern->mentor)
                                <div class="font-bold text-slate-800 truncate mt-0.5">{{ $intern->mentor->name }}</div>
                                <div class="text-[10px] text-red-600 font-semibold truncate">{{ $intern->mentor->location ?? 'Software Eng.' }}</div>
                            @else
                                <div class="text-amber-700 font-bold text-[10.5px] mt-0.5">Belum di-assign</div>
                            @endif
                        </div>
                    </div>

                    <!-- Row 3: Quick Actions + Titik 3 Dropdown -->
                    <div class="flex items-center justify-between gap-2 pt-1 no-print">
                        <div class="text-[10.5px] text-slate-500 font-medium">
                            <b class="text-slate-800 font-mono">{{ $intern->projects->count() ?? 0 }}</b> Proyek
                        </div>
                        <div class="flex items-center gap-1.5">
                            <button type="button" onclick="openEditModal({{ $intern->id }}, '{{ addslashes($intern->name) }}', '{{ addslashes($intern->email) }}', '{{ addslashes($intern->school_origin ?? 'SMKN 1 Ciamis') }}', '{{ addslashes($intern->major ?? 'PPLG') }}', '{{ $intern->mentor_id }}', '{{ $intern->status ?? 'aktif' }}', '{{ $intern->alumni_status ?? 'bekerja' }}', '{{ addslashes($intern->alumni_current_at ?? '') }}')" class="px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-[11px] font-bold flex items-center gap-1 cursor-pointer">
                                <i data-lucide="edit-2" class="w-3 h-3"></i>
                                <span>Edit</span>
                            </button>
                            @if(!empty($intern->account_id) && !empty($intern->mentor_id))
                                <button type="button" onclick="openEvaluationModal({{ $intern->id }}, '{{ addslashes($intern->name) }}', '{{ $intern->account_id }}', {{ $intern->evaluation->technical_skill ?? 85 }}, {{ $intern->evaluation->discipline ?? 90 }}, {{ $intern->evaluation->teamwork ?? 85 }}, {{ $intern->evaluation->initiative ?? 85 }}, '{{ $intern->evaluation->certificate_number ?? ('TMS-CERT-' . date('Y') . '-' . $intern->account_id) }}', '{{ $intern->evaluation->issue_date ?? date('Y-m-d') }}', '{{ addslashes($intern->evaluation->general_notes ?? 'Peserta menunjukkan progres koding sangat baik.') }}')" class="px-2.5 py-1.5 rounded-lg bg-red-50 hover:bg-red-100 text-red-700 border border-red-200 text-[11px] font-bold flex items-center gap-1 cursor-pointer">
                                    <i data-lucide="award" class="w-3 h-3"></i>
                                    <span>Nilai</span>
                                </button>
                            @endif
                            @if($hasCert)
                                <a href="{{ route('certificate.print', $intern->evaluation->certificate_number ?? ('TMS-CERT-2026-' . $intern->account_id)) }}" target="_blank" class="px-2.5 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-[11px] font-bold flex items-center gap-1">
                                    <i data-lucide="printer" class="w-3 h-3"></i>
                                    <span>Sertif</span>
                                </a>
                            @endif
                            <div class="relative inline-block text-left dropdown-container">
                                <button type="button" onclick="toggleActionDropdown(this, event)" class="w-8 h-8 rounded-lg bg-white hover:bg-slate-100 text-slate-600 border border-slate-200 flex items-center justify-center cursor-pointer" title="Opsi Aksi Lainnya">
                                    <i data-lucide="more-vertical" class="w-4 h-4"></i>
                                </button>
                                <div class="action-dropdown hidden absolute right-0 bottom-full mb-1.5 w-48 bg-white rounded-2xl shadow-xl border border-slate-100 py-1.5 z-50 divide-y divide-slate-100 text-left">
                                    <div class="py-1">
                                        @if(!empty($intern->account_id))
                                            <a href="{{ $intern->profile_url }}" target="_blank" class="flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                                                <i data-lucide="user" class="w-3.5 h-3.5 text-slate-400"></i>
                                                <span>Lihat Profil</span>
                                            </a>
                                        @endif
                                        @if($hasCert)
                                            <a href="{{ route('verify.show', $intern->evaluation->certificate_number ?? ('TMS-CERT-2026-' . $intern->account_id)) }}" target="_blank" class="flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                                                <i data-lucide="shield-check" class="w-3.5 h-3.5 text-emerald-500"></i>
                                                <span>Verifikasi QR</span>
                                            </a>
                                        @endif
                                    </div>
                                    <div class="py-1">
                                        @if($intern->status === 'alumni')
                                            <form action="{{ route('admin.students.alumni', $intern->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="aktif">
                                                <button type="submit" class="w-full flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-emerald-700 hover:bg-emerald-50 text-left cursor-pointer">
                                                    <i data-lucide="rotate-ccw" class="w-3.5 h-3.5 text-emerald-600"></i>
                                                    <span>Kembalikan ke Aktif</span>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.students.alumni', $intern->id) }}" method="POST" onsubmit="return confirm('Luluskan siswa {{ addslashes($intern->name) }} dan pindahkan ke Alumni Magang?');">
                                                @csrf
                                                <input type="hidden" name="status" value="alumni">
                                                <button type="submit" class="w-full flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-indigo-700 hover:bg-indigo-50 text-left cursor-pointer">
                                                    <i data-lucide="graduation-cap" class="w-3.5 h-3.5 text-indigo-600"></i>
                                                    <span>Luluskan / Jadi Alumni</span>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-xs text-slate-400">Belum ada data siswa terdaftar.</div>
            @endforelse
        </div>

        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                        <th class="py-3 px-4">Siswa & Developer</th>
                        <th class="py-3 px-4">Sekolah & Jurusan</th>
                        <th class="py-3 px-4">Pembimbing TMS</th>
                        <th class="py-3 px-4">Karya Proyek</th>
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
                                        <div class="font-bold text-slate-900 text-xs">
                                            {{ $intern->name }} 
                                            @if(!empty($intern->account_id))
                                                <span class="font-mono text-red-600 font-bold text-[11px]">({{ $intern->account_id }})</span>
                                            @else
                                                <span class="font-mono text-amber-700 bg-amber-100/90 px-1.5 py-0.5 rounded text-[10px] font-bold border border-amber-300">(belum terdaftar)</span>
                                            @endif
                                        </div>
                                        <div class="text-[10px] text-slate-400 font-mono">
                                            @if(!empty($intern->account_id))
                                                ID: {{ $intern->account_id }} • {{ $intern->email }}
                                            @else
                                                <span class="text-amber-600 font-semibold font-sans">Menunggu Penetapan Mentor</span> • {{ $intern->email }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-semibold text-slate-800">{{ $intern->school_origin }}</div>
                                <div class="text-[10px] text-slate-500">{{ $intern->major }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                @if($intern->mentor)
                                    <div class="font-bold text-slate-800 text-xs">{{ $intern->mentor->name }} <span class="font-mono text-red-600 text-[11px]">({{ $intern->mentor->account_id ?? $intern->mentor->username ?? $intern->mentor->id }})</span></div>
                                    <div class="text-[10px] text-slate-500">{{ $intern->mentor->major ?? 'Pembimbing TMS' }}</div>
                                    <div class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 rounded-md bg-red-50 text-red-700 text-[10px] font-bold border border-red-200">
                                        <i data-lucide="briefcase" class="w-3 h-3 text-red-600"></i>
                                        <span>Divisi: {{ $intern->mentor->location ?? 'IT / Software Engineering' }}</span>
                                    </div>
                                @else
                                    <span class="text-slate-400 italic text-[11px]">Belum di-assign</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="font-bold text-slate-900 font-mono">{{ $intern->projects->count() ?? 1 }} Proyek</span>
                                <div class="text-[10px] text-slate-400">Portofolio Digital</div>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @if($intern->status === 'alumni')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200 font-bold text-[10px] whitespace-nowrap leading-none shadow-2xs">
                                        <i data-lucide="graduation-cap" class="w-3.5 h-3.5 text-indigo-600"></i>
                                        Alumni Magang
                                    </span>
                                    @if($intern->evaluation)
                                        <div class="mt-1">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 font-mono text-[9px] font-bold">
                                                Nilai: {{ $intern->evaluation->final_score }} [A]
                                            </span>
                                        </div>
                                    @endif
                                @elseif(empty($intern->account_id) || empty($intern->mentor_id))
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-50 text-amber-800 border border-amber-200 font-bold text-[10px] whitespace-nowrap leading-none shadow-2xs">
                                        <i data-lucide="clock" class="w-3 h-3 text-amber-600"></i>
                                        Belum Di-assign
                                    </span>
                                @elseif($intern->evaluation)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-red-50 text-red-700 border border-red-200 font-bold font-mono text-[11px] whitespace-nowrap leading-none shadow-2xs">
                                        Nilai: {{ $intern->evaluation->final_score }} [A]
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 font-bold text-[10px] whitespace-nowrap leading-none shadow-2xs">
                                        ✓ Aktif Magang
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <!-- Menu Aksi Titik 3 (More Action Dropdown) -->
                                <div class="relative inline-block text-left dropdown-container">
                                    <button type="button" onclick="toggleActionDropdown(this, event)" class="w-8 h-8 rounded-xl bg-white hover:bg-slate-100 text-slate-600 hover:text-slate-900 border border-slate-200 transition-colors shadow-2xs flex items-center justify-center cursor-pointer ml-auto" title="Opsi Aksi Siswa">
                                        <i data-lucide="more-vertical" class="w-4 h-4"></i>
                                    </button>
                                    <div class="action-dropdown hidden absolute right-0 mt-1.5 w-48 bg-white rounded-2xl shadow-xl border border-slate-100 py-1.5 z-40 divide-y divide-slate-100 text-left animate-in fade-in zoom-in-95 duration-100">
                                        <div class="py-1">
                                            @if(!empty($intern->account_id))
                                                <a href="{{ $intern->profile_url }}" target="_blank" class="flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                                                    <i data-lucide="user" class="w-3.5 h-3.5 text-slate-400"></i>
                                                    <span>Lihat Profil</span>
                                                </a>
                                            @else
                                                <button type="button" onclick="alert('Profil {{ addslashes($intern->name) }} belum dapat dibuka karena siswa belum terdaftar resmi (belum memiliki ID & pembimbing mentor). Silakan klik Edit Data untuk memilih mentor terlebih dahulu.')" class="w-full flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-slate-400 hover:bg-slate-50 transition-colors text-left cursor-not-allowed opacity-60" title="Siswa belum terdaftar resmi">
                                                    <i data-lucide="user-x" class="w-3.5 h-3.5 text-slate-400"></i>
                                                    <span>Profil (Belum Terdaftar)</span>
                                                </button>
                                            @endif
                                            <a href="{{ route('evaluation.index') }}" class="flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                                                <i data-lucide="award" class="w-3.5 h-3.5 text-red-500"></i>
                                                <span>Rapor & Nilai</span>
                                            </a>
                                        </div>
                                        <div class="py-1">
                                            @if($intern->status === 'alumni')
                                                <form action="{{ route('admin.students.alumni', $intern->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="aktif">
                                                    <button type="submit" class="w-full flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-emerald-700 hover:bg-emerald-50 transition-colors text-left cursor-pointer">
                                                        <i data-lucide="rotate-ccw" class="w-3.5 h-3.5 text-emerald-600"></i>
                                                        <span>Kembalikan ke Aktif</span>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.students.alumni', $intern->id) }}" method="POST" onsubmit="return confirm('Luluskan siswa {{ addslashes($intern->name) }} dan pindahkan ke Alumni Magang? Data portofolio dan sertifikat akan tetap tersimpan aman.');">
                                                    @csrf
                                                    <input type="hidden" name="status" value="alumni">
                                                    <button type="submit" class="w-full flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-indigo-700 hover:bg-indigo-50 transition-colors text-left cursor-pointer">
                                                        <i data-lucide="graduation-cap" class="w-3.5 h-3.5 text-indigo-600"></i>
                                                        <span>Luluskan / Jadi Alumni</span>
                                                    </button>
                                                </form>
                                            @endif
                                            <button type="button" onclick="openEditModal({{ $intern->id }}, '{{ addslashes($intern->name) }}', '{{ addslashes($intern->email) }}', '{{ addslashes($intern->school_origin ?? 'SMKN 1 Ciamis') }}', '{{ addslashes($intern->major ?? 'PPLG') }}', '{{ $intern->mentor_id }}', '{{ $intern->status ?? 'aktif' }}', '{{ $intern->alumni_status ?? 'bekerja' }}', '{{ addslashes($intern->alumni_current_at ?? '') }}')" class="w-full flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors text-left cursor-pointer">
                                                <i data-lucide="edit-2" class="w-3.5 h-3.5 text-slate-400"></i>
                                                <span>Edit Data</span>
                                            </button>
                                            <button type="button" onclick="openResetPasswordModal({{ $intern->id }}, '{{ addslashes($intern->name) }}', '{{ $intern->account_id ?? $intern->email }}', 'siswa')" class="w-full flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-amber-700 hover:bg-amber-50 transition-colors text-left cursor-pointer">
                                                <i data-lucide="rotate-ccw" class="w-3.5 h-3.5 text-amber-500"></i>
                                                <span>Reset Sandi</span>
                                            </button>
                                        </div>
                                        <div class="py-1">
                                            <button type="button" onclick="openStudentDeletionModal({{ $intern->id }}, '{{ addslashes($intern->name) }}', '{{ $intern->status ?? 'aktif' }}')" class="w-full flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-red-600 hover:bg-red-50 transition-colors text-left cursor-pointer">
                                                <i data-lucide="trash-2" class="w-3.5 h-3.5 text-red-500"></i>
                                                <span>Hapus Siswa</span>
                                            </button>
                                        </div>
                                    </div>
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
    <div class="mas-card p-4 sm:p-6 space-y-4 overflow-hidden">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-3">
            <div>
                <h2 class="text-base font-black text-slate-900 tracking-tight flex items-center gap-2">
                    <i data-lucide="archive" class="w-5 h-5 text-red-600 shrink-0"></i>
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
                <div class="p-3.5 sm:p-4 rounded-xl border border-slate-200 bg-white flex flex-col justify-between space-y-3 min-w-0 overflow-hidden">
                    <div>
                        <div class="flex items-center justify-between gap-2 min-w-0">
                            <h3 class="text-xs font-bold text-slate-900 font-mono truncate min-w-0 flex-1">{{ $proj->title }}</h3>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-red-50 text-red-600 border border-red-200 whitespace-nowrap shrink-0">
                                {{ $proj->batch->name ?? 'Angkatan 2026' }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-600 mt-1.5 leading-relaxed">{{ $proj->short_description ?? $proj->description }}</p>
                        <div class="text-[11px] text-slate-400 mt-2 truncate">
                            Pengembang: <b class="text-slate-700">{{ $proj->creator->name ?? 'Pradipta Endra Maulana' }}</b> ({{ $proj->creator->school_origin ?? 'SMKN 1 Ciamis' }})
                        </div>
                    </div>

                    <div class="pt-2 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-xs">
                        <span class="text-[10px] font-mono text-slate-500 truncate min-w-0 flex-1">{{ $proj->tech_stack }}</span>
                        <div class="flex items-center gap-2 shrink-0">
                            @if($proj->repo_url)
                                <a href="{{ $proj->repo_url }}" target="_blank" class="px-2.5 py-1 rounded-lg bg-slate-900 hover:bg-black text-white text-[11px] font-mono font-medium flex items-center gap-1.5 shadow-2xs transition-colors shrink-0">
                                    <svg class="w-3.5 h-3.5 fill-current shrink-0" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/></svg>
                                    <span>Repo</span>
                                </a>
                            @endif
                            @if(filled($proj->live_url))
                                <a href="{{ $proj->live_url }}" target="_blank" class="px-2.5 py-1 rounded-lg bg-red-600 hover:bg-red-700 text-white text-[11px] font-bold flex items-center gap-1.5 shadow-2xs transition-colors shrink-0">
                                    <i data-lucide="external-link" class="w-3 h-3 shrink-0"></i>
                                    <span>Live/Demo</span>
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

    <!-- 4. Section: Pendaftaran Akun Baru oleh Admin (Mentor & Siswa) -->
    <div id="form-register-user" class="mas-card p-4 sm:p-8 space-y-4 sm:space-y-5 overflow-hidden">
        <div class="border-b border-slate-100 pb-4">
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
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap *</label>
                    <input type="text" name="name" required placeholder="Contoh: Alyzza Nazwa" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Email / Username (Opsional)</label>
                    <input type="text" name="email" placeholder="alyzza@smkn1ciamis.sch.id (otomatis jika kosong)" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                </div>
            </div>

            <!-- Bagian Khusus Siswa (Dropdown Mentor & Batch) -->
            <div id="siswa-fields" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Pilih Pembimbing TMS (Mentor)</label>
                        <select name="mentor_id" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 font-medium focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                            <option value="">{{ $mentors->count() > 0 ? '-- Pilih Mentor Pembimbing --' : '-- Belum Ada Staff Mentor Terdaftar --' }}</option>
                            @foreach($mentors as $m)
                                <option value="{{ $m->id }}">{{ $m->name }} ({{ $m->school_origin }})</option>
                            @endforeach
                        </select>
                        @if($mentors->count() === 0)
                            <p class="text-[10px] text-amber-600 font-bold mt-1">Belum ada mentor. Daftarkan mentor terlebih dahulu di atas atau di menu Data Mentor & Staff.</p>
                        @else
                            <p class="text-[10px] text-slate-400 mt-1">Siswa otomatis muncul di daftar monitoring mentor yang dipilih.</p>
                        @endif
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

            <div class="pt-3 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <span class="text-[11px] text-slate-400">Password standar akun baru: <b class="font-mono text-slate-700">password</b></span>
                <button type="submit" class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-bold transition-all shadow-md shadow-red-600/30 flex items-center justify-center gap-2 whitespace-nowrap">
                    <i data-lucide="check" class="w-4 h-4 shrink-0"></i>
                    <span>Daftarkan Akun Pengguna</span>
                </button>
            </div>
        </form>
    </div>

    <!-- 6. Section: Rekapitulasi Nilai & Laporan Resmi DUDI -->
    <div id="rekapitulasi-laporan" class="mas-card p-4 sm:p-6 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-3">
            <div>
                <h2 class="text-base font-black text-slate-900 tracking-tight flex items-center gap-2">
                    <i data-lucide="file-spreadsheet" class="w-5 h-5 text-red-600 shrink-0"></i>
                    <span>Rekapitulasi Laporan Resmi PKL untuk Sekolah Mitra</span>
                </h2>
                <p class="text-xs text-slate-400 mt-0.5">Ekspor transkrip nilai 4 pilar industri dan sertifikat kelulusan magang untuk SMKN 1 Ciamis.</p>
            </div>
            <button onclick="window.print()" class="w-full sm:w-auto px-4 py-2 rounded-xl bg-slate-900 hover:bg-black text-white text-xs font-bold transition-all shadow-xs flex items-center justify-center gap-2 whitespace-nowrap">
                <i data-lucide="download" class="w-4 h-4 text-emerald-400 shrink-0"></i>
                <span>Ekspor Rekap Nilai (PDF / Print)</span>
            </button>
        </div>
        <div class="bg-slate-50 p-3 sm:p-4 rounded-xl border border-slate-200 text-xs text-slate-600 flex items-center justify-between gap-3">
            <div class="min-w-0 flex-1">
                <div class="font-bold text-slate-800 text-[11px] sm:text-xs truncate">Status Rekapitulasi: 1 Siswa Terdaftar (Batch 2026/2027)</div>
                <div class="text-[10px] sm:text-[11px] text-slate-500 truncate">Nilai Akhir: 94.0 [ Predikat A ] • No. Sertifikat: TMS-PKL-2026-001</div>
            </div>
            <span class="px-2.5 py-1 rounded bg-emerald-100 text-emerald-800 font-bold text-[10px] whitespace-nowrap shrink-0">
                Siap Diterbitkan
            </span>
        </div>
    </div>

    <!-- Modal Edit Data Siswa (Khusus Hak Akses Admin) -->
    <div id="modal-edit-student" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
        <div class="mas-card p-6 bg-white w-full max-w-lg shadow-2xl space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center shrink-0 aspect-square">
                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-slate-900">Edit Data Siswa Magang</h3>
                        <p class="text-[11px] text-slate-400">Kelola mutasi sekolah, ganti pembimbing, atau update biodata siswa.</p>
                    </div>
                </div>
                <button onclick="closeEditModal()" class="w-7 h-7 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center text-lg">&times;</button>
            </div>

            <form id="form-edit-student" method="POST" class="space-y-3.5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap Siswa</label>
                    <input type="text" id="edit-name" name="name" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 font-semibold focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Email / Akun</label>
                    <input type="email" id="edit-email" name="email" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 font-mono focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Asal Sekolah</label>
                        <input type="text" id="edit-school" name="school_origin" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Jurusan</label>
                        <input type="text" id="edit-major" name="major" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Staff Mentor Pembimbing</label>
                    <select id="edit-mentor-id" name="mentor_id" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 font-semibold focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                        <option value="">-- Belum Diassign --</option>
                        @foreach($mentors as $mentor)
                            <option value="{{ $mentor->id }}">{{ $mentor->name }} (Mentor TMS)</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Status Keikutsertaan Magang</label>
                    <select id="edit-status" name="status" onchange="toggleAlumniFields(this.value)" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 font-semibold focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                        <option value="aktif">✓ Siswa Aktif Magang (Sedang Berjalan)</option>
                        <option value="alumni">🎓 Alumni Magang (Telah Lulus PKL)</option>
                    </select>
                </div>

                <div id="edit-alumni-section" class="hidden p-3.5 rounded-xl bg-indigo-50/70 border border-indigo-200 space-y-3">
                    <div class="flex items-center gap-1.5 text-indigo-950 font-bold text-xs">
                        <i data-lucide="graduation-cap" class="w-4 h-4 text-indigo-600"></i>
                        <span>Pelacakan Karir Pasca-PKL (Alumni Tracer)</span>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Status Karir</label>
                            <select id="edit-alumni-status" name="alumni_status" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                                <option value="direkrut_tms">Direkrut PT. TMS</option>
                                <option value="bekerja">Bekerja di Perusahaan Lain</option>
                                <option value="kuliah">Kuliah / Studi Lanjut</option>
                                <option value="mencari_kerja">Mencari Kerja / Freelance</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Instansi / Kampus / Kantor</label>
                            <input type="text" id="edit-alumni-current-at" name="alumni_current_at" placeholder="Contoh: PT. TMS / Politeknik" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                        </div>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-red-600/30 flex items-center gap-1.5">
                        <i data-lucide="save" class="w-3.5 h-3.5"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Pilihan Hapus / Jadikan Alumni (Smart Deletion Modal) -->
    <div id="modal-delete-student-choice" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
        <div class="mas-card p-6 bg-white w-full max-w-md shadow-2xl space-y-4">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 border border-amber-200">
                    <i data-lucide="help-circle" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-sm font-black text-slate-900">Kelola Status / Hapus Siswa</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Pilih tindakan untuk siswa <b id="delete-modal-student-name" class="text-slate-800">Nama Siswa</b></p>
                </div>
            </div>

            <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-600 space-y-2 leading-relaxed">
                <p>Apakah siswa ini <b>telah menyelesaikan masa PKL (Lulus)</b> atau Anda ingin <b>menghapus permanen</b> dari sistem?</p>
            </div>

            <!-- 2 Pilihan Tindakan Utama -->
            <div class="space-y-2.5">
                <!-- Pilihan A: Pindahkan ke Alumni PKL -->
                <form id="form-choice-alumni" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="alumni">
                    <button type="submit" class="w-full p-3.5 rounded-xl border-2 border-indigo-200 bg-indigo-50/70 hover:bg-indigo-100 text-left transition-all flex items-start gap-3 group cursor-pointer">
                        <div class="w-8 h-8 rounded-lg bg-indigo-600 text-white flex items-center justify-center shrink-0 shadow-sm mt-0.5">
                            <i data-lucide="graduation-cap" class="w-4 h-4"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-1.5">
                                <span class="text-xs font-black text-indigo-950">Pindahkan ke Alumni PKL</span>
                                <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-indigo-200 text-indigo-800 uppercase tracking-wider">Direkomendasikan</span>
                            </div>
                            <p class="text-[11px] text-indigo-700/90 mt-0.5">Siswa lulus magang. Seluruh sertifikat, rapor nilai, portofolio, dan logbook <b>tetap aman tersimpan abadi</b>.</p>
                        </div>
                    </button>
                </form>

                <!-- Pilihan B: Hapus Permanen dari Database -->
                <form id="form-choice-delete" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('PERINGATAN: Seluruh data jurnal, tugas, dan nilai sertifikat siswa ini akan DIHAPUS PERMANEN dan tidak dapat dipulihkan. Yakin ingin melanjutkan?');" class="w-full p-3.5 rounded-xl border border-red-200 bg-red-50/40 hover:bg-red-50 text-left transition-all flex items-start gap-3 group cursor-pointer">
                        <div class="w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center shrink-0 mt-0.5">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </div>
                        <div class="flex-1">
                            <span class="text-xs font-bold text-red-800">Hapus Permanen Dari Database</span>
                            <p class="text-[11px] text-red-600/90 mt-0.5">Gunakan jika akun ini pendaftar fiktif/batal magang. Seluruh data & riwayat akan dimusnahkan.</p>
                        </div>
                    </button>
                </form>
            </div>

            <div class="pt-2 flex justify-end">
                <button type="button" onclick="closeStudentDeletionModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition-colors cursor-pointer">
                    Batal
                </button>
            </div>
        </div>
    </div>

</div>

<script>
    function toggleAlumniFields(status) {
        const sec = document.getElementById('edit-alumni-section');
        if (sec) {
            if (status === 'alumni') {
                sec.classList.remove('hidden');
            } else {
                sec.classList.add('hidden');
            }
        }
    }

    function openEditModal(id, name, email, school, major, mentorId, status, alumniStatus, alumniCurrentAt) {
        const modal = document.getElementById('modal-edit-student');
        const form = document.getElementById('form-edit-student');
        form.action = "{{ url('/admin/siswa') }}/" + id;
        document.getElementById('edit-name').value = name;
        document.getElementById('edit-email').value = email;
        document.getElementById('edit-school').value = school;
        document.getElementById('edit-major').value = major;
        document.getElementById('edit-mentor-id').value = mentorId || '';

        const statusEl = document.getElementById('edit-status');
        if (statusEl) {
            statusEl.value = status || 'aktif';
            toggleAlumniFields(statusEl.value);
        }
        const alumniStatusEl = document.getElementById('edit-alumni-status');
        if (alumniStatusEl) {
            alumniStatusEl.value = alumniStatus || 'bekerja';
        }
        const alumniCurrentAtEl = document.getElementById('edit-alumni-current-at');
        if (alumniCurrentAtEl) {
            alumniCurrentAtEl.value = alumniCurrentAt || '';
        }

        modal.classList.remove('hidden');
        if (window.lucide) { lucide.createIcons(); }
    }

    function closeEditModal() {
        document.getElementById('modal-edit-student').classList.add('hidden');
    }

    function openStudentDeletionModal(id, name, currentStatus) {
        const modal = document.getElementById('modal-delete-student-choice');
        document.getElementById('delete-modal-student-name').textContent = name;
        document.getElementById('form-choice-alumni').action = "{{ url('/admin/siswa') }}/" + id + "/alumni";
        document.getElementById('form-choice-delete').action = "{{ url('/admin/siswa') }}/" + id;
        modal.classList.remove('hidden');
        if (window.lucide) { lucide.createIcons(); }
    }

    function closeStudentDeletionModal() {
        document.getElementById('modal-delete-student-choice').classList.add('hidden');
    }

    function toggleAdminForm(role) {
        const siswaFields = document.getElementById('siswa-fields');
        if (siswaFields) {
            siswaFields.style.display = (role === 'mentor') ? 'none' : 'block';
        }
    }

    // Toggle Collapse / Expand Chart Cards
    function toggleChartCard(name) {
        const body = document.getElementById(name + '-body');
        const sub = document.getElementById(name + '-sub');
        const controls = document.getElementById(name + '-controls');
        const header = document.getElementById(name + '-header');
        if (!body) return;

        const isHidden = body.classList.contains('hidden');
        const btns = document.querySelectorAll(`button[onclick*="'${name}'"]`);

        if (isHidden) {
            // Expand (tampil penuh kembali)
            body.classList.remove('hidden');
            if (sub) sub.classList.remove('hidden');
            if (controls) controls.classList.remove('hidden');
            if (header) {
                header.classList.add('border-b', 'pb-4');
                header.classList.remove('pb-0');
            }
            btns.forEach(b => {
                b.innerHTML = '<i data-lucide="chevron-down" class="w-4 h-4"></i>';
                b.setAttribute('title', 'Sembunyikan Grafik');
            });
        } else {
            // Collapse (sembunyi menjadi satu bar judul dengan arrow up)
            body.classList.add('hidden');
            if (sub) sub.classList.add('hidden');
            if (controls) controls.classList.add('hidden');
            if (header) {
                header.classList.remove('border-b', 'pb-4');
                header.classList.add('pb-0');
            }
            btns.forEach(b => {
                b.innerHTML = '<i data-lucide="chevron-up" class="w-4 h-4"></i>';
                b.setAttribute('title', 'Tampilkan Grafik');
            });
        }
        lucide.createIcons();
    }

    document.addEventListener('DOMContentLoaded', function () {
        // 1. Dataset for Monitoring Activity Chart (100% Real Database Aggregation)
        const chartDataWeekly = @json($chartDataWeekly);
        const chartDataMonthly = @json($chartDataMonthly);

        const maxWeekly = Math.max(...(chartDataWeekly.journals || [0]), ...(chartDataWeekly.tasks || [0]), 3);
        const maxMonthly = Math.max(...(chartDataMonthly.journals || [0]), ...(chartDataMonthly.tasks || [0]), 5);

        // 2. Initialize Combined Bar & Line Chart
        const ctxMonitoring = document.getElementById('adminMonitoringChart');
        if (ctxMonitoring) {
            const monitoringChart = new Chart(ctxMonitoring.getContext('2d'), {
                data: {
                    labels: chartDataWeekly.labels,
                    datasets: [
                        {
                            type: 'bar',
                            label: 'Jurnal Harian (Logbook)',
                            data: chartDataWeekly.journals,
                            backgroundColor: '#ef4444',
                            hoverBackgroundColor: '#dc2626',
                            borderRadius: 6,
                            barThickness: 18,
                            order: 2
                        },
                        {
                            type: 'line',
                            label: 'Presensi Masuk Lab',
                            data: chartDataWeekly.tasks,
                            borderColor: '#0f172a',
                            backgroundColor: 'rgba(15, 23, 42, 0.08)',
                            borderWidth: 2.5,
                            tension: 0.35,
                            fill: false,
                            pointBackgroundColor: '#0f172a',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 5,
                            pointHoverRadius: 7,
                            order: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: {
                                font: { family: "'Outfit', sans-serif", size: 11, weight: '500' },
                                color: '#64748b'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            suggestedMax: maxWeekly,
                            grid: {
                                color: '#f1f5f9'
                            },
                            ticks: {
                                stepSize: maxWeekly > 10 ? 2 : 1,
                                font: { family: "'Outfit', sans-serif", size: 11 },
                                color: '#94a3b8'
                            }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleFont: { family: "'Outfit', sans-serif", size: 12, weight: '700' },
                            bodyFont: { family: "'Outfit', sans-serif", size: 11 },
                            padding: 10,
                            cornerRadius: 8,
                            boxPadding: 4
                        }
                    }
                }
            });

            // Interactive Timeframe Switcher
            window.switchTimeframe = function(tf) {
                const btnW = document.getElementById('btn-chart-weekly');
                const btnM = document.getElementById('btn-chart-monthly');

                if (tf === 'weekly') {
                    monitoringChart.data.labels = chartDataWeekly.labels;
                    monitoringChart.data.datasets[0].data = chartDataWeekly.journals;
                    monitoringChart.data.datasets[1].data = chartDataWeekly.tasks;
                    monitoringChart.options.scales.y.suggestedMax = maxWeekly;
                    monitoringChart.options.scales.y.ticks.stepSize = maxWeekly > 10 ? 2 : 1;

                    btnW.className = 'px-3 py-1 rounded-lg bg-red-600 text-white shadow-xs transition-all';
                    btnM.className = 'px-3 py-1 rounded-lg bg-transparent text-slate-600 hover:text-slate-900 transition-all';
                } else {
                    monitoringChart.data.labels = chartDataMonthly.labels;
                    monitoringChart.data.datasets[0].data = chartDataMonthly.journals;
                    monitoringChart.data.datasets[1].data = chartDataMonthly.tasks;
                    monitoringChart.options.scales.y.suggestedMax = maxMonthly;
                    monitoringChart.options.scales.y.ticks.stepSize = maxMonthly > 10 ? 2 : 1;

                    btnM.className = 'px-3 py-1 rounded-lg bg-red-600 text-white shadow-xs transition-all';
                    btnW.className = 'px-3 py-1 rounded-lg bg-transparent text-slate-600 hover:text-slate-900 transition-all';
                }
                monitoringChart.update();
            };
        }

        // 3. Initialize Status Doughnut Chart
        const ctxDonut = document.getElementById('adminStatusDonutChart');
        if (ctxDonut) {
            new Chart(ctxDonut.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Siswa Aktif Magang', 'Terhubung Mentor', 'Evaluasi Selesai'],
                    datasets: [{
                        data: [
                            {{ max($interns->whereNotNull('mentor_id')->where('status', '!=', 'alumni')->count(), 1) }},
                            {{ max($interns->whereNotNull('mentor_id')->count(), 1) }},
                            {{ max($interns->filter(fn($i) => $i->evaluation)->count(), 1) }}
                        ],
                        backgroundColor: ['#0f172a', '#ef4444', '#10b981'],
                        borderWidth: 0,
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleFont: { family: "'Outfit', sans-serif", size: 12, weight: '700' },
                            bodyFont: { family: "'Outfit', sans-serif", size: 11 },
                            padding: 10,
                            cornerRadius: 8
                        }
                    },
                    cutout: '76%'
                }
            });
        }
    });
</script>
@endsection