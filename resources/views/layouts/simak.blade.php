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
<body class="min-h-screen flex antialiased bg-slate-50 text-slate-800">

    @php
        $role = auth()->check() ? auth()->user()->role : 'siswa';
    @endphp

    <!-- ============================================================== -->
    <!-- 1. DESKTOP LEFT SIDEBAR (Hitam - Putih - Merah TMS Style)       -->
    <!-- ============================================================== -->
    <aside class="w-64 bg-white border-r border-slate-200 hidden md:flex flex-col justify-between flex-shrink-0 z-30">
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

            <!-- Navigation Links (Role-Aware: Siswa / Mentor / Admin) - Tanpa Anchor Glitch! -->
            <nav class="p-4 space-y-1">

                @if($role === 'siswa')
                    <!-- ================= MENU KHUSUS SISWA PKL ================= -->
                    <div class="px-3 pb-1 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Aktivitas Siswa</div>

                    <!-- Dashboard Siswa -->
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm transition-all {{ request()->routeIs('dashboard') ? 'bg-red-50 text-red-600 font-black border-l-4 border-red-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium' }}">
                        <i data-lucide="layout-dashboard" class="w-4 h-4 {{ request()->routeIs('dashboard') ? 'text-red-600' : 'text-slate-400' }}"></i>
                        <span>Dashboard Siswa</span>
                    </a>

                    <!-- Jurnal Kegiatan (Khusus Siswa) -->
                    <a href="{{ route('journals.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm transition-all {{ request()->routeIs('journals.*') ? 'bg-red-50 text-red-600 font-black border-l-4 border-red-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium' }}">
                        <i data-lucide="book-open" class="w-4 h-4 {{ request()->routeIs('journals.*') ? 'text-red-600' : 'text-slate-400' }}"></i>
                        <span>Jurnal Kegiatan</span>
                    </a>

                    <!-- Showcase Portofolio -->
                    <a href="{{ route('showcase.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm transition-all {{ request()->routeIs('showcase.*') ? 'bg-red-50 text-red-600 font-black border-l-4 border-red-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium' }}">
                        <i data-lucide="folder-git-2" class="w-4 h-4 {{ request()->routeIs('showcase.*') ? 'text-red-600' : 'text-slate-400' }}"></i>
                        <span>Arsip Portofolio</span>
                    </a>

                    <!-- Evaluasi & Nilai -->
                    <a href="{{ route('evaluation.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm transition-all {{ request()->routeIs('evaluation.*') ? 'bg-red-50 text-red-600 font-black border-l-4 border-red-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium' }}">
                        <i data-lucide="award" class="w-4 h-4 {{ request()->routeIs('evaluation.*') ? 'text-red-600' : 'text-slate-400' }}"></i>
                        <span>Evaluasi & Nilai</span>
                    </a>

                    <!-- Profil Developer Ala GitHub -->
                    <a href="{{ route('profile') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm transition-all {{ request()->routeIs('profile*') ? 'bg-red-50 text-red-600 font-black border-l-4 border-red-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium' }}">
                        <div class="flex items-center gap-3">
                            <i data-lucide="user" class="w-4 h-4 {{ request()->routeIs('profile*') ? 'text-red-600' : 'text-slate-400' }}"></i>
                            <span>Profil Developer</span>
                        </div>
                        <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-slate-900 text-white font-mono">GitHub</span>
                    </a>

                @elseif($role === 'mentor')
                    <!-- ================= MENU KHUSUS MENTOR (MONITORING BATCH SEKARANG) ================= -->
                    <div class="px-3 pb-1 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Area Staff Mentor</div>

                    <!-- Dashboard Monitoring Batch Sekarang -->
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm transition-all {{ request()->routeIs('dashboard') || request()->routeIs('mentor.dashboard') ? 'bg-red-50 text-red-600 font-black border-l-4 border-red-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium' }}">
                        <i data-lucide="layout-dashboard" class="w-4 h-4 {{ request()->routeIs('dashboard') || request()->routeIs('mentor.dashboard') ? 'text-red-600' : 'text-slate-400' }}"></i>
                        <span>Monitoring Batch Sekarang</span>
                    </a>

                    <!-- Siswa Bimbingan (Inspect & Stats Performa) -->
                    <a href="{{ route('mentor.students') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm transition-all {{ request()->routeIs('mentor.students*') ? 'bg-red-50 text-red-600 font-black border-l-4 border-red-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium' }}">
                        <i data-lucide="users" class="w-4 h-4 {{ request()->routeIs('mentor.students*') ? 'text-red-600' : 'text-slate-400' }}"></i>
                        <span>Siswa Bimbingan</span>
                    </a>

                    <!-- Validasi Jurnal Masuk (Review Hari Ini) -->
                    <a href="{{ route('mentor.review') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm transition-all {{ request()->routeIs('mentor.review') ? 'bg-red-50 text-red-600 font-black border-l-4 border-red-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium' }}">
                        <div class="flex items-center gap-3">
                            <i data-lucide="check-check" class="w-4 h-4 {{ request()->routeIs('mentor.review') ? 'text-red-600' : 'text-slate-400' }}"></i>
                            <span>Validasi Jurnal Masuk</span>
                        </div>
                        <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-red-600 text-white">Review</span>
                    </a>

                    <!-- Evaluasi Nilai Siswa Bimbingan -->
                    <a href="{{ route('evaluation.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm transition-all {{ request()->routeIs('evaluation.*') ? 'bg-red-50 text-red-600 font-black border-l-4 border-red-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium' }}">
                        <i data-lucide="award" class="w-4 h-4 {{ request()->routeIs('evaluation.*') ? 'text-red-600' : 'text-slate-400' }}"></i>
                        <span>Penilaian & Rapor Siswa</span>
                    </a>

                    <!-- Showcase Batch Sekarang -->
                    <a href="{{ route('showcase.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm transition-all {{ request()->routeIs('showcase.*') ? 'bg-red-50 text-red-600 font-black border-l-4 border-red-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium' }}">
                        <i data-lucide="folder-git-2" class="w-4 h-4 {{ request()->routeIs('showcase.*') ? 'text-red-600' : 'text-slate-400' }}"></i>
                        <span>Showcase Batch Sekarang</span>
                    </a>

                @elseif($role === 'admin_tms')
                    <!-- ================= MENU KHUSUS ADMIN (MONITORING SEMUA & SEMUA ARSIP) ================= -->
                    <div class="px-3 pb-1 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Area Admin TMS</div>

                    <!-- Monitoring Global & Arsip Master (Bersih tanpa Hash Anchor!) -->
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm transition-all {{ (request()->routeIs('admin.dashboard') || (request()->routeIs('dashboard') && $role === 'admin_tms')) && !request()->routeIs('admin.students*') ? 'bg-red-50 text-red-600 font-black border-l-4 border-red-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium' }}">
                        <i data-lucide="shield-check" class="w-4 h-4 {{ (request()->routeIs('admin.dashboard') || (request()->routeIs('dashboard') && $role === 'admin_tms')) && !request()->routeIs('admin.students*') ? 'text-red-600' : 'text-slate-400' }}"></i>
                        <span>Monitoring Global & Arsip</span>
                    </a>

                    <!-- Data Siswa (Semua Batch) -->
                    <a href="{{ route('admin.students') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm transition-all {{ request()->routeIs('admin.students*') ? 'bg-red-50 text-red-600 font-black border-l-4 border-red-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium' }}">
                        <i data-lucide="users" class="w-4 h-4 {{ request()->routeIs('admin.students*') ? 'text-red-600' : 'text-slate-400' }}"></i>
                        <span>Data Siswa (Semua Batch)</span>
                    </a>

                    <!-- Master Arsip Portofolio (Semua Angkatan) -->
                    <a href="{{ route('showcase.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm transition-all {{ request()->routeIs('showcase.*') ? 'bg-red-50 text-red-600 font-black border-l-4 border-red-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium' }}">
                        <div class="flex items-center gap-3">
                            <i data-lucide="archive" class="w-4 h-4 {{ request()->routeIs('showcase.*') ? 'text-red-600' : 'text-slate-400' }}"></i>
                            <span>Master Arsip Portofolio</span>
                        </div>
                        <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-slate-900 text-white font-mono">Semua</span>
                    </a>

                    <!-- Rekapitulasi Nilai & Laporan -->
                    <a href="{{ route('evaluation.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm transition-all {{ request()->routeIs('evaluation.*') ? 'bg-red-50 text-red-600 font-black border-l-4 border-red-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium' }}">
                        <i data-lucide="file-spreadsheet" class="w-4 h-4 {{ request()->routeIs('evaluation.*') ? 'text-red-600' : 'text-slate-400' }}"></i>
                        <span>Rekap Nilai & Laporan DUDI</span>
                    </a>
                @endif

                <!-- Layanan Bantuan & SOP (Semua Role) -->
                <div class="pt-3 pb-1 px-3">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Layanan</span>
                </div>
                <a href="{{ route('informasi') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm transition-all {{ request()->routeIs('informasi') ? 'bg-red-50 text-red-600 font-black border-l-4 border-red-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium' }}">
                    <i data-lucide="help-circle" class="w-4 h-4 {{ request()->routeIs('informasi') ? 'text-red-600' : 'text-slate-400' }}"></i>
                    <span>Pusat Bantuan & SOP</span>
                </a>
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

            <!-- Mobile Role Quick Switcher -->
            <div class="p-4 border-b border-slate-100 bg-slate-50">
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Ganti Peran (Demo):</div>
                <div class="grid grid-cols-3 gap-1.5">
                    <a href="{{ route('login.quick', 'siswa') }}" class="py-1.5 text-center text-[11px] font-bold rounded-lg {{ $role === 'siswa' ? 'bg-red-600 text-white' : 'bg-white border border-slate-200 text-slate-700' }}">Siswa</a>
                    <a href="{{ route('login.quick', 'mentor') }}" class="py-1.5 text-center text-[11px] font-bold rounded-lg {{ $role === 'mentor' ? 'bg-slate-900 text-white' : 'bg-white border border-slate-200 text-slate-700' }}">Mentor</a>
                    <a href="{{ route('login.quick', 'admin_tms') }}" class="py-1.5 text-center text-[11px] font-bold rounded-lg {{ $role === 'admin_tms' ? 'bg-slate-900 text-white' : 'bg-white border border-slate-200 text-slate-700' }}">Admin</a>
                </div>
            </div>

            <!-- Mobile Navigation Links (Same logic, role-aware) -->
            <nav class="p-4 space-y-1 overflow-y-auto max-h-[calc(100vh-220px)]">
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
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold {{ (request()->routeIs('admin.dashboard') || (request()->routeIs('dashboard') && $role === 'admin_tms')) && !request()->routeIs('admin.students*') ? 'bg-red-50 text-red-600' : 'text-slate-700' }}">
                        <i data-lucide="shield-check" class="w-4 h-4"></i>
                        <span>Monitoring Global & Arsip</span>
                    </a>
                    <a href="{{ route('admin.students') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('admin.students*') ? 'bg-red-50 text-red-600' : 'text-slate-700' }}">
                        <i data-lucide="users" class="w-4 h-4"></i>
                        <span>Data Siswa (Semua Batch)</span>
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
                <a href="{{ route('informasi') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('informasi') ? 'bg-red-50 text-red-600' : 'text-slate-700' }}">
                    <i data-lucide="help-circle" class="w-4 h-4"></i>
                    <span>Pusat Bantuan & SOP</span>
                </a>
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
                            <div class="text-[10px] text-red-600 font-bold uppercase">{{ auth()->user()->role }}</div>
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
    <!-- 3. MAIN CONTENT AREA                                           -->
    <!-- ============================================================== -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto min-h-screen">

        <!-- Top Header (Hitam - Putih - Merah) -->
        <header class="h-16 bg-white border-b border-slate-200 px-4 sm:px-8 flex items-center justify-between sticky top-0 z-20">
            
            <!-- Mobile Brand & Hamburger Toggle -->
            <div class="flex items-center gap-2.5 md:hidden">
                <button id="mobile-drawer-toggle" type="button" class="w-9 h-9 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 flex items-center justify-center transition-colors" title="Buka Menu Navigasi">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
                <div class="w-8 h-8 rounded-xl bg-slate-900 text-red-500 flex items-center justify-center font-black text-xs shadow-xs">
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

            <!-- Right Controls: Role Switcher Demo, Notif, Profile & Logout -->
            <div class="flex items-center gap-2 sm:gap-3 ml-auto">
                @auth
                    <!-- Demo Role Switcher (Desktop) -->
                    <div class="hidden lg:flex items-center gap-1 bg-slate-100 p-1 rounded-xl text-xs font-semibold">
                        <span class="text-slate-400 px-1 text-[11px]">Role:</span>
                        <a href="{{ route('login.quick', 'siswa') }}" class="px-2.5 py-0.5 rounded-lg {{ auth()->user()->role === 'siswa' ? 'bg-red-600 text-white shadow-xs font-bold' : 'text-slate-600 hover:text-slate-900' }}">Siswa</a>
                        <a href="{{ route('login.quick', 'mentor') }}" class="px-2.5 py-0.5 rounded-lg {{ auth()->user()->role === 'mentor' ? 'bg-slate-900 text-white shadow-xs font-bold' : 'text-slate-600 hover:text-slate-900' }}">Mentor</a>
                        <a href="{{ route('login.quick', 'admin_tms') }}" class="px-2.5 py-0.5 rounded-lg {{ auth()->user()->role === 'admin_tms' ? 'bg-slate-900 text-white shadow-xs font-bold' : 'text-slate-600 hover:text-slate-900' }}">Admin</a>
                    </div>

                    <!-- Notification Bell -->
                    <button class="w-9 h-9 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-slate-100 transition-colors relative">
                        <i data-lucide="bell" class="w-4 h-4"></i>
                        <span class="w-2 h-2 rounded-full bg-red-600 absolute top-2 right-2"></span>
                    </button>

                    <!-- User Profile Pill -->
                    <a href="{{ route('profile') }}" class="flex items-center gap-2 pl-2 border-l border-slate-200 group hover:opacity-85 transition-opacity" title="Buka Profil Developer">
                        <div class="w-9 h-9 rounded-xl overflow-hidden bg-slate-900 text-white font-extrabold text-xs flex items-center justify-center border-2 border-red-500 shadow-xs flex-shrink-0">
                            @if(auth()->user()->avatar)
                                <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                            @else
                                {{ substr(auth()->user()->name, 0, 2) }}
                            @endif
                        </div>
                        <div class="hidden sm:block text-left">
                            <div class="text-xs font-bold text-slate-900 leading-tight uppercase group-hover:text-red-600 transition-colors">{{ auth()->user()->name }}</div>
                            <div class="text-[10px] text-red-600 font-bold uppercase">{{ auth()->user()->role }}</div>
                        </div>
                    </a>

                    <!-- Logout Button (Desktop) -->
                    <form action="{{ route('logout') }}" method="POST" class="hidden sm:inline">
                        @csrf
                        <button type="submit" title="Keluar" class="p-1.5 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors ml-1">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-bold transition-all shadow-sm">
                        Masuk
                    </a>
                @endauth
            </div>
        </header>

        <!-- Main Body Content (With comfortable mobile bottom padding for bottom nav) -->
        <main class="flex-1 p-4 sm:p-8 pb-24 md:pb-8">
            @if(session('success'))
                <div class="mb-5 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center justify-between shadow-xs">
                    <span class="flex items-center gap-2">
                        <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600"></i>
                        {{ session('success') }}
                    </span>
                    <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800">&times;</button>
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
            <button onclick="document.getElementById('mobile-drawer-toggle').click()" class="flex flex-col items-center gap-1 py-1 px-2.5 rounded-xl text-slate-500">
                <i data-lucide="menu" class="w-5 h-5"></i>
                <span class="text-[10px]">Menu</span>
            </button>
        @elseif($role === 'admin_tms')
            <!-- Admin Mobile Bottom Bar -->
            <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center gap-1 py-1 px-2.5 rounded-xl transition-colors {{ (request()->routeIs('admin.dashboard') || (request()->routeIs('dashboard') && $role === 'admin_tms')) && !request()->routeIs('admin.students*') ? 'text-red-600 font-bold' : 'text-slate-500' }}">
                <i data-lucide="shield-check" class="w-5 h-5"></i>
                <span class="text-[10px]">Global</span>
            </a>
            <a href="{{ route('admin.students') }}" class="flex flex-col items-center gap-1 py-1 px-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.students*') ? 'text-red-600 font-bold' : 'text-slate-500' }}">
                <i data-lucide="users" class="w-5 h-5"></i>
                <span class="text-[10px]">Siswa</span>
            </a>
            <a href="{{ route('showcase.index') }}" class="flex flex-col items-center gap-1 py-1 px-2.5 rounded-xl transition-colors {{ request()->routeIs('showcase.*') ? 'text-red-600 font-bold' : 'text-slate-500' }}">
                <i data-lucide="archive" class="w-5 h-5"></i>
                <span class="text-[10px]">Arsip</span>
            </a>
            <a href="{{ route('evaluation.index') }}" class="flex flex-col items-center gap-1 py-1 px-2.5 rounded-xl transition-colors {{ request()->routeIs('evaluation.*') ? 'text-red-600 font-bold' : 'text-slate-500' }}">
                <i data-lucide="file-spreadsheet" class="w-5 h-5"></i>
                <span class="text-[10px]">Nilai</span>
            </a>
            <button onclick="document.getElementById('mobile-drawer-toggle').click()" class="flex flex-col items-center gap-1 py-1 px-2.5 rounded-xl text-slate-500">
                <i data-lucide="menu" class="w-5 h-5"></i>
                <span class="text-[10px]">Menu</span>
            </button>
        @endif
    </nav>

    <!-- Vanilla JS for Mobile Drawer Toggle & Lucide Initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize Lucide Icons
            lucide.createIcons();

            // Mobile Drawer Logic
            const toggleBtn = document.getElementById('mobile-drawer-toggle');
            const closeBtn = document.getElementById('mobile-drawer-close');
            const backdrop = document.getElementById('mobile-backdrop');
            const drawer = document.getElementById('mobile-drawer');

            function openDrawer() {
                if (backdrop && drawer) {
                    backdrop.classList.remove('hidden');
                    drawer.classList.remove('-translate-x-full');
                    document.body.classList.add('overflow-hidden');
                }
            }

            function closeDrawer() {
                if (backdrop && drawer) {
                    backdrop.classList.add('hidden');
                    drawer.classList.add('-translate-x-full');
                    document.body.classList.remove('overflow-hidden');
                }
            }

            if (toggleBtn) toggleBtn.addEventListener('click', openDrawer);
            if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
            if (backdrop) backdrop.addEventListener('click', closeDrawer);

            // Re-render icons on drawer open
            if (toggleBtn) {
                toggleBtn.addEventListener('click', function () {
                    setTimeout(() => lucide.createIcons(), 50);
                });
            }
        });
    </script>
</body>
</html>