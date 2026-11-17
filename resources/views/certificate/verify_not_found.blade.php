<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sertifikat Tidak Ditemukan • PT. Teknologi Multi Sistem</title>
    
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
    </style>
</head>
<body class="py-12 px-4 sm:px-6 flex items-center justify-center min-h-screen">

    <div class="max-w-md w-full text-center space-y-6">

        <div class="w-16 h-16 rounded-2xl bg-amber-500/20 border border-amber-500/40 text-amber-400 flex items-center justify-center mx-auto">
            <i data-lucide="alert-triangle" class="w-8 h-8"></i>
        </div>

        <div class="space-y-2">
            <h1 class="text-2xl font-black text-white">Sertifikat Tidak Ditemukan</h1>
            <p class="text-xs text-slate-300">Nomor sertifikat atau ID <span class="font-mono text-amber-300 font-bold">"{{ $certificate_number }}"</span> tidak terdaftar dalam basis data resmi PT. Teknologi Multi Sistem.</p>
        </div>

        <div class="bg-white rounded-3xl p-6 text-left space-y-4 shadow-xl">
            <div class="text-xs text-slate-600 space-y-2">
                <p class="font-bold text-slate-800">Kemungkinan Penyebab:</p>
                <ul class="list-disc pl-5 space-y-1 text-slate-500">
                    <li>Salah memasukkan digit nomor sertifikat atau ID.</li>
                    <li>Sertifikat belum diterbitkan atau masih dalam proses evaluasi akhir mentor/admin.</li>
                    <li>Dokumen sertifikat bukan diterbitkan oleh PT. Teknologi Multi Sistem.</li>
                </ul>
            </div>

            <div class="pt-2 flex flex-col gap-2">
                <a href="{{ route('verify.index') }}" class="w-full py-3 px-4 rounded-xl bg-slate-900 hover:bg-black text-white text-xs font-bold transition-all text-center">
                    Cari Nomor Lain
                </a>
                <a href="{{ route('login') }}" class="w-full py-2.5 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-all text-center">
                    Kembali ke Beranda
                </a>
            </div>
        </div>

    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
