<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran PKL Online • PT. Teknologi Multi Sistem</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        tms: {
                            red: '#ef4444',
                            dark: '#0f172a',
                            light: '#f8fafc'
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace']
                    }
                }
            }
        }
    </script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .form-card {
            background: #ffffff;
            border-radius: 1.25rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
        }
    </style>
</head>
<body class="min-h-screen text-slate-800 flex flex-col justify-between antialiased selection:bg-red-500 selection:text-white">

    <!-- Top Navigation Header -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-xs">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <a href="{{ route('registry.index') }}" class="flex items-center gap-2.5 hover:opacity-90 transition-opacity">
                <div class="w-9 h-9 rounded-xl bg-slate-950 flex items-center justify-center font-extrabold text-white text-xs border border-red-500 shadow-xs">
                    TMS
                </div>
                <div>
                    <div class="font-extrabold text-slate-900 tracking-tight text-sm">PT. TEKNOLOGI MULTI SISTEM</div>
                    <div class="text-[10px] text-red-600 font-bold uppercase tracking-wider">Portal Registrasi PKL Online</div>
                </div>
            </a>
            
            <div class="flex items-center gap-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-3.5 py-1.5 rounded-xl bg-slate-900 hover:bg-black text-white text-xs font-bold transition-all shadow-xs flex items-center gap-1.5">
                        <i data-lucide="layout-dashboard" class="w-3.5 h-3.5 text-red-500"></i>
                        <span>Ke Dasbor SIMAK</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-3.5 py-1.5 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold transition-all">
                        Login SIMAK
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="max-w-3xl w-full mx-auto px-4 sm:px-6 py-8 sm:py-12 space-y-6 flex-1">

        <!-- Banner Header Form Google-Form Style -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-950 via-slate-900 to-black text-white p-6 sm:p-8 shadow-xl border border-slate-800">
            <div class="absolute -right-8 -top-8 w-44 h-44 rounded-full bg-red-600/20 blur-2xl pointer-events-none"></div>
            
            <div class="relative z-10 space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-600/30 text-red-400 border border-red-500/30 text-[10px] font-bold uppercase tracking-wider">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                    <span>Tahun Ajaran {{ $activeBatch->period_year ?? '2026' }} • {{ $activeBatch->batch_name ?? 'Angkatan 2026' }}</span>
                </div>
                <h1 class="text-xl sm:text-2xl font-black text-white tracking-tight">
                    Pendaftaran Praktik Kerja Lapangan (PKL)
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 max-w-xl leading-relaxed">
                    Formulir resmi registrasi calon siswa magang industri software house di <strong>PT. Teknologi Multi Sistem</strong>. Isi biodata secara mandiri dan simpan kode registrasi antrian Anda.
                </p>
            </div>
        </div>

        <!-- Success Flash Alert (Tampilkan Kode Antrian Jika Baru Submit) -->
        @if(session('registration_success'))
            @php $res = session('registration_success'); @endphp
            <div class="p-5 sm:p-6 rounded-2xl bg-emerald-50 border-2 border-emerald-300 text-emerald-950 space-y-3 shadow-md animate-in fade-in duration-300">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow-xs">
                        <i data-lucide="check-check" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-emerald-900">Pendaftaran Berhasil Dikirim ke Tim PT. TMS!</h3>
                        <p class="text-xs text-emerald-700">Terima kasih, <b>{{ $res['name'] }}</b>. Data registrasi Anda telah masuk ke antrian seleksi.</p>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-xl border border-emerald-200 space-y-2">
                    <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Kode ID Antrian Registrasi Anda:</div>
                    <div class="flex items-center gap-3">
                        <span id="code-box" class="font-mono text-xl sm:text-2xl font-black text-red-600 tracking-wider select-all">{{ $res['code'] }}</span>
                        <button type="button" onclick="copyCode('{{ $res['code'] }}')" class="px-3 py-1.5 rounded-lg bg-slate-900 hover:bg-black text-white text-xs font-bold transition-all flex items-center gap-1.5 cursor-pointer">
                            <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                            <span id="copy-btn-text">Salin Kode</span>
                        </button>
                    </div>
                    <p class="text-[11px] text-slate-500">
                        <strong>Penting:</strong> Simpan kode ini untuk mengecek status persetujuan pendaftaran Anda sewaktu-waktu di tab <b>Cek Status Pendaftaran</b>.
                    </p>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs space-y-1">
                <div class="font-bold flex items-center gap-1.5">
                    <i data-lucide="alert-circle" class="w-4 h-4 text-red-600"></i>
                    <span>Terdapat kesalahan pada isian formulir:</span>
                </div>
                <ul class="list-disc list-inside text-red-700 text-[11px] pl-1">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $isCheckTab = ($activeTab === 'check');
        @endphp

        <!-- Selection Switcher / Tabs: 1. Formulir Pendaftaran | 2. Cek Status Pendaftaran -->
        <div class="flex items-center gap-2 p-1.5 bg-slate-200/80 rounded-2xl">
            <button type="button" onclick="switchTab('register')" id="tab-btn-register" 
                    class="flex-1 py-2.5 px-4 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-2 cursor-pointer {{ !$isCheckTab ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                <i data-lucide="clipboard-edit" id="tab-icon-register" class="w-4 h-4 {{ !$isCheckTab ? 'text-red-600' : 'text-slate-500' }}"></i>
                <span>Formulir Pendaftaran PKL</span>
            </button>
            <button type="button" onclick="switchTab('check')" id="tab-btn-check" 
                    class="flex-1 py-2.5 px-4 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-2 cursor-pointer {{ $isCheckTab ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                <i data-lucide="search" id="tab-icon-check" class="w-4 h-4 {{ $isCheckTab ? 'text-red-600' : 'text-slate-500' }}"></i>
                <span>Cek Status Pendaftaran</span>
            </button>
        </div>

        <!-- ======================================================== -->
        <!-- TAB 1: FORMULIR PENDAFTARAN PKL                          -->
        <!-- ======================================================== -->
        <div id="tab-content-register" class="form-card p-6 sm:p-8 space-y-6 {{ $isCheckTab ? 'hidden' : '' }}">
            <div class="border-b border-slate-100 pb-3">
                <h2 class="text-base sm:text-lg font-black text-slate-900 tracking-tight">Biodata Calon Siswa Magang</h2>
                <p class="text-xs text-slate-500 mt-0.5">Lengkapi seluruh kolom identitas di bawah ini dengan data yang valid.</p>
            </div>

            <form action="{{ route('registry.store') }}" method="POST" class="space-y-4">
                @csrf

                <!-- 1. Nama Lengkap -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="full_name" value="{{ old('full_name') }}" required
                           placeholder="Contoh: Pradipta Endra Maulana"
                           class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-semibold">
                </div>

                <!-- 2. Jenis Kelamin & NIS (2 Kolom) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                        <select name="gender" required class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-semibold">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="Laki-laki" {{ old('gender') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('gender') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            Nomor Induk Siswa (NIS) <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nis" value="{{ old('nis') }}" required
                               placeholder="Contoh: 212210045"
                               class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-mono">
                    </div>
                </div>

                <!-- 3. Tempat Lahir & Tanggal Lahir (2 Kolom) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            Tempat Lahir
                        </label>
                        <input type="text" name="birth_place" value="{{ old('birth_place') }}"
                               placeholder="Contoh: Ciamis"
                               class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-medium">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            Tanggal Lahir
                        </label>
                        <input type="date" name="birth_date" value="{{ old('birth_date') }}"
                               class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-medium">
                    </div>
                </div>

                <!-- 4. Agama & Asal Sekolah (2 Kolom) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            Agama
                        </label>
                        <select name="religion" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-medium">
                            <option value="">-- Pilih Agama --</option>
                            <option value="Islam" {{ old('religion') === 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ old('religion') === 'Kristen' ? 'selected' : '' }}>Kristen Protestan</option>
                            <option value="Katolik" {{ old('religion') === 'Katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="Hindu" {{ old('religion') === 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ old('religion') === 'Buddha' ? 'selected' : '' }}>Buddha</option>
                            <option value="Khonghucu" {{ old('religion') === 'Khonghucu' ? 'selected' : '' }}>Khonghucu</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            Asal Sekolah Mitra
                        </label>
                        <input type="text" name="school_origin" value="{{ old('school_origin', 'SMKN 1 Ciamis') }}"
                               placeholder="Contoh: SMKN 1 Ciamis"
                               class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-semibold">
                    </div>
                </div>

                <!-- 5. Kompetensi Keahlian (Ketik Aja) -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">
                        Kompetensi Keahlian / Jurusan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="skill_competency" value="{{ old('skill_competency', 'PPLG (Pengembangan Perangkat Lunak & Gim)') }}" required
                           placeholder="Ketik keahlian Anda, contoh: PPLG / Rekayasa Perangkat Lunak, TKJ, dll"
                           class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-medium">
                </div>

                <!-- 6. Email Aktif & Nomor HP / WA (2 Kolom) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            Email Aktif <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               placeholder="nama@gmail.com"
                               class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 font-mono focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            Nomor Aktif (WhatsApp / Telepon) <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" name="phone_number" value="{{ old('phone_number') }}" required
                               placeholder="08xxxxxxxxxx"
                               class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 font-mono focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3">
                    <p class="text-[11px] text-slate-400">
                        Dengan menekan tombol kirim, Anda menyetujui data biodata disimpan untuk keperluan seleksi PKL PT. TMS.
                    </p>
                    <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-red-600 hover:bg-red-700 active:scale-98 text-white text-xs font-bold rounded-xl shadow-md shadow-red-600/30 transition-all flex items-center justify-center gap-2 cursor-pointer">
                        <i data-lucide="send" class="w-4 h-4"></i>
                        <span>Kirim Pendaftaran PKL</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- ======================================================== -->
        <!-- TAB 2: CEK STATUS PENDAFTARAN                            -->
        <!-- ======================================================== -->
        <div id="tab-content-check" class="form-card p-6 sm:p-8 space-y-6 {{ $isCheckTab ? '' : 'hidden' }}">
            <div class="border-b border-slate-100 pb-3">
                <h2 class="text-base sm:text-lg font-black text-slate-900 tracking-tight">Cek Status Antrian Pendaftaran</h2>
                <p class="text-xs text-slate-500 mt-0.5">Masukkan kode registrasi yang didapatkan saat Anda menyelesaikan pendaftaran.</p>
            </div>

            <!-- Search Box -->
            <form action="{{ route('registry.check') }}" method="GET" class="flex flex-col sm:flex-row gap-2.5">
                <input type="hidden" name="tab" value="check">
                <div class="relative flex-1">
                    <i data-lucide="ticket" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                    <input type="text" name="code" value="{{ $searchedCode ?? '' }}" required
                           placeholder="Contoh: TMS-REG-84920"
                           class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono uppercase font-bold text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all">
                </div>
                <button type="submit" class="px-5 py-2.5 bg-slate-950 hover:bg-black text-white text-xs font-bold rounded-xl transition-all shadow-xs flex items-center justify-center gap-2 cursor-pointer">
                    <i data-lucide="search" class="w-4 h-4"></i>
                    <span>Cek Status</span>
                </button>
            </form>

            <!-- Result Card -->
            @if(isset($searchResult) && $searchResult)
                <div class="p-5 sm:p-6 rounded-2xl border transition-all space-y-4
                     @if($searchResult->status === 'approved')
                         bg-emerald-50/70 border-emerald-300 text-emerald-950
                     @elseif($searchResult->status === 'rejected')
                         bg-red-50/70 border-red-300 text-red-950
                     @else
                         bg-amber-50/70 border-amber-300 text-amber-950
                     @endif">
                    
                    <!-- Header Status -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b pb-3.5
                         @if($searchResult->status === 'approved') border-emerald-200
                         @elseif($searchResult->status === 'rejected') border-red-200
                         @else border-amber-200 @endif">
                        
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-white shadow-xs
                                 @if($searchResult->status === 'approved') bg-emerald-600
                                 @elseif($searchResult->status === 'rejected') bg-red-600
                                 @else bg-amber-500 @endif">
                                @if($searchResult->status === 'approved')
                                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                                @elseif($searchResult->status === 'rejected')
                                    <i data-lucide="x-circle" class="w-5 h-5"></i>
                                @else
                                    <i data-lucide="clock" class="w-5 h-5"></i>
                                @endif
                            </div>
                            <div>
                                <div class="text-[10px] font-mono uppercase font-bold tracking-wider opacity-75">Status Pendaftaran</div>
                                <div class="text-base font-black">
                                    @if($searchResult->status === 'approved')
                                        Diterima & Disetujui PT. TMS
                                    @elseif($searchResult->status === 'rejected')
                                        Belum Dapat Diterima
                                    @else
                                        Sedang Ditinjau (Pending Review)
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="text-left sm:text-right">
                            <span class="font-mono text-xs font-bold px-2.5 py-1 rounded-lg bg-white/80 border shadow-2xs">
                                {{ $searchResult->registration_code }}
                            </span>
                        </div>
                    </div>

                    <!-- Explanatory Message -->
                    <div class="text-xs leading-relaxed bg-white/90 p-4 rounded-xl border
                         @if($searchResult->status === 'approved') border-emerald-100 text-slate-800
                         @elseif($searchResult->status === 'rejected') border-red-100 text-slate-800
                         @else border-amber-100 text-slate-800 @endif">
                        @if($searchResult->status === 'approved')
                            <p class="font-semibold text-emerald-800">
                                <strong>Selamat!</strong> Pendaftaran PKL Anda telah <b>disetujui oleh Administrator PT. Teknologi Multi Sistem</b>.
                            </p>
                            @if($searchResult->user && $searchResult->user->account_id)
                                <div class="mt-2 p-3.5 bg-emerald-100/80 rounded-xl border border-emerald-300 text-xs text-emerald-950 space-y-1.5">
                                    <div class="flex items-center justify-between">
                                        <span class="font-bold text-slate-700">ID Akun Resmi SIMAK:</span>
                                        <span class="font-mono text-sm font-black text-red-600 bg-white px-2.5 py-0.5 rounded-lg border border-red-300 shadow-2xs">{{ $searchResult->user->account_id }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="font-bold text-slate-700">Mentor Pembimbing:</span>
                                        <span class="font-semibold text-slate-900">{{ $searchResult->user->mentor->name ?? '-' }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="font-bold text-slate-700">Password Bawaan:</span>
                                        <code class="px-2 py-0.5 rounded bg-white font-mono text-[11px] text-slate-800 border border-slate-200">tmshebatsukses</code>
                                    </div>
                                    <div class="pt-2">
                                        <a href="{{ route('login') }}" class="w-full py-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl flex items-center justify-center gap-1.5 shadow-sm text-center">
                                            <i data-lucide="log-in" class="w-4 h-4"></i>
                                            <span>Masuk ke Dashboard Siswa</span>
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="mt-2 p-3 bg-amber-50 rounded-xl border border-amber-200 text-xs text-amber-900 space-y-1">
                                    <p class="font-bold flex items-center gap-1.5 text-amber-800">
                                        <i data-lucide="clock" class="w-4 h-4 text-amber-600"></i>
                                        Menunggu Penetapan Mentor Pembimbing
                                    </p>
                                    <p class="text-[11px] text-slate-600">
                                        Pendaftaran Anda telah diterima. Saat ini Administrator TMS sedang menentukan mentor pembimbing divisi Anda. Segera setelah mentor ditetapkan, ID Akun 5-digit resmi Anda akan aktif di sini.
                                    </p>
                                </div>
                            @endif
                        @elseif($searchResult->status === 'rejected')
                            <p class="font-semibold text-red-800">
                                <strong>Mohon Maaf.</strong> Pengajuan PKL Anda saat ini belum dapat diterima.
                            </p>
                            <p class="text-[11px] text-slate-600 mt-1">
                                Keterangan: <i>{{ $searchResult->rejection_reason ?? 'Kuota magang periode ini telah penuh.' }}</i>
                            </p>
                        @else
                            <p class="font-semibold text-amber-800">
                                <strong>Data Anda Sedang Dalam Antrian Peninjauan.</strong>
                            </p>
                            <p class="text-[11px] text-slate-600 mt-1">
                                Tim seleksi PT. TMS sedang memverifikasi biodata dan ketersediaan kuota. Silakan simpan kode ini dan periksa kembali secara berkala.
                            </p>
                        @endif
                    </div>

                    <!-- Summary Table -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-xs pt-1">
                        <div class="p-2.5 rounded-xl bg-white/80 border border-slate-200/60">
                            <div class="text-[10px] text-slate-400">Nama Siswa</div>
                            <div class="font-bold text-slate-800 truncate">{{ $searchResult->full_name }}</div>
                        </div>
                        <div class="p-2.5 rounded-xl bg-white/80 border border-slate-200/60">
                            <div class="text-[10px] text-slate-400">NIS</div>
                            <div class="font-bold text-slate-800 font-mono">{{ $searchResult->nis }}</div>
                        </div>
                        <div class="p-2.5 rounded-xl bg-white/80 border border-slate-200/60">
                            <div class="text-[10px] text-slate-400">Asal Sekolah</div>
                            <div class="font-bold text-slate-800 truncate">{{ $searchResult->school_origin }}</div>
                        </div>
                        <div class="p-2.5 rounded-xl bg-white/80 border border-slate-200/60">
                            <div class="text-[10px] text-slate-400">Tanggal Daftar</div>
                            <div class="font-bold text-slate-800">{{ $searchResult->created_at->format('d/m/Y') }}</div>
                        </div>
                    </div>
                </div>
            @elseif(isset($searchedCode) && $searchedCode)
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 text-center space-y-2">
                    <div class="w-10 h-10 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center mx-auto">
                        <i data-lucide="search-x" class="w-5 h-5"></i>
                    </div>
                    <div class="text-xs font-bold text-slate-700">Kode Registrasi Tidak Ditemukan</div>
                    <p class="text-[11px] text-slate-400 max-w-sm mx-auto">
                        Pastikan Anda memasukkan kode lengkap yang benar, contoh: <b>TMS-REG-84920</b>.
                    </p>
                </div>
            @endif
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-500">
        <div class="max-w-4xl mx-auto px-4">
            <p>&copy; {{ date('Y') }} PT. Teknologi Multi Sistem &bull; Divisi Talent & Software Engineering</p>
            <p class="text-[11px] text-slate-400 mt-1">Sistem Informasi Manajemen Aktivitas & Karya Siswa PKL (SIMAK-TMS)</p>
        </div>
    </footer>

    <script>
        function switchTab(tab) {
            const regContent = document.getElementById('tab-content-register');
            const checkContent = document.getElementById('tab-content-check');
            const regBtn = document.getElementById('tab-btn-register');
            const checkBtn = document.getElementById('tab-btn-check');
            const regIcon = document.getElementById('tab-icon-register');
            const checkIcon = document.getElementById('tab-icon-check');

            if (tab === 'register') {
                if (regContent) regContent.classList.remove('hidden');
                if (checkContent) checkContent.classList.add('hidden');
                
                if (regBtn) {
                    regBtn.className = 'flex-1 py-2.5 px-4 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-2 cursor-pointer bg-white text-slate-900 shadow-xs';
                }
                if (checkBtn) {
                    checkBtn.className = 'flex-1 py-2.5 px-4 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-2 cursor-pointer text-slate-600 hover:text-slate-900';
                }
                if (regIcon) {
                    regIcon.classList.remove('text-slate-500');
                    regIcon.classList.add('text-red-600');
                }
                if (checkIcon) {
                    checkIcon.classList.remove('text-red-600');
                    checkIcon.classList.add('text-slate-500');
                }
            } else {
                if (checkContent) checkContent.classList.remove('hidden');
                if (regContent) regContent.classList.add('hidden');
                
                if (checkBtn) {
                    checkBtn.className = 'flex-1 py-2.5 px-4 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-2 cursor-pointer bg-white text-slate-900 shadow-xs';
                }
                if (regBtn) {
                    regBtn.className = 'flex-1 py-2.5 px-4 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-2 cursor-pointer text-slate-600 hover:text-slate-900';
                }
                if (checkIcon) {
                    checkIcon.classList.remove('text-slate-500');
                    checkIcon.classList.add('text-red-600');
                }
                if (regIcon) {
                    regIcon.classList.remove('text-red-600');
                    regIcon.classList.add('text-slate-500');
                }
            }
            if (window.lucide) lucide.createIcons();
        }

        function copyCode(code) {
            navigator.clipboard.writeText(code).then(() => {
                const btnText = document.getElementById('copy-btn-text');
                if (btnText) {
                    btnText.innerText = 'Tersalin!';
                    setTimeout(() => { btnText.innerText = 'Salin Kode'; }, 2000);
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            if (window.lucide) lucide.createIcons();
        });
    </script>
</body>
</html>
