@extends('layouts.simak')

@section('title', 'Siswa Bimbingan & Monitoring Performa • SIMAK-TMS')

@section('content')
<div class="space-y-6">

    <!-- Page Heading -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900">Siswa Bimbingan & Monitoring Performa</h1>
            <p class="text-xs text-slate-500 mt-0.5">Pantau performa koding, rekapitulasi logbook jurnal harian, dan karya portofolio siswa bimbingan Anda.</p>
        </div>

        <div class="flex items-center gap-2 flex-wrap sm:flex-nowrap w-full sm:w-auto no-print">
            <!-- Green Export Button (Opens Format Choice Modal) -->
            <button type="button" onclick="openExportModal()" class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-emerald-600/25 flex items-center justify-center gap-1.5 text-center shrink-0 cursor-pointer" title="Unduh Berkas Spreadsheet Data Siswa Bimbingan (Excel / CSV)">
                <i data-lucide="file-spreadsheet" class="w-4 h-4 text-emerald-100 shrink-0"></i>
                <span>Ekspor Excel / CSV</span>
                <i data-lucide="chevron-down" class="w-3 h-3 text-emerald-200 shrink-0"></i>
            </button>

            <!-- Cetak Rekap Button -->
            <button type="button" onclick="window.print()" class="px-3.5 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-xl transition-all shadow-xs flex items-center justify-center gap-1.5 text-center shrink-0 cursor-pointer" title="Cetak Rekap / Simpan PDF">
                <i data-lucide="printer" class="w-4 h-4 text-slate-500 shrink-0"></i>
                <span>Cetak Rekap</span>
            </button>

            <!-- Date Pill -->
            <div class="bg-white border border-slate-200 px-3.5 py-1.5 rounded-xl text-xs font-semibold text-slate-700 hidden md:flex items-center gap-2 shadow-xs shrink-0">
                <i data-lucide="calendar" class="w-4 h-4 text-red-600"></i>
                <span>{{ now()->translatedFormat('l, d F Y') }}</span>
            </div>

            <!-- Validasi Jurnal Button -->
            <a href="{{ route('mentor.review') }}" class="px-4 py-2 bg-slate-900 hover:bg-black text-white text-xs font-bold rounded-xl transition-all shadow-xs flex items-center justify-center gap-2 shrink-0">
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
                                <h3 class="text-sm font-black text-slate-900">{{ $student->name }} <span class="font-mono text-red-600 font-bold text-xs">({{ $student->account_id ?? 'belum terdaftar' }})</span></h3>
                                @php
                                    $todayJournal = $student->journals->first(function($j) {
                                        return \Carbon\Carbon::parse($j->journal_date)->isToday();
                                    });
                                @endphp
                                @if($todayJournal)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span>
                                        Check-in {{ $todayJournal->created_at->format('H:i') }} WIB
                                    </span>
                                @elseif($student->isOffDay(now()))
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-sky-50 text-sky-700 text-[10px] font-bold border border-sky-200">
                                        <i data-lucide="user-x" class="w-3 h-3 text-sky-600"></i>
                                        Hari Libur / Off Shift
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-slate-100 text-slate-500 text-[10px] font-semibold border border-slate-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        Belum Check-in Hari Ini
                                    </span>
                                @endif
                            </div>
                            <div class="text-[11px] text-slate-400 font-mono mt-0.5">
                                <span>ID: {{ $student->account_id ?? 'Menunggu Mentor' }}</span>
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
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Validasi Logbook Harian</div>
                            <div class="text-lg font-black text-slate-900 font-mono mt-0.5">
                                {{ $student->journals->where('status', 'approved')->count() }} <span class="text-xs font-normal text-slate-400">Disetujui</span>
                            </div>
                            <div class="text-[10px] text-slate-500 font-medium mt-1">
                                Dari total <strong class="text-slate-800">{{ $student->journals->count() }}</strong> diajukan
                                @if($student->journals->where('status', 'pending')->count() > 0)
                                    <span class="text-amber-600 font-bold">({{ $student->journals->where('status', 'pending')->count() }} review)</span>
                                @elseif($student->journals->count() > 0)
                                    <span class="text-emerald-600 font-bold">(100% ACC)</span>
                                @endif
                            </div>
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
                            @if($todayJournal)
                                <div class="text-lg font-black text-slate-900 font-mono mt-0.5">
                                    {{ $todayJournal->created_at->format('H.i') }} <span class="text-xs font-normal text-slate-400">WIB</span>
                                </div>
                                <div class="text-[10px] {{ $todayJournal->created_at->format('H:i') <= '08:00' ? 'text-emerald-600' : 'text-amber-600' }} font-semibold mt-1">
                                    {{ $todayJournal->created_at->format('H:i') <= '08:00' ? '✓ Tepat Waktu (Hari Kerja)' : 'Terlambat (> 08:00 WIB)' }}
                                </div>
                            @elseif($student->isOffDay(now()))
                                <div class="text-base font-bold text-sky-600 font-mono mt-0.5">
                                    --.-- <span class="text-xs font-normal text-sky-500">WIB</span>
                                </div>
                                <div class="text-[10px] text-sky-600 font-medium mt-1">Hari Libur / Off Shift DUDI</div>
                            @else
                                <div class="text-base font-bold text-slate-400 font-mono mt-0.5">
                                    --.-- <span class="text-xs font-normal text-slate-400">WIB</span>
                                </div>
                                <div class="text-[10px] text-slate-400 font-medium mt-1">Belum Isi Jurnal Hari Ini</div>
                            @endif
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
                                                @if(!empty($journal->mentor_feedback))
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-bold text-[10px]">
                                                        <i data-lucide="check" class="w-3 h-3"></i> Ada Catatan Mentor
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-red-100 text-red-700 font-bold text-[10px]">
                                                        <i data-lucide="clock" class="w-3 h-3"></i> Belum Diberi Catatan
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div>
                                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Deskripsi Kegiatan / Catatan Siswa:</div>
                                            <p class="text-xs text-slate-700 leading-relaxed">{{ $journal->activity_detail }}</p>
                                        </div>

                                        @if(!empty($journal->mentor_feedback))
                                            <div class="p-2.5 rounded-lg bg-emerald-50/80 border border-emerald-200 text-emerald-900 text-xs space-y-0.5">
                                                <div class="text-[10px] font-bold text-emerald-700 uppercase tracking-wider">Catatan Pembimbing:</div>
                                                <p class="font-medium text-emerald-950">"{{ $journal->mentor_feedback }}"</p>
                                            </div>
                                        @endif

                                        <div class="flex items-center justify-end pt-1">
                                            <a href="{{ route('mentor.review') }}" class="text-[11px] text-red-600 font-bold hover:underline flex items-center gap-1">
                                                <i data-lucide="edit-3" class="w-3 h-3"></i>
                                                <span>{{ !empty($journal->mentor_feedback) ? 'Edit Catatan di Review Hub' : 'Sisipkan Catatan di Review Hub' }}</span>
                                            </a>
                                        </div>
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
                        @if(!empty($student->account_id))
                            <a href="{{ $student->profile_url }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-white border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 transition-colors flex items-center gap-1.5 shadow-2xs">
                                <svg class="w-3.5 h-3.5 fill-current shrink-0 text-slate-900" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/></svg>
                                <span>Profil Developer Siswa</span>
                            </a>
                        @else
                            <button type="button" onclick="alert('Profil siswa {{ addslashes($student->name) }} belum dapat dibuka karena siswa belum terdaftar resmi.')" class="px-3 py-1.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-400 text-xs font-semibold cursor-not-allowed opacity-60 flex items-center gap-1.5 shadow-2xs" title="Siswa belum terdaftar resmi">
                                <i data-lucide="user-x" class="w-3.5 h-3.5 text-slate-400"></i>
                                <span>Profil Belum Tersedia</span>
                            </button>
                        @endif
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

    <!-- TABLE KHUSUS CETAK DOKUMEN / PRINT REKAP RESMI PT. TMS -->
    <div class="print-header mt-4">
        <div style="margin-bottom: 12px;">
            <h2 style="font-size: 13pt; font-weight: 900; margin: 0; color: #0f172a; text-transform: uppercase;">Laporan Monitoring & Rekapitulasi Siswa Bimbingan</h2>
            <div style="font-size: 8.5pt; color: #64748b; margin-top: 2px;">
                <span>Pembimbing Industri: <b>{{ $mentor->name }}</b></span> &bull; 
                <span>Dicetak: {{ now()->translatedFormat('d F Y, H:i') }} WIB</span>
            </div>
        </div>

        <table style="width: 100%; border-collapse: collapse; font-size: 8pt; margin-top: 8px;">
            <thead>
                <tr style="background: #f1f5f9;">
                    <th style="border: 1px solid #cbd5e1; padding: 6px 4px; text-align: center; width: 28px;">No</th>
                    <th style="border: 1px solid #cbd5e1; padding: 6px; text-align: left;">ID Akun</th>
                    <th style="border: 1px solid #cbd5e1; padding: 6px; text-align: left;">Nama Siswa</th>
                    <th style="border: 1px solid #cbd5e1; padding: 6px; text-align: left;">Sekolah Asal & Jurusan</th>
                    <th style="border: 1px solid #cbd5e1; padding: 6px; text-align: center;">Status</th>
                    <th style="border: 1px solid #cbd5e1; padding: 6px; text-align: center;">Logbook</th>
                    <th style="border: 1px solid #cbd5e1; padding: 6px; text-align: center;">Proyek</th>
                    <th style="border: 1px solid #cbd5e1; padding: 6px; text-align: center;">Teknis</th>
                    <th style="border: 1px solid #cbd5e1; padding: 6px; text-align: center;">Disiplin</th>
                    <th style="border: 1px solid #cbd5e1; padding: 6px; text-align: center;">Tim</th>
                    <th style="border: 1px solid #cbd5e1; padding: 6px; text-align: center;">Inisiatif</th>
                    <th style="border: 1px solid #cbd5e1; padding: 6px; text-align: center;">Nilai</th>
                    <th style="border: 1px solid #cbd5e1; padding: 6px; text-align: center;">Predikat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $idx => $s)
                    @php $e = $s->evaluation; @endphp
                    <tr>
                        <td style="border: 1px solid #cbd5e1; padding: 5px 4px; text-align: center;">{{ $idx + 1 }}</td>
                        <td style="border: 1px solid #cbd5e1; padding: 5px; font-family: monospace;">{{ $s->account_id ?? '-' }}</td>
                        <td style="border: 1px solid #cbd5e1; padding: 5px; font-weight: bold;">{{ $s->name }}</td>
                        <td style="border: 1px solid #cbd5e1; padding: 5px;">{{ $s->school_origin ?? 'SMKN 1 Ciamis' }} ({{ $s->major ?? 'PPLG' }})</td>
                        <td style="border: 1px solid #cbd5e1; padding: 5px; text-align: center;">{{ ucfirst($s->status ?? 'Aktif') }}</td>
                        <td style="border: 1px solid #cbd5e1; padding: 5px; text-align: center;">{{ $s->journals->count() }}</td>
                        <td style="border: 1px solid #cbd5e1; padding: 5px; text-align: center;">{{ $s->showcaseProjects ? $s->showcaseProjects->count() : 0 }}</td>
                        <td style="border: 1px solid #cbd5e1; padding: 5px; text-align: center;">{{ $e ? $e->technical_skill : '-' }}</td>
                        <td style="border: 1px solid #cbd5e1; padding: 5px; text-align: center;">{{ $e ? $e->discipline : '-' }}</td>
                        <td style="border: 1px solid #cbd5e1; padding: 5px; text-align: center;">{{ $e ? $e->teamwork : '-' }}</td>
                        <td style="border: 1px solid #cbd5e1; padding: 5px; text-align: center;">{{ $e ? $e->initiative : '-' }}</td>
                        <td style="border: 1px solid #cbd5e1; padding: 5px; text-align: center; font-weight: bold;">{{ $e ? number_format($e->final_score, 1) : '-' }}</td>
                        <td style="border: 1px solid #cbd5e1; padding: 5px; text-align: center; font-weight: bold;">{{ $e ? ($e->grade ?? ($e->final_score >= 85 ? 'A' : 'B')) : '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="13" style="border: 1px solid #cbd5e1; padding: 12px; text-align: center;">Belum ada siswa bimbingan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- MODAL PILIH FORMAT EKSPOR MENTOR (EXCEL / CSV) -->
    <div id="modal-export-student" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl border border-slate-200 overflow-hidden transform transition-all animate-in fade-in zoom-in-95 duration-150">
            <!-- Modal Header -->
            <div class="p-6 pb-4 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center shrink-0">
                        <i data-lucide="file-spreadsheet" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-black text-slate-900">Ekspor Data Siswa Bimbingan</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Unduh berkas rekapitulasi progres & rapor bimbingan:</p>
                    </div>
                </div>
                <button type="button" onclick="closeExportModal()" class="w-8 h-8 rounded-xl hover:bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition-colors">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            <!-- Modal Body: Choices -->
            <div class="p-6 space-y-3">
                <!-- Option 1: Microsoft Excel (.xls) -->
                <a href="{{ route('mentor.students.export', array_merge(request()->query(), ['format' => 'excel'])) }}" 
                   onclick="closeExportModal()"
                   class="group p-4 rounded-2xl border-2 border-emerald-100 hover:border-emerald-500 bg-emerald-50/40 hover:bg-emerald-50 transition-all flex items-start gap-3.5 block text-left">
                    <div class="w-11 h-11 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-black text-xs shrink-0 shadow-md shadow-emerald-600/20 group-hover:scale-105 transition-transform">
                        XLS
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-2">
                            <h4 class="text-xs font-bold text-slate-900 group-hover:text-emerald-700 transition-colors">Microsoft Excel (.xls)</h4>
                            <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-full">Rekomendasi</span>
                        </div>
                        <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">
                            Format spreadsheet resmi lengkap dengan warna header TMS, border rapi, kolom 4 pilar nilai, dan jumlah logbook. Siap dibuka di MS Excel & WPS.
                        </p>
                    </div>
                    <i data-lucide="download" class="w-4 h-4 text-emerald-600 shrink-0 mt-1 opacity-60 group-hover:opacity-100 group-hover:translate-y-0.5 transition-all"></i>
                </a>

                <!-- Option 2: CSV Universal (.csv) -->
                <a href="{{ route('mentor.students.export', array_merge(request()->query(), ['format' => 'csv'])) }}" 
                   onclick="closeExportModal()"
                   class="group p-4 rounded-2xl border-2 border-slate-200 hover:border-slate-800 bg-slate-50/50 hover:bg-slate-100 transition-all flex items-start gap-3.5 block text-left">
                    <div class="w-11 h-11 rounded-xl bg-slate-800 text-white flex items-center justify-center font-black text-xs shrink-0 shadow-md shadow-slate-800/20 group-hover:scale-105 transition-transform">
                        CSV
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-2">
                            <h4 class="text-xs font-bold text-slate-900 group-hover:text-black transition-colors">Comma Separated Values (.csv)</h4>
                            <span class="text-[10px] font-bold text-slate-600 bg-slate-200 px-2 py-0.5 rounded-full">Universal</span>
                        </div>
                        <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">
                            Format data teks terpisah koma dengan UTF-8 BOM. Sangat cocok untuk backup arsip, Google Sheets, atau integrasi data.
                        </p>
                    </div>
                    <i data-lucide="download" class="w-4 h-4 text-slate-600 shrink-0 mt-1 opacity-60 group-hover:opacity-100 group-hover:translate-y-0.5 transition-all"></i>
                </a>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-3.5 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                <span>Klik opsi untuk langsung mengunduh</span>
                <button type="button" onclick="closeExportModal()" class="px-3 py-1.5 rounded-xl font-bold text-slate-600 hover:bg-slate-200 transition-colors">
                    Batal
                </button>
            </div>
        </div>
    </div>

</div>

<!-- Vanilla JS Toggle for Accordion Inspect Dropdowns -->
<script>
    function openExportModal() {
        const m = document.getElementById('modal-export-student');
        if (m) {
            m.classList.remove('hidden');
            m.classList.add('flex');
            if (window.lucide) lucide.createIcons();
        }
    }

    function closeExportModal() {
        const m = document.getElementById('modal-export-student');
        if (m) {
            m.classList.add('hidden');
            m.classList.remove('flex');
        }
    }

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
