@extends('layouts.simak')

@section('title', 'Modul Tugas LMS • SIMAK-TMS')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900">Modul Tugas Industri (LMS)</h1>
            <p class="text-xs text-slate-500 mt-1">Daftar sprint modul teknis yang ditugaskan mentor PT. Teknologi Multi Sistem.</p>
        </div>

        <!-- Filter Tabs -->
        <div class="flex items-center gap-1 bg-white p-1 rounded-xl border border-slate-200 self-start sm:self-auto shadow-xs">
            <a href="{{ route('tasks.index') }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold {{ $filter === 'all' ? 'bg-red-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">Semua</a>
            <a href="{{ route('tasks.index', ['filter' => 'aktif']) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold {{ $filter === 'aktif' ? 'bg-red-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">Aktif</a>
            <a href="{{ route('tasks.index', ['filter' => 'selesai']) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold {{ $filter === 'selesai' ? 'bg-red-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">Selesai</a>
        </div>
    </div>

    <!-- Tasks List -->
    <div class="space-y-4">
        @forelse($tasks as $task)
            @php
                $submission = $task->submissions->first();
            @endphp
            <div class="mas-card p-6 space-y-4">
                <!-- Task Header -->
                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded {{ $task->priority === 'tinggi' ? 'bg-red-50 text-red-600 border border-red-200' : 'bg-slate-100 text-slate-600' }}">
                                Prioritas {{ $task->priority }}
                            </span>
                            <span class="text-xs text-slate-400">Mentor: <b class="text-slate-700">{{ $task->mentor->name }}</b></span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900">{{ $task->title }}</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">{{ $task->description }}</p>
                    </div>

                    <div class="text-left sm:text-right flex-shrink-0 bg-slate-50 sm:bg-transparent p-3 sm:p-0 rounded-xl border border-slate-100 sm:border-0">
                        <div class="text-[10px] text-slate-400 font-medium">Batas Waktu:</div>
                        <div class="text-xs font-bold text-red-600 font-mono">{{ $task->deadline->translatedFormat('d M Y, H:i') }} WIB</div>
                    </div>
                </div>

                <!-- Submission Status Box -->
                @if($submission)
                    <div class="bg-slate-50 border border-slate-200/80 rounded-xl p-4 space-y-2 text-xs">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-slate-700">Status Tugas:</span>
                                @if($submission->status === 'approved')
                                    <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-700 border border-emerald-300">✓ Disetujui (Approved)</span>
                                @elseif($submission->status === 'revisi')
                                    <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-700 border border-amber-300">⚠ Butuh Revisi</span>
                                @else
                                    <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-red-100 text-red-700 border border-red-300">⏳ Menunggu Review</span>
                                @endif
                            </div>
                            @if($submission->score)
                                <div class="font-bold text-slate-800">
                                    Nilai: <span class="text-red-600 font-mono font-black text-sm">{{ $submission->score }}</span>/100
                                </div>
                            @endif
                        </div>

                        @if($submission->submission_url)
                            <div class="text-slate-500 truncate">
                                Repositori PR: <a href="{{ $submission->submission_url }}" target="_blank" class="text-red-600 hover:underline font-mono">{{ $submission->submission_url }}</a>
                            </div>
                        @endif

                        @if($submission->notes)
                            <div class="text-slate-600 italic border-l-2 border-red-500 pl-2">
                                "{{ $submission->notes }}"
                            </div>
                        @endif

                        @if($submission->feedback)
                            <div class="bg-red-50/50 border border-red-100 rounded-lg p-3 mt-2">
                                <div class="font-bold text-red-700 text-[11px] mb-0.5">Catatan Mentor TMS:</div>
                                <div class="text-slate-700">{{ $submission->feedback }}</div>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Submission Form (If open or needs revision) -->
                @if(!$submission || $submission->status === 'revisi')
                    <form action="{{ route('tasks.submit', $task->id) }}" method="POST" class="bg-slate-50 border border-slate-200/80 rounded-xl p-4 space-y-3">
                        @csrf
                        <div class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                            <i data-lucide="upload" class="w-4 h-4 text-red-600"></i>
                            <span>{{ $submission && $submission->status === 'revisi' ? 'Kirim Ulang Hasil Revisi' : 'Submit Hasil Pengerjaan Modul' }}</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] text-slate-600 font-medium mb-1">Tautan GitHub Pull Request / Branch</label>
                                <input type="url" name="submission_url" required placeholder="https://github.com/pradipta/.../pull/1" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                            </div>
                            <div>
                                <label class="block text-[11px] text-slate-600 font-medium mb-1">Catatan Singkat / Ringkasan Perubahan</label>
                                <input type="text" name="notes" placeholder="Contoh: Menambahkan migration dan route resource" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                            </div>
                        </div>
                        <button type="submit" class="px-4 py-2 text-xs font-bold bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors flex items-center gap-1.5 shadow-sm">
                            <span>Kirim ke Mentor</span>
                            <i data-lucide="send" class="w-3.5 h-3.5"></i>
                        </button>
                    </form>
                @endif
            </div>
        @empty
            <div class="mas-card p-8 text-center text-slate-400 text-xs">
                Tidak ada tugas yang sesuai filter saat ini.
            </div>
        @endforelse
    </div>

</div>
@endsection
