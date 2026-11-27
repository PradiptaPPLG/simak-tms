/**
 * SIMAK-TMS Office & PDF Tools Web Worker
 * Runs heavy PDF processing off the main UI thread with live progress updates.
 */
importScripts('/vendor/pdf-tools/pdf-lib.min.js');

function postProgress(percent, label) {
    self.postMessage({ type: 'progress', percent: Math.min(100, Math.max(0, Math.round(percent))), label });
}

self.onmessage = async function (e) {
    const { taskId, action, payload } = e.data;
    try {
        if (action === 'merge') {
            postProgress(5, 'Mempersiapkan dokumen gabungan...');
            const merged = await PDFLib.PDFDocument.create();
            const files = payload.files;
            for (let i = 0; i < files.length; i++) {
                postProgress(10 + ((i / files.length) * 75), `Menggabungkan file ${i + 1} dari ${files.length}...`);
                const src = await PDFLib.PDFDocument.load(files[i], { ignoreEncryption: true });
                const copied = await merged.copyPages(src, src.getPageIndices());
                copied.forEach(p => merged.addPage(p));
            }
            postProgress(92, 'Menyusun file PDF akhir...');
            const outBytes = await merged.save();
            postProgress(100, 'Selesai!');
            self.postMessage({ taskId, type: 'done', result: { bytes: outBytes.buffer } }, [outBytes.buffer]);
        } else if (action === 'watermark') {
            postProgress(10, 'Memuat dokumen PDF...');
            const pdfDoc = await PDFLib.PDFDocument.load(payload.bytes, { ignoreEncryption: true });
            const font = await pdfDoc.embedFont(PDFLib.StandardFonts.HelveticaBold);

            let rgbColor = PDFLib.rgb(0.88, 0.11, 0.28);
            if (payload.colorOpt === 'slate') rgbColor = PDFLib.rgb(0.15, 0.18, 0.25);
            else if (payload.colorOpt === 'blue') rgbColor = PDFLib.rgb(0.1, 0.35, 0.85);

            const pages = pdfDoc.getPages();
            for (let i = 0; i < pages.length; i++) {
                postProgress(15 + (((i + 1) / pages.length) * 75), `Memberi watermark halaman ${i + 1} dari ${pages.length}...`);
                const page = pages[i];
                const { width, height } = page.getSize();
                const textWidth = font.widthOfTextAtSize(payload.text, payload.fontSize);
                page.drawText(payload.text, {
                    x: width / 2 - (textWidth * Math.cos(Math.PI / 4)) / 2,
                    y: height / 2 - (textWidth * Math.sin(Math.PI / 4)) / 2,
                    size: payload.fontSize,
                    font: font,
                    color: rgbColor,
                    opacity: payload.opacity,
                    rotate: PDFLib.degrees(45),
                });
            }
            postProgress(94, 'Menyimpan PDF...');
            const outBytes = await pdfDoc.save();
            postProgress(100, 'Selesai!');
            self.postMessage({ taskId, type: 'done', result: { bytes: outBytes.buffer, pageCount: pages.length } }, [outBytes.buffer]);
        } else if (action === 'rotate') {
            postProgress(10, 'Memuat dokumen PDF...');
            const src = await PDFLib.PDFDocument.load(payload.bytes, { ignoreEncryption: true });
            const out = await PDFLib.PDFDocument.create();
            const activePages = payload.pages;
            for (let i = 0; i < activePages.length; i++) {
                postProgress(15 + (((i + 1) / activePages.length) * 75), `Memproses halaman ${i + 1} dari ${activePages.length}...`);
                const [copied] = await out.copyPages(src, [activePages[i].idx]);
                if (activePages[i].rot !== 0) {
                    const current = copied.getRotation().angle;
                    copied.setRotation(PDFLib.degrees((current + activePages[i].rot) % 360));
                }
                out.addPage(copied);
            }
            postProgress(94, 'Menyimpan PDF...');
            const outBytes = await out.save();
            postProgress(100, 'Selesai!');
            self.postMessage({ taskId, type: 'done', result: { bytes: outBytes.buffer, pageCount: activePages.length } }, [outBytes.buffer]);
        } else if (action === 'split_extract') {
            postProgress(15, 'Mengekstrak halaman terpilih...');
            const src = await PDFLib.PDFDocument.load(payload.bytes, { ignoreEncryption: true });
            const out = await PDFLib.PDFDocument.create();
            const indices = payload.indices;
            for (let i = 0; i < indices.length; i++) {
                postProgress(20 + (((i + 1) / indices.length) * 70), `Menyalin halaman ${i + 1} dari ${indices.length}...`);
                const [p] = await out.copyPages(src, [indices[i]]);
                out.addPage(p);
            }
            postProgress(94, 'Menyimpan PDF...');
            const outBytes = await out.save();
            postProgress(100, 'Selesai!');
            self.postMessage({ taskId, type: 'done', result: { bytes: outBytes.buffer } }, [outBytes.buffer]);
        } else if (action === 'img2pdf') {
            postProgress(10, 'Membuat dokumen PDF...');
            const pdfDoc = await PDFLib.PDFDocument.create();
            const items = payload.images;
            for (let i = 0; i < items.length; i++) {
                postProgress(15 + (((i + 1) / items.length) * 75), `Menyusun gambar ${i + 1} dari ${items.length}...`);
                const item = items[i];
                const embedded = item.isPng
                    ? await pdfDoc.embedPng(item.bytes)
                    : await pdfDoc.embedJpg(item.bytes);

                let pageW, pageH;
                if (payload.pageSize === 'fit') {
                    pageW = embedded.width;
                    pageH = embedded.height;
                } else {
                    pageW = 595.28;
                    pageH = 841.89;
                }
                const page = pdfDoc.addPage([pageW, pageH]);
                if (payload.pageSize === 'fit') {
                    page.drawImage(embedded, { x: 0, y: 0, width: pageW, height: pageH });
                } else {
                    const margin = 24;
                    const maxW = pageW - margin * 2;
                    const maxH = pageH - margin * 2;
                    const ratio = Math.min(maxW / embedded.width, maxH / embedded.height);
                    const drawW = embedded.width * ratio;
                    const drawH = embedded.height * ratio;
                    page.drawImage(embedded, {
                        x: (pageW - drawW) / 2,
                        y: (pageH - drawH) / 2,
                        width: drawW,
                        height: drawH,
                    });
                }
            }
            postProgress(94, 'Menyimpan PDF...');
            const outBytes = await pdfDoc.save();
            postProgress(100, 'Selesai!');
            self.postMessage({ taskId, type: 'done', result: { bytes: outBytes.buffer } }, [outBytes.buffer]);
        }
    } catch (err) {
        self.postMessage({ taskId, type: 'error', error: err.message || 'Terjadi kesalahan pada worker.' });
    }
};
