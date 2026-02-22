@extends('layouts.app')
@section('title', 'Manajemen Limbah & K3 - SIM-Lab')

@section('content')

{{-- SETUP DATA DEFAULT --}}
@php
    $summary = $summary ?? [];
    $incidents = $incidents ?? [];
    $waste_logs = $waste_logs ?? [];
@endphp
<style>
.form-input {
    @apply w-full rounded-lg border border-slate-200 px-4 py-2 text-sm focus:ring-2 focus:ring-emerald-600 focus:outline-none;
}
</style>
<style>
.form-label {
    font-size: 13px;
    font-weight: 500;
    color: #1f2937;
    margin-bottom: 6px;
    display: block;
}

.form-input {
    width: 100%;
    border-radius: 12px;
    border: 1px solid transparent;
    background: #f0fdf4; /* hijau muda */
    padding: 12px 14px;
    font-size: 14px;
    color: #065f46;
    transition: all 0.2s ease;
}

.form-input::placeholder {
    color: #9ca3af;
}

.form-input:focus {
    outline: none;
    border-color: #10b981;
    background: #ecfdf5;
    box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.15);
}

.form-input[readonly] {
    background: #e5e7eb;
    color: #6b7280;
}
</style>


{{-- HEADER HALAMAN --}}
<div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-slate-800">Manajemen Limbah & K3</h1>
        <p class="text-sm text-slate-500 mt-1">
            Keselamatan kerja, pengelolaan limbah, dan kepatuhan lingkungan
        </p>
    </div>

    <div class="flex items-center gap-3">
        {{-- Tombol Laporan K3L (Putih/Outline) --}}
        <button class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2 text-xs font-medium text-slate-700 shadow-sm hover:bg-slate-50">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Laporan K3L
        </button>

        {{-- Tombol Laporkan Insiden (Hijau Tua) --}}
       <button id="btnLaporkanInsiden"
            class="inline-flex items-center gap-2 rounded-lg bg-emerald-800 px-4 py-2 text-xs font-medium text-white shadow-md hover:bg-emerald-900 transition-colors">

            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.398 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            Laporkan Insiden
        </button>
    </div>
</div>

