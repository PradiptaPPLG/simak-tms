@extends('layouts.simak')

@section('title', 'Master Data Siswa Magang (Semua Batch) • Admin TMS')

@section('content')
<div class="space-y-6 min-w-0 max-w-full">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-red-50 text-red-600 border border-red-200 text-[10px] font-bold uppercase tracking-wider mb-1">
                <span class="w-1.5 h-1.5 rounded-full bg-red-600 animate-pulse shrink-0"></span>
                <span class="hidden sm:inline">Master Data Lintas Angkatan & Periode PKL</span>
                <span class="sm:hidden">Master Data Siswa Magang</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black tracking-tight text-slate-900">Master Data Siswa Magang (Semua Batch)</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola data seluruh siswa magang lintas sekolah mitra, pembagian staff mentor pembimbing, serta rekapitulasi penugasan.</p>
        </div>

        <div class="grid grid-cols-2 sm:flex sm:items-center gap-2 w-full sm:w-auto">
            <button onclick="document.getElementById('form-register-student').scrollIntoView({behavior: 'smooth'})" class="w-full sm:w-auto px-3.5 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-red-600/25 flex items-center justify-center gap-1.5 text-center">
                <i data-lucide="user-plus" class="w-4 h-4 shrink-0"></i>
                <span class="hidden sm:inline">Daftarkan Siswa Baru</span>
                <span class="sm:hidden">Daftar Siswa</span>
            </button>
            <button onclick="window.print()" class="w-full sm:w-auto px-3.5 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-xl transition-all shadow-xs flex items-center justify-center gap-1.5 text-center">
                <i data-lucide="printer" class="w-4 h-4 text-slate-500 shrink-0"></i>
                <span>Cetak Rekap</span>
            </button>
        </div>
    </div>

    <!-- 1. Quick Stats Cards (Compact 3-Cols on Mobile) -->
    <div class="grid grid-cols-3 gap-2 sm:gap-4">
        <div class="mas-card p-3 sm:p-5 border-l-2 sm:border-l-4 border-l-red-600 flex flex-col sm:flex-row sm:items-center justify-between gap-1">
            <div>
                <p class="text-slate-400 text-[10px] sm:text-[11px] font-bold uppercase tracking-wider mb-0.5 truncate">Total Siswa</p>
                <h3 class="text-lg sm:text-2xl font-black text-slate-900 font-mono">{{ $totalInterns }} <span class="text-[10px] sm:text-xs font-normal text-slate-500">Peserta</span></h3>
            </div>
            <div class="hidden sm:flex w-11 h-11 bg-red-50 text-red-600 rounded-xl items-center justify-center shrink-0">
                <i data-lucide="users" class="w-5 h-5"></i>
            </div>
        </div>

        <div class="mas-card p-3 sm:p-5 border-l-2 sm:border-l-4 border-l-slate-900 flex flex-col sm:flex-row sm:items-center justify-between gap-1">
            <div>
                <p class="text-slate-400 text-[10px] sm:text-[11px] font-bold uppercase tracking-wider mb-0.5 truncate">Ada Pembimbing</p>
                <h3 class="text-lg sm:text-2xl font-black text-slate-900 font-mono">{{ $assignedInterns }} <span class="text-[10px] sm:text-xs font-normal text-slate-500">Siswa</span></h3>
            </div>
            <div class="hidden sm:flex w-11 h-11 bg-slate-100 text-slate-900 rounded-xl items-center justify-center shrink-0">
                <i data-lucide="user-check" class="w-5 h-5"></i>
            </div>
        </div>

        <div class="mas-card p-3 sm:p-5 border-l-2 sm:border-l-4 border-l-emerald-600 flex flex-col sm:flex-row sm:items-center justify-between gap-1">
            <div>
                <p class="text-slate-400 text-[10px] sm:text-[11px] font-bold uppercase tracking-wider mb-0.5 truncate">Nilai Rapor</p>
                <h3 class="text-lg sm:text-2xl font-black text-slate-900 font-mono">{{ $evaluatedInterns }} <span class="text-[10px] sm:text-xs font-normal text-slate-500">Ternilai</span></h3>
            </div>
            <div class="hidden sm:flex w-11 h-11 bg-emerald-50 text-emerald-600 rounded-xl items-center justify-center shrink-0">
                <i data-lucide="award" class="w-5 h-5"></i>
            </div>
        </div>
    </div>

    <!-- 2. Filter & Search Bar -->
    <div class="mas-card p-4">
        <form method="GET" action="{{ route('admin.students') }}" class="flex flex-col md:flex-row gap-3 items-center justify-between">
            <div class="relative flex-1 w-full">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa, email, sekolah (contoh: SMKN 1 Ciamis), atau jurusan..." class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all">
            </div>

            <div class="flex items-center gap-2.5 w-full md:w-auto">
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

                @if(request('search') || request('mentor_id'))
                    <a href="{{ route('admin.students') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl transition-colors flex-shrink-0">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- 3. Tabel Data Siswa Lengkap -->
    <div class="mas-card p-6 space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div>
                <h2 class="text-base font-black text-slate-900 tracking-tight flex items-center gap-2">
                    <i data-lucide="users" class="w-5 h-5 text-red-600"></i>
                    <span>Daftar Siswa Magang Terdaftar ({{ $interns->count() }})</span>
                </h2>
                <p class="text-xs text-slate-400 mt-0.5">Seluruh data siswa aktif dan alumni magang di PT. Teknologi Multi Sistem.</p>
            </div>
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
                        <th class="py-3 px-4 text-right">Aksi</th>
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
                                @if($intern->evaluation)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-red-50 text-red-700 border border-red-200 font-bold font-mono text-[11px] whitespace-nowrap leading-none shadow-2xs">
                                        Nilai: {{ $intern->evaluation->final_score }} [A]
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 font-bold text-[10px] whitespace-nowrap leading-none shadow-2xs">
                                        ✓ Aktif Magang
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <!-- Menu Aksi Titik 3 (More Actions Dropdown) -->
                                <div class="relative inline-block text-left dropdown-container">
                                    <button type="button" onclick="toggleActionDropdown(this, event)" class="w-8 h-8 rounded-xl bg-white hover:bg-slate-100 text-slate-600 hover:text-slate-900 border border-slate-200 transition-colors shadow-2xs flex items-center justify-center cursor-pointer ml-auto" title="Opsi Aksi Siswa">
                                        <i data-lucide="more-vertical" class="w-4 h-4"></i>
                                    </button>
                                    <div class="action-dropdown hidden absolute right-0 mt-1.5 w-44 bg-white rounded-2xl shadow-xl border border-slate-100 py-1.5 z-40 divide-y divide-slate-100 text-left animate-in fade-in zoom-in-95 duration-100">
                                        <div class="py-1">
                                            @php
                                                $hasCert = !empty($intern->account_id) && !empty($intern->mentor_id) && !empty($intern->evaluation) && $intern->evaluation->is_published;
                                            @endphp

                                            @if(!empty($intern->account_id))
                                                <a href="{{ url('/profile/' . $intern->account_id) }}" target="_blank" class="flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
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
                                                    <button type="button" onclick="alert('Sertifikat kelulusan belum dapat dicetak karena siswa {{ addslashes($intern->name) }} masih aktif magang dan nilai akhir belum diterbitkan oleh mentor di menu Rapor & Nilai.')" class="w-full flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-slate-400 hover:bg-slate-50 transition-colors text-left cursor-not-allowed opacity-60" title="Evaluasi belum diterbitkan">
                                                        <i data-lucide="printer" class="w-3.5 h-3.5 text-slate-400"></i>
                                                        <span>Cetak Sertifikat</span>
                                                    </button>
                                                    <button type="button" onclick="alert('Verifikasi QR sertifikat belum tersedia karena siswa {{ addslashes($intern->name) }} masih aktif magang dan nilai kelulusan belum disahkan oleh mentor.')" class="w-full flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-slate-400 hover:bg-slate-50 transition-colors text-left cursor-not-allowed opacity-60" title="Evaluasi belum diterbitkan">
                                                        <i data-lucide="shield-check" class="w-3.5 h-3.5 text-slate-400"></i>
                                                        <span>Verifikasi QR</span>
                                                    </button>
                                                @endif
                                            @endif
                                            <a href="{{ route('evaluation.index') }}" class="flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                                                <i data-lucide="award" class="w-3.5 h-3.5 text-slate-400"></i>
                                                <span>Rapor & Nilai</span>
                                            </a>
                                        </div>
                                        <div class="py-1">
                                            <button type="button" onclick="openEditModal({{ $intern->id }}, '{{ addslashes($intern->name) }}', '{{ addslashes($intern->email) }}', '{{ addslashes($intern->school_origin ?? 'SMKN 1 Ciamis') }}', '{{ addslashes($intern->major ?? 'PPLG') }}', '{{ $intern->mentor_id }}')" class="w-full flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors text-left cursor-pointer">
                                                <i data-lucide="edit-2" class="w-3.5 h-3.5 text-slate-400"></i>
                                                <span>Edit Data</span>
                                            </button>
                                            <button type="button" onclick="openResetPasswordModal({{ $intern->id }}, '{{ addslashes($intern->name) }}', '{{ $intern->account_id ?? $intern->username ?? $intern->id }}', 'siswa')" class="w-full flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-amber-700 hover:bg-amber-50 transition-colors text-left cursor-pointer">
                                                <i data-lucide="rotate-ccw" class="w-3.5 h-3.5 text-amber-500"></i>
                                                <span>Reset Sandi</span>
                                            </button>
                                        </div>
                                        <div class="py-1">
                                            <form action="{{ route('admin.students.destroy', $intern->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa {{ $intern->name }}? Tindakan ini permanen jika siswa dipulangkan atau pindah.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-red-600 hover:bg-red-50 transition-colors text-left cursor-pointer">
                                                    <i data-lucide="trash-2" class="w-3.5 h-3.5 text-red-500"></i>
                                                    <span>Hapus Siswa</span>
                                                </button>
                                            </form>
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

    <!-- 4. Form Registrasi Akun Siswa Baru -->
    <div id="form-register-student" class="mas-card p-6 bg-gradient-to-br from-white to-slate-50 border-2 border-slate-200">
        <div class="flex items-start sm:items-center gap-3 mb-4 pb-3 border-b border-slate-200">
            <div class="w-10 h-10 rounded-xl bg-red-600 text-white flex items-center justify-center shadow-md shadow-red-600/30 shrink-0 aspect-square mt-0.5 sm:mt-0">
                <i data-lucide="user-plus" class="w-5 h-5"></i>
            </div>
            <div>
                <h3 class="text-base font-black text-slate-900 tracking-tight">Form Pendaftaran Akun Siswa Magang Baru</h3>
                <p class="text-xs text-slate-500">Admin mendaftarkan akun siswa baru dan langsung menghubungkannya ke Staff Mentor pembimbing.</p>
            </div>
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

    <script>
        function openEditModal(id, name, email, school, major, mentorId) {
            const modal = document.getElementById('modal-edit-student');
            const form = document.getElementById('form-edit-student');
            form.action = "{{ url('/admin/siswa') }}/" + id;
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-email').value = email;
            document.getElementById('edit-school').value = school;
            document.getElementById('edit-major').value = major;
            document.getElementById('edit-mentor-id').value = mentorId || '';
            modal.classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('modal-edit-student').classList.add('hidden');
        }
    </script>
</div>
@endsection
