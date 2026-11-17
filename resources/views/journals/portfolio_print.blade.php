<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pratinjau Cetak: Portofolio PKL (TP) - {{ $user->name }}</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            background: #e2e8f0;
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            color: #0f172a;
        }

        /* Top Sticky Toolbar */
        .toolbar {
            position: sticky;
            top: 0;
            z-index: 50;
            background: #0f172a;
            color: #e2e8f0;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            border-bottom: 1px solid #1e293b;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.25);
        }
        .toolbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }
        .toolbar-left .icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: #1e293b;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .toolbar-left .icon svg { width: 17px; height: 17px; color: #ef4444; }
        .toolbar-title { font-weight: 700; font-size: 13.5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .toolbar-sub { font-size: 11.5px; color: #94a3b8; margin-top: 1px; }
        .toolbar-actions { display: flex; gap: 8px; flex-shrink: 0; }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 8px 14px;
            border-radius: 10px;
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.15s ease;
            line-height: 1;
        }
        .btn svg { width: 15px; height: 15px; }
        .btn-ghost {
            background: #1e293b;
            color: #cbd5e1;
            border: 1px solid #334155;
        }
        .btn-ghost:hover { background: #334155; color: #fff; }
        .btn-primary {
            background: #ef4444;
            color: #fff;
        }
        .btn-primary:hover { background: #dc2626; transform: translateY(-1px); }
        .btn-success {
            background: #10b981;
            color: #fff;
        }
        .btn-success:hover { background: #059669; transform: translateY(-1px); }

        .page-wrap {
            padding: 28px 16px 48px;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            overflow-x: hidden;
        }
        .page-info {
            width: 210mm;
            max-width: 100%;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            font-size: 12px;
            color: #475569;
        }
        .page-info .chip {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 999px;
            padding: 4px 12px;
            font-weight: 600;
            color: #334155;
            white-space: nowrap;
        }
        .btn-zoom-toggle {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 999px;
            padding: 4px 12px;
            font-size: 11.5px;
            font-weight: 600;
            color: #ef4444;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.15s ease;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }
        .btn-zoom-toggle:hover {
            background: #f8fafc;
            border-color: #94a3b8;
            color: #dc2626;
        }
        .fit-width .btn-zoom-toggle {
            background: #fef2f2;
            border-color: #fecaca;
            color: #ef4444;
        }
        .page-viewport {
            width: 100%;
            overflow-x: auto;
            display: flex;
            justify-content: flex-start;
            padding: 4px 0 20px;
        }
        @media (min-width: 215mm) {
            .page-viewport {
                justify-content: center;
            }
        }
        .page {
            width: 210mm;
            min-height: 297mm;
            background: #ffffff;
            padding: 17mm 17mm 15mm;
            box-shadow: 0 15px 40px rgba(15, 23, 42, 0.18);
            border-radius: 2px;
            transform-origin: top center;
            flex-shrink: 0;
            margin: 0 auto;
            transition: transform 0.2s ease, margin-bottom 0.2s ease;
        }

        /* Formal Academic Styling */
        .p-doc {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            line-height: 1.5;
            color: #0f172a;
        }
        .header {
            text-align: center;
            margin-bottom: 12pt;
        }
        .header h2 {
            margin: 0;
            font-size: 14pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5pt;
        }
        .header h3 {
            margin: 2pt 0 0 0;
            font-size: 12pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3pt;
            color: #1e293b;
        }
        .header .meta {
            margin: 2pt 0 0 0;
            font-size: 10pt;
            color: #475569;
        }
        .rule {
            border-top: 1.5pt solid #0f172a;
            margin-bottom: 12pt;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10.5pt;
            margin-bottom: 16pt;
        }
        .info-table td {
            padding: 2.5pt 0;
            vertical-align: top;
        }
        .tp-section {
            margin-bottom: 18pt;
            page-break-inside: avoid;
            break-inside: avoid;
        }
        .tp-title {
            background-color: #f1f5f9;
            padding: 6pt 10pt;
            border: 1pt solid #cbd5e1;
            font-weight: 700;
            font-size: 10.5pt;
            color: #0f172a;
            margin-bottom: 6pt;
        }
        .tp-title .cp-desc {
            font-weight: normal;
            font-size: 9pt;
            color: #334155;
            margin-top: 2pt;
            display: block;
        }
        table.data {
            width: 100%;
            border-collapse: collapse;
            font-size: 9.5pt;
        }
        table.data th, table.data td {
            border: 0.75pt solid #94a3b8;
            padding: 5pt 6pt;
            text-align: left;
            vertical-align: top;
        }
        table.data th {
            background-color: #eef2f7;
            font-weight: 700;
            text-align: center;
        }
        .signature-table {
            width: 100%;
            border: none;
            margin-top: 28pt;
            page-break-inside: avoid;
            break-inside: avoid;
        }
        .signature-table td {
            text-align: center;
            width: 50%;
            vertical-align: top;
            font-size: 10.5pt;
        }
        .space { height: 55pt; }
        .print-info {
            margin-top: 14pt;
            font-size: 8pt;
            color: #64748b;
            text-align: right;
            page-break-before: avoid;
        }

        @media (max-width: 640px) {
            .toolbar {
                padding: 10px 12px;
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }
            .toolbar-left {
                justify-content: center;
            }
            .toolbar-title {
                font-size: 12.5px;
            }
            .toolbar-sub {
                font-size: 10px;
                text-align: center;
            }
            .toolbar-actions {
                justify-content: center;
                width: 100%;
            }
            .btn {
                flex: 1;
                justify-content: center;
                padding: 8px 10px;
                font-size: 11.5px;
            }
            .page-info {
                flex-direction: column;
                align-items: center;
                text-align: center;
                gap: 8px;
            }
        }

        @media print {
            @page {
                size: A4 portrait;
                margin: 12mm 15mm 12mm 15mm;
            }
            body { background: #fff !important; }
            .toolbar, .page-info { display: none !important; }
            .page-wrap { padding: 0 !important; }
            .page-viewport { overflow: visible !important; height: auto !important; padding: 0 !important; }
            .page {
                width: 100% !important;
                min-height: auto !important;
                padding: 0 !important;
                box-shadow: none !important;
                border-radius: 0 !important;
                transform: none !important;
                zoom: 1 !important;
            }
        }
    </style>
</head>
<body>

    <!-- Sticky Toolbar -->
    <div class="toolbar">
        <div class="toolbar-left">
            <div class="icon">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div>
                <div class="toolbar-title">Pratinjau Cetak: Portofolio PKL Berdasarkan TP</div>
                <div class="toolbar-sub">Portofolio-PKL-{{ $user->account_id }}.pdf &middot; {{ $projects->count() }} proyek rekayasa &middot; {{ $jurnals->count() }} kegiatan terverifikasi</div>
            </div>
        </div>
        <div class="toolbar-actions">
            <a href="{{ route('journals.index') }}" onclick="handleKembali(event)" class="btn btn-ghost">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
            <button onclick="window.print()" class="btn btn-primary">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Unduh PDF
            </button>
            <button onclick="window.print()" class="btn btn-success">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak
            </button>
        </div>
    </div>

    <!-- Paper Container -->
    <div class="page-wrap">
        <div class="page-info">
            <div class="page-info-text">
                <span>Dokumen akan dicetak pada kertas <strong>A4 (Portrait)</strong> berukuran standar.</span>
            </div>
            <div style="display: flex; gap: 8px; align-items: center;">
                <button id="btn-toggle-fit" class="btn-zoom-toggle">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width: 14px; height: 14px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5"/>
                    </svg>
                    <span id="zoom-text">Fit Lebar</span>
                </button>
                <span class="chip">{{ $projects->count() }} Proyek Rekayasa</span>
            </div>
        </div>

        <div class="page-viewport">
            <div class="page">
                <div class="p-doc">
                    <div class="header">
                        <h2>PORTOFOLIO PRAKTIK KERJA LAPANGAN (PKL)</h2>
                        <h3>BERDASARKAN TUJUAN PEMBELAJARAN (TP)</h3>
                        <p class="meta">Tahun Ajaran {{ $user->batch->period_year ?? '2025/2026' }}</p>
                    </div>

                    <div class="rule"></div>

                    <table class="info-table">
                        <tr>
                            <td style="width: 155pt; font-weight: 700;">Nama Peserta Didik</td>
                            <td style="width: 12pt;">:</td>
                            <td><strong>{{ strtoupper($user->name) }}</strong></td>
                            <td style="width: 50pt; font-weight: 700;">NIS</td>
                            <td style="width: 12pt;">:</td>
                            <td>{{ $user->nis_nim ?? $user->account_id }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 700;">Konsentrasi Keahlian</td>
                            <td>:</td>
                            <td>{{ $user->major ?? 'PPLG (Pengembangan Perangkat Lunak & Gim)' }}</td>
                            <td style="font-weight: 700;">ID Akun</td>
                            <td>:</td>
                            <td>{{ $user->account_id }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 700;">Dunia Kerja Tempat PKL</td>
                            <td>:</td>
                            <td colspan="4"><strong>PT. TEKNOLOGI MULTI SISTEM</strong> (Software House & IT Services)</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 700;">Asal Sekolah Mitra</td>
                            <td>:</td>
                            <td colspan="4">{{ $user->school_origin ?? 'SMKN 1 Ciamis' }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 700;">Periode Pelaksanaan Magang</td>
                            <td>:</td>
                            <td colspan="4">{{ $user->internship_period ?? '1 Juli 2026 – 31 Desember 2026' }}</td>
                        </tr>
                    </table>

                    <!-- TP 1: Soft Skills & Budaya Kerja -->
                    <div class="tp-section">
                        <div class="tp-title">
                            Tujuan Pembelajaran 1: Penerapan Soft Skills, Budaya Kerja Industri & Manajemen Tugas
                            <span class="cp-desc">CP: Peserta didik menginternalisasi SOP perusahaan, komunikasi teknis tim, etika kerja rekayasa, kedisiplinan logbook, dan kolaborasi profesional bersama mentor.</span>
                        </div>
                        <table class="data">
                            <thead>
                                <tr>
                                    <th style="width: 6%;">No</th>
                                    <th style="width: 16%;">Tanggal</th>
                                    <th style="width: 50%;">Aktivitas / Kegiatan Penerapan</th>
                                    <th style="width: 28%;">Catatan Capaian Industri</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="text-align: center;">1</td>
                                    <td>16/11/2026</td>
                                    <td>
                                        <strong>Briefing SOP, Orientasi Budaya Kerja & Manajemen Task Magang</strong><br>
                                        <span style="font-size: 8.5pt; color: #475569;">Penyusunan backlog sprint mingguan dan pemahaman standar commit repository git PT. TMS.</span>
                                    </td>
                                    <td><span style="color: #047857; font-weight: 600;">Internalisasi SOP Selesai (Disiplin)</span></td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">2</td>
                                    <td>Berkelanjutan</td>
                                    <td>
                                        <strong>Pencatatan Logbook Harian Mandiri & Review Mentor TMS</strong><br>
                                        <span style="font-size: 8.5pt; color: #475569;">Konsistensi pengisian logbook real-time dan evaluasi berkala bersama mentor pembimbing.</span>
                                    </td>
                                    <td><span style="color: #047857; font-weight: 600;">Memenuhi Standar Industri</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- TP 2: Rekayasa Software, Database & API -->
                    <div class="tp-section">
                        <div class="tp-title">
                            Tujuan Pembelajaran 2: Perancangan Arsitektur Perangkat Lunak, Basis Data & RESTful API
                            <span class="cp-desc">CP: Peserta didik mampu merancang skema relasi basis data, membangun backend API terstandar, mengelola version control (Git flow/commit), serta menyusun komponen UI responsif.</span>
                        </div>
                        <table class="data">
                            <thead>
                                <tr>
                                    <th style="width: 6%;">No</th>
                                    <th style="width: 16%;">Tanggal</th>
                                    <th style="width: 50%;">Aktivitas / Kegiatan Pengerjaan</th>
                                    <th style="width: 28%;">Tautan / Bukti Koding</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $tp2Count = 0; @endphp
                                @foreach($jurnals as $row)
                                    @php $tp2Count++; @endphp
                                    <tr>
                                        <td style="text-align: center;">{{ $tp2Count }}</td>
                                        <td>{{ \Carbon\Carbon::parse($row->journal_date)->format('d/m/Y') }}</td>
                                        <td>
                                            <strong>{{ $row->activity_title }}</strong><br>
                                            <span style="font-size: 8.5pt; color: #475569;">{{ $row->activity_detail }}</span>
                                        </td>
                                        <td>
                                            @if($row->commit_url)
                                                <span style="font-size: 8pt; color: #4f46e5; word-break: break-all;">
                                                    {{ Str::limit($row->commit_url, 38) }}
                                                </span>
                                            @else
                                                <span style="color: #94a3b8; font-size: 8.5pt;">Logbook SIMAK TMS</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                @if($tp2Count === 0)
                                    <tr>
                                        <td colspan="4" style="text-align: center; color: #64748b; padding: 10pt;">Belum ada entri aktivitas teknis tercatat.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- TP 3: Produk Portofolio Karya & Deployment -->
                    <div class="tp-section">
                        <div class="tp-title">
                            Tujuan Pembelajaran 3: Penjaminan Mutu, Pengujian Sistem & Showcase Produk Perangkat Lunak
                            <span class="cp-desc">CP: Peserta didik mampu menguji fitur perangkat lunak, melakukan deployment ke server, serta mempublikasikan portofolio karya aplikasi siap pakai bagi stakeholder industri.</span>
                        </div>
                        <table class="data">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th style="width: 32%;">Judul Karya & Kategori</th>
                                    <th style="width: 28%;">Tech Stack / Komponen</th>
                                    <th style="width: 35%;">Deskripsi Singkat & Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($projects as $p)
                                    <tr>
                                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                                        <td>
                                            <strong style="color: #0f172a;">{{ $p->title }}</strong><br>
                                            <span style="font-size: 8pt; color: #b91c1c; font-weight: 600;">{{ $p->project_category ?? 'Software Project' }}</span>
                                        </td>
                                        <td>
                                            <span style="font-size: 8.5pt; color: #334155;">{{ $p->tech_stack ?? '-' }}</span>
                                        </td>
                                        <td>
                                            <div style="font-size: 8.5pt; color: #334155;">{{ Str::limit($p->short_description ?? $p->full_description, 90) }}</div>
                                            <div style="font-size: 8pt; color: #047857; font-weight: 600; margin-top: 2pt;">
                                                Status: {{ $p->status ?? 'Production Ready' }}
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" style="text-align: center; color: #64748b; padding: 10pt;">Belum ada proyek showcase terdaftar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Tanda Tangan Dual: Sesuai Instruksi User -->
                    <!-- Sisi Kiri: Pembimbing TMS (Mentor Siswa) -->
                    <!-- Sisi Kanan: Nama Siswa / Nama Akun Siswa -->
                    <div class="footer">
                        <table class="signature-table">
                            <tr>
                                <td>
                                    Mengetahui,<br>
                                    <strong>Pembimbing Instansi (Mentor TMS)</strong>
                                    <div class="space"></div>
                                    <strong style="text-decoration: underline;">{{ $mentor->name ?? 'Mentor Pembimbing Industri' }}</strong><br>
                                    <span style="font-size: 9pt; color: #334155;">ID: {{ $mentor->account_id ?? '-' }} &bull; {{ $mentor->headline ?? 'Software Engineer' }}</span>
                                </td>
                                <td>
                                    Tasikmalaya, {{ now()->locale('id')->translatedFormat('d F Y') }}<br>
                                    <strong>Peserta Didik / Praktikan PKL</strong>
                                    <div class="space"></div>
                                    <strong style="text-decoration: underline;">{{ $user->name }}</strong><br>
                                    <span style="font-size: 9pt; color: #334155;">NIS: {{ $user->nis_nim ?? $user->account_id }} (ID Akun: {{ $user->account_id }})</span>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <p class="print-info">Dokumen Portofolio ini digenerate secara otomatis oleh SIMAK-TMS pada {{ now()->locale('id')->translatedFormat('d F Y, H:i') }} WIB.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateZoom() {
            const page = document.querySelector('.page');
            const viewport = document.querySelector('.page-viewport');
            if (!page || !viewport) return;
            
            const screenWidth = viewport.clientWidth;
            const targetWidth = 794; // 210mm at 96dpi
            
            if (window.matchMedia('print').matches) {
                page.style.zoom = 'normal';
                page.style.transform = 'none';
                viewport.style.height = 'auto';
                return;
            }
            
            const isFitMode = document.body.classList.contains('fit-width');
            
            if (isFitMode && screenWidth < targetWidth) {
                const scale = (screenWidth - 24) / targetWidth;
                page.style.zoom = scale;
                const computedZoom = window.getComputedStyle(page).zoom;
                if (computedZoom === undefined || computedZoom === 'normal' || computedZoom == 1) {
                    page.style.transform = `scale(${scale})`;
                    page.style.transformOrigin = 'top center';
                    const scaledHeight = page.offsetHeight * scale;
                    viewport.style.height = `${scaledHeight + 40}px`;
                    page.style.margin = '0 auto';
                } else {
                    page.style.transform = 'none';
                    viewport.style.height = 'auto';
                }
            } else {
                page.style.zoom = 'normal';
                page.style.transform = 'none';
                viewport.style.height = 'auto';
            }
        }

        function handleKembali(e) {
            e.preventDefault();
            window.close();
            setTimeout(function() {
                if (window.history.length > 1) {
                    window.history.back();
                } else {
                    window.location.href = "{{ route('journals.index') }}";
                }
            }, 120);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const btnFit = document.getElementById('btn-toggle-fit');
            const zoomText = document.getElementById('zoom-text');
            
            if (window.innerWidth < 768) {
                document.body.classList.add('fit-width');
                if (zoomText) zoomText.textContent = 'Ukuran Asli';
            } else {
                if (zoomText) zoomText.textContent = 'Fit Lebar';
            }
            
            updateZoom();
            window.addEventListener('resize', updateZoom);
            
            if (btnFit) {
                btnFit.addEventListener('click', function() {
                    const isFit = document.body.classList.toggle('fit-width');
                    if (isFit) {
                        if (zoomText) zoomText.textContent = 'Ukuran Asli';
                    } else {
                        if (zoomText) zoomText.textContent = 'Fit Lebar';
                    }
                    updateZoom();
                });
            }
        });
    </script>
</body>
</html>
