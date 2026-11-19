@extends('layouts.simak')

@section('title', 'Data Angkatan & Project DUDI • Admin TMS')

@section('content')
<div class="space-y-6 min-w-0 max-w-full">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-black tracking-tight text-slate-900">Data Angkatan & Project per Angkatan</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola angkatan magang (cohort/batch) serta produk software yang dibangun siswa PKL (1 angkatan dapat mengerjakan &gt;1 project).</p>
        </div>

        <div class="grid grid-cols-2 sm:flex sm:items-center gap-2 w-full sm:w-auto">
            <button onclick="openCreateProjectModal()" class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-red-600/25 flex items-center justify-center gap-1.5 text-center">
                <i data-lucide="plus-circle" class="w-4 h-4 shrink-0"></i>
                <span class="truncate">Tambah Project</span>
            </button>
            <button onclick="openCreateBatchModal()" class="px-3 py-2 bg-slate-900 hover:bg-black text-white text-xs font-bold rounded-xl transition-all shadow-xs flex items-center justify-center gap-1.5 text-center">
                <i data-lucide="calendar-plus" class="w-4 h-4 text-red-400 shrink-0"></i>
                <span class="truncate">Tambah Angkatan</span>
            </button>
        </div>
    </div>

    <!-- Quick Stats Cards (Compact 3-Cols on Mobile to Save Vertical Space) -->
    <div class="grid grid-cols-3 gap-2 sm:gap-4">
        <div class="mas-card p-3 sm:p-5 border-l-2 sm:border-l-4 border-l-slate-900 flex flex-col sm:flex-row sm:items-center justify-between gap-1">
            <div>
                <p class="text-slate-400 text-[10px] sm:text-[11px] font-bold uppercase tracking-wider mb-0.5 truncate">Total Angkatan</p>
                <h3 class="text-lg sm:text-2xl font-black text-slate-900 font-mono">{{ $batches->count() }} <span class="text-[10px] sm:text-xs font-normal text-slate-500">Batch</span></h3>
            </div>
            <div class="hidden sm:flex w-11 h-11 bg-slate-100 text-slate-900 rounded-xl items-center justify-center shrink-0">
                <i data-lucide="layers" class="w-5 h-5"></i>
            </div>
        </div>

        <div class="mas-card p-3 sm:p-5 border-l-2 sm:border-l-4 border-l-red-600 flex flex-col sm:flex-row sm:items-center justify-between gap-1">
            <div>
                <p class="text-slate-400 text-[10px] sm:text-[11px] font-bold uppercase tracking-wider mb-0.5 truncate">Project Digital</p>
                <h3 class="text-lg sm:text-2xl font-black text-slate-900 font-mono">{{ \App\Models\ShowcaseProject::count() }} <span class="text-[10px] sm:text-xs font-normal text-slate-500">App</span></h3>
            </div>
            <div class="hidden sm:flex w-11 h-11 bg-red-50 text-red-600 rounded-xl items-center justify-center shrink-0">
                <i data-lucide="folder-git-2" class="w-5 h-5"></i>
            </div>
        </div>

        <div class="mas-card p-3 sm:p-5 border-l-2 sm:border-l-4 border-l-emerald-600 flex flex-col sm:flex-row sm:items-center justify-between gap-1">
            <div>
                <p class="text-slate-400 text-[10px] sm:text-[11px] font-bold uppercase tracking-wider mb-0.5 truncate">Rata-rata/Batch</p>
                @php
                    $avg = $batches->count() > 0 ? round(\App\Models\ShowcaseProject::count() / $batches->count(), 1) : 0;
                @endphp
                <h3 class="text-lg sm:text-2xl font-black text-slate-900 font-mono">{{ $avg }} <span class="text-[10px] sm:text-xs font-normal text-slate-500">Proj</span></h3>
            </div>
            <div class="hidden sm:flex w-11 h-11 bg-emerald-50 text-emerald-600 rounded-xl items-center justify-center shrink-0">
                <i data-lucide="git-branch" class="w-5 h-5"></i>
            </div>
        </div>
    </div>

    <!-- Batch Selector Tabs -->
    <div class="flex items-center gap-2 overflow-x-auto pb-1 no-scrollbar">
        @foreach($batches as $batch)
            <a href="{{ route('admin.batches', ['batch_id' => $batch->id]) }}" 
               class="px-3.5 py-2 sm:px-4 sm:py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2 whitespace-nowrap {{ ($selectedBatchId == $batch->id) ? 'bg-red-600 text-white shadow-md shadow-red-600/25' : 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-50' }}">
                <i data-lucide="folder" class="w-3.5 h-3.5 {{ ($selectedBatchId == $batch->id) ? 'text-white' : 'text-slate-400' }}"></i>
                <span>{{ $batch->batch_name }}</span>
                <span class="px-1.5 py-0.5 rounded-md text-[10px] font-mono {{ ($selectedBatchId == $batch->id) ? 'bg-black/20 text-white' : 'bg-slate-100 text-slate-600' }}">
                    {{ $batch->showcase_projects_count ?? 0 }} Project
                </span>
            </a>
        @endforeach
    </div>

    <!-- Selected Batch Details Card -->
    @if($selectedBatch)
        <div class="mas-card p-4 sm:p-5 bg-gradient-to-r from-slate-900 to-slate-800 text-white flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded bg-red-600 text-white shrink-0">
                        Batch {{ $selectedBatch->period_year }}
                    </span>
                    <span class="text-[11px] sm:text-xs text-slate-300">Periode Pelaksanaan: <b>{{ \Carbon\Carbon::parse($selectedBatch->start_date)->translatedFormat('d M Y') }} – {{ \Carbon\Carbon::parse($selectedBatch->end_date)->translatedFormat('d M Y') }}</b></span>
                </div>
                <h2 class="text-lg sm:text-xl font-black mt-1.5">{{ $selectedBatch->batch_name }}</h2>
                <p class="text-xs text-slate-300 mt-0.5">Seluruh project perangkat lunak yang dikerjakan oleh siswa PKL di bawah bimbingan mentor industri PT. TMS pada batch ini.</p>
            </div>

            <div class="grid grid-cols-2 sm:flex sm:items-center gap-2 shrink-0 w-full sm:w-auto">
                <button 
                    onclick="openEditBatchModal({{ json_encode($selectedBatch) }})" 
                    class="px-3 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-semibold backdrop-blur-md transition-all flex items-center justify-center gap-1.5 border border-white/10 text-center">
                    <i data-lucide="edit-3" class="w-3.5 h-3.5 text-amber-400 shrink-0"></i>
                    <span class="truncate">Edit Angkatan</span>
                </button>
                <button 
                    onclick="openCreateProjectModal({{ $selectedBatch->id }})" 
                    class="px-3 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-bold transition-all shadow-md flex items-center justify-center gap-1.5 text-center">
                    <i data-lucide="plus" class="w-3.5 h-3.5 shrink-0"></i>
                    <span class="truncate">+ Project Batch</span>
                </button>
            </div>
        </div>
    @endif

    <!-- Projects Table & Cards in this Batch -->
    <div class="mas-card overflow-hidden">
        <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-slate-900 text-white flex items-center justify-center shrink-0">
                    <i data-lucide="folder-git-2" class="w-4 h-4"></i>
                </div>
                <div>
                    <h3 class="text-sm font-black text-slate-900">Daftar Project Angkatan ({{ $projects->count() }})</h3>
                    <p class="text-[11px] text-slate-400">1 angkatan dapat mempublikasikan lebih dari 1 project nyata.</p>
                </div>
            </div>
            <span class="text-[11px] font-mono text-slate-500 font-semibold shrink-0">
                {{ $selectedBatch->batch_name ?? 'Batch' }}
            </span>
        </div>

        <div class="p-4 sm:p-5 grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($projects as $project)
                <div class="p-4 sm:p-5 rounded-2xl border border-slate-200 bg-white hover:border-red-400/50 hover:shadow-md transition-all flex flex-col justify-between space-y-3 relative group">
                    <div>
                        <!-- Header: Kategori & Status (Anti-collision on Mobile) -->
                        <div class="flex flex-wrap items-center justify-between gap-1.5 mb-2">
                            <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full bg-slate-100 text-slate-700 border border-slate-200 truncate max-w-[190px] sm:max-w-none">
                                {{ $project->project_category ?? 'Web Application' }}
                            </span>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center gap-1 shrink-0">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse shrink-0"></span>
                                <span>{{ $project->status ?? 'Completed & Deployed' }}</span>
                            </span>
                        </div>

                        <!-- Title & Description -->
                        <h4 class="text-base font-black text-slate-900 leading-snug">{{ $project->title }}</h4>
                        <p class="text-xs text-slate-600 mt-1 leading-relaxed">{{ $project->short_description }}</p>

                        <!-- Tech Stack Tags -->
                        <div class="mt-3">
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Teknologi yang Dipakai:</div>
                            <div class="flex flex-wrap gap-1">
                                @foreach(explode(',', $project->tech_stack) as $t)
                                    <span class="text-[10px] font-mono font-medium px-2 py-0.5 rounded bg-slate-100 text-slate-800 border border-slate-200">
                                        {{ trim($t) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <!-- Team Members (Anggota Tim) -->
                        <div class="mt-3 p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider flex items-center gap-1">
                                <i data-lucide="users" class="w-3 h-3 text-red-500"></i>
                                <span>Anggota Tim Pengembang:</span>
                            </div>
                            <div class="text-xs font-semibold text-slate-800 mt-0.5">
                                {{ $project->team_members }}
                            </div>
                        </div>
                    </div>

                    <!-- Footer: Links & Action Buttons -->
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2">
                            @if($project->repo_url)
                                <a href="{{ $project->repo_url }}" target="_blank" class="px-2.5 py-1 rounded-lg bg-slate-900 hover:bg-black text-white text-[11px] font-mono font-medium flex items-center gap-1.5 shadow-2xs transition-colors">
                                    <svg class="w-3.5 h-3.5 fill-current shrink-0" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/></svg>
                                    <span>Repo</span>
                                </a>
                            @endif
                            @if($project->live_url)
                                <a href="{{ $project->live_url }}" target="_blank" class="px-2.5 py-1 rounded-lg bg-red-600 hover:bg-red-700 text-white text-[11px] font-bold flex items-center gap-1.5 shadow-2xs transition-colors">
                                    <i data-lucide="external-link" class="w-3 h-3"></i>
                                    <span>Live</span>
                                </a>
                            @endif
                        </div>

                        <div class="relative inline-block text-left dropdown-container">
                            <button type="button" onclick="toggleActionDropdown(this, event)" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 hover:text-slate-900 transition-colors flex items-center justify-center cursor-pointer ml-auto" title="Opsi Aksi Project">
                                <i data-lucide="more-vertical" class="w-4 h-4"></i>
                            </button>
                            <div class="action-dropdown hidden absolute right-0 bottom-full mb-1.5 w-44 bg-white rounded-2xl shadow-xl border border-slate-100 py-1.5 z-40 divide-y divide-slate-100 text-left animate-in fade-in zoom-in-95 duration-100">
                                <div class="py-1">
                                    <button type="button" 
                                            onclick="openEditProjectModal({{ json_encode($project) }})" 
                                            class="w-full flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors text-left cursor-pointer">
                                        <i data-lucide="edit-3" class="w-3.5 h-3.5 text-slate-400"></i>
                                        <span>Edit Project</span>
                                    </button>
                                </div>
                                <div class="py-1">
                                    <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Hapus project {{ addslashes($project->title) }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-red-600 hover:bg-red-50 transition-colors text-left cursor-pointer">
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5 text-red-500"></i>
                                            <span>Hapus Project</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-2 p-10 text-center text-slate-400 text-xs">
                    Belum ada project yang didaftarkan untuk angkatan ini. Klik tombol <b>"Tambah Project Baru"</b> untuk menambahkan.
                </div>
            @endforelse
        </div>
    </div>

</div>

<!-- ============================================================== -->
<!-- MODAL 1: TAMBAH / EDIT PROJECT ANGKATAN                        -->
<!-- ============================================================== -->
<div id="modal-project" class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 space-y-4 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-xl bg-red-600 text-white flex items-center justify-center shrink-0 aspect-square">
                    <i data-lucide="folder-plus" class="w-4 h-4"></i>
                </div>
                <div>
                    <h3 id="modal-project-title" class="text-sm font-black text-slate-900">Tambah Project Angkatan</h3>
                    <p class="text-[10px] text-slate-400">1 Angkatan dapat memiliki lebih dari 1 project digital.</p>
                </div>
            </div>
            <button onclick="closeProjectModal()" class="text-slate-400 hover:text-slate-700">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="form-project" method="POST" action="{{ route('admin.projects.store') }}" class="space-y-3">
            @csrf
            <div id="project-method-spoof"></div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Pilih Angkatan (Batch) *</label>
                <select id="proj-batch-id" name="batch_id" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    @foreach($batches as $b)
                        <option value="{{ $b->id }}" {{ $selectedBatchId == $b->id ? 'selected' : '' }}>{{ $b->batch_name }} ({{ $b->period_year }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Judul / Nama Project *</label>
                <input type="text" id="proj-title" name="title" required placeholder="Contoh: SIMAK-TMS / TechPulse Engineering" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Kategori Project *</label>
                    <select id="proj-category" name="project_category" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                        <option value="Enterprise LMS & Activity Tracker">Enterprise LMS & Activity Tracker</option>
                        <option value="Engineering Blog & Documentation">Engineering Blog & Documentation</option>
                        <option value="Internal Lab Geofencing Attendance">Internal Lab Geofencing Attendance</option>
                        <option value="Fintech & Billing SLA">Fintech & Billing SLA</option>
                        <option value="Web Application & API">Web Application & API</option>
                        <option value="Mobile App (PWA)">Mobile App (PWA)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Status Deploy *</label>
                    <select id="proj-status" name="status" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                        <option value="Completed & Deployed">Completed & Deployed</option>
                        <option value="In Production">In Production</option>
                        <option value="Under Development">Under Development</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Teknologi yang Dipakai (Tech Stack) *</label>
                <input type="text" id="proj-tech" name="tech_stack" required placeholder="Contoh: Laravel 11, Tailwind CSS, SQLite, Chart.js" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Anggota Tim Pengembang (Siswa PKL) *</label>
                <input type="text" id="proj-members" name="team_members" required placeholder="Contoh: Pradipta Endra Maulana (Lead Dev), Farhan (Mentor)" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Singkat Project *</label>
                <textarea id="proj-desc" name="short_description" rows="2" required placeholder="Deskripsi ringkas tujuan dan fungsi sistem yang dibangun..." class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">URL Repository Git</label>
                    <input type="text" id="proj-repo" name="repo_url" placeholder="https://github.com/..." class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">URL Live Demo</label>
                    <input type="text" id="proj-live" name="live_url" placeholder="https://app.tms.co.id" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                </div>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeProjectModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl shadow-md shadow-red-600/25">
                    Simpan Project
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL 2: TAMBAH / EDIT ANGKATAN (BATCH)                        -->
<!-- ============================================================== -->
<div id="modal-batch" class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-100 space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-xl bg-slate-900 text-white flex items-center justify-center shrink-0 aspect-square">
                    <i data-lucide="calendar" class="w-4 h-4"></i>
                </div>
                <div>
                    <h3 id="modal-batch-title" class="text-sm font-black text-slate-900">Tambah Angkatan Baru</h3>
                    <p class="text-[10px] text-slate-400">Periode angkatan magang PT. TMS</p>
                </div>
            </div>
            <button onclick="closeBatchModal()" class="text-slate-400 hover:text-slate-700">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="form-batch" method="POST" action="{{ route('admin.batches.store') }}" class="space-y-3">
            @csrf
            <div id="batch-method-spoof"></div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Angkatan (Batch) *</label>
                <input type="text" id="batch-name" name="batch_name" required placeholder="Contoh: Angkatan 2027" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Tahun Pelaksanaan *</label>
                <input type="number" id="batch-year" name="period_year" required value="2026" min="2020" max="2035" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Mulai *</label>
                    <input type="date" id="batch-start" name="start_date" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Selesai *</label>
                    <input type="date" id="batch-end" name="end_date" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                </div>
            </div>

            <div class="flex items-center gap-2 pt-1">
                <input type="checkbox" id="batch-active" name="is_active" value="1" checked class="rounded border-slate-300 text-red-600 focus:ring-red-500">
                <label for="batch-active" class="text-xs font-semibold text-slate-700">Set sebagai Angkatan Aktif</label>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeBatchModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-slate-900 hover:bg-black text-white text-xs font-bold rounded-xl shadow-xs">
                    Simpan Angkatan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openCreateProjectModal(batchId = null) {
        const modal = document.getElementById('modal-project');
        const form = document.getElementById('form-project');
        document.getElementById('modal-project-title').innerText = 'Tambah Project Angkatan Baru';
        form.action = "{{ route('admin.projects.store') }}";
        document.getElementById('project-method-spoof').innerHTML = '';
        
        document.getElementById('proj-title').value = '';
        document.getElementById('proj-tech').value = 'Laravel 11, Tailwind CSS, SQLite';
        document.getElementById('proj-members').value = 'Pradipta Endra Maulana (Lead Dev)';
        document.getElementById('proj-desc').value = '';
        document.getElementById('proj-repo').value = '';
        document.getElementById('proj-live').value = '';

        if (batchId) {
            document.getElementById('proj-batch-id').value = batchId;
        }

        modal.classList.remove('hidden');
    }

    function openEditProjectModal(project) {
        const modal = document.getElementById('modal-project');
        const form = document.getElementById('form-project');
        document.getElementById('modal-project-title').innerText = 'Edit Project Angkatan';
        form.action = "{{ url('/admin/projects') }}/" + project.id;
        document.getElementById('project-method-spoof').innerHTML = '<input type="hidden" name="_method" value="PUT">';

        document.getElementById('proj-batch-id').value = project.batch_id;
        document.getElementById('proj-title').value = project.title || '';
        document.getElementById('proj-category').value = project.project_category || 'Web Application';
        document.getElementById('proj-status').value = project.status || 'Completed & Deployed';
        document.getElementById('proj-tech').value = project.tech_stack || '';
        document.getElementById('proj-members').value = project.team_members || '';
        document.getElementById('proj-desc').value = project.short_description || '';
        document.getElementById('proj-repo').value = project.repo_url || '';
        document.getElementById('proj-live').value = project.live_url || '';

        modal.classList.remove('hidden');
    }

    function closeProjectModal() {
        document.getElementById('modal-project').classList.add('hidden');
    }

    function openCreateBatchModal() {
        const modal = document.getElementById('modal-batch');
        const form = document.getElementById('form-batch');
        document.getElementById('modal-batch-title').innerText = 'Tambah Angkatan Baru';
        form.action = "{{ route('admin.batches.store') }}";
        document.getElementById('batch-method-spoof').innerHTML = '';

        document.getElementById('batch-name').value = '';
        document.getElementById('batch-year').value = 2026;
        document.getElementById('batch-start').value = '';
        document.getElementById('batch-end').value = '';
        document.getElementById('batch-active').checked = true;

        modal.classList.remove('hidden');
    }

    function openEditBatchModal(batch) {
        const modal = document.getElementById('modal-batch');
        const form = document.getElementById('form-batch');
        document.getElementById('modal-batch-title').innerText = 'Edit Angkatan Magang';
        form.action = "{{ url('/admin/angkatan') }}/" + batch.id;
        document.getElementById('batch-method-spoof').innerHTML = '<input type="hidden" name="_method" value="PUT">';

        document.getElementById('batch-name').value = batch.batch_name || '';
        document.getElementById('batch-year').value = batch.period_year || 2026;
        document.getElementById('batch-start').value = batch.start_date || '';
        document.getElementById('batch-end').value = batch.end_date || '';
        document.getElementById('batch-active').checked = !!batch.is_active;

        modal.classList.remove('hidden');
    }

    function closeBatchModal() {
        document.getElementById('modal-batch').classList.add('hidden');
    }
</script>
@endsection
