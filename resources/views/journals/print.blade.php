<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pratinjau Cetak: Laporan Jurnal PKL - {{ $user->name }}</title>
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
        .toolbar-left .icon svg { width: 17px; height: 17px; color: #818cf8; }
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
            background: #6366f1;
            color: #fff;
        }
        .btn-primary:hover { background: #4f46e5; transform: translateY(-1px); }
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
            color: #4f46e5;
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
            color: #4338ca;
        }
        .fit-width .btn-zoom-toggle {
            background: #eef2ff;
            border-color: #c7d2fe;
            color: #4f46e5;
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

        /* Academic / Formal Document Styles */
        .j-doc {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            line-height: 1.55;
            color: #0f172a;
        }
        .j-doc .title {
            font-size: 14.5pt;
            font-weight: 700;
            text-align: center;
            letter-spacing: 0.6pt;
            text-transform: uppercase;
            margin: 0 0 2pt 0;
        }
        .j-doc .subtitle {
            font-size: 12.5pt;
            font-weight: 700;
            text-align: center;
            letter-spacing: 0.4pt;
            text-transform: uppercase;
            margin: 0 0 3pt 0;
        }
        .j-doc .meta-line {
            text-align: center;
            font-size: 10.5pt;
            color: #334155;
            margin: 0 0 10pt 0;
        }
        .j-doc .rule {
            border-top: 1.5pt solid #1e293b;
            margin: 0 0 16pt 0;
        }
        .j-doc .section-title {
            font-size: 11.5pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5pt;
            color: #1e293b;
            margin: 18pt 0 4pt 0;
            padding-bottom: 4pt;
            border-bottom: 0.75pt solid #94a3b8;
        }
        .j-doc table.identity {
            width: 100%;
            border-collapse: collapse;
            font-size: 10.5pt;
        }
        .j-doc table.identity td {
            padding: 2pt 0;
            vertical-align: top;
        }
        .j-doc table.identity td.label {
            width: 165pt;
            font-weight: 700;
            color: #334155;
        }
        .j-doc table.identity td.colon {
            width: 12pt;
        }
        .j-doc table.journal {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
            margin-top: 6pt;
        }
        .j-doc table.journal th,
        .j-doc table.journal td {
            border: 0.75pt solid #94a3b8;
            padding: 5pt 6pt;
            vertical-align: top;
            text-align: left;
        }
        .j-doc table.journal th {
            background: #eef2f7;
            font-weight: 700;
            text-align: center;
        }
        .j-doc .weekly-header {
            display: flex;
            justify-content: space-between;
            font-size: 10.5pt;
            font-weight: 700;
            margin-top: 14pt;
            margin-bottom: 4pt;
            color: #1e293b;
            border-bottom: 1pt solid #cbd5e1;
            padding-bottom: 2pt;
        }
        .j-doc .print-info {
            margin-top: 16pt;
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
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <div class="toolbar-title">Pratinjau Cetak: Laporan Jurnal Kegiatan PKL</div>
                <div class="toolbar-sub">Jurnal-PKL-{{ $user->account_id }}.pdf &middot; {{ $jurnals->count() }} entri jurnal tercatat</div>
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
                <span class="chip">{{ $jurnals->count() }} catatan kegiatan</span>
            </div>
        </div>

        <div class="page-viewport">
            <div class="page">
                <div class="j-doc">
                    <p class="title">LAPORAN JURNAL KEGIATAN</p>
                    <p class="subtitle">PRAKTIK KERJA LAPANGAN (PKL)</p>
                    <p class="meta-line">Tahun Ajaran {{ $user->batch->period_year ?? '2025/2026' }}</p>

                    <div class="rule"></div>

                    <table class="identity">
                        <tr>
                            <td class="label">Nama Peserta Didik</td>
                            <td class="colon">:</td>
                            <td><strong>{{ strtoupper($user->name) }}</strong> &nbsp;(NIS: {{ $user->nis_nim ?? $user->account_id }})</td>
                        </tr>
                        <tr>
                            <td class="label">Kelas / Konsentrasi</td>
                            <td class="colon">:</td>
                            <td>{{ $user->major ?? 'PPLG — Rekayasa Perangkat Lunak' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Tempat PKL / Industri</td>
                            <td class="colon">:</td>
                            <td><strong>PT. TEKNOLOGI MULTI SISTEM</strong> (Divisi Software Engineering)</td>
                        </tr>
                        <tr>
                            <td class="label">Pembimbing Sekolah</td>
                            <td class="colon">:</td>
                            <td>Guru Pembimbing Kejuruan ({{ $user->school_origin ?? 'Sekolah Mitra' }})</td>
                        </tr>
                        <tr>
                            <td class="label">Pembimbing Instansi Dunia Kerja</td>
                            <td class="colon">:</td>
                            <td><strong>{{ $mentor->name ?? 'Mentor Pembimbing Industri TMS' }}</strong>{{ ($mentor && $mentor->headline) ? ' ('.$mentor->headline.')' : '' }}</td>
                        </tr>
                    </table>

                    <p class="section-title">DAFTAR KEGIATAN JURNAL</p>

                    @forelse($groupedJurnals as $groupHeader => $rows)
                        @php
                            [$weekText, $monthText] = explode('|', $groupHeader);
                        @endphp

                        <div class="weekly-header">
                            <span>{{ $weekText }}</span>
                            <span>{{ $monthText }}</span>
                        </div>

                        <table class="journal">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th style="width: 15%;">Hari / Tanggal</th>
                                    <th style="width: 42%;">Uraian Kegiatan / Pekerjaan</th>
                                    <th style="width: 18%;">Kompetensi</th>
                                    <th style="width: 20%;">Catatan Pembimbing</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rows as $index => $row)
                                    <tr>
                                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                                        <td>
                                            <strong>{{ \Carbon\Carbon::parse($row->journal_date)->locale('id')->isoFormat('dddd') }}</strong><br>
                                            <span style="color: #475569;">{{ \Carbon\Carbon::parse($row->journal_date)->format('d/m/Y') }}</span>
                                        </td>
                                        <td>
                                            <div style="font-weight: 700; color: #0f172a; margin-bottom: 2pt;">{{ $row->activity_title }}</div>
                                            <div style="font-size: 9.5pt; color: #334155;">{{ $row->activity_detail }}</div>
                                            @if($row->commit_url)
                                                <div style="font-size: 8pt; color: #4f46e5; margin-top: 3pt; word-break: break-all;">
                                                    <strong>Tautan Bukti:</strong> {{ Str::limit($row->commit_url, 45) }}
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <span style="font-size: 9pt; color: #1e293b;">
                                                @if(str_contains(strtolower($row->activity_title), 'orientasi') || str_contains(strtolower($row->activity_title), 'sop') || str_contains(strtolower($row->activity_title), 'briefing'))
                                                    Internalisasi dan penerapan soft skills kerja
                                                @elseif(str_contains(strtolower($row->activity_title), 'api') || str_contains(strtolower($row->activity_title), 'backend'))
                                                    Pengembangan API Backend & Integrasi Sistem
                                                @elseif(str_contains(strtolower($row->activity_title), 'ui') || str_contains(strtolower($row->activity_title), 'blade') || str_contains(strtolower($row->activity_title), 'dashboard'))
                                                    Slicing UI Responsif & Front-End Components
                                                @else
                                                    Rekayasa Perangkat Lunak & Logika Sistem
                                                @endif
                                            </span>
                                        </td>
                                        <td>
                                            @if($row->mentor_feedback)
                                                <span style="font-size: 9pt; color: #047857; font-style: italic;">"{{ $row->mentor_feedback }}"</span>
                                            @else
                                                <span style="color: #94a3b8;">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @empty
                        <table class="journal">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th style="width: 15%;">Hari / Tanggal</th>
                                    <th style="width: 42%;">Uraian Kegiatan / Pekerjaan</th>
                                    <th style="width: 18%;">Kompetensi</th>
                                    <th style="width: 20%;">Catatan Pembimbing</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5" style="text-align: center; padding: 20pt; color: #64748b;">Belum ada entri jurnal yang tercatat.</td>
                                </tr>
                            </tbody>
                        </table>
                    @endforelse

                    <!-- Tanda Tangan Dual: Kiri Pembimbing TMS, Kanan Siswa -->
                    <div style="margin-top: 30pt; page-break-inside: avoid; break-inside: avoid;">
                        <table style="width: 100%; border: none; font-size: 10.5pt;">
                            <tr>
                                <td style="width: 50%; text-align: center; vertical-align: top;">
                                    <p style="margin: 0 0 2pt 0;">Mengetahui,</p>
                                    <p style="margin: 0 0 2pt 0; font-weight: 700;">Pembimbing Instansi Dunia Kerja (TMS)</p>
                                    <div style="height: 55pt;"></div>
                                    <p style="margin: 0; font-weight: 700; text-decoration: underline;">{{ $mentor->name ?? 'Mentor Pembimbing Industri' }}</p>
                                    <p style="margin: 2pt 0 0 0; font-size: 9.5pt; color: #334155;">ID Mentor: {{ $mentor->account_id ?? '-' }} &bull; {{ $mentor->headline ?? 'Software Engineer' }}</p>
                                </td>
                                <td style="width: 50%; text-align: center; vertical-align: top;">
                                    <p style="margin: 0 0 2pt 0;">Tasikmalaya, {{ now()->locale('id')->translatedFormat('d F Y') }}</p>
                                    <p style="margin: 0 0 2pt 0; font-weight: 700;">Peserta Didik / Praktikan PKL</p>
                                    <div style="height: 55pt;"></div>
                                    <p style="margin: 0; font-weight: 700; text-decoration: underline;">{{ $user->name }}</p>
                                    <p style="margin: 2pt 0 0 0; font-size: 9.5pt; color: #334155;">NIS: {{ $user->nis_nim ?? $user->account_id }} (ID Akun: {{ $user->account_id }})</p>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <p class="print-info">Dokumen ini dicetak dari SIMAK-TMS (Sistem Informasi Manajemen Aktivitas & Karya Siswa PKL) pada {{ now()->locale('id')->translatedFormat('d F Y, H:i') }} WIB.</p>
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