{{-- SUMMARY CARDS --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    
    {{-- Card 1: Insiden Bulan Ini --}}
    <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100 flex flex-col justify-between h-32">
        <div class="flex items-start justify-between">
            <div class="text-xs font-medium text-slate-500">Insiden Bulan Ini</div>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
        </div>
        <div>
            <div class="text-3xl font-bold text-slate-800">{{ $summary['insiden_bulan_ini'] ?? 0 }}</div>
            <div class="text-[10px] text-slate-500 mt-1">{{ $summary['insiden_selesai'] ?? 0 }} selesai ditangani</div>
        </div>
    </div>

    {{-- Card 2: Zero Major Incident --}}
    <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100 flex flex-col justify-between h-32">
        <div class="flex items-start justify-between">
            <div class="text-xs font-medium text-slate-500">Zero Major Incident</div>
            <div class="rounded-full bg-green-50 p-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>
        </div>
        <div>
            <div class="text-3xl font-bold text-emerald-600">{{ $summary['zero_incident_actual'] ?? 0 }}</div>
            <div class="text-[10px] text-slate-500 mt-1">Insiden berat (Target: {{ $summary['zero_incident_target'] ?? 0 }})</div>
        </div>
    </div>

    {{-- Card 3: Limbah B3 Bulan Ini --}}
    <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100 flex flex-col justify-between h-32">
        <div class="flex items-start justify-between">
            <div class="text-xs font-medium text-slate-500">Limbah B3 Bulan Ini</div>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </div>
        <div>
            <div class="text-3xl font-bold text-slate-800">{{ $summary['limbah_b3_total'] ?? 0 }}</div>
            <div class="text-[10px] text-slate-500 mt-1">kg/liter • Terbuang dengan benar</div>
        </div>
    </div>

    {{-- Card 4: Kepatuhan K3 --}}
    <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100 flex flex-col justify-between h-32">
        <div class="flex items-start justify-between">
            <div class="text-xs font-medium text-slate-500">Kepatuhan K3</div>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
        </div>
        <div class="w-full">
            <div class="text-3xl font-bold text-slate-800 mb-2">{{ $summary['kepatuhan_k3'] ?? 0 }}%</div>
            {{-- Progress Bar --}}
            <div class="w-full bg-slate-100 rounded-full h-2">
                <div class="bg-emerald-700 h-2 rounded-full" style="width: {{ $summary['kepatuhan_k3'] ?? 0 }}%"></div>
            </div>
            <div class="text-[10px] text-slate-500 mt-2">Checklist harian</div>
        </div>
    </div>
</div>

{{-- SECTION UTAMA: TABS & KONTEN --}}
<div class="bg-white rounded-xl shadow-sm border border-slate-100 min-h-[500px]" x-data="{ activeTab: 'k3' }">
    
    {{-- TAB NAVIGATION --}}
    <div class="flex border-b border-slate-100 bg-slate-50/50 rounded-t-xl px-4 pt-2">
        <button 
            @click="activeTab = 'k3'"
            :class="{ 'border-b-2 border-emerald-600 font-semibold text-emerald-800': activeTab === 'k3', 'text-slate-500 hover:text-slate-700': activeTab !== 'k3' }"
            class="px-6 py-3 text-sm transition-all duration-200">
            K3 & Insiden
        </button>
        <button 
            @click="activeTab = 'limbah'"
            :class="{ 'border-b-2 border-emerald-600 font-semibold text-emerald-800': activeTab === 'limbah', 'text-slate-500 hover:text-slate-700': activeTab !== 'limbah' }"
            class="px-6 py-3 text-sm transition-all duration-200">
            Limbah
        </button>
        <button 
            @click="activeTab = 'pelatihan'"
            :class="{ 'border-b-2 border-emerald-600 font-semibold text-emerald-800': activeTab === 'pelatihan', 'text-slate-500 hover:text-slate-700': activeTab !== 'pelatihan' }"
            class="px-6 py-3 text-sm transition-all duration-200">
            Pelatihan
        </button>
        <button 
            @click="activeTab = 'checklist'"
            :class="{ 'border-b-2 border-emerald-600 font-semibold text-emerald-800': activeTab === 'checklist', 'text-slate-500 hover:text-slate-700': activeTab !== 'checklist' }"
            class="px-6 py-3 text-sm transition-all duration-200">
            Checklist
        </button>
    </div>

    {{-- KONTEN TAB --}}
    <div class="p-6">
        
        {{-- 1. TAB K3 & INSIDEN --}}
        <div x-show="activeTab === 'k3'" class="space-y-4">
            <div>
                <h2 class="text-base font-medium text-slate-800">Laporan Insiden Keselamatan</h2>
                <p class="text-sm text-emerald-600">Riwayat insiden dan CAPA (Corrective and Preventive Action)</p>
            </div>

            <div class="overflow-x-auto rounded-lg border border-slate-100 mt-4">
                <table class="min-w-full divide-y divide-slate-100 text-sm">
                    <thead class="bg-white">
                        <tr class="text-left text-slate-500 font-medium">
                            <th class="px-4 py-3 font-medium">ID</th>
                            <th class="px-4 py-3 font-medium">Insiden</th>
                            <th class="px-4 py-3 font-medium">Tanggal</th>
                            <th class="px-4 py-3 font-medium">Tingkat</th>
                            <th class="px-4 py-3 font-medium">Pelapor</th>
                            <th class="px-4 py-3 font-medium">CAPA</th>
                            <th class="px-4 py-3 font-medium">Status</th>
                            <th class="px-4 py-3 font-medium text-right">Aksi</th>
                        </tr>
                    </thead>
                   <tbody id="tableInsidenBody" class="divide-y divide-slate-50 bg-white">
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-slate-500">
                                Memuat data...
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>

        {{-- 2. TAB LIMBAH (Contoh Sederhana) --}}
        {{-- ISI TAB LIMBAH (SESUAI REQUEST GAMBAR 2) --}}
        <div x-show="activeTab === 'limbah'" style="display: none;">
             
             {{-- Header Section Tab Limbah --}}
             <div class="mb-6">
                <h2 class="text-lg font-semibold text-slate-800">Pencatatan Limbah</h2>
                <p class="text-sm text-emerald-700">Tracking limbah B3 dan non-B3 sesuai regulasi</p>
            </div>

            {{-- Tabel Limbah --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 text-sm">
                    <thead>
                        <tr class="text-left text-slate-500">
                            <th class="px-4 py-4 font-medium">ID</th>
                            <th class="px-4 py-4 font-medium">Jenis Limbah</th>
                            <th class="px-4 py-4 font-medium">Kategori</th>
                            <th class="px-4 py-4 font-medium">Volume</th>
                            <th class="px-4 py-4 font-medium">Tanggal</th>
                            <th class="px-4 py-4 font-medium">Vendor</th>
                            <th class="px-4 py-4 font-medium">Manifest</th>
                            <th class="px-4 py-4 font-medium">Status</th>
                        </tr>
                    </thead>
                <tbody class="divide-y divide-slate-50 bg-white">
@forelse($waste_logs as $log)
<tr class="hover:bg-slate-50 transition-colors">

    {{-- ID --}}
    <td class="px-4 py-4 text-slate-700 font-medium align-middle">
        WST-{{ str_pad($log->id, 4, '0', STR_PAD_LEFT) }}
    </td>

    {{-- Jenis Limbah --}}
    <td class="px-4 py-4 align-middle">
        @php
            $isB3 = in_array(strtolower($log->kategori), ['benda tajam','infeksius','kimia']);
            $badgeClass = $isB3
                ? 'bg-red-50 text-red-600 border border-red-100'
                : 'bg-emerald-50 text-emerald-600 border border-emerald-100';
        @endphp

        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium {{ $badgeClass }}">
            {{ $log->jenis_limbah }}
        </span>
    </td>

    {{-- Kategori --}}
    <td class="px-4 py-4 text-slate-600 align-middle">
        {{ $log->kategori }}
    </td>

    {{-- Volume / Berat --}}
    <td class="px-4 py-4 text-slate-800 font-medium align-middle">
        {{ $log->berat }} gram
    </td>

    {{-- Tanggal --}}
    <td class="px-4 py-4 text-slate-600 align-middle">
        {{ \Carbon\Carbon::parse($log->created_at)->format('d M Y') }}
    </td>

    {{-- Vendor / Alur --}}
    <td class="px-4 py-4 text-slate-600 align-middle">
        {{ $log->alur_pembuangan }}
    </td>

    {{-- Manifest --}}
    <td class="px-4 py-4 align-middle text-slate-400">
        -
    </td>

    {{-- Status Verifikasi --}}
    <td class="px-4 py-4 align-middle">
        @php
            $statusClass = $log->status_verifikasi === 'Terverifikasi'
                ? 'bg-emerald-100 text-emerald-700'
                : 'bg-amber-100 text-amber-700';
        @endphp

        <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium {{ $statusClass }}">
            {{ $log->status_verifikasi }}
        </span>
    </td>
</tr>
@empty
<tr>
    <td colspan="8" class="px-4 py-8 text-center text-slate-500">
        Belum ada pencatatan limbah.
    </td>
</tr>
@endforelse
</tbody>

                </table>
            </div>
        </div>
        {{-- 3. TAB PELATIHAN (Placeholder) --}}
<div x-show="activeTab === 'pelatihan'" style="display: none;">
            
            {{-- Header Tab --}}
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-slate-800">Jadwal Pelatihan K3</h2>
                <p class="text-sm text-emerald-700">Pelatihan keselamatan kerja dan sertifikasi staf</p>
            </div>

            {{-- List Card Pelatihan --}}
            <div class="space-y-5">
                @forelse($trainings as $training)
                    <div class="border border-slate-200 rounded-xl p-5 bg-white shadow-sm hover:shadow-md transition-shadow">
                        
                        {{-- Bagian Atas: Icon, Judul, Status --}}
                        <div class="flex items-start gap-4">
                            {{-- Icon Avatar Group --}}
                            <div class="flex-shrink-0 w-12 h-12 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>

                            {{-- Konten Utama --}}
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-base font-semibold text-slate-800">{{ $training['judul'] }}</h3>
                                        <div class="text-sm text-slate-500 mt-0.5">
                                            {{ $training['vendor'] }} • {{ $training['durasi'] }}
                                        </div>
                                    </div>
                                    
                                    {{-- Badge Status --}}
                                    @php
                                        $statusClass = match($training['status']) {
                                            'Terjadwal' => 'bg-blue-50 text-blue-600 border border-blue-100',
                                            'Selesai' => 'bg-green-50 text-green-600 border border-green-100',
                                            default => 'bg-gray-100 text-gray-600'
                                        };
                                    @endphp
                                    <span class="px-3 py-1 rounded-lg text-xs font-medium {{ $statusClass }}">
                                        {{ $training['status'] }}
                                    </span>
                                </div>

                                {{-- Info Tanggal & Peserta --}}
                                <div class="flex items-center gap-6 mt-4 text-sm text-slate-600">
                                    <div class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $training['tanggal'] }}
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                        {{ $training['peserta_current'] }}/{{ $training['peserta_max'] }} peserta
                                    </div>
                                </div>

                                {{-- Topik --}}
                                <div class="mt-4">
                                    <div class="text-xs font-medium text-slate-800 mb-2">Topik:</div>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($training['topik'] as $topik)
                                            <span class="px-3 py-1 border border-slate-200 rounded-full text-xs text-slate-600 bg-slate-50">
                                                {{ $topik }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Progress Bar (Hanya jika Status Terjadwal / Belum Penuh) --}}
                                @if($training['status'] === 'Terjadwal')
                                    <div class="mt-5">
                                        @php
                                            $percentage = ($training['peserta_current'] / $training['peserta_max']) * 100;
                                            $sisaSlot = $training['peserta_max'] - $training['peserta_current'];
                                        @endphp
                                        <div class="w-full bg-slate-100 rounded-full h-2">
                                            <div class="bg-emerald-700 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        @if($sisaSlot > 0)
                                            <div class="text-xs text-emerald-600 font-medium mt-1">
                                                {{ $sisaSlot }} slot tersisa
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Footer: Tombol Aksi --}}
                        <div class="border-t border-slate-100 mt-5 pt-4 flex gap-3">
                            <button class="px-4 py-2 border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                                Detail
                            </button>
                            
                            @if($training['status'] === 'Terjadwal')
                                <button class="px-4 py-2 bg-emerald-700 text-white rounded-lg text-sm font-medium hover:bg-emerald-800 transition-colors shadow-sm shadow-emerald-200">
                                    Daftar Peserta
                                </button>
                            @elseif($training['status'] === 'Selesai')
                                <button class="px-4 py-2 border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                                    Lihat Sertifikat
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10 text-slate-500 border border-dashed rounded-xl">
                        Belum ada jadwal pelatihan.
                    </div>
                @endforelse
            </div>
        </div>
        {{-- 4. TAB CHECKLIST (Placeholder) --}}
       {{-- ISI TAB CHECKLIST --}}
        <div x-show="activeTab === 'checklist'" style="display: none;">
            
            {{-- Header Checklist --}}
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-lg font-semibold text-slate-800">Checklist K3 Harian</h2>
                    <p class="text-sm text-emerald-700">Inspeksi keselamatan laboratorium - {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold text-slate-800">{{ $complianceScore }}%</div>
                    <div class="text-xs text-slate-500 font-medium">Kepatuhan</div>
                </div>
            </div>

            {{-- List Item Checklist --}}
            <div class="space-y-3 mb-6">
                @foreach($checklists as $item)
                    <div class="flex items-center justify-between p-4 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors">
                        <span class="text-sm font-medium {{ $item['status'] == 'warning' ? 'text-slate-600' : 'text-slate-700' }}">
                            {{ $item['task'] }}
                        </span>

                        @if($item['status'] == 'ok')
                            {{-- Icon Centang Hijau (Circle Check) --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @else
                            {{-- Icon Warning Segitiga (Orange) --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.398 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- Progress Bar Section --}}
            <div class="mb-8">
                <div class="w-full bg-slate-200 rounded-full h-2.5 mb-2">
                    <div class="bg-emerald-800 h-2.5 rounded-full transition-all duration-500" style="width: {{ $complianceScore }}%"></div>
                </div>
                <div class="text-center text-sm font-medium text-slate-600">
                    {{ $completedItems }} dari {{ $totalItems }} item selesai
                </div>
            </div>

            {{-- Bagian 'Item yang Perlu Ditindaklanjuti' (Gambar Bawah) --}}
            @if($actionItems->count() > 0)
                <div class="mt-8">
                    <h3 class="text-base font-semibold text-slate-800 mb-3">Item yang Perlu Ditindaklanjuti</h3>
                    
                    @foreach($actionItems as $action)
                        <div class="flex items-center justify-between p-4 bg-yellow-50 border border-yellow-100 rounded-xl">
                            <div class="flex items-start gap-3">
                                {{-- Icon Warning Kecil --}}
                                <div class="mt-0.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.398 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-slate-800">{{ $action['task'] }}</div>
                                    <div class="text-xs text-slate-500 mt-0.5">Belum diverifikasi hari ini</div>
                                </div>
                            </div>
                            
                            {{-- Tombol Tindak Lanjut --}}
                            <button class="px-4 py-2 bg-white border border-slate-200 rounded-lg text-xs font-semibold text-slate-700 shadow-sm hover:bg-slate-50 hover:text-emerald-700 transition-colors">
                                Tindak Lanjut
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>

    </div>
</div>
<div x-data="{ openModal: false, step: 1, previewFiles: [] }">

<!-- MODAL -->
<div id="modalInsiden" class="fixed inset-0 z-50 bg-black/50 hidden flex items-center justify-center">

   <div class="bg-white w-full max-w-5xl rounded-xl shadow-lg flex flex-col h-[90vh]">

        <!-- Header -->
        <div class="flex justify-between items-center px-6 py-4 border-b">
            <h2 class="text-lg font-semibold text-emerald-800">Laporan Insiden</h2>
            <button id="closeModal" class="text-slate-500 hover:text-red-600">✕</button>
        </div>

        <!-- BODY -->
        <div class="p-6 overflow-y-auto flex-1" id="modalBody">
<form id="formInsiden" enctype="multipart/form-data">
@csrf

<div id="step1">
    <h3 class="text-lg font-semibold text-emerald-800">A. Identitas Laporan</h3>

    <div class="grid grid-cols-3 gap-x-6 gap-y-5">
        <div>
            <label class="form-label">ID Insiden/NCR *</label>
            <input type="text" name="id_insiden" placeholder="INC-007" readonly class="form-input">
        </div>

        <div>
            <label class="form-label">Tanggal dan Waktu Kejadian *</label>
            <input type="datetime-local" name="tgl_kejadian" class="form-input">
        </div>

        <div>
            <label class="form-label">Tanggal Pelaporan *</label>
            <input type="date" name="tgl_lapor" class="form-input">
        </div>

        <div>
            <label class="form-label">Unit *</label>
            <input type="text" name="unit" class="form-input">
        </div>

        <div>
            <label class="form-label">Lokasi Detail *</label>
            <input type="text" name="lokasi" class="form-input">
        </div>

        <div>
            <label class="form-label">Jenis Insiden *</label>
            <select name="jenis_insiden" class="form-input">
                <option value="">-- Pilih --</option>
                <option value="Keselamatan Kerja">Keselamatan Kerja</option>
                <option value="Limbah">Limbah</option>
                <option value="Alat">Alat</option>
                <option value="Lingkungan">Lingkungan</option>
            </select>
        </div>
    </div>

    <h3 class="text-lg font-semibold text-emerald-800 mt-10">B. Pelapor</h3>

    <div class="grid grid-cols-3 gap-x-6 gap-y-5">
        <div>
            <label class="form-label">Nama Pelapor *</label>
            <input type="text" name="nama_pelapor" class="form-input">
        </div>

        <div>
            <label class="form-label">Jabatan *</label>
            <select name="jabatan" class="form-input">
                <option value="">-- Pilih --</option>
                <option value="Teknisi">Teknisi</option>
                <option value="Dokter">Dokter</option>
                <option value="Perawat">Perawat</option>
                <option value="Staff">Staff</option>
            </select>
        </div>

        <div>
            <label class="form-label">Kontak</label>
            <input type="text" name="kontak" class="form-input">
        </div>

        <div>
            <label class="form-label">Status Pelapor</label>
            <select name="status_pelapor" class="form-input">
                <option value="">-- Pilih --</option>
                <option value="Saksi">Saksi</option>
                <option value="Korban">Korban</option>
                <option value="Pelapor Langsung">Pelapor Langsung</option>
            </select>
        </div>
    </div>
</div>

<!-- STEP 2 -->
<div id="step2" class="hidden">
    <h3 class="text-lg font-semibold text-emerald-800">C. Detail Insiden</h3>

    <div class="grid grid-cols-3 gap-x-6 gap-y-5">
        <div>
            <label class="form-label">Judul Singkat</label>
            <input type="text" name="judul" class="form-input">
        </div>

        <div class="col-span-2">
            <label class="form-label">Deskripsi *</label>
            <textarea name="deskripsi" rows="3" class="form-input"></textarea>
        </div>

        <div>
            <label class="form-label">Jenis Dampak *</label>
            <select name="jenis_dampak" class="form-input">
                <option value="">-- Pilih --</option>
                <option value="Pencemaran Lingkungan">Pencemaran Lingkungan</option>
                <option value="Cedera">Cedera</option>
                <option value="Kerusakan Alat">Kerusakan Alat</option>
            </select>
        </div>

        <div>
            <label class="form-label">Tingkat Keparahan *</label>
            <select name="tingkat_keparahan" class="form-input">
                <option value="">-- Pilih --</option>
                <option value="Rendah">Rendah</option>
                <option value="Sedang">Sedang</option>
                <option value="Tinggi">Tinggi</option>
            </select>
        </div>

        <div>
            <label class="form-label">Kategori NCR *</label>
            <select name="kategori_ncr" class="form-input">
                <option value="">-- Pilih --</option>
                <option value="Prosedur Tidak Dipatuhi">Prosedur Tidak Dipatuhi</option>
                <option value="Human Error">Human Error</option>
                <option value="Alat Bermasalah">Alat Bermasalah</option>
            </select>
        </div>
    </div>

    <h3 class="text-lg font-semibold text-emerald-800 mt-10">F. Bukti Pendukung</h3>

    <div class="grid grid-cols-2 gap-x-6 gap-y-5">
       <div>
            <label class="form-label">Upload Foto/Video</label>

            <label class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-slate-200 bg-white text-sm cursor-pointer hover:bg-slate-50">
                <span>Upload File</span>
                <input type="file" id="uploadBukti" name="bukti[]" multiple accept="image/*,video/*" class="hidden">

            </label>

            <!-- Preview -->
            <div id="previewArea" class="grid grid-cols-4 gap-3 mt-4"></div>
        </div>

        <div>
            <label class="form-label">Dokumen Pendukung *</label>
            <select name="dokumen_pendukung" class="form-input">
                <option value="">-- Pilih --</option>
                <option value="SOP">SOP</option>
                <option value="IK">IK</option>
                <option value="Form Inspeksi">Form Inspeksi</option>
            </select>
        </div>
    </div>
</div>

<div class="flex justify-between items-center px-6 py-4 border-t bg-slate-50">
    <button id="btnPrev" type="button" class="hidden px-4 py-2 border rounded-lg text-sm">Sebelumnya</button>

    <div class="ml-auto space-x-2">
        <button id="btnNext" type="button" class="px-5 py-2 bg-emerald-700 text-white rounded-lg">Selanjutnya</button>

        <button id="btnSubmit" type="submit" class="hidden px-5 py-2 bg-emerald-800 text-white rounded-lg">
            Buat Laporan
        </button>

        <button id="btnCapa" type="button" class="hidden px-5 py-2 bg-blue-700 text-white rounded-lg">
            Simpan CAPA
        </button>
    </div>
</div>
</form>


        </div>

        <!-- FOOTER -->
       

    </div>
</div>


</div>
@endsection

@push('scripts')
    {{-- Pastikan AlpineJS diload jika belum ada di layout utama --}}
    {{-- <script src="//unpkg.com/alpinejs" defer></script> --}}
    <script>
        function loadInsiden() {
    $.ajax({
        url: '/insiden/list',
        type: 'GET',
        success: function(res) {
            let html = '';

            if (res.length === 0) {
                html = `
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-slate-500">
                            Tidak ada data insiden.
                        </td>
                    </tr>
                `;
            } else {
                res.forEach(item => {
                    let badgeTingkat = '';
                    let badgeStatus = '';

                    // WARNA TINGKAT
                    if (item.tingkat_keparahan.toLowerCase() === 'rendah') {
                        badgeTingkat = 'bg-green-50 text-green-700 border-green-100';
                    } else if (item.tingkat_keparahan.toLowerCase() === 'sedang') {
                        badgeTingkat = 'bg-yellow-50 text-yellow-700 border-yellow-100';
                    } else if (item.tingkat_keparahan.toLowerCase() === 'tinggi') {
                        badgeTingkat = 'bg-red-50 text-red-700 border-red-100';
                    } else {
                        badgeTingkat = 'bg-slate-50 text-slate-600 border-slate-200';
                    }

                    // WARNA STATUS
                    if (item.status === 'Selesai') {
                        badgeStatus = 'bg-emerald-100 text-emerald-700';
                    } else if (item.status === 'Investigasi') {
                        badgeStatus = 'bg-blue-100 text-blue-700';
                    } else if (item.status === 'Baru') {
                        badgeStatus = 'bg-red-100 text-red-700';
                    } else {
                        badgeStatus = 'bg-gray-100 text-gray-700';
                    }

                    html += `
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-4 text-slate-600">${item.id_insiden}</td>

                            <td class="px-4 py-4 text-slate-800 font-medium max-w-xs truncate" title="${item.judul}">
                                ${item.judul ?? '-'}
                            </td>

                            <td class="px-4 py-4 text-slate-600">${formatTanggal(item.tgl_kejadian)}</td>

                            <td class="px-4 py-4">
                                <span class="inline-flex px-2 py-1 text-xs font-medium border rounded ${badgeTingkat}">
                                    ${item.tingkat_keparahan}
                                </span>
                            </td>

                            <td class="px-4 py-4 text-slate-600">${item.nama_pelapor}</td>

                            <td class="px-4 py-4">
                                <span class="text-slate-400 text-xs">-</span>
                            </td>

                            <td class="px-4 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium ${badgeStatus}">
                                    ${item.status ?? 'Baru'}
                                </span>
                            </td>

                            <td class="px-4 py-4 text-right">
                                <button onclick="detailInsiden('${item.id_insiden}')"

                                    class="text-sm font-medium text-slate-600 hover:text-emerald-700">
                                    Detail
                                </button>
                            </td>
                        </tr>
                    `;
                });
            }

            $('#tableInsidenBody').html(html);
        }
    });
}
function detailInsiden(id) {
 $.get('/insiden/detail/' + id, function(res) {


        // Step 1
        $('input[name="id_insiden"]').val(res.id_insiden);
        $('input[name="tgl_kejadian"]').val(res.tgl_kejadian);
        $('input[name="tgl_lapor"]').val(res.tgl_lapor);
        $('input[name="unit"]').val(res.unit);
        $('input[name="lokasi"]').val(res.lokasi);
        $('select[name="jenis_insiden"]').val(res.jenis_insiden);

        $('input[name="nama_pelapor"]').val(res.nama_pelapor);
        $('select[name="jabatan"]').val(res.jabatan);
        $('input[name="kontak"]').val(res.kontak);
        $('select[name="status_pelapor"]').val(res.status_pelapor);

        // Step 2
        $('input[name="judul"]').val(res.judul);
        $('textarea[name="deskripsi"]').val(res.deskripsi);
        $('select[name="jenis_dampak"]').val(res.jenis_dampak);
        $('select[name="tingkat_keparahan"]').val(res.tingkat_keparahan);
        $('select[name="kategori_ncr"]').val(res.kategori_ncr);
        $('select[name="dokumen_pendukung"]').val(res.dokumen_pendukung);

        // Tampilkan modal
        $('#modalInsiden').removeClass('hidden');
        $('body').addClass('overflow-hidden');

        // Mode detail = readonly
        $('#formInsiden input, #formInsiden textarea, #formInsiden select')
            .prop('disabled', true);

        // $('#btnNext').hide();
        $('#btnSubmit').hide();
         $('#btnCapa').removeClass('hidden');
    });
}

$(document).ready(function() {
     loadInsiden();
$('#formInsiden').on('submit', function(e) {
    e.preventDefault();
 
    let formData = new FormData(this);

    // Hapus dulu bukti[] bawaan
    formData.delete('bukti[]');

    // Masukkan file yang masih ada
    selectedFiles.forEach((file, i) => {
        formData.append('bukti[]', file);
    });

    Swal.fire({
        title: 'Menyimpan...',
        text: 'Mohon tunggu',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });

    $.ajax({
        url: "{{ route('insiden.store') }}",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(res) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Laporan berhasil disimpan',
                timer: 2000,
                showConfirmButton: false
            });
  loadInsiden();
            $('#modalInsiden').addClass('hidden');
            $('body').removeClass('overflow-hidden');
            $('#formInsiden')[0].reset();
            selectedFiles = [];
            $('#previewArea').html('');
        },
        error: function(xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: xhr.responseJSON?.message || 'Terjadi kesalahan'
            });
        }
    });
});


    $('#btnLaporkanInsiden').click(function() {
        $('#modalInsiden').removeClass('hidden');
        $('body').addClass('overflow-hidden');
    });

    $('#closeModal').click(function() {
        $('#modalInsiden').addClass('hidden');
        $('body').removeClass('overflow-hidden');
    });

    $('#btnNext').click(function() {
        $('#step1').addClass('hidden');
        $('#step2').removeClass('hidden');

        $('#btnNext').addClass('hidden');
        $('#btnPrev').removeClass('hidden');
        $('#btnSubmit').removeClass('hidden');

        $('#modalBody').scrollTop(0); // reset scroll
    });

    $('#btnPrev').click(function() {
        $('#step2').addClass('hidden');
        $('#step1').removeClass('hidden');

        $('#btnNext').removeClass('hidden');
        $('#btnPrev').addClass('hidden');
        $('#btnSubmit').addClass('hidden');

        $('#modalBody').scrollTop(0); // reset scroll
    });

   let selectedFiles = [];

$('#uploadBukti').on('change', function(e) {
    const files = Array.from(e.target.files);

    files.forEach(file => {
        selectedFiles.push(file);
    });

    renderPreview();
    $(this).val(''); // reset supaya bisa pilih file yang sama lagi
});

function renderPreview() {
    $('#previewArea').html('');

    selectedFiles.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            let previewHtml = '';

            if (file.type.startsWith('image')) {
                previewHtml = `
                    <div class="relative group">
                        <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg border">
                        <button type="button" onclick="removeFile(${index})"
                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 text-xs flex items-center justify-center">
                            ✕
                        </button>
                    </div>
                `;
            } else if (file.type.startsWith('video')) {
                previewHtml = `
                    <div class="relative group">
                        <video src="${e.target.result}" class="w-full h-24 rounded-lg border" controls></video>
                        <button type="button" onclick="removeFile(${index})"
                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 text-xs flex items-center justify-center">
                            ✕
                        </button>
                    </div>
                `;
            }

            $('#previewArea').append(previewHtml);
        };
        reader.readAsDataURL(file);
    });
}

function removeFile(index) {
    selectedFiles.splice(index, 1);
    renderPreview();
}

});

</script>

@endpush