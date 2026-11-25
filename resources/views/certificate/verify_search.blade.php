<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pencarian & Verifikasi Sertifikat PKL • PT. Teknologi Multi Sistem</title>
    
    <link rel="icon" type="image/png" href="{{ asset('images/logo/simak-icon-64.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo/simak-icon-128.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #090d16 0%, #0f172a 50%, #1e1b4b 100%);
            color: #0f172a;
            min-height: 100vh;
        }
        .glass-card {
            background: #ffffff;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
        }
    </style>
</head>
<body class="py-12 px-4 sm:px-6 flex items-center justify-center min-h-screen">

    <div class="max-w-xl w-full space-y-6">

        <!-- Header -->
        <div class="text-center space-y-2">
            <img src="{{ asset('images/logo/simak-icon.png') }}" alt="SIMAK Logo" class="w-16 h-16 mx-auto rounded-2xl mb-3 object-contain">
            <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">Verifikasi Sertifikat PKL PT. TMS</h1>
            <p class="text-xs text-slate-300">Masukkan nomor sertifikat atau ID peserta magang untuk memvalidasi keaslian dokumen kelulusan industri secara instan.</p>
        </div>

        <!-- Search Form Card -->
        <div class="glass-card p-6 sm:p-8 rounded-3xl border border-slate-100 space-y-6">
            <form action="{{ route('verify.index') }}" method="GET" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Nomor Sertifikat / ID Peserta / NIS:
                    </label>
                    <div class="relative">
                        <i data-lucide="qr-code" class="w-5 h-5 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2"></i>
                        <input 
                            type="text" 
                            name="q" 
                            required 
                            placeholder="Contoh: TMS-CERT-2026-20239 atau 20239" 
                            class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs sm:text-sm text-slate-900 font-mono font-semibold focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all placeholder:font-sans placeholder:font-normal">
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1.5">Anda dapat memasukkan format lengkap nomor sertifikat atau 5-digit ID peserta magang.</p>
                </div>

                <button type="submit" class="w-full py-3.5 px-5 rounded-2xl bg-red-600 hover:bg-red-700 text-white text-xs sm:text-sm font-bold transition-all shadow-md shadow-red-600/30 flex items-center justify-center gap-2">
                    <i data-lucide="search" class="w-4 h-4"></i>
                    <span>Cek & Validasi Sertifikat Sekarang</span>
                </button>
            </form>

            @if(isset($recentVerifications) && $recentVerifications->count() > 0)
                <div class="pt-4 border-t border-slate-100 space-y-2">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Contoh Sertifikat Terdaftar:</span>
                    <div class="space-y-1.5">
                        @foreach($recentVerifications as $rv)
                            <a href="{{ route('verify.show', $rv->certificate_number) }}" class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 hover:bg-red-50/50 border border-slate-100 hover:border-red-200 transition-colors text-xs group">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-lg bg-slate-900 text-white font-bold text-xs flex items-center justify-center">
                                        {{ substr($rv->user->name ?? 'PS', 0, 2) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-800 group-hover:text-red-600 transition-colors">{{ $rv->user->name ?? 'Peserta' }}</div>
                                        <div class="text-[10px] text-slate-400 font-mono">{{ $rv->certificate_number }}</div>
                                    </div>
                                </div>
                                <span class="text-[11px] font-mono font-bold text-red-600 group-hover:translate-x-0.5 transition-transform">Verifikasi &rarr;</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="pt-2 text-center border-t border-slate-100">
                <a href="{{ route('login') }}" class="text-xs font-semibold text-slate-500 hover:text-red-600 transition-colors">
                    &larr; Masuk ke SIMAK-TMS Dashboard
                </a>
            </div>
        </div>

        <div class="text-center text-xs text-slate-400">
            &copy; 2026 PT. Teknologi Multi Sistem &bull; Divisi Vokasi & Kemitraan Industri
        </div>

    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
