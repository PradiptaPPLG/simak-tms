@extends('layouts.simak')

@section('title', 'Pusat Review Mentor • SIMAK-TMS')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900">Pusat Validasi & Review Mentor</h1>
            <p class="text-xs text-slate-500 mt-1">Approval 1-Click untuk Jurnal Harian dan pemberian nilai modul tugas koding siswa magang.</p>
        </div>

        <div class="flex items-center gap-2 bg-white px-3.5 py-1.5 rounded-xl border border-slate-200 text-xs shadow-xs">
            <span class="text-slate-400">Login sebagai:</span>
            <span class="font-bold text-red-600">{{ auth()->user()->name }}</span>
        </div>
    </div>

    <!-- Section 1: Pending Daily Journals -->
    <div class="space-y-3">
        <div class="flex items-center justify-between">
            <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center gap-2">
                <span>1. Validasi Jurnal Harian Siswa</span>
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-red-50 text-red-600 border border-red-200">
                    {{ $pendingJournals->count() }} Menunggu Validasi
                </span>
            </h2>
        </div>

        <div class="space-y-3">
            @forelse($pendingJournals as $journal)
                <div class="mas-card p-5 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="space-y-1.5 flex-1">
                        <div class="flex items-center gap-2 text-xs">
                            <span class="font-bold text-slate-900">{{ $journal->user->name }}</span>
                            <span class="text-slate-400">•</span>
                            <span class="text-slate-500 font-mono">{{ $journal->journal_date->translatedFormat('d F Y') }}</span>
                            <span class="text-[10px] font-bold px-2 py-0.2 rounded bg-red-100 text-red-700">Pending</span>
                        </div>
                        <div class="text-xs font-bold text-slate-800">{{ $journal->activity_title }}</div>
                        <div class="text-xs text-slate-600 line-clamp-2 leading-relaxed">{{ $journal->activity_detail }}</div>
                        @if($journal->commit_url)
                            <div class="text-[11px] text-slate-500">
                                Commit Git: <a href="{{ $journal->commit_url }}" target="_blank" class="text-red-600 hover:underline font-mono">{{ $journal->commit_url }}</a>
                            </div>
                        @endif
                    </div>

                    <form action="{{ route('mentor.journal.approve', $journal->id) }}" method="POST" class="flex-shrink-0">
                        @csrf
                        <button type="submit" class="px-4 py-2 rounded-xl text-xs font-bold bg-slate-900 hover:bg-black text-white transition-all shadow-xs flex items-center gap-1.5">
                            <i data-lucide="check" class="w-4 h-4 text-emerald-400"></i>
                            <span>Setujui (1-Click)</span>
                        </button>
                    </form>
                </div>
            @empty
                <div class="mas-card p-6 text-center text-slate-400 text-xs">
                    Semua jurnal harian telah disetujui (Approved). Tidak ada antrean.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Section 2: Pending Task Submissions -->
    <div class="space-y-3 pt-4 border-t border-slate-200">
        <div class="flex items-center justify-between">
            <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center gap-2">
                <span>2. Penilaian Modul Tugas Siswa</span>
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-red-50 text-red-600 border border-red-200">
                    {{ $pendingSubmissions->count() }} Perlu Penilaian
                </span>
            </h2>
        </div>

        <div class="space-y-4">
            @forelse($pendingSubmissions as $sub)
                <div class="mas-card p-6 space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-2 border-b border-slate-100 pb-3">
                        <div>
                            <div class="text-xs text-slate-500">Siswa: <b class="text-slate-800">{{ $sub->user->name }}</b> ({{ $sub->user->school_origin }})</div>
                            <h3 class="text-base font-bold text-slate-900 mt-0.5">{{ $sub->task->title }}</h3>
                        </div>
                        <div class="text-xs text-slate-400 font-mono">Disubmit: {{ $sub->created_at->diffForHumans() }}</div>
                    </div>

                    <div class="space-y-1 text-xs text-slate-600">
                        @if($sub->submission_url)
                            <div>Pull Request: <a href="{{ $sub->submission_url }}" target="_blank" class="text-red-600 hover:underline font-mono">{{ $sub->submission_url }}</a></div>
                        @endif
                        @if($sub->notes)
                            <div class="text-slate-500 italic">"{{ $sub->notes }}"</div>
                        @endif
                    </div>

                    <!-- Grading Form -->
                    <form action="{{ route('mentor.task.grade', $sub->id) }}" method="POST" class="bg-slate-50 border border-slate-200/80 rounded-xl p-4 space-y-3">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                            <div>
                                <label class="block text-[11px] text-slate-600 font-medium mb-1">Nilai Modul (0 - 100)</label>
                                <input type="number" name="score" value="95" min="0" max="100" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-xs text-slate-800 font-mono focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                            </div>
                            <div class="sm:col-span-3">
                                <label class="block text-[11px] text-slate-600 font-medium mb-1">Feedback Teknis & Arahan Koding</label>
                                <input type="text" name="feedback" value="Implementasi REST API rapi, validasi request sudah lengkap. Pertahankan clean code." class="w-full bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold bg-red-600 hover:bg-red-700 text-white transition-all shadow-sm flex items-center gap-1.5">
                                <span>Simpan Nilai & Berikan Feedback</span>
                                <i data-lucide="send" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                    </form>
                </div>
            @empty
                <div class="mas-card p-6 text-center text-slate-400 text-xs">
                    Semua tugas telah dinilai. Tidak ada antrean tugas aktif.
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
