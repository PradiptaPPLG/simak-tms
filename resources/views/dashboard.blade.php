@extends('layouts.simak')

@section('title', 'Dashboard Siswa • SIMAK-TMS')

@section('content')
<div class="space-y-6">

    <!-- Page Heading -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900">Dashboard Siswa</h1>
            <p class="text-xs text-slate-500 mt-0.5">Monitoring aktivitas magang, modul penugasan LMS, dan logbook harian di PT. TMS.</p>
        </div>

        <!-- Date Indicator -->
        <div class="bg-white border border-slate-200 px-3.5 py-1.5 rounded-xl text-xs font-semibold text-slate-600 flex items-center gap-2 shadow-xs self-start sm:self-auto">
            <i data-lucide="calendar" class="w-4 h-4 text-red-600"></i>
            <span>{{ now()->translatedFormat('l, d F Y') }}</span>
        </div>
    </div>

    <!-- 1. Top 3 Stat Cards (Hitam - Putih - Merah TMS Style) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        
        <!-- Card 1: Status Hari Ini -->
        <div class="mas-card p-5 border-l-4 border-l-red-600 flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-slate-500 text-xs font-medium mb-1">Status Hari Ini</p>
                    <h3 class="text-xl font-black text-slate-900 tracking-tight uppercase">MASUK KERJA</h3>
                </div>
                <div class="w-11 h-11 bg-red-50 text-red-600 rounded-xl flex items-center justify-center">
                    <i data-lucide="activity" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center gap-2 text-xs text-slate-500">
                <i data-lucide="building-2" class="w-4 h-4 text-slate-400"></i>
                <span>PT. Teknologi Multi Sistem</span>
            </div>
        </div>

        <!-- Card 2: Jurnal Terisi -->
        <div class="mas-card p-5 border-l-4 border-l-slate-900 flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-slate-500 text-xs font-medium mb-1">Jurnal Terisi</p>
                    <h3 class="text-xl font-black text-slate-900 tracking-tight">1 <span class="text-xs font-normal text-slate-500">Harian</span></h3>
                </div>
                <div class="w-11 h-11 bg-slate-100 text-slate-900 rounded-xl flex items-center justify-center">
                    <i data-lucide="book-open" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100">
                <div class="flex items-center justify-between text-xs mb-1.5">
                    <span class="font-bold text-red-600">Valid: {{ $todayJournal ? '1' : '0' }}</span>
                    <span class="text-slate-500 font-medium">100% Terverifikasi</span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                    <div class="bg-red-600 h-1.5 rounded-full" style="width: {{ $todayJournal ? '100%' : '50%' }}"></div>
                </div>
            </div>
        </div>

        <!-- Card 3: Tugas LMS / Kehadiran -->
        <div class="mas-card p-5 border-l-4 border-l-red-500 flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-slate-500 text-xs font-medium mb-1">Tugas Modul LMS</p>
                    <h3 class="text-xl font-black text-slate-900 tracking-tight">{{ $pendingTasksCount }} <span class="text-xs font-normal text-slate-500">Modul Sprint</span></h3>
                </div>
                <div class="w-11 h-11 bg-red-50 text-red-600 rounded-xl flex items-center justify-center">
                    <i data-lucide="code-2" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>Presensi: <b class="text-slate-800">07.54 WIB</b></span>
                <span class="font-bold text-red-600 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                    Hadir Lab
                </span>
            </div>
        </div>

    </div>

    <!-- 2. Aksi Cepat (Hitam - Putih - Merah TMS) -->
    <div>
        <h3 class="text-sm font-bold text-slate-700 uppercase tracking-wider mb-3">Aksi Cepat</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            
            <!-- Button 1: Isi Jurnal -->
            <a href="{{ route('journals.index') }}" class="mas-card mas-card-hover p-4 flex flex-col items-center justify-center gap-2.5 text-center group">
                <div class="w-10 h-10 rounded-full bg-red-50 text-red-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i data-lucide="edit-3" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-800 group-hover:text-red-600 transition-colors">Isi Jurnal</div>
                    <div class="text-[10px] text-slate-400">Logbook harian</div>
                </div>
            </a>

            <!-- Button 2: Modul LMS -->
            <a href="{{ route('tasks.index') }}" class="mas-card mas-card-hover p-4 flex flex-col items-center justify-center gap-2.5 text-center group">
                <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-900 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i data-lucide="clipboard-check" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-800 group-hover:text-slate-900 transition-colors">Modul LMS</div>
                    <div class="text-[10px] text-slate-400">Tugas koding aktif</div>
                </div>
            </a>

            <!-- Button 3: Arsip Portofolio -->
            <a href="{{ route('showcase.index') }}" class="mas-card mas-card-hover p-4 flex flex-col items-center justify-center gap-2.5 text-center group">
                <div class="w-10 h-10 rounded-full bg-red-50 text-red-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i data-lucide="folder-git-2" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-800 group-hover:text-red-600 transition-colors">Portofolio Karya</div>
                    <div class="text-[10px] text-slate-400">Arsip showcase</div>
                </div>
            </a>

            <!-- Button 4: Evaluasi & Rapor -->
            <a href="{{ route('evaluation.index') }}" class="mas-card mas-card-hover p-4 flex flex-col items-center justify-center gap-2.5 text-center group">
                <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-900 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i data-lucide="award" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-800 group-hover:text-slate-900 transition-colors">Transkrip Nilai</div>
                    <div class="text-[10px] text-slate-400">Evaluasi 4 pilar</div>
                </div>
            </a>

        </div>
    </div>

    <!-- 3. Active LMS Task Banner (Charcoal / Red Accent) -->
    <div class="mas-card p-5 bg-gradient-to-r from-slate-950 via-slate-900 to-black text-white rounded-2xl relative overflow-hidden shadow-md border border-slate-800">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="space-y-1">
                <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-red-600/30 text-red-400 border border-red-500/30 text-[10px] font-bold uppercase tracking-wider">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                    Sprint Koding Aktif Siswa
                </div>
                <h3 class="text-base sm:text-lg font-black text-white">
                    Modul 02: Implementasi REST API & CRUD Komentar Blog TechPulse
                </h3>
                <p class="text-xs text-slate-300 max-w-2xl leading-relaxed">
                    Siswa sedang menyelesaikan controller resource, migration relasi komentar, dan form modal dinamis dengan review Pull Request oleh mentor Farhan Ramadhan.
                </p>
            </div>
            <div class="flex-shrink-0 flex items-center gap-3">
                <a href="{{ route('tasks.index') }}" class="px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-bold transition-all shadow-md shadow-red-600/30">
                    Buka Modul Tugas &rarr;
                </a>
            </div>
        </div>
    </div>

    <!-- 4. Analytical Charts Section (Hitam & Merah TMS) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        
        <!-- Chart 1: Persentase Pengisian Jurnal (Valid vs Pending) -->
        <div class="mas-card p-5">
            <h3 class="text-xs font-black text-slate-600 uppercase tracking-wider mb-4">
                PERSENTASE PENGISIAN JURNAL (VALID VS PENDING)
            </h3>
            <div class="relative h-56 flex items-center justify-center">
                <canvas id="jurnalDonutChart"></canvas>
            </div>
            <div class="flex items-center justify-center gap-6 mt-3 text-xs">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-red-600"></span>
                    <span class="text-slate-700 font-bold">Valid Terverifikasi (100%)</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-slate-900"></span>
                    <span class="text-slate-500 font-medium">Pending (0%)</span>
                </div>
            </div>
        </div>

        <!-- Chart 2: Grafik Kehadiran Mingguan Anda -->
        <div class="mas-card p-5">
            <h3 class="text-xs font-black text-slate-600 uppercase tracking-wider mb-4">
                GRAFIK KEHADIRAN MINGGUAN ANDA (JAM CHECK-IN)
            </h3>
            <div class="relative h-56 flex items-center justify-center">
                <canvas id="kehadiranLineChart"></canvas>
            </div>
            <div class="text-center text-[11px] text-slate-500 mt-3">
                Rata-rata jam masuk lab: <b class="text-slate-900">07.54 WIB</b> (Tepat Waktu)
            </div>
        </div>

    </div>

</div>

<!-- Chart.js Scripts (Hitam - Merah Palette) -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Donut Chart
        const ctxDonut = document.getElementById('jurnalDonutChart').getContext('2d');
        new Chart(ctxDonut, {
            type: 'doughnut',
            data: {
                labels: ['Valid', 'Pending'],
                datasets: [{
                    data: [1, 0],
                    backgroundColor: ['#ef4444', '#0f172a'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                cutout: '72%'
            }
        });

        // Line Chart
        const ctxLine = document.getElementById('kehadiranLineChart').getContext('2d');
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                datasets: [{
                    label: 'Jam Check-In',
                    data: [7.54, null, null, null, null, null],
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239, 68, 68, 0.08)',
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: '#dc2626',
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        min: 7.0,
                        max: 9.0,
                        ticks: {
                            callback: function(val) {
                                return '0' + val.toFixed(2).replace('.', ':');
                            }
                        }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
    });
</script>
@endsection
