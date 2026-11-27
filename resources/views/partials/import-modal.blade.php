{{-- ============================================================== --}}
{{-- REUSABLE IMPORT EXCEL / CSV + DUPLICATE CONFLICT MODAL          --}}
{{-- Expected props: $importRoute, $importTitle, $templateName,     --}}
{{--                 $templateHeaders (array), $sampleRow (array)   --}}
{{-- ============================================================== --}}
<style>
    @keyframes simakModalFadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes simakModalPopIn {
        from { opacity: 0; transform: scale(0.95) translateY(8px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }
    .import-backdrop-anim {
        animation: simakModalFadeIn 0.18s ease-out forwards;
    }
    .import-card-anim {
        animation: simakModalPopIn 0.22s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
</style>

<!-- MODAL 1: IMPORT EXCEL / CSV -->
<div id="modal-import-data" class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs hidden items-center justify-center p-4 import-backdrop-anim" style="z-index: 9990; display: none;" onclick="if(event.target===this) closeImportModal()">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 space-y-4 import-card-anim" style="position: relative; z-index: 9991;">
        <!-- Header -->
        <div class="flex items-start justify-between gap-3">
            <div class="flex items-start gap-3">
                <div class="w-11 h-11 rounded-2xl bg-indigo-50 text-indigo-600 border border-indigo-200 flex items-center justify-center shrink-0">
                    <i data-lucide="upload-cloud" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-slate-900 leading-snug">{{ $importTitle ?? 'Import Data Excel / CSV' }}</h3>
                    <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">
                        Unggah file hasil <b>Ekspor Excel (.xls / .xlsx)</b> atau <b>CSV</b> untuk restore backup atau tambah data massal per baris.
                    </p>
                </div>
            </div>
            <button type="button" onclick="closeImportModal()" class="w-8 h-8 rounded-xl hover:bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition-colors cursor-pointer shrink-0">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Download Template Banner -->
        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-center justify-between gap-3">
            <div class="flex items-center gap-2.5 min-w-0">
                <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                    <i data-lucide="file-spreadsheet" class="w-4 h-4"></i>
                </div>
                <div class="min-w-0">
                    <div class="text-xs font-bold text-slate-800 truncate">Template Excel Resmi (Sama dengan Ekspor)</div>
                    <div class="text-[11px] text-slate-500 truncate">Unduh template kosong jika ingin mengisi data baru dari awal.</div>
                </div>
            </div>
            <button type="button" onclick="downloadImportTemplate()" class="px-3 py-1.5 rounded-xl bg-white hover:bg-emerald-50 border border-slate-200 hover:border-emerald-300 text-emerald-700 text-[11px] font-bold transition-all shrink-0 cursor-pointer flex items-center gap-1.5 shadow-2xs">
                <i data-lucide="download" class="w-3.5 h-3.5"></i>
                <span>Unduh Template</span>
            </button>
        </div>

        <!-- Dropzone -->
        <label for="import-file-input" id="import-dropzone" class="block border-2 border-dashed border-slate-200 hover:border-indigo-400 hover:bg-indigo-50/30 rounded-2xl p-5 text-center cursor-pointer transition-all">
            <input type="file" id="import-file-input" accept=".xlsx,.xls,.csv" class="hidden" onchange="handleImportFileSelect(this.files[0])">
            <div class="w-10 h-10 rounded-2xl bg-indigo-100/70 text-indigo-600 flex items-center justify-center mx-auto mb-2">
                <i data-lucide="file-up" class="w-5 h-5"></i>
            </div>
            <div id="import-file-label" class="text-xs font-bold text-slate-700">Klik untuk pilih file atau seret ke sini</div>
            <div class="text-[11px] text-slate-400 mt-1">Mendukung format <b>.xlsx</b>, <b>.xls</b> (hasil ekspor SIMAK), dan <b>.csv</b></div>
        </label>

        <!-- Preview Area (Hidden until parsed) -->
        <div id="import-preview-box" class="hidden p-3.5 rounded-2xl bg-indigo-50/60 border border-indigo-200/80 space-y-2">
            <div class="flex items-center justify-between text-xs">
                <span class="font-bold text-indigo-900 flex items-center gap-1.5">
                    <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600"></i>
                    <span id="import-row-count-text">0 baris data terbaca</span>
                </span>
                <span id="import-file-name-badge" class="text-[10px] font-mono font-bold px-2 py-0.5 rounded-md bg-white text-indigo-700 border border-indigo-200 truncate max-w-[180px]"></span>
            </div>
            <div id="import-preview-list" class="max-h-28 overflow-y-auto space-y-1 text-[11px] text-slate-600 divide-y divide-indigo-100"></div>
        </div>

        <!-- Error Box -->
        <div id="import-error-box" class="hidden p-3 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold"></div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
            <button type="button" onclick="closeImportModal()" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all cursor-pointer">
                Batal
            </button>
            <button type="button" id="btn-submit-import" onclick="submitImportCheck()" disabled class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 disabled:bg-slate-300 disabled:cursor-not-allowed text-white text-xs font-bold transition-all shadow-md shadow-indigo-600/20 flex items-center gap-2 cursor-pointer">
                <i data-lucide="database-zap" class="w-4 h-4"></i>
                <span id="btn-submit-import-label">Import Data Sekarang</span>
            </button>
        </div>
    </div>
</div>

<!-- MODAL 2: KONFIRMASI DATA DUPLIKAT (TIMPA / LEWATI + COUNTDOWN) -->
<div id="modal-import-conflict" class="fixed inset-0 bg-slate-950/75 backdrop-blur-xs hidden items-center justify-center p-4 import-backdrop-anim" style="z-index: 9999; display: none;">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-100 space-y-4 import-card-anim" style="position: relative; z-index: 10000; margin: auto;">
        <!-- Header -->
        <div class="flex items-start justify-between gap-3">
            <div class="flex items-start gap-3">
                <div class="w-11 h-11 rounded-2xl bg-amber-100 text-amber-600 border border-amber-200 flex items-center justify-center shrink-0">
                    <i data-lucide="alert-triangle" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-slate-900 leading-snug">Ditemukan Data Duplikat!</h3>
                    <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">
                        Terdapat <b id="import-dup-count-text" class="text-amber-700">0 data duplikat</b> yang sudah ada di sistem, dan <b id="import-new-count-text" class="text-emerald-700">0 data baru</b>.
                    </p>
                </div>
            </div>
            <button type="button" onclick="cancelImportConflict()" class="w-8 h-8 rounded-xl hover:bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition-colors cursor-pointer shrink-0">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Scrollable Duplicate List -->
        <div class="p-3 bg-amber-50/70 border border-amber-200/80 rounded-2xl space-y-2">
            <div class="text-[10px] font-bold text-amber-900 uppercase tracking-wider flex items-center gap-1.5">
                <i data-lucide="copy-check" class="w-3.5 h-3.5 text-amber-600"></i>
                <span>Daftar data yang terdeteksi duplikat:</span>
            </div>
            <div id="import-dup-list" class="space-y-1.5 max-h-36 overflow-y-auto pr-1 text-xs divide-y divide-amber-200/50"></div>
        </div>

        <!-- Action Explanation -->
        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 text-slate-600 text-[11px] leading-relaxed">
            <span class="font-bold text-slate-800">Apakah Anda ingin menimpa data lama atau melewatinya?</span>
            <ul class="list-disc pl-4 mt-1 space-y-1 text-slate-500">
                <li><b>Timpa Data Duplikat:</b> Data di sistem akan diperbarui mengikuti isi file Excel/CSV yang Anda impor.</li>
                <li><b>Lewati Duplikat (Aman):</b> Data di template yang duplikat <b>tidak ikut masuk</b> ke sistem; hanya data baru yang disimpan.</li>
            </ul>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-2 pt-2 border-t border-slate-100">
            <div class="grid grid-cols-2 gap-2">
                <button type="button" onclick="cancelImportConflict()" class="w-full py-2.5 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all text-center cursor-pointer">
                    Batal
                </button>
                <button type="button" id="btn-import-skip" onclick="executeImportMode('skip')" class="w-full py-2.5 px-3 rounded-xl bg-sky-50 hover:bg-sky-100 border border-sky-200 text-sky-800 text-xs font-bold transition-all text-center cursor-pointer">
                    Lewati Duplikat (Aman)
                </button>
            </div>

            <button type="button" id="btn-import-overwrite" onclick="executeImportMode('overwrite')" disabled
                    class="w-full py-2.5 px-4 rounded-xl font-bold text-xs transition-all flex items-center justify-center gap-2 cursor-not-allowed opacity-60 bg-red-400 text-white shadow-xs">
                <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                <span id="btn-import-overwrite-label">Ya, Timpa Data Duplikat (3s)</span>
            </button>
        </div>
    </div>
</div>

<script src="{{ asset('vendor/pdf-tools/xlsx.full.min.js') }}"></script>
<script>
(function() {
    const IMPORT_ENDPOINT = @json($importRoute);
    const TEMPLATE_NAME = @json($templateName ?? 'Template_Import_SIMAK.xlsx');
    const TEMPLATE_HEADERS = @json($templateHeaders ?? []);
    const SAMPLE_ROW = @json($sampleRow ?? []);
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || @json(csrf_token());

    let parsedImportRows = [];
    let importCountdownTimer = null;
    let importCountdownSec = 3;

    window.openImportModal = function() {
        const m = document.getElementById('modal-import-data');
        if (!m) return;
        // Reset state
        parsedImportRows = [];
        const fileInput = document.getElementById('import-file-input');
        if (fileInput) fileInput.value = '';
        document.getElementById('import-file-label').textContent = 'Klik untuk pilih file atau seret ke sini';
        document.getElementById('import-preview-box').classList.add('hidden');
        document.getElementById('import-error-box').classList.add('hidden');
        document.getElementById('btn-submit-import').disabled = true;
        document.getElementById('btn-submit-import-label').textContent = 'Import Data Sekarang';

        m.classList.remove('hidden');
        m.classList.add('flex');
        m.style.display = 'flex';
        if (window.lucide) lucide.createIcons();
    };

    window.closeImportModal = function() {
        const m = document.getElementById('modal-import-data');
        if (!m) return;
        m.classList.add('hidden');
        m.classList.remove('flex');
        m.style.display = 'none';
    };

    window.downloadImportTemplate = function() {
        if (typeof XLSX === 'undefined') {
            alert('Library Excel lokal sedang dimuat, silakan coba beberapa detik lagi.');
            return;
        }
        const aoa = [TEMPLATE_HEADERS];
        if (SAMPLE_ROW && SAMPLE_ROW.length > 0) {
            aoa.push(SAMPLE_ROW);
        }
        const ws = XLSX.utils.aoa_to_sheet(aoa);
        // Set comfortable column widths
        ws['!cols'] = TEMPLATE_HEADERS.map(h => ({ wch: Math.max(String(h).length + 6, 16) }));
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Template Import');
        XLSX.writeFile(wb, TEMPLATE_NAME);
    };

    function showImportError(msg) {
        const box = document.getElementById('import-error-box');
        box.textContent = msg;
        box.classList.remove('hidden');
    }

    window.handleImportFileSelect = function(file) {
        const errBox = document.getElementById('import-error-box');
        const prevBox = document.getElementById('import-preview-box');
        const submitBtn = document.getElementById('btn-submit-import');
        errBox.classList.add('hidden');
        prevBox.classList.add('hidden');
        submitBtn.disabled = true;
        parsedImportRows = [];

        if (!file) return;
        if (typeof XLSX === 'undefined') {
            showImportError('Library pembaca Excel belum siap. Muat ulang halaman.');
            return;
        }

        document.getElementById('import-file-label').textContent = file.name;
        const reader = new FileReader();
        reader.onload = function(e) {
            try {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, { type: 'array' });
                const firstSheetName = workbook.SheetNames[0];
                const sheet = workbook.Sheets[firstSheetName];
                const rawAoa = XLSX.utils.sheet_to_json(sheet, { header: 1, defval: '' });

                if (!rawAoa || rawAoa.length < 2) {
                    showImportError('File tidak memiliki baris data yang valid.');
                    return;
                }

                // Cari baris header (karena file ekspor .xls punya judul di baris 1-2 sebelum <table>)
                let headerIdx = -1;
                const knownKeywords = ['email', 'email siswa', 'nama lengkap', 'nama lengkap siswa', 'nama lengkap pendaftar', 'kode antrian', 'id akun', 'id akun 5-digit'];
                for (let i = 0; i < Math.min(rawAoa.length, 12); i++) {
                    const rowLower = rawAoa[i].map(c => String(c || '').trim().toLowerCase());
                    if (rowLower.some(cell => knownKeywords.includes(cell))) {
                        headerIdx = i;
                        break;
                    }
                }

                if (headerIdx === -1) {
                    showImportError('Header kolom tidak dikenali! Pastikan menggunakan file hasil Ekspor atau Template Resmi SIMAK.');
                    return;
                }

                const headers = rawAoa[headerIdx].map(h => String(h || '').trim());
                const rows = [];
                for (let r = headerIdx + 1; r < rawAoa.length; r++) {
                    const rawRow = rawAoa[r];
                    if (!rawRow || rawRow.every(c => String(c ?? '').trim() === '')) continue;

                    const obj = {};
                    let hasContent = false;
                    headers.forEach((h, idx) => {
                        if (!h) return;
                        const val = rawRow[idx] !== undefined && rawRow[idx] !== null ? String(rawRow[idx]).trim() : '';
                        obj[h] = val;
                        if (h.toLowerCase() !== 'no' && val !== '' && val !== '-') {
                            hasContent = true;
                        }
                    });
                    if (hasContent) {
                        rows.push(obj);
                    }
                }

                if (rows.length === 0) {
                    showImportError('Tidak ada baris data yang terisi di bawah header.');
                    return;
                }

                parsedImportRows = rows;
                document.getElementById('import-row-count-text').textContent = `${rows.length} baris data siap diimpor`;
                document.getElementById('import-file-name-badge').textContent = file.name;

                const listEl = document.getElementById('import-preview-list');
                listEl.innerHTML = '';
                rows.slice(0, 4).forEach((row, idx) => {
                    const name = row['Nama Lengkap'] || row['Nama Lengkap Siswa'] || row['Nama Lengkap Pendaftar'] || row['full_name'] || row['name'] || 'Tanpa Nama';
                    const idOrMail = row['Email'] || row['Email Siswa'] || row['Kode Antrian'] || row['ID Akun'] || row['ID Akun 5-Digit'] || '-';
                    const div = document.createElement('div');
                    div.className = 'py-1 flex items-center justify-between gap-2';
                    div.innerHTML = `<span class="font-semibold text-slate-800 truncate">${idx + 1}. ${escapeHtml(name)}</span><span class="font-mono text-[10px] text-slate-500 shrink-0">${escapeHtml(idOrMail)}</span>`;
                    listEl.appendChild(div);
                });
                if (rows.length > 4) {
                    const more = document.createElement('div');
                    more.className = 'pt-1 text-[10px] text-indigo-600 font-semibold';
                    more.textContent = `...dan ${rows.length - 4} baris lainnya`;
                    listEl.appendChild(more);
                }

                prevBox.classList.remove('hidden');
                submitBtn.disabled = false;
                if (window.lucide) lucide.createIcons();
            } catch (err) {
                console.error(err);
                showImportError('Gagal membaca file spreadsheet. Pastikan file tidak rusak.');
            }
        };
        reader.readAsArrayBuffer(file);
    };

    // Drag & Drop support
    const dropzone = document.getElementById('import-dropzone');
    if (dropzone) {
        dropzone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropzone.classList.add('border-indigo-500', 'bg-indigo-50/60');
        });
        dropzone.addEventListener('dragleave', () => {
            dropzone.classList.remove('border-indigo-500', 'bg-indigo-50/60');
        });
        dropzone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropzone.classList.remove('border-indigo-500', 'bg-indigo-50/60');
            if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
                handleImportFileSelect(e.dataTransfer.files[0]);
            }
        });
    }

    function escapeHtml(str) {
        return String(str ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    window.submitImportCheck = async function() {
        if (parsedImportRows.length === 0) return;
        const btn = document.getElementById('btn-submit-import');
        const label = document.getElementById('btn-submit-import-label');
        btn.disabled = true;
        label.textContent = 'Memeriksa & Mengimpor...';
        document.getElementById('import-error-box').classList.add('hidden');

        try {
            const res = await fetch(IMPORT_ENDPOINT, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                body: JSON.stringify({ rows: parsedImportRows, mode: 'check' })
            });
            const data = await res.json();

            if (!res.ok) {
                showImportError(data.message || 'Terjadi kesalahan saat memproses import.');
                btn.disabled = false;
                label.textContent = 'Import Data Sekarang';
                return;
            }

            if (data.status === 'conflict') {
                // Tutup popup import, ganti dengan popup konfirmasi duplikat + detikan
                closeImportModal();
                openImportConflictModal(data);
                return;
            }

            // Sukses tanpa duplikat
            closeImportModal();
            window.location.reload();
        } catch (err) {
            console.error(err);
            showImportError('Koneksi gagal saat mengirim data import.');
            btn.disabled = false;
            label.textContent = 'Import Data Sekarang';
        }
    };

    function openImportConflictModal(data) {
        document.getElementById('import-dup-count-text').textContent = `${data.duplicate_count} data duplikat`;
        document.getElementById('import-new-count-text').textContent = `${data.new_count} data baru`;

        const listEl = document.getElementById('import-dup-list');
        listEl.innerHTML = '';
        (data.duplicates || []).forEach(dup => {
            const item = document.createElement('div');
            item.className = 'py-1.5 flex items-center justify-between gap-2';
            item.innerHTML = `
                <div class="min-w-0">
                    <div class="font-bold text-slate-800 truncate">${escapeHtml(dup.label)}</div>
                    <div class="text-[10px] text-amber-800 truncate">${escapeHtml(dup.sublabel || '')}</div>
                </div>
                <span class="px-2 py-0.5 rounded-md bg-amber-100 text-amber-800 font-bold text-[10px] shrink-0 border border-amber-200">
                    ${escapeHtml(dup.reason || 'Duplikat')}
                </span>
            `;
            listEl.appendChild(item);
        });

        // Disable Skip button if 0 new rows? No, keep it clickable so user can still skip duplicates cleanly
        const modal = document.getElementById('modal-import-conflict');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        modal.style.display = 'flex';
        if (window.lucide) lucide.createIcons();

        startOverwriteCountdown();
    }

    function startOverwriteCountdown() {
        clearInterval(importCountdownTimer);
        importCountdownSec = 3;
        const btn = document.getElementById('btn-import-overwrite');
        const label = document.getElementById('btn-import-overwrite-label');

        btn.disabled = true;
        btn.className = 'w-full py-2.5 px-4 rounded-xl font-bold text-xs transition-all flex items-center justify-center gap-2 cursor-not-allowed opacity-60 bg-red-400 text-white shadow-xs';
        label.textContent = `Ya, Timpa Data Duplikat (${importCountdownSec}s)`;

        importCountdownTimer = setInterval(() => {
            importCountdownSec--;
            if (importCountdownSec > 0) {
                label.textContent = `Ya, Timpa Data Duplikat (${importCountdownSec}s)`;
            } else {
                clearInterval(importCountdownTimer);
                btn.disabled = false;
                btn.className = 'w-full py-2.5 px-4 rounded-xl font-bold text-xs transition-all flex items-center justify-center gap-2 cursor-pointer bg-red-600 hover:bg-red-700 text-white shadow-md shadow-red-600/25';
                label.textContent = 'Ya, Timpa Data Duplikat Sekarang';
            }
        }, 1000);
    }

    window.cancelImportConflict = function() {
        clearInterval(importCountdownTimer);
        const modal = document.getElementById('modal-import-conflict');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        modal.style.display = 'none';
    };

    window.executeImportMode = async function(mode) {
        clearInterval(importCountdownTimer);
        const btnSkip = document.getElementById('btn-import-skip');
        const btnOverwrite = document.getElementById('btn-import-overwrite');
        btnSkip.disabled = true;
        btnOverwrite.disabled = true;

        if (mode === 'overwrite') {
            document.getElementById('btn-import-overwrite-label').textContent = 'Menimpa & Menyimpan...';
        } else {
            btnSkip.textContent = 'Menyimpan Data Baru...';
        }

        try {
            const res = await fetch(IMPORT_ENDPOINT, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                body: JSON.stringify({ rows: parsedImportRows, mode: mode })
            });
            const data = await res.json();
            if (res.ok && data.status === 'success') {
                window.location.reload();
            } else {
                alert(data.message || 'Gagal menyelesaikan import.');
                cancelImportConflict();
            }
        } catch (err) {
            console.error(err);
            alert('Terjadi kesalahan jaringan saat menyimpan import.');
            cancelImportConflict();
        }
    };
})();
</script>
