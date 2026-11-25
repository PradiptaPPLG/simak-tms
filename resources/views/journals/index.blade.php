@extends('layouts.simak')

@section('title', 'Jurnal Kegiatan PKL • SIMAK-TMS')

@section('content')
<div class="space-y-6">

    <!-- Header Section (Hitam - Putih - Merah TMS) -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-xl sm:text-2xl font-black tracking-tight text-slate-900">Jurnal Kegiatan PKL</h1>
            <p class="text-xs text-slate-500 mt-0.5">Catat setiap aktivitas pengerjaan atau pembelajaran di industri secara mandiri.</p>
        </div>

        <div class="grid grid-cols-2 sm:flex sm:items-center gap-2 w-full sm:w-auto">
            <!-- Tombol Atur Jadwal Libur / Off-Shift -->
            <button type="button" onclick="openOffDaysModal()" class="px-3 py-2 bg-sky-50 border border-sky-200 hover:bg-sky-100 text-sky-800 text-xs font-bold rounded-xl transition-all shadow-xs flex items-center justify-center gap-1.5 cursor-pointer text-center" title="Atur Hari Libur Rutin DUDI / Shift Kerja">
                <i data-lucide="calendar-clock" class="w-4 h-4 text-sky-600 shrink-0"></i>
                <span class="truncate">Atur Hari Libur</span>
            </button>
            <a href="{{ route('journals.print') }}" target="_blank" class="px-3 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-xl transition-all shadow-xs flex items-center justify-center gap-1.5 cursor-pointer text-center">
                <i data-lucide="printer" class="w-4 h-4 text-slate-500 shrink-0"></i>
                <span class="truncate">Cetak Jurnal</span>
            </a>
            <a href="{{ route('journals.portfolio.print') }}" target="_blank" class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-red-600/25 flex items-center justify-center gap-1.5 text-center">
                <i data-lucide="book-open" class="w-4 h-4 shrink-0"></i>
                <span class="truncate">Cetak Portofolio</span>
            </a>
        </div>
    </div>

    <!-- Banner Peringatan jika Terdapat Jurnal yang Bertabrakan dengan Jadwal Libur -->
    @if(isset($conflictingJournals) && $conflictingJournals->isNotEmpty())
        <div class="p-4 sm:p-5 rounded-2xl bg-amber-50 border-2 border-amber-300 text-amber-950 space-y-3 shadow-xs">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center shrink-0 shadow-xs">
                        <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-xs font-black uppercase tracking-wider text-amber-950">
                            Ditemukan {{ $conflictingJournals->count() }} Jurnal Bertabrakan dengan Jadwal Hari Libur
                        </h3>
                        <p class="text-[11px] text-amber-800 mt-0.5">
                            Terdapat catatan logbook pada tanggal libur Anda: 
                            <b>{{ $conflictingJournals->map(fn($j) => \Carbon\Carbon::parse($j->journal_date)->translatedFormat('l, d M Y'))->implode('; ') }}</b>
                        </p>
                    </div>
                </div>

                <!-- Tombol Bersihkan Semua Konflik (Membuka Popup Konfirmasi 5 Detik) -->
                <button type="button" onclick="triggerConflictModalFromBanner()" class="px-4 py-2 bg-red-600 hover:bg-red-700 active:scale-98 text-white font-bold text-xs rounded-xl shadow-xs transition-all flex items-center gap-1.5 cursor-pointer">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                    <span>Hapus Jurnal yang Bertabrakan</span>
                </button>
            </div>
            <p class="text-xs text-amber-900/90 bg-white/80 p-3 rounded-xl border border-amber-200 leading-relaxed">
                Catatan logbook pada tanggal libur tersebut membuat bilah kalender presensi terlihat jomplang. Anda dapat membersihkannya sekaligus lewat tombol di atas, atau menghapusnya secara manual pada masing-masing tanggal.
            </p>
        </div>
    @endif

    <!-- 1. Interactive Monthly Calendar Grid (November 2026) -->
    <div class="mas-card p-4 sm:p-6">
        <!-- Calendar Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-5">
            <div class="flex items-center gap-2">
                <i data-lucide="calendar" class="w-5 h-5 text-red-600"></i>
                <h2 class="text-lg font-bold text-slate-800">November 2026</h2>
                <span class="px-2.5 py-0.5 rounded-lg bg-red-50 text-red-600 text-xs font-bold">Bulan Berjalan</span>
            </div>
            
            <div class="flex items-center gap-2 text-xs">
                @if($hasConfiguredOffDays)
                    <button type="button" onclick="openOffDaysModal()" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-sky-50 border border-sky-200 text-sky-800 font-semibold hover:bg-sky-100 transition-colors cursor-pointer" title="Klik untuk mengubah jadwal hari libur">
                        <i data-lucide="user-x" class="w-3.5 h-3.5 text-sky-600"></i>
                        <span>{{ $user->off_day_notes ?? (count($user->off_days_labels) > 0 ? 'Libur: ' . implode(', ', $user->off_days_labels) : 'Shift Fleksibel') }}</span>
                        <i data-lucide="sliders-horizontal" class="w-3 h-3 text-sky-500 ml-0.5"></i>
                    </button>
                @else
                    <button type="button" onclick="openOffDaysModal()" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-amber-50 border border-amber-300 text-amber-800 font-bold animate-pulse cursor-pointer">
                        <i data-lucide="alert-triangle" class="w-3.5 h-3.5 text-amber-600"></i>
                        <span>Klik untuk Set Hari Libur</span>
                    </button>
                @endif
            </div>
        </div>

        <!-- Days of Week (Senin s.d. Minggu) -->
        <div class="grid grid-cols-7 gap-2 text-center text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">
            <div>SEN</div>
            <div>SEL</div>
            <div>RAB</div>
            <div>KAM</div>
            <div>JUM</div>
            <div>SAB</div>
            <div>MIN</div>
        </div>

        <!-- Calendar Cells Grid (Format Proporsional Kompak Ala MAS-PKL) -->
        <div class="grid grid-cols-7 gap-1.5 sm:gap-2">
            {{-- 1 November 2026 is Sunday (col 7). Leading 6 empty cells for Oct 26-31 --}}
            @for($i = 0; $i < 6; $i++)
                <div class="h-11 sm:h-12 rounded-xl bg-slate-50/40 border border-slate-100/60 opacity-20"></div>
            @endfor

            {{-- Days 1 to 30 of November 2026 --}}
            @for($d = 1; $d <= 30; $d++)
                @php
                    $dayStr = sprintf('2026-11-%02d', $d);
                    $journal = $journalsByDate->get($dayStr);
                    $isSelected = ($selectedDate === $dayStr);
                    $isToday = ($dayStr === now()->toDateString());
                    $isPast = ($dayStr < now()->toDateString());
                    $isFuture = ($dayStr > now()->toDateString());
                    $isDateOff = $user->isOffDay($dayStr);
                    $isExpired = ($isPast && !$journal && !$isDateOff);
                @endphp

                @if($journal && !$isDateOff)
                    {{-- 1. JURNAL TERISI PADA HARI KERJA (HIJAU RESMI) --}}
                    <a href="{{ route('journals.index', ['date' => $dayStr]) }}#form-jurnal"
                       class="h-11 sm:h-12 rounded-xl flex flex-col items-center justify-center p-1 sm:p-1.5 transition-all cursor-pointer relative bg-emerald-50 border border-emerald-300 text-emerald-800 hover:bg-emerald-100/80 hover:shadow-xs
                              {{ $isSelected ? 'ring-2 ring-slate-900 ring-offset-2 z-10 scale-105 shadow-md' : 'hover:scale-102' }}"
                       title="Jurnal Terisi ({{ $dayStr }}). Klik untuk melihat/mengedit logbook.">
                        <span class="text-xs sm:text-sm font-black text-emerald-800 leading-none">{{ $d }}</span>
                        <div class="mt-1 flex items-center justify-center">
                            <i data-lucide="check-circle" class="w-3.5 h-3.5 text-emerald-600"></i>
                        </div>
                    </a>

                @elseif($journal && $isDateOff)
                    {{-- JURNAL BERTABRAKAN DI HARI LIBUR (Gambar 1 & 2) --}}
                    <a href="{{ route('journals.index', ['date' => $dayStr]) }}#form-jurnal"
                       class="h-11 sm:h-12 rounded-xl flex flex-col items-center justify-center p-1 sm:p-1.5 transition-all cursor-pointer relative bg-emerald-50 border-2 border-emerald-400 text-emerald-900 hover:bg-emerald-100/90 hover:shadow-xs
                              {{ $isSelected ? 'ring-2 ring-slate-900 ring-offset-2 z-10 scale-105 shadow-md' : 'hover:scale-102' }}"
                       title="Jurnal bertabrakan dengan hari libur ({{ $dayStr }}). Klik untuk melihat atau menghapus logbook agar kalender rapi.">
                        <span class="text-xs sm:text-sm font-black text-emerald-800 leading-none">{{ $d }}</span>
                        <div class="mt-1 flex items-center justify-center">
                            <i data-lucide="check-circle" class="w-3.5 h-3.5 text-emerald-600"></i>
                        </div>
                    </a>

                @elseif($isDateOff)
                    {{-- 2. HARI LIBUR / OFF SHIFT (BIRU DENGAN ICON USER-X - PERSIS SEPERTI GAMBAR USER) --}}
                    <a href="{{ route('journals.index', ['date' => $dayStr]) }}#form-jurnal"
                       class="h-11 sm:h-12 rounded-xl flex flex-col items-center justify-center p-1 sm:p-1.5 transition-all cursor-pointer relative bg-sky-50 border border-sky-200 text-sky-700 hover:bg-sky-100 hover:shadow-xs
                              {{ $isSelected ? 'ring-2 ring-sky-500 ring-offset-2 z-10 scale-105 shadow-md' : 'hover:scale-102' }}"
                       title="Hari Libur Rutin DUDI / Off Shift ({{ $dayStr }}).">
                        <span class="text-xs sm:text-sm font-black text-sky-600 leading-none">{{ $d }}</span>
                        <div class="mt-1 flex items-center justify-center">
                            <i data-lucide="user-x" class="w-3.5 h-3.5 text-sky-600"></i>
                        </div>
                    </a>

                @elseif($isToday)
                    {{-- 3. HARI INI (AKTIF UNTUK DIISI - ORANYE) --}}
                    <a href="{{ route('journals.index', ['date' => $dayStr]) }}#form-jurnal"
                       class="h-11 sm:h-12 rounded-xl flex flex-col items-center justify-center p-1 sm:p-1.5 transition-all cursor-pointer relative bg-amber-50 border-2 border-amber-500 text-amber-900 shadow-xs ring-2 ring-amber-500/20 hover:bg-amber-100/80
                              {{ $isSelected ? 'ring-2 ring-amber-600 ring-offset-2 z-10 scale-105 shadow-md' : 'hover:scale-102' }}"
                       title="Hari Ini ({{ $dayStr }}) - Klik untuk mengisi jurnal kegiatan aktif">
                        <span class="text-xs sm:text-sm font-black text-amber-900 leading-none">{{ $d }}</span>
                        <div class="mt-1 flex items-center justify-center">
                            <i data-lucide="edit-3" class="w-3.5 h-3.5 text-amber-600"></i>
                        </div>
                    </a>

                @elseif($isExpired)
                    {{-- 4. TERLEWAT + TIDAK DIISI (ABU-ABU, ICON ⛔ BAN, MOUSE DISABLE, TIDAK TRIGGER APAPUN) --}}
                    <div class="h-11 sm:h-12 rounded-xl flex flex-col items-center justify-center p-1 sm:p-1.5 bg-slate-100/70 border border-dashed border-slate-300 text-slate-400 opacity-60 cursor-not-allowed select-none relative"
                         title="Batas waktu terlewat (jurnal hari kerja tidak diisi). Pengisian dikunci untuk mencegah manipulasi tugas.">
                        <span class="text-xs sm:text-sm font-bold text-slate-400 leading-none">{{ $d }}</span>
                        <div class="mt-1 flex items-center justify-center">
                            <i data-lucide="ban" class="w-3.5 h-3.5 text-slate-400"></i>
                        </div>
                    </div>

                @else
                    {{-- 5. AKAN DATANG (BELUM TIBA WAKTUNYA) --}}
                    <div class="h-11 sm:h-12 rounded-xl flex flex-col items-center justify-center p-1 sm:p-1.5 bg-slate-50/50 border border-slate-200/60 text-slate-300 opacity-40 cursor-not-allowed select-none relative"
                         title="Belum tiba waktunya ({{ $dayStr }})">
                        <span class="text-xs sm:text-sm font-medium text-slate-400 leading-none">{{ $d }}</span>
                        <div class="mt-1 flex items-center justify-center">
                            <span class="text-xs font-bold text-slate-300 leading-none">-</span>
                        </div>
                    </div>
                @endif
            @endfor
        </div>

        <!-- Calendar Legend & Penjelasan Indikator Status -->
        <div class="mt-4 pt-3.5 border-t border-slate-100 flex flex-wrap items-center gap-4 text-xs">
            <div class="flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-emerald-50 border border-emerald-300 flex items-center justify-center text-emerald-700 shadow-2xs">
                    <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
                </span>
                <span class="text-slate-700"><b class="text-emerald-700">Hijau:</b> Jurnal Diisi</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-sky-50 border border-sky-200 flex items-center justify-center text-sky-600 shadow-2xs">
                    <i data-lucide="user-x" class="w-3.5 h-3.5 text-sky-600"></i>
                </span>
                <span class="text-slate-700"><b class="text-sky-600">Biru:</b> Hari Libur / Off Shift</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-amber-50 border border-amber-400 flex items-center justify-center text-amber-700 shadow-2xs">
                    <i data-lucide="edit-3" class="w-3.5 h-3.5 text-amber-600"></i>
                </span>
                <span class="text-slate-700"><b class="text-amber-700">Oranye:</b> Hari Ini</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-slate-100 border border-dashed border-slate-300 flex items-center justify-center text-slate-400">
                    <i data-lucide="ban" class="w-3.5 h-3.5 text-slate-400"></i>
                </span>
                <span class="text-slate-600"><b class="text-slate-500">Abu:</b> Terlewat / Terkunci</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-400">
                    <span class="text-xs font-bold text-slate-300">-</span>
                </span>
                <span class="text-slate-500">Akan Datang</span>
            </div>
        </div>
    </div>

    <!-- 2. Form Input / Edit Jurnal Kegiatan / Empty State Libur (#form-jurnal) -->
    <div id="form-jurnal" class="space-y-6">

        @if($isSelectedDateOff && $selectedJournal)
            <!-- ========================================================== -->
            <!-- KONDISI A: JURNAL BERTABRAKAN PADA HARI LIBUR              -->
            <!-- ========================================================== -->
            <div class="mas-card p-6 sm:p-8 border-2 border-amber-300 bg-amber-50/50 space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-amber-200/80 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-amber-500 text-white flex items-center justify-center shrink-0 shadow-md">
                            <i data-lucide="alert-triangle" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-base font-black text-amber-950">Jurnal Bertabrakan dengan Jadwal Libur</h3>
                                <span class="px-2.5 py-0.5 rounded-full bg-amber-200 text-amber-900 text-[10px] font-black uppercase">
                                    Konflik Jadwal
                                </span>
                            </div>
                            <p class="text-xs text-amber-800 mt-0.5">
                                Tanggal: <b>{{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('l, d F Y') }}</b>
                            </p>
                        </div>
                    </div>

                    <!-- Tombol Hapus Jurnal Ini -->
                    <form action="{{ route('journals.destroy', $selectedJournal->id) }}" method="POST" onsubmit="return confirm('Hapus catatan jurnal tanggal {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('d F Y') }} agar bilah kalender kembali seragam sebagai hari libur?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 active:scale-98 text-white font-bold text-xs rounded-xl shadow-md shadow-red-600/20 flex items-center gap-2 cursor-pointer transition-all">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                            <span>Hapus Jurnal Ini Agar Kalender Rapi</span>
                        </button>
                    </form>
                </div>

                <!-- Ringkasan Logbook yang Ada -->
                <div class="p-4 rounded-xl bg-white border border-amber-200 text-xs text-slate-800 space-y-1.5 shadow-2xs">
                    <div class="font-bold text-sm text-slate-900">{{ $selectedJournal->activity_title }}</div>
                    <p class="text-slate-600 leading-relaxed">{{ $selectedJournal->activity_detail }}</p>
                </div>

                <p class="text-xs text-amber-900/90 leading-relaxed">
                    Catatan logbook ini sebelumnya tercatat sebelum hari libur rutin ditetapkan. Anda dapat menghapus logbook ini dengan menekan tombol merah di atas agar bilah kalender hari Sabtu/Minggu tidak jomplang dan seragam berikon libur <span class="font-bold text-sky-700"><i data-lucide="user-x" class="w-3.5 h-3.5 inline"></i> Off Shift</span>.
                </p>
            </div>

        @elseif($isSelectedDateOff && !$selectedJournal)
            <!-- ========================================================== -->
            <!-- KONDISI B: HARI LIBUR BERSIH (PERSIS SEPERTI GAMBAR 3)      -->
            <!-- ========================================================== -->
            <div class="mas-card p-10 sm:p-14 text-center border-dashed border-2 border-slate-200/90 space-y-3">
                <div class="w-16 h-16 rounded-full bg-slate-50 border border-slate-200/80 flex items-center justify-center mx-auto mb-4 text-sky-500 shadow-2xs">
                    <i data-lucide="user-x" class="w-8 h-8"></i>
                </div>
                <h3 class="text-base sm:text-lg font-black text-slate-900 tracking-tight">
                    {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('l, d F Y') }}
                </h3>
                <p class="text-xs sm:text-sm text-slate-500 font-medium">
                    Anda sedang <b class="text-sky-600 font-bold uppercase tracking-wider">LIBUR</b> pada tanggal ini. Jurnal tidak wajib diisi.
                </p>

                <!-- Tombol Toggle Form Opsional -->
                <div class="pt-4">
                    <button type="button" onclick="document.getElementById('form-jurnal-card').classList.toggle('hidden')" 
                            class="text-xs text-slate-400 hover:text-sky-600 font-semibold underline transition-colors cursor-pointer">
                        Tetap ingin mencatat aktivitas mandiri / lembur? Klik di sini
                    </button>
                </div>
            </div>

        @endif

        <!-- Card Form Input / Edit Logbook (Hidden secara default jika hari libur kosong) -->
        <div id="form-jurnal-card" class="mas-card p-6 sm:p-8 space-y-6 {{ ($isSelectedDateOff && !$selectedJournal) ? 'hidden' : '' }}">
            
            <!-- Form Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4">
                <div>
                    <h2 class="text-xl font-black text-slate-900 tracking-tight">
                        {{ $selectedJournal ? 'Edit Jurnal Kegiatan' : ($isSelectedDateOff ? 'Catatan Aktivitas Mandiri / Libur' : 'Tulis Jurnal Kegiatan') }}
                    </h2>
                    <p class="text-xs text-slate-400 mt-0.5">Catatan aktivitas harian siswa PKL di PT. Teknologi Multi Sistem.</p>
                </div>

                <div>
                    @if($selectedJournal)
                        @if(!empty($selectedJournal->mentor_feedback))
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold">
                                <i data-lucide="check-circle" class="w-3.5 h-3.5 text-emerald-600"></i>
                                <span>Mentor Telah Memberi Catatan</span>
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-50 border border-red-200 text-red-700 text-xs font-bold">
                                <i data-lucide="clock" class="w-3.5 h-3.5 text-red-500"></i>
                                <span>Menunggu Catatan Mentor</span>
                            </span>
                        @endif
                    @elseif($isSelectedDateOff)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-sky-50 border border-sky-200 text-sky-800 text-xs font-bold">
                            <i data-lucide="user-x" class="w-3.5 h-3.5 text-sky-600"></i>
                            <span>Hari Libur / Off Shift</span>
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-semibold">
                            <i data-lucide="file-edit" class="w-3.5 h-3.5 text-slate-400"></i>
                            <span>Belum Ada Catatan</span>
                        </span>
                    @endif
                </div>
            </div>

            <!-- Feedback Card dari Mentor -->
            @if($selectedJournal && !empty($selectedJournal->mentor_feedback))
                <div class="p-4 rounded-2xl bg-emerald-50/80 border border-emerald-200 text-emerald-950 space-y-2.5 shadow-2xs">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center shadow-xs shrink-0 aspect-square">
                                <i data-lucide="message-square-quote" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <h3 class="text-xs font-black uppercase tracking-wider text-emerald-950">Catatan & Bimbingan Mentor Industri</h3>
                                <p class="text-[11px] text-emerald-700">Pembimbing: <b class="text-emerald-900">{{ $selectedJournal->mentor->name ?? 'Staff Mentor TMS' }}</b></p>
                            </div>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-200/80 text-emerald-900 text-[10px] font-black uppercase tracking-wider">
                            ✓ Catatan Tersedia
                        </span>
                    </div>
                    <div class="bg-white/90 rounded-xl p-3.5 border border-emerald-100 text-xs text-slate-800 leading-relaxed font-medium">
                        "{{ $selectedJournal->mentor_feedback }}"
                    </div>
                </div>
            @endif

            @php
                $isDateExpired = ($selectedDate < now()->toDateString() && !$selectedJournal && !$isSelectedDateOff);
                $isDateFuture = ($selectedDate > now()->toDateString());
                $isFormLocked = ($isDateExpired || $isDateFuture || !$hasConfiguredOffDays);
            @endphp

            <!-- Notice Belum Konfigurasi Hari Libur -->
            @if(!$hasConfiguredOffDays)
                <div class="p-4 rounded-2xl bg-amber-50 border-2 border-amber-300 text-amber-950 space-y-2.5">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center shrink-0 shadow-xs">
                                <i data-lucide="lock" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h3 class="text-xs font-black uppercase tracking-wider text-amber-950">Pengisian Jurnal Terkunci Sementara</h3>
                                <p class="text-[11px] text-amber-800">Anda belum menentukan jadwal hari libur rutin magang di DUDI.</p>
                            </div>
                        </div>
                        <button type="button" onclick="openOffDaysModal()" class="px-3.5 py-1.5 bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs rounded-xl shadow-xs transition-colors shrink-0 cursor-pointer">
                            Pilih Hari Libur Sekarang
                        </button>
                    </div>
                </div>
            @elseif($isDateExpired)
                <!-- Notice Terkunci jika Hari Kerja Terlewat -->
                <div class="p-4 rounded-2xl bg-slate-100/80 border border-dashed border-slate-300 text-slate-700 space-y-2">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-slate-200 text-slate-500 flex items-center justify-center shrink-0">
                            <i data-lucide="ban" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h3 class="text-xs font-black uppercase tracking-wider text-slate-800">Batas Waktu Pengisian Logbook Telah Ditutup</h3>
                            <p class="text-[11px] text-slate-500">Tanggal: <b>{{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('l, d F Y') }}</b></p>
                        </div>
                    </div>
                    <p class="text-xs text-slate-600 bg-white/70 p-3 rounded-xl border border-slate-200">
                        Pengisian jurnal untuk hari kerja aktif ini telah terkunci secara otomatis guna menjamin kedisiplinan industri dan mencegah manipulasi penumpukan tugas oleh siswa PKL. Silakan isi logbook untuk hari kerja aktif hari ini.
                    </p>
                </div>
            @elseif($isDateFuture)
                <div class="p-4 rounded-2xl bg-amber-50 border border-dashed border-amber-300 text-amber-900 space-y-2">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                            <i data-lucide="clock" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h3 class="text-xs font-black uppercase tracking-wider text-amber-900">Tanggal Masa Depan Belum Dibuka</h3>
                            <p class="text-[11px] text-amber-700">Tanggal: <b>{{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('l, d F Y') }}</b></p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Form Input -->
            <form action="{{ route('journals.store') }}" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="journal_date" value="{{ $selectedDate }}">

                <!-- Row 1: Tanggal Terpilih & Status Pengisian -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Tanggal Kegiatan</label>
                        <div class="flex items-center justify-between bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-800 font-bold">
                            <div class="flex items-center gap-2">
                                <i data-lucide="calendar" class="w-4 h-4 text-slate-700"></i>
                                <span>{{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('l, d F Y') }}</span>
                            </div>
                            <span class="text-[11px] text-slate-400 font-normal font-mono">({{ $selectedDate }})</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Status Pengisian</label>
                        <div class="flex items-center justify-between bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs">
                            <div class="flex items-center gap-2">
                                <i data-lucide="{{ $selectedJournal ? 'check-circle-2' : ($isSelectedDateOff ? 'user-x' : ($isDateExpired ? 'ban' : ($isDateFuture ? 'clock' : 'file-edit'))) }}" 
                                   class="w-4 h-4 {{ $selectedJournal ? 'text-emerald-600' : ($isSelectedDateOff ? 'text-sky-600' : ($isDateExpired ? 'text-slate-400' : ($isDateFuture ? 'text-amber-500' : 'text-slate-500'))) }}"></i>
                                <span class="font-bold {{ $selectedJournal ? 'text-emerald-700' : ($isSelectedDateOff ? 'text-sky-700' : ($isDateExpired ? 'text-slate-500' : ($isDateFuture ? 'text-amber-700' : 'text-slate-700'))) }}">
                                    {{ $selectedJournal ? 'Jurnal Sudah Diisi' : ($isSelectedDateOff ? 'Hari Libur / Off Shift (Tidak Wajib)' : ($isDateExpired ? 'Terkunci (Terlewat)' : ($isDateFuture ? 'Terkunci (Masa Depan)' : 'Belum Ada Jurnal'))) }}
                                </span>
                            </div>
                            <span class="text-[10px] {{ $selectedJournal ? 'bg-emerald-100 text-emerald-800' : ($isSelectedDateOff ? 'bg-sky-100 text-sky-800 border border-sky-200' : ($isDateExpired ? 'bg-slate-200 text-slate-500' : ($isDateFuture ? 'bg-amber-100 text-amber-800' : 'bg-slate-200 text-slate-600'))) }} font-bold px-2 py-0.5 rounded">
                                {{ $selectedJournal ? 'Tersimpan' : ($isSelectedDateOff ? 'Off Shift' : ($isDateExpired ? 'Terkunci' : ($isDateFuture ? 'Belum Buka' : 'Draft'))) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Row 2: Pekerjaan / Fitur yang Dikerjakan -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">
                        Pekerjaan / Fitur yang Dikerjakan 
                        @if($isSelectedDateOff)
                            <span class="text-[10px] text-sky-600 font-normal">(aktivitas mandiri / lembur opsional)</span>
                        @else
                            <span class="text-red-500">*</span>
                        @endif
                    </label>
                    <input type="text" name="activity_title" required {{ $isFormLocked ? 'disabled' : '' }}
                           value="{{ old('activity_title', $selectedJournal->activity_title ?? ($isSelectedDateOff && !$selectedJournal ? 'Aktivitas Belajar Mandiri & Eksplorasi Proyek' : '')) }}"
                           placeholder="Contoh: Implementasi modul autentikasi login & integrasi database logbook"
                           class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 {{ $isFormLocked ? 'bg-slate-100 cursor-not-allowed opacity-60' : '' }}">
                </div>

                <!-- Row 3: Dua Kolom (Dropzone Foto Bukti & Deskripsi Kegiatan/Catatan Harian) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    
                    <!-- Left: Foto Bukti Kegiatan Dropzone (Opsional) -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center justify-between">
                            <span>Foto Bukti Kegiatan</span>
                            <span class="text-[10px] font-semibold text-slate-400">(opsional)</span>
                        </label>
                        <div class="border-2 border-dashed border-slate-200 rounded-2xl p-7 flex flex-col items-center justify-center text-center hover:bg-slate-50 hover:border-slate-300 transition-colors {{ $isFormLocked ? 'cursor-not-allowed opacity-60' : 'cursor-pointer' }} group h-[calc(100%-24px)] min-h-[170px]">
                            <div class="w-11 h-11 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                                <i data-lucide="camera" class="w-5 h-5"></i>
                            </div>
                            <div class="text-xs font-bold text-slate-700">Unggah Foto Bukti Kegiatan</div>
                            <div class="text-[10px] text-slate-400 mt-0.5">JPG, PNG — screenshot koding, suasana lab, atau dokumen (opsional)</div>
                        </div>
                    </div>

                    <!-- Right: Deskripsi Kegiatan / Catatan Harian & Tautan Bukti (Drive/Git/Web) -->
                    <div class="space-y-3.5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center justify-between">
                                <span>Deskripsi Kegiatan / Catatan Harian <span class="text-red-500">*</span></span>
                                @if($isSelectedDateOff)
                                    <span class="text-[10px] text-sky-600 font-semibold">(opsional di hari libur)</span>
                                @endif
                            </label>
                            <textarea name="activity_detail" rows="4" required {{ $isFormLocked ? 'disabled' : '' }}
                                      placeholder="Tuliskan ringkasan aktivitas, fitur yang dikembangkan, alur kerja, atau catatan pembelajaran..."
                                      class="w-full bg-white border border-slate-200 rounded-xl p-3 text-xs text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 leading-relaxed {{ $isFormLocked ? 'bg-slate-100 cursor-not-allowed opacity-60' : '' }}">{{ old('activity_detail', $selectedJournal->activity_detail ?? ($isSelectedDateOff && !$selectedJournal ? 'Melakukan pembelajaran mandiri dan riset teknologi pendukung proyek di luar jam kerja industri.' : '')) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center justify-between">
                                <span>Tautan Bukti / Link Drive / Git</span>
                                <span class="text-[10px] font-semibold text-slate-400">(opsional)</span>
                            </label>
                            <input type="url" name="commit_url" {{ $isFormLocked ? 'disabled' : '' }}
                                   value="{{ old('commit_url', $selectedJournal->commit_url ?? '') }}"
                                   placeholder="https://drive.google.com/... atau https://github.com/..."
                                   class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 font-mono focus:ring-2 focus:ring-red-500/20 focus:border-red-500 {{ $isFormLocked ? 'bg-slate-100 cursor-not-allowed opacity-60' : '' }}">
                        </div>
                    </div>

                </div>

                <!-- Submit Button Footer -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-4 border-t border-slate-100">
                    <span class="text-xs text-slate-400">
                        @if(!$hasConfiguredOffDays)
                            Pengisian dikunci sementara. Tentukan hari libur rutin magang Anda di modal popup terlebih dahulu.
                        @elseif($isSelectedDateOff && !$selectedJournal)
                            Hari libur DUDI. Pengisian jurnal bersifat opsional untuk aktivitas mandiri.
                        @elseif($isDateExpired)
                            Pengisian untuk tanggal hari kerja ini ditutup. Hubungi mentor jika terdapat kendala teknis.
                        @elseif($isDateFuture)
                            Pengisian untuk tanggal ini belum dibuka. Silakan kembali pada hari kegiatan berlangsung.
                        @else
                            {{ $selectedJournal ? 'Perubahan akan memperbarui data jurnal untuk tanggal ' . \Carbon\Carbon::parse($selectedDate)->translatedFormat('d F Y') . '.' : 'Jurnal baru akan dicatat untuk tanggal ' . \Carbon\Carbon::parse($selectedDate)->translatedFormat('d F Y') . '.' }}
                        @endif
                    </span>

                    @if(!$isFormLocked)
                        <button type="submit" class="px-6 py-2.5 {{ $isSelectedDateOff ? 'bg-sky-600 hover:bg-sky-700 shadow-sky-600/25' : 'bg-red-600 hover:bg-red-700 shadow-red-600/25' }} active:scale-98 text-white font-bold text-xs rounded-xl shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer">
                            <i data-lucide="save" class="w-4 h-4"></i>
                            <span>{{ $selectedJournal ? 'Perbarui Jurnal Kegiatan' : ($isSelectedDateOff ? 'Simpan Catatan Mandiri / Libur' : 'Simpan Jurnal Baru') }}</span>
                        </button>
                    @elseif(!$hasConfiguredOffDays)
                        <button type="button" onclick="openOffDaysModal()" class="px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs transition-all shadow-sm flex items-center gap-2 cursor-pointer">
                            <i data-lucide="lock" class="w-4 h-4"></i>
                            <span>Pilih Hari Libur Untuk Buka Form</span>
                        </button>
                    @elseif($isDateFuture)
                        <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-700 font-bold text-xs cursor-not-allowed select-none">
                            <i data-lucide="clock" class="w-4 h-4"></i>
                            <span>Pengisian Terkunci (Tanggal Masa Depan)</span>
                        </div>
                    @else
                        <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-slate-100 border border-slate-200 text-slate-400 font-bold text-xs cursor-not-allowed select-none">
                            <i data-lucide="ban" class="w-4 h-4"></i>
                            <span>Pengisian Terkunci (Batas Waktu Terlewat)</span>
                        </div>
                    @endif
                </div>
            </form>
        </div>

    </div>

</div>

<!-- ============================================================== -->
<!-- MODAL: ATUR HARI LIBUR RUTIN DUDI & SHIFT KERJA                -->
<!-- ============================================================== -->
<style>
    @keyframes modalBackdropFadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes modalContentZoomIn {
        from {
            opacity: 0;
            transform: scale(0.93) translateY(14px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }
    .modal-backdrop-animate {
        animation: modalBackdropFadeIn 0.22s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    .modal-card-animate {
        animation: modalContentZoomIn 0.26s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
</style>

<div id="modal-jadwal-libur" class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs {{ !$hasConfiguredOffDays ? '' : 'hidden' }} items-center justify-center p-4 modal-backdrop-animate" style="position: fixed; inset: 0; z-index: 9999; display: {{ !$hasConfiguredOffDays ? 'flex' : 'none' }};">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 space-y-5 modal-card-animate" style="position: relative; z-index: 10000; margin: auto;">
        
        <!-- Modal Header -->
        <div class="flex items-center justify-between border-b border-slate-100 pb-3.5">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-sky-500 text-white flex items-center justify-center shadow-xs shrink-0">
                    <i data-lucide="calendar-clock" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-sm font-black text-slate-900">Atur Jadwal Hari Libur Rutin DUDI</h3>
                    <p class="text-[11px] text-slate-400">Sinkronisasi kalender kerja magang di PT. Teknologi Multi Sistem</p>
                </div>
            </div>
            @if($hasConfiguredOffDays)
                <button type="button" onclick="closeOffDaysModal()" class="w-8 h-8 rounded-xl hover:bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition-colors cursor-pointer">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            @endif
        </div>

        <form id="form-jadwal-libur" action="{{ route('journals.off_days.update') }}" method="POST" class="space-y-4" onsubmit="return handleOffDaysFormSubmit(event)">
            @csrf
            <input type="hidden" name="delete_conflicts" id="input-delete-conflicts" value="0">
            
            <div class="p-3.5 bg-sky-50/70 border border-sky-100 rounded-2xl text-xs text-sky-900 leading-relaxed">
                Pilih hari-hari ketika Anda <b>tidak bertugas di kantor / DUDI</b>. Hari libur yang dipilih akan otomatis ditandai dengan ikon <span class="inline-flex items-center gap-1 font-bold text-sky-700"><i data-lucide="user-x" class="w-3.5 h-3.5 inline"></i> Off Shift</span> dan tidak akan dihitung sebagai alpa/terlewat.
            </div>

            <!-- Preset Buttons -->
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Pilihan Cepat (Preset):</label>
                <div class="flex flex-wrap items-center gap-1.5">
                    <button type="button" onclick="setOffDaysPreset([6, 7], 'Libur Akhir Pekan (Sabtu & Minggu)')"
                            class="px-2.5 py-1 text-xs font-bold rounded-xl bg-slate-100 hover:bg-sky-500 hover:text-white text-slate-700 border border-slate-200 transition-colors cursor-pointer">
                        Sabtu &amp; Minggu (5 Hari Kerja)
                    </button>
                    <button type="button" onclick="setOffDaysPreset([7], 'Libur Hari Minggu Saja')"
                            class="px-2.5 py-1 text-xs font-bold rounded-xl bg-slate-100 hover:bg-sky-500 hover:text-white text-slate-700 border border-slate-200 transition-colors cursor-pointer">
                        Minggu Saja (6 Hari Kerja)
                    </button>
                    <button type="button" onclick="setOffDaysPreset([], 'Shift Rolling / Fleksibel')"
                            class="px-2.5 py-1 text-xs font-bold rounded-xl bg-slate-100 hover:bg-sky-500 hover:text-white text-slate-700 border border-slate-200 transition-colors cursor-pointer">
                        Shift Rolling / Tidak Tetap
                    </button>
                </div>
            </div>

            <!-- 7 Days Grid Pill Checkboxes -->
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Pilih Hari Libur (Senin - Minggu):</label>
                <div class="grid grid-cols-7 gap-1.5" id="routine-off-days-grid">
                    @php
                        $dayOptions = [
                            1 => 'Sen',
                            2 => 'Sel',
                            3 => 'Rab',
                            4 => 'Kam',
                            5 => 'Jum',
                            6 => 'Sab',
                            7 => 'Min',
                        ];
                    @endphp
                    @foreach($dayOptions as $num => $dayName)
                        <label class="cursor-pointer">
                            <input type="checkbox" name="routine_off_days[]" value="{{ $num }}" 
                                   {{ in_array($num, $routineOffDays) ? 'checked' : '' }}
                                   class="peer sr-only off-day-checkbox">
                            <span class="flex flex-col items-center justify-center py-2.5 rounded-xl text-xs font-bold border border-slate-200 bg-white text-slate-600 peer-checked:bg-sky-500 peer-checked:text-white peer-checked:border-sky-500 peer-checked:shadow-sm transition-all select-none">
                                <span>{{ $dayName }}</span>
                                <span class="text-[9px] font-normal opacity-75 mt-0.5">{{ $num >= 6 ? 'Weekend' : 'Weekday' }}</span>
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Keterangan Libur / Catatan Shift -->
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Keterangan / Pola Shift Kerja (Opsional):</label>
                <input type="text" id="off-day-notes-input" name="off_day_notes" 
                       value="{{ $user->off_day_notes ?? 'Libur Akhir Pekan (Sabtu & Minggu)' }}"
                       placeholder="Misal: Libur Akhir Pekan, Off Shift Rolling A, Shift 1"
                       class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 font-medium">
            </div>

            <!-- Modal Footer Buttons -->
            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                @if($hasConfiguredOffDays)
                    <button type="button" onclick="closeOffDaysModal()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors cursor-pointer">
                        Batal
                    </button>
                @endif
                <button type="submit" class="px-5 py-2 rounded-xl bg-sky-600 hover:bg-sky-700 active:scale-98 text-white text-xs font-bold transition-all shadow-md shadow-sky-600/20 flex items-center gap-1.5 cursor-pointer">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>Simpan Jadwal Hari Libur</span>
                </button>
            </div>
        </form>

    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL POPUP: KONFIRMASI HARI LIBUR & PEMBERSIHAN JURNAL        -->
<!-- ============================================================== -->
<div id="modal-confirm-conflict" class="fixed inset-0 bg-slate-950/75 backdrop-blur-xs hidden items-center justify-center p-4 modal-backdrop-animate" style="position: fixed; inset: 0; z-index: 9999; display: none;">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-100 space-y-4 modal-card-animate" style="position: relative; z-index: 10000; margin: auto;">
        
        <!-- Header: Alert Triangle Icon & Close X -->
        <div class="flex items-start justify-between gap-3">
            <div class="flex items-start gap-3">
                <div class="w-11 h-11 rounded-2xl bg-amber-100 text-amber-600 border border-amber-200 flex items-center justify-center shrink-0">
                    <i data-lucide="alert-triangle" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-slate-900 leading-snug">Jadwal Libur Nabrak Jurnal!</h3>
                    <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">
                        Hari libur yang Anda pilih bertabrakan dengan <b id="conflict-count-text" class="text-amber-700">0 jurnal</b> yang sudah terisi sebelumnya.
                    </p>
                </div>
            </div>
            <button type="button" onclick="cancelConflictAndBackToOffDays()" class="w-8 h-8 rounded-xl hover:bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition-colors cursor-pointer shrink-0">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Daftar Jurnal yang Bertabrakan (Scrollable List) -->
        <div class="p-3 bg-amber-50/70 border border-amber-200/80 rounded-2xl space-y-2">
            <div class="text-[10px] font-bold text-amber-900 uppercase tracking-wider flex items-center gap-1.5">
                <i data-lucide="calendar" class="w-3.5 h-3.5 text-amber-600"></i>
                <span>Jurnal yang bertabrakan:</span>
            </div>
            <div id="conflict-journals-list" class="space-y-1.5 max-h-36 overflow-y-auto pr-1 text-xs divide-y divide-amber-200/50">
                <!-- Dynamically populated by JS -->
            </div>
        </div>

        <!-- Penjelasan Opsi Tindakan -->
        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 text-slate-600 text-[11px] leading-relaxed">
            <span class="font-bold text-slate-800">Pilih tindakan yang Anda inginkan:</span>
            <ul class="list-disc pl-4 mt-1 space-y-1 text-slate-500">
                <li><b>Hapus Jurnal:</b> Jurnal di atas akan dihapus agar kalender seragam &amp; rapi menjadi hari libur (biru).</li>
                <li><b>Simpan Saja:</b> Jadwal libur disimpan, jurnal tetap aman dan tidak hilang.</li>
            </ul>
        </div>

        <!-- Tombol Aksi: Batal, Simpan Tanpa Hapus, Ya Hapus (dengan Countdown 5 Detik) -->
        <div class="space-y-2 pt-2 border-t border-slate-100">
            <div class="grid grid-cols-2 gap-2">
                <button type="button" onclick="cancelConflictAndBackToOffDays()" class="w-full py-2.5 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all text-center cursor-pointer">
                    Batal (Ubah Hari)
                </button>
                <button type="button" onclick="confirmSaveWithoutDelete()" class="w-full py-2.5 px-3 rounded-xl bg-sky-50 hover:bg-sky-100 border border-sky-200 text-sky-800 text-xs font-bold transition-all text-center cursor-pointer">
                    Simpan Saja (Aman)
                </button>
            </div>
            
            <button type="button" id="btn-confirm-delete-conflict" onclick="confirmSaveAndDelete()" disabled
                    class="w-full py-2.5 px-4 rounded-xl font-bold text-xs transition-all flex items-center justify-center gap-2 cursor-not-allowed opacity-60 bg-red-400 text-white shadow-xs">
                <i data-lucide="trash-2" class="w-4 h-4"></i>
                <span id="btn-confirm-delete-label">Ya, Hapus Jurnal Bertabrakan (5s)</span>
            </button>
        </div>

    </div>
</div>

<script>
    const userExistingJournals = {!! json_encode($journals->map(function($j) {
        $c = \Carbon\Carbon::parse($j->journal_date);
        return [
            'id' => $j->id,
            'date' => $c->toDateString(),
            'dayOfWeek' => $c->dayOfWeekIso,
            'formatted' => $c->translatedFormat('l, d F Y'),
            'title' => $j->activity_title ?? $j->activity_summary ?? 'Catatan Logbook'
        ];
    })) !!};

    let conflictCountdownInterval = null;
    let conflictCountdownSeconds = 5;

    function openOffDaysModal() {
        const modal = document.getElementById('modal-jadwal-libur');
        if (modal) {
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
        }
    }

    function closeOffDaysModal() {
        @if($hasConfiguredOffDays)
            const modal = document.getElementById('modal-jadwal-libur');
            if (modal) {
                modal.classList.add('hidden');
                modal.style.display = 'none';
            }
        @else
            alert('Silakan pilih dan simpan hari libur rutin Anda terlebih dahulu untuk membuka logbook.');
        @endif
    }

    function setOffDaysPreset(days, defaultNote = '') {
        const checkboxes = document.querySelectorAll('.off-day-checkbox');
        checkboxes.forEach(cb => {
            cb.checked = days.includes(parseInt(cb.value));
        });
        if (defaultNote) {
            const noteInput = document.getElementById('off-day-notes-input');
            if (noteInput) {
                noteInput.value = defaultNote;
            }
        }
    }

    function handleOffDaysFormSubmit(event) {
        // Cek hari apa saja yang dicentang
        const checkedDays = Array.from(document.querySelectorAll('#routine-off-days-grid .off-day-checkbox:checked'))
            .map(cb => parseInt(cb.value, 10));

        // Deteksi apakah ada jurnal yang bertabrakan dengan hari libur baru
        const conflicts = userExistingJournals.filter(j => checkedDays.includes(j.dayOfWeek));

        if (conflicts.length > 0) {
            event.preventDefault();
            openConflictModal(conflicts);
            return false;
        }

        // Jika tidak ada benturan jurnal, langsung submit dengan aman
        const input = document.getElementById('input-delete-conflicts');
        if (input) input.value = "0";
        return true;
    }

    function openConflictModal(conflicts) {
        // 1. Tutup modal jadwal libur terlebih dahulu agar tidak bertumpuk
        const offDaysModal = document.getElementById('modal-jadwal-libur');
        if (offDaysModal) {
            offDaysModal.classList.add('hidden');
            offDaysModal.style.display = 'none';
        }

        const modal = document.getElementById('modal-confirm-conflict');
        const countEl = document.getElementById('conflict-count-text');
        const listEl = document.getElementById('conflict-journals-list');
        const btn = document.getElementById('btn-confirm-delete-conflict');
        const label = document.getElementById('btn-confirm-delete-label');

        if (!modal) return;

        countEl.innerText = `${conflicts.length} jurnal`;
        
        // Render daftar jurnal yang bertabrakan
        listEl.innerHTML = conflicts.map(j => `
            <div class="pt-1.5 first:pt-0">
                <div class="flex items-center justify-between">
                    <span class="font-bold text-amber-950">${j.formatted}</span>
                    <span class="text-[10px] px-1.5 py-0.5 rounded bg-amber-200 text-amber-900 font-mono">ID #${j.id}</span>
                </div>
                <p class="text-[11px] text-amber-800 truncate mt-0.5">${j.title}</p>
            </div>
        `).join('');

        // Reset timer countdown 5 detik untuk tombol YA
        if (conflictCountdownInterval) {
            clearInterval(conflictCountdownInterval);
        }
        conflictCountdownSeconds = 5;
        btn.disabled = true;
        btn.className = "w-full py-2.5 px-4 rounded-xl font-bold text-xs transition-all flex items-center justify-center gap-2 cursor-not-allowed opacity-60 bg-red-400 text-white shadow-xs";
        label.innerText = `Ya, Hapus Jurnal Bertabrakan (${conflictCountdownSeconds}s)`;

        conflictCountdownInterval = setInterval(() => {
            conflictCountdownSeconds--;
            if (conflictCountdownSeconds > 0) {
                label.innerText = `Ya, Hapus Jurnal Bertabrakan (${conflictCountdownSeconds}s)`;
            } else {
                clearInterval(conflictCountdownInterval);
                conflictCountdownInterval = null;
                btn.disabled = false;
                btn.className = "w-full py-2.5 px-4 rounded-xl font-bold text-xs transition-all flex items-center justify-center gap-2 cursor-pointer bg-red-600 hover:bg-red-700 active:scale-98 text-white shadow-md shadow-red-600/25";
                label.innerText = "Ya, Hapus Jurnal Bertabrakan";
            }
        }, 1000);

        modal.classList.remove('hidden');
        modal.style.display = 'flex';
        if (window.lucide) lucide.createIcons();
    }

    function closeConflictModal() {
        if (conflictCountdownInterval) {
            clearInterval(conflictCountdownInterval);
            conflictCountdownInterval = null;
        }
        const modal = document.getElementById('modal-confirm-conflict');
        if (modal) {
            modal.classList.add('hidden');
            modal.style.display = 'none';
        }
    }

    function cancelConflictAndBackToOffDays() {
        closeConflictModal();
        // Buka kembali modal jadwal libur agar user dapat mengubah pilihan harinya
        const offDaysModal = document.getElementById('modal-jadwal-libur');
        if (offDaysModal) {
            offDaysModal.classList.remove('hidden');
            offDaysModal.style.display = 'flex';
        }
    }

    function confirmSaveWithoutDelete() {
        closeConflictModal();
        const input = document.getElementById('input-delete-conflicts');
        if (input) input.value = "0";
        const form = document.getElementById('form-jadwal-libur');
        if (form) form.submit();
    }

    function confirmSaveAndDelete() {
        closeConflictModal();
        const input = document.getElementById('input-delete-conflicts');
        if (input) input.value = "1";
        const form = document.getElementById('form-jadwal-libur');
        if (form) form.submit();
    }

    function triggerConflictModalFromBanner() {
        @if(isset($conflictingJournals) && $conflictingJournals->isNotEmpty())
            const conflicts = {!! json_encode($conflictingJournals->map(function($j) {
                $c = \Carbon\Carbon::parse($j->journal_date);
                return [
                    'id' => $j->id,
                    'date' => $c->toDateString(),
                    'dayOfWeek' => $c->dayOfWeekIso,
                    'formatted' => $c->translatedFormat('l, d F Y'),
                    'title' => $j->activity_title ?? $j->activity_summary ?? 'Catatan Logbook'
                ];
            })) !!};
            openConflictModal(conflicts);
        @endif
    }
</script>
@endsection
