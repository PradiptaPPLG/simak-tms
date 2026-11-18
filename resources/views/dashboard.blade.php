@extends('layouts.simak')

@section('title', 'Dashboard Siswa • SIMAK-TMS')

@section('content')
<div class="space-y-6 min-w-0 max-w-full">

    <!-- Page Heading -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-xl sm:text-2xl font-black tracking-tight text-slate-900">Dashboard Siswa</h1>
            <p class="text-xs text-slate-500 mt-0.5">Monitoring aktivitas magang, portofolio karya digital, dan logbook harian di PT. TMS.</p>
        </div>

        <!-- Date Indicator -->
        <div class="bg-white border border-slate-200 px-3.5 py-1.5 rounded-xl text-xs font-semibold text-slate-600 flex items-center gap-2 shadow-xs self-start sm:self-auto">
            <i data-lucide="calendar" class="w-4 h-4 text-red-600 shrink-0"></i>
            <span>{{ now()->translatedFormat('l, d F Y') }}</span>
        </div>
    </div>

    <!-- 1. Top 3 Stat Cards (Hitam - Putih - Merah TMS Style) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 sm:gap-5">
        
        <!-- Card 1: Status Hari Ini -->
        <div class="mas-card p-4 sm:p-5 border-l-2 sm:border-l-4 border-l-red-600 flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-slate-500 text-xs font-medium mb-1">Status Magang</p>
                    <h3 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight uppercase">SISWA AKTIF</h3>
                </div>
                <div class="w-9 h-9 sm:w-11 sm:h-11 bg-red-50 text-red-600 rounded-xl flex items-center justify-center shrink-0">
                    <i data-lucide="activity" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                </div>
            </div>
            <div class="mt-3 sm:mt-4 pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between gap-1.5 text-xs text-slate-500">
                <div class="flex items-center gap-1.5 truncate">
                    <i data-lucide="building-2" class="w-4 h-4 text-slate-400 shrink-0"></i>
                    <span class="truncate">PT. TMS</span>
                </div>
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-red-50 text-red-700 text-[10px] font-bold border border-red-200 shrink-0">
                    <i data-lucide="briefcase" class="w-3 h-3 text-red-600"></i>
                    <span>Divisi {{ $user->mentor->location ?? 'IT / Software Engineering' }}</span>
                </span>
            </div>
        </div>

        <!-- Card 2: Jurnal Terselesaikan (Counting) -->
        <div class="mas-card p-4 sm:p-5 border-l-2 sm:border-l-4 border-l-slate-900 flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-slate-500 text-xs font-medium mb-1">Jurnal Terselesaikan</p>
                    <h3 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight">{{ $approvedJournalsCount ?? 1 }} <span class="text-xs font-normal text-slate-500">Logbook Valid</span></h3>
                </div>
                <div class="w-9 h-9 sm:w-11 sm:h-11 bg-slate-100 text-slate-900 rounded-xl flex items-center justify-center shrink-0">
                    <i data-lucide="book-check" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                </div>
            </div>
            <div class="mt-3 sm:mt-4 pt-3 border-t border-slate-100">
                <div class="flex items-center justify-between text-xs mb-1.5">
                    <span class="font-bold text-red-600">{{ $approvedJournalsCount ?? 1 }} Disetujui</span>
                    <span class="text-slate-500 font-medium">{{ $pendingJournalsCount ?? 0 }} Pending Review</span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                    <div class="bg-red-600 h-1.5 rounded-full" style="width: {{ ($totalJournalsCount ?? 1) > 0 ? (($approvedJournalsCount ?? 1) / ($totalJournalsCount ?? 1) * 100) : 100 }}%"></div>
                </div>
            </div>
        </div>

        <!-- Card 3: Portofolio Karya Siswa -->
        <div class="mas-card p-4 sm:p-5 border-l-2 sm:border-l-4 border-l-red-500 flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-slate-500 text-xs font-medium mb-1">Portofolio Karya Siswa</p>
                    <h3 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight">2 <span class="text-xs font-normal text-slate-500">Proyek Digital</span></h3>
                </div>
                <div class="w-9 h-9 sm:w-11 sm:h-11 bg-red-50 text-red-600 rounded-xl flex items-center justify-center shrink-0">
                    <i data-lucide="folder-git-2" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>Kategori: <b class="text-slate-800">Software & Web</b></span>
                <span class="font-bold text-emerald-600 flex items-center gap-1">
                    <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
                    Arsip Permanen
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

            <!-- Button 2: Profil Developer -->
            <a href="{{ route('profile') }}" class="mas-card mas-card-hover p-4 flex flex-col items-center justify-center gap-2.5 text-center group">
                <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-900 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i data-lucide="user" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-800 group-hover:text-slate-900 transition-colors">Profil Developer</div>
                    <div class="text-[10px] text-slate-400">Bio & Skill GitHub</div>
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
</div>
@endsection
