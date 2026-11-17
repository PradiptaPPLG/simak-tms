@extends('layouts.simak')

@section('title', 'Master Data Staff Mentor & Pembimbing • Admin TMS')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-red-50 text-red-600 border border-red-200 text-[10px] font-bold uppercase tracking-wider mb-1">
                <span class="w-1.5 h-1.5 rounded-full bg-red-600 animate-pulse"></span>
                Manajemen Staff & Pembimbing Industri PT. TMS
            </div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900">Master Data Staff Mentor & Pembimbing</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola data seluruh staff mentor teknis lab software, pembagian siswa bimbingan, kontak koordinasi, dan pendaftaran mentor baru.</p>
        </div>

        <div class="flex items-center gap-2.5">
            <button onclick="document.getElementById('form-register-mentor').scrollIntoView({behavior: 'smooth'})" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-red-600/25 flex items-center gap-2">
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                <span>Daftarkan Mentor Baru</span>
            </button>
            <button onclick="window.print()" class="px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-xl transition-all shadow-xs flex items-center gap-2">
                <i data-lucide="printer" class="w-4 h-4 text-slate-500"></i>
                <span>Cetak Rekap</span>
            </button>
        </div>
    </div>

    <!-- 1. Quick Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="mas-card p-5 border-l-4 border-l-slate-900 flex items-center justify-between">
            <div>
                <p class="text-slate-400 text-[11px] font-bold uppercase tracking-wider mb-1">Total Staff Mentor TMS</p>
                <h3 class="text-2xl font-black text-slate-900 font-mono">{{ $totalMentors }} <span class="text-xs font-normal text-slate-500">Staff Aktif</span></h3>
            </div>
            <div class="w-11 h-11 bg-slate-100 text-slate-900 rounded-xl flex items-center justify-center">
                <i data-lucide="user-check" class="w-5 h-5"></i>
            </div>
        </div>

        <div class="mas-card p-5 border-l-4 border-l-red-600 flex items-center justify-between">
            <div>
                <p class="text-slate-400 text-[11px] font-bold uppercase tracking-wider mb-1">Siswa Terhubung Bimbingan</p>
                <h3 class="text-2xl font-black text-slate-900 font-mono">{{ $assignedStudentsCount }} <span class="text-xs font-normal text-slate-500">Siswa Aktif</span></h3>
            </div>
            <div class="w-11 h-11 bg-red-50 text-red-600 rounded-xl flex items-center justify-center">
                <i data-lucide="users" class="w-5 h-5"></i>
            </div>
        </div>

        <div class="mas-card p-5 border-l-4 border-l-emerald-600 flex items-center justify-between">
            <div>
                <p class="text-slate-400 text-[11px] font-bold uppercase tracking-wider mb-1">Rasio Bimbingan Lab</p>
                <h3 class="text-2xl font-black text-slate-900 font-mono">1 : {{ $ratio }} <span class="text-xs font-normal text-slate-500">Siswa/Mentor</span></h3>
            </div>
            <div class="w-11 h-11 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
                <i data-lucide="git-pull-request" class="w-5 h-5"></i>
            </div>
        </div>
    </div>

    <!-- 2. Search & Filter Bar -->
    <div class="mas-card p-4">
        <form action="{{ route('admin.mentors') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
            <div class="relative flex-1 w-full">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama mentor, email, atau bidang keahlian (contoh: Backend, UI/UX, Cloud)..." class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-red-500 transition-colors">
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-slate-900 hover:bg-black text-white text-xs font-bold rounded-xl transition-all flex items-center justify-center gap-1.5 shadow-xs">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                    <span>Terapkan</span>
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.mentors') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl transition-colors">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- 3. Tabel Master Data Staff Mentor -->
    <div class="mas-card overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-slate-900 text-white flex items-center justify-center">
                    <i data-lucide="user-check" class="w-4 h-4"></i>
                </div>
                <div>
                    <h2 class="text-sm font-black text-slate-900">Daftar Staff Mentor & Pembimbing TMS ({{ $mentors->count() }})</h2>
                    <p class="text-[11px] text-slate-400">Seluruh mentor teknis lab software PT. Teknologi Multi Sistem yang berwenang membimbing siswa.</p>
                </div>
            </div>
            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-700 font-mono">
                Periode: 2026/2027
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                        <th class="py-3 px-4">Staff Mentor & Kontak</th>
                        <th class="py-3 px-4">Jabatan & Bidang Keahlian</th>
                        <th class="py-3 px-4">Siswa Bimbingan Aktif</th>
                        <th class="py-3 px-4">Penempatan Lab</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($mentors as $mentor)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <!-- Kolom 1: Avatar, Nama, Email, Kontak -->
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-slate-900 text-white font-bold flex items-center justify-center text-xs shrink-0 shadow-xs ring-2 ring-slate-100">
                                        {{ substr($mentor->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900 text-xs">{{ $mentor->name }} <span class="font-mono text-red-600 font-bold text-[11px]">({{ $mentor->account_id ?? $mentor->username ?? $mentor->id }})</span></div>
                                        <div class="text-[10px] text-slate-400 flex items-center gap-1.5 mt-0.5 font-mono">
                                            <span>ID: {{ $mentor->account_id ?? $mentor->username ?? $mentor->id }}</span>
                                            <span>•</span>
                                            <span>{{ $mentor->email }}</span>
                                        </div>
                                        @if($mentor->phone_number)
                                            <div class="text-[10px] text-slate-500 flex items-center gap-1 mt-0.5">
                                                <i data-lucide="phone" class="w-3 h-3 text-slate-400"></i>
                                                <span>{{ $mentor->phone_number }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Kolom 2: Jabatan & Bidang Keahlian -->
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-800 text-xs">{{ $mentor->major ?? $mentor->headline ?? 'Senior Software Engineer' }}</div>
                                <div class="text-[11px] text-slate-500 mt-0.5 line-clamp-1 max-w-xs">{{ $mentor->bio ?? 'Staff Mentor Pembimbing Industri PT. TMS' }}</div>
                            </td>

                            <!-- Kolom 3: Siswa Bimbingan Aktif -->
                            <td class="py-3.5 px-4">
                                <div class="space-y-1.5">
                                    <div class="flex items-center gap-1.5">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $mentor->students->count() > 0 ? 'bg-red-50 text-red-700 border border-red-200' : 'bg-slate-100 text-slate-500' }}">
                                            {{ $mentor->students->count() }} Siswa Bimbingan
                                        </span>
                                    </div>
                                    @if($mentor->students->count() > 0)
                                        <div class="flex flex-wrap gap-1 max-w-xs">
                                            @foreach($mentor->students as $student)
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-white border border-slate-200 text-[10px] font-semibold text-slate-700 shadow-2xs">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                                    {{ $student->name }} ({{ $student->account_id ?? $student->username ?? $student->id }})
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-[11px] text-slate-400 italic">Belum ada siswa yang dialokasikan</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Kolom 4: Penempatan Lab -->
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <div class="font-bold text-slate-700 text-xs flex items-center gap-1.5">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-red-500"></i>
                                    <span>{{ $mentor->location ?? 'Lab Software TMS' }}</span>
                                </div>
                                <div class="text-[10px] text-slate-400 mt-0.5">PT. Teknologi Multi Sistem</div>
                            </td>

                            <!-- Kolom 5: Status -->
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 font-bold text-[10px] whitespace-nowrap leading-none shadow-2xs">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Aktif Membimbing
                                </span>
                            </td>

                            <!-- Kolom 6: Aksi (Edit & Hapus) -->
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    <!-- Tombol Edit Mentor (Buka Modal) -->
                                    <button 
                                        type="button" 
                                        onclick="openEditMentorModal({{ json_encode([
                                            'id' => $mentor->id,
                                            'name' => $mentor->name,
                                            'email' => $mentor->email,
                                            'headline' => $mentor->major ?? $mentor->headline,
                                            'phone_number' => $mentor->phone_number,
                                            'bio' => $mentor->bio,
                                        ]) }})"
                                        class="px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-[11px] font-bold transition-colors inline-flex items-center gap-1"
                                        title="Edit Data Mentor">
                                        <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                        <span>Edit</span>
                                    </button>

                                    <!-- Tombol Hapus Mentor -->
                                    <form action="{{ route('admin.mentors.destroy', $mentor->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun mentor {{ $mentor->name }}? Seluruh alokasi siswa bimbingan mentor ini akan dilepaskan (unassigned).')">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit" 
                                            class="px-2.5 py-1.5 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white rounded-lg text-[11px] font-bold transition-colors inline-flex items-center gap-1 border border-red-200 hover:border-red-600"
                                            title="Hapus Akun Mentor">
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">
                                <i data-lucide="user-x" class="w-8 h-8 mx-auto text-slate-300 mb-2"></i>
                                <p class="text-xs font-semibold">Tidak ada staff mentor yang sesuai dengan filter pencarian.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- 4. Form Pendaftaran Akun Staff Mentor Baru -->
    <div id="form-register-mentor" class="mas-card p-6 sm:p-8 space-y-5">
        <div class="border-b border-slate-100 pb-4">
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-red-50 text-red-600 border border-red-200 text-[10px] font-bold uppercase tracking-wider mb-1">
                Hak Akses Khusus Admin TMS
            </div>
            <h2 class="text-lg font-black text-slate-900 tracking-tight flex items-center gap-2">
                <i data-lucide="user-plus" class="w-5 h-5 text-red-600"></i>
                <span>Form Pendaftaran Akun Staff Mentor Baru</span>
            </h2>
            <p class="text-xs text-slate-500 mt-0.5">Admin mendaftarkan akun staff mentor industri baru. ID Login 5-digit dibuat otomatis oleh sistem dan kata sandi universal default adalah <code class="font-mono text-red-600 font-bold bg-red-50 px-1.5 py-0.5 rounded">tmshebatsukses</code>.</p>
        </div>

        <form action="{{ route('admin.mentors.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Nama Lengkap Mentor -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap Mentor (dengan gelar) *</label>
                    <input type="text" name="name" required placeholder="Contoh: Farhan Ramadhan, S.Kom" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-semibold">
                </div>

                <!-- Email / Username (Opsional) -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Email / Username TMS (Opsional)</label>
                    <input type="text" name="email" placeholder="mentor@tms.co.id (otomatis jika kosong)" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-mono">
                    <p class="text-[10px] text-slate-400 mt-1">Boleh dikosongkan, sistem akan meng-generate otomatis.</p>
                </div>

                <!-- ID Login Otomatis -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">ID Login Akun</label>
                    <input type="text" value="[Auto-Generate 5-Digit]" readonly class="w-full px-3.5 py-2.5 bg-red-50/60 border border-red-200 rounded-xl text-xs text-red-700 font-mono font-bold select-none">
                    <p class="text-[10px] text-slate-400 mt-1">Diterbitkan otomatis sistem (contoh: 19364).</p>
                </div>

                <!-- Password Default Universal -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Password Default Universal</label>
                    <input type="text" value="tmshebatsukses" readonly class="w-full px-3.5 py-2.5 bg-slate-100 border border-slate-200 rounded-xl text-xs text-slate-700 font-mono font-bold select-none">
                    <p class="text-[10px] text-slate-400 mt-1">Mentor dapat mengganti password setelah login.</p>
                </div>

                <!-- Bidang Keahlian / Jabatan -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Bidang Keahlian / Jabatan Industri *</label>
                    <input type="text" name="headline" required placeholder="Contoh: Senior Software Engineer / Tech Lead" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-semibold">
                </div>

                <!-- Nomor WhatsApp -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Nomor Handphone / WhatsApp *</label>
                    <input type="text" name="phone_number" required placeholder="Contoh: 0852-1958-3336" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-mono">
                </div>

                <!-- Penempatan Lab -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Penempatan Lab / Instansi</label>
                    <input type="text" value="PT. Teknologi Multi Sistem (Lab Software TMS)" readonly class="w-full px-3.5 py-2.5 bg-slate-100 border border-slate-200 rounded-xl text-xs text-slate-500 font-semibold select-none">
                </div>
            </div>

            <!-- Bio Singkat -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Bio Singkat & Deskripsi Kompetensi Bimbingan</label>
                <textarea name="bio" rows="2" placeholder="Deskripsikan fokus teknologi yang dibimbing oleh mentor (contoh: RESTful API, Database, Docker, Clean Architecture, dll)..." class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all"></textarea>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-3">
                <button type="submit" class="px-5 py-2.5 bg-slate-900 hover:bg-black text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-slate-900/20 flex items-center gap-2">
                    <i data-lucide="check" class="w-4 h-4 text-emerald-400"></i>
                    <span>Simpan & Daftarkan Mentor Baru</span>
                </button>
            </div>
        </form>
    </div>

