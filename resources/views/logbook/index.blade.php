@extends('layouts.app')
@section('title', 'Logbook Digital - SIM-Lab')
@section('content')

{{-- Pastikan ini di-pass dari Controller, jika tidak, tentukan nilai default --}}
@php
    // Set data default jika tidak di-pass (sebagai fallback)
    $summary = $summary ?? ['total_entry' => 0, 'dinilai' => 0, 'menunggu' => 0, 'rata_rata' => 0];
    $student = $student ?? ['nama' => 'Nama Mahasiswa', 'nim' => '0000', 'semester' => 0, 'progress_percent' => 0];
    $competencies = $competencies ?? [];
    $remediations = $remediations ?? [];
    $bests = $bests ?? [];
    $logEntries = $logEntries ?? []; // Akan kita buat dummy-nya di bawah
@endphp

{{-- HEADER HALAMAN LOGBOOK --}}
<div class="flex items-start justify-between gap-4 mb-5">
    <div>
        <h1 class="text-2xl font-semibold text-emerald-900">Logbook Kegiatan Digital</h1>
        <p class="text-sm text-emerald-700">
            Dokumentasi dan penilaian aktivitas praktikum mahasiswa
        </p>
    </div>

 <div class="flex items-center gap-3">

    {{-- Tombol Buat Pelatihan --}}
    <button  id="btnBuatPelatihan"
        class="inline-flex items-center gap-2 rounded-xl border border-emerald-200 bg-white px-4 py-2 text-xs font-medium text-emerald-800 shadow-sm hover:bg-emerald-50 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 4v16m8-8H4"/>
        </svg>
        Buat Pelatihan
    </button>

    {{-- Tombol Export --}}
    <button
        class="inline-flex items-center gap-2 rounded-xl bg-emerald-700 px-4 py-2 text-xs font-medium text-white shadow-lg shadow-emerald-300/40 hover:bg-emerald-800 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M16 12l-4-4m0 0L8 12m4-4v12"/>
        </svg>
        Export Portfolio
    </button>

</div>
</div>

