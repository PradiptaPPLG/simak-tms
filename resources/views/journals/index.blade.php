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
            <button onclick="window.print()" class="px-3 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-xl transition-all shadow-xs flex items-center justify-center gap-1.5 cursor-pointer text-center">
                <i data-lucide="printer" class="w-4 h-4 text-slate-500 shrink-0"></i>
                <span class="truncate">Cetak Jurnal</span>
            </button>
            <a href="{{ route('showcase.index') }}" class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-red-600/25 flex items-center justify-center gap-1.5 text-center">
                <i data-lucide="book" class="w-4 h-4 shrink-0"></i>
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

        <!-- Calendar Cells Grid -->
        <div class="grid grid-cols-7 gap-2">
            {{-- 1 November 2026 is Sunday (col 7). Leading 6 empty cells for Oct 26-31 --}}
            @for($i = 0; $i < 6; $i++)
                <div class="p-2 sm:p-3 rounded-xl bg-slate-50/40 border border-slate-100 opacity-20"></div>
            @endfor

            {{-- Days 1 to 30 of November 2026 --}}
            @for($d = 1; $d <= 30; $d++)
                @php
                    $dayStr = sprintf('2026-11-%02d', $d);
                    $journal = $journalsByDate->get($dayStr);
                    $isSelected = ($selectedDate === $dayStr);
                    $isToday = ($dayStr === now()->toDateString());
                    $hasFeedback = ($journal && !empty($journal->mentor_feedback));
                @endphp

                <a href="{{ route('journals.index', ['date' => $dayStr]) }}#form-jurnal"
                   class="p-2 sm:p-3 rounded-xl flex flex-col items-center justify-center transition-all cursor-pointer relative min-h-[58px] sm:min-h-[66px]
                          {{ $isSelected ? 'ring-2 ring-red-600 ring-offset-2 z-10 scale-105 shadow-md' : 'hover:scale-102' }}
                          @if($journal)
                              @if($hasFeedback)
                                  bg-emerald-50 border border-emerald-300 text-emerald-800 hover:bg-emerald-100/80
                              @else
                                  bg-red-50 border border-red-200 text-red-700 hover:bg-red-100/80
                              @endif
                          @else
                              @if($isToday)
                                  bg-white border-2 border-red-500 text-slate-900 shadow-xs
                              @else
                                  bg-slate-50 border border-slate-200/80 text-slate-400 hover:bg-slate-100
                              @endif
                          @endif"
                   title="{{ $journal ? ($hasFeedback ? 'Mentor sudah menyisipkan catatan. Klik untuk meninjau/mengedit.' : 'Jurnal terisi, belum ada catatan mentor. Klik untuk mengedit.') : ($isToday ? 'Hari Ini - Klik untuk mengisi jurnal' : 'Belum diisi') }}">
                    
                    <span class="text-sm font-black
                        @if($journal)
                            {{ $hasFeedback ? 'text-emerald-800' : 'text-red-700' }}
                        @elseif($isToday)
                            text-red-600
                        @else
                            text-slate-500
                        @endif">
                        {{ $d }}
                    </span>

                    @if($journal)
                        {{-- Icon pensil tetap ada untuk edit catatan --}}
                        <i data-lucide="edit-3" class="w-3.5 h-3.5 mt-1 {{ $hasFeedback ? 'text-emerald-600' : 'text-red-600' }}"></i>
                    @elseif($isToday)
                        <span class="text-[9px] font-bold text-red-500 mt-0.5">Hari Ini</span>
                    @else
                        <span class="text-xs text-slate-300 mt-0.5">-</span>
                    @endif
                </a>
            @endfor

            {{-- 30 Nov 2026 is Monday (col 1). Trailing 6 empty cells --}}
            @for($i = 0; $i < 6; $i++)
                <div class="p-2 sm:p-3 rounded-xl bg-slate-50/40 border border-slate-100 opacity-20"></div>
            @endfor
        </div>

        <!-- Calendar Legend & Penjelasan Indikator Warna -->
        <div class="mt-5 pt-4 border-t border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-3 text-xs">
            <div class="flex flex-wrap items-center gap-4">
                <div class="flex items-center gap-2">
                    <span class="w-7 h-7 rounded-lg bg-red-50 border border-red-200 flex items-center justify-center text-red-600 shadow-2xs">
                        <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                    </span>
                    <span class="text-slate-700"><b class="text-red-600">Merah:</b> Jurnal Terisi (Belum Ada Catatan Mentor)</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-7 h-7 rounded-lg bg-emerald-50 border border-emerald-300 flex items-center justify-center text-emerald-700 shadow-2xs">
                        <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                    </span>
                    <span class="text-slate-700"><b class="text-emerald-700">Hijau:</b> Mentor Sudah Menyisipkan Catatan (Tetap Bisa Diedit)</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-7 h-7 rounded-lg bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-400">
                        <span class="text-xs">-</span>
                    </span>
                    <span class="text-slate-400">Belum Ada Jurnal</span>
                </div>
            </div>
            <div class="text-[11px] text-slate-400 flex items-center gap-1">
                <i data-lucide="mouse-pointer-click" class="w-3.5 h-3.5"></i>
                <span>Klik tanggal pada kalender untuk membuka & mengedit form jurnal</span>
            </div>
        </div>
    </div>

    <!-- 2. Form Input / Edit Jurnal Kegiatan (#form-jurnal) -->
    <div id="form-jurnal" class="mas-card p-6 sm:p-8 space-y-6">
        
        <!-- Form Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4">
            <div>
                <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-red-50 text-red-600 text-[10px] font-bold uppercase tracking-wider mb-1">
                    Logbook Harian Industri
                </div>
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
            <div class="p-3.5 rounded-2xl bg-red-50/70 border border-red-200 text-red-900 text-xs flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-lg bg-red-100 text-red-600 flex items-center justify-center">
                        <i data-lucide="clock" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <span class="font-bold">Status Bimbingan Mentor:</span>
                        <span class="text-red-700"> Belum ada catatan yang disisipkan oleh mentor pembimbing untuk jurnal tanggal ini.</span>
                    </div>
                </div>
                <span class="text-[10px] bg-red-100 text-red-700 font-bold px-2.5 py-1 rounded-full border border-red-200">
                    Menunggu Catatan
                </span>
            </div>
        @endif

        <!-- Form Input -->
        <form action="{{ route('journals.store') }}" method="POST" class="space-y-5">
            @csrf
            <input type="hidden" name="journal_date" value="{{ $selectedDate }}">

            <!-- Row 1: Tanggal Terpilih & Presensi Lab -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Tanggal Kegiatan</label>
                    <div class="flex items-center justify-between bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-800 font-bold">
                        <div class="flex items-center gap-2">
                            <i data-lucide="calendar" class="w-4 h-4 text-red-600"></i>
                            <span>{{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('l, d F Y') }}</span>
                        </div>
                        <span class="text-[11px] text-slate-400 font-normal font-mono">({{ $selectedDate }})</span>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Presensi Kehadiran Lab</label>
                    <div class="flex items-center justify-between bg-emerald-50 border border-emerald-200 rounded-xl px-4 py-2 text-xs text-emerald-800">
                        <div class="flex items-center gap-2">
                            <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600"></i>
                            <span class="font-bold">Hadir Kerja: <span class="font-normal">07:54 - 17:00 WIB</span></span>
                        </div>
                        <span class="text-[10px] bg-emerald-200 text-emerald-900 font-bold px-2 py-0.5 rounded">Tervalidasi</span>
                    </div>
                </div>
            </div>

            <!-- Row 2: Pekerjaan / Fitur yang Dikerjakan -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Pekerjaan / Fitur yang Dikerjakan <span class="text-red-500">*</span></label>
                <input type="text" name="activity_title" required
                       value="{{ old('activity_title', $selectedJournal->activity_title ?? '') }}"
                       placeholder="Contoh: Implementasi modul autentikasi login & integrasi database logbook"
                       class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
            </div>

            <!-- Row 3: Dua Kolom (Dropzone Foto Bukti & Deskripsi Kegiatan/Catatan Harian) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                
                <!-- Left: Foto Bukti Kegiatan Dropzone -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Foto Bukti Kegiatan</label>
                    <div class="border-2 border-dashed border-slate-200 rounded-2xl p-7 flex flex-col items-center justify-center text-center hover:bg-red-50/30 hover:border-red-300 transition-colors cursor-pointer group h-[calc(100%-24px)] min-h-[170px]">
                        <div class="w-11 h-11 rounded-full bg-red-50 text-red-600 flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                            <i data-lucide="camera" class="w-5 h-5"></i>
                        </div>
                        <div class="text-xs font-bold text-slate-700">Klik untuk unggah foto kegiatan</div>
                        <div class="text-[10px] text-slate-400 mt-0.5">JPG, PNG — screenshot layar koding / suasana lab</div>
                    </div>
                </div>

                <!-- Right: Deskripsi Kegiatan / Catatan Harian & Tautan Commit Git -->
                <div class="space-y-3.5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi Kegiatan / Catatan Harian <span class="text-red-500">*</span></label>
                        <textarea name="activity_detail" rows="4" required
                                  placeholder="Tuliskan ringkasan aktivitas, fitur yang dikembangkan, alur kerja, atau catatan pembelajaran hari ini..."
                                  class="w-full bg-white border border-slate-200 rounded-xl p-3 text-xs text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 leading-relaxed">{{ old('activity_detail', $selectedJournal->activity_detail ?? '') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Tautan Commit Git / Pull Request (Bukti Koding)</label>
                        <input type="url" name="commit_url"
                               value="{{ old('commit_url', $selectedJournal->commit_url ?? '') }}"
                               placeholder="https://github.com/.../commit/..."
                               class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 font-mono focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                </div>

            </div>

            <!-- Submit Button Footer -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-4 border-t border-slate-100">
                <span class="text-xs text-slate-400">
                    {{ $selectedJournal ? 'Perubahan akan memperbarui data jurnal untuk tanggal ' . \Carbon\Carbon::parse($selectedDate)->translatedFormat('d F Y') . '.' : 'Jurnal baru akan dicatat untuk tanggal ' . \Carbon\Carbon::parse($selectedDate)->translatedFormat('d F Y') . '.' }}
                </span>
                <button type="submit" class="px-6 py-2.5 bg-red-600 hover:bg-red-700 active:scale-98 text-white font-bold text-xs rounded-xl shadow-md shadow-red-600/25 transition-all flex items-center justify-center gap-2 cursor-pointer">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    <span>{{ $selectedJournal ? 'Perbarui Jurnal Kegiatan' : 'Simpan Jurnal Baru' }}</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
