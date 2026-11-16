@extends('layouts.simak')

@section('title', 'Showcase & Arsip Karya • SIMAK-TMS')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900">Showcase & Arsip Karya Siswa</h1>
            <p class="text-xs text-slate-500 mt-1">Repositori produk digital, website, dan aplikasi yang dibangun siswa PKL di PT. TMS.</p>
        </div>

        <!-- Batch Filter Selector -->
        <form method="GET" action="{{ route('showcase.index') }}" class="flex items-center gap-2">
            <span class="text-xs text-slate-500 font-medium">Angkatan:</span>
            <select name="batch_id" onchange="this.form.submit()" class="bg-white border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-700 font-semibold focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 shadow-xs">
                <option value="">Semua Angkatan</option>
                @foreach($batches as $batch)
                    <option value="{{ $batch->id }}" {{ ($selectedBatchId ?? null) == $batch->id ? 'selected' : '' }}>
                        {{ $batch->name }} ({{ $batch->year }})
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    <!-- Projects Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        @forelse($projects as $project)
            <div class="mas-card p-6 flex flex-col justify-between space-y-4">
                <div>
                    <!-- Badge & Meta -->
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <span class="text-[10px] font-bold uppercase px-2.5 py-0.5 rounded-full bg-red-50 text-red-600 border border-red-200">
                            {{ $project->batch->name ?? 'Angkatan Magang' }}
                        </span>
                        <span class="text-xs text-slate-400">Pengembang: <b class="text-slate-700">{{ $project->creator->name ?? 'Pradipta Endra Maulana' }}</b></span>
                    </div>

                    <h3 class="text-base font-bold text-slate-900">{{ $project->title }}</h3>
                    <p class="text-xs text-slate-600 mt-1.5 leading-relaxed">{{ $project->short_description ?? $project->description }}</p>

                    <!-- Tech Stack Tags -->
                    @php
                        $stacks = is_array($project->tech_stack) ? $project->tech_stack : explode(',', $project->tech_stack);
                    @endphp
                    <div class="mt-3 flex flex-wrap gap-1.5">
                        @foreach($stacks as $tech)
                            <span class="text-[10px] font-mono font-medium px-2 py-0.5 rounded bg-slate-100 text-slate-700 border border-slate-200">
                                {{ trim($tech) }}
                            </span>
                        @endforeach
                    </div>
                </div>

                <!-- Footer Links -->
                <div class="border-t border-slate-100 pt-4 flex items-center justify-between text-xs">
                    <div class="text-[11px] text-slate-400">
                        Sekolah: <span class="text-slate-700 font-semibold">{{ $project->creator->school_origin ?? 'SMKN 1 Ciamis' }}</span>
                    </div>

                    <div class="flex items-center gap-2">
                        @if($project->repo_url ?? $project->repository_url)
                            <a href="{{ $project->repo_url ?? $project->repository_url }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-slate-900 hover:bg-black text-white text-xs font-semibold transition-colors flex items-center gap-1.5">
                                <i data-lucide="git-branch" class="w-3.5 h-3.5 text-slate-300"></i>
                                <span>Git</span>
                            </a>
                        @endif

                        @if($project->live_url)
                            <a href="{{ $project->live_url }}" target="_blank" class="px-3.5 py-1.5 rounded-lg bg-red-600 hover:bg-red-700 text-white text-xs font-bold transition-colors flex items-center gap-1.5 shadow-xs">
                                <span>Live Demo</span>
                                <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="mas-card p-8 text-center text-slate-400 text-xs md:col-span-2">
                Belum ada portofolio karya pada angkatan ini.
            </div>
        @endforelse
    </div>

</div>
@endsection
