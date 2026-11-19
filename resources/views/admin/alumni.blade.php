@extends('layouts.simak')

@section('title', 'Direktori Alumni PKL • PT. Teknologi Multi Sistem')

@section('content')
<div class="space-y-6 min-w-0 max-w-full">

    <!-- Header Section (2 Informasi Inti: Judul + Subtitle) -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-black tracking-tight text-slate-900 flex items-center gap-2.5">
                <i data-lucide="graduation-cap" class="w-6 h-6 text-red-600"></i>
                <span>Direktori Alumni PKL PT. TMS</span>
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">Pusat rekam jejak, direktori karir, dan showcase talenta lulusan Praktik Kerja Lapangan.</p>
        </div>

        <div class="flex items-center gap-2 no-print">
            <!-- Green Export Button (Opens Format Choice Modal) -->
            <button type="button" onclick="openExportModal()" class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-emerald-600/20 flex items-center gap-1.5 cursor-pointer" title="Unduh Berkas Spreadsheet Data Alumni (Excel / CSV)">
                <i data-lucide="file-spreadsheet" class="w-4 h-4 text-emerald-100 shrink-0"></i>
                <span>Ekspor Excel / CSV</span>
                <i data-lucide="chevron-down" class="w-3 h-3 text-emerald-200 shrink-0"></i>
            </button>
            <a href="{{ route('admin.students', ['status' => 'alumni']) }}" class="px-3.5 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-xl transition-all shadow-xs flex items-center gap-1.5">
                <i data-lucide="table" class="w-4 h-4 text-slate-500 shrink-0"></i>
                <span class="hidden sm:inline">Mode Tabel Siswa</span>
            </a>
            <button onclick="window.print()" class="px-3.5 py-2 bg-slate-900 hover:bg-black text-white text-xs font-bold rounded-xl transition-all shadow-xs flex items-center gap-1.5">
                <i data-lucide="printer" class="w-4 h-4 text-red-400 shrink-0"></i>
                <span>Cetak Rekap</span>
            </button>
        </div>
    </div>

    <!-- 1. Stat Summary Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
        <!-- Total Alumni -->
        <div class="mas-card p-4 border-l-4 border-l-slate-900 flex items-center justify-between">
            <div>
                <p class="text-slate-400 text-[10px] font-bold uppercase tracking-wider">Total Alumni Lulus</p>
                <h3 class="text-xl sm:text-2xl font-black text-slate-900 font-mono mt-0.5">{{ $totalAlumni }}</h3>
                <p class="text-[10px] text-slate-500 mt-0.5">Talenta bersertifikat</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-900 flex items-center justify-center shrink-0">
                <i data-lucide="graduation-cap" class="w-5 h-5"></i>
            </div>
        </div>

        <!-- Bekerja di Industri -->
        <div class="mas-card p-4 border-l-4 border-l-emerald-600 flex items-center justify-between">
            <div>
                <p class="text-emerald-700 text-[10px] font-bold uppercase tracking-wider">Bekerja di Industri</p>
                <h3 class="text-xl sm:text-2xl font-black text-emerald-600 font-mono mt-0.5">{{ $workingCount }}</h3>
                <p class="text-[10px] text-slate-500 mt-0.5">Terserap dunia kerja</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <i data-lucide="briefcase" class="w-5 h-5"></i>
            </div>
        </div>

        <!-- Melanjutkan Kuliah -->
        <div class="mas-card p-4 border-l-4 border-l-blue-600 flex items-center justify-between">
            <div>
                <p class="text-blue-700 text-[10px] font-bold uppercase tracking-wider">Lanjut Kuliah</p>
                <h3 class="text-xl sm:text-2xl font-black text-blue-600 font-mono mt-0.5">{{ $collegeCount }}</h3>
                <p class="text-[10px] text-slate-500 mt-0.5">Pendidikan tinggi</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                <i data-lucide="book-open" class="w-5 h-5"></i>
            </div>
        </div>

        <!-- Wirausaha / Freelance -->
        <div class="mas-card p-4 border-l-4 border-l-purple-600 flex items-center justify-between">
            <div>
                <p class="text-purple-700 text-[10px] font-bold uppercase tracking-wider">Freelance / Usaha</p>
                <h3 class="text-xl sm:text-2xl font-black text-purple-600 font-mono mt-0.5">{{ $freelanceCount }}</h3>
                <p class="text-[10px] text-slate-500 mt-0.5">Karya independen</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                <i data-lucide="laptop" class="w-5 h-5"></i>
            </div>
        </div>
    </div>

    <!-- 2. Filter Navigation & Search Bar -->
    <div class="mas-card p-4 no-print">
        <form method="GET" action="{{ route('admin.alumni') }}" class="space-y-3">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
                <!-- Angkatan Pills -->
                <div class="flex items-center gap-1.5 overflow-x-auto pb-1 md:pb-0 scrollbar-none text-xs">
                    <a href="{{ route('admin.alumni', array_merge(request()->except('batch_id', 'page'))) }}" 
                       class="px-3 py-1.5 rounded-xl font-bold transition-all shrink-0 {{ empty($selectedBatchId) ? 'bg-red-600 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}">
                        Semua Angkatan ({{ $totalAlumni }})
                    </a>
                    @foreach($batches as $b)
                        @php
                            $batchAlumniCount = $b->users()->where('status', 'alumni')->count();
                        @endphp
                        <a href="{{ route('admin.alumni', array_merge(request()->except('page'), ['batch_id' => $b->id])) }}" 
                           class="px-3 py-1.5 rounded-xl font-bold transition-all shrink-0 flex items-center gap-1.5 {{ (string)$selectedBatchId === (string)$b->id ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}">
                            <span>{{ $b->batch_name }}</span>
                            <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ (string)$selectedBatchId === (string)$b->id ? 'bg-red-600 text-white' : 'bg-slate-100 text-slate-600' }}">
                                {{ $batchAlumniCount }}
                            </span>
                        </a>
                    @endforeach
                </div>

                <!-- Search Input & Career Filter -->
                <div class="flex items-center gap-2 w-full md:w-auto">
                    <div class="relative flex-1 md:w-56">
                        <i data-lucide="search" class="w-3.5 h-3.5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                        <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama alumni..." 
                               class="w-full pl-8 pr-3 py-1.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-medium">
                    </div>

                    <select name="career_status" onchange="this.form.submit()" class="px-3 py-1.5 text-xs bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-medium focus:outline-none focus:border-red-500">
                        <option value="">Semua Karir</option>
                        <option value="bekerja" {{ $careerStatus === 'bekerja' ? 'selected' : '' }}>💼 Bekerja</option>
                        <option value="kuliah" {{ $careerStatus === 'kuliah' ? 'selected' : '' }}>🎓 Kuliah</option>
                        <option value="wirausaha" {{ $careerStatus === 'wirausaha' ? 'selected' : '' }}>💻 Freelance / Usaha</option>
                        <option value="mencari_kerja" {{ $careerStatus === 'mencari_kerja' ? 'selected' : '' }}>🚀 Mencari Kerja</option>
                    </select>

                    <button type="submit" class="px-3 py-1.5 bg-slate-900 hover:bg-black text-white text-xs font-bold rounded-xl transition-all shrink-0">
                        Cari
                    </button>

                    @if($search || $selectedBatchId || $careerStatus)
                        <a href="{{ route('admin.alumni') }}" class="px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold rounded-xl transition-all shrink-0" title="Reset Filter">
                            <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- 3. Grid Direktori Alumni (Kotak Grid Lebar 5 Kolom Style TMS) -->
    @if($alumni->isEmpty())
        <!-- Empty State -->
        <div class="mas-card p-12 text-center space-y-4">
            <div class="w-16 h-16 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center mx-auto shadow-inner">
                <i data-lucide="graduation-cap" class="w-8 h-8"></i>
            </div>
            <div class="max-w-md mx-auto space-y-1">
                <h3 class="text-base font-black text-slate-900">Belum Ada Data Alumni</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    @if($search || $selectedBatchId || $careerStatus)
                        Tidak ditemukan alumni yang sesuai dengan filter pencarian. Silakan reset filter untuk melihat seluruh alumni.
                    @else
                        Saat ini belum ada siswa yang dialihkan menjadi Alumni Magang. Buka menu Data Siswa dan klik tombol aksi titik-tiga untuk meluluskan siswa menjadi alumni resmi.
                    @endif
                </p>
            </div>
            @if($search || $selectedBatchId || $careerStatus)
                <a href="{{ route('admin.alumni') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-slate-900 text-white text-xs font-bold hover:bg-black transition-all shadow-xs">
                    <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                    <span>Tampilkan Semua Alumni</span>
                </a>
            @else
                <a href="{{ route('admin.students') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-red-600 text-white text-xs font-bold hover:bg-red-700 transition-all shadow-md shadow-red-600/25">
                    <i data-lucide="users" class="w-3.5 h-3.5"></i>
                    <span>Buka Data Siswa</span>
                </a>
            @endif
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 sm:gap-5">
            @foreach($alumni as $item)
                @php
                    $initials = collect(explode(' ', $item->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->join('');
                    $profileUrl = route('profile.public', $item->account_id ?? $item->username ?? $item->id);
                @endphp
                <div class="mas-card p-5 flex flex-col items-center text-center relative group hover:border-red-500/40 hover:shadow-lg transition-all duration-300">
                    
                    <!-- Top Angkatan Badge -->
                    <div class="w-full flex items-center justify-between mb-3 text-[10px]">
                        <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-700 font-mono font-bold">
                            {{ $item->batch->batch_name ?? 'Angkatan 2026' }}
                        </span>
                        
                        <!-- Quick Career Edit Trigger -->
                        <button type="button" 
                                onclick="openCareerModal({{ $item->id }}, '{{ addslashes($item->name) }}', '{{ $item->alumni_status ?? 'bekerja' }}', '{{ addslashes($item->alumni_current_at ?? '') }}')"
                                class="text-slate-400 hover:text-red-600 transition-colors p-1 rounded-lg hover:bg-slate-100" 
                                title="Perbarui Status Karir Alumni">
                            <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                        </button>
                    </div>

                    <!-- Center Avatar (Lingkaran) -->
                    <a href="{{ $profileUrl }}" target="_blank" class="relative group/avatar cursor-pointer mb-3">
                        <div class="w-20 h-20 rounded-full bg-slate-900 border-2 border-slate-200 overflow-hidden shadow-sm flex items-center justify-center transition-transform duration-300 group-hover/avatar:scale-105 group-hover/avatar:border-red-500">
                            @if($item->avatar)
                                <img src="{{ $item->avatar }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-xl font-black text-white font-mono">{{ $initials }}</span>
                            @endif
                        </div>
                        
                        <!-- Graduation Badge Icon on Avatar -->
                        <div class="absolute bottom-0 right-0 w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center border-2 border-white shadow-xs" title="Lulusan Resmi PKL TMS">
                            <i data-lucide="check" class="w-3.5 h-3.5 stroke-[3]"></i>
                        </div>
                    </a>

                    <!-- Identity -->
                    <div class="w-full space-y-0.5 mb-2">
                        <a href="{{ $profileUrl }}" target="_blank" class="block font-black text-slate-900 text-sm tracking-tight hover:text-red-600 transition-colors truncate" title="{{ $item->name }}">
                            {{ $item->name }}
                        </a>
                        <p class="text-[11px] font-mono text-slate-400">
                            ID: <span class="text-slate-600 font-bold">{{ $item->account_id ?? $item->id }}</span> • {{ '@' . ($item->username ?? $item->account_id ?? $item->id) }}
                        </p>
                        <p class="text-[11px] text-slate-500 truncate" title="{{ $item->school_origin ?? 'SMKN 1 Ciamis' }}">
                            {{ $item->school_origin ?? 'SMKN 1 Ciamis' }}
                        </p>
                        <p class="text-[10px] text-slate-400 font-medium">
                            {{ $item->major ?? 'PPLG' }}
                        </p>
                    </div>

                    <!-- Career Status Badge -->
                    <div class="w-full my-2">
                        @if($item->alumni_status === 'bekerja')
                            <div class="px-2.5 py-1 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-200/80 text-[10px] font-bold flex items-center justify-center gap-1.5 truncate">
                                <i data-lucide="briefcase" class="w-3 h-3 text-emerald-600 shrink-0"></i>
                                <span class="truncate">{{ $item->alumni_current_at ? 'Bekerja @ ' . $item->alumni_current_at : 'Bekerja di Industri' }}</span>
                            </div>
                        @elseif($item->alumni_status === 'kuliah')
                            <div class="px-2.5 py-1 rounded-xl bg-blue-50 text-blue-800 border border-blue-200/80 text-[10px] font-bold flex items-center justify-center gap-1.5 truncate">
                                <i data-lucide="book-open" class="w-3 h-3 text-blue-600 shrink-0"></i>
                                <span class="truncate">{{ $item->alumni_current_at ? 'Kuliah @ ' . $item->alumni_current_at : 'Melanjutkan Kuliah' }}</span>
                            </div>
                        @elseif(in_array($item->alumni_status, ['wirausaha', 'freelance']))
                            <div class="px-2.5 py-1 rounded-xl bg-purple-50 text-purple-800 border border-purple-200/80 text-[10px] font-bold flex items-center justify-center gap-1.5 truncate">
                                <i data-lucide="laptop" class="w-3 h-3 text-purple-600 shrink-0"></i>
                                <span class="truncate">{{ $item->alumni_current_at ?: 'Freelance / Wirausaha' }}</span>
                            </div>
                        @elseif($item->alumni_status === 'mencari_kerja')
                            <div class="px-2.5 py-1 rounded-xl bg-amber-50 text-amber-800 border border-amber-200/80 text-[10px] font-bold flex items-center justify-center gap-1.5 truncate">
                                <i data-lucide="compass" class="w-3 h-3 text-amber-600 shrink-0"></i>
                                <span class="truncate">Mencari Peluang Karir</span>
                            </div>
                        @else
                            <div class="px-2.5 py-1 rounded-xl bg-slate-100 text-slate-700 text-[10px] font-bold flex items-center justify-center gap-1.5 truncate">
                                <i data-lucide="award" class="w-3 h-3 text-slate-500 shrink-0"></i>
                                <span class="truncate">Alumni Lulusan TMS</span>
                            </div>
                        @endif
                    </div>

                    <!-- Tech Stack / Skills (jika ada) -->
                    @if($item->skills)
                        <div class="flex items-center justify-center gap-1 flex-wrap my-1.5 w-full">
                            @foreach(array_slice(explode(',', $item->skills), 0, 3) as $skill)
                                <span class="px-1.5 py-0.5 rounded bg-slate-100 text-slate-600 text-[9px] font-mono">
                                    {{ trim($skill) }}
                                </span>
                            @endforeach
                        </div>
                    @endif

                    <!-- Bottom Card Action Button -->
                    <div class="mt-auto pt-3 w-full border-t border-slate-100 flex items-center gap-1.5">
                        <a href="{{ $profileUrl }}" target="_blank" class="w-full py-1.5 px-2 rounded-xl bg-slate-900 hover:bg-black text-white text-[11px] font-bold transition-all shadow-xs flex items-center justify-center gap-1.5">
                            <i data-lucide="external-link" class="w-3.5 h-3.5 text-red-400"></i>
                            <span>Buka Profil</span>
                        </a>
                    </div>

                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($alumni->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $alumni->links() }}
            </div>
        @endif
    @endif

</div>

<!-- ======================================================================= -->
<!-- MODAL UPDATE STATUS KARIR ALUMNI                                         -->
<!-- ======================================================================= -->
<div id="modal-alumni-career" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl border border-slate-200 overflow-hidden transform transition-all">
        <div class="p-6 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <i data-lucide="briefcase" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-slate-900">Perbarui Status Karir Alumni</h3>
                        <p id="career-modal-name" class="text-[11px] text-slate-500">Nama Siswa</p>
                    </div>
                </div>
                <button type="button" onclick="closeCareerModal()" class="w-8 h-8 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition-colors">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            <form id="form-alumni-career" method="POST" action="" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Status Aktivitas Saat Ini</label>
                    <select id="career-status-select" name="alumni_status" required class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-semibold focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                        <option value="bekerja">💼 Bekerja di Industri / Perusahaan</option>
                        <option value="kuliah">🎓 Melanjutkan Pendidikan / Kuliah</option>
                        <option value="wirausaha">💻 Wirausaha / Freelance Developer</option>
                        <option value="mencari_kerja">🚀 Fresh Graduate / Mencari Kerja</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Tempat Kerja / Kampus / Keterangan</label>
                    <input type="text" id="career-current-at" name="alumni_current_at" placeholder="Contoh: PT. Teknologi Multi Sistem / Univ. Siliwangi" 
                           class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-semibold focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    <p class="text-[10px] text-slate-400 mt-1">Nama kantor perusahaan, kampus universitas, atau fokus wirausaha siswa.</p>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                    <button type="button" onclick="closeCareerModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 rounded-xl text-xs font-bold bg-emerald-600 hover:bg-emerald-700 text-white transition-all shadow-md shadow-emerald-600/25 flex items-center gap-1.5">
                        <i data-lucide="save" class="w-3.5 h-3.5"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openCareerModal(userId, userName, currentStatus, currentAt) {
    const modal = document.getElementById('modal-alumni-career');
    const form = document.getElementById('form-alumni-career');
    const nameEl = document.getElementById('career-modal-name');
    const selectEl = document.getElementById('career-status-select');
    const atEl = document.getElementById('career-current-at');

    nameEl.textContent = userName;
    selectEl.value = currentStatus || 'bekerja';
    atEl.value = currentAt || '';
    form.action = `/admin/alumni/${userId}/career`;

    modal.classList.remove('hidden');
    modal.classList.add('flex');
    if (window.lucide) {
        window.lucide.createIcons();
    }
}

function closeCareerModal() {
    const modal = document.getElementById('modal-alumni-career');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function openExportModal() {
    const m = document.getElementById('modal-export-alumni');
    if (m) {
        m.classList.remove('hidden');
        m.classList.add('flex');
        if (window.lucide) { lucide.createIcons(); }
    }
}
function closeExportModal() {
    const m = document.getElementById('modal-export-alumni');
    if (m) {
        m.classList.add('hidden');
        m.classList.remove('flex');
    }
}

</script>

<!-- MODAL PILIH FORMAT EKSPOR ALUMNI (EXCEL / CSV) -->
<div id="modal-export-alumni" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl border border-slate-200 overflow-hidden transform transition-all animate-in fade-in zoom-in-95 duration-150">
        <!-- Modal Header -->
        <div class="p-6 pb-4 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center shrink-0">
                    <i data-lucide="file-spreadsheet" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-slate-900">Pilih Format Ekspor Alumni</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Pilih format berkas data direktori alumni yang diinginkan:</p>
                </div>
            </div>
            <button type="button" onclick="closeExportModal()" class="w-8 h-8 rounded-xl hover:bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition-colors">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <!-- Modal Body: Choices -->
        <div class="p-6 space-y-3">
            <!-- Option 1: Microsoft Excel (.xls) -->
            <a href="{{ route('admin.alumni.export', array_merge(request()->query(), ['format' => 'excel'])) }}" 
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
                        Format spreadsheet dengan rekam jejak karir, keahlian tech stack, warna header hijau TMS & kop resmi. Siap buka di MS Excel.
                    </p>
                </div>
                <i data-lucide="download" class="w-4 h-4 text-emerald-600 shrink-0 mt-1 opacity-60 group-hover:opacity-100 group-hover:translate-y-0.5 transition-all"></i>
            </a>

            <!-- Option 2: CSV Universal (.csv) -->
            <a href="{{ route('admin.alumni.export', array_merge(request()->query(), ['format' => 'csv'])) }}" 
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
                        Format teks data terpisah koma dengan UTF-8 BOM. Sangat cocok untuk Google Sheets, SQL database, atau sistem pelaporan.
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

@endsection
