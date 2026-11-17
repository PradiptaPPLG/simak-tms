@extends('layouts.simak')

@section('title', 'Evaluasi & Rapor Siswa • SIMAK-TMS')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900">Transkrip Evaluasi & Penilaian Industri</h1>
            <p class="text-xs text-slate-500 mt-1">Penilaian performa magang berdasarkan 4 standar kompetensi industri PT. Teknologi Multi Sistem.</p>
        </div>

        @if($evaluation && $evaluation->certificate_number)
            <div class="flex items-center gap-2 flex-wrap">
                <div class="bg-red-50 border border-red-200 text-red-700 text-xs font-mono font-bold px-3 py-1.5 rounded-xl self-start sm:self-auto shadow-xs">
                    No. Sertifikat: {{ $evaluation->certificate_number }}
                </div>
                <a href="{{ route('certificate.print', $evaluation->certificate_number) }}" target="_blank" class="px-3.5 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-red-600/25 flex items-center gap-1.5">
                    <i data-lucide="printer" class="w-3.5 h-3.5"></i>
                    <span>Cetak E-Sertifikat</span>
                </a>
                <a href="{{ route('verify.show', $evaluation->certificate_number) }}" target="_blank" class="px-3.5 py-1.5 bg-slate-900 hover:bg-black text-white text-xs font-bold rounded-xl transition-all shadow-xs flex items-center gap-1.5">
                    <i data-lucide="shield-check" class="w-3.5 h-3.5 text-emerald-400"></i>
                    <span>Verifikasi QR</span>
                </a>
            </div>
        @endif
    </div>

    @if($evaluation)
        <!-- Final Score Summary Card -->
        <div class="mas-card p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-6 border-l-4 border-l-red-600">
            <div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-red-600">Hasil Penilaian Akhir</div>
                <h3 class="text-xl font-extrabold text-slate-900 mt-0.5">{{ $user->name }}</h3>
                <div class="text-xs text-slate-500 mt-1">
                    {{ $user->school_origin }} • {{ $user->major }}
                </div>
                <div class="text-xs text-slate-400 mt-2">
                    Penilai Industri: <b class="text-slate-800">{{ $evaluation->mentor->name ?? 'Farhan Ramadhan (Head of Software TMS)' }}</b>
                </div>
            </div>

            <div class="flex items-center gap-4 bg-slate-50 border border-slate-200 p-4 rounded-xl self-start sm:self-auto">
                <div class="text-right">
                    <div class="text-[10px] uppercase font-bold text-slate-400">Skor Akhir</div>
                    <div class="text-3xl font-black text-slate-900 font-mono">{{ $evaluation->final_score }}</div>
                </div>
                <div class="w-14 h-14 rounded-xl bg-red-600 text-white font-black text-2xl flex items-center justify-center shadow-md shadow-red-600/30">
                    {{ $evaluation->final_score >= 85 ? 'A' : ($evaluation->final_score >= 75 ? 'B' : 'C') }}
                </div>
            </div>
        </div>

        <!-- 4 Competency Breakdown -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="mas-card p-5 space-y-1">
                <div class="text-[10px] uppercase font-bold text-slate-400">Hard Skills (Koding)</div>
                <div class="text-2xl font-black text-slate-900 font-mono">{{ $evaluation->technical_skill }}<span class="text-xs text-slate-400 font-normal">/100</span></div>
                <p class="text-xs text-slate-500 leading-snug">Implementasi Laravel, Clean Code, dan RESTful API.</p>
            </div>

            <div class="mas-card p-5 space-y-1">
                <div class="text-[10px] uppercase font-bold text-slate-400">Soft Skills (Teamwork)</div>
                <div class="text-2xl font-black text-slate-900 font-mono">{{ $evaluation->teamwork }}<span class="text-xs text-slate-400 font-normal">/100</span></div>
                <p class="text-xs text-slate-500 leading-snug">Kolaborasi tim, daily standup meeting, & komunikasi.</p>
            </div>

            <div class="mas-card p-5 space-y-1">
                <div class="text-[10px] uppercase font-bold text-slate-400">Inisiatif & Solutif</div>
                <div class="text-2xl font-black text-slate-900 font-mono">{{ $evaluation->initiative }}<span class="text-xs text-slate-400 font-normal">/100</span></div>
                <p class="text-xs text-slate-500 leading-snug">Troubleshooting mandiri & inisiatif pemecahan masalah.</p>
            </div>

            <div class="mas-card p-5 space-y-1">
                <div class="text-[10px] uppercase font-bold text-slate-400">Kedisiplinan & SOP</div>
                <div class="text-2xl font-black text-slate-900 font-mono">{{ $evaluation->discipline }}<span class="text-xs text-slate-400 font-normal">/100</span></div>
                <p class="text-xs text-slate-500 leading-snug">Penilaian profesional mentor industri atas kedisiplinan jam kerja & SOP (bukan kalkulasi otomatis kalender/libur).</p>
            </div>
        </div>

        <!-- Qualitative Mentor Notes -->
        <div class="mas-card p-6 space-y-2">
            <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Catatan Evaluasi Kualitatif Mentor Industri</h4>
            <div class="text-xs text-slate-600 leading-relaxed italic border-l-2 border-red-500 pl-3">
                "{{ $evaluation->general_notes ?? 'Peserta menunjukkan progres koding yang sangat cepat dan pemahaman arsitektur MVC yang solid.' }}"
            </div>
        </div>
    @else
        <div class="mas-card p-8 text-center text-slate-400 text-xs">
            Evaluasi nilai belum diterbitkan oleh mentor. Pastikan seluruh penugasan modul sprint telah disubmit.
        </div>
    @endif

</div>
@endsection
