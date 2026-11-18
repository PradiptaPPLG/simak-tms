@extends('layouts.simak')

@section('title', 'Profil Developer • ' . $user->name . ' • SIMAK-TMS')

@section('content')
<div class="space-y-6">

    <!-- Profile Grid Layout (Ala GitHub Two-Column) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- ============================================================== -->
        <!-- LEFT COLUMN: AVATAR, BIO, SOCIAL LINKS, TECH STACKS (4 COLS)  -->
        <!-- ============================================================== -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- User Identity Card -->
            <div class="mas-card p-6 relative overflow-hidden">
                <!-- Top Accent Line -->
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-slate-900 via-red-600 to-red-500"></div>

                <!-- Avatar with Badge & Edit Trigger (Kamera / Upload 1:1) -->
                <div class="relative w-36 h-36 mx-auto sm:mx-0 mb-3 group">
                    <div onclick="openAvatarModal()" class="w-36 h-36 rounded-2xl overflow-hidden bg-slate-900 border-4 border-white shadow-lg shadow-slate-900/10 flex items-center justify-center relative cursor-pointer group" title="Klik untuk Ubah Foto Profil">
                        @if($user->avatar)
                            <img id="profile-avatar-display" src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-full h-full object-cover user-avatar-preview transition-transform duration-300 group-hover:scale-105">
                        @else
                            <div id="profile-avatar-placeholder" class="w-full h-full flex items-center justify-center bg-red-600 text-white font-black text-3xl font-mono">
                                {{ substr($user->name, 0, 2) }}
                            </div>
                        @endif

                        <!-- Hover Overlay with Camera Icon -->
                        <div class="absolute inset-0 bg-slate-950/60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center text-white gap-1 backdrop-blur-2xs">
                            <i data-lucide="camera" class="w-6 h-6 text-red-400"></i>
                            <span class="text-[10px] font-bold">Ubah Foto Profil</span>
                        </div>
                    </div>

                    <!-- Circular Camera Button on Corner -->
                    <button type="button" onclick="openAvatarModal()" class="absolute -bottom-1.5 -right-1.5 w-10 h-10 rounded-full bg-red-600 hover:bg-red-700 text-white flex items-center justify-center shadow-lg border-2 border-white transition-all transform hover:scale-110 cursor-pointer z-10" title="Ubah Foto Profil (Kamera / Upload 1:1)">
                        <i data-lucide="camera" class="w-4 h-4"></i>
                    </button>

                    <!-- Online Status Badge -->
                    <div class="absolute top-2 right-2 w-4 h-4 rounded-full bg-emerald-500 border-2 border-white shadow-sm z-10" title="Aktif di Lab TMS"></div>
                </div>

                <!-- Secondary Quick Button under avatar -->
                <button type="button" onclick="openAvatarModal()" class="w-full sm:w-36 mb-4 px-2.5 py-1.5 rounded-xl bg-slate-100 hover:bg-red-50 hover:text-red-600 text-slate-700 text-[11px] font-bold border border-slate-200 transition-all flex items-center justify-center gap-1.5 cursor-pointer">
                    <i data-lucide="image-plus" class="w-3.5 h-3.5 text-red-500"></i>
                    <span>Edit Foto Profil (1:1)</span>
                </button>

                <!-- Names & Headlines -->
                <div class="space-y-1">
                    <h1 class="text-xl font-black text-slate-900 tracking-tight leading-snug">
                        {{ $user->name }}
                    </h1>
                    <div class="text-xs font-mono font-semibold text-slate-500 flex items-center gap-1.5 flex-wrap">
                        <span class="text-slate-900 font-bold bg-slate-100 px-2 py-0.5 rounded border border-slate-200">ID: {{ $user->account_id ?? $user->username ?? $user->id }}</span>
                        <span>•</span>
                        <span>&#64;{{ $user->username ?? strtolower(str_replace(' ', '', $user->name)) }}</span>
                        <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full bg-red-50 text-red-600 border border-red-200">
                            {{ $user->role === 'siswa' ? 'Siswa PKL' : strtoupper($user->role) }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-700 font-medium pt-1 leading-relaxed">
                        {{ $user->headline ?? 'Junior Full-Stack Web Developer & Intern @ PT. Teknologi Multi Sistem' }}
                    </p>
                </div>

                <!-- Bio Quote -->
                <div class="mt-4 pt-4 border-t border-slate-100">
                    <p class="text-xs text-slate-600 leading-relaxed italic bg-slate-50 p-3 rounded-xl border border-slate-100">
                        "{{ $user->bio ?? 'Belum ada bio singkat. Klik tombol edit profil di bawah untuk menambahkan rangkuman minat koding Anda.' }}"
                    </p>
                </div>

                <!-- Fast Edit Trigger Button -->
                <div class="mt-4">
                    <button type="button" onclick="openAndScrollToEditProfile()" 
                            class="w-full py-2.5 px-4 rounded-xl bg-slate-900 hover:bg-black text-white text-xs font-bold transition-all shadow-xs flex items-center justify-center gap-2 cursor-pointer">
                        <i data-lucide="edit-3" class="w-3.5 h-3.5 text-red-400"></i>
                        <span>Edit Profil & Media Sosial</span>
                    </button>
                </div>

                <!-- Fast Share Profile Trigger Button -->
                <div class="mt-2.5">
                    <button type="button" onclick="openProfileShareModal()" 
                            class="w-full py-2.5 px-4 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-800 text-xs font-bold transition-all shadow-xs flex items-center justify-center gap-2 cursor-pointer">
                        <i data-lucide="share-2" class="w-3.5 h-3.5 text-red-600"></i>
                        <span>Bagikan Profil Publik & QR Code</span>
                    </button>
                </div>

                <!-- Affiliations & Meta Data -->
                <div class="mt-5 space-y-2.5 text-xs text-slate-600 border-t border-slate-100 pt-4">
                    <div class="flex items-center gap-2.5">
                        <i data-lucide="building-2" class="w-4 h-4 text-slate-400 flex-shrink-0"></i>
                        <span>PT. Teknologi Multi Sistem</span>
                        @if($user->mentor)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-red-50 text-red-700 text-[10px] font-bold border border-red-200">
                                <i data-lucide="briefcase" class="w-3 h-3 text-red-600"></i>
                                <span>Divisi {{ $user->mentor->location ?? 'IT / Software Engineering' }}</span>
                            </span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2.5">
                        <i data-lucide="graduation-cap" class="w-4 h-4 text-slate-400 flex-shrink-0"></i>
                        <span>{{ $user->school_origin }} • {{ $user->major }}</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <i data-lucide="map-pin" class="w-4 h-4 text-slate-400 flex-shrink-0"></i>
                        <span>{{ $user->location ?? 'Ciamis, Jawa Barat, ID' }}</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <i data-lucide="mail" class="w-4 h-4 text-slate-400 flex-shrink-0"></i>
                        <span class="font-mono text-slate-700">{{ $user->email }}</span>
                    </div>
                </div>

                <!-- Media Sosial & Link Portofolio (Unggulan Ala GitHub) -->
                <div class="mt-5 pt-4 border-t border-slate-100 space-y-2">
                    <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Tautan & Media Sosial:</div>
                    <div class="space-y-1.5">
                        <!-- GitHub -->
                        <a href="{{ $user->github_url ?? 'https://github.com/pradiptam' }}" target="_blank" class="flex items-center justify-between p-2 rounded-lg bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-medium transition-colors group">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 fill-current shrink-0 text-slate-800" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/></svg>
                                <span>GitHub</span>
                            </div>
                            <span class="text-[11px] text-red-600 font-mono group-hover:underline">Buka &rarr;</span>
                        </a>

                        <!-- LinkedIn -->
                        <a href="{{ $user->linkedin_url ?? 'https://linkedin.com/in/pradiptaendra' }}" target="_blank" class="flex items-center justify-between p-2 rounded-lg bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-medium transition-colors group">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 fill-current shrink-0 text-[#0077b5]" viewBox="0 0 24 24" aria-hidden="true"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.46 8.76c.98 0 1.77-.8 1.77-1.78a1.77 1.77 0 0 0-3.54 0c0 .98.79 1.78 1.77 1.78M7.86 18.5v-8.37H5.07v8.37h2.79z"/></svg>
                                <span>LinkedIn</span>
                            </div>
                            <span class="text-[11px] text-red-600 font-mono group-hover:underline">Buka &rarr;</span>
                        </a>

                        <!-- Instagram -->
                        <a href="{{ $user->instagram_url ?? 'https://instagram.com/pradiptam' }}" target="_blank" class="flex items-center justify-between p-2 rounded-lg bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-medium transition-colors group">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 stroke-[#E4405F] fill-none stroke-2 shrink-0" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
                                <span>Instagram</span>
                            </div>
                            <span class="text-[11px] text-red-600 font-mono group-hover:underline">Buka &rarr;</span>
                        </a>

                        <!-- Personal Website -->
                        <a href="{{ $user->website_url ?? 'https://pradipta.dev' }}" target="_blank" class="flex items-center justify-between p-2 rounded-lg bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-medium transition-colors group">
                            <div class="flex items-center gap-2">
                                <i data-lucide="globe" class="w-4 h-4 text-emerald-600"></i>
                                <span>Website Portofolio</span>
                            </div>
                            <span class="text-[11px] text-red-600 font-mono group-hover:underline">Kunjungi &rarr;</span>
                        </a>
                    </div>
                </div>

                <!-- Tech Stack Badges -->
                <div class="mt-5 pt-4 border-t border-slate-100 space-y-2">
                    <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Tech Stack & Keahlian:</div>
                    @php
                        $skillsList = explode(',', $user->skills ?? 'PHP 8.2+, Laravel 11, Tailwind CSS, MySQL, JavaScript, Git / GitHub, RESTful API');
                    @endphp
                    <div class="flex flex-wrap gap-1.5">
                        @foreach($skillsList as $sk)
                            <span class="px-2.5 py-1 rounded-lg bg-slate-100 border border-slate-200 text-slate-800 text-[11px] font-mono font-medium">
                                {{ trim($sk) }}
                            </span>
                        @endforeach
                    </div>
                </div>

                @if($user->role === 'siswa')
                <!-- Career Badges (Ala GitHub Achievements) -->
                <div class="mt-5 pt-4 border-t border-slate-100 space-y-2.5">
                    <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Pencapaian Magang (Badges):</div>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="p-2.5 rounded-xl bg-red-50 border border-red-200 flex items-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-red-600 text-white flex items-center justify-center font-bold text-xs">
                                <i data-lucide="shield-check" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <div class="text-[11px] font-bold text-red-900 leading-tight">Verified Intern</div>
                                <div class="text-[9px] text-red-600">PT. TMS DUDI</div>
                            </div>
                        </div>

                        <div class="p-2.5 rounded-xl bg-slate-100 border border-slate-200 flex items-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-slate-900 text-white flex items-center justify-center font-bold text-xs">
                                <i data-lucide="git-pull-request" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <div class="text-[11px] font-bold text-slate-900 leading-tight">Pull Shark</div>
                                <div class="text-[9px] text-slate-500">PR Approved</div>
                            </div>
                        </div>

                        <div class="p-2.5 rounded-xl bg-slate-100 border border-slate-200 flex items-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-red-500 text-white flex items-center justify-center font-bold text-xs">
                                <i data-lucide="flame" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <div class="text-[11px] font-bold text-slate-900 leading-tight">Sprint Master</div>
                                <div class="text-[9px] text-slate-500">Modul LMS 100%</div>
                            </div>
                        </div>

                        <div class="p-2.5 rounded-xl bg-slate-100 border border-slate-200 flex items-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-emerald-600 text-white flex items-center justify-center font-bold text-xs">
                                <i data-lucide="clock" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <div class="text-[11px] font-bold text-slate-900 leading-tight">Hadir Tepat</div>
                                <div class="text-[9px] text-slate-500">07:54 WIB Checkin</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

            </div>

            <div class="mas-card p-5 space-y-3">
                <div class="flex items-center gap-2 border-b border-slate-100 pb-2.5">
                    <div class="w-7 h-7 rounded-lg bg-red-50 text-red-600 flex items-center justify-center">
                        <i data-lucide="key" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="text-xs font-black text-slate-900">Keamanan & Password Akun</h3>
                        <p class="text-[10px] text-slate-400">Kelola kata sandi akun SIMAK-TMS Anda</p>
                    </div>
                </div>
                <button type="button" onclick="openChangePasswordModal()" class="w-full py-2 px-3 rounded-xl bg-slate-900 hover:bg-black text-white text-xs font-bold transition-all flex items-center justify-center gap-2 shadow-xs">
                    <i data-lucide="lock" class="w-3.5 h-3.5 text-red-400"></i>
                    <span>Ubah Kata Sandi Akun</span>
                </button>
            </div>

        </div>

        <!-- ============================================================== -->
        <!-- RIGHT COLUMN: E-SERTIFIKAT, PINNED REPOS, & PENGATURAN PROFIL  -->
        <!-- ============================================================== -->
        <div class="lg:col-span-8 space-y-6">

            @if($user->role === 'siswa')
                @if($evaluation && $evaluation->is_published)
                    @php
                        $certNumber = $evaluation->certificate_number ?? ('TMS-CERT-2026-' . ($user->account_id ?? $user->id));
                        $verifyUrl = route('verify.show', $certNumber);
                        $printUrl = route('certificate.print', $certNumber);
                    @endphp
                    <!-- ============================================================== -->
                    <!-- E-SERTIFIKAT & QR VERIFIKASI DUDI (Fitur Unggulan Siswa)       -->
                    <!-- ============================================================== -->
                    <div class="mas-card p-6 bg-gradient-to-r from-slate-900 via-slate-950 to-slate-900 text-white relative overflow-hidden border-2 border-red-500/30 shadow-xl">
                        <!-- Top Accent Line -->
                        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-red-600 via-amber-400 to-red-500"></div>

                        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                            <!-- Left: QR Code & Info -->
                            <div class="flex items-center gap-4 shrink-0">
                                <div class="w-24 h-24 sm:w-28 sm:h-28 bg-white p-2 rounded-2xl shadow-lg border-2 border-amber-400/50 shrink-0">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data={{ urlencode($verifyUrl) }}" alt="QR Code Verifikasi" class="w-full h-full object-contain">
                                </div>
                                <div class="space-y-1">
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 text-[10px] font-bold uppercase">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                        Dokumen Otentik Terverifikasi
                                    </div>
                                    <h3 class="text-base font-black text-white">E-Sertifikat Kelulusan PKL PT. TMS</h3>
                                    <div class="text-xs font-mono text-slate-300">
                                        No. Sertifikat: <b class="text-amber-400 font-mono">{{ $certNumber }}</b>
                                    </div>
                                    <p class="text-[11px] text-slate-400 max-w-sm leading-snug">
                                        Pindai QR ini langsung dengan kamera HP untuk memvalidasi keaslian di portal resmi.
                                    </p>
                                </div>
                            </div>

                            <!-- Right: Skor & Tombol Aksi -->
                            <div class="flex flex-col sm:flex-row items-center gap-4 w-full md:w-auto justify-end">
                                <div class="bg-white/10 backdrop-blur-md px-4 py-3 rounded-2xl border border-white/10 text-center shrink-0 w-full sm:w-auto">
                                    <div class="text-[10px] uppercase font-bold text-slate-300">Skor Kelulusan</div>
                                    <div class="text-2xl font-black text-amber-400 font-mono">{{ $evaluation->final_score }}</div>
                                    <div class="text-[10px] text-emerald-400 font-bold">PREDIKAT {{ $evaluation->final_score >= 85 ? 'A' : ($evaluation->final_score >= 75 ? 'B' : 'C') }}</div>
                                </div>

                                <div class="flex flex-col gap-2 w-full sm:w-auto shrink-0">
                                    <a href="{{ $printUrl }}" target="_blank" class="py-2.5 px-4 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-bold transition-all shadow-md shadow-red-600/30 flex items-center justify-center gap-2">
                                        <i data-lucide="printer" class="w-4 h-4"></i>
                                        <span>Cetak E-Sertifikat (PDF)</span>
                                    </a>
                                    <a href="{{ $verifyUrl }}" target="_blank" class="py-2.5 px-4 rounded-xl bg-white/15 hover:bg-white/25 text-white text-xs font-bold transition-all border border-white/20 flex items-center justify-center gap-2">
                                        <i data-lucide="shield-check" class="w-4 h-4 text-emerald-400"></i>
                                        <span>Verifikasi Publik &rarr;</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Status Belum Lulus / Magang Berjalan -->
                    <div class="mas-card p-5 bg-gradient-to-r from-slate-900 to-slate-800 text-white rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-4 border border-slate-700 shadow-md">
                        <div class="flex items-center gap-3.5">
                            <div class="w-11 h-11 rounded-xl bg-amber-500/20 text-amber-400 border border-amber-500/30 flex items-center justify-center shrink-0">
                                <i data-lucide="clock" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-300 text-[10px] font-bold uppercase mb-1">
                                    Status: Praktik Kerja Lapangan Aktif
                                </div>
                                <h3 class="text-sm font-bold text-white">E-Sertifikat Kelulusan Belum Diterbitkan</h3>
                                <p class="text-xs text-slate-300 mt-0.5 leading-relaxed">
                                    Sertifikat resmi dan kode verifikasi QR akan terbit otomatis setelah pembimbing mentor industri menyelesaikan evaluasi nilai 4 pilar di akhir periode PKL.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            <!-- 2. PINNED REPOSITORIES & PROJECTS (Proyek Unggulan Ala GitHub) -->
            <div class="mas-card p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div class="flex items-center gap-2">
                        <i data-lucide="pin" class="w-4 h-4 text-red-600"></i>
                        <h2 class="text-sm font-black text-slate-900 uppercase tracking-wider">
                            Proyek Unggulan & Repositori (Pinned Projects)
                        </h2>
                    </div>
                    <a href="{{ route('showcase.index') }}" class="text-xs font-bold text-red-600 hover:underline">
                        Lihat Semua Arsip &rarr;
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($projects as $proj)
                        <div class="p-4 rounded-xl border border-slate-200 bg-white hover:border-red-300 hover:shadow-xs transition-all flex flex-col justify-between space-y-3">
                            <div>
                                <div class="flex items-center justify-between gap-2">
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="book-bookmark" class="w-4 h-4 text-slate-500"></i>
                                        <h3 class="text-xs font-bold text-red-600 font-mono hover:underline">
                                            {{ $proj->title }}
                                        </h3>
                                    </div>
                                    <span class="text-[10px] px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 font-semibold border border-slate-200">
                                        Public
                                    </span>
                                </div>
                                <p class="text-xs text-slate-600 mt-2 leading-relaxed line-clamp-2">
                                    {{ $proj->short_description ?? $proj->description }}
                                </p>
                            </div>

                            <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                                <div class="flex items-center gap-3">
                                    <span class="flex items-center gap-1.5 font-medium">
                                        <span class="w-2.5 h-2.5 rounded-full bg-red-600 inline-block"></span>
                                        Laravel
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <i data-lucide="star" class="w-3.5 h-3.5 text-amber-500"></i>
                                        12
                                    </span>
                                </div>

                                <div class="flex items-center gap-2">
                                    @if($proj->repo_url)
                                        <a href="{{ $proj->repo_url }}" target="_blank" class="px-2.5 py-1 rounded-lg bg-slate-900 hover:bg-black text-white font-mono text-[11px] font-medium flex items-center gap-1.5 shadow-2xs transition-colors">
                                            <svg class="w-3.5 h-3.5 fill-current shrink-0" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/></svg>
                                            <span>Repo</span>
                                        </a>
                                    @endif
                                    @if($proj->live_url)
                                        <a href="{{ $proj->live_url }}" target="_blank" class="px-2.5 py-1 rounded-lg bg-red-600 hover:bg-red-700 text-white text-[11px] font-bold flex items-center gap-1.5 shadow-2xs transition-colors">
                                            <i data-lucide="external-link" class="w-3 h-3"></i>
                                            <span>Demo</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <!-- Default Fallback Pinned Cards -->
                        <div class="p-4 rounded-xl border border-slate-200 bg-white flex flex-col justify-between space-y-3">
                            <div>
                                <div class="flex items-center justify-between">
                                    <h3 class="text-xs font-bold text-red-600 font-mono">TechPulse Engineering Blog</h3>
                                    <span class="text-[10px] px-2 py-0.5 rounded-full bg-slate-100 text-slate-600">Public</span>
                                </div>
                                <p class="text-xs text-slate-600 mt-2">Sistem blog arsitektur modular dengan REST API, relasi komentar, dan dashboard analitik.</p>
                            </div>
                            <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-xs">
                                <span class="font-medium text-slate-500"><span class="w-2 h-2 rounded-full bg-red-600 inline-block mr-1"></span> Laravel</span>
                                <span class="font-bold text-slate-800">14 Commits</span>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- 3. FORM EDIT PROFIL & MEDIA SOSIAL (Bisa Ditambah & Diubah Langsung) -->
            <div id="edit-profile-section" class="mas-card p-5 sm:p-7 space-y-5 transition-all">
                <div id="edit-profile-header" class="flex items-center justify-between gap-3 border-b border-slate-100 pb-4 transition-all">
                    <div class="min-w-0">
                        <h2 class="text-base sm:text-lg font-black text-slate-900 tracking-tight flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center shrink-0">
                                <i data-lucide="settings" class="w-4 h-4"></i>
                            </div>
                            <span class="truncate">Pengaturan Profil & Media Sosial</span>
                        </h2>
                        <p id="edit-profile-sub" class="text-xs text-slate-500 mt-1">
                            Perbarui informasi biodata, tautan media sosial, serta foto avatar profil Anda di sini.
                        </p>
                    </div>

                    <!-- Tombol Panah Abu-Abu Kecil (Kanan Atas Sesuai Permintaan) -->
                    <button type="button" onclick="toggleProfileSection('edit-profile')" class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-700 flex items-center justify-center transition-all cursor-pointer shrink-0" title="Sembunyikan Pengaturan">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </button>
                </div>

                <div id="edit-profile-body">
                    <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Row 1: Username & Foto Avatar URL -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Username Developer</label>
                            <div class="relative">
                                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-xs text-slate-400 font-mono">&#64;</span>
                                <input type="text" name="username" value="{{ old('username', $user->username ?? 'pradiptaendra') }}" 
                                       class="w-full pl-8 pr-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 font-mono focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                            </div>
                            <p class="text-[10px] text-slate-400 mt-1">Username unik untuk tautan portofolio SIMAK.</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Foto Profil / Avatar</label>
                            <div class="flex gap-2">
                                <input type="text" id="form-avatar-url-input" name="avatar" value="{{ old('avatar', $user->avatar) }}" 
                                       placeholder="https://... atau klik tombol upload"
                                       class="flex-1 px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 font-mono focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                                <button type="button" onclick="openAvatarModal()" class="px-3.5 py-2.5 bg-slate-900 hover:bg-black text-white text-xs font-bold rounded-xl transition-all shadow-xs flex items-center gap-1.5 shrink-0 cursor-pointer" title="Ambil Kamera / Upload & Crop 1:1">
                                    <i data-lucide="camera" class="w-4 h-4 text-red-500"></i>
                                    <span class="hidden sm:inline">Upload / Kamera</span>
                                </button>
                            </div>
                            <p class="text-[10px] text-slate-400 mt-1">Dapat menggunakan kamera langsung atau upload file (Maks. 2MB, Crop 1:1 auto).</p>
                        </div>
                    </div>

                    <!-- Row 2: Headline / Role Title -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Headline Keahlian / Status Magang</label>
                        <input type="text" name="headline" value="{{ old('headline', $user->headline ?? 'Junior Full-Stack Web Developer & Intern @ PT. Teknologi Multi Sistem') }}"
                               placeholder="Contoh: Junior Backend Engineer & Intern @ PT. Teknologi Multi Sistem"
                               class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>

                    <!-- Row 3: Bio Developer -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Bio / Rangkuman Diri</label>
                        <textarea name="bio" rows="3" placeholder="Ceritakan latar belakang ketertarikan teknologi Anda..."
                                  class="w-full p-3 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 leading-relaxed">{{ old('bio', $user->bio) }}</textarea>
                    </div>

                    <!-- Row 4: Media Sosial (GitHub & LinkedIn) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 fill-current shrink-0 text-slate-900" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/></svg>
                                <span>Tautan Profil GitHub</span>
                            </label>
                            <input type="url" name="github_url" value="{{ old('github_url', $user->github_url ?? 'https://github.com/pradiptam') }}"
                                   placeholder="https://github.com/username"
                                   class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 font-mono focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 fill-current shrink-0 text-[#0077b5]" viewBox="0 0 24 24" aria-hidden="true"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.46 8.76c.98 0 1.77-.8 1.77-1.78a1.77 1.77 0 0 0-3.54 0c0 .98.79 1.78 1.77 1.78M7.86 18.5v-8.37H5.07v8.37h2.79z"/></svg>
                                <span>Tautan Profil LinkedIn</span>
                            </label>
                            <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $user->linkedin_url ?? 'https://linkedin.com/in/pradiptaendra') }}"
                                   placeholder="https://linkedin.com/in/username"
                                   class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 font-mono focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                        </div>
                    </div>

                    <!-- Row 5: Media Sosial (Instagram & Website Portofolio) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 stroke-[#E4405F] fill-none stroke-2 shrink-0" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
                                <span>Tautan Instagram</span>
                            </label>
                            <input type="url" name="instagram_url" value="{{ old('instagram_url', $user->instagram_url ?? 'https://instagram.com/pradiptam') }}"
                                   placeholder="https://instagram.com/username"
                                   class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 font-mono focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1 flex items-center gap-1.5">
                                <i data-lucide="globe" class="w-3.5 h-3.5 text-emerald-600"></i>
                                <span>Website Portofolio Pribadi</span>
                            </label>
                            <input type="url" name="website_url" value="{{ old('website_url', $user->website_url ?? 'https://pradipta.dev') }}"
                                   placeholder="https://pradipta.dev"
                                   class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 font-mono focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                        </div>
                    </div>

                    <!-- Row 6: Tech Stack Skills & Location -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Tech Stack / Skills (Dipisah koma)</label>
                            <input type="text" name="skills" value="{{ old('skills', $user->skills ?? 'PHP, Laravel 11, Tailwind CSS, MySQL, JavaScript, Git, REST API') }}"
                                   placeholder="PHP, Laravel, Vue.js, Tailwind, MySQL"
                                   class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 font-mono focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Domisili / Lokasi</label>
                            <input type="text" name="location" value="{{ old('location', $user->location ?? 'Ciamis, Jawa Barat, ID') }}"
                                   placeholder="Ciamis, Jawa Barat, ID"
                                   class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-bold transition-all shadow-md shadow-red-600/30 flex items-center gap-2">
                            <i data-lucide="save" class="w-4 h-4"></i>
                            <span>Simpan Perubahan Profil</span>
                        </button>
                    </div>

                </form>
                </div>
            </div>
        </div>

    </div>

    <!-- ============================================================== -->
    <!-- ZONA KELUAR AKUN / LOGOUT (Paling Bawah Halaman Profil)         -->
    <!-- ============================================================== -->
    <div class="mas-card p-5 sm:p-6 border-l-4 border-l-red-600 bg-red-50/20 flex flex-col sm:flex-row items-center justify-between gap-4 mt-8">
        <div class="text-center sm:text-left">
            <div class="flex items-center justify-center sm:justify-start gap-2">
                <div class="w-7 h-7 rounded-lg bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                </div>
                <h4 class="text-sm font-black text-slate-900 tracking-tight">Keluar dari Sesi Akun</h4>
            </div>
            <p class="text-xs text-slate-500 mt-1">Selesaikan sesi aktif Anda di perangkat ini untuk menjaga kerahasiaan data SIMAK-TMS.</p>
        </div>
        <form action="{{ route('logout') }}" method="POST" class="w-full sm:w-auto shrink-0">
            @csrf
            <button type="submit" class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 active:scale-95 text-white text-xs font-bold transition-all shadow-md shadow-red-600/20 flex items-center justify-center gap-2 cursor-pointer">
                <i data-lucide="log-out" class="w-4 h-4"></i>
                <span>Keluar dari Akun</span>
            </button>
        </form>
    </div>

</div>

<script>
    function toggleProfileSection(name) {
        const body = document.getElementById(name + '-body');
        const sub = document.getElementById(name + '-sub');
        const header = document.getElementById(name + '-header');
        if (!body) return;

        const isHidden = body.classList.contains('hidden');
        const btns = document.querySelectorAll(`button[onclick*="'${name}'"]`);

        if (isHidden) {
            // Expand
            body.classList.remove('hidden');
            if (sub) sub.classList.remove('hidden');
            if (header) {
                header.classList.add('border-b', 'pb-4');
                header.classList.remove('pb-0');
            }
            btns.forEach(b => {
                b.innerHTML = '<i data-lucide="chevron-down" class="w-4 h-4"></i>';
                b.setAttribute('title', 'Sembunyikan Pengaturan');
            });
        } else {
            // Collapse (Sembunyi menjadi 1 bar dengan arrow up)
            body.classList.add('hidden');
            if (sub) sub.classList.add('hidden');
            if (header) {
                header.classList.remove('border-b', 'pb-4');
                header.classList.add('pb-0');
            }
            btns.forEach(b => {
                b.innerHTML = '<i data-lucide="chevron-up" class="w-4 h-4"></i>';
                b.setAttribute('title', 'Tampilkan Pengaturan');
            });
        }
        if (window.lucide) {
            lucide.createIcons();
        }
    }

    function openAndScrollToEditProfile() {
        const body = document.getElementById('edit-profile-body');
        if (body && body.classList.contains('hidden')) {
            toggleProfileSection('edit-profile');
        }
        const section = document.getElementById('edit-profile-section');
        if (section) {
            section.scrollIntoView({ behavior: 'smooth' });
        }
    }
</script>
@endsection