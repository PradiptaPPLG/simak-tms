@extends('layouts.simak')

@section('title', 'Master Data Siswa Magang (Semua Batch) • Admin TMS')

@section('content')
<div class="space-y-6 min-w-0 max-w-full">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-black tracking-tight text-slate-900">Master Data Siswa Magang (Semua Batch)</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola data seluruh siswa magang lintas sekolah mitra, pembagian mentor pembimbing, serta rekapitulasi penugasan.</p>
        </div>

        <div class="flex items-center gap-2 flex-wrap sm:flex-nowrap w-full sm:w-auto no-print">
            <!-- Green Export Button (Opens Format Choice Modal) -->
            <button type="button" onclick="openExportModal()" class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-emerald-600/25 flex items-center justify-center gap-1.5 text-center shrink-0 cursor-pointer" title="Unduh Berkas Spreadsheet Data Siswa (Excel / CSV)">
                <i data-lucide="file-spreadsheet" class="w-4 h-4 text-emerald-100 shrink-0"></i>
                <span>Ekspor Excel / CSV</span>
                <i data-lucide="chevron-down" class="w-3 h-3 text-emerald-200 shrink-0"></i>
            </button>

            <!-- Indigo Import Button -->
            <button type="button" onclick="openImportModal()" class="px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-indigo-600/25 flex items-center justify-center gap-1.5 text-center shrink-0 cursor-pointer" title="Import / Restore Data Siswa dari Excel atau CSV">
                <i data-lucide="upload-cloud" class="w-4 h-4 text-indigo-100 shrink-0"></i>
                <span>Import Excel / CSV</span>
            </button>

            <!-- Tambah Siswa Manual Button -->
            <button onclick="document.getElementById('form-register-student').scrollIntoView({behavior: 'smooth'})" class="px-3.5 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-red-600/25 flex items-center justify-center gap-1.5 text-center shrink-0 cursor-pointer" title="Input Siswa Manual (Bypass Antrian Formulir Online)">
                <i data-lucide="user-plus" class="w-4 h-4 shrink-0"></i>
                <span class="hidden sm:inline">Tambah Siswa Manual</span>
                <span class="sm:hidden">Tambah Manual</span>
            </button>

            <!-- Cetak Rekap Button -->
            <button onclick="window.print()" class="px-3.5 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-xl transition-all shadow-xs flex items-center justify-center gap-1.5 text-center shrink-0">
                <i data-lucide="printer" class="w-4 h-4 text-slate-500 shrink-0"></i>
                <span>Cetak Rekap</span>
            </button>
        </div>
    </div>

    <!-- 1. Quick Stats Cards (Compact 4-Cols) -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 sm:gap-4">
        <div class="mas-card p-3 sm:p-5 border-l-2 sm:border-l-4 border-l-red-600 flex flex-col sm:flex-row sm:items-center justify-between gap-1">
            <div>
                <p class="text-slate-400 text-[10px] sm:text-[11px] font-bold uppercase tracking-wider mb-0.5 truncate">Total Siswa</p>
                <h3 class="text-lg sm:text-2xl font-black text-slate-900 font-mono">{{ $totalInterns }} <span class="text-[10px] sm:text-xs font-normal text-slate-500">Peserta</span></h3>
            </div>
            <div class="hidden sm:flex w-11 h-11 bg-red-50 text-red-600 rounded-xl items-center justify-center shrink-0">
                <i data-lucide="users" class="w-5 h-5"></i>
            </div>
        </div>

        <div class="mas-card p-3 sm:p-5 border-l-2 sm:border-l-4 border-l-emerald-600 flex flex-col sm:flex-row sm:items-center justify-between gap-1">
            <div>
                <p class="text-slate-400 text-[10px] sm:text-[11px] font-bold uppercase tracking-wider mb-0.5 truncate">Siswa Aktif</p>
                <h3 class="text-lg sm:text-2xl font-black text-slate-900 font-mono">{{ $assignedInterns }} <span class="text-[10px] sm:text-xs font-normal text-slate-500">Magang</span></h3>
            </div>
            <div class="hidden sm:flex w-11 h-11 bg-emerald-50 text-emerald-600 rounded-xl items-center justify-center shrink-0">
                <i data-lucide="user-check" class="w-5 h-5"></i>
            </div>
        </div>

        <div class="mas-card p-3 sm:p-5 border-l-2 sm:border-l-4 border-l-indigo-600 flex flex-col sm:flex-row sm:items-center justify-between gap-1">
            <div>
                <p class="text-slate-400 text-[10px] sm:text-[11px] font-bold uppercase tracking-wider mb-0.5 truncate">Alumni Magang</p>
                <h3 class="text-lg sm:text-2xl font-black text-slate-900 font-mono">{{ $totalAlumni }} <span class="text-[10px] sm:text-xs font-normal text-slate-500">Lulus</span></h3>
            </div>
            <div class="hidden sm:flex w-11 h-11 bg-indigo-50 text-indigo-600 rounded-xl items-center justify-center shrink-0">
                <i data-lucide="graduation-cap" class="w-5 h-5"></i>
            </div>
        </div>

        <div class="mas-card p-3 sm:p-5 border-l-2 sm:border-l-4 border-l-amber-500 flex flex-col sm:flex-row sm:items-center justify-between gap-1">
            <div>
                <p class="text-slate-400 text-[10px] sm:text-[11px] font-bold uppercase tracking-wider mb-0.5 truncate">Nilai Rapor</p>
                <h3 class="text-lg sm:text-2xl font-black text-slate-900 font-mono">{{ $evaluatedInterns }} <span class="text-[10px] sm:text-xs font-normal text-slate-500">Ternilai</span></h3>
            </div>
            <div class="hidden sm:flex w-11 h-11 bg-amber-50 text-amber-600 rounded-xl items-center justify-center shrink-0">
                <i data-lucide="award" class="w-5 h-5"></i>
            </div>
        </div>
    </div>

    <!-- 2. Filter & Search Bar -->
    <div class="mas-card p-4 no-print">
        <form method="GET" action="{{ route('admin.students') }}" class="flex flex-col md:flex-row gap-3 items-center justify-between">
            <div class="relative flex-1 w-full">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa, email, sekolah (contoh: SMKN 1 Ciamis), atau jurusan..." class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all">
            </div>

            <div class="flex items-center gap-2.5 w-full md:w-auto flex-wrap">
                <select name="status" onchange="this.form.submit()" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 font-medium focus:outline-none focus:border-red-500">
                    <option value="">-- Semua Status --</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>✓ Siswa Aktif Magang</option>
                    <option value="alumni" {{ request('status') == 'alumni' ? 'selected' : '' }}>🎓 Alumni Magang (Lulus)</option>
                </select>

                <select name="mentor_id" onchange="this.form.submit()" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 font-medium focus:outline-none focus:border-red-500">
                    <option value="">-- Semua Pembimbing TMS --</option>
                    @foreach($mentors as $m)
                        <option value="{{ $m->id }}" {{ request('mentor_id') == $m->id ? 'selected' : '' }}>{{ $m->name }} ({{ $m->account_id ?? $m->username ?? $m->id }})</option>
                    @endforeach
                </select>

                <button type="submit" class="px-4 py-2 bg-slate-900 hover:bg-black text-white text-xs font-bold rounded-xl transition-all shadow-xs flex items-center gap-1.5 flex-shrink-0">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                    <span>Terapkan</span>
                </button>

                @if(request('search') || request('mentor_id') || request('status'))
                    <a href="{{ route('admin.students') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl transition-colors flex-shrink-0">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- 3. Tabel Data Siswa Lengkap -->
    <div class="mas-card p-6 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-3">
            <div>
                <h2 class="text-base font-black text-slate-900 tracking-tight flex items-center gap-2">
                    <i data-lucide="users" class="w-5 h-5 text-red-600"></i>
                    <span>Daftar Siswa Magang Terdaftar ({{ $interns->count() }})</span>
                </h2>
                <p class="text-xs text-slate-400 mt-0.5">Seluruh data siswa aktif dan alumni magang di PT. Teknologi Multi Sistem.</p>
            </div>
            <a href="{{ route('admin.alumni') }}" class="px-3.5 py-1.5 rounded-xl bg-slate-900 hover:bg-black text-white text-xs font-bold transition-all shadow-xs flex items-center gap-1.5 shrink-0 self-start sm:self-auto no-print">
                <i data-lucide="graduation-cap" class="w-4 h-4 text-red-400"></i>
                <span>Direktori Alumni PKL &rarr;</span>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                        <th class="py-3 px-4">Siswa & Developer</th>
                        <th class="py-3 px-4">Sekolah & Jurusan</th>
                        <th class="py-3 px-4">Pembimbing TMS</th>
                        <th class="py-3 px-4">Karya Proyek</th>
                        <th class="py-3 px-4">Status & Nilai Akhir</th>
                        <th class="py-3 px-4 text-right action-col no-print">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($interns as $intern)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl overflow-hidden bg-slate-900 text-white font-extrabold flex items-center justify-center border border-red-500/30 flex-shrink-0">
                                        @if($intern->avatar)
                                            <img src="{{ $intern->avatar }}" alt="{{ $intern->name }}" class="w-full h-full object-cover">
                                        @else
                                            {{ substr($intern->name, 0, 2) }}
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900 text-xs">
                                            {{ $intern->name }} 
                                            @if(!empty($intern->account_id))
                                                <span class="font-mono text-red-600 font-bold text-[11px]">({{ $intern->account_id }})</span>
                                            @else
                                                <span class="font-mono text-amber-700 bg-amber-100/90 px-1.5 py-0.5 rounded text-[10px] font-bold border border-amber-300">(belum terdaftar)</span>
                                            @endif
                                        </div>
                                        <div class="text-[10px] text-slate-400 font-mono">
                                            @if(!empty($intern->account_id))
                                                ID: {{ $intern->account_id }} • {{ $intern->email }}
                                            @else
                                                <span class="text-amber-600 font-semibold">Menunggu Penetapan Mentor</span> • {{ $intern->email }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-semibold text-slate-800">{{ $intern->school_origin ?? 'SMKN 1 Ciamis' }}</div>
                                <div class="text-[10px] text-slate-500">{{ $intern->major ?? 'PPLG' }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                @if($intern->mentor)
                                    <div class="font-bold text-slate-800 text-xs">{{ $intern->mentor->name }} <span class="font-mono text-red-600 text-[11px]">({{ $intern->mentor->account_id ?? $intern->mentor->username ?? $intern->mentor->id }})</span></div>
                                    <div class="text-[10px] text-slate-500">{{ $intern->mentor->major ?? 'Pembimbing TMS' }}</div>
                                    <div class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 rounded-md bg-red-50 text-red-700 text-[10px] font-bold border border-red-200">
                                        <i data-lucide="briefcase" class="w-3 h-3 text-red-600"></i>
                                        <span>Divisi: {{ $intern->mentor->location ?? 'IT / Software Engineering' }}</span>
                                    </div>
                                @else
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-amber-50 text-amber-800 border border-amber-200 text-[11px] font-bold animate-pulse">
                                        <i data-lucide="alert-triangle" class="w-3.5 h-3.5 text-amber-600 shrink-0"></i>
                                        <span>Belum Memilih Mentor</span>
                                    </div>
                                    <p class="text-[9.5px] text-slate-400 mt-0.5">Klik Edit Data untuk memilih mentor & menerbitkan ID.</p>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="font-bold text-slate-900 font-mono">{{ $intern->projects->count() ?? 1 }} Proyek</span>
                                <div class="text-[10px] text-slate-400">Portofolio Digital</div>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @if($intern->status === 'alumni')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200 font-bold text-[10px] whitespace-nowrap leading-none shadow-2xs">
                                        <i data-lucide="graduation-cap" class="w-3.5 h-3.5 text-indigo-600"></i>
                                        Alumni Magang
                                    </span>
                                    @if($intern->evaluation)
                                        <div class="mt-1">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 font-mono text-[9px] font-bold">
                                                Nilai: {{ $intern->evaluation->final_score }} [A]
                                            </span>
                                        </div>
                                    @endif
                                @elseif(empty($intern->account_id) || empty($intern->mentor_id))
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-50 text-amber-800 border border-amber-200 font-bold text-[10px] whitespace-nowrap leading-none shadow-2xs">
                                        <i data-lucide="clock" class="w-3 h-3 text-amber-600"></i>
                                        Belum Di-assign
                                    </span>
                                @elseif($intern->evaluation)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-red-50 text-red-700 border border-red-200 font-bold font-mono text-[11px] whitespace-nowrap leading-none shadow-2xs">
                                        Nilai: {{ $intern->evaluation->final_score }} [A]
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 font-bold text-[10px] whitespace-nowrap leading-none shadow-2xs">
                                        ✓ Aktif Magang
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right action-col no-print">
                                <!-- Menu Aksi Titik 3 (More Actions Dropdown) -->
                                <div class="relative inline-block text-left dropdown-container">
                                    <button type="button" onclick="toggleActionDropdown(this, event)" class="w-8 h-8 rounded-xl bg-white hover:bg-slate-100 text-slate-600 hover:text-slate-900 border border-slate-200 transition-colors shadow-2xs flex items-center justify-center cursor-pointer ml-auto" title="Opsi Aksi Siswa">
                                        <i data-lucide="more-vertical" class="w-4 h-4"></i>
                                    </button>
                                    <div class="action-dropdown hidden absolute right-0 mt-1.5 w-48 bg-white rounded-2xl shadow-xl border border-slate-100 py-1.5 z-40 divide-y divide-slate-100 text-left animate-in fade-in zoom-in-95 duration-100">
                                        <div class="py-1">
                                            @php
                                                $hasCert = !empty($intern->account_id) && !empty($intern->mentor_id) && !empty($intern->evaluation) && $intern->evaluation->is_published;
                                            @endphp

                                            @if(!empty($intern->account_id))
                                                <a href="{{ $intern->profile_url }}" target="_blank" class="flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                                                    <i data-lucide="user" class="w-3.5 h-3.5 text-slate-400"></i>
                                                    <span>Lihat Profil</span>
                                                </a>
                                            @else
                                                <button type="button" onclick="alert('Profil {{ addslashes($intern->name) }} belum dapat dibuka karena siswa belum terdaftar resmi (belum memiliki ID & pembimbing mentor). Silakan klik Edit Data untuk memilih mentor terlebih dahulu.')" class="w-full flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-slate-400 hover:bg-slate-50 transition-colors text-left cursor-not-allowed opacity-60" title="Siswa belum terdaftar resmi">
                                                    <i data-lucide="user-x" class="w-3.5 h-3.5 text-slate-400"></i>
                                                    <span>Profil (Belum Terdaftar)</span>
                                                </button>
                                            @endif

                                            @if($hasCert)
                                                <a href="{{ route('certificate.print', $intern->evaluation->certificate_number ?? ('TMS-CERT-2026-' . $intern->account_id)) }}" target="_blank" class="flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-red-600 hover:bg-red-50 transition-colors">
                                                    <i data-lucide="printer" class="w-3.5 h-3.5 text-red-500"></i>
                                                    <span>Cetak Sertifikat</span>
                                                </a>
                                                <a href="{{ route('verify.show', $intern->evaluation->certificate_number ?? ('TMS-CERT-2026-' . $intern->account_id)) }}" target="_blank" class="flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                                                    <i data-lucide="shield-check" class="w-3.5 h-3.5 text-emerald-500"></i>
                                                    <span>Verifikasi QR</span>
                                                </a>
                                            @else
                                                @if(empty($intern->account_id) || empty($intern->mentor_id))
                                                    <button type="button" onclick="alert('Sertifikat belum tersedia karena siswa belum terdaftar resmi / belum memiliki pembimbing mentor.')" class="w-full flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-slate-400 hover:bg-slate-50 transition-colors text-left cursor-not-allowed opacity-60" title="Siswa belum terdaftar resmi">
                                                        <i data-lucide="printer" class="w-3.5 h-3.5 text-slate-400"></i>
                                                        <span>Cetak Sertifikat</span>
                                                    </button>
                                                    <button type="button" onclick="alert('Verifikasi QR belum tersedia karena siswa belum terdaftar resmi / belum memiliki pembimbing mentor.')" class="w-full flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-slate-400 hover:bg-slate-50 transition-colors text-left cursor-not-allowed opacity-60" title="Siswa belum terdaftar resmi">
                                                        <i data-lucide="shield-check" class="w-3.5 h-3.5 text-slate-400"></i>
                                                        <span>Verifikasi QR</span>
                                                    </button>
                                                @else
                                                    <button type="button" onclick="alert('Sertifikat kelulusan belum dapat dicetak karena nilai akhir belum diterbitkan oleh mentor di menu Rapor & Nilai.')" class="w-full flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-slate-400 hover:bg-slate-50 transition-colors text-left cursor-not-allowed opacity-60" title="Evaluasi belum diterbitkan">
                                                        <i data-lucide="printer" class="w-3.5 h-3.5 text-slate-400"></i>
                                                        <span>Cetak Sertifikat</span>
                                                    </button>
                                                    <button type="button" onclick="alert('Verifikasi QR sertifikat belum tersedia karena nilai kelulusan belum disahkan oleh mentor.')" class="w-full flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-slate-400 hover:bg-slate-50 transition-colors text-left cursor-not-allowed opacity-60" title="Evaluasi belum diterbitkan">
                                                        <i data-lucide="shield-check" class="w-3.5 h-3.5 text-slate-400"></i>
                                                        <span>Verifikasi QR</span>
                                                    </button>
                                                @endif
                                            @endif
                                            @if(empty($intern->account_id) || empty($intern->mentor_id))
                                                <button type="button" onclick="alert('Evaluasi & nilai belum dapat diisi untuk {{ addslashes($intern->name) }} karena siswa belum terdaftar resmi / belum memiliki mentor pembimbing. Silakan tentukan mentor terlebih dahulu dengan klik Edit Data.')" class="w-full flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-slate-400 hover:bg-slate-50 transition-colors text-left cursor-not-allowed opacity-60" title="Siswa belum terdaftar resmi">
                                                    <i data-lucide="award" class="w-3.5 h-3.5 text-slate-400"></i>
                                                    <span>Rapor & Nilai</span>
                                                </button>
                                            @else
                                                <button type="button" onclick="openEvaluationModal({{ $intern->id }}, '{{ addslashes($intern->name) }}', '{{ $intern->account_id }}', {{ $intern->evaluation->technical_skill ?? 85 }}, {{ $intern->evaluation->discipline ?? 90 }}, {{ $intern->evaluation->teamwork ?? 85 }}, {{ $intern->evaluation->initiative ?? 85 }}, '{{ $intern->evaluation->certificate_number ?? ('TMS-CERT-' . date('Y') . '-' . $intern->account_id) }}', '{{ $intern->evaluation->issue_date ?? date('Y-m-d') }}', '{{ addslashes($intern->evaluation->general_notes ?? 'Peserta menunjukkan progres koding sangat baik dan integritas disiplin kerja industri memuaskan.') }}')" class="w-full flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors text-left cursor-pointer">
                                                    <i data-lucide="award" class="w-3.5 h-3.5 text-red-500"></i>
                                                    <span>Rapor & Nilai</span>
                                                </button>
                                            @endif
                                        </div>
                                        <div class="py-1">
                                            @if($intern->status === 'alumni')
                                                <form action="{{ route('admin.students.alumni', $intern->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="aktif">
                                                    <button type="submit" class="w-full flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-emerald-700 hover:bg-emerald-50 transition-colors text-left cursor-pointer">
                                                        <i data-lucide="rotate-ccw" class="w-3.5 h-3.5 text-emerald-600"></i>
                                                        <span>Kembalikan ke Aktif</span>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.students.alumni', $intern->id) }}" method="POST" onsubmit="return confirm('Luluskan siswa {{ addslashes($intern->name) }} dan pindahkan ke Alumni Magang? Data portofolio dan sertifikat akan tetap tersimpan aman.');">
                                                    @csrf
                                                    <input type="hidden" name="status" value="alumni">
                                                    <button type="submit" class="w-full flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-indigo-700 hover:bg-indigo-50 transition-colors text-left cursor-pointer">
                                                        <i data-lucide="graduation-cap" class="w-3.5 h-3.5 text-indigo-600"></i>
                                                        <span>Luluskan / Jadi Alumni</span>
                                                    </button>
                                                </form>
                                            @endif
                                            <button type="button" onclick="openEditModal({{ $intern->id }}, '{{ addslashes($intern->name) }}', '{{ addslashes($intern->email) }}', '{{ addslashes($intern->school_origin ?? 'SMKN 1 Ciamis') }}', '{{ addslashes($intern->major ?? 'PPLG') }}', '{{ $intern->mentor_id }}', '{{ $intern->status ?? 'aktif' }}', '{{ $intern->alumni_status ?? 'bekerja' }}', '{{ addslashes($intern->alumni_current_at ?? '') }}')" class="w-full flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors text-left cursor-pointer">
                                                <i data-lucide="edit-2" class="w-3.5 h-3.5 text-slate-400"></i>
                                                <span>Edit Data</span>
                                            </button>
                                            <button type="button" onclick="openResetPasswordModal({{ $intern->id }}, '{{ addslashes($intern->name) }}', '{{ $intern->account_id ?? $intern->email }}', 'siswa')" class="w-full flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-amber-700 hover:bg-amber-50 transition-colors text-left cursor-pointer">
                                                <i data-lucide="rotate-ccw" class="w-3.5 h-3.5 text-amber-500"></i>
                                                <span>Reset Sandi</span>
                                            </button>
                                        </div>
                                        <div class="py-1">
                                            <button type="button" onclick="openStudentDeletionModal({{ $intern->id }}, '{{ addslashes($intern->name) }}', '{{ $intern->status ?? 'aktif' }}')" class="w-full flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-red-600 hover:bg-red-50 transition-colors text-left cursor-pointer">
                                                <i data-lucide="trash-2" class="w-3.5 h-3.5 text-red-500"></i>
                                                <span>Hapus Siswa</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">Tidak ada siswa magang yang sesuai dengan pencarian atau filter.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- 4. Form Registrasi Akun Siswa Secara Manual -->
    <div id="form-register-student" class="mas-card p-6 bg-gradient-to-br from-white to-slate-50 border-2 border-slate-200 no-print">
        <div class="flex items-start sm:items-center justify-between gap-3 mb-4 pb-3 border-b border-slate-200">
            <div class="flex items-start sm:items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-red-600 text-white flex items-center justify-center shadow-md shadow-red-600/30 shrink-0 aspect-square mt-0.5 sm:mt-0">
                    <i data-lucide="user-plus" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-slate-900 tracking-tight">Input & Daftarkan Siswa Secara Manual</h3>
                    <p class="text-xs text-slate-500">Khusus pendaftaran langsung oleh Admin (bypass formulir online) dan langsung menghubungkan siswa ke Mentor.</p>
                </div>
            </div>
            <span class="hidden sm:inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 border border-slate-200 text-[10px] font-bold shrink-0">
                <i data-lucide="shield-check" class="w-3.5 h-3.5 text-red-600"></i>
                Khusus Admin TMS
            </span>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="role" value="siswa">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap Siswa *</label>
                    <input type="text" name="name" required placeholder="Contoh: Alyzza Nazwa" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-semibold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Email / Username Siswa (Opsional)</label>
                    <input type="text" name="email" placeholder="alyzza@smkn1ciamis.sch.id (otomatis jika kosong)" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">ID Login Akun</label>
                    <input type="text" value="[Auto-Generate 5-Digit]" readonly class="w-full px-3.5 py-2.5 bg-red-50/60 border border-red-200 rounded-xl text-xs text-red-700 font-mono font-bold select-none">
                    <p class="text-[10px] text-slate-400 mt-1">Diterbitkan otomatis sistem (contoh: 19364).</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Password Default Universal</label>
                    <input type="text" value="tmshebatsukses" readonly class="w-full px-3.5 py-2.5 bg-slate-100 border border-slate-200 rounded-xl text-xs text-slate-700 font-mono font-bold select-none">
                    <p class="text-[10px] text-slate-400 mt-1">Siswa dapat mengganti password setelah login.</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Asal Sekolah</label>
                    <input type="text" name="school_origin" value="SMKN 1 Ciamis" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Kompetensi Keahlian / Jurusan</label>
                    <input type="text" name="major" value="PPLG (Pengembangan Perangkat Lunak & Gim)" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all">
                </div>

                <div class="sm:col-span-2 lg:col-span-3">
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Pilih Staff Mentor Pembimbing *</label>
                    <select name="mentor_id" required class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 font-semibold focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all">
                        <option value="">{{ $mentors->count() > 0 ? '-- Pilih Mentor Pembimbing TMS --' : '-- Belum Ada Staff Mentor Terdaftar --' }}</option>
                        @foreach($mentors as $mentor)
                            <option value="{{ $mentor->id }}">{{ $mentor->name }} ({{ $mentor->account_id ?? $mentor->username ?? $mentor->id }}) - {{ $mentor->major ?? 'Senior Software Engineer' }}</option>
                        @endforeach
                    </select>
                    @if($mentors->count() === 0)
                        <p class="text-[10px] text-amber-600 font-bold mt-1.5 flex items-center gap-1">
                            <i data-lucide="info" class="w-3.5 h-3.5 text-amber-500 shrink-0"></i>
                            <span>Belum ada mentor. Silakan <a href="{{ route('admin.mentors') }}" class="underline text-red-600 font-black">daftarkan mentor terlebih dahulu</a> di menu Data Mentor & Staff.</span>
                        </p>
                    @endif
                </div>
            </div>

            <div class="pt-2 flex justify-end">
                <button type="submit" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-red-600/30 flex items-center gap-2">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>Simpan & Daftarkan Siswa</span>
                </button>
            </div>
        </form>
    </div>

    <!-- 5. Modal Edit Data Siswa (Khusus Hak Akses Admin) -->
    <div id="modal-edit-student" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
        <div class="mas-card p-6 bg-white w-full max-w-lg shadow-2xl space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center shrink-0 aspect-square">
                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-slate-900">Edit Data Siswa Magang</h3>
                        <p class="text-[11px] text-slate-400">Kelola mutasi sekolah, ganti pembimbing, atau update biodata siswa.</p>
                    </div>
                </div>
                <button onclick="closeEditModal()" class="w-7 h-7 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center text-lg">&times;</button>
            </div>

            <form id="form-edit-student" method="POST" class="space-y-3.5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap Siswa</label>
                    <input type="text" id="edit-name" name="name" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 font-semibold focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Email / Akun</label>
                    <input type="email" id="edit-email" name="email" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 font-mono focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Asal Sekolah</label>
                        <input type="text" id="edit-school" name="school_origin" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Jurusan</label>
                        <input type="text" id="edit-major" name="major" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Staff Mentor Pembimbing</label>
                    <select id="edit-mentor-id" name="mentor_id" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 font-semibold focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                        <option value="">-- Belum Diassign --</option>
                        @foreach($mentors as $mentor)
                            <option value="{{ $mentor->id }}">{{ $mentor->name }} (Mentor TMS)</option>
                        @endforeach
                    </select>
                    <p class="text-[10px] text-amber-700 bg-amber-50 p-2 rounded-lg border border-amber-200 mt-1.5 flex items-center gap-1.5">
                        <i data-lucide="info" class="w-3.5 h-3.5 text-amber-600 shrink-0"></i>
                        <span>Jika siswa berstatus <b>(belum terdaftar)</b>, memilih mentor dan menekan Simpan akan otomatis menerbitkan ID resmi 5-digit siswa.</span>
                    </p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Status Keikutsertaan Magang</label>
                    <select id="edit-status" name="status" onchange="toggleAlumniFields(this.value)" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 font-semibold focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                        <option value="aktif">✓ Siswa Aktif Magang (Sedang Berjalan)</option>
                        <option value="alumni">🎓 Alumni Magang (Telah Lulus PKL)</option>
                    </select>
                </div>

                <div id="edit-alumni-section" class="hidden p-3.5 rounded-xl bg-indigo-50/70 border border-indigo-200 space-y-3">
                    <div class="flex items-center gap-1.5 text-indigo-950 font-bold text-xs">
                        <i data-lucide="graduation-cap" class="w-4 h-4 text-indigo-600"></i>
                        <span>Pelacakan Karir Pasca-PKL (Alumni Tracer)</span>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Status Karir</label>
                            <select id="edit-alumni-status" name="alumni_status" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                                <option value="direkrut_tms">Direkrut PT. TMS</option>
                                <option value="bekerja">Bekerja di Perusahaan Lain</option>
                                <option value="kuliah">Kuliah / Studi Lanjut</option>
                                <option value="mencari_kerja">Mencari Kerja / Freelance</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Instansi / Kampus / Kantor</label>
                            <input type="text" id="edit-alumni-current-at" name="alumni_current_at" placeholder="Contoh: PT. TMS / Politeknik" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                        </div>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-red-600/30 flex items-center gap-1.5">
                        <i data-lucide="save" class="w-3.5 h-3.5"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- 6. Modal Evaluasi & Input Nilai Rapor Siswa (Admin TMS) -->
    <div id="modal-evaluation-student" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs overflow-y-auto">
        <div class="mas-card p-6 bg-white w-full max-w-lg shadow-2xl space-y-4 my-8">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center shrink-0 aspect-square">
                        <i data-lucide="award" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-slate-900">Rapor & Nilai Evaluasi Industri</h3>
                        <p class="text-[11px] text-slate-400" id="eval-student-subtitle">Penetapan 4 standar kompetensi & penerbitan sertifikat resmi.</p>
                    </div>
                </div>
                <button type="button" onclick="closeEvaluationModal()" class="w-7 h-7 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center text-lg cursor-pointer">&times;</button>
            </div>

            <form id="form-evaluation-student" method="POST" class="space-y-4">
                @csrf

                <!-- Score Preview Bar -->
                <div class="p-3.5 rounded-2xl bg-slate-900 text-white flex items-center justify-between">
                    <div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Perhitungan Skor Akhir</div>
                        <div class="text-xs text-slate-300">Teknis 35% + Disiplin 25% + Team 20% + Inisiatif 20%</div>
                    </div>
                    <div class="text-right">
                        <div class="text-xl font-black font-mono text-emerald-400" id="eval-live-score">86.3</div>
                        <div class="text-[10px] font-bold text-slate-300 uppercase" id="eval-live-grade">Predikat: A (Sangat Memuaskan)</div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Teknis Koding (35%)
                        </label>
                        <input type="number" step="0.1" min="0" max="100" id="eval-tech" name="technical_skill" required oninput="calcEvaluationScore()" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Kedisiplinan & SOP (25%)
                        </label>
                        <input type="number" step="0.1" min="0" max="100" id="eval-disc" name="discipline" required oninput="calcEvaluationScore()" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Teamwork & Agile (20%)
                        </label>
                        <input type="number" step="0.1" min="0" max="100" id="eval-team" name="teamwork" required oninput="calcEvaluationScore()" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Inisiatif & Solusi (20%)
                        </label>
                        <input type="number" step="0.1" min="0" max="100" id="eval-init" name="initiative" required oninput="calcEvaluationScore()" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Sertifikat Resmi</label>
                        <input type="text" id="eval-cert-no" name="certificate_number" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 font-mono font-bold focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Penerbitan</label>
                        <input type="date" id="eval-issue-date" name="issue_date" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Catatan Kualitatif / Feedback Industri</label>
                    <textarea id="eval-notes" name="general_notes" rows="2" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500" placeholder="Catatan evaluasi kompetensi magang siswa..."></textarea>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                    <button type="button" onclick="closeEvaluationModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition-colors cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-red-600/30 flex items-center gap-1.5 cursor-pointer">
                        <i data-lucide="award" class="w-3.5 h-3.5"></i>
                        <span>Simpan & Sahkan Nilai</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- 7. Modal Pilihan Hapus / Jadikan Alumni (Smart Deletion Modal) -->
    <div id="modal-delete-student-choice" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
        <div class="mas-card p-6 bg-white w-full max-w-md shadow-2xl space-y-4">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 border border-amber-200">
                    <i data-lucide="help-circle" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-sm font-black text-slate-900">Kelola Status / Hapus Siswa</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Pilih tindakan untuk siswa <b id="delete-modal-student-name" class="text-slate-800">Nama Siswa</b></p>
                </div>
            </div>

            <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-600 space-y-2 leading-relaxed">
                <p>Apakah siswa ini <b>telah menyelesaikan masa PKL (Lulus)</b> atau Anda ingin <b>menghapus permanen</b> dari sistem?</p>
            </div>

            <!-- 2 Pilihan Tindakan Utama -->
            <div class="space-y-2.5">
                <!-- Pilihan A: Pindahkan ke Alumni PKL -->
                <form id="form-choice-alumni" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="alumni">
                    <button type="submit" class="w-full p-3.5 rounded-xl border-2 border-indigo-200 bg-indigo-50/70 hover:bg-indigo-100 text-left transition-all flex items-start gap-3 group cursor-pointer">
                        <div class="w-8 h-8 rounded-lg bg-indigo-600 text-white flex items-center justify-center shrink-0 shadow-sm mt-0.5">
                            <i data-lucide="graduation-cap" class="w-4 h-4"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-1.5">
                                <span class="text-xs font-black text-indigo-950">Pindahkan ke Alumni PKL</span>
                                <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-indigo-200 text-indigo-800 uppercase tracking-wider">Direkomendasikan</span>
                            </div>
                            <p class="text-[11px] text-indigo-700/90 mt-0.5">Siswa lulus magang. Seluruh sertifikat, rapor nilai, portofolio, dan logbook <b>tetap aman tersimpan abadi</b>.</p>
                        </div>
                    </button>
                </form>

                <!-- Pilihan B: Hapus Permanen dari Database -->
                <form id="form-choice-delete" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('PERINGATAN: Seluruh data jurnal, tugas, dan nilai sertifikat siswa ini akan DIHAPUS PERMANEN dan tidak dapat dipulihkan. Yakin ingin melanjutkan?');" class="w-full p-3.5 rounded-xl border border-red-200 bg-red-50/40 hover:bg-red-50 text-left transition-all flex items-start gap-3 group cursor-pointer">
                        <div class="w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center shrink-0 mt-0.5">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </div>
                        <div class="flex-1">
                            <span class="text-xs font-bold text-red-800">Hapus Permanen Dari Database</span>
                            <p class="text-[11px] text-red-600/90 mt-0.5">Gunakan jika akun ini pendaftar fiktif/batal magang. Seluruh data & riwayat akan dimusnahkan.</p>
                        </div>
                    </button>
                </form>
            </div>

            <div class="pt-2 flex justify-end">
                <button type="button" onclick="closeStudentDeletionModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition-colors cursor-pointer">
                    Batal
                </button>
            </div>
        </div>
    </div>

    <script>
        function toggleAlumniFields(status) {
            const sec = document.getElementById('edit-alumni-section');
            if (sec) {
                if (status === 'alumni') {
                    sec.classList.remove('hidden');
                } else {
                    sec.classList.add('hidden');
                }
            }
        }

        function openEditModal(id, name, email, school, major, mentorId, status, alumniStatus, alumniCurrentAt) {
            const modal = document.getElementById('modal-edit-student');
            const form = document.getElementById('form-edit-student');
            form.action = "{{ url('/admin/siswa') }}/" + id;
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-email').value = email;
            document.getElementById('edit-school').value = school;
            document.getElementById('edit-major').value = major;
            document.getElementById('edit-mentor-id').value = mentorId || '';
            
            const statusEl = document.getElementById('edit-status');
            if (statusEl) {
                statusEl.value = status || 'aktif';
                toggleAlumniFields(statusEl.value);
            }
            const alumniStatusEl = document.getElementById('edit-alumni-status');
            if (alumniStatusEl) {
                alumniStatusEl.value = alumniStatus || 'bekerja';
            }
            const alumniCurrentAtEl = document.getElementById('edit-alumni-current-at');
            if (alumniCurrentAtEl) {
                alumniCurrentAtEl.value = alumniCurrentAt || '';
            }

            modal.classList.remove('hidden');
            if (window.lucide) { lucide.createIcons(); }
        }

        function closeEditModal() {
            document.getElementById('modal-edit-student').classList.add('hidden');
        }

        function openStudentDeletionModal(id, name, currentStatus) {
            const modal = document.getElementById('modal-delete-student-choice');
            document.getElementById('delete-modal-student-name').textContent = name;
            document.getElementById('form-choice-alumni').action = "{{ url('/admin/siswa') }}/" + id + "/alumni";
            document.getElementById('form-choice-delete').action = "{{ url('/admin/siswa') }}/" + id;
            modal.classList.remove('hidden');
            if (window.lucide) { lucide.createIcons(); }
        }

        function closeStudentDeletionModal() {
            document.getElementById('modal-delete-student-choice').classList.add('hidden');
        }

        function openEvaluationModal(id, name, accountId, tech, disc, team, init, certNo, issueDate, notes) {
            const modal = document.getElementById('modal-evaluation-student');
            const form = document.getElementById('form-evaluation-student');
            form.action = "{{ url('/admin/evaluasi') }}/" + id;
            document.getElementById('eval-student-subtitle').textContent = "Siswa: " + name + " (ID: " + accountId + ")";
            document.getElementById('eval-tech').value = tech;
            document.getElementById('eval-disc').value = disc;
            document.getElementById('eval-team').value = team;
            document.getElementById('eval-init').value = init;
            document.getElementById('eval-cert-no').value = certNo;
            document.getElementById('eval-issue-date').value = issueDate;
            document.getElementById('eval-notes').value = notes;
            calcEvaluationScore();
            modal.classList.remove('hidden');
            if (window.lucide) { lucide.createIcons(); }
        }

        function closeEvaluationModal() {
            document.getElementById('modal-evaluation-student').classList.add('hidden');
        }

        
        function openExportModal() {
            const m = document.getElementById('modal-export-student');
            if (m) {
                m.classList.remove('hidden');
                m.classList.add('flex');
                if (window.lucide) { lucide.createIcons(); }
            }
        }
        function closeExportModal() {
            const m = document.getElementById('modal-export-student');
            if (m) {
                m.classList.add('hidden');
                m.classList.remove('flex');
            }
        }

        function calcEvaluationScore() {
            const t = parseFloat(document.getElementById('eval-tech').value) || 0;
            const d = parseFloat(document.getElementById('eval-disc').value) || 0;
            const tm = parseFloat(document.getElementById('eval-team').value) || 0;
            const i = parseFloat(document.getElementById('eval-init').value) || 0;
            const finalScore = Math.round(((t * 0.35) + (d * 0.25) + (tm * 0.20) + (i * 0.20)) * 10) / 10;
            document.getElementById('eval-live-score').textContent = finalScore.toFixed(1);
            let grade = 'Predikat: D (Kurang)';
            if (finalScore >= 85) grade = 'Predikat: A (Sangat Memuaskan)';
            else if (finalScore >= 75) grade = 'Predikat: B (Memuaskan)';
            else if (finalScore >= 60) grade = 'Predikat: C (Cukup)';
            document.getElementById('eval-live-grade').textContent = grade;
        }
    </script>

    <!-- MODAL PILIH FORMAT EKSPOR (EXCEL / CSV) -->
    <div id="modal-export-student" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl border border-slate-200 overflow-hidden transform transition-all animate-in fade-in zoom-in-95 duration-150">
            <!-- Modal Header -->
            <div class="p-6 pb-4 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center shrink-0">
                        <i data-lucide="file-spreadsheet" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-black text-slate-900">Pilih Format Ekspor Data</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Pilih format berkas rekapitulasi siswa yang diinginkan:</p>
                    </div>
                </div>
                <button type="button" onclick="closeExportModal()" class="w-8 h-8 rounded-xl hover:bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition-colors">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            <!-- Modal Body: Choices -->
            <div class="p-6 space-y-3">
                <!-- Option 1: Microsoft Excel (.xls) -->
                <a href="{{ route('admin.students.export', array_merge(request()->query(), ['format' => 'excel'])) }}" 
                   onclick="closeExportModal()"
                   class="group p-4 rounded-2xl border-2 border-emerald-100 hover:border-emerald-500 bg-emerald-50/40 hover:bg-emerald-50 transition-all flex items-start gap-3.5 block text-left">
                    <div class="w-11 h-11 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-black text-xs shrink-0 shadow-md shadow-emerald-600/20 group-hover:scale-105 transition-transform">
                        XLS
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-2">
                            <h4 class="text-xs font-bold text-slate-900 group-hover:text-emerald-700 transition-colors">Microsoft Excel (.xls)</h4>
                            <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-full">Rekomendasi</span>
                        </div>
                        <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">
                            Format spreadsheet dengan warna header hijau TMS, border tabel rapi, dan kop resmi. Langsung siap dibuka di MS Excel & WPS.
                        </p>
                    </div>
                    <i data-lucide="download" class="w-4 h-4 text-emerald-600 shrink-0 mt-1 opacity-60 group-hover:opacity-100 group-hover:translate-y-0.5 transition-all"></i>
                </a>

                <!-- Option 2: CSV Universal (.csv) -->
                <a href="{{ route('admin.students.export', array_merge(request()->query(), ['format' => 'csv'])) }}" 
                   onclick="closeExportModal()"
                   class="group p-4 rounded-2xl border-2 border-slate-200 hover:border-slate-800 bg-slate-50/50 hover:bg-slate-100 transition-all flex items-start gap-3.5 block text-left">
                    <div class="w-11 h-11 rounded-xl bg-slate-800 text-white flex items-center justify-center font-black text-xs shrink-0 shadow-md shadow-slate-800/20 group-hover:scale-105 transition-transform">
                        CSV
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-2">
                            <h4 class="text-xs font-bold text-slate-900 group-hover:text-black transition-colors">Comma Separated Values (.csv)</h4>
                            <span class="text-[10px] font-bold text-slate-600 bg-slate-200 px-2 py-0.5 rounded-full">Universal</span>
                        </div>
                        <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">
                            Format teks data terpisah koma dengan UTF-8 BOM. Sangat cocok untuk Google Sheets, SQL database, atau script data.
                        </p>
                    </div>
                    <i data-lucide="download" class="w-4 h-4 text-slate-600 shrink-0 mt-1 opacity-60 group-hover:opacity-100 group-hover:translate-y-0.5 transition-all"></i>
                </a>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-3.5 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                <span>Klik opsi untuk langsung mengunduh</span>
                <button type="button" onclick="closeExportModal()" class="px-3 py-1.5 rounded-xl font-bold text-slate-600 hover:bg-slate-200 transition-colors">
                    Batal
                </button>
            </div>
        </div>
    </div>

</div>

@include('partials.import-modal', [
    'importRoute' => route('admin.students.import'),
    'importTitle' => 'Import / Restore Data Siswa Magang',
    'templateName' => 'Template_Import_Data_Siswa_TMS.xlsx',
    'templateHeaders' => ['No','ID Akun','Nama Lengkap','Email','NIS / NIM','No. WhatsApp','Asal Sekolah','Jurusan','Angkatan','Mentor Pembimbing','Status Magang','Status Karir Alumni','Instansi / Kampus Alumni','Jml Logbook','Nilai Akhir','Predikat','No. E-Sertifikat'],
    'sampleRow' => ['1','20999','Contoh Siswa Magang','contoh.siswa@smkn1ciamis.sch.id','212210999','081234567890','SMKN 1 Ciamis','PPLG','Angkatan 2026','Mentor Test 1','Aktif Magang','-','-','0','-','-','-'],
])
@endsection
