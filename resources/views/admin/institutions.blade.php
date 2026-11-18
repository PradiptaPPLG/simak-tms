@extends('layouts.simak')

@section('title', 'Data Sekolah & Kampus Mitra • Admin TMS')

@section('content')
<div class="space-y-6 min-w-0 max-w-full">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-red-50 text-red-600 border border-red-200 text-[10px] font-bold uppercase tracking-wider mb-1">
                <span class="w-1.5 h-1.5 rounded-full bg-red-600 animate-pulse"></span>
                Kemitraan Vokasi & Relasi Jangka Panjang DUDI PT. TMS
            </div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900">Data Asal Instansi (Sekolah / Kampus)</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola direktori SMK dan Perguruan Tinggi mitra, kontak guru/dosen pembimbing, serta riwayat MoU kemitraan industri.</p>
        </div>

        <div class="flex items-center gap-2.5">
            <button onclick="openCreateInstModal()" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-red-600/25 flex items-center gap-2">
                <i data-lucide="building-2" class="w-4 h-4"></i>
                <span>Daftarkan Instansi Mitra Baru</span>
            </button>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="mas-card p-5 border-l-4 border-l-slate-900 flex items-center justify-between">
            <div>
                <p class="text-slate-400 text-[11px] font-bold uppercase tracking-wider mb-1">Total Instansi Mitra DUDI</p>
                <h3 class="text-2xl font-black text-slate-900 font-mono">{{ $totalInstitutions }} <span class="text-xs font-normal text-slate-500">Lembaga</span></h3>
            </div>
            <div class="w-11 h-11 bg-slate-100 text-slate-900 rounded-xl flex items-center justify-center">
                <i data-lucide="building" class="w-5 h-5"></i>
            </div>
        </div>

        <div class="mas-card p-5 border-l-4 border-l-red-600 flex items-center justify-between">
            <div>
                <p class="text-slate-400 text-[11px] font-bold uppercase tracking-wider mb-1">Sekolah Menengah Kejuruan (SMK)</p>
                <h3 class="text-2xl font-black text-slate-900 font-mono">{{ $smkCount }} <span class="text-xs font-normal text-slate-500">SMK Mitra</span></h3>
            </div>
            <div class="w-11 h-11 bg-red-50 text-red-600 rounded-xl flex items-center justify-center">
                <i data-lucide="graduation-cap" class="w-5 h-5"></i>
            </div>
        </div>

        <div class="mas-card p-5 border-l-4 border-l-emerald-600 flex items-center justify-between">
            <div>
                <p class="text-slate-400 text-[11px] font-bold uppercase tracking-wider mb-1">Perguruan Tinggi / Politeknik</p>
                <h3 class="text-2xl font-black text-slate-900 font-mono">{{ $campusCount }} <span class="text-xs font-normal text-slate-500">Kampus</span></h3>
            </div>
            <div class="w-11 h-11 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
                <i data-lucide="book-open" class="w-5 h-5"></i>
            </div>
        </div>
    </div>

    <!-- Table of Partner Institutions -->
    <div class="mas-card overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-slate-900 text-white flex items-center justify-center">
                    <i data-lucide="building-2" class="w-4 h-4"></i>
                </div>
                <div>
                    <h3 class="text-sm font-black text-slate-900">Direktori Sekolah & Kampus Mitra ({{ $institutions->count() }})</h3>
                    <p class="text-[11px] text-slate-400">Kerjasama formal Praktik Kerja Lapangan & Rekrutmen Talenta PT. TMS.</p>
                </div>
            </div>
            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-700 font-mono">
                DUDI Vokasi
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                        <th class="py-3 px-4">Nama Instansi & Wilayah</th>
                        <th class="py-3 px-4">Tingkat</th>
                        <th class="py-3 px-4">Kontak Guru / Dosen Pembimbing</th>
                        <th class="py-3 px-4">Nomor & Tanggal MoU</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($institutions as $inst)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-900 text-xs">{{ $inst->name }}</div>
                                <div class="text-[11px] text-slate-400 mt-0.5 flex items-center gap-1">
                                    <i data-lucide="map-pin" class="w-3 h-3 text-slate-400"></i>
                                    <span>{{ $inst->address ?? $inst->city }}</span>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="px-2 py-0.5 rounded-md font-bold text-[10px] {{ $inst->type === 'SMK' ? 'bg-red-50 text-red-700 border border-red-200' : 'bg-slate-100 text-slate-700' }}">
                                    {{ $inst->type }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-800">{{ $inst->pic_name ?? '-' }}</div>
                                <div class="text-[11px] text-slate-500 font-mono flex items-center gap-2 mt-0.5">
                                    @if($inst->pic_phone)
                                        <span class="flex items-center gap-1">
                                            <i data-lucide="phone" class="w-3 h-3 text-emerald-600"></i>
                                            <span>{{ $inst->pic_phone }}</span>
                                        </span>
                                    @endif
                                    @if($inst->pic_email)
                                        <span>• {{ $inst->pic_email }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3.5 px-4 font-mono text-[11px]">
                                <div class="font-bold text-slate-700">{{ $inst->mou_number ?? 'MoU-TMS-DUDI' }}</div>
                                <div class="text-[10px] text-slate-400">Tgl: {{ $inst->mou_date ? \Carbon\Carbon::parse($inst->mou_date)->translatedFormat('d M Y') : 'Aktif' }}</div>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 font-bold text-[10px]">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Kerjasama Aktif
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                <!-- Menu Aksi Titik 3 (More Action Dropdown) -->
                                <div class="relative inline-block text-left dropdown-container">
                                    <button type="button" onclick="toggleActionDropdown(this, event)" class="w-8 h-8 rounded-xl bg-white hover:bg-slate-100 text-slate-600 hover:text-slate-900 border border-slate-200 transition-colors shadow-2xs flex items-center justify-center cursor-pointer ml-auto" title="Opsi Aksi Instansi">
                                        <i data-lucide="more-vertical" class="w-4 h-4"></i>
                                    </button>
                                    <div class="action-dropdown hidden absolute right-0 mt-1.5 w-44 bg-white rounded-2xl shadow-xl border border-slate-100 py-1.5 z-40 divide-y divide-slate-100 text-left animate-in fade-in zoom-in-95 duration-100">
                                        <div class="py-1">
                                            <button type="button" 
                                                    onclick="openEditInstModal({{ json_encode($inst) }})" 
                                                    class="w-full flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors text-left cursor-pointer">
                                                <i data-lucide="edit-3" class="w-3.5 h-3.5 text-slate-400"></i>
                                                <span>Edit Instansi</span>
                                            </button>
                                        </div>
                                        <div class="py-1">
                                            <form action="{{ route('admin.institutions.destroy', $inst->id) }}" method="POST" onsubmit="return confirm('Hapus instansi {{ addslashes($inst->name) }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-red-600 hover:bg-red-50 transition-colors text-left cursor-pointer">
                                                    <i data-lucide="trash-2" class="w-3.5 h-3.5 text-red-500"></i>
                                                    <span>Hapus Instansi</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400 text-xs">
                                Belum ada instansi sekolah atau kampus mitra yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal Tambah / Edit Instansi Mitra -->
<div id="modal-inst" class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 space-y-4 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-xl bg-red-600 text-white flex items-center justify-center shrink-0 aspect-square">
                    <i data-lucide="building" class="w-4 h-4"></i>
                </div>
                <div>
                    <h3 id="modal-inst-title" class="text-sm font-black text-slate-900">Daftarkan Instansi Mitra Baru</h3>
                    <p class="text-[10px] text-slate-400">Kerjasama sekolah/kampus mitra dengan PT. TMS</p>
                </div>
            </div>
            <button onclick="closeInstModal()" class="text-slate-400 hover:text-slate-700">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="form-inst" method="POST" action="{{ route('admin.institutions.store') }}" class="space-y-3">
            @csrf
            <div id="inst-method-spoof"></div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Sekolah / Kampus *</label>
                <input type="text" id="inst-name" name="name" required placeholder="Contoh: SMKN 1 Ciamis / Universitas Galuh" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jenjang Pendidikan *</label>
                    <select id="inst-type" name="type" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                        <option value="SMK">SMK (Sekolah Menengah Kejuruan)</option>
                        <option value="Universitas">Universitas</option>
                        <option value="Politeknik">Politeknik / Vokasi D3/D4</option>
                        <option value="Institut">Institut</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Kota / Kabupaten *</label>
                    <input type="text" id="inst-city" name="city" required value="Ciamis" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Lengkap Instansi</label>
                <textarea id="inst-address" name="address" rows="2" placeholder="Jl. Jend. Soedirman No. 269..." class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500"></textarea>
            </div>

            <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 space-y-2.5">
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Kontak Guru / Dosen Pembimbing Sekolah:</div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap Pembimbing *</label>
                    <input type="text" id="inst-pic-name" name="pic_name" required placeholder="Contoh: Bpk. Dani Ramdhani, S.Kom." class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">No. WhatsApp / HP *</label>
                        <input type="text" id="inst-pic-phone" name="pic_phone" required placeholder="081223456789" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Email Resmi</label>
                        <input type="email" id="inst-pic-email" name="pic_email" placeholder="pplg@smkn1ciamis.sch.id" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nomor MoU Kerjasama</label>
                    <input type="text" id="inst-mou-num" name="mou_number" placeholder="MoU/TMS-SMKN1CMS/2026/014" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Mulai MoU</label>
                    <input type="date" id="inst-mou-date" name="mou_date" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                </div>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeInstModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl shadow-md shadow-red-600/25">
                    Simpan Instansi Mitra
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openCreateInstModal() {
        const modal = document.getElementById('modal-inst');
        const form = document.getElementById('form-inst');
        document.getElementById('modal-inst-title').innerText = 'Daftarkan Instansi Mitra Baru';
        form.action = "{{ route('admin.institutions.store') }}";
        document.getElementById('inst-method-spoof').innerHTML = '';

        document.getElementById('inst-name').value = '';
        document.getElementById('inst-type').value = 'SMK';
        document.getElementById('inst-city').value = 'Ciamis';
        document.getElementById('inst-address').value = '';
        document.getElementById('inst-pic-name').value = '';
        document.getElementById('inst-pic-phone').value = '';
        document.getElementById('inst-pic-email').value = '';
        document.getElementById('inst-mou-num').value = '';
        document.getElementById('inst-mou-date').value = '';

        modal.classList.remove('hidden');
    }

    function openEditInstModal(inst) {
        const modal = document.getElementById('modal-inst');
        const form = document.getElementById('form-inst');
        document.getElementById('modal-inst-title').innerText = 'Edit Instansi Mitra';
        form.action = "{{ url('/admin/instansi') }}/" + inst.id;
        document.getElementById('inst-method-spoof').innerHTML = '<input type="hidden" name="_method" value="PUT">';

        document.getElementById('inst-name').value = inst.name || '';
        document.getElementById('inst-type').value = inst.type || 'SMK';
        document.getElementById('inst-city').value = inst.city || 'Ciamis';
        document.getElementById('inst-address').value = inst.address || '';
        document.getElementById('inst-pic-name').value = inst.pic_name || '';
        document.getElementById('inst-pic-phone').value = inst.pic_phone || '';
        document.getElementById('inst-pic-email').value = inst.pic_email || '';
        document.getElementById('inst-mou-num').value = inst.mou_number || '';
        document.getElementById('inst-mou-date').value = inst.mou_date || '';

        modal.classList.remove('hidden');
    }

    function closeInstModal() {
        document.getElementById('modal-inst').classList.add('hidden');
    }
</script>
@endsection
