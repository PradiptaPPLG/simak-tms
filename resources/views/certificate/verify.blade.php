<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi Sertifikat Resmi • {{ $evaluation->certificate_number }} • PT. Teknologi Multi Sistem</title>
    
    <link rel="icon" type="image/png" href="{{ asset('images/logo/simak-icon-64.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo/simak-icon-128.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=Outfit:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;0,900;1,400&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', 'Outfit', sans-serif;
            background: radial-gradient(circle at 50% 0%, #1e1b4b 0%, #0f172a 50%, #090d16 100%);
            color: #0f172a;
            min-height: 100vh;
        }
        .verified-card {
            background: #ffffff;
            box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.08);
        }
    </style>
</head>
<body class="py-6 sm:py-10 px-3.5 sm:px-6 min-h-screen overflow-x-hidden">

    <div class="max-w-3xl w-full mx-auto space-y-5">

        <!-- Top Brand Header -->
        <div class="flex flex-col items-center text-center space-y-2.5 px-1">
            <div class="flex flex-col sm:flex-row items-center justify-center gap-2 sm:gap-3">
                <img src="{{ asset('images/logo/simak-icon.png') }}" alt="SIMAK-TMS" class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl object-contain shadow-md shrink-0">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-[11px] sm:text-xs font-semibold shadow-lg max-w-full">
                    <span class="w-2 h-2 sm:w-2.5 sm:h-2.5 rounded-full bg-emerald-400 animate-pulse shrink-0"></span>
                    <span class="truncate">Portal Verifikasi Publik Resmi SIMAK-TMS</span>
                </div>
            </div>
            <h1 class="text-lg sm:text-3xl font-black text-white tracking-tight">PT. TEKNOLOGI MULTI SISTEM</h1>
            <p class="text-[11px] sm:text-xs text-slate-300 leading-relaxed">Sistem Informasi Manajemen Aktivitas, Karya &amp; Sertifikasi Siswa Praktik Kerja Lapangan (PKL)</p>
        </div>

        <!-- Main Verified Card -->
        <div class="verified-card rounded-3xl overflow-hidden border border-slate-100">
            
            <!-- Green / Emerald Verification Ribbon -->
            <div class="bg-gradient-to-r from-emerald-600 via-emerald-500 to-teal-600 px-4 sm:px-6 py-4 text-white flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-md">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center shrink-0 border border-white/20">
                        <i data-lucide="shield-check" class="w-5 h-5 sm:w-6 sm:h-6 text-white"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="text-[10px] font-extrabold uppercase tracking-widest text-emerald-100">Status Dokumen Otentik</div>
                        <div class="text-sm sm:text-base font-black tracking-wide leading-snug">SERTIFIKAT RESMI TERVERIFIKASI DUDI</div>
                    </div>
                </div>
                <div class="sm:text-right font-mono text-xs bg-emerald-700/60 px-3.5 py-2 rounded-xl border border-emerald-400/40">
                    <div class="text-[9px] text-emerald-200 uppercase font-semibold">Nomor Sertifikat:</div>
                    <div class="font-bold tracking-wider">{{ $evaluation->certificate_number }}</div>
                </div>
            </div>

            <!-- Card Content Body -->
            <div class="p-6 sm:p-8 space-y-6">

                <!-- Student Identity Header -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-slate-900 to-slate-800 text-white font-black text-xl flex items-center justify-center shadow-lg shadow-slate-900/25 shrink-0 border border-slate-200 overflow-hidden">
                            @if($student->avatar)
                                <img src="{{ $student->avatar }}" alt="{{ $student->name }}" class="w-full h-full object-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <span style="display:none;" class="w-full h-full items-center justify-center">{{ substr($student->name, 0, 2) }}</span>
                            @else
                                {{ substr($student->name, 0, 2) }}
                            @endif
                        </div>
                        <div>
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 font-bold text-[10px] uppercase border border-emerald-200 mb-1">
                                <i data-lucide="check" class="w-3 h-3"></i> Peserta Lulus PKL
                            </div>
                            <h2 class="text-xl sm:text-2xl font-black text-slate-900 leading-tight">{{ $student->name }}</h2>
                            <div class="text-xs text-slate-500 font-mono mt-0.5">
                                NIS / ID: <b class="text-slate-800">{{ $student->nis_nim ?: ($student->account_id ?? '-') }}</b> • Akun: <b class="text-slate-800">{{ $student->account_id ?? '-' }}</b>
                            </div>
                        </div>
                    </div>

                    <!-- Final Score Badge -->
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 flex items-center gap-3 self-start sm:self-auto">
                        <div class="text-right">
                            <div class="text-[10px] font-bold text-slate-400 uppercase">Skor Evaluasi</div>
                            <div class="text-2xl font-black font-mono text-slate-900">{{ number_format($evaluation->final_score, 1) }}<span class="text-xs text-slate-400 font-normal">/100</span></div>
                        </div>
                        @php
                            $score = (float) $evaluation->final_score;
                            $gradeBadge = $score >= 85 ? 'bg-emerald-600' : ($score >= 75 ? 'bg-blue-600' : ($score >= 60 ? 'bg-amber-500' : 'bg-rose-600'));
                            $gradeLetter = $score >= 85 ? 'A' : ($score >= 75 ? 'B' : ($score >= 60 ? 'C' : 'D'));
                        @endphp
                        <div class="w-12 h-12 rounded-xl {{ $gradeBadge }} text-white font-black text-xl flex items-center justify-center shadow-md">
                            {{ $gradeLetter }}
                        </div>
                    </div>
                </div>

                <!-- 2-Column Metadata -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-1">
                        <span class="text-slate-400 text-[10px] font-bold uppercase tracking-wider">Asal Sekolah / Kampus Mitra</span>
                        <div class="font-bold text-slate-800 text-sm">{{ $student->school_origin }}</div>
                        <div class="text-slate-500 font-medium">Program / Jurusan: {{ $student->major }}</div>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-1">
                        <span class="text-slate-400 text-[10px] font-bold uppercase tracking-wider">Mentor Pembimbing Industri</span>
                        <div class="font-bold text-slate-800 text-sm">{{ $mentor->name ?? ($student->mentor->name ?? 'Staff Mentor TMS') }}</div>
                        <div class="text-slate-500 font-medium">Divisi Software Engineering @ PT. TMS</div>
                    </div>
                </div>

                <!-- 4 Pilar Kompetensi Industri -->
                <div class="space-y-2">
                    <span class="text-slate-400 text-[10px] font-bold uppercase tracking-wider">Rekapitulasi 4 Pilar Nilai Kompetensi DUDI</span>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 text-center">
                            <span class="text-slate-400 text-[10px] font-bold uppercase">1. Teknis</span>
                            <div class="text-lg font-black font-mono text-slate-900 mt-0.5">{{ $evaluation->technical_skill }}</div>
                            <span class="text-[9px] text-slate-500">Hard Skills</span>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 text-center">
                            <span class="text-slate-400 text-[10px] font-bold uppercase">2. Disiplin</span>
                            <div class="text-lg font-black font-mono text-slate-900 mt-0.5">{{ $evaluation->discipline }}</div>
                            <span class="text-[9px] text-slate-500">Presensi & POS</span>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 text-center">
                            <span class="text-slate-400 text-[10px] font-bold uppercase">3. Teamwork</span>
                            <div class="text-lg font-black font-mono text-slate-900 mt-0.5">{{ $evaluation->teamwork }}</div>
                            <span class="text-[9px] text-slate-500">Kolaborasi</span>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 text-center">
                            <span class="text-slate-400 text-[10px] font-bold uppercase">4. Inisiatif</span>
                            <div class="text-lg font-black font-mono text-slate-900 mt-0.5">{{ $evaluation->initiative }}</div>
                            <span class="text-[9px] text-slate-500">Problem Solving</span>
                        </div>
                    </div>
                </div>

                @if($evaluation->general_notes)
                    <div class="p-4 rounded-2xl bg-amber-50/70 border border-amber-200/80 text-amber-950 text-xs space-y-1">
                        <span class="font-bold text-[10px] uppercase tracking-wider text-amber-700 flex items-center gap-1.5">
                            <i data-lucide="message-square-quote" class="w-3.5 h-3.5"></i>
                            <span>Catatan Evaluasi Pembimbing Industri:</span>
                        </span>
                        <p class="font-medium pl-5 leading-relaxed">"{{ $evaluation->general_notes }}"</p>
                    </div>
                @endif

                <!-- Action Button Print / View Certificate -->
                <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex items-center gap-2 text-xs text-slate-500">
                        <i data-lucide="calendar" class="w-4 h-4 text-slate-400"></i>
                        <span>Diterbitkan: <b>{{ \Carbon\Carbon::parse($evaluation->issue_date ?? now())->translatedFormat('d F Y') }}</b></span>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('certificate.print', $evaluation->certificate_number) }}" target="_blank" class="px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-black text-white text-xs font-bold transition-all shadow-md flex items-center justify-center gap-2">
                            <i data-lucide="printer" class="w-4 h-4 text-amber-400"></i>
                            <span>Buka E-Sertifikat Cetak (PDF)</span>
                        </a>
                    </div>
                </div>

            </div>

        </div>

        <div class="text-center text-[11px] text-slate-400">
            &copy; {{ date('Y') }} PT. Teknologi Multi Sistem &bull; SIMAK-TMS Verifikasi Otentik DUDI
        </div>

    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>