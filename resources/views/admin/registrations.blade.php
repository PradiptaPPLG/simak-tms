@extends('layouts.simak')

@section('title', 'Manajemen Pendaftaran PKL Online • Admin TMS')

@section('content')
<div class="space-y-6 min-w-0 max-w-full">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-black tracking-tight text-slate-900">Manajemen Pendaftaran PKL Online</h1>
            <p class="text-xs text-slate-500 mt-0.5">Tinjau biodata pendaftar, seleksi administrasi, verifikasi kuota, dan pembuatan data siswa magang.</p>
        </div>

        <div class="grid grid-cols-2 sm:flex sm:items-center gap-2 w-full sm:w-auto no-print">
            <!-- Green Export Button (Opens Format Choice Modal) -->
            <button type="button" onclick="openExportModal()" class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-emerald-600/20 flex items-center gap-1.5 cursor-pointer" title="Unduh Berkas Spreadsheet Data Pendaftaran (Excel / CSV)">
                <i data-lucide="file-spreadsheet" class="w-4 h-4 text-emerald-100 shrink-0"></i>
                <span>Ekspor Excel / CSV</span>
                <i data-lucide="chevron-down" class="w-3 h-3 text-emerald-200 shrink-0"></i>
            </button>
            <button type="button" onclick="openImportModal()" class="px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-indigo-600/20 flex items-center gap-1.5 cursor-pointer" title="Import / Restore Data Pendaftaran PKL dari Excel atau CSV">
                <i data-lucide="upload-cloud" class="w-4 h-4 text-indigo-100 shrink-0"></i>
                <span>Import Excel / CSV</span>
            </button>
            <a href="{{ route('registry.index') }}" target="_blank" class="px-3.5 py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl transition-all shadow-sm flex items-center gap-1.5">
                <i data-lucide="external-link" class="w-4 h-4 text-red-400 shrink-0"></i>
                <span>Buka Form Pendaftaran</span>
            </a>
            <button onclick="window.print()" class="px-3.5 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-xl transition-all shadow-xs flex items-center justify-center gap-1.5 cursor-pointer">
                <i data-lucide="printer" class="w-4 h-4 text-slate-500 shrink-0"></i>
                <span>Cetak Rekap</span>
            </button>
        </div>
    </div>

    <!-- 1. Stats Counter Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
        <a href="{{ route('admin.registrations', ['status' => 'all']) }}" class="mas-card p-4 border-l-4 {{ $status === 'all' ? 'border-l-red-600 ring-2 ring-red-500/20' : 'border-l-slate-400' }} hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-[10px] font-bold uppercase tracking-wider">Total Pendaftar</p>
                    <h3 class="text-xl sm:text-2xl font-black text-slate-900 font-mono mt-0.5">{{ $counts['all'] }}</h3>
                    <p class="text-[10px] text-slate-500 mt-0.5">Semua formulir masuk</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center">
                    <i data-lucide="inbox" class="w-5 h-5"></i>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.registrations', ['status' => 'pending']) }}" class="mas-card p-4 border-l-4 {{ $status === 'pending' ? 'border-l-amber-500 ring-2 ring-amber-500/20' : 'border-l-amber-400' }} hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-amber-600 text-[10px] font-bold uppercase tracking-wider flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-ping"></span>
                        Menunggu Review
                    </p>
                    <h3 class="text-xl sm:text-2xl font-black text-amber-600 font-mono mt-0.5">{{ $counts['pending'] }}</h3>
                    <p class="text-[10px] text-slate-500 mt-0.5">Perlu diverifikasi</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <i data-lucide="clock" class="w-5 h-5"></i>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.registrations', ['status' => 'approved']) }}" class="mas-card p-4 border-l-4 {{ $status === 'approved' ? 'border-l-emerald-600 ring-2 ring-emerald-500/20' : 'border-l-emerald-400' }} hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-600 text-[10px] font-bold uppercase tracking-wider">Disetujui / Lolos</p>
                    <h3 class="text-xl sm:text-2xl font-black text-emerald-600 font-mono mt-0.5">{{ $counts['approved'] }}</h3>
                    <p class="text-[10px] text-slate-500 mt-0.5">Masuk ke data siswa</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <i data-lucide="check-circle-2" class="w-5 h-5"></i>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.registrations', ['status' => 'rejected']) }}" class="mas-card p-4 border-l-4 {{ $status === 'rejected' ? 'border-l-rose-600 ring-2 ring-rose-500/20' : 'border-l-rose-400' }} hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-rose-600 text-[10px] font-bold uppercase tracking-wider">Ditolak</p>
                    <h3 class="text-xl sm:text-2xl font-black text-rose-600 font-mono mt-0.5">{{ $counts['rejected'] }}</h3>
                    <p class="text-[10px] text-slate-500 mt-0.5">Tidak memenuhi kuota</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                    <i data-lucide="x-circle" class="w-5 h-5"></i>
                </div>
            </div>
        </a>
    </div>

    <!-- 2. Filter Navigation Tabs & Search -->
    <div class="mas-card p-4 no-print">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
            <!-- Tabs -->
            <div class="flex items-center gap-1.5 overflow-x-auto pb-1 md:pb-0 scrollbar-none text-xs">
                <a href="{{ route('admin.registrations', ['status' => 'all']) }}" 
                   class="px-3 py-1.5 rounded-xl font-bold transition-all shrink-0 {{ $status === 'all' ? 'bg-red-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                    Semua ({{ $counts['all'] }})
                </a>
                <a href="{{ route('admin.registrations', ['status' => 'pending']) }}" 
                   class="px-3 py-1.5 rounded-xl font-bold transition-all shrink-0 flex items-center gap-1.5 {{ $status === 'pending' ? 'bg-amber-500 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                    @if($counts['pending'] > 0)
                        <span class="w-2 h-2 rounded-full bg-amber-200 animate-pulse"></span>
                    @endif
                    Menunggu Review ({{ $counts['pending'] }})
                </a>
                <a href="{{ route('admin.registrations', ['status' => 'approved']) }}" 
                   class="px-3 py-1.5 rounded-xl font-bold transition-all shrink-0 {{ $status === 'approved' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                    Disetujui ({{ $counts['approved'] }})
                </a>
                <a href="{{ route('admin.registrations', ['status' => 'rejected']) }}" 
                   class="px-3 py-1.5 rounded-xl font-bold transition-all shrink-0 {{ $status === 'rejected' ? 'bg-rose-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                    Ditolak ({{ $counts['rejected'] }})
                </a>
            </div>

            <!-- Search Filter Bar -->
            <div class="relative w-full md:w-72">
                <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" id="reg-search-input" placeholder="Cari nama, NIS, kode antrian..." 
                       class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white transition-all">
            </div>
        </div>
    </div>

    <!-- 4. Applicants Table -->
    <div class="mas-card overflow-hidden">
        <div class="p-4 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i data-lucide="list-checks" class="w-5 h-5 text-red-600"></i>
                <h2 class="text-sm font-bold text-slate-900">Daftar Formulir Antrian Pendaftaran ({{ $registrations->total() }})</h2>
            </div>
            <span class="text-[11px] text-slate-400">Diperbarui: {{ now()->translatedFormat('d F Y, H:i') }}</span>
        </div>

        <!-- Mobile Card List (Responsive < 768px) -->
        <div class="md:hidden divide-y divide-slate-100">
            @forelse($registrations as $reg)
                <div class="p-4 space-y-2.5">
                    <div class="flex items-start justify-between gap-2">
                        <div class="min-w-0">
                            <span class="font-mono text-[10px] font-bold text-slate-700 bg-slate-100 px-2 py-0.5 rounded border border-slate-200">{{ $reg->registration_code }}</span>
                            <div class="font-bold text-slate-900 text-xs mt-1 truncate">{{ $reg->full_name }}</div>
                            <div class="text-[10px] text-slate-500 font-mono">NIS: {{ $reg->nis ?? '-' }} • {{ $reg->school_origin ?? 'SMKN 1 Ciamis' }}</div>
                        </div>
                        <div class="shrink-0">
                            @if($reg->status === 'pending')
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">Pending</span>
                            @elseif($reg->status === 'approved')
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Disetujui</span>
                            @else
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">Ditolak</span>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center justify-between gap-2 pt-1 text-[11px] no-print">
                        <span class="text-slate-500 truncate">{{ $reg->email }}</span>
                        <div class="flex items-center gap-1.5 shrink-0">
                            <button type="button" onclick="openDetailModal({{ json_encode($reg) }})" class="px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold cursor-pointer">Detail</button>
                            <div class="relative inline-block text-left dropdown-container">
                                <button type="button" onclick="toggleActionDropdown(this, event)" class="w-8 h-8 rounded-lg bg-white hover:bg-slate-100 text-slate-600 border border-slate-200 flex items-center justify-center cursor-pointer" title="Opsi Aksi">
                                    <i data-lucide="more-vertical" class="w-4 h-4"></i>
                                </button>
                                <div class="action-dropdown hidden absolute right-0 bottom-full mb-1.5 w-48 bg-white rounded-2xl shadow-xl border border-slate-100 py-1.5 z-50 divide-y divide-slate-100 text-left">
                                    @if($reg->status === 'pending')
                                        <div class="py-1">
                                            <form method="POST" action="{{ route('admin.registrations.approve', $reg->id) }}" onsubmit="return confirm('Setujui pendaftaran PKL atas nama {{ addslashes($reg->full_name) }}?');">
                                                @csrf
                                                <button type="submit" class="w-full flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-emerald-700 hover:bg-emerald-50 text-left cursor-pointer">
                                                    <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-600"></i>
                                                    <span>Setujui Pendaftaran</span>
                                                </button>
                                            </form>
                                            <button type="button" onclick="openRejectModal({{ $reg->id }}, '{{ addslashes($reg->full_name) }}')" class="w-full flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-rose-700 hover:bg-rose-50 text-left cursor-pointer">
                                                <i data-lucide="x" class="w-3.5 h-3.5 text-rose-500"></i>
                                                <span>Tolak Pendaftaran</span>
                                            </button>
                                        </div>
                                    @endif
                                    <div class="py-1">
                                        <form method="POST" action="{{ route('admin.registrations.destroy', $reg->id) }}" onsubmit="return confirm('Hapus data pendaftaran {{ addslashes($reg->full_name) }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-red-600 hover:bg-red-50 text-left cursor-pointer">
                                                <i data-lucide="trash-2" class="w-3.5 h-3.5 text-red-500"></i>
                                                <span>Hapus Antrian</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-xs text-slate-400">Belum ada data pendaftaran.</div>
            @endforelse
        </div>

        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left text-xs" id="reg-table">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/50 text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                        <th class="py-3 px-4">No</th>
                        <th class="py-3 px-4">Kode Antrian</th>
                        <th class="py-3 px-4">Calon Siswa & NIS</th>
                        <th class="py-3 px-4">Sekolah & Keahlian</th>
                        <th class="py-3 px-4">Kontak Siswa</th>
                        <th class="py-3 px-4">Tanggal Masuk</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-right action-col no-print">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100" id="reg-tbody">
                    @forelse($registrations as $index => $reg)
                        <tr class="hover:bg-slate-50/80 transition-colors reg-row" 
                            data-search="{{ strtolower($reg->full_name . ' ' . $reg->registration_code . ' ' . $reg->nis . ' ' . $reg->school_origin . ' ' . $reg->skill_competency) }}">
                            <td class="py-3.5 px-4 font-mono text-slate-400">{{ $index + 1 }}</td>
                            
                            <td class="py-3.5 px-4">
                                <span class="font-mono text-xs font-bold text-slate-900 bg-slate-100 px-2 py-1 rounded-md border border-slate-200 tracking-tight">
                                    {{ $reg->registration_code }}
                                </span>
                            </td>

                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg overflow-hidden bg-slate-900 text-white font-bold text-xs flex items-center justify-center shrink-0">
                                        {{ substr($reg->full_name, 0, 2) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900 text-xs flex items-center gap-1.5">
                                            <span>{{ $reg->full_name }}</span>
                                            @if($reg->gender === 'Laki-laki')
                                                <span class="text-[9px] px-1.5 py-0.2 rounded bg-blue-50 text-blue-600 font-semibold border border-blue-200">L</span>
                                            @else
                                                <span class="text-[9px] px-1.5 py-0.2 rounded bg-pink-50 text-pink-600 font-semibold border border-pink-200">P</span>
                                            @endif
                                        </div>
                                        <div class="text-[10px] text-slate-400 font-mono mt-0.5">NIS: {{ $reg->nis }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="py-3.5 px-4">
                                <div class="font-semibold text-slate-800">{{ $reg->school_origin ?? 'SMKN 1 Ciamis' }}</div>
                                <div class="text-[10px] text-red-600 font-medium">{{ $reg->skill_competency }}</div>
                            </td>

                            <td class="py-3.5 px-4">
                                <div class="text-[11px] text-slate-700 flex items-center gap-1">
                                    <i data-lucide="mail" class="w-3 h-3 text-slate-400 shrink-0"></i>
                                    <span class="truncate max-w-[140px]">{{ $reg->email }}</span>
                                </div>
                                <div class="text-[10px] text-slate-500 font-mono flex items-center gap-1 mt-0.5">
                                    <i data-lucide="phone" class="w-3 h-3 text-emerald-500 shrink-0"></i>
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $reg->phone_number) }}" target="_blank" class="hover:text-emerald-600 hover:underline">
                                        {{ $reg->phone_number }}
                                    </a>
                                </div>
                            </td>

                            <td class="py-3.5 px-4 font-mono text-[11px] text-slate-500">
                                <div>{{ $reg->created_at ? $reg->created_at->translatedFormat('d M Y') : '-' }}</div>
                                <div class="text-[10px] text-slate-400">{{ $reg->created_at ? $reg->created_at->translatedFormat('H:i') . ' WIB' : '' }}</div>
                            </td>

                            <td class="py-3.5 px-4 text-center">
                                @if($reg->status === 'pending')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                        Pending
                                    </span>
                                @elseif($reg->status === 'approved')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <i data-lucide="check" class="w-3 h-3 text-emerald-600"></i>
                                        Disetujui
                                    </span>
                                @elseif($reg->status === 'rejected')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                        <i data-lucide="x" class="w-3 h-3 text-rose-600"></i>
                                        Ditolak
                                    </span>
                                @endif
                            </td>

                            <td class="py-3.5 px-4 text-right action-col no-print">
                                <!-- Menu Aksi Titik 3 (More Action Dropdown) -->
                                <div class="relative inline-block text-left dropdown-container">
                                    <button type="button" onclick="toggleActionDropdown(this, event)" class="w-8 h-8 rounded-xl bg-white hover:bg-slate-100 text-slate-600 hover:text-slate-900 border border-slate-200 transition-colors shadow-2xs flex items-center justify-center cursor-pointer ml-auto" title="Opsi Aksi Pendaftaran">
                                        <i data-lucide="more-vertical" class="w-4 h-4"></i>
                                    </button>
                                    <div class="action-dropdown hidden absolute right-0 mt-1.5 w-48 bg-white rounded-2xl shadow-xl border border-slate-100 py-1.5 z-40 divide-y divide-slate-100 text-left animate-in fade-in zoom-in-95 duration-100">
                                        <div class="py-1">
                                            <button type="button" 
                                                    onclick="openDetailModal({{ json_encode($reg) }})" 
                                                    class="w-full flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors text-left cursor-pointer">
                                                <i data-lucide="eye" class="w-3.5 h-3.5 text-slate-400"></i>
                                                <span>Lihat Biodata</span>
                                            </button>
                                        </div>

                                        @if($reg->status === 'pending')
                                            <div class="py-1">
                                                <form method="POST" action="{{ route('admin.registrations.approve', $reg->id) }}" onsubmit="return confirm('Setujui pendaftaran PKL atas nama {{ addslashes($reg->full_name) }}?\n\nSiswa akan otomatis masuk ke menu Data Siswa.');">
                                                    @csrf
                                                    <button type="submit" class="w-full flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-emerald-700 hover:bg-emerald-50 transition-colors text-left cursor-pointer">
                                                        <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-600"></i>
                                                        <span>Setujui Pendaftaran</span>
                                                    </button>
                                                </form>
                                                <button type="button" 
                                                        onclick="openRejectModal({{ $reg->id }}, '{{ addslashes($reg->full_name) }}')"
                                                        class="w-full flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-rose-700 hover:bg-rose-50 transition-colors text-left cursor-pointer">
                                                    <i data-lucide="x" class="w-3.5 h-3.5 text-rose-500"></i>
                                                    <span>Tolak Pendaftaran</span>
                                                </button>
                                            </div>
                                        @elseif($reg->status === 'approved')
                                            <div class="py-1">
                                                <a href="{{ route('admin.students') }}" class="flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-indigo-700 hover:bg-indigo-50 transition-colors">
                                                    <i data-lucide="user-check" class="w-3.5 h-3.5 text-indigo-600"></i>
                                                    <span>Buka di Data Siswa</span>
                                                </a>
                                            </div>
                                        @endif

                                        <div class="py-1">
                                            <form method="POST" action="{{ route('admin.registrations.destroy', $reg->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus antrian formulir pendaftaran {{ addslashes($reg->full_name) }}?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-red-600 hover:bg-red-50 transition-colors text-left cursor-pointer">
                                                    <i data-lucide="trash-2" class="w-3.5 h-3.5 text-red-500"></i>
                                                    <span>Hapus Formulir</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-12 text-slate-400">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                    <i data-lucide="inbox" class="w-6 h-6"></i>
                                </div>
                                <p class="font-bold text-slate-700 text-sm">Belum Ada Formulir Pendaftaran</p>
                                <p class="text-xs text-slate-400 mt-1">Calon peserta yang mendaftar melalui tautan formulir akan tampil di sini.</p>
                                <a href="{{ route('registry.index') }}" target="_blank" class="inline-flex items-center gap-1.5 mt-3 text-xs text-red-600 font-bold hover:underline">
                                    <span>Buka Form Pendaftaran Calon Siswa</span>
                                    <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($registrations->hasPages())
            <div class="px-4 py-3 border-t border-slate-100 bg-slate-50/50 no-print">
                {{ $registrations->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal: Biodata Lengkap Calon Siswa -->
<div id="detail-modal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 space-y-5 animate-in fade-in zoom-in-95 duration-150">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-red-50 text-red-600 flex items-center justify-center">
                    <i data-lucide="user" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 text-sm">Biodata Calon Siswa Magang</h3>
                    <p class="text-[11px] text-slate-400" id="modal-queue-code">TMS-REG-XXXXX</p>
                </div>
            </div>
            <button onclick="closeDetailModal()" class="w-8 h-8 rounded-full hover:bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition-colors">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <div class="space-y-3.5 text-xs">
            <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100 flex items-center justify-between">
                <div>
                    <p class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Status Pendaftaran</p>
                    <div id="modal-status-badge" class="mt-0.5"></div>
                </div>
                <div class="text-right">
                    <p class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Tanggal Submit</p>
                    <p class="font-mono text-slate-700 font-semibold" id="modal-created-at">-</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="p-3 bg-white rounded-xl border border-slate-200">
                    <span class="text-[10px] font-bold text-slate-400 uppercase block mb-0.5">Nama Lengkap</span>
                    <span class="font-bold text-slate-900 text-xs" id="modal-full-name">-</span>
                </div>
                <div class="p-3 bg-white rounded-xl border border-slate-200">
                    <span class="text-[10px] font-bold text-slate-400 uppercase block mb-0.5">NIS</span>
                    <span class="font-mono font-bold text-slate-900 text-xs" id="modal-nis">-</span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="p-3 bg-white rounded-xl border border-slate-200">
                    <span class="text-[10px] font-bold text-slate-400 uppercase block mb-0.5">Jenis Kelamin</span>
                    <span class="font-semibold text-slate-800" id="modal-gender">-</span>
                </div>
                <div class="p-3 bg-white rounded-xl border border-slate-200">
                    <span class="text-[10px] font-bold text-slate-400 uppercase block mb-0.5">Agama</span>
                    <span class="font-semibold text-slate-800" id="modal-religion">-</span>
                </div>
            </div>

            <div class="p-3 bg-white rounded-xl border border-slate-200">
                <span class="text-[10px] font-bold text-slate-400 uppercase block mb-0.5">Tempat & Tanggal Lahir</span>
                <span class="font-semibold text-slate-800" id="modal-birth-info">-</span>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="p-3 bg-white rounded-xl border border-slate-200">
                    <span class="text-[10px] font-bold text-slate-400 uppercase block mb-0.5">Asal Sekolah</span>
                    <span class="font-semibold text-slate-800" id="modal-school">-</span>
                </div>
                <div class="p-3 bg-white rounded-xl border border-slate-200">
                    <span class="text-[10px] font-bold text-slate-400 uppercase block mb-0.5">Kompetensi Keahlian</span>
                    <span class="font-semibold text-red-600 font-mono" id="modal-skill">-</span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="p-3 bg-white rounded-xl border border-slate-200">
                    <span class="text-[10px] font-bold text-slate-400 uppercase block mb-0.5">Email Aktif</span>
                    <span class="font-mono text-slate-800 break-all" id="modal-email">-</span>
                </div>
                <div class="p-3 bg-white rounded-xl border border-slate-200">
                    <span class="text-[10px] font-bold text-slate-400 uppercase block mb-0.5">No. HP / WhatsApp</span>
                    <a href="#" id="modal-phone-link" target="_blank" class="font-mono text-emerald-600 font-semibold hover:underline block">
                        <span id="modal-phone">-</span>
                    </a>
                </div>
            </div>

            <div id="modal-rejection-box" class="p-3 bg-rose-50 rounded-xl border border-rose-200 text-rose-800 hidden">
                <span class="text-[10px] font-bold uppercase tracking-wider block mb-0.5 text-rose-600">Alasan Penolakan:</span>
                <p id="modal-rejection-reason" class="text-xs italic"></p>
            </div>
        </div>

        <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
            <button type="button" onclick="closeDetailModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-colors">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- Modal: Alasan Penolakan -->
<div id="reject-modal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-100 space-y-4 animate-in fade-in zoom-in-95 duration-150">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                    <i data-lucide="x-circle" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 text-sm">Tolak Pendaftaran Calon Siswa</h3>
                    <p class="text-[11px] text-slate-400" id="reject-applicant-name">Nama Siswa</p>
                </div>
            </div>
            <button onclick="closeRejectModal()" class="w-8 h-8 rounded-full hover:bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition-colors">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <form id="reject-form" method="POST" action="" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Alasan Penolakan (Akan tampil saat dicek oleh siswa):</label>
                <textarea name="rejection_reason" rows="3" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-rose-500 text-slate-800" placeholder="Tuliskan alasan penolakan, misal kuota jurusan magang telah penuh atau kualifikasi belum sesuai.">Mohon maaf, kuota penerimaan magang periode ini telah penuh / kualifikasi belum memenuhi.</textarea>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                <button type="button" onclick="closeRejectModal()" class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl shadow-sm transition-colors">
                    Konfirmasi Tolak
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Search Filter
    const searchInput = document.getElementById('reg-search-input');
    const rows = document.querySelectorAll('.reg-row');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            rows.forEach(row => {
                const searchData = row.getAttribute('data-search') || '';
                if (searchData.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    // Detail Modal
    function openDetailModal(data) {
        document.getElementById('modal-queue-code').textContent = data.registration_code || '-';
        document.getElementById('modal-full-name').textContent = data.full_name || '-';
        document.getElementById('modal-nis').textContent = data.nis || '-';
        document.getElementById('modal-gender').textContent = data.gender || '-';
        document.getElementById('modal-religion').textContent = data.religion || '-';
        
        let birthStr = (data.birth_place ? data.birth_place : '') + (data.birth_date ? (', ' + data.birth_date) : '');
        document.getElementById('modal-birth-info').textContent = birthStr || '-';
        document.getElementById('modal-school').textContent = data.school_origin || 'SMKN 1 Ciamis';
        document.getElementById('modal-skill').textContent = data.skill_competency || '-';
        document.getElementById('modal-email').textContent = data.email || '-';
        document.getElementById('modal-phone').textContent = data.phone_number || '-';
        
        const cleanPhone = (data.phone_number || '').replace(/[^0-9]/g, '');
        document.getElementById('modal-phone-link').href = 'https://wa.me/' + cleanPhone;

        const dateObj = new Date(data.created_at);
        document.getElementById('modal-created-at').textContent = dateObj.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });

        const statusBadge = document.getElementById('modal-status-badge');
        const rejectBox = document.getElementById('modal-rejection-box');
        
        if (data.status === 'pending') {
            statusBadge.innerHTML = '<span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">Pending Review</span>';
            rejectBox.classList.add('hidden');
        } else if (data.status === 'approved') {
            statusBadge.innerHTML = '<span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Disetujui</span>';
            rejectBox.classList.add('hidden');
        } else if (data.status === 'rejected') {
            statusBadge.innerHTML = '<span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">Ditolak</span>';
            document.getElementById('modal-rejection-reason').textContent = data.rejection_reason || 'Tidak ada catatan tambahan.';
            rejectBox.classList.remove('hidden');
        }

        document.getElementById('detail-modal').classList.remove('hidden');
        lucide.createIcons();
    }

    function closeDetailModal() {
        document.getElementById('detail-modal').classList.add('hidden');
    }

    // Reject Modal
    function openRejectModal(id, name) {
        document.getElementById('reject-applicant-name').textContent = name;
        document.getElementById('reject-form').action = '/admin/pendaftaran/' + id + '/reject';
        document.getElementById('reject-modal').classList.remove('hidden');
        lucide.createIcons();
    }

    function closeRejectModal() {
        document.getElementById('reject-modal').classList.add('hidden');
    }

    function openExportModal() {
        const m = document.getElementById('modal-export-registrations');
        if (m) {
            m.classList.remove('hidden');
            m.classList.add('flex');
            if (window.lucide) { lucide.createIcons(); }
        }
    }
    function closeExportModal() {
        const m = document.getElementById('modal-export-registrations');
        if (m) {
            m.classList.add('hidden');
            m.classList.remove('flex');
        }
    }

</script>

<!-- MODAL PILIH FORMAT EKSPOR PENDAFTARAN (EXCEL / CSV) -->
<div id="modal-export-registrations" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl border border-slate-200 overflow-hidden transform transition-all animate-in fade-in zoom-in-95 duration-150">
        <!-- Modal Header -->
        <div class="p-6 pb-4 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center shrink-0">
                    <i data-lucide="file-spreadsheet" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-slate-900">Pilih Format Ekspor Pendaftaran</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Pilih format berkas data pendaftar PKL yang diinginkan:</p>
                </div>
            </div>
            <button type="button" onclick="closeExportModal()" class="w-8 h-8 rounded-xl hover:bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition-colors">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <!-- Modal Body: Choices -->
        <div class="p-6 space-y-3">
            <!-- Option 1: Microsoft Excel (.xls) -->
            <a href="{{ route('admin.registrations.export', array_merge(request()->query(), ['format' => 'excel'])) }}" 
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
                        Format spreadsheet dengan biodata pendaftar, NIS, kontak WA, status verifikasi, warna header hijau TMS & kop resmi.
                    </p>
                </div>
                <i data-lucide="download" class="w-4 h-4 text-emerald-600 shrink-0 mt-1 opacity-60 group-hover:opacity-100 group-hover:translate-y-0.5 transition-all"></i>
            </a>

            <!-- Option 2: CSV Universal (.csv) -->
            <a href="{{ route('admin.registrations.export', array_merge(request()->query(), ['format' => 'csv'])) }}" 
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
                        Format teks data terpisah koma dengan UTF-8 BOM. Sangat cocok untuk Google Sheets, basis data SQL, atau olah data lainnya.
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

@include('partials.import-modal', [
    'importRoute' => route('admin.registrations.import'),
    'importTitle' => 'Import / Restore Antrian Pendaftaran PKL',
    'templateName' => 'Template_Import_Pendaftaran_TMS.xlsx',
    'templateHeaders' => ['No','Kode Antrian','Nama Lengkap','Jenis Kelamin','NIS / NISN','Tempat Lahir','Tanggal Lahir','Agama','Email','No. WhatsApp','Asal Sekolah','Kompetensi Keahlian','Status','Catatan','Waktu Mendaftar'],
    'sampleRow' => ['1','REG-CONTOH01','Contoh Pendaftar PKL','Laki-laki','242510999','Ciamis','2009-03-02','Islam','pendaftar.contoh@gmail.com','081234567890','SMKN 1 Ciamis','PPLG','Pending Review','Siap magang di TMS','27 Nov 2026'],
])
@endsection
