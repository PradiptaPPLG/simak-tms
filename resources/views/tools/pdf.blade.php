@extends('layouts.simak')

@section('title', 'Office & PDF Tools • SIMAK-TMS')

@section('content')
<div class="space-y-6" id="pdf-suite-root">

    <!-- 1. Hero Header Banner -->
    <div class="mas-card p-6 sm:p-8 bg-gradient-to-br from-white via-slate-50 to-red-50/30 border-slate-200">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-lg bg-red-50 border border-red-200 text-red-700 text-[11px] font-bold uppercase tracking-wider">
                    <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                    <span>TMS Office Suite • 100% Client-Side Engine</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-slate-900">
                    Office & PDF Tools
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 max-w-2xl leading-relaxed">
                    Kelola dokumen magang, laporan PKL, dan berkas industri secara instan (Merge, Split, Kompres, Konversi Gambar/Office ke PDF, Rotasi, & Watermark). Seluruh file diproses lokal di browser Anda — aman, cepat, dan tanpa batas ukuran upload server.
                </p>
            </div>

            <!-- Security / Tech Stack Badge -->
            <div class="flex flex-wrap items-center gap-2 self-start lg:self-auto shrink-0">
                <div class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 shadow-2xs flex items-center gap-2">
                    <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600"></i>
                    <div class="text-left">
                        <div class="text-[11px] font-extrabold text-slate-800 leading-none">Privasi Lokal</div>
                        <div class="text-[10px] text-slate-400">Tidak dikirim ke server</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. View Switcher: Catalog Grid vs Active Tool Workspace -->
    <div id="tools-catalog-view" class="space-y-5">

        <!-- Category Filter Tabs -->
        <div class="flex flex-wrap items-center gap-2">
            <button type="button" onclick="filterTools('all')" data-cat="all" class="tool-cat-btn active px-4 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer bg-slate-900 text-white shadow-xs">
                Semua Tools (8)
            </button>
            <button type="button" onclick="filterTools('organize')" data-cat="organize" class="tool-cat-btn px-4 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer bg-white text-slate-600 border border-slate-200 hover:bg-slate-50">
                Organisir PDF
            </button>
            <button type="button" onclick="filterTools('convert')" data-cat="convert" class="tool-cat-btn px-4 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer bg-white text-slate-600 border border-slate-200 hover:bg-slate-50">
                Konversi Dokumen
            </button>
            <button type="button" onclick="filterTools('optimize')" data-cat="optimize" class="tool-cat-btn px-4 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer bg-white text-slate-600 border border-slate-200 hover:bg-slate-50">
                Optimasi & Keamanan
            </button>
        </div>

        <!-- Tool Cards Grid (Ala iLovePDF modern) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4" id="tools-grid">

            <!-- Tool 1: Merge PDF -->
            <button type="button" onclick="openTool('merge')" data-category="organize" class="tool-card group text-left mas-card p-5 hover:border-red-300 hover:shadow-lg hover:-translate-y-0.5 transition-all cursor-pointer flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-600 border border-red-100 flex items-center justify-center mb-4 group-hover:bg-red-600 group-hover:text-white transition-colors">
                        <i data-lucide="layers" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-900 mb-1.5">Gabung PDF (Merge)</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Satukan beberapa file PDF menjadi satu dokumen berurutan sesuai keinginan Anda.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] font-bold text-red-600">
                    <span>Buka Tool</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform"></i>
                </div>
            </button>

            <!-- Tool 2: Split PDF -->
            <button type="button" onclick="openTool('split')" data-category="organize" class="tool-card group text-left mas-card p-5 hover:border-orange-300 hover:shadow-lg hover:-translate-y-0.5 transition-all cursor-pointer flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-orange-50 text-orange-600 border border-orange-100 flex items-center justify-center mb-4 group-hover:bg-orange-600 group-hover:text-white transition-colors">
                        <i data-lucide="scissors" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-900 mb-1.5">Pisah PDF (Split)</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Ekstrak halaman tertentu secara visual atau pecah setiap halaman jadi file PDF terpisah (.ZIP).</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] font-bold text-orange-600">
                    <span>Buka Tool</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform"></i>
                </div>
            </button>

            <!-- Tool 3: Compress PDF -->
            <button type="button" onclick="openTool('compress')" data-category="optimize" class="tool-card group text-left mas-card p-5 hover:border-emerald-300 hover:shadow-lg hover:-translate-y-0.5 transition-all cursor-pointer flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center mb-4 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                        <i data-lucide="minimize-2" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-900 mb-1.5">Kompres PDF</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Perkecil ukuran file PDF scan/dokumen agar ringan diunggah dengan rasio kompresi yang bisa diatur.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] font-bold text-emerald-600">
                    <span>Buka Tool</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform"></i>
                </div>
            </button>

            <!-- Tool 4: PDF to Image -->
            <button type="button" onclick="openTool('pdf2img')" data-category="convert" class="tool-card group text-left mas-card p-5 hover:border-amber-300 hover:shadow-lg hover:-translate-y-0.5 transition-all cursor-pointer flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 border border-amber-100 flex items-center justify-center mb-4 group-hover:bg-amber-600 group-hover:text-white transition-colors">
                        <i data-lucide="image" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-900 mb-1.5">PDF ke Gambar</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Konversi tiap halaman PDF menjadi gambar JPG atau PNG berkualitas HD secara instan.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] font-bold text-amber-600">
                    <span>Buka Tool</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform"></i>
                </div>
            </button>

            <!-- Tool 5: Image to PDF -->
            <button type="button" onclick="openTool('img2pdf')" data-category="convert" class="tool-card group text-left mas-card p-5 hover:border-sky-300 hover:shadow-lg hover:-translate-y-0.5 transition-all cursor-pointer flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 border border-sky-100 flex items-center justify-center mb-4 group-hover:bg-sky-600 group-hover:text-white transition-colors">
                        <i data-lucide="file-image" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-900 mb-1.5">Gambar ke PDF</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Ubah foto dokumentasi kegiatan atau scan JPG/PNG menjadi dokumen PDF A4 siap cetak.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] font-bold text-sky-600">
                    <span>Buka Tool</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform"></i>
                </div>
            </button>

            <!-- Tool 6: Organize & Rotate PDF -->
            <button type="button" onclick="openTool('organize')" data-category="organize" class="tool-card group text-left mas-card p-5 hover:border-indigo-300 hover:shadow-lg hover:-translate-y-0.5 transition-all cursor-pointer flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 border border-indigo-100 flex items-center justify-center mb-4 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                        <i data-lucide="rotate-cw" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-900 mb-1.5">Putar & Hapus Halaman</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Perbaiki orientasi halaman miring (90°/180°) atau hapus halaman yang tidak diperlukan.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] font-bold text-indigo-600">
                    <span>Buka Tool</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform"></i>
                </div>
            </button>

            <!-- Tool 7: Watermark PDF -->
            <button type="button" onclick="openTool('watermark')" data-category="optimize" class="tool-card group text-left mas-card p-5 hover:border-purple-300 hover:shadow-lg hover:-translate-y-0.5 transition-all cursor-pointer flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 border border-purple-100 flex items-center justify-center mb-4 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                        <i data-lucide="stamp" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-900 mb-1.5">Watermark & Stempel</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Tambahkan teks tanda air (watermark) kustom untuk melindungi keaslian dokumen PDF.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] font-bold text-purple-600">
                    <span>Buka Tool</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform"></i>
                </div>
            </button>

            <!-- Tool 8: Office Viewer & Print PDF -->
            <button type="button" onclick="openTool('office')" data-category="convert" class="tool-card group text-left mas-card p-5 hover:border-blue-300 hover:shadow-lg hover:-translate-y-0.5 transition-all cursor-pointer flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center mb-4 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <i data-lucide="file-spreadsheet" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-900 mb-1.5">Office ke PDF / Viewer</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Buka & pratinjau dokumen Word (.DOCX) atau Spreadsheet (.XLSX / .CSV) lalu cetak ke PDF.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] font-bold text-blue-600">
                    <span>Buka Tool</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform"></i>
                </div>
            </button>

        </div>
    </div>

    <!-- 3. Active Tool Workspace Container (Hidden by default) -->
    <div id="tool-workspace-view" class="hidden space-y-5">

        <!-- Workspace Top Bar -->
        <div class="flex flex-wrap items-center justify-between gap-3">
            <button type="button" onclick="closeTool()" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold transition-all cursor-pointer shadow-2xs">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                <span>Kembali ke Katalog Tools</span>
            </button>

            <div class="flex items-center gap-2" id="ws-header-badge">
                <!-- Populated dynamically -->
            </div>
        </div>

        <!-- Main Workspace Card -->
        <div class="mas-card p-6 sm:p-8 space-y-6">

            <!-- Title & Description -->
            <div class="border-b border-slate-100 pb-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3.5">
                    <div id="ws-icon-box" class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0"></div>
                    <div>
                        <h2 id="ws-title" class="text-xl font-black text-slate-900">Tool Name</h2>
                        <p id="ws-desc" class="text-xs text-slate-500 mt-0.5">Tool description here</p>
                    </div>
                </div>
                <button type="button" onclick="resetCurrentTool()" id="btn-ws-reset" class="hidden px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors flex items-center gap-1.5 cursor-pointer self-start sm:self-auto">
                    <i data-lucide="refresh-cw" class="w-3.5 h-3.5"></i>
                    <span>Ulangi / Pilih File Baru</span>
                </button>
            </div>

            <!-- Drag & Drop Zone -->
            <div id="ws-dropzone" class="border-2 border-dashed border-slate-300 hover:border-red-400 bg-slate-50/70 hover:bg-red-50/20 rounded-2xl p-8 sm:p-12 text-center transition-all cursor-pointer relative">
                <input type="file" id="ws-file-input" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                <div class="w-16 h-16 rounded-2xl bg-white border border-slate-200 shadow-xs flex items-center justify-center mx-auto mb-4 text-red-600">
                    <i data-lucide="upload-cloud" class="w-8 h-8"></i>
                </div>
                <h3 class="text-base font-extrabold text-slate-900 mb-1">Klik atau Tarik & Lepas File di Sini</h3>
                <p id="ws-accept-label" class="text-xs text-slate-500">Mendukung format PDF</p>
                <div class="mt-4 inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-slate-900 text-white text-xs font-bold shadow-xs">
                    <i data-lucide="folder-open" class="w-3.5 h-3.5"></i>
                    <span>Pilih File dari Komputer</span>
                </div>
            </div>

            <!-- Dynamic Tool Controls & Preview Area -->
            <div id="ws-body" class="hidden space-y-6">
                <!-- Populated by JS per active tool -->
            </div>

            <!-- Live Progress Bar (Worker Background Processing) -->
            <div id="ws-progress-wrap" class="hidden p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                <div class="flex items-center justify-between text-xs font-bold text-slate-700">
                    <span id="ws-progress-label" class="flex items-center gap-2">
                        <i data-lucide="cpu" class="w-3.5 h-3.5 text-indigo-600 animate-pulse"></i>
                        <span>Memproses di background worker...</span>
                    </span>
                    <span id="ws-progress-pct" class="font-mono text-indigo-600">0%</span>
                </div>
                <div class="w-full h-2.5 bg-slate-200 rounded-full overflow-hidden">
                    <div id="ws-progress-bar" class="h-full bg-gradient-to-r from-indigo-600 to-purple-600 rounded-full transition-all duration-200" style="width: 0%"></div>
                </div>
            </div>

            <!-- Status / Progress Feedback -->
            <div id="ws-status" class="hidden p-4 rounded-xl border text-xs font-semibold flex items-center gap-3"></div>

        </div>
    </div>

