<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Sertifikat PKL • {{ $student->name }} • {{ $evaluation->certificate_number }}</title>
    
    <link rel="icon" type="image/png" href="{{ asset('images/logo/simak-icon-64.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=Outfit:wght@300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,600;0,700;0,900;1,400;1,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Great+Vibes&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', 'Outfit', sans-serif;
            background-color: #0b0f19;
            color: #0f172a;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .font-cinzel {
            font-family: 'Cinzel', serif;
        }

        .font-playfair {
            font-family: 'Playfair Display', serif;
        }

        .font-script {
            font-family: 'Great Vibes', cursive;
        }

        /* Standar A4 Landscape Presisi: 297mm x 210mm (~1.414 ratio) */
        .cert-canvas {
            width: 1060px;
            height: 750px;
            background: #ffffff;
            position: relative;
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.7);
            overflow: hidden;
        }

        /* Subtle Security Guilloche Pattern */
        .guilloche-bg {
            background-color: #ffffff;
            background-image: 
                radial-gradient(circle at 50% 50%, rgba(220, 38, 38, 0.02) 0%, transparent 60%),
                radial-gradient(circle at 20% 20%, rgba(217, 119, 6, 0.025) 0%, transparent 40%),
                radial-gradient(circle at 80% 80%, rgba(15, 23, 42, 0.02) 0%, transparent 40%),
                linear-gradient(135deg, rgba(248, 250, 252, 0.6) 25%, transparent 25%),
                linear-gradient(225deg, rgba(248, 250, 252, 0.6) 25%, transparent 25%);
            background-size: 100% 100%, 100% 100%, 100% 100%, 40px 40px, 40px 40px;
        }

        /* Corner Geometric Accent Shapes */
        .corner-geo-tl {
            position: absolute;
            top: 0;
            left: 0;
            width: 180px;
            height: 180px;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 45%, #b91c1c 46%, #dc2626 50%, #d97706 52%, transparent 53%);
            pointer-events: none;
            z-index: 1;
        }

        .corner-geo-br {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 180px;
            height: 180px;
            background: linear-gradient(315deg, #0f172a 0%, #1e293b 45%, #b91c1c 46%, #dc2626 50%, #d97706 52%, transparent 53%);
            pointer-events: none;
            z-index: 1;
        }

        /* Golden Ribbon / Seal Badge */
        .gold-seal {
            background: radial-gradient(circle, #fde047 0%, #eab308 50%, #ca8a04 80%, #a16207 100%);
            box-shadow: 0 4px 14px rgba(161, 98, 7, 0.35), inset 0 2px 4px rgba(255, 255, 255, 0.6);
        }

        @media print {
            body {
                background: none !important;
                padding: 0 !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
            }
            .no-print {
                display: none !important;
            }
            .cert-canvas {
                box-shadow: none !important;
                margin: 0 !important;
                width: 100vw !important;
                height: 100vh !important;
                border-radius: 0 !important;
                page-break-inside: avoid;
            }
            @page {
                size: A4 landscape;
                margin: 0;
            }
        }
    </style>
</head>
<body class="py-8 px-4 flex flex-col items-center justify-center min-h-screen">

    <!-- Top Action Floating Bar (Disembunyikan saat Print) -->
    <div class="no-print fixed top-5 z-50 flex items-center gap-3 bg-slate-900/90 backdrop-blur-md px-5 py-2.5 rounded-full border border-slate-700/80 shadow-2xl text-white">
        <div class="flex items-center gap-2 pr-3 border-r border-slate-700 text-xs font-semibold">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
            <span>E-Sertifikat Industri TMS • Validasi Publik Resmi</span>
        </div>
        <button onclick="window.print()" class="px-4 py-1.5 rounded-full bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white text-xs font-bold transition-all shadow-md shadow-red-600/30 flex items-center gap-1.5 cursor-pointer">
            <i data-lucide="printer" class="w-3.5 h-3.5"></i>
            <span>Cetak / Simpan PDF</span>
        </button>
        <a href="{{ url()->previous() ?: route('profile') }}" class="px-3.5 py-1.5 rounded-full bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold transition-colors flex items-center gap-1">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            <span>Kembali</span>
        </a>
    </div>

    <!-- ============================================================== -->
    <!-- CERTIFICATE A4 CANVAS (LANDSCAPE MODERN & LUXURY)               -->
    <!-- ============================================================== -->
    <div class="cert-canvas rounded-3xl p-8 sm:p-9 flex flex-col justify-between relative my-6 guilloche-bg">

        <!-- Modern Geometric Corner Polygons -->
        <div class="corner-geo-tl"></div>
        <div class="corner-geo-br"></div>

        <!-- Luxury Multi-layer Borders -->
        <div class="absolute inset-4 rounded-2xl border-2 border-slate-900/90 pointer-events-none z-10"></div>
        <div class="absolute inset-5 rounded-xl border border-amber-500/60 pointer-events-none z-10"></div>
        <div class="absolute inset-6 rounded-lg border border-dashed border-slate-300/80 pointer-events-none z-10"></div>

        <!-- Subtle Watermark Logo Center -->
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-[0.035] select-none z-0">
            <img src="{{ asset('images/logo/logo_tms.png') }}" alt="Watermark TMS" class="w-[480px] h-[480px] object-contain grayscale">
        </div>

        <!-- ============================================================== -->
        <!-- 1. HEADER SECTION (KOP INDUSTRI & TITLE)                       -->
        <!-- ============================================================== -->
        <div class="relative z-20 pt-1 px-8">
            <div class="flex items-center justify-between">
                
                <!-- Brand Logo & Identity -->
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo/logo_tms.png') }}" alt="Logo PT. Teknologi Multi Sistem" class="w-12 h-12 object-contain shrink-0">
                    <div>
                        <div class="font-cinzel font-black text-slate-950 text-base tracking-[0.18em] leading-none">
                            PT. TEKNOLOGI MULTI SISTEM
                        </div>
                        <div class="text-[9px] uppercase tracking-[0.2em] text-slate-500 font-bold mt-1 flex items-center gap-1.5">
                            <span>Software House</span>
                            <span class="w-1 h-1 rounded-full bg-red-500"></span>
                            <span>Digital Solution Partner</span>
                            <span class="w-1 h-1 rounded-full bg-amber-500"></span>
                            <span>Ciamis, ID</span>
                        </div>
                    </div>
                </div>

                <!-- Gold Excellence Seal Badge -->
                <div class="flex items-center gap-2.5">
                    <div class="w-11 h-11 rounded-full gold-seal flex items-center justify-center text-slate-950 shadow-md shrink-0 border border-amber-300">
                        <i data-lucide="shield-check" class="w-6 h-6 text-amber-950"></i>
                    </div>
                    <div class="text-right">
                        <div class="text-[9px] font-extrabold uppercase tracking-widest text-amber-800 leading-tight">DUDI VERIFIED</div>
                        <div class="text-[8px] font-mono text-slate-400 tracking-wider">ISO-ALIGNED PKL</div>
                    </div>
                </div>
            </div>

            <!-- Title & Certificate Number Ribbon -->
            <div class="text-center mt-3">
                <div class="inline-block relative">
                    <h1 class="font-cinzel text-2xl sm:text-[28px] font-black text-slate-950 tracking-[0.15em] uppercase leading-tight">
                        SERTIFIKAT PRAKTIK KERJA LAPANGAN
                    </h1>
                    <div class="w-32 h-1 bg-gradient-to-r from-red-600 via-amber-500 to-red-600 mx-auto mt-1 rounded-full"></div>
                </div>
                <div class="text-[10px] uppercase tracking-[0.25em] text-slate-500 font-semibold italic mt-1">
                    Certificate of Industrial Internship & Professional Competency
                </div>
                <div class="mt-2 inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-900 text-white text-[10px] font-mono font-bold shadow-xs">
                    <span class="text-amber-400">NO:</span>
                    <span>{{ $evaluation->certificate_number }}</span>
                </div>
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- 2. BODY SECTION (PENERIMA & PERNYATAAN KELULUSAN)              -->
        <!-- ============================================================== -->
        <div class="text-center relative z-20 px-12 py-1 space-y-2">
            <p class="text-[11px] uppercase tracking-[0.22em] text-slate-400 font-bold">
                Diberikan Dengan Bangga Kepada:
            </p>

            <!-- Recipient Name in Luxury Serif Typography -->
            <div class="relative py-1">
                <h2 class="font-playfair text-3xl sm:text-[38px] font-black text-slate-950 tracking-tight leading-tight">
                    {{ $student->name }}
                </h2>
                <div class="text-xs text-slate-600 font-semibold flex items-center justify-center gap-3 pt-1">
                    <span>NIS / ID: <b class="font-mono text-slate-900">{{ $student->nis_nim ?: ($student->account_id ?? '-') }}</b></span>
                    <span class="text-amber-500">•</span>
                    <span>Instansi: <b class="text-slate-900">{{ $student->school_origin }}</b></span>
                    <span class="text-amber-500">•</span>
                    <span>Program: <b class="text-slate-900">{{ $student->major }}</b></span>
                </div>
            </div>

            <!-- Statement Paragraph -->
            <p class="text-xs sm:text-[12.5px] text-slate-700 max-w-3xl mx-auto leading-relaxed pt-0.5">
                Telah melaksanakan dan menyelesaikan seluruh rangkaian program <b>Praktik Kerja Lapangan (PKL)</b> pada divisi <b>Software Engineering & Development</b> di PT. Teknologi Multi Sistem dari tanggal <b>{{ $student->internship_period ?? '1 Juli 2026 s/d 31 Desember 2026' }}</b> dengan hasil evaluasi kinerja industri:
            </p>

            @php
                $score = (float) $evaluation->final_score;
                if ($score >= 85) {
                    $predTitle = 'PREDIKAT A (SANGAT MEMUASKAN)';
                    $badgeBg = 'from-emerald-700 via-emerald-600 to-teal-700';
                    $textColor = 'text-emerald-100';
                } elseif ($score >= 75) {
                    $predTitle = 'PREDIKAT B (MEMUASKAN)';
                    $badgeBg = 'from-blue-700 via-blue-600 to-indigo-700';
                    $textColor = 'text-blue-100';
                } elseif ($score >= 60) {
                    $predTitle = 'PREDIKAT C (CUKUP)';
                    $badgeBg = 'from-amber-700 via-amber-600 to-orange-700';
                    $textColor = 'text-amber-100';
                } else {
                    $predTitle = 'PREDIKAT D (KURANG)';
                    $badgeBg = 'from-rose-700 via-rose-600 to-red-700';
                    $textColor = 'text-rose-100';
                }
            @endphp

            <!-- Grade Callout Pill -->
            <div class="inline-flex items-center gap-3 px-5 py-1.5 rounded-xl bg-gradient-to-r {{ $badgeBg }} text-white text-xs font-black shadow-md">
                <i data-lucide="award" class="w-4 h-4 text-amber-300"></i>
                <span class="tracking-wider">{{ $predTitle }}</span>
                <span class="opacity-40">|</span>
                <span class="font-mono text-amber-300 tracking-wider">SKOR AKHIR: {{ number_format($score, 1) }} / 100</span>
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- 3. FOOTER SECTION (4 PILAR, QR VERIFY, TTD & STEMPEL)          -->
        <!-- ============================================================== -->
        <div class="relative z-20 border-t border-slate-200/90 pt-3 px-8 grid grid-cols-12 items-end gap-3 pb-1">
            
            <!-- Left: QR Code Verifikasi Online Otentik (Menuju Profil Publik Siswa) -->
            <div class="col-span-3 flex items-center gap-2.5">
                <div class="w-[74px] h-[74px] bg-white p-1 rounded-xl border border-slate-300 shadow-sm flex items-center justify-center shrink-0">
                    <img 
                        src="https://api.qrserver.com/v1/create-qr-code/?size=160x160&data={{ urlencode($student->profile_url) }}" 
                        alt="QR Code Profil & Sertifikat Siswa" 
                        class="w-full h-full object-contain">
                </div>
                <div class="text-[8.5px] text-slate-500 leading-tight">
                    <div class="font-bold text-slate-800 uppercase tracking-wide">Validasi Profil & DUDI:</div>
                    <div class="text-[8px] font-mono text-slate-400 mt-0.5">Scan QR untuk melihat Profil, Portofolio & Keaslian Sertifikat Siswa.</div>
                    <div class="text-emerald-700 font-bold mt-1 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        <span>Otentik & Terdaftar</span>
                    </div>
                </div>
            </div>

            <!-- Center: Transkrip Mini 4 Pilar Industri -->
            <div class="col-span-5 text-center px-1">
                <div class="text-[8.5px] uppercase font-bold text-slate-400 tracking-widest mb-1">
                    Capaian Kompetensi 4 Pilar DUDI:
                </div>
                <div class="grid grid-cols-4 gap-1.5 text-[10px] font-mono bg-slate-50 border border-slate-200/80 p-2 rounded-xl">
                    <div class="bg-white rounded-lg py-1 border border-slate-100 shadow-2xs">
                        <div class="text-slate-400 text-[8px] uppercase font-semibold">Teknis</div>
                        <div class="font-black text-slate-900">{{ $evaluation->technical_skill }}</div>
                    </div>
                    <div class="bg-white rounded-lg py-1 border border-slate-100 shadow-2xs">
                        <div class="text-slate-400 text-[8px] uppercase font-semibold">Disiplin</div>
                        <div class="font-black text-slate-900">{{ $evaluation->discipline }}</div>
                    </div>
                    <div class="bg-white rounded-lg py-1 border border-slate-100 shadow-2xs">
                        <div class="text-slate-400 text-[8px] uppercase font-semibold">Kerjasama</div>
                        <div class="font-black text-slate-900">{{ $evaluation->teamwork }}</div>
                    </div>
                    <div class="bg-white rounded-lg py-1 border border-slate-100 shadow-2xs">
                        <div class="text-slate-400 text-[8px] uppercase font-semibold">Inisiatif</div>
                        <div class="font-black text-slate-900">{{ $evaluation->initiative }}</div>
                    </div>
                </div>
                <div class="text-[8px] text-slate-500 mt-1 font-medium">
                    Cohort: <span class="font-bold text-slate-700">{{ $student->batch->batch_name ?? 'Angkatan 2026' }}</span> &bull; PT. TMS
                </div>
            </div>

            <!-- Right: Signatures & Stempel Resmi DUDI -->
            <div class="col-span-4 text-right relative">
                
                <!-- Digital Stempel PT. Teknologi Multi Sistem -->
                <div class="absolute right-10 -top-7 w-24 h-24 rounded-full border-2 border-red-600/35 flex flex-col items-center justify-center rotate-[-12deg] pointer-events-none select-none bg-red-600/[0.02]">
                    <div class="w-20 h-20 rounded-full border border-dashed border-red-600/30 flex flex-col items-center justify-center p-1 text-center">
                        <span class="text-[6.5px] font-black text-red-600/60 uppercase leading-none">PT. TEKNOLOGI</span>
                        <span class="text-[6px] font-bold text-slate-700/50 my-0.5">MULTI SISTEM</span>
                        <span class="text-[5.5px] font-black text-red-600/50 uppercase tracking-widest leading-none">VERIFIED DUDI</span>
                    </div>
                </div>

                <div class="text-[9px] text-slate-500 mb-2 font-medium">
                    Ciamis, {{ \Carbon\Carbon::parse($evaluation->issue_date ?? now())->translatedFormat('d F Y') }}
                </div>

                <div class="grid grid-cols-2 gap-3 text-center pt-1">
                    <div>
                        <!-- Tanda Tangan Pembimbing Industri -->
                        <div class="font-script text-base text-slate-800 leading-none h-6 flex items-end justify-center">
                            {{ $mentor->name ?? ($student->mentor->name ?? 'Staff Mentor') }}
                        </div>
                        <div class="border-t border-slate-400 mt-1 pt-0.5 text-[8.5px] font-bold text-slate-800">
                            {{ $mentor->name ?? ($student->mentor->name ?? 'Staff Mentor TMS') }}
                        </div>
                        <div class="text-[7.5px] text-slate-500 font-medium">Mentor Pembimbing Industri</div>
                    </div>

                    <div>
                        <!-- Tanda Tangan Direktur Utama -->
                        <div class="font-script text-base text-slate-800 leading-none h-6 flex items-end justify-center">
                            Dani Ramdhani
                        </div>
                        <div class="border-t border-slate-400 mt-1 pt-0.5 text-[8.5px] font-bold text-slate-800">
                            Dani Ramdhani, S.T.
                        </div>
                        <div class="text-[7.5px] text-slate-500 font-medium">Direktur Utama PT. TMS</div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>