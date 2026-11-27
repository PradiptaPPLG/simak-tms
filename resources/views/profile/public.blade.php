<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Developer • {{ $user->name }} • SIMAK-TMS</title>
    
    <!-- Favicon (SIMAK Icon) -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo/simak-icon-64.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo/simak-icon-128.png') }}">

    <!-- Google Fonts: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                        mono: ['JetBrains Mono', 'ui-monospace', 'monospace']
                    },
                    colors: {
                        tms: {
                            dark: '#090d16',
                            card: '#0f172a',
                            red: '#ef4444'
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }
        .mas-card {
            background: #ffffff;
            border-radius: 1.25rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03), 0 2px 4px -2px rgba(0, 0, 0, 0.03);
            transition: all 0.2s ease;
        }
        .mas-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -4px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col bg-slate-50 antialiased selection:bg-red-500 selection:text-white">

    <!-- Top Public Navigation Bar -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ route('login') }}" class="flex items-center gap-2.5 group">
                <img src="{{ asset('images/logo/simak-icon.png') }}" alt="SIMAK Logo" class="w-9 h-9 rounded-xl shadow-xs shrink-0 object-contain">
                <div class="leading-none">
                    <div class="text-sm font-black text-slate-900 tracking-tight flex items-center gap-1.5">
                        <span>SIMAK-TMS</span>
                        <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Verified</span>
                    </div>
                    <span class="text-[10px] text-slate-400 font-medium">PT. Teknologi Multi Sistem</span>
                </div>
            </a>

            <!-- Right Public Actions -->
            <div class="flex items-center gap-2 sm:gap-3">
                <!-- Tombol Bagikan Profil -->
                <button type="button" onclick="openProfileShareModal()" class="px-3 sm:px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all flex items-center gap-1.5 cursor-pointer">
                    <i data-lucide="share-2" class="w-4 h-4 text-red-600"></i>
                    <span class="hidden sm:inline">Bagikan Profil</span>
                </button>

                @auth
                    @if($isOwner)
                        <a href="{{ route('profile') }}" class="px-3 sm:px-4 py-2 rounded-xl bg-slate-900 hover:bg-black text-white text-xs font-bold transition-all flex items-center gap-1.5 shadow-xs">
                            <i data-lucide="edit-3" class="w-4 h-4 text-red-400"></i>
                            <span>Edit Profil Saya</span>
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="px-3 sm:px-4 py-2 rounded-xl bg-slate-900 hover:bg-black text-white text-xs font-bold transition-all flex items-center gap-1.5 shadow-xs">
                            <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                            <span class="hidden sm:inline">Dasbor Saya</span>
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="px-3 sm:px-4 py-2 rounded-xl bg-slate-900 hover:bg-black text-white text-xs font-bold transition-all flex items-center gap-1.5 shadow-xs">
                        <i data-lucide="log-in" class="w-4 h-4"></i>
                        <span>Masuk Sistem</span>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="max-w-6xl mx-auto px-4 sm:px-6 py-8 flex-1 w-full space-y-8">

        <!-- Top Verified Profile Card -->
        <div class="mas-card p-6 sm:p-8 relative overflow-hidden">
            <!-- Top Gradient Accent Line -->
            <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-slate-900 via-red-600 to-red-500"></div>

            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <!-- Left: Avatar, Name, Role & Badges -->
                <div class="flex flex-col sm:flex-row items-center sm:items-start md:items-center gap-5 text-center sm:text-left">
                    <div class="relative w-28 h-28 sm:w-32 sm:h-32 shrink-0">
                        <div class="w-full h-full rounded-2xl overflow-hidden bg-slate-900 border-4 border-white shadow-lg flex items-center justify-center">
                            @if($user->avatar)
                                <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-3xl font-black text-white font-mono">{{ substr($user->name, 0, 2) }}</span>
                            @endif
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-7 h-7 rounded-full bg-emerald-500 text-white border-2 border-white flex items-center justify-center shadow-sm" title="Terverifikasi Resmi">
                            <i data-lucide="check" class="w-4 h-4 stroke-[3]"></i>
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
                            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">{{ $user->name }}</h1>
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold">
                                <i data-lucide="shield-check" class="w-3.5 h-3.5 text-emerald-600"></i>
                                Otentik
                            </span>
                        </div>

                        <div class="text-xs font-mono font-semibold text-slate-500 flex flex-wrap items-center justify-center sm:justify-start gap-2">
                            <button type="button" 
                                    onclick="copyIdBadge('{{ $user->account_id }}', this)" 
                                    title="Klik untuk menyalin ID ({{ $user->account_id }})" 
                                    class="inline-flex items-center gap-1.5 bg-slate-100 hover:bg-slate-200 active:scale-95 text-slate-800 px-2.5 py-0.5 rounded-lg border border-slate-200 text-xs font-mono font-bold transition-all cursor-pointer group shadow-2xs">
                                <span>ID: {{ $user->account_id ?? '-' }}</span>
                                <svg class="w-3 h-3 text-slate-400 group-hover:text-slate-700 transition-colors shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                </svg>
                            </button>
                            @php
                                $displayHandle = (!empty($user->username) && !is_numeric($user->username) && $user->username !== $user->account_id)
                                    ? $user->username
                                    : strtolower(preg_replace('/[^a-zA-Z0-9]/', '', explode(' ', trim($user->name))[0] ?? 'dev'));
                            @endphp
                            <span>•</span>
                            <span class="text-slate-600 font-semibold">&#64;{{ $displayHandle }}</span>
                            <span>•</span>
                            @if($user->status === 'alumni')
                                <span class="px-2.5 py-0.5 rounded-full bg-indigo-50 text-indigo-700 font-bold border border-indigo-200 uppercase text-[10px] inline-flex items-center gap-1">
                                    <i data-lucide="graduation-cap" class="w-3 h-3 text-indigo-600"></i> Alumni Magang
                                </span>
                            @else
                                <span class="px-2 py-0.5 rounded-full bg-red-50 text-red-600 font-bold border border-red-200 uppercase text-[10px]">
                                    {{ $user->role === 'siswa' ? 'Siswa PKL' : strtoupper($user->role) }}
                                </span>
                            @endif
                        </div>

                        <p class="text-xs sm:text-sm text-slate-700 font-medium max-w-xl">
                            {{ $user->headline ?? 'Junior Full-Stack Web Developer & Intern @ PT. Teknologi Multi Sistem' }}
                        </p>

                        <!-- Organization & Education details -->
                        <div class="pt-2 flex flex-wrap items-center justify-center sm:justify-start gap-3 sm:gap-4 text-xs text-slate-600">
                            <div class="flex items-center gap-1.5">
                                <i data-lucide="building-2" class="w-4 h-4 text-slate-400"></i>
                                <span>PT. Teknologi Multi Sistem</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <i data-lucide="graduation-cap" class="w-4 h-4 text-slate-400"></i>
                                <span>{{ $user->school_origin }} • {{ $user->major }}</span>
                            </div>
                            @if($user->mentor)
                                <div class="flex items-center gap-1.5">
                                    <i data-lucide="briefcase" class="w-4 h-4 text-red-500"></i>
                                    <span class="font-semibold text-red-700">Divisi {{ $user->mentor->location ?? 'IT / Software Engineering' }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right: QR Code Snippet & Share CTA -->
                <div class="flex flex-col items-center sm:items-end w-full md:w-auto shrink-0 border-t md:border-t-0 pt-4 md:pt-0 border-slate-100">
                    <div class="bg-slate-50 p-2.5 rounded-2xl border border-slate-200 shadow-xs flex items-center gap-3">
                        <div class="w-16 h-16 bg-white p-1 rounded-xl border border-slate-200 shrink-0">
                            <img src="{{ $qrCodeUrl }}" alt="QR Code Profil" class="w-full h-full object-contain">
                        </div>
                        <div class="text-left space-y-1">
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">QR Code Publik</div>
                            <div class="text-xs font-bold text-slate-900">Validasi Otentik</div>
                            <button type="button" onclick="openProfileShareModal()" class="text-xs text-red-600 font-bold hover:underline flex items-center gap-1 cursor-pointer">
                                <span>Bagikan & Unduh</span>
                                <i data-lucide="arrow-right" class="w-3 h-3"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bio Quote -->
            @if($user->bio)
                <div class="mt-6 pt-6 border-t border-slate-100">
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed italic bg-slate-50 p-4 rounded-xl border border-slate-100">
                        "{{ $user->bio }}"
                    </p>
                </div>
            @endif

            <!-- Social Links Row -->
            <div class="mt-5 flex flex-wrap items-center gap-2.5 pt-4 border-t border-slate-100">
                @if($user->github_url)
                    <a href="{{ $user->github_url }}" target="_blank" rel="noopener noreferrer" class="px-3 py-1.5 rounded-xl bg-slate-900 hover:bg-black text-white text-xs font-semibold flex items-center gap-2 transition-all">
                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/></svg>
                        <span>GitHub</span>
                    </a>
                @endif

                @if($user->linkedin_url)
                    <a href="{{ $user->linkedin_url }}" target="_blank" rel="noopener noreferrer" class="px-3 py-1.5 rounded-xl bg-[#0077b5] hover:bg-[#006097] text-white text-xs font-semibold flex items-center gap-2 transition-all">
                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.46 8.76c.98 0 1.77-.8 1.77-1.78a1.77 1.77 0 0 0-3.54 0c0 .98.79 1.78 1.77 1.78M7.86 18.5v-8.37H5.07v8.37h2.79z"/></svg>
                        <span>LinkedIn</span>
                    </a>
                @endif

                @if($user->instagram_url)
                    <a href="{{ $user->instagram_url }}" target="_blank" rel="noopener noreferrer" class="px-3 py-1.5 rounded-xl bg-pink-50 hover:bg-pink-100 text-pink-700 border border-pink-200 text-xs font-semibold flex items-center gap-2 transition-all">
                        <svg class="w-3.5 h-3.5 fill-[#E4405F] shrink-0" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        <span>Instagram</span>
                    </a>
                @endif

                @if($user->website_url)
                    <a href="{{ $user->website_url }}" target="_blank" rel="noopener noreferrer" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-semibold flex items-center gap-2 transition-all">
                        <i data-lucide="globe" class="w-3.5 h-3.5 text-emerald-600"></i>
                        <span>Website Portofolio</span>
                    </a>
                @endif
            </div>
        </div>

        <!-- Metric Telemetry Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="mas-card p-4 text-center">
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Portofolio Digital</div>
                <div class="text-2xl font-black text-slate-900 font-mono mt-1">{{ $totalProjects }} <span class="text-xs font-normal text-slate-500">Proyek</span></div>
            </div>
            <div class="mas-card p-4 text-center">
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Jurnal Harian</div>
                <div class="text-2xl font-black text-slate-900 font-mono mt-1">{{ $totalJournals }} <span class="text-xs font-normal text-slate-500">Logbook</span></div>
            </div>
            @if($evaluation && $evaluation->is_published)
                <div class="mas-card p-4 text-center">
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nilai Evaluasi</div>
                    <div class="text-2xl font-black text-emerald-600 font-mono mt-1">{{ $evaluation->final_score }} <span class="text-xs font-bold text-slate-800">[ {{ $evaluation->final_score >= 85 ? 'A' : ($evaluation->final_score >= 75 ? 'B' : 'C') }} ]</span></div>
                </div>
                <div class="mas-card p-4 text-center">
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Status DUDI</div>
                    <div class="text-2xl font-black text-slate-900 font-mono mt-1">100% <span class="text-xs font-normal text-emerald-600 font-bold">Lulus</span></div>
                </div>
            @else
                <div class="mas-card p-4 text-center">
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nilai Evaluasi</div>
                    <div class="text-lg font-black text-amber-600 mt-2 font-mono">Masa Magang</div>
                </div>
                <div class="mas-card p-4 text-center">
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Status DUDI</div>
                    @if($user->status === 'alumni')
                        <div class="text-sm font-black text-indigo-700 mt-2 font-mono">
                            <span class="text-xs font-bold text-indigo-700 bg-indigo-50 px-2.5 py-1 rounded-full border border-indigo-200">Alumni (Lulus PKL)</span>
                        </div>
                    @else
                        <div class="text-lg font-black text-slate-900 mt-2"><span class="text-xs font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">Aktif Magang</span></div>
                    @endif
                </div>
            @endif
        </div>

        <!-- E-Sertifikat Kelulusan Resmi DUDI (Jika Sudah Diterbitkan) -->
        @if($evaluation && $evaluation->is_published)
            <div class="mas-card p-6 bg-gradient-to-r from-slate-900 via-slate-950 to-slate-900 text-white relative overflow-hidden border-2 border-amber-400/30 shadow-xl">
                <!-- Top Accent Line -->
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-red-600 via-amber-400 to-red-500"></div>

                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="space-y-3">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 text-[11px] font-bold uppercase tracking-wider">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            E-Sertifikat DUDI Resmi Terverifikasi Sistem
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-white">Sertifikat Praktik Kerja Lapangan (PKL)</h3>
                            <p class="text-xs text-slate-400 mt-0.5">Diterbitkan oleh <b>PT. Teknologi Multi Sistem</b> • Periode Resmi Batch {{ $user->batch->name ?? '2026' }}</p>
                        </div>
                        <div class="flex flex-wrap items-center gap-3 text-xs font-mono">
                            <div class="bg-slate-800/80 px-3 py-1.5 rounded-xl border border-slate-700">
                                <span class="text-slate-400 text-[10px] uppercase block">No. Sertifikat:</span>
                                <span class="font-bold text-amber-400 font-mono">{{ $evaluation->certificate_number }}</span>
                            </div>
                            <div class="bg-slate-800/80 px-3 py-1.5 rounded-xl border border-slate-700">
                                <span class="text-slate-400 text-[10px] uppercase block">Tanggal Terbit:</span>
                                <span class="font-bold text-slate-200">{{ \Carbon\Carbon::parse($evaluation->issue_date ?? now())->locale('id')->isoFormat('D MMMM Y') }}</span>
                            </div>
                        </div>

                        <!-- 4 Pilar Mini Transcript -->
                        <div class="grid grid-cols-4 gap-2 pt-1 max-w-md">
                            <div class="bg-slate-800/50 p-2 rounded-xl border border-slate-700/60 text-center">
                                <span class="text-[9px] uppercase text-slate-400 block font-semibold">Teknis</span>
                                <span class="text-xs font-bold text-white font-mono">{{ $evaluation->technical_skill }}</span>
                            </div>
                            <div class="bg-slate-800/50 p-2 rounded-xl border border-slate-700/60 text-center">
                                <span class="text-[9px] uppercase text-slate-400 block font-semibold">Disiplin</span>
                                <span class="text-xs font-bold text-white font-mono">{{ $evaluation->discipline }}</span>
                            </div>
                            <div class="bg-slate-800/50 p-2 rounded-xl border border-slate-700/60 text-center">
                                <span class="text-[9px] uppercase text-slate-400 block font-semibold">Kerjasama</span>
                                <span class="text-xs font-bold text-white font-mono">{{ $evaluation->teamwork }}</span>
                            </div>
                            <div class="bg-slate-800/50 p-2 rounded-xl border border-slate-700/60 text-center">
                                <span class="text-[9px] uppercase text-slate-400 block font-semibold">Inisiatif</span>
                                <span class="text-xs font-bold text-white font-mono">{{ $evaluation->initiative }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col items-center sm:items-end gap-3 shrink-0 w-full md:w-auto">
                        <div class="bg-white/10 backdrop-blur-md px-5 py-3 rounded-2xl border border-white/10 text-center w-full sm:w-auto">
                            <div class="text-[10px] uppercase font-bold text-slate-300">Skor Kelulusan Akhir</div>
                            <div class="text-3xl font-black text-amber-400 font-mono">{{ $evaluation->final_score }}</div>
                            <div class="text-[11px] text-emerald-400 font-bold uppercase tracking-wider">
                                Predikat {{ $evaluation->final_score >= 85 ? 'A (Sangat Memuaskan)' : ($evaluation->final_score >= 75 ? 'B (Memuaskan)' : 'C (Cukup)') }}
                            </div>
                        </div>

                        <a href="{{ route('certificate.print', $evaluation->certificate_number) }}" target="_blank" class="w-full sm:w-auto py-2.5 px-5 rounded-xl bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white text-xs font-bold transition-all shadow-md shadow-red-600/30 flex items-center justify-center gap-2">
                            <i data-lucide="printer" class="w-4 h-4 text-amber-300"></i>
                            <span>Buka & Cetak E-Sertifikat (PDF)</span>
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Skills & Tech Stacks -->
        @if($user->skills)
            <div class="mas-card p-6">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Penguasaan Teknologi & Tech Stack</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach(explode(',', $user->skills) as $skill)
                        @if(trim($skill))
                            <span class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-red-50 hover:text-red-600 hover:border-red-200 border border-slate-200 text-xs font-mono font-semibold text-slate-800 transition-colors">
                                {{ trim($skill) }}
                            </span>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Showcase Portofolio Projects -->
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-black text-slate-900 tracking-tight">Karya & Portofolio Proyek Industri</h2>
                    <p class="text-xs text-slate-500">Aplikasi dan karya digital yang telah dibangun selama masa PKL di PT. Teknologi Multi Sistem.</p>
                </div>
                <span class="px-2.5 py-1 rounded-lg bg-red-50 text-red-600 text-xs font-bold font-mono">
                    {{ $projects->count() }} Proyek
                </span>
            </div>

            @if($projects->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($projects as $p)
                        <div class="mas-card p-5 flex flex-col justify-between space-y-4">
                            <div>
                                <div class="flex items-start justify-between gap-2">
                                    <h4 class="text-sm font-bold text-slate-900 leading-snug">{{ $p->title }}</h4>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-600 shrink-0">
                                        {{ $p->project_category ?? ($p->category ?? 'Web Application') }}
                                    </span>
                                </div>
                                <p class="text-xs text-slate-600 mt-2 line-clamp-3 leading-relaxed">
                                    {{ $p->short_description ?? ($p->full_description ?? ($p->description ?? '')) }}
                                </p>
                            </div>

                            @if($p->tech_stack)
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach(explode(',', $p->tech_stack) as $t)
                                        <span class="px-2 py-0.5 rounded bg-slate-50 border border-slate-100 text-[10px] font-mono text-slate-600">
                                            {{ trim($t) }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-bold">
                                @if($p->repo_url)
                                    <a href="{{ $p->repo_url }}" target="_blank" rel="noopener noreferrer" class="text-slate-700 hover:text-black flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 fill-current shrink-0" viewBox="0 0 24 24"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/></svg>
                                        <span>Repository</span>
                                    </a>
                                @else
                                    <span class="text-slate-400 text-[11px]">Private Repo</span>
                                @endif

                                @if(filled($p->live_url) || filled($p->demo_url))
                                    <a href="{{ filled($p->live_url) ? $p->live_url : $p->demo_url }}" target="_blank" rel="noopener noreferrer" class="px-3 py-1 rounded-lg bg-red-600 hover:bg-red-700 text-white flex items-center gap-1.5 shadow-xs transition-all">
                                        <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                                        <span>Link Live/Demo</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="mas-card p-8 text-center text-slate-400 space-y-2">
                    <i data-lucide="folder-code" class="w-8 h-8 mx-auto text-slate-300"></i>
                    <p class="text-xs font-medium">Belum ada portofolio proyek publik yang dipublikasikan.</p>
                </div>
            @endif
        </div>

        <!-- Bottom Official Authenticity Card -->
        <div class="mas-card p-6 bg-slate-900 text-white relative overflow-hidden border border-slate-800">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-20 h-20 bg-white p-1.5 rounded-2xl shrink-0 shadow-lg">
                        <img src="{{ $qrCodeUrl }}" alt="QR Code" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <div class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 text-[10px] font-bold border border-emerald-500/30 uppercase">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            Sistem Verifikasi QR Otentik
                        </div>
                        <h4 class="text-base font-black text-white mt-1">SIMAK-TMS Digital Certificate & Portfolio</h4>
                        <p class="text-xs text-slate-400 max-w-md mt-0.5">
                            Pindai QR code ini untuk membuktikan orisinalitas profil dan sertifikasi magang pada database resmi PT. Teknologi Multi Sistem.
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                    <button type="button" onclick="openProfileShareModal()" class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-bold transition-all shadow-md shadow-red-600/30 flex items-center justify-center gap-2 cursor-pointer">
                        <i data-lucide="share-2" class="w-4 h-4"></i>
                        <span>Bagikan / Unduh QR</span>
                    </button>
                </div>
            </div>
        </div>

    </main>

    <!-- Public Footer -->
    <footer class="mt-auto border-t border-slate-200 bg-white py-6 text-center text-xs text-slate-400">
        <p>Hak Cipta &copy; 2026 PT. Teknologi Multi Sistem. Sistem Informasi Manajemen Aktivitas & Karya Siswa PKL (SIMAK-TMS).</p>
    </footer>

    <!-- ============================================================== -->
    <!-- SHARE PROFILE & QR CODE MODAL                                  -->
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
                <p class="text-xs text-slate-500">Tautan & QR Code otentik akun <b>{{ $user->name }}</b></p>
            </div>

            <!-- Stylized QR Card Preview (To Download) -->
            <div id="qrCardVisual" class="bg-gradient-to-b from-slate-900 to-slate-950 p-5 rounded-2xl text-center text-white border-2 border-red-500/20 shadow-lg relative overflow-hidden">
                <div class="text-[10px] font-mono tracking-widest text-slate-400 uppercase mb-2">PT. TEKNOLOGI MULTI SISTEM</div>
                
                <div class="w-40 h-40 bg-white p-2.5 rounded-2xl mx-auto shadow-md border-2 border-slate-100">
                    <img id="modalQrImage" src="{{ $qrCodeUrl }}" alt="QR Code" class="w-full h-full object-contain">
                </div>

                <div class="mt-3">
                    <div class="text-sm font-black text-white leading-snug">{{ $user->name }}</div>
                    <div class="text-[11px] font-mono font-semibold text-red-400 mt-0.5">
                        {{ $user->role === 'siswa' ? 'SISWA PKL' : strtoupper($user->role) }} • ID: {{ $user->account_id ?? $user->username ?? $user->id }}
                    </div>
                    <div class="text-[10px] text-slate-400 mt-1">Pindai dengan kamera untuk membuka profil resmi</div>
                </div>
            </div>

            <!-- Copy Link Input -->
            <div class="space-y-1.5">
                <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">Tautan Publik Profil</label>
                <div class="flex items-center gap-2">
                    <input id="publicLinkInput" type="text" readonly value="{{ $publicUrl }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono text-slate-700 select-all focus:outline-none">
                    <button id="btnCopyLink" type="button" onclick="copyPublicLink()" class="px-3.5 py-2 rounded-xl bg-slate-900 hover:bg-black text-white text-xs font-bold shrink-0 transition-all cursor-pointer">
                        Salin
                    </button>
                </div>
            </div>

            <!-- Action Buttons: Download QR & Native Share -->
            <div class="space-y-2 pt-2 border-t border-slate-100">
                <button type="button" onclick="downloadQRCodeCard('{{ addslashes($user->name) }}', '{{ $user->account_id ?? $user->username ?? $user->id }}', '{{ $user->role === 'siswa' ? 'Siswa PKL' : strtoupper($user->role) }}', '{{ $qrCodeUrl }}')" class="w-full py-2.5 px-4 rounded-xl bg-red-600 hover:bg-red-700 active:scale-95 text-white text-xs font-bold transition-all shadow-md shadow-red-600/30 flex items-center justify-center gap-2 cursor-pointer">
                    <i data-lucide="download" class="w-4 h-4"></i>
                    <span>Simpan Gambar QR (Galeri / File)</span>
                </button>

                <button type="button" onclick="shareViaNavigator('{{ addslashes($user->name) }}', '{{ $publicUrl }}')" class="w-full py-2 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all flex items-center justify-center gap-2 cursor-pointer">
                    <i data-lucide="send" class="w-3.5 h-3.5"></i>
                    <span>Kirim ke WhatsApp / Aplikasi Lain</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Scripts for QR & Share -->
    <script>
        function openProfileShareModal() {
            const modal = document.getElementById('profileShareModal');
            if (modal) {
                modal.classList.remove('hidden');
                lucide.createIcons();
            }
        }

        function closeProfileShareModal() {
            const modal = document.getElementById('profileShareModal');
            if (modal) modal.classList.add('hidden');
        }

        function copyIdBadge(idValue, btnEl) {
            if (!idValue || idValue === '-') return;
            const origHtml = btnEl.innerHTML;
            const origClass = btnEl.className;

            const doFeedback = () => {
                btnEl.innerHTML = `
                    <span class="inline-flex items-center gap-1 text-emerald-700 font-bold">
                        <svg class="w-3 h-3 stroke-emerald-600 stroke-2 fill-none" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Tersalin!
                    </span>
                `;
                btnEl.className = 'inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 border border-emerald-300 px-2.5 py-0.5 rounded-lg text-xs font-mono font-bold transition-all shadow-xs';
                setTimeout(() => {
                    btnEl.innerHTML = origHtml;
                    btnEl.className = origClass;
                }, 1500);
            };

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(idValue).then(doFeedback).catch(() => fallbackCopyId(idValue, doFeedback));
            } else {
                fallbackCopyId(idValue, doFeedback);
            }
        }

        function fallbackCopyId(text, cb) {
            const ta = document.createElement('textarea');
            ta.value = text;
            ta.style.position = 'fixed';
            ta.style.opacity = '0';
            document.body.appendChild(ta);
            ta.focus();
            ta.select();
            try {
                document.execCommand('copy');
                if (cb) cb();
            } catch (e) {}
            document.body.removeChild(ta);
        }

        function copyPublicLink() {
            const input = document.getElementById('publicLinkInput');
            const btn = document.getElementById('btnCopyLink');
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
                    title: 'Profil Developer SIMAK-TMS • ' + name,
                    text: 'Lihat portofolio terverifikasi ' + name + ' di SIMAK-TMS PT. Teknologi Multi Sistem:',
                    url: url
                }).catch(() => {});
            } else {
                copyPublicLink();
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

            // Header Banner
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

        document.addEventListener('DOMContentLoaded', function () {
            lucide.createIcons();
        });
    </script>
</body>
</html>
