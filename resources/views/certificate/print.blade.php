<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Sertifikat PKL • {{ $student->name }} • {{ $evaluation->certificate_number }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=Outfit:wght@300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,600;0,700;0,900;1,400&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #1e293b;
            color: #0f172a;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .serif-title {
            font-family: 'Cinzel', serif;
        }

        .serif-name {
            font-family: 'Playfair Display', serif;
        }

        /* Standar A4 Landscape: 297mm x 210mm (Ratio ~1.414) */
        .cert-canvas {
            width: 1050px;
            height: 742px;
            background: #ffffff;
            position: relative;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            /* Catatan: Ketika template foto sertifikat dari mentor sudah siap,
               Anda cukup mengganti background dengan:
               background-image: url('/path/to/template-sertifikat.jpg');
               background-size: cover;
               background-position: center;
            */
        }

        @media print {
            body {
                background: none !important;
                padding: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .cert-canvas {
                box-shadow: none !important;
                margin: 0 !important;
                width: 100vw !important;
                height: 100vh !important;
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
    <div class="no-print fixed top-5 z-50 flex items-center gap-3 bg-slate-900/90 backdrop-blur-md px-5 py-2.5 rounded-full border border-slate-700 shadow-2xl text-white">
        <div class="flex items-center gap-2 pr-3 border-r border-slate-700 text-xs font-semibold">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            <span>E-Sertifikat PKL PT. TMS (Siap Cetak / PDF)</span>
        </div>
        <button onclick="window.print()" class="px-4 py-1.5 rounded-full bg-red-600 hover:bg-red-700 text-white text-xs font-bold transition-all shadow-md flex items-center gap-1.5 cursor-pointer">
            <i data-lucide="printer" class="w-3.5 h-3.5"></i>
            <span>Cetak / Simpan PDF</span>
        </button>
        <a href="{{ route('profile') }}" class="px-3.5 py-1.5 rounded-full bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold transition-colors flex items-center gap-1">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            <span>Kembali</span>
        </a>
    </div>

    <!-- CERTIFICATE A4 CANVAS -->
    <div class="cert-canvas rounded-2xl overflow-hidden p-8 flex flex-col justify-between border-8 border-slate-900 relative my-6">

        <!-- Outer Ornamental Frame -->
        <div class="absolute inset-2 border-2 border-amber-600/70 pointer-events-none rounded-xl"></div>
        <div class="absolute inset-3 border border-slate-200 pointer-events-none rounded-lg"></div>

        <!-- Corner Ornaments (Gold & Black Accents) -->
        <div class="absolute top-4 left-4 w-12 h-12 border-t-4 border-l-4 border-amber-500 pointer-events-none"></div>
        <div class="absolute top-4 right-4 w-12 h-12 border-t-4 border-r-4 border-amber-500 pointer-events-none"></div>
        <div class="absolute bottom-4 left-4 w-12 h-12 border-b-4 border-l-4 border-amber-500 pointer-events-none"></div>
        <div class="absolute bottom-4 right-4 w-12 h-12 border-b-4 border-r-4 border-amber-500 pointer-events-none"></div>

        <!-- Certificate Header -->
        <div class="text-center relative z-10 pt-2">
            <div class="flex items-center justify-center gap-3 mb-1">
                <div class="w-10 h-10 rounded-xl bg-slate-900 text-red-600 flex items-center justify-center font-black text-sm shadow-md">
                    TMS
                </div>
                <div class="text-left">
                    <div class="serif-title font-black text-slate-950 text-base tracking-widest leading-none">PT. TEKNOLOGI MULTI SISTEM</div>
                    <div class="text-[9px] uppercase tracking-wider text-slate-500 font-semibold mt-0.5">Software Engineering & Digital Solutions &bull; Ciamis - Indonesia</div>
                </div>
            </div>

            <!-- Title -->
            <div class="mt-3">
                <h1 class="serif-title text-2xl sm:text-3xl font-black text-slate-900 tracking-wider">
                    SERTIFIKAT PRAKTIK KERJA LAPANGAN
                </h1>
                <div class="text-[11px] uppercase tracking-widest text-amber-700 font-semibold italic mt-0.5">
                    Certificate of Industrial Internship & Professional Competency
                </div>
                <div class="inline-block mt-2 px-3 py-0.5 rounded-full bg-slate-100 border border-slate-200 text-[10px] font-mono font-bold text-slate-700">
                    No. Sertifikat: {{ $evaluation->certificate_number }}
                </div>
            </div>
        </div>

        <!-- Certificate Body -->
        <div class="text-center relative z-10 px-8 space-y-2">
            <p class="text-xs uppercase tracking-widest text-slate-500 font-semibold">
                Diberikan kepada (This is to certify that):
            </p>

            <!-- Recipient Name -->
            <h2 class="serif-name text-3xl sm:text-4xl font-black text-slate-950 tracking-tight text-red-600 underline decoration-amber-500/50 decoration-2 underline-offset-8">
                {{ $student->name }}
            </h2>

            <!-- Student Meta -->
            <div class="text-xs text-slate-600 font-medium pt-2">
                NIS/NIM: <b class="font-mono text-slate-900">{{ $student->nis_nim ?? '212210045' }}</b> &bull; 
                Asal Sekolah/Kampus: <b class="text-slate-900">{{ $student->school_origin }}</b> &bull; 
                Konsentrasi: <b class="text-slate-900">{{ $student->major }}</b>
            </div>

            <!-- Statement Paragraph -->
            <p class="text-xs sm:text-[13px] text-slate-700 max-w-2xl mx-auto leading-relaxed pt-1">
                Telah berhasil menyelesaikan seluruh program <b>Praktik Kerja Lapangan (PKL)</b> pada divisi <b>{{ $student->mentor->location ?? 'IT / Software Engineering' }}</b> di PT. Teknologi Multi Sistem dari tanggal <b>{{ $student->internship_period ?? '1 Juli 2026 s/d 31 Desember 2026' }}</b> dengan predikat:
            </p>

            <!-- Grade Callout -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-xs font-bold">
                <i data-lucide="award" class="w-4 h-4 text-amber-600"></i>
                <span>PREDIKAT A (SANGAT MEMUASKAN) &bull; SKOR AKHIR: {{ $evaluation->final_score }} / 100</span>
            </div>
        </div>

        <!-- Certificate Footer (QR Code, Scores & Signatures) -->
        <div class="relative z-10 pt-3 border-t border-slate-100 grid grid-cols-12 items-end gap-4 px-4 pb-1">
            
            <!-- Left: QR Code Verifikasi Online -->
            <div class="col-span-3 flex items-center gap-2.5">
                <div class="w-20 h-20 bg-white p-1 rounded-xl border border-slate-200 shadow-xs flex items-center justify-center shrink-0">
                    <img 
                        src="https://api.qrserver.com/v1/create-qr-code/?size=160x160&data={{ urlencode(route('verify.show', $evaluation->certificate_number)) }}" 
                        alt="QR Code Verifikasi" 
                        class="w-full h-full object-contain">
                </div>
                <div class="text-[9px] text-slate-400 leading-tight">
                    <div class="font-bold text-slate-700">Verifikasi Resmi:</div>
                    <div class="line-clamp-2 text-[8px] font-mono mt-0.5">Scan QR untuk cek keaslian di SIMAK-TMS DUDI.</div>
                    <div class="text-emerald-600 font-bold mt-0.5">● Otentik</div>
                </div>
            </div>

            <!-- Center: Transkrip Nilai Ringkas -->
            <div class="col-span-5 text-center px-2">
                <div class="text-[9px] uppercase font-bold text-slate-400 tracking-wider mb-1">Capaian Standar Industri PT. TMS:</div>
                <div class="grid grid-cols-4 gap-1 text-[10px] font-mono bg-slate-50 p-1.5 rounded-lg border border-slate-100">
                    <div>
                        <div class="text-slate-400 text-[8px]">Teknis</div>
                        <div class="font-bold text-slate-900">{{ $evaluation->technical_skill }}</div>
                    </div>
                    <div>
                        <div class="text-slate-400 text-[8px]">Disiplin</div>
                        <div class="font-bold text-slate-900">{{ $evaluation->discipline }}</div>
                    </div>
                    <div>
                        <div class="text-slate-400 text-[8px]">Teamwork</div>
                        <div class="font-bold text-slate-900">{{ $evaluation->teamwork }}</div>
                    </div>
                    <div>
                        <div class="text-slate-400 text-[8px]">Inisiatif</div>
                        <div class="font-bold text-slate-900">{{ $evaluation->initiative }}</div>
                    </div>
                </div>
                <div class="text-[9px] text-slate-500 mt-1 font-medium italic">
                    Project: SIMAK-TMS & TechPulse Engineering Blog
                </div>
            </div>

            <!-- Right: Signatures & Digital Stamp -->
            <div class="col-span-4 text-right space-y-1 relative">
                <!-- Stempel Digital PT. TMS (Watermark) -->
                <div class="absolute right-14 -top-8 w-24 h-24 rounded-full border-4 border-red-600/30 flex items-center justify-center rotate-[-15deg] pointer-events-none">
                    <div class="text-[8px] font-black text-red-600/40 text-center uppercase leading-none">
                        PT. TEKNOLOGI<br>MULTI SISTEM<br><span class="text-[6px]">VERIFIED DUDI</span>
                    </div>
                </div>

                <div class="text-[10px] text-slate-500">
                    Ciamis, {{ \Carbon\Carbon::parse($evaluation->issue_date ?? now())->translatedFormat('d F Y') }}
                </div>

                <div class="grid grid-cols-2 gap-2 text-center pt-5">
                    <div>
                        <!-- Tanda Tangan Pembimbing Industri -->
                        <div class="font-script text-xs font-bold text-slate-900 italic font-mono">{{ $mentor->name ?? 'Farhan Ramadhan' }}</div>
                        <div class="border-t border-slate-400 mt-1 pt-0.5 text-[8px] font-bold text-slate-700">Mentor Pembimbing</div>
                        <div class="text-[7px] text-slate-400">Head of Software TMS</div>
                    </div>

                    <div>
                        <!-- Tanda Tangan Direktur Utama -->
                        <div class="font-script text-xs font-bold text-slate-900 italic font-mono">Dani Ramdhani, S.T.</div>
                        <div class="border-t border-slate-400 mt-1 pt-0.5 text-[8px] font-bold text-slate-700">Direktur Utama</div>
                        <div class="text-[7px] text-slate-400">PT. Teknologi Multi Sistem</div>
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
