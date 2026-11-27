@extends('layouts.simak')

@section('title', 'Data Angkatan & Project DUDI • Admin TMS')

@section('content')
<div class="space-y-6 min-w-0 max-w-full">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-black tracking-tight text-slate-900">Data Angkatan & Penilaian DUDI</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola angkatan magang (cohort/batch), input nilai rapor industri siswa per angkatan, dan katalog project digital.</p>
        </div>

        <div class="grid grid-cols-2 sm:flex sm:items-center gap-2 w-full sm:w-auto">
            <button onclick="openEnrollStudentModal()" class="px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-emerald-600/25 flex items-center justify-center gap-1.5 text-center cursor-pointer">
                <i data-lucide="user-plus" class="w-4 h-4 shrink-0"></i>
                <span class="truncate">Daftarkan Siswa</span>
            </button>
            <button onclick="openCreateProjectModal({{ $selectedBatchId }})" class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-red-600/25 flex items-center justify-center gap-1.5 text-center cursor-pointer">
                <i data-lucide="plus-circle" class="w-4 h-4 shrink-0"></i>
                <span class="truncate">Tambah Project</span>
            </button>
            <button onclick="openCreateBatchModal()" class="px-3 py-2 bg-slate-900 hover:bg-black text-white text-xs font-bold rounded-xl transition-all shadow-xs flex items-center justify-center gap-1.5 text-center cursor-pointer col-span-2 sm:col-span-1">
                <i data-lucide="calendar-plus" class="w-4 h-4 text-red-400 shrink-0"></i>
                <span class="truncate">Tambah Angkatan</span>
            </button>
        </div>
    </div>

    <!-- Quick Stats Cards (Compact 3-Cols) -->
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

        <div class="mas-card p-3 sm:p-5 border-l-2 sm:border-l-4 border-l-emerald-600 flex flex-col sm:flex-row sm:items-center justify-between gap-1">
            <div>
                <p class="text-slate-400 text-[10px] sm:text-[11px] font-bold uppercase tracking-wider mb-0.5 truncate">Siswa Terdaftar (Batch Ini)</p>
                <h3 class="text-lg sm:text-2xl font-black text-emerald-700 font-mono">{{ $batchStudents->count() }} <span class="text-[10px] sm:text-xs font-normal text-slate-500">Siswa</span></h3>
            </div>
            <div class="hidden sm:flex w-11 h-11 bg-emerald-50 text-emerald-600 rounded-xl items-center justify-center shrink-0">
                <i data-lucide="users" class="w-5 h-5"></i>
            </div>
        </div>

        <div class="mas-card p-3 sm:p-5 border-l-2 sm:border-l-4 border-l-red-600 flex flex-col sm:flex-row sm:items-center justify-between gap-1">
            <div>
                <p class="text-slate-400 text-[10px] sm:text-[11px] font-bold uppercase tracking-wider mb-0.5 truncate">Project Digital</p>
                <h3 class="text-lg sm:text-2xl font-black text-slate-900 font-mono">{{ $projects->count() }} <span class="text-[10px] sm:text-xs font-normal text-slate-500">App</span></h3>
            </div>
            <div class="hidden sm:flex w-11 h-11 bg-red-50 text-red-600 rounded-xl items-center justify-center shrink-0">
                <i data-lucide="folder-git-2" class="w-5 h-5"></i>
            </div>
        </div>
    </div>

    <!-- Batch Selector Tabs -->
    <div class="flex items-center gap-2 overflow-x-auto pb-1 no-scrollbar">
        @foreach($batches as $batch)
            @php
                $isSel = ($selectedBatchId == $batch->id);
                $bStudentCount = \App\Models\BatchStudent::where('batch_id', $batch->id)->count();
            @endphp
            <a href="{{ route('admin.batches', ['batch_id' => $batch->id, 'tab' => $activeTab]) }}" 
               class="px-3.5 py-2 sm:px-4 sm:py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2 whitespace-nowrap {{ $isSel ? 'bg-red-600 text-white shadow-md shadow-red-600/25' : 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-50' }}">
                <i data-lucide="folder" class="w-3.5 h-3.5 {{ $isSel ? 'text-white' : 'text-slate-400' }}"></i>
                <span>{{ $batch->batch_name }}</span>
                <span class="px-1.5 py-0.5 rounded-md text-[10px] font-mono {{ $isSel ? 'bg-black/20 text-white' : 'bg-slate-100 text-slate-600' }}">
                    {{ $bStudentCount }} Siswa
                </span>
            </a>
        @endforeach
    </div>

    <!-- Selected Batch Details Card -->
    @if($selectedBatch)
        <div class="mas-card p-4 sm:p-5 bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 text-white flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded bg-red-600 text-white shrink-0">
                        Batch {{ $selectedBatch->period_year }}
                    </span>
                    <span class="text-[11px] sm:text-xs text-slate-300">Periode Pelaksanaan: <b>{{ \Carbon\Carbon::parse($selectedBatch->start_date)->translatedFormat('d M Y') }} – {{ \Carbon\Carbon::parse($selectedBatch->end_date)->translatedFormat('d M Y') }}</b></span>
                    @if($selectedBatch->is_active)
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                            Angkatan Aktif
                        </span>
                    @endif
                </div>
                <h2 class="text-lg sm:text-xl font-black mt-1.5">{{ $selectedBatch->batch_name }}</h2>
                <p class="text-xs text-slate-300 mt-0.5">Kelola data siswa, penilaian manual rapor DUDI 4 pilar, serta showcase produk software pada angkatan ini.</p>
            </div>

            <div class="flex flex-wrap items-center gap-2 shrink-0">
                <button 
                    onclick="openEnrollStudentModal()" 
                    class="px-3 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-all shadow-md flex items-center justify-center gap-1.5 cursor-pointer">
                    <i data-lucide="user-plus" class="w-3.5 h-3.5 shrink-0"></i>
                    <span>+ Siswa ke Batch</span>
                </button>
                <button 
                    onclick="openEditBatchModal({{ json_encode($selectedBatch) }})" 
                    class="px-3 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-semibold backdrop-blur-md transition-all flex items-center justify-center gap-1.5 border border-white/10 cursor-pointer">
                    <i data-lucide="edit-3" class="w-3.5 h-3.5 text-amber-400 shrink-0"></i>
                    <span>Edit Batch</span>
                </button>
            </div>
        </div>
    @endif

    <!-- Tab Switcher: Siswa & Rapor DUDI vs Project Digital Angkatan -->
    <div class="grid grid-cols-2 sm:flex sm:items-center gap-1 sm:gap-2 border-b border-slate-200">
        <a href="{{ route('admin.batches', ['batch_id' => $selectedBatchId, 'tab' => 'students']) }}"
           class="px-2.5 sm:px-4 py-2.5 text-[11px] sm:text-xs font-bold transition-all flex items-center justify-center sm:justify-start gap-1.5 sm:gap-2 border-b-2 whitespace-nowrap {{ $activeTab === 'students' ? 'border-red-600 text-red-600' : 'border-transparent text-slate-500 hover:text-slate-900' }}">
            <i data-lucide="users" class="w-3.5 h-3.5 sm:w-4 sm:h-4 shrink-0"></i>
            <span class="sm:hidden">Rapor Siswa</span>
            <span class="hidden sm:inline">Siswa &amp; Penilaian Rapor DUDI</span>
            <span class="px-1.5 sm:px-2 py-0.5 text-[10px] font-mono rounded-full shrink-0 {{ $activeTab === 'students' ? 'bg-red-50 text-red-700 font-black' : 'bg-slate-100 text-slate-600' }}">
                {{ $batchStudents->count() }}
            </span>
        </a>
        <a href="{{ route('admin.batches', ['batch_id' => $selectedBatchId, 'tab' => 'projects']) }}"
           class="px-2.5 sm:px-4 py-2.5 text-[11px] sm:text-xs font-bold transition-all flex items-center justify-center sm:justify-start gap-1.5 sm:gap-2 border-b-2 whitespace-nowrap {{ $activeTab === 'projects' ? 'border-red-600 text-red-600' : 'border-transparent text-slate-500 hover:text-slate-900' }}">
            <i data-lucide="folder-git-2" class="w-3.5 h-3.5 sm:w-4 sm:h-4 shrink-0"></i>
            <span class="sm:hidden">Project Angkatan</span>
            <span class="hidden sm:inline">Project Digital Angkatan</span>
            <span class="px-1.5 sm:px-2 py-0.5 text-[10px] font-mono rounded-full shrink-0 {{ $activeTab === 'projects' ? 'bg-red-50 text-red-700 font-black' : 'bg-slate-100 text-slate-600' }}">
                {{ $projects->count() }}
            </span>
        </a>
    </div>

    @if($activeTab === 'students')
        <!-- ============================================================== -->
        <!-- TAB 1: SISWA & PENILAIAN RAPOR DUDI ANGKATAN                    -->
        <!-- ============================================================== -->
        <div class="mas-card overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-slate-900 text-white flex items-center justify-center shrink-0">
                        <i data-lucide="award" class="w-4 h-4 text-amber-400"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-slate-900">Daftar Siswa & Rapor DUDI ({{ $batchStudents->count() }} Siswa)</h3>
                        <p class="text-[11px] text-slate-400">Penilaian 4 pilar industri independen per angkatan — mentor dan admin dapat mengedit nilai manual.</p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <button onclick="openEnrollStudentModal()" class="px-3 py-1.5 rounded-xl bg-slate-900 hover:bg-black text-white text-xs font-bold transition-all flex items-center gap-1.5 cursor-pointer">
                        <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                        <span>Daftarkan Siswa ke Batch</span>
                    </button>
                </div>
            </div>

            <!-- Mobile Card List (Responsive < 768px) -->
            <div class="md:hidden divide-y divide-slate-100">
                @forelse($batchStudents as $bs)
                    @php
                        $student = $bs->student;
                        $mentor = $bs->mentor ?? $student->mentor ?? null;
                    @endphp
                    <div class="p-4 space-y-3 hover:bg-slate-50/70 transition-colors">
                        <!-- Row 1: Avatar, Name, ID & Score/Grade -->
                        <div class="flex items-start justify-between gap-2.5">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden shrink-0 flex items-center justify-center font-bold text-slate-700 text-xs">
                                    @if($student && $student->avatar)
                                        <img src="{{ asset($student->avatar) }}" alt="{{ $student->name }}" class="w-full h-full object-cover">
                                    @else
                                        <span>{{ strtoupper(substr($student->name ?? 'S', 0, 1)) }}</span>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <div class="font-black text-slate-900 text-xs truncate">
                                        @if($student)
                                            <a href="{{ $student->profile_url }}" target="_blank" class="hover:text-red-600 hover:underline">{{ $student->name }}</a>
                                        @else
                                            <span>(User Tidak Ditemukan)</span>
                                        @endif
                                    </div>
                                    <div class="text-[10px] text-slate-400 font-mono truncate">
                                        ID: {{ $student->account_id ?? $student->id ?? '-' }} • {{ $bs->role_title ?? 'Software Engineer Intern' }}
                                    </div>
                                </div>
                            </div>

                            <div class="text-right shrink-0">
                                <div class="font-mono text-sm font-black text-slate-900 leading-none">{{ number_format($bs->final_score, 1) }}</div>
                                <span class="inline-block px-2 py-0.5 mt-1 rounded-full text-[9.5px] font-black {{ in_array($bs->grade, ['A', 'A-']) ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : (in_array($bs->grade, ['B+', 'B', 'B-']) ? 'bg-blue-100 text-blue-800 border border-blue-300' : 'bg-amber-100 text-amber-800 border border-amber-300') }}">
                                    Grade {{ $bs->grade }}
                                </span>
                            </div>
                        </div>

                        <!-- Row 2: School & Mentor Grid -->
                        <div class="grid grid-cols-2 gap-2 text-[11px] bg-slate-50/80 p-2.5 rounded-xl border border-slate-100">
                            <div class="min-w-0">
                                <div class="text-[9.5px] font-bold text-slate-400 uppercase">Instansi &amp; Jurusan</div>
                                <div class="font-semibold text-slate-800 truncate mt-0.5">{{ $bs->institution_name ?: ($student->school_origin ?? 'SMKN 1 Ciamis') }}</div>
                                <div class="text-[10px] text-slate-500 truncate">{{ $bs->major ?: ($student->major ?? 'PPLG') }}</div>
                            </div>
                            <div class="min-w-0">
                                <div class="text-[9.5px] font-bold text-slate-400 uppercase">Mentor Pembimbing</div>
                                @if($mentor)
                                    <div class="font-semibold text-slate-800 truncate mt-0.5">{{ $mentor->name }}</div>
                                    <div class="text-[10px] text-slate-400 truncate">{{ $mentor->email }}</div>
                                @else
                                    <div class="text-amber-600 italic text-[10.5px] mt-0.5">Belum ditentukan</div>
                                @endif
                            </div>
                        </div>

                        <!-- Row 3: 4 Pilar Nilai -->
                        <div class="grid grid-cols-4 gap-1.5 text-[10px] font-mono text-center">
                            <div class="px-1.5 py-1 rounded-lg bg-slate-100 text-slate-700">Tek: <b>{{ $bs->technical_skill }}</b></div>
                            <div class="px-1.5 py-1 rounded-lg bg-slate-100 text-slate-700">Dis: <b>{{ $bs->discipline }}</b></div>
                            <div class="px-1.5 py-1 rounded-lg bg-slate-100 text-slate-700">Tim: <b>{{ $bs->teamwork }}</b></div>
                            <div class="px-1.5 py-1 rounded-lg bg-slate-100 text-slate-700">Ini: <b>{{ $bs->initiative }}</b></div>
                        </div>

                        <!-- Row 4: Certificate & Actions -->
                        <div class="flex items-center justify-between gap-2 pt-1">
                            <div class="min-w-0 text-[10px]">
                                @if($bs->certificate_number)
                                    <a href="{{ route('verify.show', $bs->certificate_number) }}" target="_blank" class="font-mono text-red-600 hover:underline font-semibold truncate block">
                                        {{ $bs->certificate_number }}
                                    </a>
                                @else
                                    <span class="text-slate-400 italic">Sertifikat belum terbit</span>
                                @endif
                            </div>
                            <div class="flex items-center gap-1.5 shrink-0">
                                <button onclick='openGradeStudentModal(@json($bs), @json($student))' class="px-2.5 py-1.5 rounded-lg bg-red-50 hover:bg-red-600 text-red-600 hover:text-white text-[11px] font-bold transition-all flex items-center gap-1 cursor-pointer">
                                    <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                    <span>Nilai DUDI</span>
                                </button>
                                <form action="{{ route('admin.batch_students.destroy', $bs->id) }}" method="POST" onsubmit="return confirm('Keluarkan siswa {{ addslashes($student->name ?? 'ini') }} dari {{ addslashes($selectedBatch->batch_name) }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-lg bg-slate-100 hover:bg-red-100 text-slate-500 hover:text-red-600 transition-colors cursor-pointer" title="Keluarkan dari Angkatan">
                                        <i data-lucide="user-x" class="w-3.5 h-3.5"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-slate-400 text-xs">
                        Belum ada siswa yang didaftarkan pada angkatan ini.
                    </div>
                @endforelse
            </div>

            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                            <th class="py-3 px-4">Siswa PKL</th>
                            <th class="py-3 px-4">Asal Instansi & Jurusan</th>
                            <th class="py-3 px-4">Mentor Pembimbing</th>
                            <th class="py-3 px-3 text-center">4 Pilar Nilai</th>
                            <th class="py-3 px-4 text-center">Nilai Akhir</th>
                            <th class="py-3 px-4 text-center">Status & Sertifikat</th>
                            <th class="py-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($batchStudents as $bs)
                            @php
                                $student = $bs->student;
                                $mentor = $bs->mentor ?? $student->mentor ?? null;
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden shrink-0 flex items-center justify-center font-bold text-slate-700">
                                            @if($student && $student->avatar)
                                                <img src="{{ asset($student->avatar) }}" alt="{{ $student->name }}" class="w-full h-full object-cover">
                                            @else
                                                <span>{{ strtoupper(substr($student->name ?? 'S', 0, 1)) }}</span>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-black text-slate-900 hover:text-red-600 transition-colors">
                                                @if($student)
                                                    <a href="{{ $student->profile_url }}" target="_blank" class="hover:underline flex items-center gap-1">
                                                        <span>{{ $student->name }}</span>
                                                        <i data-lucide="external-link" class="w-3 h-3 text-slate-400"></i>
                                                    </a>
                                                @else
                                                    <span>(User Tidak Ditemukan)</span>
                                                @endif
                                            </div>
                                            <div class="text-[10px] text-slate-400 font-mono mt-0.5">
                                                ID: {{ $student->account_id ?? $student->id ?? '-' }} • {{ $bs->role_title ?? 'Software Engineer Intern' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="py-3 px-4">
                                    <div class="font-semibold text-slate-800">{{ $bs->institution_name ?: ($student->school_origin ?? 'SMKN 1 Ciamis') }}</div>
                                    <div class="text-[10px] text-slate-500 font-medium">{{ $bs->major ?: ($student->major ?? 'PPLG') }}</div>
                                </td>

                                <td class="py-3 px-4">
                                    @if($mentor)
                                        <div class="font-semibold text-slate-800 flex items-center gap-1">
                                            <i data-lucide="user-check" class="w-3 h-3 text-emerald-600"></i>
                                            <span>{{ $mentor->name }}</span>
                                        </div>
                                        <div class="text-[10px] text-slate-400">{{ $mentor->email }}</div>
                                    @else
                                        <span class="text-xs text-amber-600 italic">Belum ditentukan</span>
                                    @endif
                                </td>

                                <td class="py-3 px-3">
                                    <div class="grid grid-cols-2 gap-1 text-[10px] font-mono min-w-[130px]">
                                        <span class="px-1.5 py-0.5 rounded bg-slate-100 text-slate-700" title="Teknis">Tek: <b>{{ $bs->technical_skill }}</b></span>
                                        <span class="px-1.5 py-0.5 rounded bg-slate-100 text-slate-700" title="Disiplin">Dis: <b>{{ $bs->discipline }}</b></span>
                                        <span class="px-1.5 py-0.5 rounded bg-slate-100 text-slate-700" title="Kerjasama Tim">Tim: <b>{{ $bs->teamwork }}</b></span>
                                        <span class="px-1.5 py-0.5 rounded bg-slate-100 text-slate-700" title="Inisiatif">Ini: <b>{{ $bs->initiative }}</b></span>
                                    </div>
                                </td>

                                <td class="py-3 px-4 text-center">
                                    <div class="font-mono text-base font-black text-slate-900 leading-tight">
                                        {{ number_format($bs->final_score, 1) }}
                                    </div>
                                    <span class="inline-block px-2 py-0.5 mt-0.5 rounded-full text-[10px] font-black
                                        {{ in_array($bs->grade, ['A', 'A-']) ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : (in_array($bs->grade, ['B+', 'B', 'B-']) ? 'bg-blue-100 text-blue-800 border border-blue-300' : 'bg-amber-100 text-amber-800 border border-amber-300') }}">
                                        Grade {{ $bs->grade }}
                                    </span>
                                </td>

                                <td class="py-3 px-4 text-center">
                                    @if($bs->certificate_number)
                                        <a href="{{ route('verify.show', $bs->certificate_number) }}" target="_blank" class="font-mono text-[10px] text-red-600 hover:underline block font-semibold">
                                            {{ $bs->certificate_number }}
                                        </a>
                                        <span class="text-[9px] text-slate-400 block mt-0.5">
                                            {{ $bs->is_published ? '✅ Terverifikasi Publik' : 'Draft / Internal' }}
                                        </span>
                                    @else
                                        <span class="text-[10px] text-slate-400 italic">Belum terbit</span>
                                    @endif
                                </td>

                                <td class="py-3 px-4 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <button 
                                            onclick='openGradeStudentModal(@json($bs), @json($student))' 
                                            class="px-2.5 py-1.5 rounded-lg bg-red-50 hover:bg-red-600 text-red-600 hover:text-white text-xs font-bold transition-all flex items-center gap-1 cursor-pointer">
                                            <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                            <span>Nilai DUDI</span>
                                        </button>
                                        <form action="{{ route('admin.batch_students.destroy', $bs->id) }}" method="POST" onsubmit="return confirm('Keluarkan siswa {{ addslashes($student->name ?? 'ini') }} dari {{ addslashes($selectedBatch->batch_name) }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg bg-slate-100 hover:bg-red-100 text-slate-500 hover:text-red-600 transition-colors cursor-pointer" title="Keluarkan dari Angkatan">
                                                <i data-lucide="user-x" class="w-3.5 h-3.5"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-slate-400">
                                    <i data-lucide="users" class="w-8 h-8 mx-auto text-slate-300 mb-2"></i>
                                    <p class="font-medium text-xs">Belum ada siswa yang didaftarkan pada angkatan ini.</p>
                                    <button onclick="openEnrollStudentModal()" class="mt-2 text-xs font-bold text-red-600 hover:underline">
                                        + Daftarkan Siswa Sekarang
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <!-- ============================================================== -->
        <!-- TAB 2: PROJECT DIGITAL ANGKATAN                                -->
        <!-- ============================================================== -->
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
                <button onclick="openCreateProjectModal({{ $selectedBatchId }})" class="px-3 py-1.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-bold transition-all shadow-xs flex items-center gap-1.5 cursor-pointer">
                    <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                    <span>+ Project Baru</span>
                </button>
            </div>

            <div class="p-4 sm:p-5 grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($projects as $project)
                    <div class="p-4 sm:p-5 rounded-2xl border border-slate-200 bg-white hover:border-red-400/50 hover:shadow-md transition-all flex flex-col justify-between space-y-3 relative group">
                        <div>
                            <!-- Header: Kategori & Status -->
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

                            <!-- Team Members -->
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
                                @if(filled($project->live_url))
                                    <a href="{{ $project->live_url }}" target="_blank" class="px-2.5 py-1 rounded-lg bg-red-600 hover:bg-red-700 text-white text-[11px] font-bold flex items-center gap-1.5 shadow-2xs transition-colors">
                                        <i data-lucide="external-link" class="w-3 h-3"></i>
                                        <span>Live/Demo</span>
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
    @endif

</div>

<!-- ============================================================== -->
<!-- MODAL: INPUT / EDIT NILAI RAPOR DUDI SISWA (4 PILAR)           -->
<!-- ============================================================== -->
<div id="modal-grade-student" class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 space-y-4 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-xl bg-red-600 text-white flex items-center justify-center shrink-0">
                    <i data-lucide="award" class="w-4 h-4"></i>
                </div>
                <div>
                    <h3 class="text-sm font-black text-slate-900">Input / Edit Nilai Rapor DUDI</h3>
                    <p id="grade-student-subtitle" class="text-[10px] text-slate-400">Penilaian 4 Pilar Kompetensi Industri PT. TMS</p>
                </div>
            </div>
            <button onclick="closeGradeModal()" class="text-slate-400 hover:text-slate-700 cursor-pointer">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="form-grade-student" method="POST" action="" class="space-y-4">
            @csrf

            <!-- Student Profile Badge -->
            <div class="p-3 bg-slate-50 border border-slate-200/70 rounded-2xl flex items-center gap-3">
                <div id="grade-student-avatar" class="w-10 h-10 rounded-xl bg-red-100 text-red-700 font-black flex items-center justify-center overflow-hidden shrink-0">
                    S
                </div>
                <div>
                    <h4 id="grade-student-name" class="text-xs font-black text-slate-900 leading-tight">Nama Siswa</h4>
                    <p id="grade-student-school" class="text-[10px] text-slate-500 mt-0.5">Asal Sekolah • Jurusan</p>
                </div>
            </div>

            <!-- 4 Pilar Kompetensi Form Inputs -->
            <div class="space-y-3">
                <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider">
                    4 Pilar Penilaian Kompetensi (Skala 0 - 100):
                </label>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">1. Kemampuan Teknis (Hard Skill) *</label>
                        <input type="number" id="grade-tech" name="technical_skill" required min="0" max="100" step="1" oninput="calculateGradeLive()" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-mono font-bold text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">2. Disiplin & Kehadiran *</label>
                        <input type="number" id="grade-disc" name="discipline" required min="0" max="100" step="1" oninput="calculateGradeLive()" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-mono font-bold text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">3. Kerjasama Tim *</label>
                        <input type="number" id="grade-team" name="teamwork" required min="0" max="100" step="1" oninput="calculateGradeLive()" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-mono font-bold text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">4. Inisiatif & Kreativitas *</label>
                        <input type="number" id="grade-init" name="initiative" required min="0" max="100" step="1" oninput="calculateGradeLive()" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-mono font-bold text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                </div>

                <!-- Live Preview of Final Score & Grade -->
                <div class="p-3 bg-red-50/50 border border-red-200/60 rounded-xl flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-bold uppercase text-red-700">Rata-rata Nilai Akhir:</span>
                        <div class="flex items-center gap-2 mt-0.5">
                            <span id="live-final-score" class="text-xl font-black font-mono text-slate-900">85.0</span>
                            <span id="live-grade-badge" class="px-2 py-0.5 rounded text-[10px] font-black bg-emerald-600 text-white">
                                Predikat A
                            </span>
                        </div>
                    </div>
                    <div class="text-right text-[10px] text-slate-500">
                        Otomatis terhitung dari<br>rata-rata 4 pilar di atas.
                    </div>
                </div>
            </div>

            <!-- Catatan Mentor / Pembimbing Industri -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Catatan / Ulasan Pembimbing Industri</label>
                <textarea id="grade-notes" name="mentor_notes" rows="2" placeholder="Catatan evaluasi perkembangan kinerja siswa selama masa PKL..." class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 leading-relaxed"></textarea>
            </div>

            <!-- Sertifikat Meta -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Sertifikat DUDI</label>
                    <input type="text" id="grade-cert" name="certificate_number" placeholder="TMS/PKL/2026/..." class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Terbit</label>
                    <input type="date" id="grade-date" name="issue_date" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                </div>
            </div>

            <div class="flex items-center gap-2 pt-1">
                <input type="checkbox" id="grade-published" name="is_published" value="1" checked class="rounded border-slate-300 text-red-600 focus:ring-red-500">
                <label for="grade-published" class="text-xs font-semibold text-slate-700">Publikasikan nilai ke Profil Siswa & Validasi E-Sertifikat Publik</label>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeGradeModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl shadow-md shadow-red-600/25 cursor-pointer">
                    Simpan Nilai DUDI
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL: DAFTARKAN SISWA KE ANGKATAN INI                         -->
<!-- ============================================================== -->
<div id="modal-enroll-student" class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-100 space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0">
                    <i data-lucide="user-plus" class="w-4 h-4"></i>
                </div>
                <div>
                    <h3 class="text-sm font-black text-slate-900">Daftarkan Siswa ke Angkatan</h3>
                    <p class="text-[10px] text-slate-400">{{ $selectedBatch->batch_name ?? 'Batch' }}</p>
                </div>
            </div>
            <button onclick="closeEnrollModal()" class="text-slate-400 hover:text-slate-700 cursor-pointer">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.batch_students.enroll') }}" class="space-y-3">
            @csrf
            <input type="hidden" name="batch_id" value="{{ $selectedBatchId }}">

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Pilih Siswa PKL *</label>
                <select name="user_id" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500" onchange="autoFillStudentMeta(this)">
                    <option value="">-- Pilih Siswa PKL --</option>
                    @foreach($allStudents as $st)
                        <option value="{{ $st->id }}" data-school="{{ $st->school_origin }}" data-major="{{ $st->major }}" data-mentor="{{ $st->mentor_id }}">
                            {{ $st->name }} (ID: {{ $st->account_id ?? $st->id }}) - {{ $st->school_origin ?? 'Siswa' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Mentor Pembimbing Industri</label>
                <select id="enroll-mentor-id" name="mentor_id" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    <option value="">-- Pilih Mentor Pembimbing --</option>
                    @foreach($mentors as $m)
                        <option value="{{ $m->id }}">{{ $m->name }} ({{ $m->email }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Role / Posisi Magang</label>
                <input type="text" name="role_title" value="Software Engineer Intern" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Asal Sekolah / Kampus</label>
                    <input type="text" id="enroll-school" name="institution_name" placeholder="SMKN 1 Ciamis" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jurusan / Program Studi</label>
                    <input type="text" id="enroll-major" name="major" placeholder="PPLG" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                </div>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeEnrollModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-md shadow-emerald-600/25 cursor-pointer">
                    Daftarkan Siswa
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL: TAMBAH / EDIT PROJECT ANGKATAN                          -->
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
            <button onclick="closeProjectModal()" class="text-slate-400 hover:text-slate-700 cursor-pointer">
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

            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <label class="block text-xs font-bold text-slate-700">Anggota Tim Pengembang (Siswa PKL) *</label>
                    <button type="button" onclick="addExtraTeamMemberRow()" class="px-2.5 py-1 rounded-lg bg-slate-900 hover:bg-black text-white text-[10.5px] font-bold flex items-center gap-1 cursor-pointer transition-colors">
                        <i data-lucide="user-plus" class="w-3 h-3"></i>
                        <span>+ Tambah Anggota</span>
                    </button>
                </div>

                <!-- Siswa Utama / Lead (terhubung ke creator_id) -->
                <div class="grid grid-cols-12 gap-2 items-center bg-slate-50 p-2 rounded-xl border border-slate-200">
                    <div class="col-span-7">
                        <select id="proj-creator-id" name="creator_id" required onchange="syncTeamMembersString()" class="w-full px-2.5 py-1.5 bg-white border border-slate-200 rounded-lg text-xs font-semibold text-slate-800 focus:outline-none focus:border-red-500">
                            <option value="">-- Pilih Siswa Utama --</option>
                            @foreach($allStudents as $st)
                                <option value="{{ $st->id }}" data-name="{{ $st->name }}">
                                    {{ $st->name }} ({{ $st->account_id ?? $st->id }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-5">
                        <input type="text" id="proj-lead-role" value="Lead Dev" oninput="syncTeamMembersString()" placeholder="Peran (mis: Lead Dev)" class="w-full px-2.5 py-1.5 bg-white border border-slate-200 rounded-lg text-xs text-slate-700 focus:outline-none focus:border-red-500">
                    </div>
                </div>

                <!-- Anggota Tambahan Dinamis -->
                <div id="proj-extra-members" class="space-y-1.5"></div>

                <!-- Compiled string for team_members -->
                <input type="hidden" id="proj-members" name="team_members" required>
                <p class="text-[10px] text-slate-400">Otomatis terhubung ke halaman <b>Profil &amp; Portofolio</b> seluruh siswa yang dipilih di atas.</p>
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
                    <label class="block text-xs font-bold text-slate-700 mb-1">Link Live/Demo <span class="text-[10px] font-normal text-slate-400">(Opsional)</span></label>
                    <input type="text" id="proj-live" name="live_url" placeholder="https://live-atau-demo.com" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                </div>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeProjectModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl shadow-md shadow-red-600/25 cursor-pointer">
                    Simpan Project
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL: TAMBAH / EDIT ANGKATAN (BATCH)                          -->
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
            <button onclick="closeBatchModal()" class="text-slate-400 hover:text-slate-700 cursor-pointer">
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
                <button type="button" onclick="closeBatchModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-slate-900 hover:bg-black text-white text-xs font-bold rounded-xl shadow-xs cursor-pointer">
                    Simpan Angkatan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Live calculate final score & grade
    function calculateGradeLive() {
        const tech = parseFloat(document.getElementById('grade-tech').value) || 0;
        const disc = parseFloat(document.getElementById('grade-disc').value) || 0;
        const team = parseFloat(document.getElementById('grade-team').value) || 0;
        const init = parseFloat(document.getElementById('grade-init').value) || 0;

        const avg = ((tech + disc + team + init) / 4);
        const finalScore = avg.toFixed(1);
        document.getElementById('live-final-score').innerText = finalScore;

        let grade = 'D';
        let bgClass = 'bg-rose-600';
        if (avg >= 90) { grade = 'A'; bgClass = 'bg-emerald-600'; }
        else if (avg >= 85) { grade = 'A-'; bgClass = 'bg-emerald-600'; }
        else if (avg >= 80) { grade = 'B+'; bgClass = 'bg-blue-600'; }
        else if (avg >= 75) { grade = 'B'; bgClass = 'bg-blue-600'; }
        else if (avg >= 70) { grade = 'B-'; bgClass = 'bg-blue-500'; }
        else if (avg >= 65) { grade = 'C+'; bgClass = 'bg-amber-600'; }
        else if (avg >= 60) { grade = 'C'; bgClass = 'bg-amber-500'; }

        const badge = document.getElementById('live-grade-badge');
        badge.className = `px-2 py-0.5 rounded text-[10px] font-black text-white ${bgClass}`;
        badge.innerText = `Predikat ${grade}`;
    }

    // Modal Grade Student
    function openGradeStudentModal(bs, student) {
        const modal = document.getElementById('modal-grade-student');
        const form = document.getElementById('form-grade-student');
        form.action = "{{ url('/batch-students') }}/" + bs.id + "/grade";

        const studentName = student ? student.name : 'Siswa';
        document.getElementById('grade-student-name').innerText = studentName;
        document.getElementById('grade-student-school').innerText = (bs.institution_name || (student ? student.school_origin : 'SMKN 1 Ciamis')) + ' • ' + (bs.major || (student ? student.major : 'PPLG'));
        document.getElementById('grade-student-subtitle').innerText = 'Penilaian untuk ' + studentName + ' (' + (bs.role_title || 'Software Engineer Intern') + ')';
        
        const avatarEl = document.getElementById('grade-student-avatar');
        const rawAvatar = student ? (student.avatar_url || student.avatar) : null;
        if (rawAvatar) {
            let avatarSrc = rawAvatar;
            if (!avatarSrc.startsWith('http://') && !avatarSrc.startsWith('https://') && !avatarSrc.startsWith('/')) {
                avatarSrc = '/' + avatarSrc;
            }
            avatarEl.innerHTML = `<img src="${avatarSrc}" alt="${studentName}" class="w-full h-full object-cover">`;
            const img = avatarEl.querySelector('img');
            if (img) {
                img.onerror = function() {
                    avatarEl.innerHTML = `<span class="font-black text-red-700">${studentName.charAt(0).toUpperCase()}</span>`;
                };
            }
        } else {
            avatarEl.innerHTML = `<span class="font-black text-red-700">${studentName.charAt(0).toUpperCase()}</span>`;
        }

        document.getElementById('grade-tech').value = bs.technical_skill ?? 85;
        document.getElementById('grade-disc').value = bs.discipline ?? 90;
        document.getElementById('grade-team').value = bs.teamwork ?? 88;
        document.getElementById('grade-init').value = bs.initiative ?? 85;
        document.getElementById('grade-notes').value = bs.mentor_notes || '';
        document.getElementById('grade-cert').value = bs.certificate_number || '';
        document.getElementById('grade-date').value = bs.issue_date ? bs.issue_date.substring(0, 10) : new Date().toISOString().slice(0, 10);
        document.getElementById('grade-published').checked = !!bs.is_published;

        calculateGradeLive();
        modal.classList.remove('hidden');
    }

    function closeGradeModal() {
        document.getElementById('modal-grade-student').classList.add('hidden');
    }

    // Modal Enroll Student
    function openEnrollStudentModal() {
        document.getElementById('modal-enroll-student').classList.remove('hidden');
    }

    function closeEnrollModal() {
        document.getElementById('modal-enroll-student').classList.add('hidden');
    }

    function autoFillStudentMeta(select) {
        const selected = select.options[select.selectedIndex];
        if (selected) {
            const school = selected.getAttribute('data-school');
            const major = selected.getAttribute('data-major');
            const mentor = selected.getAttribute('data-mentor');

            if (school) document.getElementById('enroll-school').value = school;
            if (major) document.getElementById('enroll-major').value = major;
            if (mentor) document.getElementById('enroll-mentor-id').value = mentor;
        }
    }

    // Modal Project
    const ALL_STUDENTS_FOR_PROJECT = @json($allStudents->map(fn($s) => ['id' => $s->id, 'name' => $s->name, 'account_id' => $s->account_id ?? $s->id])->values());

    function addExtraTeamMemberRow(selectedId = '', roleText = 'Developer') {
        const container = document.getElementById('proj-extra-members');
        const row = document.createElement('div');
        row.className = 'grid grid-cols-12 gap-2 items-center bg-slate-50/70 p-2 rounded-xl border border-slate-200/80 extra-member-row';

        let opts = '<option value="">-- Pilih Anggota --</option>';
        ALL_STUDENTS_FOR_PROJECT.forEach(s => {
            const sel = String(s.id) === String(selectedId) ? 'selected' : '';
            opts += `<option value="${s.id}" data-name="${s.name}" ${sel}>${s.name} (${s.account_id})</option>`;
        });

        row.innerHTML = `
            <div class="col-span-7">
                <select onchange="syncTeamMembersString()" class="extra-member-select w-full px-2.5 py-1.5 bg-white border border-slate-200 rounded-lg text-xs font-semibold text-slate-800 focus:outline-none focus:border-red-500">
                    ${opts}
                </select>
            </div>
            <div class="col-span-4">
                <input type="text" value="${roleText}" oninput="syncTeamMembersString()" placeholder="Peran" class="extra-member-role w-full px-2.5 py-1.5 bg-white border border-slate-200 rounded-lg text-xs text-slate-700 focus:outline-none focus:border-red-500">
            </div>
            <div class="col-span-1 flex justify-end">
                <button type="button" onclick="this.closest('.extra-member-row').remove(); syncTeamMembersString();" class="w-7 h-7 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 flex items-center justify-center cursor-pointer" title="Hapus Anggota">
                    <i data-lucide="x" class="w-3.5 h-3.5"></i>
                </button>
            </div>
        `;
        container.appendChild(row);
        if (window.lucide) lucide.createIcons();
        syncTeamMembersString();
    }

    function syncTeamMembersString() {
        const parts = [];
        const leadSel = document.getElementById('proj-creator-id');
        const leadRole = (document.getElementById('proj-lead-role')?.value || '').trim();
        if (leadSel && leadSel.value) {
            const opt = leadSel.options[leadSel.selectedIndex];
            const name = opt.getAttribute('data-name') || opt.text;
            parts.push(leadRole ? `${name} (${leadRole})` : name);
        }
        document.querySelectorAll('#proj-extra-members .extra-member-row').forEach(row => {
            const sel = row.querySelector('.extra-member-select');
            const role = (row.querySelector('.extra-member-role')?.value || '').trim();
            if (sel && sel.value) {
                const opt = sel.options[sel.selectedIndex];
                const name = opt.getAttribute('data-name') || opt.text;
                parts.push(role ? `${name} (${role})` : name);
            }
        });
        document.getElementById('proj-members').value = parts.join(', ');
    }

    function openCreateProjectModal(batchId = null) {
        const modal = document.getElementById('modal-project');
        const form = document.getElementById('form-project');
        document.getElementById('modal-project-title').innerText = 'Tambah Project Angkatan Baru';
        form.action = "{{ route('admin.projects.store') }}";
        document.getElementById('project-method-spoof').innerHTML = '';
        
        document.getElementById('proj-title').value = '';
        document.getElementById('proj-tech').value = 'Laravel 11, Tailwind CSS, SQLite';
        document.getElementById('proj-extra-members').innerHTML = '';
        const leadSel = document.getElementById('proj-creator-id');
        if (leadSel && leadSel.options.length > 1) leadSel.selectedIndex = 1;
        document.getElementById('proj-lead-role').value = 'Lead Dev';
        syncTeamMembersString();
        document.getElementById('proj-desc').value = '';
        document.getElementById('proj-repo').value = '';
        document.getElementById('proj-live').value = '';

        if (batchId) {
            document.getElementById('proj-batch-id').value = batchId;
        }

        modal.classList.remove('hidden');
        if (window.lucide) lucide.createIcons();
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
        document.getElementById('proj-desc').value = project.short_description || '';
        document.getElementById('proj-repo').value = project.repo_url || '';
        document.getElementById('proj-live').value = project.live_url || '';

        // Populate Lead & Extra Members
        document.getElementById('proj-extra-members').innerHTML = '';
        const leadSel = document.getElementById('proj-creator-id');
        if (project.creator_id) {
            leadSel.value = project.creator_id;
        }
        const rawMembers = (project.team_members || '').split(',').map(s => s.trim()).filter(Boolean);
        rawMembers.forEach((entry, idx) => {
            const match = entry.match(/^(.+?)\s*\(([^)]+)\)$/);
            const mName = match ? match[1].trim() : entry;
            const mRole = match ? match[2].trim() : (idx === 0 ? 'Lead Dev' : 'Developer');
            const found = ALL_STUDENTS_FOR_PROJECT.find(s => s.name.toLowerCase() === mName.toLowerCase());
            if (idx === 0) {
                if (found && !project.creator_id) leadSel.value = found.id;
                document.getElementById('proj-lead-role').value = mRole;
            } else if (found) {
                addExtraTeamMemberRow(found.id, mRole);
            }
        });
        syncTeamMembersString();

        modal.classList.remove('hidden');
        if (window.lucide) lucide.createIcons();
    }

    function closeProjectModal() {
        document.getElementById('modal-project').classList.add('hidden');
    }

    // Modal Batch
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