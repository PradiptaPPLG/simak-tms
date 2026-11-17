<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>@yield('title', 'Dashboard') • SIMAK-TMS • PT. Teknologi Multi Sistem</title>
    
    <!-- Google Fonts: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        tms: {
                            red: '#ef4444',
                            redDark: '#dc2626',
                            redDarker: '#991b1b',
                            redLight: '#fee2e2',
                            redLighter: '#fef2f2',
                            black: '#090d16',
                            charcoal: '#0f172a',
                            slate: '#1e293b'
                        }
                    }
                }
            }
        }
    </script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        html, body {
            overflow-x: hidden;
            max-width: 100vw;
        }
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
            -webkit-tap-highlight-color: transparent;
        }
        .mas-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.04), 0 1px 2px -1px rgba(0, 0, 0, 0.04);
            min-width: 0;
            max-width: 100%;
        }
        .mas-card-hover {
            transition: all 0.2s ease-in-out;
        }
        .mas-card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.08), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
        }
        /* Hide scrollbars on mobile navs but keep scrollability */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="min-h-screen flex antialiased bg-slate-50 text-slate-800 overflow-x-hidden">

    @php
        $role = auth()->check() ? auth()->user()->role : 'siswa';
    @endphp

    <!-- ============================================================== -->
    <!-- 1. DESKTOP LEFT SIDEBAR (Hitam - Putih - Merah TMS Style - FIXED)-->
    <!-- ============================================================== -->
    <aside class="fixed inset-y-0 left-0 w-64 bg-white border-r border-slate-200 hidden md:flex flex-col justify-between z-30 overflow-y-auto no-scrollbar">
        <div>
            <!-- App Brand Header -->
            <div class="h-16 flex items-center px-6 border-b border-slate-100 gap-3">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-slate-900 to-red-600 flex items-center justify-center text-white shadow-md shadow-red-500/20">
                    <i data-lucide="layers" class="w-5 h-5 text-white"></i>
                </div>
                <div>
                    <div class="font-black text-base tracking-tight text-slate-900 flex items-center gap-1.5">
                        <span>SIMAK-TMS</span>
                        <span class="text-[9px] font-bold uppercase px-1.5 py-0.5 rounded bg-red-50 text-red-600 border border-red-200">PKL</span>
                    </div>
                    <div class="text-[10px] text-slate-400 font-medium">PT. Teknologi Multi Sistem</div>
                </div>
            </div>

            <!-- Navigation Links (Role-Aware: Siswa / Mentor / Admin) -->
            <nav class="p-3.5 space-y-1">

                @if($role === 'siswa')
                    <!-- ================= MENU KHUSUS SISWA PKL ================= -->
                    <div class="px-3 pb-1 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Aktivitas Siswa</div>

                    <!-- Dashboard Siswa -->
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-[13px] transition-all {{ request()->routeIs('dashboard') ? 'bg-red-50 text-red-600 font-medium border-l-2 border-red-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium border-l-2 border-transparent' }}">
                        <i data-lucide="layout-dashboard" class="w-4 h-4 shrink-0 {{ request()->routeIs('dashboard') ? 'text-red-600' : 'text-slate-400' }}"></i>
                        <span class="truncate">Dashboard Siswa</span>
                    </a>

                    <!-- Jurnal Kegiatan (Khusus Siswa) -->
                    <a href="{{ route('journals.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-[13px] transition-all {{ request()->routeIs('journals.*') ? 'bg-red-50 text-red-600 font-medium border-l-2 border-red-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium border-l-2 border-transparent' }}">
                        <i data-lucide="book-open" class="w-4 h-4 shrink-0 {{ request()->routeIs('journals.*') ? 'text-red-600' : 'text-slate-400' }}"></i>
                        <span class="truncate">Jurnal Kegiatan</span>
                    </a>

                    <!-- Showcase Portofolio -->
                    <a href="{{ route('showcase.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-[13px] transition-all {{ request()->routeIs('showcase.*') ? 'bg-red-50 text-red-600 font-medium border-l-2 border-red-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium border-l-2 border-transparent' }}">
                        <i data-lucide="folder-git-2" class="w-4 h-4 shrink-0 {{ request()->routeIs('showcase.*') ? 'text-red-600' : 'text-slate-400' }}"></i>
                        <span class="truncate">Arsip Portofolio</span>
                    </a>

                    <!-- Evaluasi & Nilai -->
                    <a href="{{ route('evaluation.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-[13px] transition-all {{ request()->routeIs('evaluation.*') ? 'bg-red-50 text-red-600 font-medium border-l-2 border-red-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium border-l-2 border-transparent' }}">
                        <i data-lucide="award" class="w-4 h-4 shrink-0 {{ request()->routeIs('evaluation.*') ? 'text-red-600' : 'text-slate-400' }}"></i>
                        <span class="truncate">Evaluasi & Nilai</span>
                    </a>

                    <!-- Profil Developer Ala GitHub -->
                    <a href="{{ route('profile') }}" class="flex items-center justify-between px-3 py-2 rounded-xl text-[13px] transition-all {{ request()->routeIs('profile*') ? 'bg-red-50 text-red-600 font-medium border-l-2 border-red-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium border-l-2 border-transparent' }}">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <i data-lucide="user" class="w-4 h-4 shrink-0 {{ request()->routeIs('profile*') ? 'text-red-600' : 'text-slate-400' }}"></i>
                            <span class="truncate">Profil Developer</span>
                        </div>
                        <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-slate-900 text-white font-mono shrink-0">GitHub</span>
                    </a>

                @elseif($role === 'mentor')
                    <!-- ================= MENU KHUSUS MENTOR (MONITORING BATCH SEKARANG) ================= -->
                    <div class="px-3 pb-1 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Area Staff Mentor</div>

                    <!-- Dashboard Monitoring Batch Sekarang -->
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-[13px] transition-all {{ request()->routeIs('dashboard') || request()->routeIs('mentor.dashboard') ? 'bg-red-50 text-red-600 font-medium border-l-2 border-red-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium border-l-2 border-transparent' }}">
                        <i data-lucide="layout-dashboard" class="w-4 h-4 shrink-0 {{ request()->routeIs('dashboard') || request()->routeIs('mentor.dashboard') ? 'text-red-600' : 'text-slate-400' }}"></i>
                        <span class="truncate">Monitoring Batch</span>
                    </a>

                    <!-- Siswa Bimbingan (Inspect & Stats Performa) -->
                    <a href="{{ route('mentor.students') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-[13px] transition-all {{ request()->routeIs('mentor.students*') ? 'bg-red-50 text-red-600 font-medium border-l-2 border-red-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium border-l-2 border-transparent' }}">
                        <i data-lucide="users" class="w-4 h-4 shrink-0 {{ request()->routeIs('mentor.students*') ? 'text-red-600' : 'text-slate-400' }}"></i>
                        <span class="truncate">Siswa Bimbingan</span>
                    </a>

                    <!-- Validasi Jurnal Masuk (Review Hari Ini) -->
                    <a href="{{ route('mentor.review') }}" class="flex items-center justify-between px-3 py-2 rounded-xl text-[13px] transition-all {{ request()->routeIs('mentor.review') ? 'bg-red-50 text-red-600 font-medium border-l-2 border-red-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium border-l-2 border-transparent' }}">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <i data-lucide="check-check" class="w-4 h-4 shrink-0 {{ request()->routeIs('mentor.review') ? 'text-red-600' : 'text-slate-400' }}"></i>
                            <span class="truncate">Validasi Jurnal Masuk</span>
                        </div>
                        <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-red-600 text-white shrink-0">Review</span>
                    </a>

                    <!-- Evaluasi Nilai Siswa Bimbingan -->
                    <a href="{{ route('evaluation.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-[13px] transition-all {{ request()->routeIs('evaluation.*') ? 'bg-red-50 text-red-600 font-medium border-l-2 border-red-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium border-l-2 border-transparent' }}">
                        <i data-lucide="award" class="w-4 h-4 shrink-0 {{ request()->routeIs('evaluation.*') ? 'text-red-600' : 'text-slate-400' }}"></i>
                        <span class="truncate">Penilaian & Rapor Siswa</span>
                    </a>

                    <!-- Showcase Batch Sekarang -->
                    <a href="{{ route('showcase.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-[13px] transition-all {{ request()->routeIs('showcase.*') ? 'bg-red-50 text-red-600 font-medium border-l-2 border-red-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium border-l-2 border-transparent' }}">
                        <i data-lucide="folder-git-2" class="w-4 h-4 shrink-0 {{ request()->routeIs('showcase.*') ? 'text-red-600' : 'text-slate-400' }}"></i>
                        <span class="truncate">Showcase Batch Sekarang</span>
                    </a>

                @elseif($role === 'admin_tms')
                    <!-- ================= MENU KHUSUS ADMIN (MONITORING SEMUA & SEMUA ARSIP) ================= -->
                    <div class="px-3 pb-1 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Area Admin TMS</div>

                    <!-- Monitoring Global & Arsip Master -->
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-[13px] transition-all {{ (request()->routeIs('admin.dashboard') || (request()->routeIs('dashboard') && $role === 'admin_tms')) && !request()->routeIs('admin.students*') && !request()->routeIs('admin.mentors*') ? 'bg-red-50 text-red-600 font-medium border-l-2 border-red-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium border-l-2 border-transparent' }}">
                        <i data-lucide="shield-check" class="w-4 h-4 shrink-0 {{ (request()->routeIs('admin.dashboard') || (request()->routeIs('dashboard') && $role === 'admin_tms')) && !request()->routeIs('admin.students*') && !request()->routeIs('admin.mentors*') ? 'text-red-600' : 'text-slate-400' }}"></i>
                        <span class="truncate">Monitoring Global & Arsip</span>
                    </a>

                    <!-- Data Siswa (Semua Batch) -->
                    <a href="{{ route('admin.students') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-[13px] transition-all {{ request()->routeIs('admin.students*') ? 'bg-red-50 text-red-600 font-medium border-l-2 border-red-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium border-l-2 border-transparent' }}">
                        <i data-lucide="users" class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.students*') ? 'text-red-600' : 'text-slate-400' }}"></i>
                        <span class="truncate">Data Siswa (Semua Batch)</span>
                    </a>

                    <!-- Data Mentor & Staff Pembimbing -->
                    <a href="{{ route('admin.mentors') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-[13px] transition-all {{ request()->routeIs('admin.mentors*') ? 'bg-red-50 text-red-600 font-medium border-l-2 border-red-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium border-l-2 border-transparent' }}">
                        <i data-lucide="user-check" class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.mentors*') ? 'text-red-600' : 'text-slate-400' }}"></i>
                        <span class="truncate">Data Mentor & Staff</span>
                    </a>

                    <!-- Data Angkatan & Project per Angkatan (1 Angkatan > 1 Project) -->
                    <a href="{{ route('admin.batches') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-[13px] transition-all {{ request()->routeIs('admin.batches*') ? 'bg-red-50 text-red-600 font-medium border-l-2 border-red-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium border-l-2 border-transparent' }}">
                        <i data-lucide="folder-git-2" class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.batches*') ? 'text-red-600' : 'text-slate-400' }}"></i>
                        <span class="truncate whitespace-nowrap">Angkatan & Project</span>
                    </a>

                    <!-- Data Asal Instansi: Sekolah & Kampus Mitra -->
                    <a href="{{ route('admin.institutions') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-[13px] transition-all {{ request()->routeIs('admin.institutions*') ? 'bg-red-50 text-red-600 font-medium border-l-2 border-red-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium border-l-2 border-transparent' }}">
                        <i data-lucide="building-2" class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.institutions*') ? 'text-red-600' : 'text-slate-400' }}"></i>
                        <span class="truncate">Sekolah & Kampus Mitra</span>
                    </a>

                    <!-- Master Arsip Portofolio (Semua Angkatan) -->
                    <a href="{{ route('showcase.index') }}" class="flex items-center justify-between px-3 py-2 rounded-xl text-[13px] transition-all {{ request()->routeIs('showcase.*') ? 'bg-red-50 text-red-600 font-medium border-l-2 border-red-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium border-l-2 border-transparent' }}">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <i data-lucide="archive" class="w-4 h-4 shrink-0 {{ request()->routeIs('showcase.*') ? 'text-red-600' : 'text-slate-400' }}"></i>
                            <span class="truncate">Master Arsip Portofolio</span>
                        </div>
                        <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-slate-900 text-white font-mono shrink-0">Semua</span>
                    </a>

                    <!-- Rekapitulasi Nilai & Laporan -->
                    <a href="{{ route('evaluation.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-[13px] transition-all {{ request()->routeIs('evaluation.*') ? 'bg-red-50 text-red-600 font-medium border-l-2 border-red-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium border-l-2 border-transparent' }}">
                        <i data-lucide="file-spreadsheet" class="w-4 h-4 shrink-0 {{ request()->routeIs('evaluation.*') ? 'text-red-600' : 'text-slate-400' }}"></i>
                        <span class="truncate">Rekap Nilai & Laporan DUDI</span>
                    </a>
                @endif

                <!-- Layanan: Panduan & Verifikasi In-Page (Semua Role) -->
                <div class="pt-3 pb-1 px-3">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Layanan</span>
                </div>
                <a href="{{ route('guide.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-[13px] transition-all {{ request()->routeIs('guide.*') ? 'bg-red-50 text-red-600 font-medium border-l-2 border-red-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium border-l-2 border-transparent' }}">
                    <i data-lucide="book-open-check" class="w-4 h-4 shrink-0 {{ request()->routeIs('guide.*') ? 'text-red-600' : 'text-slate-400' }}"></i>
                    <span class="truncate">Panduan & Tutorial</span>
                </a>
                <button type="button" onclick="openVerifyModal()" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-[13px] transition-all text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium border-l-2 border-transparent cursor-pointer text-left">
                    <i data-lucide="shield-check" class="w-4 h-4 text-slate-400 shrink-0"></i>
                    <span class="truncate">Verifikasi Sertifikat</span>
                </button>
            </nav>
        </div>
    </aside>

    <!-- ============================================================== -->
    <!-- 2. MOBILE DRAWER OVERLAY & SIDEBAR (Slide-Over on Mobile)       -->
    <!-- ============================================================== -->
    <div id="mobile-backdrop" class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs z-50 hidden transition-opacity"></div>
    <div id="mobile-drawer" class="fixed inset-y-0 left-0 w-72 bg-white shadow-2xl z-50 flex flex-col justify-between transform -translate-x-full transition-transform duration-300 ease-in-out md:hidden">
        <div>
            <!-- Drawer Brand & Close Button -->
            <div class="h-16 flex items-center justify-between px-5 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-slate-900 to-red-600 flex items-center justify-center text-white shadow-xs">
                        <i data-lucide="layers" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <div class="font-black text-sm text-slate-900">SIMAK-TMS</div>
                        <div class="text-[10px] text-slate-400 font-semibold">PT. Teknologi Multi Sistem</div>
                    </div>
                </div>
                <button id="mobile-drawer-close" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- Mobile Navigation Links (Same logic, role-aware) -->
            <nav class="p-4 space-y-1 overflow-y-auto max-h-[calc(100vh-140px)]">
                @if($role === 'siswa')
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('dashboard') ? 'bg-red-50 text-red-600' : 'text-slate-700' }}">
                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                        <span>Dashboard Siswa</span>
                    </a>
                    <a href="{{ route('journals.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('journals.*') ? 'bg-red-50 text-red-600' : 'text-slate-700' }}">
                        <i data-lucide="book-open" class="w-4 h-4"></i>
                        <span>Jurnal Kegiatan</span>
                    </a>
                    <a href="{{ route('showcase.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('showcase.*') ? 'bg-red-50 text-red-600' : 'text-slate-700' }}">
                        <i data-lucide="folder-git-2" class="w-4 h-4"></i>
                        <span>Arsip Portofolio</span>
                    </a>
                    <a href="{{ route('evaluation.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('evaluation.*') ? 'bg-red-50 text-red-600' : 'text-slate-700' }}">
                        <i data-lucide="award" class="w-4 h-4"></i>
                        <span>Evaluasi & Nilai</span>
                    </a>
                    <a href="{{ route('profile') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('profile*') ? 'bg-red-50 text-red-600' : 'text-slate-700' }}">
                        <i data-lucide="user" class="w-4 h-4"></i>
                        <span>Profil Developer</span>
                    </a>
                @elseif($role === 'mentor')
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('dashboard') || request()->routeIs('mentor.dashboard') ? 'bg-red-50 text-red-600' : 'text-slate-700' }}">
                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                        <span>Monitoring Batch Sekarang</span>
                    </a>
                    <a href="{{ route('mentor.students') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('mentor.students*') ? 'bg-red-50 text-red-600' : 'text-slate-700' }}">
                        <i data-lucide="users" class="w-4 h-4"></i>
                        <span>Siswa Bimbingan</span>
                    </a>
                    <a href="{{ route('mentor.review') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('mentor.review') ? 'bg-red-50 text-red-600' : 'text-slate-700' }}">
                        <i data-lucide="check-check" class="w-4 h-4"></i>
                        <span>Validasi Jurnal Masuk</span>
                    </a>
                    <a href="{{ route('evaluation.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('evaluation.*') ? 'bg-red-50 text-red-600' : 'text-slate-700' }}">
                        <i data-lucide="award" class="w-4 h-4"></i>
                        <span>Penilaian & Rapor</span>
                    </a>
                    <a href="{{ route('showcase.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('showcase.*') ? 'bg-red-50 text-red-600' : 'text-slate-700' }}">
                        <i data-lucide="folder-git-2" class="w-4 h-4"></i>
                        <span>Showcase Batch Sekarang</span>
                    </a>
                @elseif($role === 'admin_tms')
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold {{ (request()->routeIs('admin.dashboard') || (request()->routeIs('dashboard') && $role === 'admin_tms')) && !request()->routeIs('admin.students*') && !request()->routeIs('admin.mentors*') ? 'bg-red-50 text-red-600' : 'text-slate-700' }}">
                        <i data-lucide="shield-check" class="w-4 h-4"></i>
                        <span>Monitoring Global & Arsip</span>
                    </a>
                    <a href="{{ route('admin.students') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('admin.students*') ? 'bg-red-50 text-red-600' : 'text-slate-700' }}">
                        <i data-lucide="users" class="w-4 h-4"></i>
                        <span>Data Siswa (Semua Batch)</span>
                    </a>
                    <a href="{{ route('admin.mentors') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('admin.mentors*') ? 'bg-red-50 text-red-600' : 'text-slate-700' }}">
                        <i data-lucide="user-check" class="w-4 h-4"></i>
                        <span>Data Mentor & Staff</span>
                    </a>
                    <a href="{{ route('admin.batches') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('admin.batches*') ? 'bg-red-50 text-red-600' : 'text-slate-700' }}">
                        <i data-lucide="folder-git-2" class="w-4 h-4"></i>
                        <span>Angkatan & Project</span>
                    </a>
                    <a href="{{ route('admin.institutions') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('admin.institutions*') ? 'bg-red-50 text-red-600' : 'text-slate-700' }}">
                        <i data-lucide="building-2" class="w-4 h-4"></i>
                        <span>Sekolah & Kampus Mitra</span>
                    </a>
                    <a href="{{ route('showcase.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('showcase.*') ? 'bg-red-50 text-red-600' : 'text-slate-700' }}">
                        <i data-lucide="archive" class="w-4 h-4"></i>
                        <span>Master Arsip Portofolio</span>
                    </a>
                    <a href="{{ route('evaluation.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('evaluation.*') ? 'bg-red-50 text-red-600' : 'text-slate-700' }}">
                        <i data-lucide="file-spreadsheet" class="w-4 h-4"></i>
                        <span>Rekap Nilai & Laporan DUDI</span>
                    </a>
                @endif
                <a href="{{ route('guide.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('guide.*') ? 'bg-red-50 text-red-600' : 'text-slate-700' }}">
                    <i data-lucide="book-open-check" class="w-4 h-4"></i>
                    <span>Panduan & Tutorial</span>
                </a>
                <button type="button" onclick="closeDrawer(); openVerifyModal();" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-100 text-left cursor-pointer">
                    <i data-lucide="shield-check" class="w-4 h-4 text-slate-500"></i>
                    <span>Verifikasi Sertifikat</span>
                </button>
            </nav>
        </div>

        <!-- Mobile Drawer Footer -->
        <div class="p-4 border-t border-slate-100">
            @auth
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-slate-900 text-white font-black text-xs flex items-center justify-center">
                            {{ substr(auth()->user()->name, 0, 2) }}
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-900 leading-tight">{{ auth()->user()->name }}</div>
                            <div class="text-[10px] text-red-600 font-bold uppercase">{{ auth()->user()->role }} <span class="text-slate-400 font-mono font-bold">({{ auth()->user()->account_id ?? auth()->user()->username ?? auth()->user()->id }})</span></div>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="p-2 text-slate-400 hover:text-red-600">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- 3. MAIN CONTENT AREA (Offset by fixed sidebar on desktop)      -->
    <!-- ============================================================== -->
    <div class="flex-1 flex flex-col min-w-0 md:pl-64 min-h-screen">

        <!-- Top Header (Hitam - Putih - Merah) -->
        <header class="h-16 bg-white border-b border-slate-200 px-4 sm:px-8 flex items-center justify-between sticky top-0 z-20">
            
            <!-- Mobile Brand & Hamburger Toggle (Kiri Atas Sesuai Standar Aplikasi) -->
            <div class="flex items-center gap-2.5 md:hidden">
                <button type="button" onclick="openMobileDrawer()" class="w-9 h-9 rounded-xl bg-slate-100 hover:bg-slate-200 active:scale-95 text-slate-800 flex items-center justify-center transition-all shrink-0 cursor-pointer" title="Buka Menu Sidebar">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
                <div class="w-8 h-8 rounded-xl bg-slate-900 text-red-500 flex items-center justify-center font-black text-xs shadow-xs shrink-0 aspect-square">
                    TMS
                </div>
                <span class="font-black text-sm text-slate-900 tracking-tight">SIMAK-TMS</span>
            </div>

            <!-- Page Title / Search (Desktop Only) -->
            <div class="hidden sm:flex items-center gap-4 flex-1 max-w-md">
                <div class="relative w-full">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                    <input type="text" placeholder="Cari jurnal, logbook, karya siswa..." class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all">
                </div>
            </div>

            <!-- Right Controls: Profile & Logout -->
            <div class="flex items-center gap-2 sm:gap-3 ml-auto">
                @auth
                    <!-- User Profile Pill (Desktop Saja karena di Mobile Profil sudah di Bottom Nav) -->
                    <a href="{{ route('profile') }}" class="hidden sm:flex items-center gap-2 group hover:opacity-85 transition-opacity" title="Buka Profil Developer">
                        <div class="w-9 h-9 rounded-xl overflow-hidden bg-slate-900 text-white font-extrabold text-xs flex items-center justify-center border-2 border-red-500 shadow-xs flex-shrink-0">
                            @if(auth()->user()->avatar)
                                <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                            @else
                                {{ substr(auth()->user()->name, 0, 2) }}
                            @endif
                        </div>
                        <div class="text-left">
                            <div class="text-xs font-bold text-slate-900 leading-tight uppercase group-hover:text-red-600 transition-colors">{{ auth()->user()->name }}</div>
                            <div class="text-[10px] text-red-600 font-bold uppercase">{{ auth()->user()->role }} <span class="text-slate-400 font-mono font-bold">({{ auth()->user()->account_id ?? auth()->user()->username ?? auth()->user()->id }})</span></div>
                        </div>
                    </a>

                    <!-- Share Profile Button (Desktop) -->
                    <button type="button" onclick="openProfileShareModal()" title="Bagikan Profil & QR Code" class="hidden sm:inline-flex p-1.5 rounded-lg text-slate-500 hover:text-red-600 hover:bg-red-50 transition-colors ml-1 cursor-pointer">
                        <i data-lucide="share-2" class="w-4 h-4"></i>
                    </button>

                    <!-- Logout Button (Desktop) -->
                    <form action="{{ route('logout') }}" method="POST" class="hidden sm:inline">
                        @csrf
                        <button type="submit" title="Keluar" class="p-1.5 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors ml-1 cursor-pointer">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                        </button>
                    </form>

                    <!-- Tombol Share di Pojok Kanan Atas Mobile (Menggantikan Logout Sesuai Permintaan) -->
                    <button type="button" onclick="openProfileShareModal()" title="Bagikan Profil & QR Code" class="sm:hidden p-2 rounded-xl text-slate-600 hover:text-red-600 hover:bg-red-50 transition-colors cursor-pointer">
                        <i data-lucide="share-2" class="w-4 h-4"></i>
                    </button>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-bold transition-all shadow-sm">
                        Masuk
                    </a>
                @endauth
            </div>
        </header>

        <!-- Main Body Content (With comfortable mobile bottom padding for bottom nav) -->
        <main class="flex-1 p-4 sm:p-8 pb-24 md:pb-8 min-w-0">
            @if(session('success'))
                <div class="mb-5 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center justify-between shadow-xs">
                    <span class="flex items-center gap-2">
                        <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600"></i>
                        {{ session('success') }}
                    </span>
                    <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800">&times;</button>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-5 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs font-semibold flex items-center justify-between shadow-xs">
                    <span class="flex items-center gap-2">
                        <i data-lucide="alert-circle" class="w-4 h-4 text-red-600"></i>
                        {{ session('error') }}
                    </span>
                    <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-800">&times;</button>
                </div>
            @endif

            <!-- Warning Banner: Password Masih Default tmshebatsukses -->
            @if(auth()->check() && auth()->user()->must_change_password && in_array(auth()->user()->role, ['siswa', 'mentor']))
                <div class="mb-5 p-4 rounded-2xl bg-gradient-to-r from-amber-50 to-orange-50 border-2 border-amber-300 text-amber-900 text-xs font-medium flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-xs">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center shrink-0 shadow-xs">
                            <i data-lucide="shield-alert" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <span class="font-extrabold text-amber-950 block text-sm">Peringatan Keamanan Akun TMS</span>
                            <span class="text-amber-800 text-xs">Akun Anda saat ini masih memakai kata sandi default (<code class="bg-amber-200/60 text-amber-950 px-1.5 py-0.5 rounded font-mono font-bold">tmshebatsukses</code>). Demi perlindungan karya & jurnal, harap perbarui kata sandi Anda.</span>
                        </div>
                    </div>
                    <button type="button" onclick="openChangePasswordModal()" class="px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-bold transition-all shadow-md shadow-red-600/25 flex items-center gap-1.5 shrink-0 self-start sm:self-auto">
                        <i data-lucide="key" class="w-3.5 h-3.5"></i>
                        <span>Ubah Sandi Baru</span>
                    </button>
                </div>
            @endif

            @yield('content')
        </main>

    </div>

    <!-- ============================================================== -->
    <!-- 4. NATIVE MOBILE BOTTOM NAVIGATION BAR (Fixed at bottom)        -->
    <!-- ============================================================== -->
    <nav class="fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-md border-t border-slate-200 md:hidden shadow-lg px-2 py-1.5 flex items-center justify-around">
        @if($role === 'siswa')
            <!-- Siswa Mobile Bottom Bar -->
            <a href="{{ route('dashboard') }}" class="flex flex-col items-center gap-1 py-1 px-2.5 rounded-xl transition-colors {{ request()->routeIs('dashboard') ? 'text-red-600 font-bold' : 'text-slate-500' }}">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                <span class="text-[10px]">Dasbor</span>
            </a>
            <a href="{{ route('evaluation.index') }}" class="flex flex-col items-center gap-1 py-1 px-2.5 rounded-xl transition-colors {{ request()->routeIs('evaluation.*') ? 'text-red-600 font-bold' : 'text-slate-500' }}">
                <i data-lucide="award" class="w-5 h-5"></i>
                <span class="text-[10px]">Rapor</span>
            </a>
            <a href="{{ route('journals.index') }}" class="flex flex-col items-center gap-1 py-1 px-2.5 rounded-xl transition-colors {{ request()->routeIs('journals.*') ? 'text-red-600 font-bold' : 'text-slate-500' }}">
                <div class="w-8 h-8 rounded-full bg-red-600 text-white flex items-center justify-center -mt-3 shadow-md shadow-red-600/30">
                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                </div>
                <span class="text-[10px] text-red-600 font-bold">Jurnal</span>
            </a>
            <a href="{{ route('showcase.index') }}" class="flex flex-col items-center gap-1 py-1 px-2.5 rounded-xl transition-colors {{ request()->routeIs('showcase.*') ? 'text-red-600 font-bold' : 'text-slate-500' }}">
                <i data-lucide="folder-git-2" class="w-5 h-5"></i>
                <span class="text-[10px]">Karya</span>
            </a>
            <a href="{{ route('profile') }}" class="flex flex-col items-center gap-1 py-1 px-2.5 rounded-xl transition-colors {{ request()->routeIs('profile*') ? 'text-red-600 font-bold' : 'text-slate-500' }}">
                <i data-lucide="user" class="w-5 h-5"></i>
                <span class="text-[10px]">Profil</span>
            </a>
        @elseif($role === 'mentor')
            <!-- Mentor Mobile Bottom Bar -->
            <a href="{{ route('dashboard') }}" class="flex flex-col items-center gap-1 py-1 px-2.5 rounded-xl transition-colors {{ request()->routeIs('dashboard') || request()->routeIs('mentor.dashboard') ? 'text-red-600 font-bold' : 'text-slate-500' }}">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                <span class="text-[10px]">Monitor</span>
            </a>
            <a href="{{ route('mentor.students') }}" class="flex flex-col items-center gap-1 py-1 px-2.5 rounded-xl transition-colors {{ request()->routeIs('mentor.students*') ? 'text-red-600 font-bold' : 'text-slate-500' }}">
                <i data-lucide="users" class="w-5 h-5"></i>
                <span class="text-[10px]">Siswa</span>
            </a>
            <a href="{{ route('mentor.review') }}" class="flex flex-col items-center gap-1 py-1 px-2.5 rounded-xl transition-colors {{ request()->routeIs('mentor.review') ? 'text-red-600 font-bold' : 'text-slate-500' }}">
                <div class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center -mt-3 shadow-md">
                    <i data-lucide="check-check" class="w-4 h-4 text-emerald-400"></i>
                </div>
                <span class="text-[10px] font-bold">Review</span>
            </a>
            <a href="{{ route('evaluation.index') }}" class="flex flex-col items-center gap-1 py-1 px-2.5 rounded-xl transition-colors {{ request()->routeIs('evaluation.*') ? 'text-red-600 font-bold' : 'text-slate-500' }}">
                <i data-lucide="award" class="w-5 h-5"></i>
                <span class="text-[10px]">Rapor</span>
            </a>
            <a href="{{ route('profile') }}" class="flex flex-col items-center gap-1 py-1 px-2.5 rounded-xl transition-colors {{ request()->routeIs('profile*') ? 'text-red-600 font-bold' : 'text-slate-500' }}">
                <i data-lucide="user" class="w-5 h-5"></i>
                <span class="text-[10px]">Profil</span>
            </a>
        @elseif($role === 'admin_tms')
            <!-- Admin Mobile Bottom Bar -->
            <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center gap-1 py-1 px-2 rounded-xl transition-colors {{ (request()->routeIs('admin.dashboard') || (request()->routeIs('dashboard') && $role === 'admin_tms')) && !request()->routeIs('admin.students*') && !request()->routeIs('admin.mentors*') ? 'text-red-600 font-bold' : 'text-slate-500' }}">
                <i data-lucide="shield-check" class="w-5 h-5"></i>
                <span class="text-[10px]">Global</span>
            </a>
            <a href="{{ route('admin.students') }}" class="flex flex-col items-center gap-1 py-1 px-2 rounded-xl transition-colors {{ request()->routeIs('admin.students*') ? 'text-red-600 font-bold' : 'text-slate-500' }}">
                <i data-lucide="users" class="w-5 h-5"></i>
                <span class="text-[10px]">Siswa</span>
            </a>
            <a href="{{ route('admin.mentors') }}" class="flex flex-col items-center gap-1 py-1 px-2 rounded-xl transition-colors {{ request()->routeIs('admin.mentors*') ? 'text-red-600 font-bold' : 'text-slate-500' }}">
                <i data-lucide="user-check" class="w-5 h-5"></i>
                <span class="text-[10px]">Mentor</span>
            </a>
            <a href="{{ route('showcase.index') }}" class="flex flex-col items-center gap-1 py-1 px-2 rounded-xl transition-colors {{ request()->routeIs('showcase.*') ? 'text-red-600 font-bold' : 'text-slate-500' }}">
                <i data-lucide="archive" class="w-5 h-5"></i>
                <span class="text-[10px]">Arsip</span>
            </a>
            <a href="{{ route('profile') }}" class="flex flex-col items-center gap-1 py-1 px-2 rounded-xl transition-colors {{ request()->routeIs('profile*') ? 'text-red-600 font-bold' : 'text-slate-500' }}">
                <i data-lucide="user" class="w-5 h-5"></i>
                <span class="text-[10px]">Profil</span>
            </a>
        @endif
    </nav>

    @php
        $forceOpenChangePassword = auth()->check() 
            && auth()->user()->must_change_password 
            && in_array(auth()->user()->role, ['siswa', 'mentor']);
        $hasPasswordErrors = (isset($errors) && $errors instanceof \Illuminate\Support\ViewErrorBag) ? ($errors->has('current_password') || $errors->has('password')) : false;
        $shouldShowModal = $forceOpenChangePassword || $hasPasswordErrors;
        $isFirstTime = auth()->check() && auth()->user()->must_change_password;
    @endphp

    <!-- ============================================================== -->
    <!-- 4. MODAL GANTI KATA SANDI (POPUP BLUR & STANDAR KEAMANAN)      -->
    <!-- ============================================================== -->
    <div id="modal-change-password" 
         class="fixed inset-0 z-50 bg-slate-950/75 backdrop-blur-md transition-all duration-300 {{ $shouldShowModal ? 'flex' : 'hidden' }}"
         style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; width: 100vw; height: 100vh; z-index: 9999; display: {{ $shouldShowModal ? 'flex' : 'none' }}; align-items: center; justify-content: center; padding: 1rem;">
        
        <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl border border-slate-200/90 p-6 sm:p-7 space-y-4 relative animate-in fade-in zoom-in-95 duration-200"
             style="margin: auto; max-width: 28rem; width: 100%;">
            
            <!-- Modal Header -->
            <div class="flex items-start justify-between border-b border-slate-100 pb-3.5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-slate-900 via-slate-800 to-red-600 text-white flex items-center justify-center shadow-md shadow-red-600/20 border border-red-500/20">
                        <i data-lucide="{{ $isFirstTime ? 'shield-alert' : 'key' }}" class="w-6 h-6 text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-black text-slate-900">
                            {{ $isFirstTime ? 'Aktivasi Akun & Sandi Baru' : 'Ubah Kata Sandi Akun' }}
                        </h3>
                        <p class="text-xs text-slate-400">
                            {{ $isFirstTime ? 'Wajib Mengatur Kata Sandi Pertama Kali' : 'Kelola Keamanan Akses Akun Anda' }}
                        </p>
                    </div>
                </div>
                <button type="button" onclick="closeChangePasswordModal()" class="p-1.5 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-colors" title="Tutup">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- Callout Info -->
            <div class="p-3.5 rounded-2xl {{ $isFirstTime ? 'bg-amber-50/70 border border-amber-200 text-amber-900' : 'bg-slate-50 border border-slate-200 text-slate-600' }} text-xs">
                @if($isFirstTime)
                    <p class="font-bold mb-1 flex items-center gap-1.5 text-amber-800">
                        <i data-lucide="info" class="w-4 h-4 text-amber-600"></i>
                        <span>Halo, {{ auth()->user()->name }}!</span>
                    </p>
                    <p class="text-[11px] leading-relaxed text-amber-800">
                        Akun Anda baru dibuat atau telah direset ke sandi awal (<code class="bg-amber-100 text-amber-950 px-1 py-0.5 rounded font-mono font-bold">tmshebatsukses</code>). Silakan tentukan kata sandi pribadi Anda untuk melanjutkan.
                    </p>
                @else
                    <p class="text-[11px] leading-relaxed text-slate-600">
                        Silakan masukkan kata sandi Anda saat ini untuk verifikasi, lalu masukkan kata sandi baru pilihan Anda.
                    </p>
                @endif
            </div>

            @if($hasPasswordErrors)
                <div class="p-3 rounded-xl bg-red-50 border border-red-200 text-red-600 text-xs font-semibold space-y-1">
                    @if(isset($errors) && $errors->has('current_password'))
                        <div class="flex items-center gap-1.5">
                            <i data-lucide="alert-circle" class="w-4 h-4"></i>
                            <span>{{ $errors->first('current_password') }}</span>
                        </div>
                    @endif
                    @if(isset($errors) && $errors->has('password'))
                        <div class="flex items-center gap-1.5">
                            <i data-lucide="alert-circle" class="w-4 h-4"></i>
                            <span>{{ $errors->first('password') }}</span>
                        </div>
                    @endif
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST" id="form-change-password" class="space-y-3.5">
                @csrf

                <!-- Current Password -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Kata Sandi Saat Ini *</label>
                    <div class="relative">
                        <i data-lucide="lock" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                        <input type="password" id="current_password_input" name="current_password" required 
                               value="{{ $isFirstTime ? 'tmshebatsukses' : '' }}"
                               placeholder="{{ $isFirstTime ? 'tmshebatsukses' : 'Masukkan kata sandi saat ini' }}" 
                               class="w-full pl-10 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 font-mono focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all">
                        <button type="button" onclick="togglePasswordVis('current_password_input', 'eye-curr')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-1">
                            <i data-lucide="eye" id="eye-curr" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <!-- New Password -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Kata Sandi Baru *</label>
                    <div class="relative">
                        <i data-lucide="key-round" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                        <input type="password" id="new_password_input" name="password" required 
                               placeholder="Masukkan kata sandi baru (minimal 6 karakter)" 
                               class="w-full pl-10 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 font-mono focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all">
                        <button type="button" onclick="togglePasswordVis('new_password_input', 'eye-new')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-1">
                            <i data-lucide="eye" id="eye-new" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Konfirmasi Kata Sandi Baru *</label>
                    <div class="relative">
                        <i data-lucide="check" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                        <input type="password" id="confirm_password_input" name="password_confirmation" required 
                               placeholder="Ulangi kata sandi baru" 
                               class="w-full pl-10 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 font-mono focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all">
                        <button type="button" onclick="togglePasswordVis('confirm_password_input', 'eye-conf')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-1">
                            <i data-lucide="eye" id="eye-conf" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <!-- Ketentuan Keamanan Sandi (Live Dynamic Checklist - Format Bebas) -->
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider flex items-center justify-between">
                        <span>Ketentuan Kata Sandi (Format Bebas):</span>
                        <span id="badge-all-valid" class="hidden text-emerald-600 font-bold font-mono text-[10px]">✓ Siap Digunakan</span>
                    </div>
                    <div class="space-y-1.5 text-xs">
                        <div id="rule-len" class="flex items-center gap-2 text-slate-400 font-medium transition-colors">
                            <span id="dot-len" class="w-4 h-4 rounded-full border border-slate-300 flex items-center justify-center text-[10px]">○</span>
                            <span>Minimal <b>6 karakter</b></span>
                        </div>
                        <div id="rule-combo" class="flex items-center gap-2 text-emerald-600 font-medium transition-colors">
                            <span id="dot-combo" class="w-4 h-4 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[10px] font-bold">✓</span>
                            <span>Format bebas (huruf, angka, atau simbol)</span>
                        </div>
                        <div id="rule-match" class="flex items-center gap-2 text-slate-400 font-medium transition-colors">
                            <span id="dot-match" class="w-4 h-4 rounded-full border border-slate-300 flex items-center justify-center text-[10px]">○</span>
                            <span>Konfirmasi kata sandi cocok</span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="pt-2 flex items-center justify-between gap-2 border-t border-slate-100">
                    <button type="button" onclick="closeChangePasswordModal()" class="px-3.5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold rounded-xl transition-colors">
                        {{ $isFirstTime ? 'Nanti Saja (Lewati)' : 'Batal' }}
                    </button>
                    <button type="submit" id="btn-submit-password" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-red-600/25 flex items-center gap-1.5">
                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                        <span>{{ $isFirstTime ? 'Simpan & Aktifkan Sandi' : 'Simpan Kata Sandi' }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if(auth()->check() && auth()->user()->role === 'admin_tms')
        <!-- ============================================================== -->
        <!-- 5. MODAL RESET PASSWORD PENGGUNA (ADMIN TMS ONLY)              -->
        <!-- ============================================================== -->
        <div id="modal-admin-reset-password" 
             class="fixed inset-0 z-50 hidden bg-slate-950/75 backdrop-blur-md transition-all duration-300"
             style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; width: 100vw; height: 100vh; z-index: 9999; display: none; align-items: center; justify-content: center; padding: 1rem;">
            <div class="bg-white rounded-3xl max-w-sm w-full shadow-2xl border border-slate-200 p-6 space-y-4 animate-in fade-in zoom-in-95 duration-200"
                 style="margin: auto; max-width: 24rem; width: 100%;">
                <div class="flex items-center gap-3 border-b border-slate-100 pb-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-200 text-amber-600 flex items-center justify-center shrink-0">
                        <i data-lucide="rotate-ccw" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-slate-900">Reset Kata Sandi Akun</h3>
                        <p class="text-[11px] text-slate-400">Hak Akses Khusus Administrator TMS</p>
                    </div>
                </div>

                <div class="text-xs text-slate-600 space-y-2.5">
                    <p>Anda akan mereset kata sandi akun pengguna berikut ke pengaturan awal:</p>
                    <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl">
                        <div class="font-bold text-slate-900 text-xs" id="reset-user-name">-</div>
                        <div class="text-[11px] text-slate-500 font-mono mt-0.5">ID Akun: <span id="reset-user-id" class="font-bold text-red-600">-</span></div>
                    </div>
                    <div class="p-2.5 rounded-xl bg-amber-50/70 border border-amber-200 text-amber-900 text-[11px] leading-relaxed">
                        Kata sandi akun akan dikembalikan ke default universal:
                        <code class="bg-amber-100 text-amber-950 px-1.5 py-0.5 rounded font-mono font-bold">tmshebatsukses</code>.
                        Pengguna akan langsung diminta membuat kata sandi baru saat masuk kembali.
                    </div>
                </div>

                <form id="form-admin-reset-password" method="POST" action="" class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                    @csrf
                    <button type="button" onclick="closeResetPasswordModal()" class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-amber-600/25 flex items-center gap-1.5">
                        <i data-lucide="check" class="w-3.5 h-3.5"></i>
                        <span>Ya, Reset Sekarang</span>
                    </button>
                </form>
            </div>
        </div>
    @endif

    <!-- ============================================================== -->
    <!-- MODAL VERIFIKASI SERTIFIKAT DIGITAL IN-PAGE (Tanpa Pindah Page)  -->
    <!-- ============================================================== -->
    <div id="verify-cert-modal" class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full border border-slate-200 shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-200">
            <!-- Modal Header -->
            <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-gradient-to-r from-slate-900 to-slate-800 text-white">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-red-600/30 border border-red-500/40 flex items-center justify-center text-red-400">
                        <i data-lucide="shield-check" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-black tracking-tight text-white">Verifikasi Sertifikat Digital PT. TMS</h3>
                        <p class="text-[11px] text-slate-300">Cek keaslian e-sertifikat langsung tanpa meninggalkan halaman aktif</p>
                    </div>
                </div>
                <button type="button" onclick="closeVerifyModal()" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors cursor-pointer" title="Tutup">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-5 space-y-4">
                <!-- Search Input Form -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Nomor Sertifikat / NIS Siswa</label>
                    <div class="flex gap-2">
                        <div class="relative flex-1">
                            <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                            <input type="text" id="modal-cert-query" placeholder="Contoh: TMS-CERT-2026-XI-0001 atau 19364" 
                                   class="w-full pl-9 pr-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all">
                        </div>
                        <button type="button" id="btn-modal-do-verify" onclick="executeModalVerification()" class="px-4 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-bold shadow-xs transition-colors flex items-center gap-1.5 cursor-pointer shrink-0">
                            <i data-lucide="check" class="w-4 h-4"></i>
                            <span>Cek</span>
                        </button>
                    </div>
                    <div class="flex items-center gap-1.5 mt-2 text-[10px] text-slate-400">
                        <span>Contoh Uji:</span>
                        <button type="button" onclick="setModalCertInput('TMS-CERT-2026-XI-0001')" class="underline hover:text-red-600 font-mono">TMS-CERT-2026-XI-0001</button>
                        <span>&bull;</span>
                        <button type="button" onclick="setModalCertInput('19364')" class="underline hover:text-red-600 font-mono">NIS 19364</button>
                    </div>
                </div>

                <!-- Loading Indicator -->
                <div id="modal-verify-loading" class="hidden py-8 text-center space-y-2">
                    <div class="w-8 h-8 border-3 border-red-600 border-t-transparent rounded-full animate-spin mx-auto"></div>
                    <p class="text-xs text-slate-500 font-medium">Memverifikasi basis data sertifikat industri...</p>
                </div>

                <!-- Result Card (Populated Dynamically) -->
                <div id="modal-verify-result" class="hidden"></div>
            </div>

            <!-- Modal Footer -->
            <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="text-slate-400 text-[11px] flex items-center gap-1">
                    <i data-lucide="shield" class="w-3.5 h-3.5 text-emerald-600"></i>
                    <span>Tervalidasi Database Resmi TMS</span>
                </span>
                <button type="button" onclick="closeVerifyModal()" class="px-4 py-1.5 rounded-lg bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 font-semibold transition-colors cursor-pointer">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Vanilla JS for Modal Logic, Live Password Checklist & Mobile Drawer -->
    <script>
        // In-Page Certificate Verification Modal
        function openVerifyModal() {
            const modal = document.getElementById('verify-cert-modal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                const input = document.getElementById('modal-cert-query');
                if (input) {
                    input.focus();
                }
                setTimeout(() => lucide.createIcons(), 50);
            }
        }

        function closeVerifyModal() {
            const modal = document.getElementById('verify-cert-modal');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        function setModalCertInput(code) {
            const input = document.getElementById('modal-cert-query');
            if (input) {
                input.value = code;
                executeModalVerification();
            }
        }

        async function executeModalVerification() {
            const input = document.getElementById('modal-cert-query');
            const loading = document.getElementById('modal-verify-loading');
            const resultBox = document.getElementById('modal-verify-result');
            const query = input ? input.value.trim() : '';

            if (!query) {
                if (input) input.focus();
                return;
            }

            loading.classList.remove('hidden');
            resultBox.classList.add('hidden');
            resultBox.innerHTML = '';

            try {
                const res = await fetch('/api/verify/' + encodeURIComponent(query));
                const data = await res.json();
                loading.classList.add('hidden');
                resultBox.classList.remove('hidden');

                if (res.ok && data.found) {
                    resultBox.innerHTML = `
                        <div class="p-4 rounded-xl border border-emerald-200 bg-emerald-50/70 space-y-3">
                            <div class="flex items-center justify-between pb-2 border-b border-emerald-200">
                                <span class="px-2.5 py-0.5 rounded-full bg-emerald-600 text-white font-bold text-[10px] uppercase tracking-wider flex items-center gap-1">
                                    <i data-lucide="check-circle" class="w-3 h-3"></i> Terverifikasi Asli & Sah
                                </span>
                                <span class="font-mono text-[11px] text-emerald-900 font-bold">${data.certificate_number}</span>
                            </div>
                            <div class="space-y-1.5 text-xs text-slate-700">
                                <div class="flex justify-between"><span class="text-slate-500">Nama Penerima:</span> <b class="text-slate-900">${data.student_name}</b></div>
                                <div class="flex justify-between"><span class="text-slate-500">NIS / NIM:</span> <span class="font-mono font-bold text-slate-800">${data.nis_nim}</span></div>
                                <div class="flex justify-between"><span class="text-slate-500">Asal Instansi:</span> <span class="font-medium">${data.school_origin}</span></div>
                                <div class="flex justify-between"><span class="text-slate-500">Angkatan:</span> <span class="font-medium">${data.batch_name}</span></div>
                                <div class="flex justify-between"><span class="text-slate-500">Predikat / Nilai:</span> <span class="font-bold text-emerald-700">${data.predicate} (${data.final_score})</span></div>
                                <div class="flex justify-between"><span class="text-slate-500">Tanggal Terbit:</span> <span>${data.issue_date}</span></div>
                            </div>
                            <div class="pt-2 border-t border-emerald-200 flex items-center gap-2">
                                <a href="${data.verify_url}" target="_blank" class="flex-1 py-1.5 px-3 rounded-lg bg-slate-900 hover:bg-black text-white text-[11px] font-bold text-center transition-colors flex items-center justify-center gap-1">
                                    <span>Buka Portal Publik</span>
                                    <i data-lucide="external-link" class="w-3 h-3"></i>
                                </a>
                                <a href="${data.print_url}" target="_blank" class="flex-1 py-1.5 px-3 rounded-lg bg-red-600 hover:bg-red-700 text-white text-[11px] font-bold text-center transition-colors flex items-center justify-center gap-1 shadow-2xs">
                                    <i data-lucide="printer" class="w-3 h-3"></i>
                                    <span>Cetak PDF</span>
                                </a>
                            </div>
                        </div>
                    `;
                } else {
                    resultBox.innerHTML = `
                        <div class="p-4 rounded-xl border border-red-200 bg-red-50 text-red-700 text-xs space-y-2">
                            <div class="flex items-center gap-2 font-bold text-red-800">
                                <i data-lucide="alert-triangle" class="w-4 h-4 text-red-600"></i>
                                <span>Sertifikat Tidak Ditemukan!</span>
                            </div>
                            <p class="text-[11px] text-red-600 leading-relaxed">
                                Nomor atau NIS <b>"${query}"</b> tidak terdaftar di database resmi PT. Teknologi Multi Sistem. Pastikan nomor sertifikat diketik dengan benar.
                            </p>
                        </div>
                    `;
                }
                if (window.lucide) lucide.createIcons();
            } catch (err) {
                loading.classList.add('hidden');
                resultBox.classList.remove('hidden');
                resultBox.innerHTML = `
                    <div class="p-3 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs">
                        Terjadi kendala saat memeriksa sertifikat. Silakan periksa koneksi.
                    </div>
                `;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('modal-cert-query');
            if (input) {
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        executeModalVerification();
                    }
                });
            }
        });
        // Modal Change Password Helpers
        function openChangePasswordModal() {
            const modal = document.getElementById('modal-change-password');
            if (modal) {
                modal.style.display = 'flex';
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setTimeout(() => lucide.createIcons(), 50);
            }
        }

        function closeChangePasswordModal() {
            const modal = document.getElementById('modal-change-password');
            if (modal) {
                modal.style.display = 'none';
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        // Modal Admin Reset Password Helpers
        function openResetPasswordModal(userId, name, accountId, role) {
            const modal = document.getElementById('modal-admin-reset-password');
            const form = document.getElementById('form-admin-reset-password');
            const nameEl = document.getElementById('reset-user-name');
            const idEl = document.getElementById('reset-user-id');
            
            if (modal && form) {
                form.action = "{{ url('/admin/users') }}/" + userId + "/reset-password";
                if (nameEl) nameEl.textContent = name;
                if (idEl) idEl.textContent = accountId;
                modal.style.display = 'flex';
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setTimeout(() => lucide.createIcons(), 50);
            }
        }

        function closeResetPasswordModal() {
            const modal = document.getElementById('modal-admin-reset-password');
            if (modal) {
                modal.style.display = 'none';
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        // Toggle Password Visibility Eye
        function togglePasswordVis(inputId, iconId) {
            const inp = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (!inp) return;
            if (inp.type === 'password') {
                inp.type = 'text';
                if (icon) icon.setAttribute('data-lucide', 'eye-off');
            } else {
                inp.type = 'password';
                if (icon) icon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        }

        // Bulletproof Lucide Icons Initializer & Brand Polyfill
        function initIcons() {
            // Brand icons polyfill for Lucide (Lucide latest deprecated brand icons)
            document.querySelectorAll('i[data-lucide="github"]').forEach(el => {
                const w = el.classList.contains('w-4') ? 'w-4 h-4' : (el.classList.contains('w-3') ? 'w-3 h-3' : 'w-3.5 h-3.5');
                const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                svg.setAttribute('viewBox', '0 0 24 24');
                svg.setAttribute('aria-hidden', 'true');
                svg.setAttribute('class', `${w} fill-current shrink-0 ${el.className.replace(/w-\S+|h-\S+/g, '')}`);
                svg.innerHTML = '<path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>';
                el.replaceWith(svg);
            });
            if (window.lucide) {
                lucide.createIcons();
            }
        }
        document.addEventListener('DOMContentLoaded', initIcons);
        window.addEventListener('load', initIcons);
        setTimeout(initIcons, 100);
        setTimeout(initIcons, 500);

        // Live Password Checklist Validation
        document.addEventListener('DOMContentLoaded', function () {
            initIcons();

            const newPassInput = document.getElementById('new_password_input');
            const confPassInput = document.getElementById('confirm_password_input');

            function validatePasswordCriteria() {
                if (!newPassInput) return;
                const val = newPassInput.value || '';
                const conf = confPassInput ? (confPassInput.value || '') : '';

                // 1. Length >= 6
                const isLen = val.length >= 6;
                updateRuleState('rule-len', 'dot-len', isLen);

                // 2. Format Bebas (huruf, angka, atau simbol)
                updateRuleState('rule-combo', 'dot-combo', true);

                // 3. Match
                const isMatch = val.length >= 6 && val === conf;
                updateRuleState('rule-match', 'dot-match', isMatch);

                // Badge All Valid
                const badgeAll = document.getElementById('badge-all-valid');
                if (badgeAll) {
                    if (isLen && isMatch) {
                        badgeAll.classList.remove('hidden');
                    } else {
                        badgeAll.classList.add('hidden');
                    }
                }
            }

            function updateRuleState(ruleId, dotId, isValid) {
                const ruleEl = document.getElementById(ruleId);
                const dotEl = document.getElementById(dotId);
                if (!ruleEl || !dotEl) return;
                if (isValid) {
                    ruleEl.className = 'flex items-center gap-2 text-emerald-600 font-semibold transition-colors';
                    dotEl.className = 'w-4 h-4 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[10px] font-bold';
                    dotEl.innerHTML = '✓';
                } else {
                    ruleEl.className = 'flex items-center gap-2 text-slate-400 font-medium transition-colors';
                    dotEl.className = 'w-4 h-4 rounded-full border border-slate-300 flex items-center justify-center text-[10px]';
                    dotEl.innerHTML = '○';
                }
            }

            if (newPassInput) newPassInput.addEventListener('input', validatePasswordCriteria);
            if (confPassInput) confPassInput.addEventListener('input', validatePasswordCriteria);

            // Mobile Drawer Logic
            window.openMobileDrawer = function() {
                const backdrop = document.getElementById('mobile-backdrop');
                const drawer = document.getElementById('mobile-drawer');
                if (backdrop && drawer) {
                    backdrop.classList.remove('hidden');
                    drawer.classList.remove('-translate-x-full');
                    document.body.classList.add('overflow-hidden');
                    setTimeout(() => lucide.createIcons(), 50);
                }
            };

            window.closeMobileDrawer = function() {
                const backdrop = document.getElementById('mobile-backdrop');
                const drawer = document.getElementById('mobile-drawer');
                if (backdrop && drawer) {
                    backdrop.classList.add('hidden');
                    drawer.classList.add('-translate-x-full');
                    document.body.classList.remove('overflow-hidden');
                }
            };

            const toggleBtn = document.getElementById('mobile-drawer-toggle');
            const closeBtn = document.getElementById('mobile-drawer-close');
            const backdrop = document.getElementById('mobile-backdrop');

            if (toggleBtn) toggleBtn.addEventListener('click', window.openMobileDrawer);
            if (closeBtn) closeBtn.addEventListener('click', window.closeMobileDrawer);
            if (backdrop) backdrop.addEventListener('click', window.closeMobileDrawer);
        });

        function toggleActionDropdown(btn, event) {
            event.stopPropagation();
            const dropdown = btn.nextElementSibling;
            if (!dropdown) return;

            const isCurrentlyHidden = dropdown.classList.contains('hidden');
            
            // Close all open dropdowns first
            closeAllActionDropdowns();

            if (isCurrentlyHidden) {
                // Calculate button bounding rect in viewport
                const rect = btn.getBoundingClientRect();
                const dropdownWidth = 176;

                dropdown.style.position = 'fixed';
                dropdown.style.zIndex = '99999';
                dropdown.style.margin = '0';

                // Horizontal placement (aligned to right of button)
                let left = rect.right - dropdownWidth;
                if (left < 10) left = 10;
                dropdown.style.left = left + 'px';
                dropdown.style.right = 'auto';

                // Vertical placement (check space below vs space above)
                const spaceBelow = window.innerHeight - rect.bottom;
                if (spaceBelow < 220 && rect.top > 220) {
                    dropdown.style.top = 'auto';
                    dropdown.style.bottom = (window.innerHeight - rect.top + 6) + 'px';
                } else {
                    dropdown.style.top = (rect.bottom + 6) + 'px';
                    dropdown.style.bottom = 'auto';
                }

                dropdown.classList.remove('hidden');
                if (window.lucide) {
                    lucide.createIcons();
                }
            }
        }

        function closeAllActionDropdowns() {
            document.querySelectorAll('.action-dropdown').forEach(d => {
                d.classList.add('hidden');
                d.style.position = '';
                d.style.top = '';
                d.style.bottom = '';
                d.style.left = '';
                d.style.right = '';
                d.style.zIndex = '';
            });
        }

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.dropdown-container')) {
                closeAllActionDropdowns();
            }
        });

        window.addEventListener('scroll', closeAllActionDropdowns, { passive: true });
        window.addEventListener('resize', closeAllActionDropdowns);
    </script>

    @auth
    @php
        $authUser = auth()->user();
        $authPublicUrl = route('profile.public', $authUser->account_id ?? $authUser->username ?? $authUser->id);
        $authQrUrl = route('qr.generate', $authUser->account_id ?? $authUser->username ?? $authUser->id);
    @endphp
    <!-- ============================================================== -->
    <!-- MODAL SHARE PROFIL & QR CODE AUTOGENERATE (SIMAK-TMS)          -->
    <!-- ============================================================== -->
    <div id="profileShareModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 hidden transition-opacity">
        <div class="bg-white rounded-3xl max-w-sm w-full p-6 shadow-2xl border border-slate-100 relative space-y-5 animate-in fade-in zoom-in-95 duration-200">
            <!-- Close Button -->
            <button type="button" onclick="closeProfileShareModal()" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center text-lg font-bold cursor-pointer transition-colors">&times;</button>

            <!-- Modal Header -->
            <div class="text-center space-y-1">
                <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center mx-auto mb-2">
                    <i data-lucide="share-2" class="w-6 h-6"></i>
                </div>
                <h3 class="text-base font-black text-slate-900 tracking-tight">Bagikan Profil SIMAK-TMS</h3>
                <p class="text-xs text-slate-500">Tautan & QR Code otentik akun <b>{{ $authUser->name }}</b></p>
            </div>

            <!-- Stylized QR Card Preview (Bisa Diunduh Jadi Gambar) -->
            <div class="bg-gradient-to-b from-slate-900 to-slate-950 p-5 rounded-2xl text-center text-white border-2 border-red-500/20 shadow-lg relative overflow-hidden">
                <div class="text-[10px] font-mono tracking-widest text-slate-400 uppercase mb-2">PT. TEKNOLOGI MULTI SISTEM</div>
                
                <div class="w-40 h-40 bg-white p-2.5 rounded-2xl mx-auto shadow-md border-2 border-slate-100">
                    <img id="layoutModalQrImg" src="{{ $authQrUrl }}" alt="QR Code" class="w-full h-full object-contain">
                </div>

                <div class="mt-3">
                    <div class="text-sm font-black text-white leading-snug">{{ $authUser->name }}</div>
                    <div class="text-[11px] font-mono font-semibold text-red-400 mt-0.5">
                        {{ $authUser->role === 'siswa' ? 'SISWA PKL' : strtoupper($authUser->role) }} • ID: {{ $authUser->account_id ?? $authUser->username ?? $authUser->id }}
                    </div>
                    <div class="text-[10px] text-slate-400 mt-1">Pindai dengan kamera HP untuk melihat profil publik</div>
                </div>
            </div>

            <!-- Copy Link Input -->
            <div class="space-y-1.5">
                <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">Tautan Profil Publik</label>
                <div class="flex items-center gap-2">
                    <input id="layoutPublicLinkInput" type="text" readonly value="{{ $authPublicUrl }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono text-slate-700 select-all focus:outline-none">
                    <button id="layoutBtnCopyLink" type="button" onclick="copyLayoutPublicLink()" class="px-3.5 py-2 rounded-xl bg-slate-900 hover:bg-black text-white text-xs font-bold shrink-0 transition-all cursor-pointer">
                        Salin
                    </button>
                </div>
            </div>

            <!-- Action Buttons: Download QR & Native Share -->
            <div class="space-y-2 pt-2 border-t border-slate-100">
                <button type="button" onclick="downloadQRCodeCard('{{ addslashes($authUser->name) }}', '{{ $authUser->account_id ?? $authUser->username ?? $authUser->id }}', '{{ $authUser->role === 'siswa' ? 'Siswa PKL' : strtoupper($authUser->role) }}', '{{ $authQrUrl }}')" class="w-full py-2.5 px-4 rounded-xl bg-red-600 hover:bg-red-700 active:scale-95 text-white text-xs font-bold transition-all shadow-md shadow-red-600/30 flex items-center justify-center gap-2 cursor-pointer">
                    <i data-lucide="download" class="w-4 h-4"></i>
                    <span>Simpan Gambar QR (Galeri / File)</span>
                </button>

                <button type="button" onclick="shareViaNavigator('{{ addslashes($authUser->name) }}', '{{ $authPublicUrl }}')" class="w-full py-2 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all flex items-center justify-center gap-2 cursor-pointer">
                    <i data-lucide="send" class="w-3.5 h-3.5"></i>
                    <span>Kirim ke WhatsApp / Lainnya</span>
                </button>
            </div>
        </div>
    </div>

    <script>
        function openProfileShareModal() {
            const modal = document.getElementById('profileShareModal');
            if (modal) {
                modal.classList.remove('hidden');
                if (window.lucide) lucide.createIcons();
            }
        }

        function closeProfileShareModal() {
            const modal = document.getElementById('profileShareModal');
            if (modal) modal.classList.add('hidden');
        }

        function copyLayoutPublicLink() {
            const input = document.getElementById('layoutPublicLinkInput');
            const btn = document.getElementById('layoutBtnCopyLink');
            if (!input || !btn) return;
            
            input.select();
            input.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(input.value).then(() => {
                const orig = btn.innerText;
                btn.innerText = 'Tersalin! ✓';
                btn.className = 'px-3.5 py-2 rounded-xl bg-emerald-600 text-white text-xs font-bold shrink-0 transition-all';
                setTimeout(() => {
                    btn.innerText = orig;
                    btn.className = 'px-3.5 py-2 rounded-xl bg-slate-900 hover:bg-black text-white text-xs font-bold shrink-0 transition-all cursor-pointer';
                }, 2000);
            });
        }

        function shareViaNavigator(name, url) {
            if (navigator.share) {
                navigator.share({
                    title: 'Profil SIMAK-TMS • ' + name,
                    text: 'Lihat profil portofolio terverifikasi ' + name + ' di SIMAK-TMS PT. Teknologi Multi Sistem:',
                    url: url
                }).catch(() => {});
            } else {
                copyLayoutPublicLink();
            }
        }

        function downloadQRCodeCard(name, accountId, role, qrUrl) {
            const canvas = document.createElement('canvas');
            canvas.width = 600;
            canvas.height = 760;
            const ctx = canvas.getContext('2d');

            // Draw White Card Background
            ctx.fillStyle = '#ffffff';
            ctx.beginPath();
            ctx.roundRect(0, 0, 600, 760, 28);
            ctx.fill();

            // Header Banner (TMS Dark Slate)
            ctx.fillStyle = '#090d16';
            ctx.beginPath();
            ctx.roundRect(0, 0, 600, 110, [28, 28, 0, 0]);
            ctx.fill();

            // Red Stripe
            ctx.fillStyle = '#ef4444';
            ctx.fillRect(0, 106, 600, 4);

            // Header Text
            ctx.fillStyle = '#ffffff';
            ctx.font = 'bold 20px sans-serif';
            ctx.textAlign = 'center';
            ctx.fillText('PT. TEKNOLOGI MULTI SISTEM', 300, 45);

            ctx.fillStyle = '#94a3b8';
            ctx.font = 'bold 12px sans-serif';
            ctx.fillText('SIMAK-TMS • VERIFIED DEVELOPER PROFILE', 300, 72);

            // Load and draw QR Image
            const img = new Image();
            img.crossOrigin = 'anonymous';
            img.onload = function () {
                // QR Box Background
                ctx.fillStyle = '#f8fafc';
                ctx.strokeStyle = '#e2e8f0';
                ctx.lineWidth = 2;
                ctx.beginPath();
                ctx.roundRect(140, 140, 320, 320, 20);
                ctx.fill();
                ctx.stroke();

                // Draw QR Code
                ctx.drawImage(img, 160, 160, 280, 280);

                // User Name
                ctx.fillStyle = '#0f172a';
                ctx.font = 'bold 24px sans-serif';
                ctx.textAlign = 'center';
                ctx.fillText(name, 300, 505);

                // Role & ID
                ctx.fillStyle = '#ef4444';
                ctx.font = 'bold 15px sans-serif';
                ctx.fillText(role.toUpperCase() + '  •  ID: ' + accountId, 300, 536);

                // Divider Line
                ctx.strokeStyle = '#e2e8f0';
                ctx.lineWidth = 1;
                ctx.beginPath();
                ctx.moveTo(80, 565);
                ctx.lineTo(520, 565);
                ctx.stroke();

                // Authentic Badge
                ctx.fillStyle = '#10b981';
                ctx.font = 'bold 14px sans-serif';
                ctx.fillText('✓ Dokumen Otentik Terverifikasi Sistem', 300, 600);

                // Instruction
                ctx.fillStyle = '#64748b';
                ctx.font = '13px sans-serif';
                ctx.fillText('Arahkan kamera HP ke QR Code ini untuk melihat', 300, 630);
                ctx.fillText('portofolio & rekam aktivitas secara langsung.', 300, 650);

                // Footer
                ctx.fillStyle = '#94a3b8';
                ctx.font = '11px sans-serif';
                ctx.fillText('SIMAK-TMS | https://tms.co.id', 300, 715);

                // Download Action
                const a = document.createElement('a');
                a.download = `QR-Profil-SIMAK-${accountId}-${name.replace(/[^a-zA-Z0-9]/g, '_')}.png`;
                a.href = canvas.toDataURL('image/png');
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            };
            img.src = qrUrl;
        }
    </script>
    @endauth
</body>
</html>