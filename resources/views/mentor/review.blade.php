@extends('layouts.simak')

@section('title', 'Pusat Bimbingan & Review Mentor • SIMAK-TMS')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900">Pusat Bimbingan & Catatan Mentor</h1>
            <p class="text-xs text-slate-500 mt-1">Tinjau logbook harian siswa magang dan sisipkan catatan bimbingan teknis industri secara fleksibel.</p>
        </div>

        <div class="flex items-center gap-2 bg-white px-3.5 py-1.5 rounded-xl border border-slate-200 text-xs shadow-xs">
            <span class="text-slate-400">Login sebagai:</span>
            <span class="font-bold text-red-600">{{ auth()->user()->name }}</span>
        </div>
    </div>

    <!-- Section 1: Jurnal Harian Siswa & Sisipkan Catatan Mentor -->
    <div class="space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center gap-2">
                <span>1. Logbook Jurnal Harian Siswa</span>
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-red-50 text-red-600 border border-red-200">
                    {{ $pendingJournalsCount }} Belum Ada Catatan
                </span>
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                    {{ $reviewedJournalsCount }} Sudah Ada Catatan
                </span>
            </h2>
            <span class="text-[11px] text-slate-400">
                Mentor dapat menyisipkan catatan tanpa memblokir alur kerja siswa
            </span>
        </div>

        <div class="space-y-4">
            @forelse($journals as $journal)
                @php
                    $hasNote = !empty($journal->mentor_feedback);
                @endphp
                <div class="mas-card p-6 space-y-4 border-l-4 {{ $hasNote ? 'border-l-emerald-500' : 'border-l-red-500' }}">
                    
                    <!-- Header Bar of Journal -->
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-2 border-b border-slate-100 pb-3">
                        <div>
                            <div class="flex items-center gap-2 text-xs">
                                <span class="font-bold text-slate-900">{{ $journal->user->name ?? 'Siswa Magang' }}</span>
                                <span class="text-slate-400">•</span>
                                <span class="text-slate-500 font-mono">{{ \Carbon\Carbon::parse($journal->journal_date)->translatedFormat('l, d F Y') }}</span>
                                @if($hasNote)
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded bg-emerald-100 text-emerald-800">
                                        <i data-lucide="check" class="w-3 h-3"></i> Sudah Ada Catatan
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded bg-red-100 text-red-700">
                                        <i data-lucide="clock" class="w-3 h-3"></i> Belum Diberi Catatan
                                    </span>
                                @endif
                            </div>
                            <h3 class="text-sm font-black text-slate-900 mt-1">{{ $journal->activity_title }}</h3>
                        </div>

                        @if($journal->commit_url)
                            <a href="{{ $journal->commit_url }}" target="_blank" class="px-3 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-mono font-medium transition-colors flex items-center gap-1.5 self-start">
                                <i data-lucide="git-commit" class="w-3.5 h-3.5 text-red-600"></i>
                                <span>Commit Git</span>
                            </a>
                        @endif
                    </div>

                    <!-- Journal Activity Detail (Deskripsi Kegiatan / Catatan Harian) -->
                    <div class="space-y-1">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Deskripsi Kegiatan / Catatan Siswa:</span>
                        <div class="p-3 bg-slate-50 border border-slate-200/70 rounded-xl text-xs text-slate-700 leading-relaxed font-normal">
                            {{ $journal->activity_detail }}
                        </div>
                    </div>

                    <!-- Existing Mentor Note Display (if exists) -->
                    @if($hasNote)
                        <div class="p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs space-y-1">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-[10px] uppercase tracking-wider text-emerald-700 flex items-center gap-1.5">
                                    <i data-lucide="message-square-quote" class="w-3.5 h-3.5"></i>
                                    <span>Catatan Tersimpan (oleh {{ $journal->mentor->name ?? 'Staff Mentor' }}):</span>
                                </span>
                                <span class="text-[10px] text-emerald-600">Siswa dapat melihat di kalender jurnal (berwarna hijau)</span>
                            </div>
                            <p class="font-medium text-emerald-950 pl-5">"{{ $journal->mentor_feedback }}"</p>
                        </div>
                    @endif

                    <!-- Form Sisipkan / Update Catatan Mentor -->
                    <form action="{{ route('mentor.journal.note', $journal->id) }}" method="POST" class="bg-slate-50/70 border border-slate-200/80 rounded-xl p-4 space-y-3">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1 flex items-center justify-between">
                                <span>{{ $hasNote ? 'Perbarui Catatan / Bimbingan Mentor' : 'Sisipkan Catatan / Bimbingan Mentor' }}</span>
                                <span class="text-[10px] text-slate-400 font-normal">Tersinkron langsung ke antarmuka kalender jurnal siswa</span>
                            </label>
                            <textarea id="mentor-note-{{ $journal->id }}" name="mentor_feedback" rows="2" required
                                      placeholder="Sisipkan apresiasi, evaluasi penulisan kode, atau arahan bimbingan industri untuk siswa..."
                                      class="w-full bg-white border border-slate-200 rounded-xl p-3 text-xs text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 leading-relaxed">{{ old('mentor_feedback', $journal->mentor_feedback ?? '') }}</textarea>
                        </div>

                        <!-- Quick suggestion chips -->
                        <div class="flex flex-wrap items-center gap-1.5 text-[11px]">
                            <span class="text-slate-400 text-[10px] mr-1">Rekomendasi Cepat:</span>
                            <button type="button" onclick="setQuickNote('mentor-note-{{ $journal->id }}', 'Aktivitas terverifikasi dan memenuhi standar dokumentasi kerja PT. TMS.')" class="px-2.5 py-1 rounded-lg bg-white border border-slate-200 hover:border-red-300 hover:text-red-600 text-slate-600 transition-colors text-[10px] cursor-pointer">
                                Standar TMS Terpenuhi
                            </button>
                            <button type="button" onclick="setQuickNote('mentor-note-{{ $journal->id }}', 'Struktur kode dan alur commit Git rapi. Pertahankan penamaan commit yang deskriptif.')" class="px-2.5 py-1 rounded-lg bg-white border border-slate-200 hover:border-red-300 hover:text-red-600 text-slate-600 transition-colors text-[10px] cursor-pointer">
                                Git Commit Rapi
                            </button>
                            <button type="button" onclick="setQuickNote('mentor-note-{{ $journal->id }}', 'Bagus, implementasi logika fitur sudah sesuai arsitektur. Lanjutkan ke sprint berikutnya.')" class="px-2.5 py-1 rounded-lg bg-white border border-slate-200 hover:border-red-300 hover:text-red-600 text-slate-600 transition-colors text-[10px] cursor-pointer">
                                Sesuai Arsitektur
                            </button>
                        </div>

                        <div class="flex items-center justify-end pt-1">
                            <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold bg-slate-900 hover:bg-black text-white transition-all shadow-xs flex items-center gap-1.5 cursor-pointer">
                                <i data-lucide="send" class="w-3.5 h-3.5 text-emerald-400"></i>
                                <span>{{ $hasNote ? 'Perbarui Catatan Mentor' : 'Simpan Catatan Mentor' }}</span>
                            </button>
                        </div>
                    </form>
                </div>
            @empty
                <div class="mas-card p-8 text-center text-slate-400 text-xs">
                    Belum ada logbook jurnal harian yang dikirimkan oleh siswa.
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

<script>
function setQuickNote(elementId, text) {
    const el = document.getElementById(elementId);
    if (el) {
        el.value = text;
        el.focus();
    }
}
</script>
@endsection
