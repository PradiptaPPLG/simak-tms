@extends('layouts.simak')

@section('title', 'Dashboard Monitoring Mentor • PT. Teknologi Multi Sistem')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-red-50 text-red-600 border border-red-200 text-[10px] font-bold uppercase tracking-wider mb-1">
                <span class="w-1.5 h-1.5 rounded-full bg-red-600 animate-pulse"></span>
                Monitoring Khusus Batch Berjalan (Yang Sekarang)
            </div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900">Dashboard Monitoring Pembimbing</h1>
            <p class="text-xs text-slate-500 mt-0.5">Monitoring aktivitas koding siswa magang aktif, validasi cepat jurnal harian, dan review Pull Request di PT. TMS.</p>
        </div>

        <div class="flex items-center gap-2.5">
            <button onclick="document.getElementById('form-register-student').scrollIntoView({behavior: 'smooth'})" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-red-600/25 flex items-center gap-2">
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                <span>Daftarkan Siswa</span>
            </button>
            <div class="bg-white border border-slate-200 px-3.5 py-1.5 rounded-xl text-xs font-semibold text-slate-700 flex items-center gap-2 shadow-xs">
                <i data-lucide="calendar" class="w-4 h-4 text-red-600"></i>
                <span>{{ now()->translatedFormat('l, d F Y') }}</span>
            </div>
            <a href="{{ route('mentor.review') }}" class="px-4 py-2 bg-slate-900 hover:bg-black text-white text-xs font-bold rounded-xl transition-all shadow-xs flex items-center gap-2">
                <i data-lucide="check-check" class="w-4 h-4 text-emerald-400"></i>
                <span>Pusat Review ({{ $pendingJournals->count() }})</span>
            </a>
        </div>
    </div>

    <!-- 1. Top 4 KPI Metrics (Monitoring Yang Sekarang) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Card 1: Siswa Bimbingan Aktif Sekarang -->
        <div class="mas-card p-5 border-l-4 border-l-red-600 flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-slate-400 text-[11px] font-bold uppercase tracking-wider mb-1">Siswa Aktif Sekarang</p>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight font-mono">{{ $activeInterns->count() }} <span class="text-xs font-normal text-slate-500">Orang</span></h3>
                </div>
                <div class="w-10 h-10 bg-red-50 text-red-600 rounded-xl flex items-center justify-center">
                    <i data-lucide="user-check" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-slate-100 text-[11px] text-slate-500 flex items-center justify-between">
                <span>Batch {{ $activeBatch->period_year ?? '2026' }}</span>
                <span class="text-emerald-600 font-bold flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    Hadir di Lab
                </span>
            </div>
        </div>

        <!-- Card 2: Jurnal Masuk Hari Ini -->
        <div class="mas-card p-5 border-l-4 border-l-slate-900 flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-slate-400 text-[11px] font-bold uppercase tracking-wider mb-1">Jurnal Masuk Hari Ini</p>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight font-mono">{{ $pendingJournals->count() }} <span class="text-xs font-normal text-slate-500">Perlu Validasi</span></h3>
                </div>
                <div class="w-10 h-10 bg-slate-100 text-slate-900 rounded-xl flex items-center justify-center">
                    <i data-lucide="book-open" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-slate-100 text-[11px] text-slate-500 flex items-center justify-between">
                <span>Batas Verifikasi:</span>
                <span class="font-bold text-red-600">17.00 WIB</span>
            </div>
        </div>

        <!-- Card 3: Pull Request Modul LMS -->
        <div class="mas-card p-5 border-l-4 border-l-red-500 flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-slate-400 text-[11px] font-bold uppercase tracking-wider mb-1">Pull Request Koding</p>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight font-mono">{{ $pendingSubmissions->count() }} <span class="text-xs font-normal text-slate-500">PR Menunggu</span></h3>
                </div>
                <div class="w-10 h-10 bg-red-50 text-red-600 rounded-xl flex items-center justify-center">
                    <i data-lucide="git-pull-request" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-slate-100 text-[11px] text-slate-500 flex items-center justify-between">
                <span>Code Audit:</span>
                <span class="font-bold text-slate-800">Branch Review</span>
            </div>
        </div>

        <!-- Card 4: Rata-rata Skor Bimbingan -->
        <div class="mas-card p-5 border-l-4 border-l-slate-800 flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-slate-400 text-[11px] font-bold uppercase tracking-wider mb-1">Rata-rata Skor</p>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight font-mono">94.0 <span class="text-xs font-normal text-emerald-600 font-bold">[ A ]</span></h3>
                </div>
                <div class="w-10 h-10 bg-slate-100 text-slate-800 rounded-xl flex items-center justify-center">
                    <i data-lucide="award" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-slate-100 text-[11px] text-slate-500 flex items-center justify-between">
                <span>Standar Industri:</span>
                <span class="font-bold text-red-600">Sangat Memuaskan</span>
            </div>
        </div>

    </div>

    <!-- 2. Aksi Cepat Khusus Mentor -->
    <div>
        <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Tindakan Pembimbing</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            
            <a href="{{ route('mentor.review') }}" class="mas-card mas-card-hover p-4 flex flex-col items-center justify-center gap-2.5 text-center group">
                <div class="w-10 h-10 rounded-full bg-red-50 text-red-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i data-lucide="check-check" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-800 group-hover:text-red-600 transition-colors">1-Click Validasi Jurnal</div>
                    <div class="text-[10px] text-slate-400">{{ $pendingJournals->count() }} Menunggu review</div>
                </div>
            </a>

            <a href="{{ route('tasks.index') }}" class="mas-card mas-card-hover p-4 flex flex-col items-center justify-center gap-2.5 text-center group">
                <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-900 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i data-lucide="git-pull-request" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-800 group-hover:text-slate-900 transition-colors">Code Review & Nilai</div>
                    <div class="text-[10px] text-slate-400">Modul koding siswa</div>
                </div>
            </a>

            <a href="{{ route('showcase.index') }}" class="mas-card mas-card-hover p-4 flex flex-col items-center justify-center gap-2.5 text-center group">
                <div class="w-10 h-10 rounded-full bg-red-50 text-red-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i data-lucide="folder-git-2" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-800 group-hover:text-red-600 transition-colors">Showcase Batch Sekarang</div>
                    <div class="text-[10px] text-slate-400">Arsip produk digital</div>
                </div>
            </a>

            <a href="{{ route('evaluation.index') }}" class="mas-card mas-card-hover p-4 flex flex-col items-center justify-center gap-2.5 text-center group">
                <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-900 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i data-lucide="award" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-800 group-hover:text-slate-900 transition-colors">Evaluasi 4 Pilar</div>
                    <div class="text-[10px] text-slate-400">Penilaian akhir industri</div>
                </div>
            </a>

        </div>
    </div>

    <!-- 3. Section: Live Monitoring Logbook Masuk Hari Ini (Batch Berjalan) -->
    <div class="mas-card p-6 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-3">
            <div>
                <h2 class="text-base font-black text-slate-900 tracking-tight flex items-center gap-2">
                    <i data-lucide="clock" class="w-5 h-5 text-red-600"></i>
                    <span>Logbook Siswa Masuk Hari Ini (Batch Berjalan)</span>
                </h2>
                <p class="text-xs text-slate-400 mt-0.5">Verifikasi laporan aktivitas harian siswa magang. Klik tombol setujui untuk mengesahkan jurnal.</p>
            </div>
            <span class="text-xs font-bold px-2.5 py-1 rounded-lg bg-red-50 text-red-600 border border-red-200">
                {{ $pendingJournals->count() }} Logbook Baru
            </span>
        </div>

        <div class="space-y-3">
            @forelse($pendingJournals as $journal)
                <div class="p-4 rounded-xl border border-slate-200 bg-white hover:border-red-300 transition-all flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="space-y-1.5 flex-1">
                        <div class="flex items-center gap-2 text-xs">
                            <span class="font-bold text-slate-900">{{ $journal->user->name }}</span>
                            <span class="text-slate-400">•</span>
                            <span class="text-slate-500 font-medium">{{ $journal->user->school_origin }}</span>
                            <span class="text-slate-400">•</span>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-emerald-100 text-emerald-800">Masuk: 07.54 WIB</span>
                        </div>
                        <div class="text-xs font-bold text-slate-800">{{ $journal->activity_title }}</div>
                        <p class="text-xs text-slate-600 leading-relaxed">{{ $journal->activity_detail }}</p>
                        
                        @if($journal->commit_url)
                            <div class="text-[11px] text-slate-500 flex items-center gap-1.5 pt-1">
                                <i data-lucide="git-commit" class="w-3.5 h-3.5 text-red-600"></i>
                                <span>Bukti Commit Git:</span>
                                <a href="{{ $journal->commit_url }}" target="_blank" class="text-red-600 hover:underline font-mono">{{ $journal->commit_url }}</a>
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center gap-2 flex-shrink-0">
                        <form action="{{ route('mentor.journal.approve', $journal->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 rounded-xl text-xs font-bold bg-slate-900 hover:bg-black text-white transition-all shadow-xs flex items-center gap-1.5">
                                <i data-lucide="check" class="w-4 h-4 text-emerald-400"></i>
                                <span>Setujui (1-Click)</span>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-6 text-center text-slate-400 text-xs bg-slate-50 rounded-xl border border-slate-100">
                    Semua logbook harian siswa telah divalidasi. Tidak ada antrean baru.
                </div>
            @endforelse
        </div>
    </div>

    <!-- 4. Section: Live Telemetri Siswa Bimbingan Saat Ini (Yang Sekarang) -->
    <div class="mas-card p-6 space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h2 class="text-base font-black text-slate-900 tracking-tight flex items-center gap-2">
                <i data-lucide="users" class="w-5 h-5 text-red-600"></i>
                <span>Status Kehadiran & Progres Koding Siswa Aktif</span>
            </h2>
            <span class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-lg">
                Lab Software TMS
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($activeInterns as $intern)
                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl overflow-hidden bg-slate-900 text-white font-extrabold flex items-center justify-center border-2 border-red-500">
                                @if($intern->avatar)
                                    <img src="{{ $intern->avatar }}" alt="{{ $intern->name }}" class="w-full h-full object-cover">
                                @else
                                    {{ substr($intern->name, 0, 2) }}
                                @endif
                            </div>
                            <div>
                                <h3 class="text-xs font-bold text-slate-900">{{ $intern->name }}</h3>
                                <div class="text-[10px] text-slate-400 font-mono">&#64;{{ $intern->username ?? 'siswa' }} • {{ $intern->major }}</div>
                            </div>
                        </div>

                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span>
                            Check-in 07:54 WIB
                        </span>
                    </div>

                    <div class="text-xs text-slate-600 space-y-1 border-t border-slate-200/60 pt-2.5">
                        <div class="flex justify-between">
                            <span class="text-slate-400">Sekolah:</span>
                            <span class="font-semibold text-slate-800">{{ $intern->school_origin }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Modul Sprint Disubmit:</span>
                            <span class="font-bold text-red-600 font-mono">{{ $intern->submissions->count() }} Modul</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Skor Evaluasi:</span>
                            <span class="font-black text-slate-900 font-mono">{{ $intern->evaluation->final_score ?? 94 }} [ A ]</span>
                        </div>
                    </div>

                    <div class="pt-2 flex items-center justify-end gap-2 border-t border-slate-200/60">
                        <a href="{{ route('profile') }}" class="px-3 py-1.5 rounded-lg bg-white border border-slate-200 text-slate-700 text-[11px] font-semibold hover:bg-slate-50 transition-colors flex items-center gap-1">
                            <i data-lucide="user" class="w-3.5 h-3.5 text-red-600"></i>
                            <span>Profil GitHub</span>
                        </a>
                        <a href="{{ route('mentor.review') }}" class="px-3 py-1.5 rounded-lg bg-red-600 hover:bg-red-700 text-white text-[11px] font-bold transition-colors">
                            Review Koding
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- 5. Section: Pendaftaran Siswa Bimbingan Baru oleh Mentor -->
    <div id="form-register-student" class="mas-card p-6 sm:p-8 space-y-5">
        <div class="border-b border-slate-100 pb-4">
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-red-50 text-red-600 border border-red-200 text-[10px] font-bold uppercase tracking-wider mb-1">
                Hak Akses Mentor
            </div>
            <h2 class="text-lg font-black text-slate-900 tracking-tight flex items-center gap-2">
                <i data-lucide="user-plus" class="w-5 h-5 text-red-600"></i>
                <span>Daftarkan Siswa Bimbingan Baru</span>
            </h2>
            <p class="text-xs text-slate-500 mt-0.5">
                Staff Mentor berwenang mendaftarkan akun Siswa magang. Siswa yang Anda daftarkan otomatis menjadi anak bimbingan Anda dan langsung tersinkronisasi ke daftar master Admin TMS.
            </p>
        </div>

        <form action="{{ route('mentor.students.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Siswa Magang</label>
                    <input type="text" name="name" required placeholder="Contoh: Alyzza Enggar" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Email Siswa / NISN</label>
                    <input type="email" name="email" required placeholder="alyzza@smkn1ciamis.sch.id" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Asal Sekolah</label>
                    <input type="text" name="school_origin" value="SMKN 1 Ciamis" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jurusan / Kompetensi Keahlian</label>
                    <input type="text" name="major" value="PPLG" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                </div>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                <span class="text-[11px] text-slate-400">Pembimbing otomatis: <b class="text-slate-800">{{ auth()->user()->name }}</b> (Password standar: <span class="font-mono">password</span>)</span>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-slate-900 hover:bg-black text-white text-xs font-bold transition-all shadow-xs flex items-center gap-2">
                    <i data-lucide="user-check" class="w-4 h-4 text-emerald-400"></i>
                    <span>Daftarkan ke Tim Bimbingan Saya</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection