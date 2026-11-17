@extends('layouts.simak')

@section('title', 'Siswa Bimbingan & Monitoring Performa • SIMAK-TMS')

@section('content')
<div class="space-y-6">

    <!-- Page Heading -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-red-50 text-red-600 border border-red-200 text-[10px] font-bold uppercase tracking-wider mb-1">
                Area Staff Mentor
            </div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900">Siswa Bimbingan & Monitoring Performa</h1>
            <p class="text-xs text-slate-500 mt-0.5">Inspect performa koding, rekapitulasi logbook jurnal harian, dan karya portofolio siswa bimbingan Anda.</p>
        </div>

        <div class="flex items-center gap-2.5">
            <div class="bg-white border border-slate-200 px-3.5 py-1.5 rounded-xl text-xs font-semibold text-slate-700 flex items-center gap-2 shadow-xs">
                <i data-lucide="calendar" class="w-4 h-4 text-red-600"></i>
                <span>{{ now()->translatedFormat('l, d F Y') }}</span>
            </div>
            <a href="{{ route('mentor.review') }}" class="px-4 py-2 bg-slate-900 hover:bg-black text-white text-xs font-bold rounded-xl transition-all shadow-xs flex items-center gap-2">
                <i data-lucide="check-check" class="w-4 h-4 text-emerald-400"></i>
                <span>Validasi Jurnal</span>
            </a>
        </div>
    </div>

    <!-- 1. Top 3 Stat Cards (Counting Basis) -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        
        <!-- Card 1: Total Siswa Bimbingan -->
        <div class="mas-card p-5 border-l-4 border-l-red-600 flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-slate-400 text-[11px] font-bold uppercase tracking-wider mb-1">Siswa Bimbingan Anda</p>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight font-mono">{{ $totalStudents }} <span class="text-xs font-normal text-slate-500">Peserta Aktif</span></h3>
                </div>
                <div class="w-10 h-10 bg-red-50 text-red-600 rounded-xl flex items-center justify-center">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-slate-100 text-[11px] text-slate-500 flex items-center justify-between">
                <span>Pembimbing:</span>
                <span class="font-bold text-slate-800">{{ $mentor->name ?? 'Staff Mentor TMS' }}</span>
            </div>
        </div>

        <!-- Card 2: Total Jurnal Terselesaikan -->
        <div class="mas-card p-5 border-l-4 border-l-slate-900 flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-slate-400 text-[11px] font-bold uppercase tracking-wider mb-1">Jurnal Terselesaikan</p>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight font-mono">{{ $totalApprovedJournals }} <span class="text-xs font-normal text-slate-500">Logbook Valid</span></h3>
                </div>
                <div class="w-10 h-10 bg-slate-100 text-slate-900 rounded-xl flex items-center justify-center">
                    <i data-lucide="book-check" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-slate-100 text-[11px] text-slate-500 flex items-center justify-between">
                <span>Metode:</span>
                <span class="font-bold text-red-600">Counting Logbook Selesai</span>
            </div>
        </div>

        <!-- Card 3: Rata-rata Skor Bimbingan -->
        <div class="mas-card p-5 border-l-4 border-l-red-500 flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-slate-400 text-[11px] font-bold uppercase tracking-wider mb-1">Rata-rata Skor Bimbingan</p>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight font-mono">93.4 <span class="text-xs font-normal text-slate-500 font-bold">[A]</span></h3>
                </div>
                <div class="w-10 h-10 bg-red-50 text-red-600 rounded-xl flex items-center justify-center">
                    <i data-lucide="award" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-slate-100 text-[11px] text-slate-500 flex items-center justify-between">
                <span>Standar Industri:</span>
                <span class="font-bold text-emerald-600">Sangat Memuaskan</span>
            </div>
        </div>

    </div>

    <!-- 2. Accordion List: Siswa Bimbingan dengan Fitur Dropdown Inspect Performa -->
    <div class="space-y-4">
        <div class="flex items-center justify-between border-b border-slate-200 pb-2">
            <div>
                <h2 class="text-base font-black text-slate-900 tracking-tight flex items-center gap-2">
                    <i data-lucide="user-check" class="w-5 h-5 text-red-600"></i>
                    <span>Daftar Siswa Bimbingan & Inspect Logbook</span>
                </h2>
                <p class="text-xs text-slate-400 mt-0.5">Klik tombol <b>Inspect Performa</b> pada setiap siswa untuk membuka rekapitulasi progres koding & jurnal harian.</p>
            </div>
        </div>

        @forelse($students as $student)
            <div id="siswa-{{ $student->id }}" class="mas-card p-5 transition-all hover:border-red-200">
                
                <!-- Main Header Row of Student Card -->
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                    
                    <!-- Left: Identity -->
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-2xl overflow-hidden bg-slate-900 text-white font-black text-sm flex items-center justify-center border-2 border-red-500/30 flex-shrink-0 shadow-sm">
                            @if($student->avatar)
                                <img src="{{ $student->avatar }}" alt="{{ $student->name }}" class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr($student->name, 0, 2)) }}
                            @endif
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-sm font-black text-slate-900">{{ $student->name }}</h3>
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span>
                                    Check-in 07:54 WIB
                                </span>
                            </div>
                            <div class="text-[11px] text-slate-400 font-mono mt-0.5">
                                <span>&#64;{{ $student->username ?? 'siswa' }}</span>
                                <span class="mx-1">•</span>
                                <span>{{ $student->school_origin ?? 'SMKN 1 Ciamis' }} ({{ $student->major ?? 'PPLG' }})</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Quick Stat Badges & Toggle Button -->
                    <div class="flex flex-wrap items-center gap-2.5 self-start lg:self-auto">
                        
                        <!-- Quick Stats Pills -->
                        <div class="flex items-center gap-2 text-xs">
                            <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 font-semibold text-[11px]">
                                <b class="text-slate-900 font-mono">{{ $student->journals->count() }}</b> Jurnal Tercatat
                            </span>
                            <span class="px-2.5 py-1 rounded-lg bg-red-50 text-red-700 font-semibold text-[11px]">
                                <b class="text-red-600 font-mono">{{ $student->showcaseProjects->count() }}</b> Proyek
                            </span>
                            @if($student->evaluation)
                                <span class="px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 font-bold font-mono text-[11px] whitespace-nowrap">
                                    Nilai: {{ $student->evaluation->final_score }} [A]
                                </span>
                            @endif
                        </div>

                        <!-- Inspect Dropdown Toggle Button -->
                        <button onclick="toggleInspect('detail-{{ $student->id }}', 'chevron-{{ $student->id }}')" class="px-3.5 py-1.5 rounded-xl bg-slate-900 hover:bg-black text-white text-xs font-bold transition-all shadow-xs flex items-center gap-1.5 cursor-pointer">
                            <i data-lucide="chevron-down" id="chevron-{{ $student->id }}" class="w-4 h-4 transition-transform duration-200 text-red-400"></i>
                            <span>Inspect Performa</span>
                        </button>
                    </div>

                </div>

                <!-- Collapsible Dropdown Area (Inspect Detail Panel) -->
                <div id="detail-{{ $student->id }}" class="hidden pt-5 mt-5 border-t border-slate-100 space-y-5">
                    
                    <!-- A. Stats Performa 4 Metrik Box -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Logbook Terselesaikan</div>
                            <div class="text-lg font-black text-slate-900 font-mono mt-0.5">
                                {{ $student->journals->where('status', 'approved')->count() }} <span class="text-xs font-normal text-slate-400">/ {{ $student->journals->count() }} Jurnal</span>
                            </div>
                            <div class="text-[10px] text-emerald-600 font-semibold mt-1">✓ Berbasis Counting</div>
                        </div>

                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Portofolio Karya</div>
                            <div class="text-lg font-black text-slate-900 font-mono mt-0.5">
                                {{ $student->showcaseProjects->count() }} <span class="text-xs font-normal text-slate-400">Proyek</span>
                            </div>
                            <div class="text-[10px] text-red-600 font-semibold mt-1">Etalase Showcase Aktif</div>
                        </div>

                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Kehadiran Lab Hari Ini</div>
                            <div class="text-lg font-black text-slate-900 font-mono mt-0.5">
                                07.54 <span class="text-xs font-normal text-slate-400">WIB</span>
                            </div>
                            <div class="text-[10px] text-slate-500 font-semibold mt-1">Tepat Waktu (Hari Kerja)</div>
                        </div>

                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Skor Evaluasi DUDI</div>
                            <div class="text-lg font-black text-red-600 font-mono mt-0.5">
                                {{ $student->evaluation->final_score ?? 92.75 }} <span class="text-xs font-normal text-slate-700">[A]</span>
                            </div>
                            <div class="text-[10px] text-emerald-600 font-semibold mt-1">4 Pilar Kompetensi</div>
                        </div>
                    </div>

                    <!-- B. Breakdown 4 Pilar Penilaian Siswa -->
                    @if($student->evaluation)
                        <div class="p-4 rounded-xl bg-white border border-slate-200 space-y-2">
                            <div class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center justify-between">
                                <span>Nilai 4 Pilar Kompetensi Industri</span>
                                <span class="text-[10px] text-slate-400 font-normal">Penilai: {{ $mentor->name ?? 'Staff Mentor TMS' }}</span>
                            </div>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 pt-1 text-xs">
                                <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                                    <div class="text-slate-400 text-[10px]">Hard Skills (Koding)</div>
                                    <div class="font-black text-slate-900 font-mono text-base">{{ $student->evaluation->technical_skill }} <span class="text-[10px] text-slate-400">/100</span></div>
                                </div>
                                <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                                    <div class="text-slate-400 text-[10px]">Soft Skills (Teamwork)</div>
                                    <div class="font-black text-slate-900 font-mono text-base">{{ $student->evaluation->teamwork }} <span class="text-[10px] text-slate-400">/100</span></div>
                                </div>
                                <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                                    <div class="text-slate-400 text-[10px]">Inisiatif & Solutif</div>
                                    <div class="font-black text-slate-900 font-mono text-base">{{ $student->evaluation->initiative }} <span class="text-[10px] text-slate-400">/100</span></div>
                                </div>
                                <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                                    <div class="text-slate-400 text-[10px]">Kedisiplinan & SOP</div>
                                    <div class="font-black text-slate-900 font-mono text-base">{{ $student->evaluation->discipline }} <span class="text-[10px] text-slate-400">/100</span></div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- C. Riwayat Logbook Jurnal Siswa -->
                    <div class="space-y-2.5">
                        <div class="flex items-center justify-between">
                            <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                                <i data-lucide="book-open" class="w-4 h-4 text-red-600"></i>
                                <span>Riwayat Logbook Jurnal Kegiatan Siswa</span>
                            </h4>
                            <span class="text-[10px] text-slate-400">{{ $student->journals->count() }} Jurnal Tercatat</span>
                        </div>

                        @if($student->journals->count() > 0)
                            <div class="space-y-2">
                                @foreach($student->journals as $journal)
                                    <div class="p-3.5 rounded-xl bg-slate-50/80 border border-slate-200/80 space-y-2">
                                        <div class="flex items-start justify-between gap-2">
                                            <div>
                                                <div class="text-xs font-bold text-slate-900">{{ $journal->activity_title }}</div>
                                                <div class="text-[10px] text-slate-400 flex items-center gap-2 mt-0.5">
                                                    <span>{{ \Carbon\Carbon::parse($journal->journal_date)->translatedFormat('l, d F Y') }}</span>
                                                    @if($journal->commit_url)
                                                        <a href="{{ $journal->commit_url }}" target="_blank" class="text-red-600 hover:underline flex items-center gap-1">
                                                            <i data-lucide="git-commit" class="w-3 h-3"></i>
                                                            <span>Commit Git</span>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>

                                            <div>
                                                @if($journal->status === 'approved')
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-bold text-[10px]">
                                                        ✓ Disetujui Mentor
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 font-bold text-[10px]">
                                                        ⏳ Menunggu Validasi
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <p class="text-xs text-slate-600 leading-relaxed">{{ $journal->activity_detail }}</p>

                                        @if($journal->challenges || $journal->solution)
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px] pt-1">
                                                @if($journal->challenges)
                                                    <div class="p-2 rounded-lg bg-red-50/50 border border-red-100 text-red-900">
                                                        <b class="text-red-700 block text-[10px] uppercase">Kendala Koding:</b>
                                                        {{ $journal->challenges }}
                                                    </div>
                                                @endif
                                                @if($journal->solution)
                                                    <div class="p-2 rounded-lg bg-emerald-50/50 border border-emerald-100 text-emerald-900">
                                                        <b class="text-emerald-700 block text-[10px] uppercase">Solusi:</b>
                                                        {{ $journal->solution }}
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="p-4 rounded-xl bg-slate-50 text-center text-xs text-slate-400">
                                Siswa belum mengisikan logbook kegiatan.
                            </div>
                        @endif
                    </div>

                    <!-- D. Quick Action Footer Links -->
                    <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                        <a href="{{ route('profile') }}" class="px-3 py-1.5 rounded-lg bg-white border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 transition-colors flex items-center gap-1.5 shadow-2xs">
                            <i data-lucide="github" class="w-3.5 h-3.5 text-slate-900"></i>
                            <span>Profil Developer Siswa</span>
                        </a>
                        <a href="{{ route('evaluation.index') }}" class="px-3 py-1.5 rounded-lg bg-white border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 transition-colors flex items-center gap-1.5 shadow-2xs">
                            <i data-lucide="award" class="w-3.5 h-3.5 text-red-600"></i>
                            <span>Rapor Nilai Industri</span>
                        </a>
                        <a href="{{ route('mentor.review') }}" class="px-4 py-1.5 rounded-lg bg-red-600 hover:bg-red-700 text-white text-xs font-bold transition-all shadow-xs flex items-center gap-1.5">
                            <i data-lucide="check-check" class="w-3.5 h-3.5"></i>
                            <span>Validasi Logbook</span>
                        </a>
                    </div>

                </div>

            </div>
        @empty
            <div class="mas-card p-8 text-center text-slate-400 text-xs">
                Belum ada siswa bimbingan yang terhubung ke akun Anda.
            </div>
        @endforelse
    </div>

</div>

<!-- Vanilla JS Toggle for Accordion Inspect Dropdowns -->
<script>
    function toggleInspect(detailId, chevronId) {
        const detailEl = document.getElementById(detailId);
        const chevronEl = document.getElementById(chevronId);
        if (detailEl) {
            const isHidden = detailEl.classList.contains('hidden');
            if (isHidden) {
                detailEl.classList.remove('hidden');
                if (chevronEl) chevronEl.classList.add('rotate-180');
            } else {
                detailEl.classList.add('hidden');
                if (chevronEl) chevronEl.classList.remove('rotate-180');
            }
        }
    }

    // Auto-open if URL has hash (e.g. #siswa-1)
    document.addEventListener('DOMContentLoaded', function () {
        if (window.location.hash) {
            const target = document.querySelector(window.location.hash);
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
                const btn = target.querySelector('button[onclick^="toggleInspect"]');
                if (btn) btn.click();
            }
        }
    });
</script>
@endsection