</div>

<!-- External Open-Source Client-Side Libraries (Local Same-Origin for Ultra-Fast Speed & Zero CORS) -->
<script src="{{ asset('vendor/pdf-tools/pdf-lib.min.js') }}"></script>
<script src="{{ asset('vendor/pdf-tools/pdf.min.js') }}"></script>
<script src="{{ asset('vendor/pdf-tools/jszip.min.js') }}"></script>
<script src="{{ asset('vendor/pdf-tools/xlsx.full.min.js') }}"></script>
<script src="{{ asset('vendor/pdf-tools/mammoth.browser.min.js') }}"></script>

<script>
    // Configure PDF.js Worker (Same-origin local worker = true multi-threaded speed)
    if (window.pdfjsLib) {
        pdfjsLib.GlobalWorkerOptions.workerSrc = "{{ asset('vendor/pdf-tools/pdf.worker.min.js') }}";
    }

    const TOOL_META = {
        merge: {
            title: 'Gabung PDF (Merge)',
            desc: 'Pilih 2 atau lebih file PDF, atur urutannya, lalu gabungkan menjadi 1 PDF utuh.',
            accept: '.pdf,application/pdf',
            multiple: true,
            acceptLabel: 'Pilih 2+ file PDF (.pdf) sekaligus atau tambahkan satu per satu',
            icon: 'layers',
            iconClass: 'bg-red-50 text-red-600 border border-red-100'
        },
        split: {
            title: 'Pisah PDF (Split & Extract)',
            desc: 'Klik halaman yang ingin diambil secara visual atau pecah setiap halaman jadi file terpisah.',
            accept: '.pdf,application/pdf',
            multiple: false,
            acceptLabel: 'Pilih 1 file PDF (.pdf)',
            icon: 'scissors',
            iconClass: 'bg-orange-50 text-orange-600 border border-orange-100'
        },
        compress: {
            title: 'Kompres & Optimasi PDF',
            desc: 'Kecilkan ukuran file PDF agar mudah diunggah dengan optimasi struktur atau rasterize gambar.',
            accept: '.pdf,application/pdf',
            multiple: false,
            acceptLabel: 'Pilih 1 file PDF (.pdf)',
            icon: 'minimize-2',
            iconClass: 'bg-emerald-50 text-emerald-600 border border-emerald-100'
        },
        pdf2img: {
            title: 'Konversi PDF ke Gambar (PNG/JPG)',
            desc: 'Ubah setiap halaman PDF menjadi gambar beresolusi tinggi dan unduh sebagai PNG/JPG atau ZIP.',
            accept: '.pdf,application/pdf',
            multiple: false,
            acceptLabel: 'Pilih 1 file PDF (.pdf)',
            icon: 'image',
            iconClass: 'bg-amber-50 text-amber-600 border border-amber-100'
        },
        img2pdf: {
            title: 'Konversi Gambar ke PDF',
            desc: 'Gabungkan beberapa foto JPG/PNG/WebP menjadi 1 file PDF rapi dengan ukuran kertas A4/Fit.',
            accept: 'image/png,image/jpeg,image/jpg,image/webp',
            multiple: true,
            acceptLabel: 'Pilih gambar (.jpg, .png, .webp) — bisa lebih dari 1',
            icon: 'file-image',
            iconClass: 'bg-sky-50 text-sky-600 border border-sky-100'
        },
        organize: {
            title: 'Putar & Hapus Halaman PDF',
            desc: 'Putar halaman miring (90°/180°/270°) atau hapus halaman yang tidak diperlukan.',
            accept: '.pdf,application/pdf',
            multiple: false,
            acceptLabel: 'Pilih 1 file PDF (.pdf)',
            icon: 'rotate-cw',
            iconClass: 'bg-indigo-50 text-indigo-600 border border-indigo-100'
        },
        watermark: {
            title: 'Watermark & Stempel PDF',
            desc: 'Beri tanda air teks (diagonal/mendatar) di seluruh halaman PDF Anda.',
            accept: '.pdf,application/pdf',
            multiple: false,
            acceptLabel: 'Pilih 1 file PDF (.pdf)',
            icon: 'stamp',
            iconClass: 'bg-purple-50 text-purple-600 border border-purple-100'
        },
        office: {
            title: 'Office Reader & Cetak ke PDF',
            desc: 'Buka dokumen Word (.docx) atau Excel (.xlsx / .csv) dengan rapi dan cetak langsung sebagai PDF.',
            accept: '.docx,.xlsx,.xls,.csv',
            multiple: false,
            acceptLabel: 'Mendukung file Microsoft Word (.docx) dan Excel/CSV (.xlsx, .xls, .csv)',
            icon: 'file-spreadsheet',
            iconClass: 'bg-blue-50 text-blue-600 border border-blue-100'
        }
    };

    let activeTool = null;
    let state = {
        files: [],        // { file, name, size, bytes, pageCount, previewUrl }
        pages: [],        // For split/organize: { pageNum, thumbUrl, rotation, selected, deleted }
        renderedImgs: [], // For pdf2img: { pageNum, dataUrl, ext }
        singleFile: null
    };

    // Format Bytes Helper
    function formatBytes(bytes) {
        if (bytes === 0) return '0 B';
        const k = 1024;
        const sizes = ['B', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Download Blob Helper
    function downloadBlob(blob, filename) {
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = filename;
        document.body.appendChild(a);
        a.click();
        a.remove();
        setTimeout(() => URL.revokeObjectURL(url), 1500);
    }

    // Progress Bar & Background Web Worker Helper
    function setProgress(percent, label) {
        const wrap = document.getElementById('ws-progress-wrap');
        if (percent === null || percent === undefined) {
            if (wrap) wrap.classList.add('hidden');
            return;
        }
        if (wrap) wrap.classList.remove('hidden');
        const bar = document.getElementById('ws-progress-bar');
        const pct = document.getElementById('ws-progress-pct');
        const lbl = document.getElementById('ws-progress-label');
        if (bar) bar.style.width = `${Math.min(100, Math.max(0, percent))}%`;
        if (pct) pct.textContent = `${Math.round(percent)}%`;
        if (lbl && label) {
            lbl.innerHTML = `<i data-lucide="cpu" class="w-3.5 h-3.5 text-indigo-600 animate-pulse"></i><span>${label}</span>`;
            lucide.createIcons();
        }
    }

    function runPdfWorkerTask(action, payload) {
        return new Promise((resolve, reject) => {
            const worker = new Worker("{{ asset('vendor/pdf-tools/pdf-worker.js') }}");
            const taskId = Date.now();
            setProgress(5, 'Menjalankan background worker...');
            worker.onmessage = function(e) {
                const msg = e.data;
                if (msg.type === 'progress') {
                    setProgress(msg.percent, msg.label);
                } else if (msg.type === 'done') {
                    setTimeout(() => setProgress(null), 500);
                    worker.terminate();
                    resolve(msg.result);
                } else if (msg.type === 'error') {
                    setProgress(null);
                    worker.terminate();
                    reject(new Error(msg.error));
                }
            };
            worker.onerror = function(err) {
                setProgress(null);
                worker.terminate();
                reject(new Error(err.message || 'Worker gagal dijalankan.'));
            };
            worker.postMessage({ taskId, action, payload });
        });
    }

    // Status Banner Helper
    function setStatus(type, msg) {
        if (type !== 'loading') setProgress(null);
        const el = document.getElementById('ws-status');
        if (!msg) {
            el.classList.add('hidden');
            return;
        }
        el.classList.remove('hidden', 'bg-blue-50', 'border-blue-200', 'text-blue-700', 'bg-emerald-50', 'border-emerald-200', 'text-emerald-700', 'bg-red-50', 'border-red-200', 'text-red-700');
        let icon = 'info';
        if (type === 'loading') {
            el.classList.add('bg-blue-50', 'border-blue-200', 'text-blue-700');
            icon = 'loader-2';
        } else if (type === 'success') {
            el.classList.add('bg-emerald-50', 'border-emerald-200', 'text-emerald-700');
            icon = 'check-circle-2';
        } else {
            el.classList.add('bg-red-50', 'border-red-200', 'text-red-700');
            icon = 'alert-circle';
        }
        el.innerHTML = `<i data-lucide="${icon}" class="w-4 h-4 shrink-0 ${type === 'loading' ? 'animate-spin' : ''}"></i><span>${msg}</span>`;
        lucide.createIcons();
    }

    // Category Filtering
    function filterTools(category) {
        document.querySelectorAll('.tool-cat-btn').forEach(btn => {
            if (btn.dataset.cat === category) {
                btn.className = 'tool-cat-btn active px-4 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer bg-slate-900 text-white shadow-xs';
            } else {
                btn.className = 'tool-cat-btn px-4 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer bg-white text-slate-600 border border-slate-200 hover:bg-slate-50';
            }
        });
        document.querySelectorAll('.tool-card').forEach(card => {
            if (category === 'all' || card.dataset.category === category) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        });
    }

    // Open & Close Tool Workspace
    function openTool(toolId) {
        activeTool = toolId;
        const meta = TOOL_META[toolId];
        document.getElementById('tools-catalog-view').classList.add('hidden');
        document.getElementById('tool-workspace-view').classList.remove('hidden');

        document.getElementById('ws-title').textContent = meta.title;
        document.getElementById('ws-desc').textContent = meta.desc;
        document.getElementById('ws-accept-label').textContent = meta.acceptLabel;

        const iconBox = document.getElementById('ws-icon-box');
        iconBox.className = `w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 ${meta.iconClass}`;
        iconBox.innerHTML = `<i data-lucide="${meta.icon}" class="w-6 h-6"></i>`;

        const input = document.getElementById('ws-file-input');
        input.accept = meta.accept;
        input.multiple = meta.multiple;
        input.value = '';

        resetCurrentTool();
        lucide.createIcons();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function closeTool() {
        activeTool = null;
        document.getElementById('tool-workspace-view').classList.add('hidden');
        document.getElementById('tools-catalog-view').classList.remove('hidden');
        resetCurrentTool();
    }

    function resetCurrentTool() {
        state = { files: [], pages: [], renderedImgs: [], singleFile: null };
        document.getElementById('ws-file-input').value = '';
        document.getElementById('ws-dropzone').classList.remove('hidden');
        document.getElementById('ws-body').classList.add('hidden');
        document.getElementById('ws-body').innerHTML = '';
        document.getElementById('btn-ws-reset').classList.add('hidden');
        setStatus(null, '');
    }

    // Drag & Drop Highlight + File Input Listener
    const dropzone = document.getElementById('ws-dropzone');
    const fileInput = document.getElementById('ws-file-input');

    dropzone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropzone.classList.add('border-red-500', 'bg-red-50/40');
    });
    dropzone.addEventListener('dragleave', () => {
        dropzone.classList.remove('border-red-500', 'bg-red-50/40');
    });
    dropzone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropzone.classList.remove('border-red-500', 'bg-red-50/40');
        if (e.dataTransfer.files.length) {
            handleFiles(e.dataTransfer.files);
        }
    });
    fileInput.addEventListener('change', (e) => {
        if (e.target.files.length) {
            handleFiles(e.target.files);
            e.target.value = '';
        }
    });

    async function handleFiles(fileList) {
        if (!activeTool) return;
        const filesArr = Array.from(fileList);

        try {
            if (activeTool === 'merge') {
                setStatus('loading', 'Membaca file PDF...');
                for (const f of filesArr) {
                    if (!f.name.toLowerCase().endsWith('.pdf')) continue;
                    const bytes = await f.arrayBuffer();
                    const pdfDoc = await PDFLib.PDFDocument.load(bytes, { ignoreEncryption: true });
                    state.files.push({
                        file: f,
                        name: f.name,
                        size: f.size,
                        bytes: bytes,
                        pageCount: pdfDoc.getPageCount()
                    });
                }
                setStatus(null, '');
                if (state.files.length === 0) return setStatus('error', 'Harap pilih file PDF yang valid.');
                renderMergeUI();
            }
            else if (activeTool === 'img2pdf') {
                for (const f of filesArr) {
                    if (!f.type.startsWith('image/')) continue;
                    const dataUrl = await readFileAsDataURL(f);
                    state.files.push({ file: f, name: f.name, size: f.size, dataUrl });
                }
                if (state.files.length === 0) return setStatus('error', 'Harap pilih file gambar JPG/PNG/WebP.');
                renderImg2PdfUI();
            }
            else if (activeTool === 'split' || activeTool === 'organize') {
                const f = filesArr[0];
                if (!f.name.toLowerCase().endsWith('.pdf')) return setStatus('error', 'Harap pilih file PDF.');
                await loadSinglePdfWithThumbnails(f, activeTool);
            }
            else if (activeTool === 'compress') {
                const f = filesArr[0];
                if (!f.name.toLowerCase().endsWith('.pdf')) return setStatus('error', 'Harap pilih file PDF.');
                const bytes = await f.arrayBuffer();
                const pdfDoc = await PDFLib.PDFDocument.load(bytes, { ignoreEncryption: true });
                state.singleFile = { file: f, name: f.name, size: f.size, bytes, pageCount: pdfDoc.getPageCount() };
                renderCompressUI();
            }
            else if (activeTool === 'pdf2img') {
                const f = filesArr[0];
                if (!f.name.toLowerCase().endsWith('.pdf')) return setStatus('error', 'Harap pilih file PDF.');
                const bytes = await f.arrayBuffer();
                state.singleFile = { file: f, name: f.name, size: f.size, bytes };
                renderPdf2ImgUI();
            }
            else if (activeTool === 'watermark') {
                const f = filesArr[0];
                if (!f.name.toLowerCase().endsWith('.pdf')) return setStatus('error', 'Harap pilih file PDF.');
                const bytes = await f.arrayBuffer();
                const pdfDoc = await PDFLib.PDFDocument.load(bytes, { ignoreEncryption: true });
                state.singleFile = { file: f, name: f.name, size: f.size, bytes, pageCount: pdfDoc.getPageCount() };
                renderWatermarkUI();
            }
            else if (activeTool === 'office') {
                const f = filesArr[0];
                await handleOfficeFile(f);
            }
        } catch (err) {
            console.error(err);
            setStatus('error', 'Gagal memproses file: ' + (err.message || 'Format file tidak didukung atau terenkripsi.'));
        }
    }

    function readFileAsDataURL(file) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onload = () => resolve(reader.result);
            reader.onerror = reject;
            reader.readAsDataURL(file);
        });
    }

    function showWorkspaceBody() {
        document.getElementById('ws-dropzone').classList.add('hidden');
        document.getElementById('ws-body').classList.remove('hidden');
        document.getElementById('btn-ws-reset').classList.remove('hidden');
    }

    // =========================================================================
    // 1. MERGE PDF
    // =========================================================================
    function renderMergeUI() {
        showWorkspaceBody();
        const body = document.getElementById('ws-body');
        const listHtml = state.files.map((item, idx) => `
            <div class="flex items-center justify-between gap-3 p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-9 h-9 rounded-lg bg-red-100 text-red-600 font-black text-xs flex items-center justify-center shrink-0">${idx + 1}</div>
                    <div class="min-w-0">
                        <div class="text-xs font-bold text-slate-900 truncate">${item.name}</div>
                        <div class="text-[11px] text-slate-500">${item.pageCount} halaman • ${formatBytes(item.size)}</div>
                    </div>
                </div>
                <div class="flex items-center gap-1 shrink-0">
                    <button type="button" onclick="moveMergeFile(${idx}, -1)" ${idx === 0 ? 'disabled' : ''} class="p-1.5 rounded-lg bg-white border border-slate-200 text-slate-600 hover:bg-slate-100 disabled:opacity-40 cursor-pointer" title="Naikkan">
                        <i data-lucide="arrow-up" class="w-3.5 h-3.5"></i>
                    </button>
                    <button type="button" onclick="moveMergeFile(${idx}, 1)" ${idx === state.files.length - 1 ? 'disabled' : ''} class="p-1.5 rounded-lg bg-white border border-slate-200 text-slate-600 hover:bg-slate-100 disabled:opacity-40 cursor-pointer" title="Turunkan">
                        <i data-lucide="arrow-down" class="w-3.5 h-3.5"></i>
                    </button>
                    <button type="button" onclick="removeMergeFile(${idx})" class="p-1.5 rounded-lg bg-white border border-red-200 text-red-600 hover:bg-red-50 cursor-pointer" title="Hapus">
                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                    </button>
                </div>
            </div>
        `).join('');

        body.innerHTML = `
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div class="text-xs font-bold text-slate-700">Daftar File PDF (${state.files.length} file • Total ${state.files.reduce((a, b) => a + b.pageCount, 0)} halaman)</div>
                <label class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold cursor-pointer inline-flex items-center gap-1.5 transition-colors">
                    <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                    <span>Tambah PDF Lagi</span>
                    <input type="file" accept=".pdf" multiple class="hidden" onchange="if(this.files.length) handleFiles(this.files)" />
                </label>
            </div>
            <div class="space-y-2.5">${listHtml}</div>
            <div class="pt-2 flex flex-wrap items-center justify-end gap-3">
                <button type="button" onclick="executeMerge()" ${state.files.length < 2 ? 'disabled' : ''} class="px-6 py-3 rounded-xl bg-red-600 hover:bg-red-700 disabled:bg-slate-300 text-white text-xs font-extrabold transition-all shadow-md shadow-red-600/20 flex items-center gap-2 cursor-pointer">
                    <i data-lucide="layers" class="w-4 h-4"></i>
                    <span>Gabung & Unduh PDF</span>
                </button>
            </div>
        `;
        lucide.createIcons();
    }

    function moveMergeFile(idx, dir) {
        const target = idx + dir;
        if (target < 0 || target >= state.files.length) return;
        [state.files[idx], state.files[target]] = [state.files[target], state.files[idx]];
        renderMergeUI();
    }

    function removeMergeFile(idx) {
        state.files.splice(idx, 1);
        if (state.files.length === 0) resetCurrentTool();
        else renderMergeUI();
    }

    async function executeMerge() {
        try {
            setStatus('loading', 'Menggabungkan halaman PDF di background worker...');
            const filesPayload = state.files.map(item => item.bytes.slice(0));
            const res = await runPdfWorkerTask('merge', { files: filesPayload });
            downloadBlob(new Blob([res.bytes], { type: 'application/pdf' }), 'merged_simak_tms.pdf');
            setStatus('success', `Berhasil menggabungkan ${state.files.length} file PDF!`);
        } catch (err) {
            setStatus('error', 'Gagal menggabungkan PDF: ' + err.message);
        }
    }

    // =========================================================================
    // 2. SPLIT & 6. ORGANIZE (Visual Page Thumbnails with PDF.js)
    // =========================================================================
    async function loadSinglePdfWithThumbnails(file, mode) {
        setStatus('loading', 'Merender pratinjau halaman PDF...');
        const bytes = await file.arrayBuffer();
        const pdf = await pdfjsLib.getDocument({ data: bytes.slice(0) }).promise;

        state.singleFile = { file, name: file.name, size: file.size, bytes, pageCount: pdf.numPages };
        state.pages = [];

        const maxPreviewPages = Math.min(pdf.numPages, 40);
        for (let i = 1; i <= pdf.numPages; i++) {
            let thumbUrl = null;
            if (i <= maxPreviewPages) {
                const page = await pdf.getPage(i);
                const viewport = page.getViewport({ scale: 0.3 });
                const canvas = document.createElement('canvas');
                canvas.width = viewport.width;
                canvas.height = viewport.height;
                await page.render({ canvasContext: canvas.getContext('2d'), viewport }).promise;
                thumbUrl = canvas.toDataURL('image/jpeg', 0.72);
            }
            state.pages.push({ pageNum: i, thumbUrl, rotation: 0, selected: true, deleted: false });
        }

        setStatus(null, '');
        if (mode === 'split') renderSplitUI();
        else renderOrganizeUI();
    }

    function renderSplitUI() {
        showWorkspaceBody();
        const body = document.getElementById('ws-body');
        const selectedCount = state.pages.filter(p => p.selected).length;

        const gridHtml = state.pages.map((p, idx) => `
            <div onclick="toggleSplitPage(${idx})" class="cursor-pointer rounded-xl border-2 p-2 text-center transition-all ${p.selected ? 'border-orange-500 bg-orange-50/40' : 'border-slate-200 bg-white opacity-60 hover:opacity-100'}">
                <div class="relative bg-slate-100 rounded-lg overflow-hidden aspect-[3/4] flex items-center justify-center mb-1.5">
                    ${p.thumbUrl ? `<img src="${p.thumbUrl}" class="w-full h-full object-contain" />` : `<span class="text-xs font-bold text-slate-400">Hal ${p.pageNum}</span>`}
                    <div class="absolute top-1.5 right-1.5 w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold ${p.selected ? 'bg-orange-600 text-white' : 'bg-white border border-slate-300 text-slate-400'}">
                        ${p.selected ? '✓' : ''}
                    </div>
                </div>
                <span class="text-[11px] font-bold text-slate-700">Halaman ${p.pageNum}</span>
            </div>
        `).join('');

        body.innerHTML = `
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <div class="text-xs font-extrabold text-slate-900">${state.singleFile.name}</div>
                    <div class="text-[11px] text-slate-500">${state.singleFile.pageCount} halaman • ${selectedCount} halaman dipilih</div>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <button type="button" onclick="selectAllSplit(true)" class="px-3 py-1.5 rounded-lg bg-white border border-slate-200 text-[11px] font-bold text-slate-700 hover:bg-slate-100 cursor-pointer">Pilih Semua</button>
                    <button type="button" onclick="selectAllSplit(false)" class="px-3 py-1.5 rounded-lg bg-white border border-slate-200 text-[11px] font-bold text-slate-700 hover:bg-slate-100 cursor-pointer">Kosongkan</button>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-3 max-h-[420px] overflow-y-auto p-1">${gridHtml}</div>

            <div class="pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3">
                <button type="button" onclick="executeSplitZip()" class="px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-black text-white text-xs font-bold transition-all flex items-center gap-2 cursor-pointer">
                    <i data-lucide="archive" class="w-4 h-4"></i>
                    <span>Pecah Semua Jadi File Terpisah (.ZIP)</span>
                </button>
                <button type="button" onclick="executeExtractSelected()" ${selectedCount === 0 ? 'disabled' : ''} class="px-6 py-2.5 rounded-xl bg-orange-600 hover:bg-orange-700 disabled:bg-slate-300 text-white text-xs font-extrabold transition-all shadow-md shadow-orange-600/20 flex items-center gap-2 cursor-pointer">
                    <i data-lucide="scissors" class="w-4 h-4"></i>
                    <span>Ekstrak ${selectedCount} Halaman Terpilih (1 PDF)</span>
                </button>
            </div>
        `;
        lucide.createIcons();
    }

    function toggleSplitPage(idx) {
        state.pages[idx].selected = !state.pages[idx].selected;
        renderSplitUI();
    }
    function selectAllSplit(val) {
        state.pages.forEach(p => p.selected = val);
        renderSplitUI();
    }

    async function executeExtractSelected() {
        try {
            const indices = state.pages.filter(p => p.selected).map(p => p.pageNum - 1);
            if (!indices.length) return;
            setStatus('loading', 'Mengekstrak halaman terpilih...');
            const srcDoc = await PDFLib.PDFDocument.load(state.singleFile.bytes, { ignoreEncryption: true });
            const outDoc = await PDFLib.PDFDocument.create();
            const copied = await outDoc.copyPages(srcDoc, indices);
            copied.forEach(p => outDoc.addPage(p));
            const outBytes = await outDoc.save();
            downloadBlob(new Blob([outBytes], { type: 'application/pdf' }), `extracted_${state.singleFile.name}`);
            setStatus('success', `Berhasil mengekstrak ${indices.length} halaman menjadi PDF baru!`);
        } catch (err) {
            setStatus('error', 'Gagal mengekstrak halaman: ' + err.message);
        }
    }

    async function executeSplitZip() {
        try {
            setStatus('loading', 'Memecah setiap halaman menjadi file terpisah (.ZIP)...');
            const srcDoc = await PDFLib.PDFDocument.load(state.singleFile.bytes, { ignoreEncryption: true });
            const zip = new JSZip();
            const baseName = state.singleFile.name.replace(/\.pdf$/i, '');
            for (let i = 0; i < srcDoc.getPageCount(); i++) {
                const singleDoc = await PDFLib.PDFDocument.create();
                const [page] = await singleDoc.copyPages(srcDoc, [i]);
                singleDoc.addPage(page);
                const bytes = await singleDoc.save();
                zip.file(`${baseName}_hal_${i + 1}.pdf`, bytes);
            }
            const zipBlob = await zip.generateAsync({ type: 'blob' });
            downloadBlob(zipBlob, `${baseName}_split_pages.zip`);
            setStatus('success', `Berhasil memecah ${srcDoc.getPageCount()} halaman ke dalam arsip ZIP!`);
        } catch (err) {
            setStatus('error', 'Gagal memecah PDF: ' + err.message);
        }
    }

    // =========================================================================
    // 3. COMPRESS PDF
    // =========================================================================
    function renderCompressUI() {
        showWorkspaceBody();
        const body = document.getElementById('ws-body');
        body.innerHTML = `
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                <div>
                    <div class="text-xs font-extrabold text-slate-900">${state.singleFile.name}</div>
                    <div class="text-[11px] text-slate-500">Ukuran Asli: <strong class="text-slate-900">${formatBytes(state.singleFile.size)}</strong> • ${state.singleFile.pageCount} halaman</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <label id="lbl-comp-raster" class="p-4 rounded-xl border-2 border-emerald-500 bg-emerald-50/30 cursor-pointer flex items-start gap-3 transition-all">
                    <input type="radio" name="compress_mode" value="raster" checked onchange="toggleCompressMode('raster')" class="mt-1 accent-emerald-600" />
                    <div>
                        <div class="text-xs font-extrabold text-slate-900">Kompresi Cerdas (Rekomendasi untuk Scan/Foto)</div>
                        <div class="text-[11px] text-slate-500 mt-1">Mengompres ulang resolusi & kualitas gambar di tiap halaman sehingga ukuran turun drastis (hingga 50–85%).</div>
                    </div>
                </label>
                <label id="lbl-comp-lossless" class="p-4 rounded-xl border border-slate-200 bg-white cursor-pointer flex items-start gap-3 transition-all">
                    <input type="radio" name="compress_mode" value="lossless" onchange="toggleCompressMode('lossless')" class="mt-1 accent-emerald-600" />
                    <div>
                        <div class="text-xs font-extrabold text-slate-900">Optimasi Struktur (Teks Tetap Tajam 100%)</div>
                        <div class="text-[11px] text-slate-500 mt-1">Membersihkan metadata berlebih dan memampatkan object stream PDF tanpa mengubah teks jadi gambar.</div>
                    </div>
                </label>
            </div>

            <div id="compress-quality-box" class="p-4 rounded-xl bg-white border border-slate-200 space-y-2">
                <div class="flex items-center justify-between text-xs font-bold text-slate-700">
                    <span>Tingkat Kompresi / Kualitas Gambar</span>
                    <span id="compress-q-label" class="text-emerald-600 font-extrabold">Sedang (Kualitas 65% • Scale 1.3x)</span>
                </div>
                <input type="range" id="compress-q-range" min="1" max="3" value="2" class="w-full accent-emerald-600" oninput="updateCompressLabel(this.value)" />
                <div class="flex justify-between text-[10px] text-slate-400 font-semibold">
                    <span>Ukuran Terkecil (45%)</span>
                    <span>Seimbang (65%)</span>
                    <span>Kualitas Tinggi (82%)</span>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="button" onclick="executeCompress()" class="px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-extrabold transition-all shadow-md shadow-emerald-600/20 flex items-center gap-2 cursor-pointer">
                    <i data-lucide="minimize-2" class="w-4 h-4"></i>
                    <span>Kompres & Unduh PDF</span>
                </button>
            </div>
        `;
        lucide.createIcons();
    }

    function toggleCompressMode(mode) {
        const box = document.getElementById('compress-quality-box');
        const lRaster = document.getElementById('lbl-comp-raster');
        const lLoss = document.getElementById('lbl-comp-lossless');
        if (mode === 'raster') {
            box.classList.remove('hidden');
            lRaster.className = 'p-4 rounded-xl border-2 border-emerald-500 bg-emerald-50/30 cursor-pointer flex items-start gap-3 transition-all';
            lLoss.className = 'p-4 rounded-xl border border-slate-200 bg-white cursor-pointer flex items-start gap-3 transition-all';
        } else {
            box.classList.add('hidden');
            lRaster.className = 'p-4 rounded-xl border border-slate-200 bg-white cursor-pointer flex items-start gap-3 transition-all';
            lLoss.className = 'p-4 rounded-xl border-2 border-emerald-500 bg-emerald-50/30 cursor-pointer flex items-start gap-3 transition-all';
        }
    }

    function updateCompressLabel(val) {
        const lbl = document.getElementById('compress-q-label');
        if (val == 1) lbl.textContent = 'Ekstrem (Kualitas 45% • Scale 1.0x)';
        else if (val == 2) lbl.textContent = 'Sedang (Kualitas 65% • Scale 1.3x)';
        else lbl.textContent = 'Ringan (Kualitas 82% • Scale 1.6x)';
    }

    async function executeCompress() {
        try {
            const mode = document.querySelector('input[name="compress_mode"]:checked').value;
            let outBytes;

            if (mode === 'lossless') {
                setStatus('loading', 'Mengoptimalkan struktur object stream PDF...');
                const srcDoc = await PDFLib.PDFDocument.load(state.singleFile.bytes, { ignoreEncryption: true });
                srcDoc.setTitle('');
                srcDoc.setAuthor('');
                srcDoc.setSubject('');
                srcDoc.setKeywords([]);
                srcDoc.setProducer('SIMAK-TMS PDF Optimizer');
                outBytes = await srcDoc.save({ useObjectStreams: true });
            } else {
                const level = parseInt(document.getElementById('compress-q-range').value);
                const scale = level === 1 ? 1.0 : (level === 2 ? 1.3 : 1.6);
                const quality = level === 1 ? 0.45 : (level === 2 ? 0.65 : 0.82);

                const pdf = await pdfjsLib.getDocument({ data: state.singleFile.bytes.slice(0) }).promise;
                const newPdf = await PDFLib.PDFDocument.create();

                for (let i = 1; i <= pdf.numPages; i++) {
                    setStatus('loading', `Mengompres halaman ${i} dari ${pdf.numPages}...`);
                    const page = await pdf.getPage(i);
                    const origVp = page.getViewport({ scale: 1.0 });
                    const renderVp = page.getViewport({ scale: scale });
                    const canvas = document.createElement('canvas');
                    canvas.width = renderVp.width;
                    canvas.height = renderVp.height;
                    await page.render({ canvasContext: canvas.getContext('2d'), viewport: renderVp }).promise;

                    const jpgDataUrl = canvas.toDataURL('image/jpeg', quality);
                    const jpgImage = await newPdf.embedJpg(jpgDataUrl);
                    const newPage = newPdf.addPage([origVp.width, origVp.height]);
                    newPage.drawImage(jpgImage, { x: 0, y: 0, width: origVp.width, height: origVp.height });
                }
                outBytes = await newPdf.save({ useObjectStreams: true });
            }

            const origSize = state.singleFile.size;
            const newSize = outBytes.byteLength;
            const diffPct = Math.round(((origSize - newSize) / origSize) * 100);
            const infoText = diffPct > 0
                ? `Berhasil dikompres dari ${formatBytes(origSize)} → ${formatBytes(newSize)} (Hemat ${diffPct}%)!`
                : `Optimasi selesai (${formatBytes(newSize)}). File asli sudah sangat terkompresi.`;

            downloadBlob(new Blob([outBytes], { type: 'application/pdf' }), `compressed_${state.singleFile.name}`);
            setStatus('success', infoText);
        } catch (err) {
            setStatus('error', 'Gagal mengompres PDF: ' + err.message);
        }
    }

    // =========================================================================
    // 4. PDF TO IMAGE
    // =========================================================================
    function renderPdf2ImgUI() {
        showWorkspaceBody();
        const body = document.getElementById('ws-body');
        body.innerHTML = `
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex flex-wrap items-center justify-between gap-4">
                <div>
                    <div class="text-xs font-extrabold text-slate-900">${state.singleFile.name}</div>
                    <div class="text-[11px] text-slate-500">Ukuran: ${formatBytes(state.singleFile.size)}</div>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <select id="p2i-format" class="px-3 py-2 rounded-xl border border-slate-200 bg-white text-xs font-bold text-slate-700">
                        <option value="png">Format: PNG (Tajam)</option>
                        <option value="jpeg">Format: JPG (Ringan)</option>
                    </select>
                    <select id="p2i-scale" class="px-3 py-2 rounded-xl border border-slate-200 bg-white text-xs font-bold text-slate-700">
                        <option value="1.5">Resolusi: Standard (1.5x)</option>
                        <option value="2.5" selected>Resolusi: HD (2.5x)</option>
                    </select>
                    <button type="button" onclick="executePdf2Img()" class="px-5 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white text-xs font-extrabold transition-all flex items-center gap-2 cursor-pointer">
                        <i data-lucide="image" class="w-4 h-4"></i>
                        <span>Konversi Sekarang</span>
                    </button>
                </div>
            </div>
            <div id="p2i-results" class="hidden space-y-4"></div>
        `;
        lucide.createIcons();
    }

    async function executePdf2Img() {
        try {
            const fmt = document.getElementById('p2i-format').value;
            const scale = parseFloat(document.getElementById('p2i-scale').value);
            const ext = fmt === 'png' ? 'png' : 'jpg';
            const mime = fmt === 'png' ? 'image/png' : 'image/jpeg';

            const pdf = await pdfjsLib.getDocument({ data: state.singleFile.bytes.slice(0) }).promise;
            state.renderedImgs = [];

            for (let i = 1; i <= pdf.numPages; i++) {
                setStatus('loading', `Merender halaman ${i} dari ${pdf.numPages} ke ${ext.toUpperCase()}...`);
                const page = await pdf.getPage(i);
                const viewport = page.getViewport({ scale });
                const canvas = document.createElement('canvas');
                canvas.width = viewport.width;
                canvas.height = viewport.height;
                await page.render({ canvasContext: canvas.getContext('2d'), viewport }).promise;
                const dataUrl = canvas.toDataURL(mime, 0.92);
                state.renderedImgs.push({ pageNum: i, dataUrl, ext });
            }

            const resultsEl = document.getElementById('p2i-results');
            resultsEl.classList.remove('hidden');
            resultsEl.innerHTML = `
                <div class="flex items-center justify-between">
                    <span class="text-xs font-extrabold text-slate-800">Hasil Konversi (${state.renderedImgs.length} Gambar)</span>
                    <button type="button" onclick="downloadAllImagesZip()" class="px-4 py-2 rounded-xl bg-slate-900 hover:bg-black text-white text-xs font-bold flex items-center gap-1.5 cursor-pointer">
                        <i data-lucide="download" class="w-3.5 h-3.5"></i>
                        <span>Unduh Semua (.ZIP)</span>
                    </button>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    ${state.renderedImgs.map((img, idx) => `
                        <div class="rounded-xl border border-slate-200 bg-white p-2.5 flex flex-col gap-2">
                            <img src="${img.dataUrl}" class="w-full aspect-[3/4] object-contain bg-slate-50 rounded-lg" />
                            <a href="${img.dataUrl}" download="halaman_${img.pageNum}.${img.ext}" class="w-full py-1.5 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-700 text-[11px] font-bold text-center transition-colors">
                                Unduh Hal ${img.pageNum}
                            </a>
                        </div>
                    `).join('')}
                </div>
            `;
            lucide.createIcons();
            setStatus('success', `Berhasil mengonversi ${state.renderedImgs.length} halaman PDF menjadi gambar ${ext.toUpperCase()}!`);
        } catch (err) {
            setStatus('error', 'Gagal mengonversi PDF ke gambar: ' + err.message);
        }
    }

    async function downloadAllImagesZip() {
        const zip = new JSZip();
        const baseName = state.singleFile.name.replace(/\.pdf$/i, '');
        state.renderedImgs.forEach(img => {
            const base64 = img.dataUrl.split(',')[1];
            zip.file(`${baseName}_hal_${img.pageNum}.${img.ext}`, base64, { base64: true });
        });
        const blob = await zip.generateAsync({ type: 'blob' });
        downloadBlob(blob, `${baseName}_images.zip`);
    }

    // =========================================================================
    // 5. IMAGE TO PDF
    // =========================================================================
    function renderImg2PdfUI() {
        showWorkspaceBody();
        const body = document.getElementById('ws-body');
        const listHtml = state.files.map((item, idx) => `
            <div class="rounded-xl border border-slate-200 bg-white p-2.5 flex flex-col justify-between gap-2">
                <div class="relative bg-slate-50 rounded-lg overflow-hidden aspect-square flex items-center justify-center">
                    <img src="${item.dataUrl}" class="w-full h-full object-contain" />
                    <span class="absolute top-1.5 left-1.5 px-1.5 py-0.5 rounded bg-slate-900/80 text-white text-[10px] font-bold">${idx + 1}</span>
                </div>
                <div class="text-[11px] font-semibold text-slate-700 truncate">${item.name}</div>
                <div class="flex items-center justify-between gap-1">
                    <button type="button" onclick="moveImgFile(${idx}, -1)" ${idx === 0 ? 'disabled' : ''} class="p-1 rounded bg-slate-100 hover:bg-slate-200 disabled:opacity-40 cursor-pointer"><i data-lucide="chevron-left" class="w-3.5 h-3.5"></i></button>
                    <button type="button" onclick="removeImgFile(${idx})" class="p-1 rounded bg-red-50 text-red-600 hover:bg-red-100 cursor-pointer"><i data-lucide="trash-2" class="w-3.5 h-3.5"></i></button>
                    <button type="button" onclick="moveImgFile(${idx}, 1)" ${idx === state.files.length - 1 ? 'disabled' : ''} class="p-1 rounded bg-slate-100 hover:bg-slate-200 disabled:opacity-40 cursor-pointer"><i data-lucide="chevron-right" class="w-3.5 h-3.5"></i></button>
                </div>
            </div>
        `).join('');

        body.innerHTML = `
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div class="text-xs font-bold text-slate-700">${state.files.length} Gambar Terpilih</div>
                <div class="flex flex-wrap items-center gap-2">
                    <select id="i2p-size" class="px-3 py-2 rounded-xl border border-slate-200 bg-white text-xs font-bold text-slate-700">
                        <option value="a4">Ukuran Kertas: A4</option>
                        <option value="fit">Ukuran Asli Gambar (Fit)</option>
                    </select>
                    <select id="i2p-margin" class="px-3 py-2 rounded-xl border border-slate-200 bg-white text-xs font-bold text-slate-700">
                        <option value="20">Margin: Kecil</option>
                        <option value="0">Tanpa Margin</option>
                    </select>
                    <label class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold cursor-pointer inline-flex items-center gap-1.5">
                        <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                        <span>Tambah Gambar</span>
                        <input type="file" accept="image/*" multiple class="hidden" onchange="if(this.files.length) handleFiles(this.files)" />
                    </label>
                </div>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-5 gap-3">${listHtml}</div>
            <div class="pt-2 flex justify-end">
                <button type="button" onclick="executeImg2Pdf()" class="px-6 py-3 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-xs font-extrabold transition-all shadow-md shadow-sky-600/20 flex items-center gap-2 cursor-pointer">
                    <i data-lucide="file-image" class="w-4 h-4"></i>
                    <span>Buat & Unduh PDF</span>
                </button>
            </div>
        `;
        lucide.createIcons();
    }

    function moveImgFile(idx, dir) {
        const target = idx + dir;
        if (target < 0 || target >= state.files.length) return;
        [state.files[idx], state.files[target]] = [state.files[target], state.files[idx]];
        renderImg2PdfUI();
    }

    function removeImgFile(idx) {
        state.files.splice(idx, 1);
        if (state.files.length === 0) resetCurrentTool();
        else renderImg2PdfUI();
    }

    async function executeImg2Pdf() {
        try {
            setStatus('loading', 'Menyusun gambar ke dalam halaman PDF...');
            const sizeOpt = document.getElementById('i2p-size').value;
            const margin = parseInt(document.getElementById('i2p-margin').value);
            const pdfDoc = await PDFLib.PDFDocument.create();

            for (const item of state.files) {
                const imgBytes = await convertImageToStandardBytes(item.dataUrl, item.file.type);
                const embedded = imgBytes.type === 'png'
                    ? await pdfDoc.embedPng(imgBytes.bytes)
                    : await pdfDoc.embedJpg(imgBytes.bytes);

                const imgW = embedded.width;
                const imgH = embedded.height;

                if (sizeOpt === 'fit') {
                    const page = pdfDoc.addPage([imgW + margin * 2, imgH + margin * 2]);
                    page.drawImage(embedded, { x: margin, y: margin, width: imgW, height: imgH });
                } else {
                    // A4: 595.28 x 841.89 pts
                    const isLandscape = imgW > imgH;
                    const pageW = isLandscape ? 841.89 : 595.28;
                    const pageH = isLandscape ? 595.28 : 841.89;
                    const page = pdfDoc.addPage([pageW, pageH]);

                    const availW = pageW - margin * 2;
                    const availH = pageH - margin * 2;
                    const ratio = Math.min(availW / imgW, availH / imgH);
                    const drawW = imgW * ratio;
                    const drawH = imgH * ratio;
                    const x = (pageW - drawW) / 2;
                    const y = (pageH - drawH) / 2;
                    page.drawImage(embedded, { x, y, width: drawW, height: drawH });
                }
            }

            const outBytes = await pdfDoc.save();
            downloadBlob(new Blob([outBytes], { type: 'application/pdf' }), 'images_to_pdf_simak.pdf');
            setStatus('success', `Berhasil membuat PDF dari ${state.files.length} gambar!`);
        } catch (err) {
            setStatus('error', 'Gagal membuat PDF: ' + err.message);
        }
    }

    function convertImageToStandardBytes(dataUrl, mime) {
        return new Promise((resolve) => {
            const img = new Image();
            img.onload = () => {
                const canvas = document.createElement('canvas');
                canvas.width = img.width;
                canvas.height = img.height;
                const ctx = canvas.getContext('2d');
                const isPng = mime === 'image/png';
                if (!isPng) {
                    ctx.fillStyle = '#ffffff';
                    ctx.fillRect(0, 0, canvas.width, canvas.height);
                }
                ctx.drawImage(img, 0, 0);
                const outMime = isPng ? 'image/png' : 'image/jpeg';
                canvas.toBlob(async (blob) => {
                    const bytes = await blob.arrayBuffer();
                    resolve({ type: isPng ? 'png' : 'jpg', bytes });
                }, outMime, 0.92);
            };
            img.src = dataUrl;
        });
    }

    // =========================================================================
    // 6. ORGANIZE & ROTATE PDF
    // =========================================================================
    function renderOrganizeUI() {
        showWorkspaceBody();
        const body = document.getElementById('ws-body');
        const activeCount = state.pages.filter(p => !p.deleted).length;

        const gridHtml = state.pages.map((p, idx) => `
            <div class="rounded-xl border p-2.5 flex flex-col justify-between gap-2 transition-all ${p.deleted ? 'border-red-200 bg-red-50/40 opacity-50' : 'border-slate-200 bg-white'}">
                <div class="relative bg-slate-100 rounded-lg overflow-hidden aspect-[3/4] flex items-center justify-center">
                    ${p.thumbUrl ? `<img src="${p.thumbUrl}" style="transform: rotate(${p.rotation}deg);" class="w-full h-full object-contain transition-transform" />` : `<span class="text-xs font-bold text-slate-400">Hal ${p.pageNum}</span>`}
                    ${p.deleted ? `<span class="absolute inset-0 bg-red-900/40 text-white text-[10px] font-black flex items-center justify-center">DIHAPUS</span>` : ''}
                </div>
                <div class="text-center text-[11px] font-bold text-slate-700">Hal ${p.pageNum} ${p.rotation ? `(${p.rotation}°)` : ''}</div>
                <div class="flex items-center justify-center gap-1.5">
                    <button type="button" onclick="rotatePageItem(${idx})" ${p.deleted ? 'disabled' : ''} class="flex-1 py-1.5 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-[11px] font-bold flex items-center justify-center gap-1 cursor-pointer disabled:opacity-40" title="Putar 90°">
                        <i data-lucide="rotate-cw" class="w-3 h-3"></i>
                        <span>90°</span>
                    </button>
                    <button type="button" onclick="toggleDeletePageItem(${idx})" class="p-1.5 rounded-lg ${p.deleted ? 'bg-slate-200 text-slate-700' : 'bg-red-50 text-red-600 hover:bg-red-100'} cursor-pointer" title="${p.deleted ? 'Pulihkan' : 'Hapus'}">
                        <i data-lucide="${p.deleted ? 'undo-2' : 'trash-2'}" class="w-3.5 h-3.5"></i>
                    </button>
                </div>
            </div>
        `).join('');

        body.innerHTML = `
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex flex-wrap items-center justify-between gap-3">
                <div>
                    <div class="text-xs font-extrabold text-slate-900">${state.singleFile.name}</div>
                    <div class="text-[11px] text-slate-500">${activeCount} halaman aktif dari ${state.pages.length} halaman</div>
                </div>
                <button type="button" onclick="rotateAllPages()" class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 text-xs font-bold flex items-center gap-1.5 cursor-pointer">
                    <i data-lucide="rotate-cw" class="w-3.5 h-3.5"></i>
                    <span>Putar Semua 90°</span>
                </button>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-3 max-h-[420px] overflow-y-auto p-1">${gridHtml}</div>
            <div class="pt-2 flex justify-end">
                <button type="button" onclick="executeOrganize()" ${activeCount === 0 ? 'disabled' : ''} class="px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 disabled:bg-slate-300 text-white text-xs font-extrabold transition-all shadow-md shadow-indigo-600/20 flex items-center gap-2 cursor-pointer">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    <span>Simpan & Unduh PDF Baru</span>
                </button>
            </div>
        `;
        lucide.createIcons();
    }

    function rotatePageItem(idx) {
        state.pages[idx].rotation = (state.pages[idx].rotation + 90) % 360;
        renderOrganizeUI();
    }
    function rotateAllPages() {
        state.pages.forEach(p => { if (!p.deleted) p.rotation = (p.rotation + 90) % 360; });
        renderOrganizeUI();
    }
    function toggleDeletePageItem(idx) {
        state.pages[idx].deleted = !state.pages[idx].deleted;
        renderOrganizeUI();
    }

    async function executeOrganize() {
        try {
            const activePages = state.pages.filter(p => !p.deleted);
            if (!activePages.length) return;
            setStatus('loading', 'Menyimpan perubahan orientasi dan halaman di background worker...');
            const pagesPayload = activePages.map(p => ({ idx: p.pageNum - 1, rot: p.rotation }));
            const res = await runPdfWorkerTask('rotate', {
                bytes: state.singleFile.bytes.slice(0),
                pages: pagesPayload
            });
            downloadBlob(new Blob([res.bytes], { type: 'application/pdf' }), `organized_${state.singleFile.name}`);
            setStatus('success', `Berhasil menyimpan PDF baru (${res.pageCount} halaman)!`);
        } catch (err) {
            setStatus('error', 'Gagal menyimpan PDF: ' + err.message);
        }
    }

    // =========================================================================
    // 7. WATERMARK PDF
    // =========================================================================
    function renderWatermarkUI() {
        showWorkspaceBody();
        const body = document.getElementById('ws-body');
        body.innerHTML = `
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between gap-3">
                <div>
                    <div class="text-xs font-extrabold text-slate-900">${state.singleFile.name}</div>
                    <div class="text-[11px] text-slate-500">${state.singleFile.pageCount} halaman akan diberi watermark teks (Background Worker)</div>
                </div>
                <span class="px-2.5 py-1 rounded-full bg-purple-50 text-purple-700 border border-purple-200 text-[10px] font-bold">Live Preview</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">
                <!-- Left: Settings -->
                <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Teks Watermark</label>
                        <input type="text" id="wm-text" value="DOKUMEN PKL - PT. TMS" oninput="updateWatermarkPreview()" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-900 focus:outline-none focus:border-purple-500" />
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Warna Teks</label>
                        <select id="wm-color" onchange="updateWatermarkPreview()" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-xs font-semibold text-slate-900">
                            <option value="red">Merah TMS (#e11d48)</option>
                            <option value="slate">Hitam / Slate Gelap</option>
                            <option value="blue">Biru Korporat</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Ukuran Font: <span id="wm-size-val">42</span>pt</label>
                        <input type="range" id="wm-size" min="20" max="80" value="42" class="w-full accent-purple-600" oninput="document.getElementById('wm-size-val').textContent=this.value; updateWatermarkPreview();" />
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Transparansi (Opacity): <span id="wm-op-val">25</span>%</label>
                        <input type="range" id="wm-opacity" min="10" max="80" value="25" class="w-full accent-purple-600" oninput="document.getElementById('wm-op-val').textContent=this.value; updateWatermarkPreview();" />
                    </div>
                </div>

                <!-- Right: Live Visual A4 Preview -->
                <div class="lg:col-span-5 flex flex-col items-center">
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Pratinjau Hasil Watermark</div>
                    <div id="wm-preview-box" class="relative w-full max-w-[210px] aspect-[3/4] bg-white rounded-xl border border-slate-200 shadow-inner overflow-hidden p-4 flex flex-col justify-between select-none">
                        <div class="space-y-1.5 opacity-30">
                            <div class="h-2.5 w-2/3 bg-slate-300 rounded"></div>
                            <div class="h-1.5 w-full bg-slate-200 rounded"></div>
                            <div class="h-1.5 w-5/6 bg-slate-200 rounded"></div>
                            <div class="h-1.5 w-4/5 bg-slate-200 rounded"></div>
                            <div class="h-1.5 w-full bg-slate-200 rounded mt-3"></div>
                            <div class="h-1.5 w-3/4 bg-slate-200 rounded"></div>
                        </div>
                        <div class="space-y-1.5 opacity-30">
                            <div class="h-1.5 w-full bg-slate-200 rounded"></div>
                            <div class="h-1.5 w-2/3 bg-slate-200 rounded"></div>
                        </div>
                        <div id="wm-preview-text" class="absolute inset-0 flex items-center justify-center pointer-events-none font-black text-center whitespace-nowrap" style="transform: rotate(-45deg); color: #e11d48; opacity: 0.25; font-size: 14px;">
                            DOKUMEN PKL - PT. TMS
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-2 flex justify-end">
                <button type="button" onclick="executeWatermark()" class="px-6 py-3 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-xs font-extrabold transition-all shadow-md shadow-purple-600/20 flex items-center gap-2 cursor-pointer">
                    <i data-lucide="stamp" class="w-4 h-4"></i>
                    <span>Terapkan Watermark &amp; Unduh PDF</span>
                </button>
            </div>
        `;
        lucide.createIcons();
        updateWatermarkPreview();
    }

    function updateWatermarkPreview() {
        const prev = document.getElementById('wm-preview-text');
        if (!prev) return;
        const text = document.getElementById('wm-text')?.value.trim() || 'WATERMARK';
        const colorOpt = document.getElementById('wm-color')?.value || 'red';
        const sizePt = parseInt(document.getElementById('wm-size')?.value || '42', 10);
        const opacity = parseInt(document.getElementById('wm-opacity')?.value || '25', 10) / 100;

        let colorHex = '#e11d48';
        if (colorOpt === 'slate') colorHex = '#1e293b';
        else if (colorOpt === 'blue') colorHex = '#1d4ed8';

        prev.textContent = text;
        prev.style.color = colorHex;
        prev.style.opacity = opacity;
        prev.style.fontSize = Math.max(9, Math.round(sizePt * 0.34)) + 'px';
    }

    async function executeWatermark() {
        try {
            const text = document.getElementById('wm-text').value.trim().replace(/[^\x20-\x7E\xA0-\xFF]/g, '');
            if (!text) return setStatus('error', 'Harap isi teks watermark (huruf/angka standar) terlebih dahulu.');
            const colorOpt = document.getElementById('wm-color').value;
            const fontSize = parseInt(document.getElementById('wm-size').value, 10);
            const opacity = parseInt(document.getElementById('wm-opacity').value, 10) / 100;

            setStatus('loading', 'Menambahkan watermark di background worker...');
            const res = await runPdfWorkerTask('watermark', {
                bytes: state.singleFile.bytes.slice(0),
                text,
                colorOpt,
                fontSize,
                opacity
            });
            downloadBlob(new Blob([res.bytes], { type: 'application/pdf' }), `watermarked_${state.singleFile.name}`);
            setStatus('success', `Watermark berhasil diterapkan pada ${res.pageCount} halaman!`);
        } catch (err) {
            setStatus('error', 'Gagal menambahkan watermark: ' + err.message);
        }
    }

    // =========================================================================
    // 8. OFFICE VIEWER & PRINT TO PDF (.DOCX / .XLSX / .CSV)
    // =========================================================================
    async function handleOfficeFile(file) {
        const ext = file.name.split('.').pop().toLowerCase();
        setStatus('loading', 'Membaca dan merender dokumen Office...');
        const bytes = await file.arrayBuffer();
        let htmlPreview = '';

        if (ext === 'docx') {
            const result = await mammoth.convertToHtml({ arrayBuffer: bytes });
            htmlPreview = `<div class="prose prose-sm max-w-none text-slate-800 space-y-2">${result.value}</div>`;
        } else if (['xlsx', 'xls', 'csv'].includes(ext)) {
            const workbook = XLSX.read(bytes, { type: 'array' });
            htmlPreview = workbook.SheetNames.map(sheetName => {
                const sheet = workbook.Sheets[sheetName];
                const tableHtml = XLSX.utils.sheet_to_html(sheet);
                return `
                    <div class="mb-6">
                        ${workbook.SheetNames.length > 1 ? `<div class="text-xs font-extrabold text-slate-900 bg-slate-100 px-3 py-1.5 rounded-t-lg border border-b-0 border-slate-200">Sheet: ${sheetName}</div>` : ''}
                        <div class="overflow-x-auto office-table-wrapper">${tableHtml}</div>
                    </div>
                `;
            }).join('');
        } else if (ext === 'doc') {
            return setStatus('error', 'Format .doc lama (Word 97-2003) belum didukung. Harap Save As ke .docx terlebih dahulu.');
        } else {
            return setStatus('error', 'Format tidak didukung. Harap pilih .docx, .xlsx, .xls, atau .csv');
        }

        setStatus(null, '');
        showWorkspaceBody();
        const body = document.getElementById('ws-body');
        body.innerHTML = `
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex flex-wrap items-center justify-between gap-3">
                <div>
                    <div class="text-xs font-extrabold text-slate-900">${file.name}</div>
                    <div class="text-[11px] text-slate-500">Ukuran: ${formatBytes(file.size)} • Pratinjau Siap Cetak ke PDF</div>
                </div>
                <button type="button" onclick="printOfficePreview()" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-extrabold transition-all shadow-md shadow-blue-600/20 flex items-center gap-2 cursor-pointer">
                    <i data-lucide="printer" class="w-4 h-4"></i>
                    <span>Cetak / Simpan sebagai PDF</span>
                </button>
            </div>
            <div id="office-print-area" class="p-6 sm:p-10 bg-white border border-slate-200 rounded-xl shadow-xs max-h-[520px] overflow-y-auto text-sm leading-relaxed">
                ${htmlPreview}
            </div>
        `;
        lucide.createIcons();
    }

    function printOfficePreview() {
        const content = document.getElementById('office-print-area').innerHTML;
        const win = window.open('', '_blank');
        win.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Cetak Dokumen Office - SIMAK-TMS</title>
                <style>
                    body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; padding: 32px; color: #0f172a; line-height: 1.6; }
                    table { border-collapse: collapse; width: 100%; margin: 12px 0; font-size: 12px; }
                    th, td { border: 1px solid #cbd5e1; padding: 6px 10px; text-align: left; }
                    th { background: #f1f5f9; font-weight: bold; }
                    img { max-width: 100%; height: auto; }
                </style>
            </head>
            <body>${content}</body>
            </html>
        `);
        win.document.close();
        win.focus();
        setTimeout(() => { win.print(); }, 400);
    }
</script>

<style>
    .office-table-wrapper table { border-collapse: collapse; width: 100%; font-size: 12px; }
    .office-table-wrapper th, .office-table-wrapper td { border: 1px solid #e2e8f0; padding: 6px 10px; text-align: left; }
    .office-table-wrapper tr:first-child td { background: #f8fafc; font-weight: 700; color: #0f172a; }
</style>
@endsection
