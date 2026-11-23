@extends('layouts.simak')

@section('title', 'Pusat Bimbingan & Kalender Monitoring Jurnal • SIMAK-TMS')

@section('content')
<div class="space-y-6 min-w-0 max-w-full">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-black tracking-tight text-slate-900">Monitoring Logbook & Kalender Bimbingan</h1>
            <p class="text-xs text-slate-500 mt-0.5">Pantau kepatuhan logbook harian siswa PKL, deteksi hari bolong secara visual, dan sisipkan bimbingan teknis industri.</p>
        </div>

        <div class="flex items-center gap-2 bg-white px-3.5 py-1.5 rounded-xl border border-slate-200 text-xs shadow-xs">
            <span class="text-slate-400">Pembimbing:</span>
            <span class="font-bold text-red-600">{{ auth()->user()->name }}</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 uppercase">{{ auth()->user()->role }}</span>
        </div>
    </div>

    <!-- Filter Siswa & Info Bar -->
    <div class="mas-card p-4 sm:p-5 bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 text-white flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded bg-red-600 text-white shrink-0">
                    Filter Monitoring
                </span>
                <span class="text-xs text-slate-300 font-mono">Bulan: <b>November 2026</b></span>
            </div>
            <h2 class="text-base sm:text-lg font-black mt-1">
                @if($selectedStudent)
                    Monitoring Jurnal: <span class="text-amber-400">{{ $selectedStudent->name }}</span>
                @else
                    Monitoring Jurnal: <span class="text-emerald-400">Semua Siswa Bimbingan (Rekap Global)</span>
                @endif
            </h2>
            <p class="text-xs text-slate-300">
                @if($selectedStudent)
                    {{ $selectedStudent->school_origin ?? 'SMKN 1 Ciamis' }} • {{ $selectedStudent->major ?? 'PPLG' }} (ID: {{ $selectedStudent->account_id ?? $selectedStudent->id }})
                @else
                    Melihat rekap seluruh siswa bimbingan — tanggal hijau artinya semua mengisi, kuning sebagian, merah bolong.
                @endif
            </p>
        </div>

        <!-- Dropdown Selector Siswa -->
        <div class="w-full md:w-auto min-w-[280px] shrink-0">
            <label class="block text-[11px] font-bold text-slate-300 mb-1 flex items-center gap-1.5">
                <i data-lucide="filter" class="w-3.5 h-3.5 text-red-400"></i>
                <span>Pilih Siswa yang Dipantau:</span>
            </label>
            <select onchange="window.location.href = this.value" class="w-full px-3.5 py-2.5 bg-white/10 hover:bg-white/20 border border-white/20 rounded-xl text-xs font-bold text-white focus:outline-none focus:ring-2 focus:ring-red-500 cursor-pointer backdrop-blur-md">
                <option value="{{ route('mentor.review', ['student_id' => 'all', 'date' => $selectedDate]) }}" {{ $selectedStudentId === 'all' ? 'selected' : '' }} class="bg-slate-900 text-white font-bold">
                    👥 Semua Siswa Bimbingan ({{ $students->count() }} Siswa)
                </option>
                @foreach($students as $st)
                    <option value="{{ route('mentor.review', ['student_id' => $st->id, 'date' => $selectedDate]) }}" {{ $selectedStudentId == $st->id ? 'selected' : '' }} class="bg-slate-900 text-white font-semibold">
                        👤 {{ $st->name }} (ID: {{ $st->account_id ?? $st->id }}) - {{ $st->school_origin ?? 'Siswa' }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
        <div class="mas-card p-3 sm:p-4 border-l-4 border-l-emerald-600 flex items-center justify-between">
            <div>
                <p class="text-slate-400 text-[10px] sm:text-[11px] font-bold uppercase tracking-wider mb-0.5">Jurnal Terisi (Bulan Ini)</p>
                <h3 class="text-lg sm:text-2xl font-black text-slate-900 font-mono">{{ $totalJournalsMonth }} <span class="text-xs font-normal text-slate-500">Logbook</span></h3>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <i data-lucide="check-circle-2" class="w-5 h-5"></i>
            </div>
        </div>

        <div class="mas-card p-3 sm:p-4 border-l-4 border-l-rose-600 flex items-center justify-between">
            <div>
                <p class="text-slate-400 text-[10px] sm:text-[11px] font-bold uppercase tracking-wider mb-0.5">Total Hari Bolong</p>
                <h3 class="text-lg sm:text-2xl font-black text-rose-600 font-mono">{{ $totalMissedEntries }} <span class="text-xs font-normal text-slate-500">Missed</span></h3>
            </div>
            <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                <i data-lucide="alert-octagon" class="w-5 h-5"></i>
            </div>
        </div>

        <div class="mas-card p-3 sm:p-4 border-l-4 border-l-amber-500 flex items-center justify-between">
            <div>
                <p class="text-slate-400 text-[10px] sm:text-[11px] font-bold uppercase tracking-wider mb-0.5">Perlu Catatan Mentor</p>
                <h3 class="text-lg sm:text-2xl font-black text-amber-600 font-mono">{{ $pendingFeedbackCount }} <span class="text-xs font-normal text-slate-500">Logbook</span></h3>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <i data-lucide="message-square" class="w-5 h-5"></i>
            </div>
        </div>

        <div class="mas-card p-3 sm:p-4 border-l-4 border-l-slate-900 flex items-center justify-between">
            <div>
                <p class="text-slate-400 text-[10px] sm:text-[11px] font-bold uppercase tracking-wider mb-0.5">Sudah Diberi Catatan</p>
                <h3 class="text-lg sm:text-2xl font-black text-slate-900 font-mono">{{ $reviewedCount }} <span class="text-xs font-normal text-slate-500">Selesai</span></h3>
            </div>
            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-800 flex items-center justify-center shrink-0">
                <i data-lucide="award" class="w-5 h-5"></i>
            </div>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- KALENDER MONITORING LOGBOOK (GRID 7-KOLOM ALA JURNAL SISWA)    -->
    <!-- ============================================================== -->
    <div class="mas-card p-4 sm:p-6 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-3">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-xl bg-red-600 text-white flex items-center justify-center shrink-0">
                    <i data-lucide="calendar" class="w-4 h-4"></i>
                </div>
                <div>
                    <h3 class="text-sm font-black text-slate-900">Kalender Aktivitas Jurnal Siswa (November 2026)</h3>
                    <p class="text-[11px] text-slate-400">Klik salah satu tanggal kotak di bawah untuk melihat logbook detail dan siapa saja yang bolong.</p>
                </div>
            </div>

            <div class="text-xs font-mono font-bold text-slate-600 bg-slate-100 px-3 py-1 rounded-xl shrink-0">
                Tanggal Terpilih: <span class="text-red-600">{{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('d M Y') }}</span>
            </div>
        </div>

        <!-- Days of Week Header (SEN - MIN) -->
        <div class="grid grid-cols-7 gap-1.5 sm:gap-2 text-center text-[11px] font-bold text-slate-400 uppercase tracking-wider">
            <div class="py-1">Sen</div>
            <div class="py-1">Sel</div>
            <div class="py-1">Rab</div>
            <div class="py-1">Kam</div>
            <div class="py-1">Jum</div>
            <div class="py-1 text-slate-300">Sab</div>
            <div class="py-1 text-slate-300">Min</div>
        </div>

        <!-- Calendar Cells Grid -->
        <div class="grid grid-cols-7 gap-1.5 sm:gap-2">
            {{-- Leading empty cells for Oct 26-31 (1 Nov 2026 is Sunday -> 6 leading empty cells) --}}
            @for($i = 0; $i < $leadingEmptyDays; $i++)
                <div class="h-14 sm:h-16 rounded-xl bg-slate-50/40 border border-slate-100/60 opacity-20"></div>
            @endfor

            {{-- Days 1 to 30 of November 2026 --}}
            @for($d = 1; $d <= $daysInMonth; $d++)
                @php
                    $dayData = $calendarData[$d];
                    $dayStr = $dayData['date'];
                    $isSelected = ($selectedDate === $dayStr);
                    $status = $dayData['status'];
                    $jCount = $dayData['journals_count'];
                    $tCount = $dayData['target_count'];
                @endphp

                @if($status === 'filled' || $status === 'all_filled')
                    {{-- 1. TERISI LENGKAP (HIJAU RESMI) --}}
                    <a href="{{ route('mentor.review', ['student_id' => $selectedStudentId, 'date' => $dayStr]) }}#panel-detail-tanggal"
                       class="h-14 sm:h-16 rounded-xl flex flex-col items-center justify-between p-1.5 sm:p-2 transition-all cursor-pointer relative bg-emerald-50 border border-emerald-300 text-emerald-800 hover:bg-emerald-100/90 hover:shadow-xs
                              {{ $isSelected ? 'ring-2 ring-slate-900 ring-offset-2 z-10 scale-105 shadow-md' : 'hover:scale-102' }}"
                       title="{{ $dayStr }}: Jurnal terisi lengkap ({{ $jCount }}/{{ $tCount }} siswa). Klik untuk melihat detail.">
                        <div class="w-full flex items-center justify-between">
                            <span class="text-xs sm:text-sm font-black text-emerald-800 leading-none">{{ $d }}</span>
                            <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-emerald-600"></i>
                        </div>
                        <span class="text-[9px] sm:text-[10px] font-mono font-bold px-1.5 py-0.5 rounded bg-emerald-200/80 text-emerald-900 leading-none">
                            @if($selectedStudentId !== 'all')
                                Diisi
                            @else
                                {{ $jCount }}/{{ $tCount }}
                            @endif
                        </span>
                    </a>

                @elseif($status === 'partial')
                    {{-- 2. SEBAGIAN MENGISI / SEBAGIAN BOLONG (KUNING / ORANYE) --}}
                    <a href="{{ route('mentor.review', ['student_id' => $selectedStudentId, 'date' => $dayStr]) }}#panel-detail-tanggal"
                       class="h-14 sm:h-16 rounded-xl flex flex-col items-center justify-between p-1.5 sm:p-2 transition-all cursor-pointer relative bg-amber-50 border border-amber-300 text-amber-900 hover:bg-amber-100/90 hover:shadow-xs
                              {{ $isSelected ? 'ring-2 ring-slate-900 ring-offset-2 z-10 scale-105 shadow-md' : 'hover:scale-102' }}"
                       title="{{ $dayStr }}: Sebagian siswa mengisi ({{ $jCount }}/{{ $tCount }} siswa). Ada yang bolong!">
                        <div class="w-full flex items-center justify-between">
                            <span class="text-xs sm:text-sm font-black text-amber-900 leading-none">{{ $d }}</span>
                            <i data-lucide="alert-triangle" class="w-3.5 h-3.5 text-amber-600"></i>
                        </div>
                        <span class="text-[9px] sm:text-[10px] font-mono font-bold px-1.5 py-0.5 rounded bg-amber-200/90 text-amber-950 leading-none">
                            {{ $jCount }}/{{ $tCount }}
                        </span>
                    </a>

                @elseif($status === 'today_pending')
                    {{-- 3. HARI INI (AKTIF / BERJALAN) --}}
                    <a href="{{ route('mentor.review', ['student_id' => $selectedStudentId, 'date' => $dayStr]) }}#panel-detail-tanggal"
                       class="h-14 sm:h-16 rounded-xl flex flex-col items-center justify-between p-1.5 sm:p-2 transition-all cursor-pointer relative bg-sky-50 border-2 border-sky-500 text-sky-950 shadow-xs ring-2 ring-sky-500/20 hover:bg-sky-100/80
                              {{ $isSelected ? 'ring-2 ring-slate-900 ring-offset-2 z-10 scale-105 shadow-md' : 'hover:scale-102' }}"
                       title="{{ $dayStr }} (Hari Ini): Klik untuk meninjau logbook aktif hari ini">
                        <div class="w-full flex items-center justify-between">
                            <span class="text-xs sm:text-sm font-black text-sky-950 leading-none">{{ $d }}</span>
                            <i data-lucide="clock" class="w-3.5 h-3.5 text-sky-600"></i>
                        </div>
                        <span class="text-[9px] sm:text-[10px] font-bold px-1.5 py-0.5 rounded bg-sky-200 text-sky-900 leading-none">
                            Hari Ini
                        </span>
                    </a>

                @elseif($status === 'missed')
                    {{-- 4. BOLONG DI HARI KERJA LAMPAU (MERAH / ROSE) --}}
                    <a href="{{ route('mentor.review', ['student_id' => $selectedStudentId, 'date' => $dayStr]) }}#panel-detail-tanggal"
                       class="h-14 sm:h-16 rounded-xl flex flex-col items-center justify-between p-1.5 sm:p-2 transition-all cursor-pointer relative bg-rose-50 border border-rose-300 text-rose-900 hover:bg-rose-100/90 hover:shadow-xs
                              {{ $isSelected ? 'ring-2 ring-slate-900 ring-offset-2 z-10 scale-105 shadow-md' : 'hover:scale-102' }}"
                       title="{{ $dayStr }} (Bolong): Hari kerja terlewat tanpa jurnal! Klik untuk melihat daftar siswa bolong.">
                        <div class="w-full flex items-center justify-between">
                            <span class="text-xs sm:text-sm font-black text-rose-900 leading-none">{{ $d }}</span>
                            <i data-lucide="alert-circle" class="w-3.5 h-3.5 text-rose-600"></i>
                        </div>
                        <span class="text-[9px] sm:text-[10px] font-bold px-1.5 py-0.5 rounded bg-rose-200 text-rose-950 leading-none">
                            Bolong
                        </span>
                    </a>

                @elseif($status === 'weekend')
                    {{-- 5. WEEKEND / LIBUR (ABU-ABU NETRAL) --}}
                    <a href="{{ route('mentor.review', ['student_id' => $selectedStudentId, 'date' => $dayStr]) }}#panel-detail-tanggal"
                       class="h-14 sm:h-16 rounded-xl flex flex-col items-center justify-between p-1.5 sm:p-2 transition-all cursor-pointer relative bg-slate-100/70 border border-slate-200/80 text-slate-400 hover:bg-slate-200/60
                              {{ $isSelected ? 'ring-2 ring-slate-900 ring-offset-2 z-10 scale-105 shadow-md' : '' }}"
                       title="{{ $dayStr }}: Hari Libur Akhir Pekan (Sabtu / Minggu)">
                        <div class="w-full flex items-center justify-between">
                            <span class="text-xs sm:text-sm font-semibold text-slate-500 leading-none">{{ $d }}</span>
                            <i data-lucide="coffee" class="w-3.5 h-3.5 text-slate-400"></i>
                        </div>
                        <span class="text-[9px] font-semibold text-slate-400 leading-none">
                            Libur
                        </span>
                    </a>

                @else
                    {{-- 6. FUTURE (BELUM TIBA) --}}
                    <div class="h-14 sm:h-16 rounded-xl flex flex-col items-center justify-between p-1.5 sm:p-2 bg-slate-50/50 border border-slate-200/60 text-slate-300 opacity-50 cursor-not-allowed select-none"
                         title="{{ $dayStr }}: Belum tiba waktunya">
                        <div class="w-full flex items-center justify-between">
                            <span class="text-xs sm:text-sm font-medium text-slate-400 leading-none">{{ $d }}</span>
                        </div>
                        <span class="text-[9px] font-bold text-slate-300 leading-none">-</span>
                    </div>
                @endif
            @endfor
        </div>

        <!-- Legend / Petunjuk Indikator Warna Kalender -->
        <div class="mt-4 pt-3.5 border-t border-slate-100 flex flex-wrap items-center gap-4 text-xs">
            <div class="flex items-center gap-2">
                <span class="w-5 h-5 rounded-lg bg-emerald-50 border border-emerald-300 flex items-center justify-center text-emerald-700 shadow-2xs">
                    <i data-lucide="check-circle-2" class="w-3 h-3"></i>
                </span>
                <span class="text-slate-700"><b class="text-emerald-700">Hijau:</b> Jurnal Terisi Lengkap</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-5 h-5 rounded-lg bg-amber-50 border border-amber-300 flex items-center justify-center text-amber-700 shadow-2xs">
                    <i data-lucide="alert-triangle" class="w-3 h-3"></i>
                </span>
                <span class="text-slate-700"><b class="text-amber-700">Kuning:</b> Sebagian Mengisi</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-5 h-5 rounded-lg bg-rose-50 border border-rose-300 flex items-center justify-center text-rose-700 shadow-2xs">
                    <i data-lucide="alert-circle" class="w-3 h-3"></i>
                </span>
                <span class="text-slate-700"><b class="text-rose-700">Merah:</b> Hari Kerja Bolong</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-5 h-5 rounded-lg bg-sky-50 border border-sky-400 flex items-center justify-center text-sky-700 shadow-2xs">
                    <i data-lucide="clock" class="w-3 h-3"></i>
                </span>
                <span class="text-slate-700"><b class="text-sky-700">Biru Muda:</b> Hari Ini</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-5 h-5 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400">
                    <i data-lucide="coffee" class="w-3 h-3"></i>
                </span>
                <span class="text-slate-500">Weekend / Libur</span>
            </div>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- PANEL DETAIL TANGGAL TERPILIH                                  -->
    <!-- ============================================================== -->
    <div id="panel-detail-tanggal" class="space-y-4">
        
        <!-- Header Panel Detail -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-200 pb-3">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-red-600 font-mono">Detail Aktivitas Tanggal Terpilih:</span>
                <h2 class="text-lg font-black text-slate-900 mt-0.5">
                    {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('l, d F Y') }}
                </h2>
            </div>
            <div class="flex items-center gap-2 text-xs">
                <span class="px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 font-bold">
                    {{ $selectedDateJournals->count() }} Mengisi Jurnal
                </span>
                @if($bolongStudents->count() > 0)
                    <span class="px-2.5 py-1 rounded-full bg-rose-50 text-rose-700 border border-rose-200 font-bold">
                        {{ $bolongStudents->count() }} Bolong / Belum Mengisi
                    </span>
                @endif
            </div>
        </div>

        <!-- SECTION A: SISWA YANG BOLONG PADA TANGGAL INI -->
        @if($bolongStudents->count() > 0)
            <div class="p-4 sm:p-5 rounded-2xl bg-rose-50/70 border border-rose-200 space-y-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-rose-600 text-white flex items-center justify-center shrink-0">
                            <i data-lucide="alert-octagon" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h3 class="text-xs font-black text-rose-900 uppercase tracking-wide">
                                Perhatian: {{ $bolongStudents->count() }} Siswa Tidak Mengisi Jurnal pada Hari Ini
                            </h3>
                            <p class="text-[11px] text-rose-700">Tanggal {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('d M Y') }} merupakan hari kerja aktif PKL, namun siswa berikut belum mendokumentasikan logbook:</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 pt-1">
                    @foreach($bolongStudents as $bStudent)
                        <div class="p-3 bg-white rounded-xl border border-rose-200 shadow-2xs flex items-center justify-between gap-3">
                            <div class="flex items-center gap-2.5">
                                <div class="w-9 h-9 rounded-xl bg-rose-100 text-rose-700 font-black flex items-center justify-center shrink-0 overflow-hidden">
                                    @if($bStudent->avatar)
                                        <img src="{{ asset($bStudent->avatar) }}" alt="{{ $bStudent->name }}" class="w-full h-full object-cover">
                                    @else
                                        <span>{{ strtoupper(substr($bStudent->name, 0, 1)) }}</span>
                                    @endif
                                </div>
                                <div>
                                    <div class="text-xs font-black text-slate-900 leading-tight">{{ $bStudent->name }}</div>
                                    <div class="text-[10px] text-slate-400 font-medium mt-0.5">
                                        ID: {{ $bStudent->account_id ?? $bStudent->id }} • {{ $bStudent->school_origin ?? 'SMKN 1 Ciamis' }}
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-1.5 shrink-0">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-rose-100 text-rose-800 border border-rose-200">
                                    Bolong
                                </span>
                                @if($bStudent->phone)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $bStudent->phone) }}?text=Halo%20{{ urlencode($bStudent->name) }},%20mohon%20segera%20lengkapi%20jurnal%20magang%20SIMAK-TMS%20untuk%20tanggal%20{{ urlencode(\Carbon\Carbon::parse($selectedDate)->translatedFormat('d M Y')) }}." target="_blank" class="px-2 py-1 rounded bg-emerald-600 hover:bg-emerald-700 text-white text-[10px] font-bold flex items-center gap-1 transition-colors">
                                        <i data-lucide="message-circle" class="w-3 h-3"></i>
                                        <span>WA</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- SECTION B: LOGBOOK JURNAL YANG SUDAH TERISI DI TANGGAL INI -->
        <div class="space-y-4">
            @forelse($selectedDateJournals as $journal)
                @php
                    $hasNote = !empty($journal->mentor_feedback);
                @endphp
                <div class="mas-card p-5 sm:p-6 space-y-4 border-l-4 {{ $hasNote ? 'border-l-emerald-500' : 'border-l-amber-500' }}">
                    
                    <!-- Header Bar of Journal -->
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-2 border-b border-slate-100 pb-3">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden shrink-0 flex items-center justify-center font-bold text-slate-700">
                                @if($journal->user && $journal->user->avatar)
                                    <img src="{{ asset($journal->user->avatar) }}" alt="{{ $journal->user->name }}" class="w-full h-full object-cover">
                                @else
                                    <span>{{ strtoupper(substr($journal->user->name ?? 'S', 0, 1)) }}</span>
                                @endif
                            </div>
                            <div>
                                <div class="flex flex-wrap items-center gap-2 text-xs">
                                    <span class="font-black text-slate-900">{{ $journal->user->name ?? 'Siswa Magang' }}</span>
                                    <span class="text-slate-400">•</span>
                                    <span class="text-slate-500 font-mono">{{ $journal->user->school_origin ?? 'SMKN 1 Ciamis' }}</span>
                                    <span class="text-slate-400">•</span>
                                    @if($hasNote)
                                        <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded bg-emerald-100 text-emerald-800">
                                            <i data-lucide="check" class="w-3 h-3"></i> Sudah Ada Catatan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded bg-amber-100 text-amber-800">
                                            <i data-lucide="clock" class="w-3 h-3"></i> Belum Diberi Catatan
                                        </span>
                                    @endif
                                </div>
                                <h3 class="text-base font-black text-slate-900 mt-1">{{ $journal->activity_title }}</h3>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 self-start sm:self-auto shrink-0">
                            @if($journal->commit_url)
                                <a href="{{ $journal->commit_url }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-slate-900 hover:bg-black text-white text-xs font-mono font-medium transition-colors flex items-center gap-1.5">
                                    <i data-lucide="git-commit" class="w-3.5 h-3.5 text-red-400"></i>
                                    <span>Commit Git</span>
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Journal Activity Detail -->
                    <div class="space-y-1">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Deskripsi Kegiatan / Log Koding Siswa:</span>
                        <div class="p-3.5 bg-slate-50 border border-slate-200/70 rounded-xl text-xs text-slate-700 leading-relaxed font-normal">
                            {{ $journal->activity_detail }}
                        </div>
                    </div>

                    <!-- Existing Mentor Note Display (if exists) -->
                    @if($hasNote)
                        <div class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs space-y-1">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-[10px] uppercase tracking-wider text-emerald-700 flex items-center gap-1.5">
                                    <i data-lucide="message-square-quote" class="w-3.5 h-3.5"></i>
                                    <span>Catatan Bimbingan Mentor (oleh {{ $journal->mentor->name ?? 'Staff Mentor' }}):</span>
                                </span>
                                <span class="text-[10px] text-emerald-600">Tersinkron di kalender logbook siswa</span>
                            </div>
                            <p class="font-medium text-emerald-950 pl-5 leading-relaxed">"{{ $journal->mentor_feedback }}"</p>
                        </div>
                    @endif

                    <!-- Form Sisipkan / Update Catatan Mentor -->
                    <form action="{{ route('mentor.journal.note', $journal->id) }}" method="POST" class="bg-slate-50/70 border border-slate-200/80 rounded-xl p-4 space-y-3">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1 flex items-center justify-between">
                                <span>{{ $hasNote ? 'Perbarui Catatan / Bimbingan Mentor' : 'Sisipkan Catatan / Bimbingan Mentor' }}</span>
                                <span class="text-[10px] text-slate-400 font-normal">Siswa akan membaca catatan ini pada kalender logbook pribadinya</span>
                            </label>
                            <textarea id="mentor-note-{{ $journal->id }}" name="mentor_feedback" rows="2" required
                                      placeholder="Sisipkan apresiasi, evaluasi penulisan kode, atau arahan bimbingan industri untuk siswa..."
                                      class="w-full bg-white border border-slate-200 rounded-xl p-3 text-xs text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 leading-relaxed">{{ old('mentor_feedback', $journal->mentor_feedback ?? '') }}</textarea>
                        </div>

                        <!-- Quick suggestion chips -->
                        <div class="flex flex-wrap items-center gap-1.5 text-[11px]">
                            <span class="text-slate-400 text-[10px] mr-1">Rekomendasi Cepat:</span>
                            <button type="button" onclick="setQuickNote('mentor-note-{{ $journal->id }}', 'Aktivitas terverifikasi dan memenuhi standar dokumentasi kerja PT. TMS.')" class="px-2.5 py-1 rounded-lg bg-white border border-slate-200 hover:border-red-300 hover:text-red-600 text-slate-600 transition-colors text-[10px] cursor-pointer">
                                Standar TMS Terpenuhi
                            </button>
                            <button type="button" onclick="setQuickNote('mentor-note-{{ $journal->id }}', 'Struktur kode dan alur commit Git rapi. Pertahankan penamaan commit yang deskriptif.')" class="px-2.5 py-1 rounded-lg bg-white border border-slate-200 hover:border-red-300 hover:text-red-600 text-slate-600 transition-colors text-[10px] cursor-pointer">
                                Git Commit Rapi
                            </button>
                            <button type="button" onclick="setQuickNote('mentor-note-{{ $journal->id }}', 'Bagus, implementasi logika fitur sudah sesuai arsitektur. Lanjutkan ke sprint berikutnya.')" class="px-2.5 py-1 rounded-lg bg-white border border-slate-200 hover:border-red-300 hover:text-red-600 text-slate-600 transition-colors text-[10px] cursor-pointer">
                                Sesuai Arsitektur
                            </button>
                        </div>

                        <div class="flex items-center justify-end pt-1">
                            <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold bg-slate-900 hover:bg-black text-white transition-all shadow-xs flex items-center gap-1.5 cursor-pointer">
                                <i data-lucide="send" class="w-3.5 h-3.5 text-emerald-400"></i>
                                <span>{{ $hasNote ? 'Perbarui Catatan Mentor' : 'Simpan Catatan Mentor' }}</span>
                            </button>
                        </div>
                    </form>
                </div>
            @empty
                @if($bolongStudents->isEmpty())
                    <div class="mas-card p-8 text-center text-slate-400 text-xs">
                        <i data-lucide="calendar" class="w-8 h-8 mx-auto text-slate-300 mb-2"></i>
                        <p class="font-medium">Tidak ada logbook jurnal pada tanggal {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('d F Y') }}.</p>
                        <p class="text-[11px] text-slate-400 mt-1">Pilih tanggal lain di kalender atas untuk meninjau logbook harian siswa.</p>
                    </div>
                @endif
            @endforelse
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- SECTION 2: PENILAIAN MODUL TUGAS SISWA                         -->
    <!-- ============================================================== -->
    <div class="space-y-3 pt-6 border-t border-slate-200">
        <div class="flex items-center justify-between">
            <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center gap-2">
                <span>Penilaian Modul Tugas & Submission</span>
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-red-50 text-red-600 border border-red-200">
                    {{ $pendingSubmissions->count() }} Perlu Penilaian
                </span>
            </h2>
        </div>

        <div class="space-y-4">
            @forelse($pendingSubmissions as $sub)
                <div class="mas-card p-5 sm:p-6 space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-2 border-b border-slate-100 pb-3">
                        <div>
                            <div class="text-xs text-slate-500">Siswa: <b class="text-slate-800">{{ $sub->user->name }}</b> ({{ $sub->user->school_origin }})</div>
                            <h3 class="text-base font-bold text-slate-900 mt-0.5">{{ $sub->task->title }}</h3>
                        </div>
                        <div class="text-xs text-slate-400 font-mono">Disubmit: {{ $sub->created_at->diffForHumans() }}</div>
                    </div>

                    <div class="space-y-1 text-xs text-slate-600">
                        @if($sub->submission_url)
                            <div>Pull Request: <a href="{{ $sub->submission_url }}" target="_blank" class="text-red-600 hover:underline font-mono">{{ $sub->submission_url }}</a></div>
                        @endif
                        @if($sub->notes)
                            <div class="text-slate-500 italic">"{{ $sub->notes }}"</div>
                        @endif
                    </div>

                    <!-- Grading Form -->
                    <form action="{{ route('mentor.task.grade', $sub->id) }}" method="POST" class="bg-slate-50 border border-slate-200/80 rounded-xl p-4 space-y-3">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                            <div>
                                <label class="block text-[11px] text-slate-600 font-medium mb-1">Nilai Modul (0 - 100)</label>
                                <input type="number" name="score" value="95" min="0" max="100" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-xs text-slate-800 font-mono focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                            </div>
                            <div class="sm:col-span-3">
                                <label class="block text-[11px] text-slate-600 font-medium mb-1">Feedback Teknis & Arahan Koding</label>
                                <input type="text" name="feedback" value="Implementasi REST API rapi, validasi request sudah lengkap. Pertahankan clean code." class="w-full bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold bg-red-600 hover:bg-red-700 text-white transition-all shadow-sm flex items-center gap-1.5 cursor-pointer">
                                <span>Simpan Nilai & Berikan Feedback</span>
                                <i data-lucide="send" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                    </form>
                </div>
            @empty
                <div class="mas-card p-6 text-center text-slate-400 text-xs">
                    Semua tugas telah dinilai. Tidak ada antrean tugas aktif saat ini.
                </div>
            @endforelse
        </div>
    </div>

</div>

<script>
function setQuickNote(elementId, text) {
    const el = document.getElementById(elementId);
    if (el) {
        el.value = text;
        el.focus();
    }
}
</script>
@endsection
