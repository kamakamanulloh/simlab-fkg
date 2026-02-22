@extends('layouts.app')
@section('title', 'Pemeliharaan & Kalibrasi - SIM-Lab')
@section('content')

{{-- Pastikan data di-pass dari Controller, jika tidak, tentukan nilai default --}}
@php
    $summary = $summary ?? [];
    $maintenances = $maintenances ?? [];
    $upcoming = $upcoming ?? [];
    $calibrations = $calibrations ?? []; // BARU
    $cost_summary = $cost_summary ?? []; // BARU
    $cost_trend = $cost_trend ?? []; // BARU
    $bulanIni = $bulanIni ?? Carbon\Carbon::now()->monthName . ' ' . Carbon\Carbon::now()->year;
@endphp

{{-- HEADER HALAMAN --}}
<div class="flex items-start justify-between gap-4 mb-5">
    <div>
        <h1 class="text-2xl font-semibold text-emerald-900">Pemeliharaan & Kalibrasi</h1>
        <p class="text-sm text-emerald-700">
            Kelola jadwal pemeliharaan preventif, korektif, dan kalibrasi peralatan
        </p>
    </div>

    <div class="flex items-center gap-3">
         <button
    id="btnOpenMaintenanceModal"
    class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2 text-xs font-medium text-white shadow-lg shadow-emerald-300/40 hover:bg-emerald-700">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
        <path stroke-linecap="round" stroke-linejoin="round"
            d="M12 4v16m8-8H4"/>
    </svg>
    Jadwalkan Pemeliharaan
</button>

       <button
    id="btnOpenMaintenanceModal"
    class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2 text-xs font-medium text-white shadow-lg shadow-emerald-300/40 hover:bg-emerald-700">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
        <path stroke-linecap="round" stroke-linejoin="round"
            d="M12 4v16m8-8H4"/>
    </svg>
    Jadwalkan Pemeliharaan
</button>

    </div>
</div>

