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

                @if($journal)
                    {{-- 1. JURNAL TERISI (HIJAU RESMI) --}}
                    <a href="{{ route('journals.index', ['date' => $dayStr]) }}#form-jurnal"
                       class="h-11 sm:h-12 rounded-xl flex flex-col items-center justify-center p-1 sm:p-1.5 transition-all cursor-pointer relative bg-emerald-50 border border-emerald-300 text-emerald-800 hover:bg-emerald-100/80 hover:shadow-xs
                              {{ $isSelected ? 'ring-2 ring-slate-900 ring-offset-2 z-10 scale-105 shadow-md' : 'hover:scale-102' }}"
                       title="Jurnal Terisi ({{ $dayStr }}). Klik untuk melihat/mengedit logbook.">
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
                       title="Hari Libur Rutin DUDI / Off Shift ({{ $dayStr }}). Klik untuk melihat keterangan atau mencatat aktivitas mandiri.">
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

    <!-- 2. Form Input / Edit Jurnal Kegiatan (#form-jurnal) -->
    <div id="form-jurnal" class="mas-card p-6 sm:p-8 space-y-6">
        
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

        <!-- Feedback Card dari Mentor (Jika Mentor telah menyisipkan catatan) -->
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
                <p class="text-[11px] text-emerald-700 flex items-center gap-1.5 pt-0.5">
                    <i data-lucide="pencil-line" class="w-3.5 h-3.5"></i>
                    <span>Catatan pembimbing bersifat arahan. Anda tetap dapat memperbarui deskripsi kegiatan atau commit git Anda di bawah ini jika diperlukan.</span>
                </p>
            </div>
        @elseif($selectedJournal && empty($selectedJournal->mentor_feedback))
            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-slate-700 text-xs flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <span class="font-bold">Status Logbook:</span>
                        <span class="text-slate-600"> Jurnal harian tanggal ini telah terisi dan tersimpan.</span>
                    </div>
                </div>
                <span class="text-[10px] bg-emerald-100 text-emerald-800 font-bold px-2.5 py-1 rounded-full border border-emerald-200">
                    Jurnal Terisi
                </span>
            </div>
        @endif

        @php
            $isDateExpired = ($selectedDate < now()->toDateString() && !$selectedJournal && !$isSelectedDateOff);
            $isDateFuture = ($selectedDate > now()->toDateString());
            $isFormLocked = ($isDateExpired || $isDateFuture || !$hasConfiguredOffDays);
        @endphp

        <!-- Notice Belum Konfigurasi Hari Libur (Penguncian Awal Logika Ala MAS-PKL) -->
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
                <p class="text-xs text-amber-900 bg-white/80 p-3 rounded-xl border border-amber-200 leading-relaxed">
                    Sesuai POS magang industri, siswa wajib menentukan jadwal hari libur kerja rutin (misal: <b>Sabtu &amp; Minggu</b>) sebelum dapat mengisi logbook harian. Silakan klik tombol di atas untuk memilih hari libur Anda.
                </p>
            </div>
        @elseif($isSelectedDateOff && !$selectedJournal)
            <!-- Notice Khusus Hari Libur Rutin DUDI / Off Shift -->
            <div class="p-4 rounded-2xl bg-sky-50 border border-sky-200 text-sky-950 space-y-2.5 shadow-2xs">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-sky-500 text-white flex items-center justify-center shrink-0 shadow-xs">
                            <i data-lucide="user-x" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-xs font-black uppercase tracking-wider text-sky-950">Jadwal Hari Libur DUDI / Off Shift</h3>
                                <span class="px-2.5 py-0.5 rounded-full bg-sky-200 text-sky-900 text-[10px] font-black uppercase">
                                    {{ $user->off_day_notes ?? 'Off Shift' }}
                                </span>
                            </div>
                            <p class="text-[11px] text-sky-700 mt-0.5">Tanggal: <b>{{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('l, d F Y') }}</b></p>
                        </div>
                    </div>
                    <button type="button" onclick="openOffDaysModal()" class="text-xs text-sky-600 hover:text-sky-800 font-bold hover:underline flex items-center gap-1 cursor-pointer">
                        <i data-lucide="sliders-horizontal" class="w-3.5 h-3.5"></i>
                        <span>Ubah Jadwal</span>
                    </button>
                </div>
                <p class="text-xs text-sky-900 bg-white/80 p-3 rounded-xl border border-sky-100 leading-relaxed">
                    Hari ini merupakan jadwal libur rutin magang atau off-shift kerja Anda di <b>PT. Teknologi Multi Sistem</b>. Siswa <b>tidak diwajibkan</b> mengisi logbook harian industri pada hari libur. Namun bila Anda melaksanakan kegiatan pembelajaran mandiri, sertifikasi, riset teknologi, atau pengerjaan proyek, Anda tetap diperbolehkan mencatat aktivitas di form bawah ini.
                </p>
            </div>
        @elseif($isDateExpired)
            <!-- Notice Terkunci jika Hari Kerja Terlewat & Belum Pernah Diisi -->
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
                    Pengisian jurnal untuk hari kerja aktif ini telah terkunci secara otomatis guna menjamin kedisiplinan industri dan mencegah kecurangan penumpukan tugas oleh siswa PKL. Silakan isi logbook untuk hari kerja aktif hari ini.
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
                <p class="text-xs text-amber-800 bg-white/70 p-3 rounded-xl border border-amber-200">
                    Jurnal kegiatan harian hanya dapat diisi pada hari kerja yang sedang berjalan atau hari ini. Siswa PKL tidak diperkenankan mencicil atau mengisi logbook untuk hari masa depan demi menjaga integritas data industri.
                </p>
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
                        <span class="text-[10px] text-sky-600 font-normal">(kegiatan mandiri / lembur / riset teknologi)</span>
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
                        <p class="text-[10px] text-slate-400 mt-1">Bisa menyematkan link folder Google Drive, repository GitHub, commit git, Figma, atau dokumen lainnya.</p>
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

<!-- ============================================================== -->
<!-- MODAL: ATUR HARI LIBUR RUTIN DUDI & SHIFT KERJA                -->
<!-- ============================================================== -->
<div id="modal-jadwal-libur" class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs z-50 {{ !$hasConfiguredOffDays ? '' : 'hidden' }} flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 space-y-5 animate-in fade-in zoom-in-95 duration-200">
        
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

        <form action="{{ route('journals.off_days.update') }}" method="POST" class="space-y-4">
            @csrf
            
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

<script>
    function openOffDaysModal() {
        const modal = document.getElementById('modal-jadwal-libur');
        if (modal) {
            modal.classList.remove('hidden');
        }
    }

    function closeOffDaysModal() {
        @if($hasConfiguredOffDays)
            const modal = document.getElementById('modal-jadwal-libur');
            if (modal) {
                modal.classList.add('hidden');
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
</script>
@endsection