</div>

<!-- ================= MODAL EDIT DATA MENTOR ================= -->
<div id="modal-edit-mentor" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full shadow-2xl border border-slate-100 overflow-hidden transform transition-all">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-slate-900 text-white flex items-center justify-center">
                    <i data-lucide="user-check" class="w-4 h-4"></i>
                </div>
                <div>
                    <h3 class="text-sm font-black text-slate-900">Edit Data Staff Mentor</h3>
                    <p class="text-[10px] text-slate-500">Perbarui identitas, kontak, dan keahlian mentor industri.</p>
                </div>
            </div>
            <button type="button" onclick="closeEditMentorModal()" class="p-1 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-200 transition-colors">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <form id="form-edit-mentor" method="POST" class="p-5 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap Mentor (dengan gelar) *</label>
                <input type="text" id="edit-mentor-name" name="name" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 font-semibold focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Email Resmi TMS *</label>
                <input type="email" id="edit-mentor-email" name="email" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 font-mono focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Bidang Keahlian / Jabatan Industri *</label>
                <input type="text" id="edit-mentor-headline" name="headline" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 font-semibold focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Handphone / WhatsApp *</label>
                <input type="text" id="edit-mentor-phone" name="phone_number" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 font-mono focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Bio Singkat / Ringkasan Kompetensi</label>
                <textarea id="edit-mentor-bio" name="bio" rows="2" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500"></textarea>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeEditMentorModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-red-600/25">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditMentorModal(mentor) {
        const modal = document.getElementById('modal-edit-mentor');
        const form = document.getElementById('form-edit-mentor');
        
        form.action = "{{ url('/admin/mentor') }}/" + mentor.id;
        document.getElementById('edit-mentor-name').value = mentor.name || '';
        document.getElementById('edit-mentor-email').value = mentor.email || '';
        document.getElementById('edit-mentor-headline').value = mentor.headline || '';
        document.getElementById('edit-mentor-phone').value = mentor.phone_number || '';
        document.getElementById('edit-mentor-bio').value = mentor.bio || '';

        modal.classList.remove('hidden');
        lucide.createIcons();
    }

    function closeEditMentorModal() {
        document.getElementById('modal-edit-mentor').classList.add('hidden');
    }
</script>
@endsection
