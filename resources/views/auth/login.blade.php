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
            
            <!-- Quick 1-Click Role Access (For Easy Testing) -->
            <div class="bg-slate-50 p-3 rounded-xl border border-slate-200">
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2 text-center">
                    Akses Cepat Demo (1-Klik):
                </div>
                <div class="grid grid-cols-3 gap-1.5">
                    <a href="{{ route('login.quick', 'siswa') }}" class="py-1.5 text-center text-xs font-bold rounded-lg bg-red-600 text-white hover:bg-red-700 shadow-xs transition-colors">
                        Siswa
                    </a>
                    <a href="{{ route('login.quick', 'mentor') }}" class="py-1.5 text-center text-xs font-bold rounded-lg bg-slate-900 text-white hover:bg-black transition-colors">
                        Mentor
                    </a>
                    <a href="{{ route('login.quick', 'admin_tms') }}" class="py-1.5 text-center text-xs font-bold rounded-lg bg-white border border-slate-200 text-slate-700 hover:bg-slate-100 transition-colors">
                        Admin
                    </a>
                </div>
            </div>

            @if ($errors->any())
                <div class="p-3 rounded-xl bg-red-50 border border-red-200 text-red-600 text-xs font-medium">
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Main Form -->
            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Username / Email -->
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 mb-1.5">Email / NISN</label>
                    <div class="relative">
                        <i data-lucide="mail" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                        <input type="email" id="email" name="email" value="{{ old('email', 'pradipta@tms.co.id') }}" required
                               class="w-full pl-10 pr-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all"
                               placeholder="pradipta@tms.co.id">
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-bold text-slate-700">Kata Sandi</label>
                        <span class="text-[10px] text-slate-400 font-mono">Default: password</span>
                    </div>
                    <div class="relative">
                        <i data-lucide="lock" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                        <input type="password" id="password" name="password" value="password" required
                               class="w-full pl-10 pr-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all">
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" checked class="w-3.5 h-3.5 rounded border-slate-300 text-red-600 focus:ring-red-500">
                        <span class="text-xs text-slate-600">Ingat sesi saya</span>
                    </label>
                    <a href="{{ route('informasi') }}" class="text-xs text-red-600 hover:underline font-medium">Bantuan?</a>
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
    </script>
</body>
</html>
