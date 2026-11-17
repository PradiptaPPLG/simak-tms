@extends('layouts.simak')

@section('title', 'Profil Developer • ' . $user->name . ' • SIMAK-TMS')

@section('content')
<div class="space-y-6">

    <!-- Flash Message Notification -->
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-2">
                <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900">&times;</button>
        </div>
    @endif

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

                <!-- Avatar with Badge -->
                <div class="relative w-36 h-36 mx-auto sm:mx-0 mb-4 group">
                    <div class="w-36 h-36 rounded-2xl overflow-hidden bg-slate-900 border-4 border-white shadow-lg shadow-slate-900/10 flex items-center justify-center">
                        @if($user->avatar)
                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-3xl font-black text-white">{{ substr($user->name, 0, 2) }}</span>
                        @endif
                    </div>
                    <!-- Online Status Badge -->
                    <div class="absolute bottom-2 right-2 w-5 h-5 rounded-full bg-emerald-500 border-2 border-white shadow-sm" title="Aktif di Lab TMS"></div>
                </div>

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
                    <button onclick="document.getElementById('edit-profile-section').scrollIntoView({behavior: 'smooth'})" 
                            class="w-full py-2.5 px-4 rounded-xl bg-slate-900 hover:bg-black text-white text-xs font-bold transition-all shadow-xs flex items-center justify-center gap-2">
                        <i data-lucide="edit-3" class="w-3.5 h-3.5 text-red-400"></i>
                        <span>Edit Profil & Media Sosial</span>
                    </button>
                </div>

                <!-- Affiliations & Meta Data -->
                <div class="mt-5 space-y-2.5 text-xs text-slate-600 border-t border-slate-100 pt-4">
                    <div class="flex items-center gap-2.5">
                        <i data-lucide="building-2" class="w-4 h-4 text-slate-400 flex-shrink-0"></i>
                        <span>PT. Teknologi Multi Sistem (Lab Software)</span>
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
                                <i data-lucide="github" class="w-4 h-4 text-slate-800"></i>
                                <span>GitHub</span>
                            </div>
                            <span class="text-[11px] text-red-600 font-mono group-hover:underline">Buka &rarr;</span>
                        </a>

                        <!-- LinkedIn -->
                        <a href="{{ $user->linkedin_url ?? 'https://linkedin.com/in/pradiptaendra' }}" target="_blank" class="flex items-center justify-between p-2 rounded-lg bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-medium transition-colors group">
                            <div class="flex items-center gap-2">
                                <i data-lucide="linkedin" class="w-4 h-4 text-slate-700"></i>
                                <span>LinkedIn</span>
                            </div>
                            <span class="text-[11px] text-red-600 font-mono group-hover:underline">Buka &rarr;</span>
                        </a>

                        <!-- Instagram -->
                        <a href="{{ $user->instagram_url ?? 'https://instagram.com/pradiptam' }}" target="_blank" class="flex items-center justify-between p-2 rounded-lg bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-medium transition-colors group">
                            <div class="flex items-center gap-2">
                                <i data-lucide="instagram" class="w-4 h-4 text-pink-600"></i>
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

            </div>

            <!-- Ganti Password Card -->
            <div class="mas-card p-5 space-y-3">
                <div class="flex items-center gap-2 border-b border-slate-100 pb-2.5">
                    <div class="w-7 h-7 rounded-lg bg-red-50 text-red-600 flex items-center justify-center">
                        <i data-lucide="key" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="text-xs font-black text-slate-900">Keamanan & Password Akun</h3>
                        <p class="text-[10px] text-slate-400">Password Universal Awal: <code class="font-mono text-red-600 font-bold">tmshebatsukses</code></p>
                    </div>
                </div>
                <button type="button" onclick="document.getElementById('modal-change-password').classList.remove('hidden')" class="w-full py-2 px-3 rounded-xl bg-slate-900 hover:bg-black text-white text-xs font-bold transition-all flex items-center justify-center gap-2 shadow-xs">
                    <i data-lucide="lock" class="w-3.5 h-3.5 text-red-400"></i>
                    <span>Ubah Kata Sandi Akun</span>
                </button>
            </div>

        </div>

        <!-- ============================================================== -->
        <!-- RIGHT COLUMN: GITHUB CONTRIBUTION HEATMAP, PINNED REPOS, EDIT  -->
        <!-- ============================================================== -->
        <div class="lg:col-span-8 space-y-6">

            <!-- 1. GITHUB CONTRIBUTION ACTIVITY HEATMAP (Fitur Khas GitHub) -->
            <div class="mas-card p-6 space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-3">
                    <div>
                        <div class="flex items-center gap-2">
                            <i data-lucide="activity" class="w-4 h-4 text-red-600"></i>
                            <h2 class="text-sm font-black text-slate-900 uppercase tracking-wider">
                                Grafik Kontribusi & Aktivitas Koding (November 2026)
                            </h2>
                        </div>
                        <p class="text-xs text-slate-400 mt-0.5">
                            Visualisasi harian kompilasi commit Git, pengisian jurnal logbook, dan submission sprint LMS.
                        </p>
                    </div>
                    <div class="text-left sm:text-right">
                        <div class="text-base font-black text-slate-900 font-mono">{{ $totalContributions }} Kontribusi</div>
                        <div class="text-[10px] text-red-600 font-bold uppercase">35 Hari Terakhir</div>
                    </div>
                </div>

                <!-- GitHub-Style Contribution Heatmap Matrix -->
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 overflow-x-auto">
                    <div class="min-w-[500px]">
                        <!-- Heatmap Grid -->
                        <div class="grid grid-flow-col grid-rows-7 gap-1.5 auto-cols-max">
                            @foreach($heatmap as $day)
                                @php
                                    $bgClass = 'bg-slate-200';
                                    if ($day['level'] === 1) $bgClass = 'bg-red-200 border-red-300';
                                    elseif ($day['level'] === 2) $bgClass = 'bg-red-500 border-red-600';
                                    elseif ($day['level'] === 3) $bgClass = 'bg-slate-900 border-black';
                                @endphp
                                <div class="w-4 h-4 rounded-sm {{ $bgClass }} border border-transparent transition-transform hover:scale-125 cursor-pointer relative group"
                                     title="{{ $day['label'] }}: {{ $day['count'] }} kontribusi aktivitas">
                                </div>
                            @endforeach
                        </div>

                        <!-- Legend Scale -->
                        <div class="mt-4 pt-3 border-t border-slate-200/80 flex items-center justify-between text-[11px] text-slate-500">
                            <span>Pelajari bagaimana kami mengalkulasi kontribusi repositori TMS</span>
                            <div class="flex items-center gap-1.5">
                                <span>Sedikit</span>
                                <span class="w-3 h-3 rounded-xs bg-slate-200 inline-block"></span>
                                <span class="w-3 h-3 rounded-xs bg-red-200 inline-block"></span>
                                <span class="w-3 h-3 rounded-xs bg-red-500 inline-block"></span>
                                <span class="w-3 h-3 rounded-xs bg-slate-900 inline-block"></span>
                                <span>Banyak</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3 Quick Activity KPI Metrics -->
                <div class="grid grid-cols-3 gap-3 pt-1">
                    <div class="bg-white p-3 rounded-xl border border-slate-100 text-center">
                        <div class="text-[10px] uppercase font-bold text-slate-400">Total Commit Git</div>
                        <div class="text-xl font-black text-slate-900 font-mono">{{ $totalCommits }}</div>
                    </div>
                    <div class="bg-white p-3 rounded-xl border border-slate-100 text-center">
                        <div class="text-[10px] uppercase font-bold text-slate-400">Jurnal Terverifikasi</div>
                        <div class="text-xl font-black text-red-600 font-mono">{{ $totalJournals }}</div>
                    </div>
                    <div class="bg-white p-3 rounded-xl border border-slate-100 text-center">
                        <div class="text-[10px] uppercase font-bold text-slate-400">Skor Evaluasi</div>
                        <div class="text-xl font-black text-slate-900 font-mono">{{ $evaluation->final_score ?? 94 }}</div>
                    </div>
                </div>
            </div>

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
                                        <a href="{{ $proj->repo_url }}" target="_blank" class="text-slate-700 hover:text-red-600 font-mono text-[11px] font-bold">
                                            Repo
                                        </a>
                                    @endif
                                    @if($proj->live_url)
                                        <a href="{{ $proj->live_url }}" target="_blank" class="px-2.5 py-1 rounded bg-slate-900 text-white text-[11px] font-bold hover:bg-black transition-colors">
                                            Demo
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
            <div id="edit-profile-section" class="mas-card p-6 sm:p-8 space-y-5">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <h2 class="text-lg font-black text-slate-900 tracking-tight flex items-center gap-2">
                            <i data-lucide="settings" class="w-5 h-5 text-red-600"></i>
                            <span>Pengaturan Profil Developer & Media Sosial</span>
                        </h2>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Perbarui informasi biodata, tautan media sosial, serta foto avatar profil Anda di sini.
                        </p>
                    </div>
                </div>

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
                            <label class="block text-xs font-bold text-slate-700 mb-1">URL Foto Profil / Avatar</label>
                            <input type="text" name="avatar" value="{{ old('avatar', $user->avatar) }}" 
                                   placeholder="https://.../avatar.jpg"
                                   class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 font-mono focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                            <p class="text-[10px] text-slate-400 mt-1">Dapat menggunakan URL Gravatar, Unsplash, atau UI-Avatars.</p>
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
                                <i data-lucide="github" class="w-3.5 h-3.5 text-slate-900"></i>
                                <span>Tautan Profil GitHub</span>
                            </label>
                            <input type="url" name="github_url" value="{{ old('github_url', $user->github_url ?? 'https://github.com/pradiptam') }}"
                                   placeholder="https://github.com/username"
                                   class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 font-mono focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1 flex items-center gap-1.5">
                                <i data-lucide="linkedin" class="w-3.5 h-3.5 text-slate-700"></i>
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
                                <i data-lucide="instagram" class="w-3.5 h-3.5 text-pink-600"></i>
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

            <!-- Ganti Password Card -->
            <div class="mas-card p-5 space-y-3">
                <div class="flex items-center gap-2 border-b border-slate-100 pb-2.5">
                    <div class="w-7 h-7 rounded-lg bg-red-50 text-red-600 flex items-center justify-center">
                        <i data-lucide="key" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="text-xs font-black text-slate-900">Keamanan & Password Akun</h3>
                        <p class="text-[10px] text-slate-400">Password Universal Awal: <code class="font-mono text-red-600 font-bold">tmshebatsukses</code></p>
                    </div>
                </div>
                <button type="button" onclick="document.getElementById('modal-change-password').classList.remove('hidden')" class="w-full py-2 px-3 rounded-xl bg-slate-900 hover:bg-black text-white text-xs font-bold transition-all flex items-center justify-center gap-2 shadow-xs">
                    <i data-lucide="lock" class="w-3.5 h-3.5 text-red-400"></i>
                    <span>Ubah Kata Sandi Akun</span>
                </button>
            </div>

        </div>

    </div>

</div>
@endsection