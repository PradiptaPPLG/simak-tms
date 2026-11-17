@extends('layouts.simak')

@section('title', 'Showcase & Portofolio Project Angkatan • SIMAK-TMS')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-red-50 text-red-600 border border-red-200 text-[10px] font-bold uppercase tracking-wider mb-1">
                <span class="w-1.5 h-1.5 rounded-full bg-red-600 animate-pulse"></span>
                Repositori Produk Nyata & Portofolio Angkatan PKL
            </div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900">Showcase & Project per Angkatan</h1>
            <p class="text-xs text-slate-500 mt-0.5">Repositori produk digital, aplikasi web, dan sistem internal yang dibangun siswa PKL di bawah standar industri PT. TMS (1 angkatan &gt; 1 project).</p>
        </div>
    </div>

    <!-- Batch Quick Tabs -->
    <div class="flex items-center gap-2 overflow-x-auto pb-1 no-scrollbar">
        <a href="{{ route('showcase.index') }}" 
           class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 whitespace-nowrap {{ !$selectedBatchId ? 'bg-slate-900 text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
            <i data-lucide="grid" class="w-3.5 h-3.5"></i>
            <span>Semua Project ({{ $projects->count() }})</span>
        </a>
        @foreach($batches as $batch)
            <a href="{{ route('showcase.index', ['batch_id' => $batch->id]) }}" 
               class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 whitespace-nowrap {{ ($selectedBatchId == $batch->id) ? 'bg-red-600 text-white shadow-md shadow-red-600/25' : 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-50' }}">
                <i data-lucide="folder" class="w-3.5 h-3.5 {{ ($selectedBatchId == $batch->id) ? 'text-white' : 'text-slate-400' }}"></i>
                <span>{{ $batch->batch_name }}</span>
                <span class="px-1.5 py-0.5 rounded text-[10px] font-mono {{ ($selectedBatchId == $batch->id) ? 'bg-black/20 text-white' : 'bg-slate-100 text-slate-600' }}">
                    {{ $batch->showcase_projects_count ?? 0 }}
                </span>
            </a>
        @endforeach
    </div>

    <!-- Projects Grid (1 Angkatan > 1 Project) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        @forelse($projects as $project)
            <div class="mas-card p-6 flex flex-col justify-between space-y-4 hover:border-red-400/50 hover:shadow-lg transition-all group relative overflow-hidden">
                <!-- Top Accent Line -->
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-slate-900 via-red-600 to-amber-500 opacity-80 group-hover:opacity-100 transition-opacity"></div>

                <div class="space-y-3">
                    <!-- Badges Row: Angkatan, Kategori, Status -->
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <div class="flex items-center gap-1.5 flex-wrap">
                            <span class="text-[10px] font-bold uppercase px-2.5 py-0.5 rounded-full bg-red-50 text-red-600 border border-red-200">
                                {{ $project->batch->batch_name ?? 'Angkatan 2026' }}
                            </span>
                            <span class="text-[10px] font-semibold px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 border border-slate-200">
                                {{ $project->project_category ?? 'Web Application' }}
                            </span>
                        </div>

                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            {{ $project->status ?? 'Completed & Deployed' }}
                        </span>
                    </div>

                    <!-- Title & Short Description -->
                    <div>
                        <h3 class="text-base font-black text-slate-900 leading-snug group-hover:text-red-600 transition-colors">
                            {{ $project->title }}
                        </h3>
                        <p class="text-xs text-slate-600 mt-1.5 leading-relaxed">
                            {{ $project->short_description ?? $project->full_description }}
                        </p>
                    </div>

                    <!-- Tech Stack Pills -->
                    <div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Teknologi yang Digunakan:</div>
                        @php
                            $stacks = is_array($project->tech_stack) ? $project->tech_stack : explode(',', $project->tech_stack);
                        @endphp
                        <div class="flex flex-wrap gap-1">
                            @foreach($stacks as $tech)
                                <span class="text-[10px] font-mono font-medium px-2 py-0.5 rounded bg-slate-50 text-slate-800 border border-slate-200">
                                    {{ trim($tech) }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <!-- Team Members (Anggota Tim Siswa PKL) -->
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider flex items-center gap-1">
                            <i data-lucide="users" class="w-3.5 h-3.5 text-red-600"></i>
                            <span>Anggota Tim Pengembang:</span>
                        </div>
                        <div class="text-xs font-semibold text-slate-800 mt-0.5">
                            {{ $project->team_members ?? ($project->creator->name ?? 'Tim Siswa PKL') }}
                        </div>
                    </div>
                </div>

                <!-- Footer: Asal Sekolah & Tautan Demo / Git -->
                <div class="border-t border-slate-100 pt-4 flex items-center justify-between text-xs">
                    <div class="text-[11px] text-slate-400">
                        Instansi Mitra: <span class="text-slate-800 font-semibold">{{ $project->creator->school_origin ?? 'SMKN 1 Ciamis' }}</span>
                    </div>

                    <div class="flex items-center gap-2">
                        @if($project->repo_url)
                            <a href="{{ $project->repo_url }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-slate-900 hover:bg-black text-white text-xs font-semibold transition-colors flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 fill-current shrink-0 text-slate-200" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/></svg>
                                <span>Git Repo</span>
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
            <div class="mas-card p-12 text-center text-slate-400 text-xs md:col-span-2 space-y-2">
                <i data-lucide="folder-x" class="w-8 h-8 mx-auto text-slate-300"></i>
                <p>Belum ada portofolio project pada angkatan yang dipilih.</p>
            </div>
        @endforelse
    </div>

</div>
@endsection
