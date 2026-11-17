<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk • SIMAK-TMS • PT. Teknologi Multi Sistem</title>
    
    <!-- Google Fonts: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f8fafc;
        }
        .mas-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1.25rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="min-h-screen bg-slate-50 flex items-center justify-center p-4 antialiased text-slate-800">

    <div class="w-full max-w-md">

        <!-- Logo & Header (Hitam - Putih - Merah TMS) -->
        <div class="text-center mb-6">
            <div class="w-14 h-14 mx-auto rounded-2xl bg-gradient-to-tr from-slate-900 via-slate-800 to-red-600 flex items-center justify-center text-white shadow-lg shadow-red-600/20 mb-3 border border-red-500/20">
                <i data-lucide="layers" class="w-7 h-7 text-white"></i>
            </div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900">SIMAK-TMS</h1>
            <p class="text-xs text-slate-500 mt-1">Sistem Informasi Manajemen Aktivitas & Karya Siswa PKL</p>
            <p class="text-[11px] font-bold text-red-600 uppercase tracking-wider mt-0.5">PT. Teknologi Multi Sistem</p>
        </div>

        <!-- Card Form Login -->
        <div class="mas-card p-6 sm:p-8 space-y-5">
            
            @if(session('success'))
                <div class="p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold flex items-center gap-2">
                    <i data-lucide="check-circle" class="w-4 h-4 text-emerald-500"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="p-3 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs font-semibold flex items-center gap-2">
                    <i data-lucide="alert-circle" class="w-4 h-4 text-amber-500"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if (isset($errors) && $errors->any())
                <div class="p-3 rounded-xl bg-red-50 border border-red-200 text-red-600 text-xs font-semibold">
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Main Form -->
            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Username / Email / 5-Digit ID -->
                <div>
                    <label for="login_id" class="block text-xs font-bold text-slate-700 mb-1.5">ID Pengguna (5-Digit) / Email Akun</label>
                    <div class="relative">
                        <i data-lucide="user" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                        <input type="text" id="login_id" name="login_id" value="{{ old('login_id') }}" required autofocus
                               class="w-full pl-10 pr-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 font-semibold focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-mono"
                               placeholder="Contoh: 19364 atau admin@tms.co.id">
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 mb-1.5">Kata Sandi</label>
                    <div class="relative">
                        <i data-lucide="lock" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                        <input type="password" id="password" name="password" required
                               class="w-full pl-10 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-mono"
                               placeholder="Masukkan kata sandi">
                        <button type="button" onclick="togglePasswordVisibility('password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-1 cursor-pointer transition-colors" title="Lihat/Sembunyikan Kata Sandi">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" name="remember" id="remember" value="1" checked class="w-3.5 h-3.5 rounded border-slate-300 text-red-600 focus:ring-red-500">
                        <span class="text-xs text-slate-600 font-medium">Ingat sesi saya</span>
                    </label>
                    <a href="{{ route('faq') }}" class="text-xs text-red-600 hover:text-red-700 hover:underline font-bold flex items-center gap-1.5" title="Buka Pusat Bantuan & Aturan Akun">
                        <i data-lucide="help-circle" class="w-3.5 h-3.5"></i>
                        <span>Bantuan</span>
                    </a>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-2.5 px-4 rounded-xl text-xs font-bold bg-red-600 hover:bg-red-700 active:scale-98 text-white shadow-md shadow-red-600/25 transition-all flex items-center justify-center gap-2">
                    <span>MASUK KE SISTEM TMS</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </button>
            </form>

        </div>

        <!-- Partnership Footer -->
        <div class="text-center mt-6 text-xs text-slate-400">
            <span>Kerjasama: <b class="text-slate-700">SMKN 1 Ciamis (PPLG)</b> &times; <b class="text-slate-700">PT. Teknologi Multi Sistem</b></span>
        </div>

    </div>

    <script>
        lucide.createIcons();

        function togglePasswordVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            if (!input) return;
            const isPass = input.type === 'password';
            input.type = isPass ? 'text' : 'password';
            btn.innerHTML = `<i data-lucide="${isPass ? 'eye-off' : 'eye'}" class="w-4 h-4"></i>`;
            lucide.createIcons();
        }
    </script>
</body>
</html>