{{-- CARD SUMMARY --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-5">
    {{-- Pemeliharaan Bulan Ini --}}
    <div class="bg-white rounded-xl p-4 shadow-sm border border-emerald-50 flex flex-col justify-between h-full">
        <div class="flex items-center justify-between">
            <div class="text-xs text-slate-500">Pemeliharaan Bulan Ini</div>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
        </div>
        <div class="text-2xl font-bold text-emerald-900 mt-2">{{ $summary['pemeliharaan_selesai'] ?? 0 }}</div>
        <div class="text-[10px] text-slate-500 mt-1">{{ $summary['pemeliharaan_bulan_ini'] ?? '0 selesai' }}</div>
    </div>

    {{-- Kalibrasi Terjadwal --}}
    <div class="bg-white rounded-xl p-4 shadow-sm border border-emerald-50 flex flex-col justify-between h-full">
        <div class="flex items-center justify-between">
            <div class="text-xs text-slate-500">Kalibrasi Terjadwal</div>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c1.657 0 3 .895 3 2s-1.343 2-3 2v2m0-8V4m0 8v4m-5 3h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
        </div>
        <div class="text-2xl font-bold text-emerald-900 mt-2">{{ $summary['kalibrasi_terjadwal'] ?? 0 }}</div>
        <div class="text-[10px] text-slate-500 mt-1">{{ $summary['kalibrasi_30_hari'] ?? 'Dalam 30 hari' }}</div>
    </div>

    {{-- Kalibrasi Terlambat --}}
    <div class="bg-white rounded-xl p-4 shadow-sm border border-emerald-50 flex flex-col justify-between h-full">
        <div class="flex items-center justify-between">
            <div class="text-xs text-slate-500">Kalibrasi Terlambat</div>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.398 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
        <div class="text-2xl font-bold text-emerald-900 mt-2">{{ $summary['kalibrasi_terlambat'] ?? 0 }}</div>
        <div class="text-[10px] text-red-500 mt-1 font-medium">{{ $summary['kalibrasi_perlu_ditangani'] ?? 'Perlu segera ditangani' }}</div>
    </div>

    {{-- Biaya Bulan Ini --}}
    <div class="bg-white rounded-xl p-4 shadow-sm border border-emerald-50 flex flex-col justify-between h-full">
        <div class="flex items-center justify-between">
            <div class="text-xs text-slate-500">Biaya Bulan Ini</div>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
        </div>
        <div class="text-2xl font-bold text-emerald-900 mt-2">{{ $summary['biaya_bulan_ini'] ?? 'Rp 0' }}</div>
        <div class="text-[10px] text-emerald-700 mt-1">{{ $summary['biaya_persen'] ?? '0% dari bulan lalu' }}</div>
    </div>
</div>

{{-- GRID UTAMA: RIWAYAT + MENDATANG --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
    
    {{-- RIWAYAT PEMELIHARAAN/KALIBRASI/ANALISIS (2/3 Kolom) --}}
    <div class="lg:col-span-2 bg-white rounded-2xl p-5 shadow-sm border border-emerald-50">
        {{-- TAB SUB-MENU --}}
        <div x-data="{ activeSubTab: 'pemeliharaan' }">
            <div class="flex border-b border-slate-100 mb-5">
                <button
                    @click="activeSubTab = 'pemeliharaan'"
                    :class="{ 'border-b-2 border-emerald-600 font-semibold text-emerald-800': activeSubTab === 'pemeliharaan', 'text-slate-500 hover:bg-emerald-50': activeSubTab !== 'pemeliharaan' }"
                    class="px-4 py-2 text-sm transition duration-150 ease-in-out rounded-t-lg"
                >
                    Pemeliharaan
                </button>
                <button
                    @click="activeSubTab = 'kalibrasi'"
                    :class="{ 'border-b-2 border-emerald-600 font-semibold text-emerald-800': activeSubTab === 'kalibrasi', 'text-slate-500 hover:bg-emerald-50': activeSubTab !== 'kalibrasi' }"
                    class="px-4 py-2 text-sm transition duration-150 ease-in-out rounded-t-lg"
                >
                    Kalibrasi
                </button>
                <button
                    @click="activeSubTab = 'analisis'"
                    :class="{ 'border-b-2 border-emerald-600 font-semibold text-emerald-800': activeSubTab === 'analisis', 'text-slate-500 hover:bg-emerald-50': activeSubTab !== 'analisis' }"
                    class="px-4 py-2 text-sm transition duration-150 ease-in-out rounded-t-lg"
                >
                    Analisis Biaya
                </button>
            </div>

            {{-- =================================== --}}
            {{-- ISI SUB-TAB PEMELIHARAAN (default) --}}
            {{-- =================================== --}}
            <div x-show="activeSubTab === 'pemeliharaan'">
                <div class="mb-4">
                    <div class="text-sm font-semibold text-slate-800">Riwayat Pemeliharaan</div>
                    <div class="text-xs text-emerald-700">Daftar aktivitas pemeliharaan preventif dan korektif</div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-xs">
                        <thead>
                            <tr class="text-slate-500 text-left">
                                <th class="px-2 py-3">ID</th>
                                <th class="px-2 py-3">Peralatan</th>
                                <th class="px-2 py-3">Jenis</th>
                                <th class="px-2 py-3">Tanggal</th>
                                <th class="px-2 py-3">Teknisi</th>
                                <th class="px-2 py-3">Biaya</th>
                                <th class="px-2 py-3">Status</th>
                                <th class="px-2 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100 text-slate-700">
                            @forelse($maintenances as $item)
                                @php
                                    $jenisClass = match($item['jenis']) {
                                        'Preventive' => 'bg-blue-100 text-blue-700',
                                        'Corrective' => 'bg-orange-100 text-orange-700',
                                        'Calibration' => 'bg-purple-100 text-purple-700',
                                        default => 'bg-gray-100 text-gray-700',
                                    };
                                @endphp
                                
                                <tr class="hover:bg-gray-50">
                                    <td class="px-2 py-3 font-medium">{{ $item['id'] }}</td>
                                    <td class="px-2 py-3">
                                        {{ $item['alat'] }}
                                        <div class="text-[10px] text-slate-500">{{ $item['eq_code'] }}</div>
                                    </td>
                                    <td class="px-2 py-3">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-medium {{ $jenisClass }}">
                                            {{ $item['jenis'] }}
                                        </span>
                                    </td>
                                    <td class="px-2 py-3">{{ $item['tanggal'] }}</td>
                                    <td class="px-2 py-3">{{ $item['teknisi'] }}</td>
                                    <td class="px-2 py-3">{{ $item['biaya'] }}</td>
                                    <td class="px-2 py-3">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-medium 
                                            @if($item['status'] == 'Selesai') bg-green-100 text-green-700
                                            @elseif($item['status'] == 'Terjadwal') bg-blue-100 text-blue-700
                                            @elseif($item['status'] == 'Berlangsung') bg-orange-100 text-orange-700
                                            @endif">
                                            {{ $item['status'] }}
                                        </span>
                                    </td>
                                    <td class="px-2 py-3">
                                        <button class="text-emerald-600 hover:text-emerald-800 font-medium">Detail</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-center text-slate-500">
                                        Tidak ada riwayat pemeliharaan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- =================================== --}}
            {{-- ISI SUB-TAB KALIBRASI (Gambar 1) --}}
            {{-- =================================== --}}
            <div x-show="activeSubTab === 'kalibrasi'">
                 <div class="mb-4">
                    <div class="text-sm font-semibold text-slate-800">Jadwal Kalibrasi Peralatan</div>
                    <div class="text-xs text-emerald-700">Tracking sertifikat kalibrasi dan jadwal ulang kalibrasi</div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-xs">
                        <thead>
                            <tr class="text-slate-500 text-left">
                                <th class="px-2 py-3">Peralatan</th>
                                <th class="px-2 py-3">Kalibrasi Terakhir</th>
                                <th class="px-2 py-3">Kalibrasi Berikutnya</th>
                                <th class="px-2 py-3">Vendor</th>
                                <th class="px-2 py-3">Status</th>
                                <th class="px-2 py-3">Sertifikat</th>
                                <th class="px-2 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100 text-slate-700">
                            @forelse($calibrations as $item)
                                @php
                                    $statusClass = match($item['status']) {
                                        'Terlambat' => 'bg-red-100 text-red-700',
                                        'Mendekati' => 'bg-yellow-100 text-yellow-700',
                                        'Terjadwal' => 'bg-blue-100 text-blue-700',
                                        'Valid' => 'bg-green-100 text-green-700',
                                        default => 'bg-gray-100 text-gray-700',
                                    };
                                @endphp
                                
                                <tr class="hover:bg-gray-50">
                                    <td class="px-2 py-3">
                                        {{ $item['alat'] }}
                                        <div class="text-[10px] text-slate-500">{{ $item['eq_code'] }}</div>
                                    </td>
                                    <td class="px-2 py-3">{{ $item['terakhir'] }}</td>
                                    <td class="px-2 py-3 font-medium text-slate-800">{{ $item['berikutnya'] }}</td>
                                    <td class="px-2 py-3">{{ $item['vendor'] }}</td>
                                    <td class="px-2 py-3">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-medium {{ $statusClass }}">
                                            {{ $item['status'] }}
                                        </span>
                                    </td>
                                    <td class="px-2 py-3">
                                        <button class="text-indigo-600 hover:text-indigo-800 font-medium">Sertifikat</button>
                                    </td>
                                    <td class="px-2 py-3">
                                        <button class="text-emerald-600 hover:text-emerald-800 font-medium">Jadwalkan</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-slate-500">
                                        Tidak ada jadwal kalibrasi yang tercatat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- =================================== --}}
            {{-- ISI SUB-TAB ANALISIS BIAYA (Gambar 2) --}}
            {{-- =================================== --}}
            <div x-show="activeSubTab === 'analisis'">
                 <div class="mb-4">
                    <div class="text-sm font-semibold text-slate-800">Ringkasan Biaya Pemeliharaan</div>
                    <div class="text-xs text-emerald-700">Breakdown biaya per kategori (dalam ribuan Rupiah)</div>
                </div>
                
                {{-- SUMMARY CARD BIAYA --}}
                <div class="grid grid-cols-3 gap-4 mb-6">
                    {{-- Preventif --}}
                    <div class="rounded-xl p-4 bg-blue-50/70 border border-blue-200">
                        <div class="text-xs font-semibold text-blue-700">Preventif</div>
                        <div class="text-xl font-bold text-slate-800 mt-1">Rp {{ $cost_summary['Preventif'] ?? 0 }}K</div>
                    </div>
                    {{-- Korektif --}}
                    <div class="rounded-xl p-4 bg-orange-50/70 border border-orange-200">
                        <div class="text-xs font-semibold text-orange-700">Korektif</div>
                        <div class="text-xl font-bold text-slate-800 mt-1">Rp {{ $cost_summary['Korektif'] ?? 0 }}K</div>
                    </div>
                    {{-- Kalibrasi --}}
                    <div class="rounded-xl p-4 bg-purple-50/70 border border-purple-200">
                        <div class="text-xs font-semibold text-purple-700">Kalibrasi</div>
                        <div class="text-xl font-bold text-slate-800 mt-1">Rp {{ $cost_summary['Kalibrasi'] ?? 0 }}K</div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="text-sm font-semibold text-slate-800">Trend Biaya 5 Bulan Terakhir</div>
                    <div class="text-xs text-slate-500">Visualisasi total biaya bulanan</div>
                </div>

                {{-- CHART/BAR TREND BIAYA --}}
                <div class="space-y-4">
                    @forelse($cost_trend as $trend)
                        <div>
                            <div class="flex items-center justify-between text-xs font-medium text-slate-700 mb-1">
                                <span>{{ $trend['bulan'] }}</span>
                                <span>Total: Rp {{ $trend['total'] }}K</span>
                            </div>
                            <div class="flex w-full h-4 rounded-full overflow-hidden text-[10px] font-medium">
                                @php
                                    $total = $trend['total'];
                                    $preventive_width = ($trend['preventive'] / $total) * 100;
                                    $corrective_width = ($trend['corrective'] / $total) * 100;
                                    $calibration_width = ($trend['calibration'] / $total) * 100;
                                @endphp
                                <div class="bg-blue-500 text-white flex items-center justify-center" style="width: {{ $preventive_width }}%">
                                    @if($preventive_width > 15) {{ $trend['preventive'] }}K @endif
                                </div>
                                <div class="bg-orange-500 text-white flex items-center justify-center" style="width: {{ $corrective_width }}%">
                                    @if($corrective_width > 15) {{ $trend['corrective'] }}K @endif
                                </div>
                                <div class="bg-purple-500 text-white flex items-center justify-center" style="width: {{ $calibration_width }}%">
                                    @if($calibration_width > 15) {{ $trend['calibration'] }}K @endif
                                </div>
                            </div>
                        </div>
                    @empty
                         <div class="text-center text-slate-500 py-10 text-sm border border-dashed rounded-xl">
                            Tidak ada data tren biaya untuk ditampilkan.
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>

    {{-- PEMELIHARAAN MENDATANG (1/3 Kolom) - Sama seperti sebelumnya --}}
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-emerald-50 h-fit">
        <div class="mb-4">
            <div class="text-sm font-semibold text-slate-800">Pemeliharaan Mendatang (30 Hari)</div>
            <div class="text-xs text-emerald-700">Jadwal yang akan datang di bulan {{ $bulanIni }}</div>
        </div>

        <div class="space-y-3">
            @forelse($upcoming as $item)
                <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50/70 border border-slate-100">
                    <div class="flex items-start gap-3">
                        {{-- Icon --}}
                        <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full {{ $item['icon_class'] }}">
                            @if(str_contains($item['judul'], 'Kalibrasi'))
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c1.657 0 3 .895 3 2s-1.343 2-3 2v2m0-8V4m0 8v4m-5 3h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                            @endif
                        </div>
                        
                        <div>
                            <div class="text-xs font-medium text-slate-800">{{ $item['judul'] }}</div>
                            <div class="text-[10px] text-slate-500">{{ $item['tanggal'] }} - {{ $item['eq_code'] }}</div>
                        </div>
                    </div>
                    
                    <div class="text-right text-[11px] font-semibold text-red-500 min-w-max">
                        {{ $item['sisa_hari'] }}
                    </div>
                </div>
            @empty
                <div class="text-center text-xs text-slate-500 py-3">
                    Tidak ada jadwal pemeliharaan mendatang.
                </div>
            @endforelse
        </div>
    </div>

