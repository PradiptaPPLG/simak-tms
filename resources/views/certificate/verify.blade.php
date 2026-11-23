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
        .verified-card {
            background: #ffffff;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
        }
    </style>
</head>
<body class="py-8 px-4 sm:px-6 flex items-center justify-center min-h-screen">

    <div class="max-w-3xl w-full space-y-6">

        <!-- Top Brand Header -->
        <div class="text-center space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-xs font-semibold">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Portal Verifikasi Publik Resmi SIMAK-TMS</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">PT. TEKNOLOGI MULTI SISTEM</h1>
            <p class="text-xs text-slate-300">Sistem Informasi Manajemen Aktivitas, Karya & Sertifikasi Siswa Praktik Kerja Lapangan (PKL)</p>
        </div>

        <!-- Main Verified Card -->
        <div class="verified-card rounded-3xl overflow-hidden border border-slate-100">
            
            <!-- Green Verification Ribbon -->
            <div class="bg-emerald-600 px-6 py-4 text-white flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center shrink-0">
                        <i data-lucide="shield-check" class="w-6 h-6 text-white"></i>
                    </div>
                    <div>
                        <div class="text-[11px] font-bold uppercase tracking-wider text-emerald-100">Status Dokumen Otentik</div>
                        <div class="text-base font-black tracking-wide">SERTIFIKAT RESMI TERVERIFIKASI</div>
                    </div>
                </div>
                <div class="sm:text-right font-mono text-xs bg-emerald-700/60 px-3 py-1.5 rounded-xl border border-emerald-500/40">
                    <div class="text-[10px] text-emerald-200 uppercase font-semibold">Nomor Sertifikat:</div>
                    <div class="font-bold tracking-wider">{{ $evaluation->certificate_number }}</div>
                </div>
            </div>

            <!-- Card Content Body -->
            <div class="p-6 sm:p-8 space-y-6">

                <!-- Student Identity Header -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-2xl bg-slate-900 text-white font-black text-xl flex items-center justify-center shadow-md shadow-slate-900/20 shrink-0">
                            {{ substr($student->name, 0, 2) }}
                        </div>
                        <div>
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-red-50 text-red-600 font-bold text-[10px] uppercase border border-red-200 mb-1">
                                Peserta Lulus PKL
                            </div>
                            <h2 class="text-xl sm:text-2xl font-black text-slate-900 leading-tight">{{ $student->name }}</h2>
                            <div class="text-xs text-slate-500 font-mono mt-0.5">
                                NIS/NIM: <b class="text-slate-800">{{ $student->nis_nim ?: ($student->account_id ?? '-') }}</b> • ID Akun: <b class="text-slate-800">{{ $student->account_id ?? '-' }}</b>
                            </div>
                        </div>
                    </div>

                    <!-- Final Score Badge -->
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 flex items-center gap-3 self-start sm:self-auto">
                        <div class="text-right">
                            <div class="text-[10px] font-bold text-slate-400 uppercase">Skor Evaluasi</div>
                            <div class="text-2xl font-black font-mono text-slate-900">{{ $evaluation->final_score }}<span class="text-xs text-slate-400 font-normal">/100</span></div>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-red-600 text-white font-black text-xl flex items-center justify-center shadow-md shadow-red-600/30">
                            {{ $evaluation->final_score >= 85 ? 'A' : ($evaluation->final_score >= 75 ? 'B' : ($evaluation->final_score >= 60 ? 'C' : 'D')) }}
                        </div>
                    </div>
                </div>

                <!-- 2-Column Metadata -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-1">
                        <span class="text-slate-400 text-[10px] font-bold uppercase tracking-wider">Asal Sekolah / Kampus Mitra</span>
                        <div class="font-bold text-slate-900 text-sm">{{ $student->school_origin }}</div>
                        <div class="text-slate-500 font-medium">Konsentrasi: {{ $student->major }}</div>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-1">
                        <span class="text-slate-400 text-[10px] font-bold uppercase tracking-wider">Penempatan & Periode PKL</span>
                        <div class="font-bold text-slate-900 text-sm">PT. Teknologi Multi Sistem</div>
                        <div class="text-slate-500 font-medium">Divisi {{ $student->mentor->location ?? 'IT / Software Engineering' }} • {{ $student->internship_period ?? '1 Juli 2026 – 31 Desember 2026' }}</div>
                    </div>
                </div>

                <!-- 4 Standar Kompetensi Nilai Industri -->
                <div class="space-y-2">
                    <div class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-1.5">
                        <i data-lucide="award" class="w-4 h-4 text-red-600"></i>
                        <span>Transkrip Capaian Kompetensi Industri:</span>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-center">
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
                            <div class="text-[10px] font-bold text-slate-400 uppercase">Hard Skill Koding</div>
                            <div class="text-lg font-black font-mono text-slate-900 mt-0.5">{{ $evaluation->technical_skill }}</div>
                            <div class="text-[9px] text-emerald-600 font-bold">Sangat Kompeten</div>
                        </div>
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
                            <div class="text-[10px] font-bold text-slate-400 uppercase">Kedisiplinan & SOP</div>
                            <div class="text-lg font-black font-mono text-slate-900 mt-0.5">{{ $evaluation->discipline }}</div>
                            <div class="text-[9px] text-emerald-600 font-bold">Integritas Tinggi</div>
                        </div>
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
                            <div class="text-[10px] font-bold text-slate-400 uppercase">Teamwork & Agile</div>
                            <div class="text-lg font-black font-mono text-slate-900 mt-0.5">{{ $evaluation->teamwork }}</div>
                            <div class="text-[9px] text-emerald-600 font-bold">Kolaboratif</div>
                        </div>
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
                            <div class="text-[10px] font-bold text-slate-400 uppercase">Inisiatif Solusi</div>
                            <div class="text-lg font-black font-mono text-slate-900 mt-0.5">{{ $evaluation->initiative }}</div>
                            <div class="text-[9px] text-emerald-600 font-bold">Solutif & Mandiri</div>
                        </div>
                    </div>
                </div>

                <!-- Project Angkatan yang Dikerjakan (1 Angkatan > 1 Project) -->
                @if($projects && $projects->count() > 0)
                    <div class="space-y-2">
                        <div class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center justify-between">
                            <div class="flex items-center gap-1.5">
                                <i data-lucide="folder-git-2" class="w-4 h-4 text-slate-700"></i>
                                <span>Project Unggulan Angkatan ({{ $batch->batch_name ?? 'Batch 2026' }}):</span>
                            </div>
                            <span class="text-[10px] text-slate-400 font-mono font-normal">{{ $projects->count() }} Project Terdata</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach($projects as $proj)
                                <div class="p-3.5 rounded-xl border border-slate-200 bg-white hover:border-red-300 transition-colors space-y-1.5">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[9px] font-bold uppercase px-2 py-0.5 rounded bg-red-50 text-red-600 border border-red-200">
                                            {{ $proj->project_category ?? 'Web App' }}
                                        </span>
                                        <span class="text-[10px] text-emerald-600 font-bold flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            {{ $proj->status ?? 'Completed' }}
                                        </span>
                                    </div>
                                    <div class="font-bold text-slate-900 text-xs leading-snug">{{ $proj->title }}</div>
                                    <div class="text-[10px] text-slate-500 font-mono line-clamp-1">{{ $proj->tech_stack }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Legal Validation / Signatures -->
                <div class="pt-4 border-t border-slate-100 grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <div class="w-9 h-9 rounded-lg bg-slate-900 text-white flex items-center justify-center shrink-0">
                            <i data-lucide="stamp" class="w-4 h-4 text-amber-400"></i>
                        </div>
                        <div>
                            <div class="font-bold text-slate-900">PT. Teknologi Multi Sistem</div>
                            <div class="text-[10px] text-slate-400">Terdaftar DUDI Kemitraan Vokasi Resmi</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <div class="w-9 h-9 rounded-lg bg-red-600 text-white flex items-center justify-center shrink-0">
                            <i data-lucide="user-check" class="w-4 h-4 text-white"></i>
                        </div>
                        <div>
                            <div class="font-bold text-slate-900">{{ $mentor->name ?? 'Mentor Pembimbing Industri' }}</div>
                            <div class="text-[10px] text-slate-400">Head of Software & Mentor Teknis TMS</div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="pt-2 flex flex-col sm:flex-row items-center gap-3">
                    <a href="{{ route('certificate.print', $evaluation->certificate_number) }}" target="_blank" class="w-full sm:flex-1 py-3 px-5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-bold transition-all shadow-md shadow-red-600/30 flex items-center justify-center gap-2">
                        <i data-lucide="printer" class="w-4 h-4"></i>
                        <span>Cetak E-Sertifikat Resmi (PDF / Print)</span>
                    </a>

                    <a href="{{ route('verify.index') }}" class="w-full sm:w-auto py-3 px-5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-colors flex items-center justify-center gap-2">
                        <i data-lucide="search" class="w-4 h-4 text-slate-500"></i>
                        <span>Cari Sertifikat Lain</span>
                    </a>
                </div>

            </div>

            <!-- Footer Timestamp -->
            <div class="bg-slate-50 px-6 py-3 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between text-[11px] text-slate-400 gap-2">
                <span>Diterbitkan: {{ \Carbon\Carbon::parse($evaluation->issue_date ?? now())->translatedFormat('d F Y') }}</span>
                <span class="font-mono">Security Hash: {{ substr(hash('sha256', $evaluation->certificate_number . $student->id), 0, 16) }}</span>
            </div>
        </div>

        <div class="text-center text-xs text-slate-400">
            &copy; 2026 PT. Teknologi Multi Sistem &bull; Kerjasama Resmi SMK Pusat Keunggulan & Perguruan Tinggi Mitra
        </div>

    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
