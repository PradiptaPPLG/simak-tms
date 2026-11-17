<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat Bantuan & FAQ Akses • SIMAK-TMS</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    },
                    colors: {
                        brand: {
                            red: '#ef4444',
                            darkred: '#b91c1c',
                            black: '#090d16',
                            white: '#ffffff',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased min-h-screen flex flex-col justify-between selection:bg-red-500 selection:text-white">

    <!-- Top Navigation Header -->
    <header class="bg-white/95 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-40">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <a href="{{ route('login') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-slate-900 to-black text-white flex items-center justify-center shadow-md shadow-slate-900/10 group-hover:scale-105 transition-transform">
                    <i data-lucide="layers" class="w-5 h-5 text-red-500"></i>
                </div>
                <div>
                    <div class="flex items-center gap-1.5">
                        <span class="font-black text-base tracking-tight text-slate-900">SIMAK-TMS</span>
                        <span class="text-[9px] font-black uppercase tracking-wider bg-red-100 text-red-700 px-1.5 py-0.2 rounded">PKL</span>
                    </div>
                    <p class="text-[10px] text-slate-400 font-semibold tracking-wide">PT. TEKNOLOGI MULTI SISTEM</p>
                </div>
            </a>

            <div class="flex items-center gap-2.5">
                @if(auth()->check())
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-slate-900 hover:bg-black text-white text-xs font-bold rounded-xl transition-all shadow-xs flex items-center gap-1.5">
                        <i data-lucide="layout-dashboard" class="w-3.5 h-3.5 text-red-400"></i>
                        <span>Buka Dashboard</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-red-600/20 flex items-center gap-1.5">
                        <i data-lucide="log-in" class="w-3.5 h-3.5"></i>
                        <span>Halaman Masuk (Login)</span>
                    </a>
                @endif
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 py-8 sm:py-12 flex-1 w-full space-y-8">
        
        <!-- Hero Title Section -->
        <div class="text-center space-y-3">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-50 border border-red-200 text-red-600 text-xs font-bold uppercase tracking-wider">
                <i data-lucide="shield-check" class="w-4 h-4 text-red-600"></i>
                <span>Panduan Akses & Keamanan Sistem</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">Pusat Bantuan & FAQ SIMAK-TMS</h1>
            <p class="text-sm text-slate-500 max-w-2xl mx-auto leading-relaxed">
                Informasi resmi mengenai aturan login menggunakan ID 5-digit, kata sandi universal default, penanganan kendala akses, dan dukungan teknis PT. Teknologi Multi Sistem.
            </p>
        </div>

        <!-- 3 Highlight Security Cards (ID 5-Digit, Universal Password, Reset Password) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            
            <!-- Card 1: ID 5-Digit Bukan Email -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs hover:border-red-300 transition-colors space-y-2">
                <div class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center">
                    <i data-lucide="user-check" class="w-5 h-5"></i>
                </div>
                <h3 class="text-sm font-black text-slate-900 tracking-tight">Login Menggunakan ID 5-Digit</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Siswa & Mentor masuk <b>HANYA menggunakan ID 5-Digit</b> (misal: <code class="font-mono bg-slate-100 px-1 py-0.5 rounded text-red-600 font-bold">20239</code>). <b>Dilarang memakai format email atau tanda @</b>.
                </p>
            </div>

            <!-- Card 2: Universal Password -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs hover:border-slate-400 transition-colors space-y-2">
                <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-900 flex items-center justify-center">
                    <i data-lucide="key" class="w-5 h-5"></i>
                </div>
                <h3 class="text-sm font-black text-slate-900 tracking-tight">Kata Sandi Default Universal</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Semua akun baru yang didaftarkan memiliki kata sandi default: <code class="font-mono bg-red-50 text-red-600 px-1.5 py-0.5 rounded font-bold">tmshebatsukses</code>. Wajib diperbarui saat login pertama.
                </p>
            </div>

            <!-- Card 3: Kendala & Reset Sandi -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs hover:border-amber-300 transition-colors space-y-2">
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center">
                    <i data-lucide="rotate-ccw" class="w-5 h-5"></i>
                </div>
                <h3 class="text-sm font-black text-slate-900 tracking-tight">Reset Sandi oleh Admin TMS</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Jika Anda lupa kata sandi yang telah diubah, Administrator TMS dapat mereset sandi Anda kembali ke default <code class="font-mono text-slate-700">tmshebatsukses</code>.
                </p>
            </div>

        </div>

        <!-- FAQ Accordion List -->
        <div class="space-y-4">
            <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                <h2 class="text-base font-black text-slate-900 tracking-tight flex items-center gap-2">
                    <i data-lucide="help-circle" class="w-5 h-5 text-red-600"></i>
                    <span>Tanya Jawab & Pemecahan Masalah (FAQ)</span>
                </h2>
                <span class="text-xs text-slate-400">Diperbarui November 2026</span>
            </div>

            <div class="space-y-3">
                
                <!-- FAQ 1 -->
                <details class="bg-white rounded-2xl border border-slate-200 p-5 group cursor-pointer shadow-xs open:border-red-300 transition-colors" open>
                    <summary class="flex items-center justify-between font-bold text-sm text-slate-900">
                        <span class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-red-50 text-red-600 flex items-center justify-center text-xs">1</span>
                            <span>Mengapa saya tidak bisa masuk (Login Gagal)?</span>
                        </span>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 group-open:rotate-180 transition-transform"></i>
                    </summary>
                    <div class="text-xs text-slate-600 leading-relaxed mt-3 pt-3 border-t border-slate-100 space-y-2">
                        <p>Berikut beberapa penyebab paling umum beserta solusinya:</p>
                        <ul class="list-disc pl-5 space-y-1.5 text-slate-700">
                            <li><b>Akun Belum Didaftarkan:</b> Jika ID tidak ditemukan, berarti Administrator PT. TMS belum membuat akun untuk Anda. Silakan hubungi Admin atau Mentor untuk pendaftaran.</li>
                            <li><b>Kata Sandi Sudah Pernah Diubah:</b> Jika kata sandi <code class="font-mono bg-slate-100 px-1 py-0.5 text-red-600 font-bold">tmshebatsukses</code> ditolak, kemungkinan Anda telah mengubah kata sandi pada akses pertama kali. Jika lupa, minta Admin TMS untuk melakukan <b>Reset Kata Sandi</b>.</li>
                            <li><b>Salah Format Username:</b> Pastikan Anda <b>tidak mengetikkan alamat email atau simbol @</b>. Masukkan hanya 5 digit angka ID Anda (contoh: <code class="font-mono">20239</code>).</li>
                        </ul>
                    </div>
                </details>

                <!-- FAQ 2 -->
                <details class="bg-white rounded-2xl border border-slate-200 p-5 group cursor-pointer shadow-xs open:border-red-300 transition-colors">
                    <summary class="flex items-center justify-between font-bold text-sm text-slate-900">
                        <span class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-red-50 text-red-600 flex items-center justify-center text-xs">2</span>
                            <span>Bagaimana cara kerja fitur "Ingat Sesi Saya"?</span>
                        </span>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 group-open:rotate-180 transition-transform"></i>
                    </summary>
                    <div class="text-xs text-slate-600 leading-relaxed mt-3 pt-3 border-t border-slate-100 space-y-2">
                        <p>Saat Anda mencentang opsi <b>"Ingat sesi saya"</b> di halaman masuk, sistem akan menyimpan token sesi aman pada peramban web perangkat pribadi Anda.</p>
                        <p>Dengan fitur ini, Anda tidak perlu mengetikkan ulang ID Pengguna dan kata sandi setiap kali menutup dan membuka kembali website SIMAK-TMS.</p>
                    </div>
                </details>

                <!-- FAQ 3 -->
                <details class="bg-white rounded-2xl border border-slate-200 p-5 group cursor-pointer shadow-xs open:border-red-300 transition-colors">
                    <summary class="flex items-center justify-between font-bold text-sm text-slate-900">
                        <span class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-red-50 text-red-600 flex items-center justify-center text-xs">3</span>
                            <span>Apa perbedaan pengisian jurnal di SIMAK-TMS dengan MAS-PKL?</span>
                        </span>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 group-open:rotate-180 transition-transform"></i>
                    </summary>
                    <div class="text-xs text-slate-600 leading-relaxed mt-3 pt-3 border-t border-slate-100 space-y-2">
                        <p><b>SIMAK-TMS</b> difokuskan murni pada <b>dokumentasi aktivitas industri nyata & portofolio koding</b> (pekerjaan fitur, deskripsi harian, commit Git). Seluruh atribut kurikulum akademik sekolah seperti <i>Capaian Pembelajaran (CP)</i>, <i>Tujuan Pembelajaran (TP)</i>, dan <i>Elemen Kompetensi</i> sudah dikelola secara terpisah di aplikasi <b>MAS-PKL</b>.</p>
                    </div>
                </details>

                <!-- FAQ 4 -->
                <details class="bg-white rounded-2xl border border-slate-200 p-5 group cursor-pointer shadow-xs open:border-red-300 transition-colors">
                    <summary class="flex items-center justify-between font-bold text-sm text-slate-900">
                        <span class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-red-50 text-red-600 flex items-center justify-center text-xs">4</span>
                            <span>Apa arti warna Merah dan Hijau pada kalender Jurnal PKL?</span>
                        </span>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 group-open:rotate-180 transition-transform"></i>
                    </summary>
                    <div class="text-xs text-slate-600 leading-relaxed mt-3 pt-3 border-t border-slate-100 space-y-2">
                        <p>Pada kalender bulanan interaktif:</p>
                        <ul class="list-disc pl-5 space-y-1">
                            <li><b class="text-red-600">Kotak Merah + Ikon Pensil:</b> Jurnal harian Anda telah tersimpan di sistem, namun pembimbing mentor industri belum menyisipkan catatan.</li>
                            <li><b class="text-emerald-700">Kotak Hijau + Ikon Pensil:</b> Mentor telah menyisipkan catatan bimbingan teknis. Ikon pensil tetap tersedia agar Anda dapat membaca arahan mentor sekaligus tetap bisa memperbarui catatan kegiatan jika diperlukan.</li>
                        </ul>
                    </div>
                </details>

            </div>
        </div>

        <!-- Contact Support Card PT. TMS -->
        <div class="bg-gradient-to-br from-slate-900 to-black rounded-3xl p-6 sm:p-8 text-white space-y-5 shadow-xl">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-800 pb-5">
                <div>
                    <span class="text-red-500 font-bold text-xs uppercase tracking-wider">Layanan Bantuan Pengguna</span>
                    <h3 class="text-xl font-black tracking-tight text-white mt-1">Butuh Bantuan Langsung dari Administrator?</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Hubungi tim administrator dan mentor industri PT. Teknologi Multi Sistem pada jam kerja.</p>
                </div>
                <a href="https://wa.me/6285219583336?text=Halo%20Admin%20TMS,%20saya%20memerlukan%20bantuan%20terkait%20akun%20SIMAK-TMS" target="_blank" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold text-xs rounded-xl transition-all shadow-lg shadow-red-600/30 flex items-center gap-2 self-start sm:self-auto cursor-pointer">
                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                    <span>Hubungi WhatsApp Admin</span>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs text-slate-300">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center text-red-400 shrink-0">
                        <i data-lucide="map-pin" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <div class="text-[10px] text-slate-500 font-bold uppercase">Lokasi Lab</div>
                        <div class="font-semibold text-white">Lab Software TMS</div>
                        <div class="text-[11px] text-slate-400">PT. Teknologi Multi Sistem</div>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center text-red-400 shrink-0">
                        <i data-lucide="clock" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <div class="text-[10px] text-slate-500 font-bold uppercase">Jam Kerja</div>
                        <div class="font-semibold text-white">08:00 – 17:00 WIB</div>
                        <div class="text-[11px] text-slate-400">Senin s/d Jumat</div>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center text-red-400 shrink-0">
                        <i data-lucide="phone" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <div class="text-[10px] text-slate-500 font-bold uppercase">Hotline WhatsApp</div>
                        <div class="font-semibold text-white font-mono">0852-1958-3336</div>
                        <div class="text-[11px] text-slate-400">Layanan Akun & Password</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back to Login Footer Link -->
        <div class="text-center pt-2">
            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 hover:text-red-600 transition-colors">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                <span>Kembali ke Halaman Masuk (Login) SIMAK-TMS</span>
            </a>
        </div>

    </main>

    <!-- Footer Copyright -->
    <footer class="border-t border-slate-200/80 bg-white py-4 text-center text-xs text-slate-400">
        &copy; {{ date('Y') }} PT. Teknologi Multi Sistem &bull; Kerjasama SMKN 1 Ciamis (PPLG)
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