</div>
{{-- MODAL JADWAL PEMELIHARAAN --}}
<div id="maintenanceModal"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">

    <div class="w-full max-w-lg rounded-2xl bg-white shadow-xl p-6 relative">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-semibold text-slate-800">
                Jadwalkan Pemeliharaan
            </h3>
            <button class="btnCloseModal text-slate-400 hover:text-slate-700">
                ✕
            </button>
        </div>

        {{-- Form --}}
        <form class="space-y-4 text-xs">

            <div>
                <label class="block mb-1 font-medium text-slate-700">Peralatan</label>
                <input type="text"
                       class="w-full rounded-lg border border-slate-200 px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500"
                       placeholder="Contoh: Autoclave">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block mb-1 font-medium text-slate-700">Jenis</label>
                    <select class="w-full rounded-lg border border-slate-200 px-3 py-2">
                        <option>Preventive</option>
                        <option>Corrective</option>
                        <option>Calibration</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-1 font-medium text-slate-700">Tanggal</label>
                    <input type="date"
                           class="w-full rounded-lg border border-slate-200 px-3 py-2">
                </div>
            </div>

            <div>
                <label class="block mb-1 font-medium text-slate-700">Teknisi / Vendor</label>
                <input type="text"
                       class="w-full rounded-lg border border-slate-200 px-3 py-2"
                       placeholder="Nama teknisi / vendor">
            </div>

            <div>
                <label class="block mb-1 font-medium text-slate-700">Catatan</label>
                <textarea rows="3"
                          class="w-full rounded-lg border border-slate-200 px-3 py-2"
                          placeholder="Catatan tambahan..."></textarea>
            </div>

            {{-- Footer --}}
            <div class="flex justify-end gap-2 pt-4">
                <button type="button"
                        class="btnCloseModal px-4 py-2 rounded-lg text-slate-600 hover:bg-slate-100">
                    Batal
                </button>
                <button type="submit"
                        class="px-4 py-2 rounded-lg bg-emerald-600 text-white hover:bg-emerald-700">
                    Simpan Jadwal
                </button>
            </div>

        </form>
    </div>
</div>

@endsection

@push('scripts')
    {{-- Memastikan Alpine.js dimuat untuk fungsionalitas tab --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js" defer></script> --}}
@endpush