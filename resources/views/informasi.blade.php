@extends('layouts.simak')

@section('title', 'Pusat Bantuan & Panduan • SIMAK-TMS')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900">Pusat Bantuan & SOP Magang</h1>
            <p class="text-xs text-slate-500 mt-1">Panduan alur magang, SOP git, dan saluran komunikasi pembimbing di PT. Teknologi Multi Sistem.</p>
        </div>
    </div>

    <!-- Contact Card -->
    <div class="mas-card p-6 border-l-4 border-l-red-600 space-y-4">
        <h2 class="text-lg font-bold text-slate-900">Hubungi Pembimbing Industri :</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs text-slate-600">
            <div class="space-y-1.5">
                <div>Instansi : <b class="text-slate-800">PT. Teknologi Multi Sistem</b></div>
                <div>Jam Kerja Lab : <span class="font-semibold text-slate-800">08.00 – 17.00 WIB</span></div>
                <div>Hari Kerja : <span class="font-semibold text-slate-800">Senin s/d Jumat</span></div>
            </div>
            <div class="space-y-1.5">
                <div>Mentor Software : <b class="text-slate-800">Farhan Ramadhan</b></div>
                <div>Kontak WhatsApp : <span class="text-red-600 font-mono font-bold">085223035426</span></div>
                <div>Alamat Lab : <span class="text-slate-700">Lab Software Engineering TMS</span></div>
            </div>
        </div>

        <div class="pt-2">
            <a href="https://wa.me/6285223035426?text=Halo%20Mentor%20Farhan,%20saya%20siswa%20magang%20SIMAK-TMS" target="_blank" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-xs transition-colors">
                <i data-lucide="message-circle" class="w-4 h-4"></i>
                <span>Hubungi Mentor via WhatsApp</span>
            </a>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="space-y-4">
        <h2 class="text-lg font-bold text-slate-900">Pertanyaan yang Sering Diajukan (F.A.Q)</h2>

        <div class="space-y-3">
            <details class="mas-card p-5 group cursor-pointer" open>
                <summary class="flex items-center justify-between font-bold text-sm text-slate-800">
                    <span>1. Mengapa staf industri butuh aplikasi SIMAK-TMS ini?</span>
                    <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 group-open:rotate-180 transition-transform"></i>
                </summary>
                <p class="text-xs text-slate-600 leading-relaxed mt-3 pt-3 border-t border-slate-100">
                    Sebelumnya, staf kantor kerap tidak mengetahui apa saja aktivitas dan karya yang dikerjakan oleh siswa PKL yang sedang magang. Melalui SIMAK-TMS yang terintegrasi LMS dan logbook, seluruh penugasan koding, progress harian, dan hasil karya siswa tercatat secara transparan dan permanen.
                </p>
            </details>

            <details class="mas-card p-5 group cursor-pointer">
                <summary class="flex items-center justify-between font-bold text-sm text-slate-800">
                    <span>2. Bagaimana alur pengumpulan tugas modul koding?</span>
                    <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 group-open:rotate-180 transition-transform"></i>
                </summary>
                <p class="text-xs text-slate-600 leading-relaxed mt-3 pt-3 border-t border-slate-100">
                    Siswa mengerjakan modul penugasan pada branch repository masing-masing, kemudian membuka Pull Request (PR) ke repository utama project. Tautan PR tersebut disubmit melalui menu <b>Modul Tugas LMS</b> agar mentor dapat melakukan code audit dan memberikan nilai.
                </p>
            </details>

            <details class="mas-card p-5 group cursor-pointer">
                <summary class="flex items-center justify-between font-bold text-sm text-slate-800">
                    <span>3. Kapan batas waktu pengisian jurnal kegiatan harian?</span>
                    <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 group-open:rotate-180 transition-transform"></i>
                </summary>
                <p class="text-xs text-slate-600 leading-relaxed mt-3 pt-3 border-t border-slate-100">
                    Jurnal harian wajib diisi setiap hari sebelum pukul <b>17.00 WIB</b>. Mentor industri akan melakukan validasi dan memberikan catatan evaluasi setiap sore hari.
                </p>
            </details>
        </div>
    </div>

</div>
@endsection
