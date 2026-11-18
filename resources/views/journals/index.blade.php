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
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center gap-2">
                <i data-lucide="calendar" class="w-5 h-5 text-red-600"></i>
                <h2 class="text-lg font-bold text-slate-800">November 2026</h2>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-lg bg-red-50 text-red-600 text-xs font-bold">Bulan Berjalan</span>
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
                    $isExpired = ($isPast && !$journal);
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

                @elseif($isToday)
                    {{-- 2. HARI INI (AKTIF UNTUK DIISI - ORANYE) --}}
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
                    {{-- 3. TERLEWAT + TIDAK DIISI (ABU-ABU, ICON ⛔ BAN, MOUSE DISABLE, TIDAK TRIGGER APAPUN) --}}
                    <div class="h-11 sm:h-12 rounded-xl flex flex-col items-center justify-center p-1 sm:p-1.5 bg-slate-100/70 border border-dashed border-slate-300 text-slate-400 opacity-60 cursor-not-allowed select-none relative"
                         title="Batas waktu terlewat (jurnal tidak diisi). Pengisian dikunci untuk mencegah manipulasi tugas.">
                        <span class="text-xs sm:text-sm font-bold text-slate-400 leading-none">{{ $d }}</span>
                        <div class="mt-1 flex items-center justify-center">
                            <i data-lucide="ban" class="w-3.5 h-3.5 text-slate-400"></i>
                        </div>
                    </div>

                @else
                    {{-- 4. AKAN DATANG (BELUM TIBA WAKTUNYA) --}}
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
                    {{ $selectedJournal ? 'Edit Jurnal Kegiatan' : 'Tulis Jurnal Kegiatan' }}
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
            $isDateExpired = ($selectedDate < now()->toDateString() && !$selectedJournal);
            $isDateFuture = ($selectedDate > now()->toDateString());
            $isFormLocked = ($isDateExpired || $isDateFuture);
        @endphp

        <!-- Notice Terkunci jika Tanggal Terlewat & Belum Pernah Diisi (Mencegah Kecurangan Numpuk Tugas) -->
        @if($isDateExpired)
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
                    Pengisian jurnal untuk tanggal ini telah terkunci secara otomatis guna menjamin kedisiplinan industri dan mencegah kecurangan penumpukan tugas oleh siswa PKL. Silakan isi logbook untuk hari kerja aktif hari ini.
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
                            <i data-lucide="{{ $selectedJournal ? 'check-circle-2' : ($isDateExpired ? 'ban' : ($isDateFuture ? 'clock' : 'file-edit')) }}" class="w-4 h-4 {{ $selectedJournal ? 'text-emerald-600' : ($isDateExpired ? 'text-slate-400' : ($isDateFuture ? 'text-amber-500' : 'text-slate-500')) }}"></i>
                            <span class="font-bold {{ $selectedJournal ? 'text-emerald-700' : ($isDateExpired ? 'text-slate-500' : ($isDateFuture ? 'text-amber-700' : 'text-slate-700')) }}">
                                {{ $selectedJournal ? 'Jurnal Sudah Diisi' : ($isDateExpired ? 'Terkunci (Terlewat)' : ($isDateFuture ? 'Terkunci (Masa Depan)' : 'Belum Ada Jurnal')) }}
                            </span>
                        </div>
                        <span class="text-[10px] {{ $selectedJournal ? 'bg-emerald-100 text-emerald-800' : ($isDateExpired ? 'bg-slate-200 text-slate-500' : ($isDateFuture ? 'bg-amber-100 text-amber-800' : 'bg-slate-200 text-slate-600')) }} font-bold px-2 py-0.5 rounded">
                            {{ $selectedJournal ? 'Tersimpan' : ($isDateExpired ? 'Terkunci' : ($isDateFuture ? 'Belum Buka' : 'Draft')) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Row 2: Pekerjaan / Fitur yang Dikerjakan -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Pekerjaan / Fitur yang Dikerjakan <span class="text-red-500">*</span></label>
                <input type="text" name="activity_title" required {{ $isFormLocked ? 'disabled' : '' }}
                       value="{{ old('activity_title', $selectedJournal->activity_title ?? '') }}"
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
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi Kegiatan / Catatan Harian <span class="text-red-500">*</span></label>
                        <textarea name="activity_detail" rows="4" required {{ $isFormLocked ? 'disabled' : '' }}
                                  placeholder="Tuliskan ringkasan aktivitas, fitur yang dikembangkan, alur kerja, atau catatan pembelajaran hari ini..."
                                  class="w-full bg-white border border-slate-200 rounded-xl p-3 text-xs text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 leading-relaxed {{ $isFormLocked ? 'bg-slate-100 cursor-not-allowed opacity-60' : '' }}">{{ old('activity_detail', $selectedJournal->activity_detail ?? '') }}</textarea>
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
                    @if($isDateExpired)
                        Pengisian untuk tanggal ini ditutup. Hubungi mentor jika terdapat kendala teknis.
                    @elseif($isDateFuture)
                        Pengisian untuk tanggal ini belum dibuka. Silakan kembali pada hari kegiatan berlangsung.
                    @else
                        {{ $selectedJournal ? 'Perubahan akan memperbarui data jurnal untuk tanggal ' . \Carbon\Carbon::parse($selectedDate)->translatedFormat('d F Y') . '.' : 'Jurnal baru akan dicatat untuk tanggal ' . \Carbon\Carbon::parse($selectedDate)->translatedFormat('d F Y') . '.' }}
                    @endif
                </span>

                @if(!$isFormLocked)
                    <button type="submit" class="px-6 py-2.5 bg-red-600 hover:bg-red-700 active:scale-98 text-white font-bold text-xs rounded-xl shadow-md shadow-red-600/25 transition-all flex items-center justify-center gap-2 cursor-pointer">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        <span>{{ $selectedJournal ? 'Perbarui Jurnal Kegiatan' : 'Simpan Jurnal Baru' }}</span>
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
@endsection