<div class="bg-white rounded-2xl p-5 shadow-sm border border-emerald-50">
    {{-- PASTIKAN x-data ADA DI DIV PEMBUNGKUS TAB INI --}}
    <div x-data="{ activeTab: 'logbook' }"> 
        
        {{-- TAB HEADERS --}}
        <div class="flex border-b border-emerald-100 mb-5">
            <button
                @click="activeTab = 'logbook'" {{-- PENTING: @click untuk ganti state --}}
                :class="{ 'border-b-2 border-emerald-600 font-semibold text-emerald-800': activeTab === 'logbook', 'text-slate-500 hover:bg-emerald-50': activeTab !== 'logbook' }"
                class="px-5 py-2.5 text-sm transition duration-150 ease-in-out rounded-t-xl"
            >
                Entri Logbook
            </button>
            <button
                @click="activeTab = 'kompetensi'" {{-- PENTING: @click untuk ganti state --}}
                :class="{ 'border-b-2 border-emerald-600 font-semibold text-emerald-800': activeTab === 'kompetensi', 'text-slate-500 hover:bg-emerald-50': activeTab !== 'kompetensi' }"
                class="px-5 py-2.5 text-sm transition duration-150 ease-in-out rounded-t-xl"
            >
                Capaian Kompetensi
            </button>
        </div>

        {{-- ================================================= --}}
        {{-- TAB CONTENT: ENTRI LOGBOOK (Gambar 1 & 4) --}}
        {{-- ================================================= --}}
        <div x-show="activeTab === 'logbook'" class="space-y-5">
            <h2 class="text-lg font-medium text-slate-800">Logbook Digital</h2>
            {{-- RINGKASAN LOGBOOK --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                {{-- Total Entri --}}
                <div class="bg-white rounded-xl p-4 shadow-sm border border-emerald-50 flex items-center justify-between">
                    <div>
                        <div class="text-xs text-slate-500 flex items-center gap-1">Total Entri</div>
                        <div class="text-2xl font-bold text-emerald-900 mt-1">{{ $summary['total_entry'] }}</div>
                        <div class="text-[10px] text-slate-500">Minggu ini</div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>

                {{-- Sudah Dinilai --}}
                <div class="bg-white rounded-xl p-4 shadow-sm border border-emerald-50 flex items-center justify-between">
                    <div>
                        <div class="text-xs text-slate-500 flex items-center gap-1">Sudah Dinilai</div>
                        <div class="text-2xl font-bold text-emerald-900 mt-1">{{ $summary['dinilai'] }}</div>
                        <div class="text-[10px] text-slate-500">Dari {{ $summary['total_entry'] }} entri</div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>

                {{-- Menunggu Review --}}
                <div class="bg-white rounded-xl p-4 shadow-sm border border-emerald-50 flex items-center justify-between">
                    <div>
                        <div class="text-2xl font-bold text-emerald-900 mt-1">{{ $summary['menunggu'] }}</div>
                        <div class="text-[10px] text-slate-500">Perlu dinilai</div>
                    </div>
                    <div class="text-xs text-slate-500 flex items-center gap-1">Menunggu Review</div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>

                {{-- Rata-rata Nilai --}}
                <div class="bg-white rounded-xl p-4 shadow-sm border border-emerald-50 flex items-center justify-between">
                    <div>
                        <div class="text-xs text-slate-500 flex items-center gap-1">Rata-rata Nilai</div>
                        <div class="text-2xl font-bold text-emerald-900 mt-1">{{ number_format($summary['rata_rata'], 1) }}</div>
                        <div class="text-[10px] text-slate-500">Dari 18 sesi dinilai</div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.152A1.517 1.517 0 009.43 1.948 1.517 1.517 0 007.81 2.152L4.69 8.216A1.517 1.517 0 004.5 8.784v6.432a1.517 1.517 0 00.19.568l3.12 6.064a1.517 1.517 0 001.62.204l3.12-6.064a1.517 1.517 0 00.19-.568V8.784a1.517 1.517 0 00-.19-.568L11.049 2.152z"/></svg>
                </div>
            </div>

            {{-- DAFTAR ENTRI LOGBOOK (Riwayat aktivitas) --}}
            <div class="bg-white rounded-2xl p-5 border border-emerald-50">
                <h3 class="text-sm font-semibold text-slate-800 mb-3">Daftar Entri Logbook</h3>
                <p class="text-xs text-emerald-700 mb-4">Riwayat aktivitas praktikum dan penilaian</p>

                {{-- Dummy Data Entries (untuk tampilan) --}}
                @php
                    $logEntries = [
                        [
                            'mahasiswa' => 'Muhammad Rizki', 'nim' => '2021001', 'tanggal' => '2025-11-05', 'status' => 'Dinilai',
                            'sesi' => 'Praktikum Endodontik - Sesi 1', 'aktivitas' => ['Preparasi akses kavitas', 'Cleaning & shaping', 'Obturasi'],
                            'penilaian' => [
                                ['nama' => 'Diagnosis', 'nilai' => 85],
                                ['nama' => 'Preparasi', 'nilai' => 90],
                                ['nama' => 'Obturasi', 'nilai' => 88],
                            ],
                            'feedback' => 'Teknik preparasi sudah baik. Perhatikan kedalaman kerja.',
                            'lampiran_count' => 3
                        ],
                        [
                            'mahasiswa' => 'Siti Aminah', 'nim' => '2021045', 'tanggal' => '2025-11-05', 'status' => 'Menunggu',
                            'sesi' => 'Praktikum Periodonsia - Sesi 2', 'aktivitas' => ['Scaling supragingival', 'Root planing', 'Polishing'],
                            'penilaian' => [], // Belum dinilai
                            'feedback' => null,
                            'lampiran_count' => 1
                        ],
                    ];
                @endphp

                @foreach($logEntries as $entry)
                    <div class="border border-emerald-100 p-4 rounded-xl mb-4 transition duration-200">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                {{-- Initial Mahasiswa --}}
                                @php
                                    $initials = strtoupper(implode('', array_map(fn($word) => $word[0], explode(' ', $entry['mahasiswa']))));
                                    $bg_color = $entry['status'] == 'Dinilai' ? 'bg-emerald-100' : 'bg-indigo-100';
                                    $text_color = $entry['status'] == 'Dinilai' ? 'text-emerald-700' : 'text-indigo-700';
                                @endphp
                                <div class="w-10 h-10 {{ $bg_color }} {{ $text_color }} flex items-center justify-center rounded-full text-sm font-semibold">{{ $initials }}</div>

                                <div>
                                    <div class="text-sm font-medium text-slate-800">{{ $entry['mahasiswa'] }}</div>
                                    <div class="text-[11px] text-slate-500">{{ $entry['nim'] }} • {{ $entry['tanggal'] }}</div>
                                    <div class="text-xs text-emerald-700 mt-1">
                                        Sesi: **{{ $entry['sesi'] }}**
                                    </div>
                                </div>
                            </div>

                            <div class="flex-shrink-0 text-right">
                                @if($entry['status'] === 'Dinilai')
                                    <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-3 py-1 text-[10px] font-medium text-green-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        Dinilai
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-3 py-1 text-[10px] font-medium text-amber-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3"/></svg>
                                        Menunggu
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Detail Aktivitas dan Penilaian --}}
                        <div class="mt-4 pl-14"> {{-- Padding disesuaikan dengan tinggi Initial --}}
                            <div class="text-xs font-medium text-slate-600 mb-2">Aktivitas</div>
                            <div class="flex gap-2 text-[10px] font-medium mb-4">
                                @foreach($entry['aktivitas'] as $aktivitas)
                                    <span class="rounded-full bg-emerald-50 px-2 py-1 text-emerald-700">{{ $aktivitas }}</span>
                                @endforeach
                            </div>

                            @if($entry['status'] === 'Dinilai')
                                <div class="grid grid-cols-3 gap-3">
                                    @foreach($entry['penilaian'] as $kompetensi)
                                        <div class="text-center">
                                            <div class="text-xs font-medium text-slate-700">{{ $kompetensi['nama'] }}</div>
                                            <div class="text-xl font-bold text-emerald-800">{{ $kompetensi['nilai'] }}</div>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Umpan Balik (Feedback) --}}
                                @if($entry['feedback'])
                                    <div class="bg-blue-50 border border-blue-200 p-3 rounded-xl mt-3 text-xs text-slate-700">
                                        <div class="font-semibold text-blue-700 mb-1">Umpan Balik - Prof. Dr. Ahmad Santoso</div>
                                        {{ $entry['feedback'] }}
                                    </div>
                                @endif

                                {{-- Lampiran --}}
                                <div class="flex justify-between items-center mt-3 text-xs text-slate-500">
                                    <span>{{ $entry['lampiran_count'] }} lampiran</span>
                                    <button class="text-emerald-700 font-medium hover:underline">Detail</button>
                                </div>
                            @else
                                {{-- Tombol "Beri Nilai" untuk status Menunggu --}}
                                <div class="flex justify-end pt-2">
                                    <button
                                        class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2 text-xs font-medium text-white shadow-lg shadow-emerald-300/40 hover:bg-emerald-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Beri Nilai
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach

            </div>
        </div>

        {{-- ================================================= --}}
        {{-- TAB CONTENT: CAPAIAN KOMPETENSI (Gambar 2 & 3) --}}
        {{-- ================================================= --}}
        <div x-show="activeTab === 'kompetensi'" class="space-y-5">
            <h2 class="text-lg font-medium text-slate-800">Capaian Kompetensi</h2>
            
            {{-- RINGKASAN CAPAIAN MAHASISWA --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-emerald-50">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-emerald-100 text-emerald-700 flex items-center justify-center rounded-full text-lg font-semibold">
                            {{ strtoupper(implode('', array_map(fn($word) => $word[0], explode(' ', $student['nama'])))) }}
                        </div>
                        <div>
                            <div class="text-lg font-medium text-slate-800">{{ $student['nama'] }}</div>
                            <div class="text-sm text-slate-500">{{ $student['nim'] }} • Semester {{ $student['semester'] }}</div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-xl font-bold text-emerald-700">{{ $student['progress_percent'] }}% Selesai</div>
                        <div class="text-xs text-slate-500 mt-1">Progress Sesi Praktikum</div>
                        <div class="text-xs text-slate-500">{{ 24 * ($student['progress_percent']/100) }}/24 sesi</div>
                    </div>
                </div>

                {{-- Progress Bar Sesi Praktikum --}}
                <div class="w-full h-2.5 rounded-full bg-slate-100 overflow-hidden mb-8">
                    <div class="h-full bg-emerald-600 rounded-full" style="width: {{ $student['progress_percent'] }}%"></div>
                </div>

                <h3 class="text-md font-semibold text-slate-800 mb-3">Capaian Kompetensi per Kategori</h3>
                <p class="text-xs text-emerald-700 mb-4">Progress dan rata-rata nilai per bidang kompetensi</p>
                
                {{-- Daftar Kategori Kompetensi --}}
                @foreach($competencies as $comp)
                    <div class="mb-4">
                        <div class="flex items-center justify-between text-sm text-slate-800 mb-1">
                            <div class="font-medium">{{ $comp['nama'] }}</div>
                            <div class="text-right">
                                <span class="text-xl font-bold text-amber-700">{{ $comp['rata_rata'] }}</span>
                                <span class="text-xs text-slate-500">Rata-rata</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between text-xs text-slate-500 mb-1">
                            <span>{{ $comp['capaian_count'] }}/{{ $comp['total_count'] }} kompetensi tercapai</span>
                            <span>{{ $comp['persen'] }}% selesai</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                            <div class="h-full bg-emerald-600 rounded-full" style="width: {{ $comp['persen'] }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- KOMPETENSI PERLU REMEDIASI & PENCAPAIAN TERBAIK (Grid) --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

                {{-- KOMPETENSI PERLU REMEDIASI --}}
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-emerald-50">
                    <h3 class="text-sm font-semibold text-slate-800 mb-3">Kompetensi Perlu Remidiasi</h3>
                    <div class="space-y-2">
                        @foreach($remediations as $remediasi)
                            <div class="flex items-center justify-between rounded-xl bg-red-50/40 px-4 py-2 text-xs border border-red-100">
                                <div>
                                    <div class="font-medium text-slate-800">{{ $remediasi['nama'] }}</div>
                                    <div class="text-[10px] text-slate-500">{{ $remediasi['bidang'] }}</div>
                                </div>
                                <div class="font-bold text-red-700 text-base bg-red-200 rounded-full w-8 h-8 flex items-center justify-center">{{ $remediasi['nilai'] }}</div>
                            </div>
                        @endforeach
                        <div class="text-[10px] text-slate-500 pt-2">Nilai minimal: 70</div>
                    </div>
                </div>

                {{-- PENCAPAIAN TERBAIK --}}
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-emerald-50">
                    <h3 class="text-sm font-semibold text-slate-800 mb-3">Pencapaian Terbaik</h3>
                    <div class="space-y-2">
                        @foreach($bests as $best)
                            <div class="flex items-center justify-between rounded-xl bg-green-50/40 px-4 py-2 text-xs border border-green-100">
                                <div>
                                    <div class="font-medium text-slate-800">{{ $best['nama'] }}</div>
                                    <div class="text-[10px] text-slate-500">{{ $best['bidang'] }}</div>
                                </div>
                                <div class="font-bold text-green-700 text-base bg-green-200 rounded-full w-8 h-8 flex items-center justify-center">{{ $best['nilai'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- MODAL INPUT PELATIHAN --}}
<div id="modalPelatihan"
    class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/40 backdrop-blur-sm overflow-y-auto">

       <div class="min-h-screen flex items-start justify-center p-6 py-10">
         <div class="w-full max-w-4xl bg-white rounded-3xl shadow-2xl max-h-[95vh] flex flex-col">

        {{-- HEADER --}}
        <div class="flex items-center justify-between px-6 py-4 bg-slate-100 border-b">
            <h2 class="text-sm font-semibold text-slate-800">
                Input Data Pelatihan
            </h2>
            <button id="closePelatihan"
                class="text-slate-500 hover:text-slate-800 text-lg">✕</button>
        </div>

       <form id="formPelatihan"
      data-url="{{ route('pelatihan.store') }}"
      class="flex-1 overflow-y-auto p-6 space-y-5 text-xs">
            @csrf

            {{-- BASIC INFO --}}
            <div class="space-y-3">

                <div>
                    <label class="block mb-1 font-medium">Nama Pelatihan</label>
                    <input type="text" name="nama_pelatihan"
                        class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-2">
                </div>

                <div>
                    <label class="block mb-1 font-medium">Jenis Pelatihan</label>
                    <select name="jenis_pelatihan"
                        class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-2">
                        <option>Skill Lab</option>
                        <option>Workshop</option>
                        <option>Seminar</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-1 font-medium">Lokasi / Ruangan</label>
                    <input type="text" name="lokasi"
                        class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-2">
                </div>

                <div>
                    <label class="block mb-1 font-medium">Level Pelatihan</label>
                    <select name="level"
                        class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-2">
                        <option>Basic</option>
                        <option>Intermediate</option>
                        <option>Advanced</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-1 font-medium">Jumlah Kuota</label>
                    <input type="number" name="kuota"
                        class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-2">
                </div>

            </div>

            {{-- KESIAPAN SARANA --}}
            <div class="rounded-2xl border border-slate-200 overflow-hidden">
                <div class="bg-slate-100 px-4 py-2 font-semibold text-slate-700">
                    Kesiapan Sarana
                </div>

                <div class="p-4 space-y-4">

                    {{-- Alat --}}
                    <div>
                        <label class="block mb-2 font-medium">Alat & Instrumen</label>
                        <div class="flex gap-6">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="alat_status" value="Siap Digunakan">
                                Siap Digunakan
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="alat_status" value="Perlu Cek">
                                Perlu Cek
                            </label>
                        </div>
                    </div>

                    {{-- Bahan --}}
                    <div>
                        <label class="block mb-2 font-medium">Ketersediaan Bahan/Material</label>
                        <div class="flex gap-6">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="bahan_status" value="Lengkap">
                                Lengkap
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="bahan_status" value="Kurang">
                                Kurang
                            </label>
                        </div>
                    </div>

                </div>
            </div>

            {{-- PROTOKOL K3 --}}
            <div class="rounded-2xl border border-slate-200 overflow-hidden">
                <div class="bg-slate-100 px-4 py-2 font-semibold text-slate-700">
                    Protokol Kesehatan & K3
                </div>

                <div class="p-4">
                    <div class="flex gap-6">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="k3_status" value="Sesuai Standar">
                            Sesuai Standar
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="k3_status" value="Belum Memenuhi">
                            Belum Memenuhi
                        </label>
                    </div>
                </div>
            </div>

            {{-- MATERI --}}
            <div class="rounded-2xl border border-slate-200 overflow-hidden">
                <div class="bg-slate-100 px-4 py-2 font-semibold text-slate-700">
                    Materi & Evaluasi
                </div>
                <div class="p-4">
                    <textarea name="materi"
                        class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-2"
                        rows="3"></textarea>
                </div>
            </div>

            {{-- STATUS AKHIR --}}
            <div>
                <div class="font-semibold text-slate-700 mb-2">
                    Status Akhir
                </div>

                <div class="grid grid-cols-2 gap-4">

                    <div>
                        <label class="block mb-1 font-medium">Status Pelaksanaan</label>
                        <select name="status_pelaksanaan"
                            class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-2">
                            <option>Terjadwal</option>
                            <option>Selesai</option>
                            <option>Dibatalkan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Hasil Pelatihan</label>
                        <select name="hasil"
                            class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-2">
                            <option>Proses</option>
                            <option>Lulus</option>
                            <option>Tidak Lulus</option>
                        </select>
                    </div>

                </div>
            </div>

            {{-- FOOTER --}}
            <div class="flex justify-end gap-3 pt-4 border-t">
                <button type="button"
                    id="cancelPelatihan"
                    class="px-4 py-2 rounded-xl border border-slate-300 bg-white hover:bg-slate-50">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2 rounded-xl bg-emerald-800 text-white hover:bg-emerald-900">
                    Simpan
                </button>
            </div>

        </form>
    </div>
    </div>
</div>
@endsection

@push('scripts')
    {{-- Memastikan Alpine.js dimuat jika diperlukan --}}
    {{-- <script src="//unpkg.com/alpinejs" defer></script> --}}
@endpush