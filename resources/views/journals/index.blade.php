@extends('layouts.simak')

@section('title', 'Jurnal Kegiatan PKL • SIMAK-TMS')

@section('content')
<div class="space-y-6">

    <!-- Header Section (Hitam - Putih - Merah TMS) -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900">Jurnal Kegiatan PKL</h1>
            <p class="text-xs text-slate-500 mt-1">Catat setiap aktivitas pengerjaan atau pembelajaran di industri sesuai format resmi.</p>
        </div>

        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-xl transition-all shadow-xs flex items-center gap-2">
                <i data-lucide="printer" class="w-4 h-4 text-slate-500"></i>
                <span>Cetak Jurnal</span>
            </button>
            <a href="{{ route('showcase.index') }}" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-red-600/25 flex items-center gap-2">
                <i data-lucide="book" class="w-4 h-4"></i>
                <span>Cetak Portofolio</span>
            </a>
        </div>
    </div>

    <!-- 1. Interactive Monthly Calendar Grid (November 2026) -->
    <div class="mas-card p-6">
        <!-- Calendar Header -->
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center gap-2">
                <i data-lucide="calendar" class="w-5 h-5 text-red-600"></i>
                <h2 class="text-lg font-bold text-slate-800">November 2026</h2>
            </div>
            <div class="flex items-center gap-1.5">
                <button class="p-1.5 rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50">&lt;</button>
                <span class="px-3 py-1 rounded-lg bg-red-50 text-red-600 text-xs font-bold">Bulan Ini</span>
                <button class="p-1.5 rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50">&gt;</button>
            </div>
        </div>

        <!-- Days of Week -->
        <div class="grid grid-cols-7 gap-2 text-center text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">
            <div>SEN</div>
            <div>SEL</div>
            <div>RAB</div>
            <div>KAM</div>
            <div>JUM</div>
            <div>SAB</div>
            <div>MIN</div>
        </div>

        <!-- Calendar Cells -->
        <div class="grid grid-cols-7 gap-2">
            <!-- Row 1: Oct 26 - 31 empty + Nov 1 -->
            <div class="p-3 rounded-xl bg-slate-50/50 border border-slate-100 opacity-30"></div>
            <div class="p-3 rounded-xl bg-slate-50/50 border border-slate-100 opacity-30"></div>
            <div class="p-3 rounded-xl bg-slate-50/50 border border-slate-100 opacity-30"></div>
            <div class="p-3 rounded-xl bg-slate-50/50 border border-slate-100 opacity-30"></div>
            <div class="p-3 rounded-xl bg-slate-50/50 border border-slate-100 opacity-30"></div>
            <div class="p-3 rounded-xl bg-slate-50/50 border border-slate-100 opacity-30"></div>
            <div class="p-2 sm:p-3 rounded-xl bg-slate-100 border border-slate-200 text-slate-400 flex flex-col items-center justify-center">
                <span class="text-sm font-bold">1</span>
                <i data-lucide="calendar" class="w-3.5 h-3.5 mt-1 opacity-40"></i>
            </div>

            <!-- Row 2: Nov 2 - 8 -->
            @for($d = 2; $d <= 8; $d++)
                <div class="p-2 sm:p-3 rounded-xl bg-slate-100 border border-slate-200 text-slate-400 flex flex-col items-center justify-center">
                    <span class="text-sm font-bold">{{ $d }}</span>
                    <i data-lucide="calendar" class="w-3.5 h-3.5 mt-1 opacity-40"></i>
                </div>
            @endfor

            <!-- Row 3: Nov 9 - 15 (Filled Journals: Soft Red/Peach Background with Red Pen Icon) -->
            @for($d = 9; $d <= 15; $d++)
                <div class="p-2 sm:p-3 rounded-xl bg-red-50 border border-red-200 text-red-700 flex flex-col items-center justify-center hover:scale-105 transition-transform cursor-pointer shadow-xs">
                    <span class="text-sm font-black">{{ $d }}</span>
                    <i data-lucide="edit-3" class="w-3.5 h-3.5 mt-1 text-red-600"></i>
                </div>
            @endfor

            <!-- Row 4: Nov 16 (Today: Highlighted with Red Outline) to Nov 22 -->
            <!-- Today 16 -->
            <div class="p-2 sm:p-3 rounded-xl bg-white border-2 border-red-600 text-slate-900 flex flex-col items-center justify-center shadow-md scale-105 relative z-10">
                <span class="text-sm font-black text-red-600">16</span>
                <i data-lucide="clock" class="w-3.5 h-3.5 mt-1 text-red-500"></i>
            </div>
            <!-- Future Nov 17 - 22 -->
            @for($d = 17; $d <= 22; $d++)
                <div class="p-2 sm:p-3 rounded-xl bg-slate-50 border border-slate-200/80 text-slate-400 flex flex-col items-center justify-center">
                    <span class="text-sm font-medium">{{ $d }}</span>
                    <span class="text-xs text-slate-300 mt-1">-</span>
                </div>
            @endfor

            <!-- Row 5: Nov 23 - 29 -->
            @for($d = 23; $d <= 29; $d++)
                <div class="p-2 sm:p-3 rounded-xl bg-slate-50 border border-slate-200/80 text-slate-400 flex flex-col items-center justify-center">
                    <span class="text-sm font-medium">{{ $d }}</span>
                    <span class="text-xs text-slate-300 mt-1">-</span>
                </div>
            @endfor

            <!-- Row 6: Nov 30 -->
            <div class="p-2 sm:p-3 rounded-xl bg-slate-50 border border-slate-200/80 text-slate-400 flex flex-col items-center justify-center">
                <span class="text-sm font-medium">30</span>
                <span class="text-xs text-slate-300 mt-1">-</span>
            </div>
        </div>
    </div>

    <!-- 2. Tambah / Edit Jurnal Harian (Hitam - Putih - Merah TMS) -->
    <div id="form-jurnal" class="mas-card p-6 sm:p-8">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-6">
            <div>
                <h2 class="text-xl font-black text-slate-900 tracking-tight">Tambah Jurnal Harian</h2>
                <p class="text-xs text-slate-400 mt-0.5">Siswa wajib mengisi jurnal setiap hari kerja sebelum pukul 17.00 WIB.</p>
            </div>
            <span class="text-xs font-bold text-slate-500">
                Status: <span class="text-emerald-600">{{ $todayJournal ? '✓ Telah Diisi' : 'Draft Baru' }}</span>
            </span>
        </div>

        <form action="{{ route('journals.store') }}" method="POST" class="space-y-5">
            @csrf
            <input type="hidden" name="journal_date" value="{{ now()->toDateString() }}">

            <!-- Row 1: Tanggal & Elemen Kompetensi -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Tanggal Kegiatan</label>
                    <input type="text" value="{{ now()->translatedFormat('d/m/Y') }}" readonly class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-700 font-medium">
                    <p class="text-[10px] text-slate-400 mt-1">Anda dapat mengisi jurnal untuk maksimal 7 hari sebelumnya.</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Elemen Kompetensi</label>
                    <select class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 font-medium focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                        <option selected>Internalisasi dan penerapan soft skills</option>
                        <option>Penerapan hard skills (Software Engineering)</option>
                        <option>Penyiapan Kemandirian Berwirausaha</option>
                    </select>
                </div>
            </div>

            <!-- Row 2: Capaian & Tujuan Pembelajaran -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Capaian Pembelajaran (CP)</label>
                    <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-600 leading-relaxed">
                        Pada akhir fase F, peserta didik mampu menerapkan etika berkomunikasi, integritas (jujur, disiplin, tanggung jawab), etos kerja tim di lingkungan PT. Teknologi Multi Sistem.
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Tujuan Pembelajaran (TP)</label>
                    <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-600 leading-relaxed">
                        2. Menerapkan soft skills, kolaborasi Git team flow, dan memahami standar SOP penulisan kode pada lingkungan kerja software house.
                    </div>
                </div>
            </div>

            <!-- Absensi Terdeteksi Banner -->
            <div class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600"></i>
                    <span class="font-bold">Absensi Terdeteksi: <span class="font-normal">Hadir (Masuk: 07:54 | Pulang: 17:00)</span></span>
                </div>
                <span class="text-[10px] bg-emerald-200 text-emerald-800 font-bold px-2 py-0.5 rounded">Tervalidasi</span>
            </div>

            <!-- Pekerjaan Field -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Pekerjaan</label>
                <input type="text" name="activity_title" required
                       value="{{ $todayJournal->activity_title ?? 'Meeting SOP, Aturan Kerja TMS & Implementasi Modul Komentar TechPulse' }}"
                       placeholder="Sebutkan apa yang Anda kerjakan hari ini..."
                       class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
            </div>

            <!-- Two-Column: Foto Bukti Kegiatan & Catatan Detail/Kendala -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                
                <!-- Left: Foto Bukti Kegiatan Dropzone -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Foto Bukti Kegiatan</label>
                    <div class="border-2 border-dashed border-slate-200 rounded-2xl p-8 flex flex-col items-center justify-center text-center hover:bg-red-50/30 hover:border-red-300 transition-colors cursor-pointer group">
                        <div class="w-12 h-12 rounded-full bg-red-50 text-red-600 flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                            <i data-lucide="camera" class="w-6 h-6"></i>
                        </div>
                        <div class="text-xs font-bold text-slate-700">Klik untuk unggah foto</div>
                        <div class="text-[10px] text-slate-400 mt-0.5">JPG, PNG — max 2MB</div>
                    </div>
                </div>

                <!-- Right: Catatan Detail / Kendala & Solusi -->
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Catatan Detail / Kendala</label>
                        <textarea name="activity_detail" rows="3" required placeholder="Ceritakan proses pengerjaan atau kendala yang dihadapi..."
                                  class="w-full bg-white border border-slate-200 rounded-xl p-3 text-xs text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500">{{ $todayJournal->activity_detail ?? 'Mengikuti meeting briefing bersama mentor Farhan Ramadhan mengenai standar branch naming, commit messages, dan deploy blog TechPulse.' }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Tautan Commit Git / Pull Request (Bukti Koding)</label>
                        <input type="url" name="commit_url" value="{{ $todayJournal->commit_url ?? 'https://github.com/pradipta/techpulse/commit/c418daf' }}"
                               placeholder="https://github.com/pradipta/.../commit/..."
                               class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 font-mono">
                    </div>
                </div>

            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end pt-3 border-t border-slate-100">
                <button type="submit" class="px-6 py-2.5 bg-red-600 hover:bg-red-700 active:scale-98 text-white font-bold text-xs rounded-xl shadow-md shadow-red-600/25 transition-all flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    <span>Simpan Jurnal</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
