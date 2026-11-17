@extends('layouts.simak')

@section('title', 'Master Data Siswa Magang (Semua Batch) • Admin TMS')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-red-50 text-red-600 border border-red-200 text-[10px] font-bold uppercase tracking-wider mb-1">
                <span class="w-1.5 h-1.5 rounded-full bg-red-600 animate-pulse"></span>
                Master Data Lintas Angkatan & Periode PKL
            </div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900">Master Data Siswa Magang (Semua Batch)</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola data seluruh siswa magang lintas sekolah mitra, pembagian staff mentor pembimbing, serta rekapitulasi penugasan.</p>
        </div>

        <div class="flex items-center gap-2.5">
            <button onclick="document.getElementById('form-register-student').scrollIntoView({behavior: 'smooth'})" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-red-600/25 flex items-center gap-2">
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                <span>Daftarkan Siswa Baru</span>
            </button>
            <button onclick="window.print()" class="px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-xl transition-all shadow-xs flex items-center gap-2">
                <i data-lucide="printer" class="w-4 h-4 text-slate-500"></i>
                <span>Cetak Rekap</span>
            </button>
        </div>
    </div>

    <!-- 1. Quick Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="mas-card p-5 border-l-4 border-l-red-600 flex items-center justify-between">
            <div>
                <p class="text-slate-400 text-[11px] font-bold uppercase tracking-wider mb-1">Total Siswa Terdaftar</p>
                <h3 class="text-2xl font-black text-slate-900 font-mono">{{ $totalInterns }} <span class="text-xs font-normal text-slate-500">Peserta</span></h3>
            </div>
            <div class="w-11 h-11 bg-red-50 text-red-600 rounded-xl flex items-center justify-center">
                <i data-lucide="users" class="w-5 h-5"></i>
            </div>
        </div>

        <div class="mas-card p-5 border-l-4 border-l-slate-900 flex items-center justify-between">
            <div>
                <p class="text-slate-400 text-[11px] font-bold uppercase tracking-wider mb-1">Terhubung Pembimbing TMS</p>
                <h3 class="text-2xl font-black text-slate-900 font-mono">{{ $assignedInterns }} <span class="text-xs font-normal text-slate-500">Siswa</span></h3>
            </div>
            <div class="w-11 h-11 bg-slate-100 text-slate-900 rounded-xl flex items-center justify-center">
                <i data-lucide="user-check" class="w-5 h-5"></i>
            </div>
        </div>

        <div class="mas-card p-5 border-l-4 border-l-emerald-600 flex items-center justify-between">
            <div>
                <p class="text-slate-400 text-[11px] font-bold uppercase tracking-wider mb-1">Evaluasi & Nilai Rapor</p>
                <h3 class="text-2xl font-black text-slate-900 font-mono">{{ $evaluatedInterns }} <span class="text-xs font-normal text-slate-500">Ternilai</span></h3>
            </div>
            <div class="w-11 h-11 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
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
                        <option value="{{ $m->id }}" {{ request('mentor_id') == $m->id ? 'selected' : '' }}>{{ $m->name }} (Mentor)</option>
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
                                        <div class="font-bold text-slate-900">{{ $intern->name }}</div>
                                        <div class="text-[10px] text-slate-400 font-mono">&#64;{{ $intern->username ?? 'siswa' }} • {{ $intern->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-semibold text-slate-800">{{ $intern->school_origin ?? 'SMKN 1 Ciamis' }}</div>
                                <div class="text-[10px] text-slate-500">{{ $intern->major ?? 'PPLG' }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                @if($intern->mentor)
                                    <span class="font-medium text-slate-800">{{ $intern->mentor->name }}</span>
                                    <div class="text-[10px] text-red-600 font-semibold">{{ $intern->mentor->major ?? 'Pembimbing TMS' }}</div>
                                @else
                                    <span class="text-slate-400 italic">Belum di-assign</span>
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
                                <div class="flex items-center justify-end gap-1.5">
                                    <button onclick="openEditModal({{ $intern->id }}, '{{ addslashes($intern->name) }}', '{{ addslashes($intern->email) }}', '{{ addslashes($intern->school_origin ?? 'SMKN 1 Ciamis') }}', '{{ addslashes($intern->major ?? 'PPLG') }}', '{{ $intern->mentor_id }}')" class="px-2 py-1 rounded-lg bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 text-[11px] font-semibold transition-colors flex items-center gap-1 shadow-2xs">
                                        <i data-lucide="edit-2" class="w-3 h-3 text-slate-500"></i>
                                        <span>Edit</span>
                                    </button>
                                    <form action="{{ route('admin.students.destroy', $intern->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa {{ $intern->name }}? Tindakan ini permanen jika siswa dipulangkan atau pindah.');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2 py-1 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 text-[11px] font-bold transition-colors flex items-center gap-1 border border-red-200">
                                            <i data-lucide="trash-2" class="w-3 h-3"></i>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                    <a href="{{ route('profile') }}" class="px-2 py-1 rounded-lg bg-slate-900 hover:bg-black text-white text-[11px] font-semibold transition-colors flex items-center gap-1">
                                        <i data-lucide="user" class="w-3 h-3 text-red-400"></i>
                                        <span>Profil</span>
                                    </a>
                                    <a href="{{ route('evaluation.index') }}" class="px-2 py-1 rounded-lg bg-red-600 hover:bg-red-700 text-white text-[11px] font-bold transition-colors">
                                        Rapor
                                    </a>
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
        <div class="flex items-center gap-3 mb-4 pb-3 border-b border-slate-200">
            <div class="w-10 h-10 rounded-xl bg-red-600 text-white flex items-center justify-center shadow-md shadow-red-600/30">
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
                    <input type="text" name="name" required placeholder="Contoh: Alyzza Enggar" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-semibold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Email Akun *</label>
                    <input type="email" name="email" required placeholder="alyzza@smkn1ciamis.sch.id" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Password Default *</label>
                    <input type="text" name="password" required value="tms12345" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-mono font-bold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Asal Sekolah</label>
                    <input type="text" name="school_origin" value="SMKN 1 Ciamis" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Kompetensi Keahlian / Jurusan</label>
                    <input type="text" name="major" value="PPLG (Pengembangan Perangkat Lunak & Gim)" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Pilih Staff Mentor Pembimbing *</label>
                    <select name="mentor_id" required class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 font-semibold focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all">
                        <option value="">-- Pilih Mentor Pembimbing TMS --</option>
                        @foreach($mentors as $mentor)
                            <option value="{{ $mentor->id }}">{{ $mentor->name }} ({{ $mentor->major ?? 'Senior Software Engineer' }})</option>
                        @endforeach
                    </select>
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
                    <div class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center">
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
