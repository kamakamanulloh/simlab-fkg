@extends('layouts.app')
@section('title', 'Quality & Audit - SIM-Lab')

@section('content')

{{-- HEADER HALAMAN --}}
<div class="mb-8">
    <h1 class="text-2xl font-semibold text-slate-800">Portal Tim Mutu & SPMI</h1>
    <p class="text-sm text-emerald-700 mt-1">
        Dr. Maria Kusuma • Ketua Tim Mutu Lab
    </p>
</div>

{{-- SECTION 1: SUMMARY CARDS (Sesuai Gambar) --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    {{-- Card 1: Overall Compliance --}}
    <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
        <div class="flex justify-between items-start mb-4">
            <span class="text-sm font-medium text-slate-700">Overall Compliance</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div class="text-3xl font-bold text-emerald-800 mb-3">{{ $summary['compliance']['value'] }}%</div>
        
        {{-- Progress Bar Kecil --}}
        <div class="w-full bg-slate-100 rounded-full h-1.5 mb-3">
            <div class="bg-emerald-700 h-1.5 rounded-full" style="width: {{ $summary['compliance']['value'] }}%"></div>
        </div>
        
        <div class="text-xs text-slate-500 flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
            </svg>
            <span class="text-slate-600">{{ $summary['compliance']['trend'] }}</span> {{ $summary['compliance']['trend_desc'] }}
        </div>
    </div>

    {{-- Card 2: Active CAPA --}}
    <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
        <div class="flex justify-between items-start mb-4">
            <span class="text-sm font-medium text-slate-700">Active CAPA</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.398 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>
        <div class="text-3xl font-bold text-orange-600 mb-1">{{ $summary['active_capa']['count'] }}</div>
        <div class="text-xs text-slate-500">{{ $summary['active_capa']['desc'] }}</div>
    </div>

    {{-- Card 3: Upcoming Audits --}}
    <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
        <div class="flex justify-between items-start mb-4">
            <span class="text-sm font-medium text-slate-700">Upcoming Audits</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>
        <div class="text-3xl font-bold text-slate-800 mb-1">{{ $summary['upcoming_audits']['count'] }}</div>
        <div class="text-xs text-slate-500">{{ $summary['upcoming_audits']['next'] }}</div>
    </div>

    {{-- Card 4: Audit Score --}}
    <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
        <div class="flex justify-between items-start mb-4">
            <span class="text-sm font-medium text-slate-700">Audit Score</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
            </svg>
        </div>
        <div class="text-3xl font-bold text-emerald-600 mb-1">{{ $summary['audit_score']['score'] }}</div>
        <div class="text-xs text-slate-500">{{ $summary['audit_score']['last_audit'] }}</div>
    </div>
</div>

{{-- SECTION 2: TABS & CONTENT --}}
{{-- Style Tab disamakan dengan modul sebelumnya (Laporan/Limbah) --}}
<div class="bg-slate-50/50 rounded-xl mb-6" x-data="{ activeTab: 'compliance' }">
    
    {{-- Tab Navigation --}}
    <div class="flex overflow-x-auto border-b border-slate-200 bg-emerald-50/50 rounded-t-xl">
        @foreach(['Compliance', 'Audits', 'CAPA', 'Quality Indicators', 'Documents'] as $tab)
            @php $key = strtolower(str_replace(' ', '_', $tab)); @endphp
            <button 
                @click="activeTab = '{{ $key }}'"
                :class="{ 'border-b-2 border-emerald-600 bg-white font-semibold text-emerald-800': activeTab === '{{ $key }}', 'text-slate-500 hover:text-slate-700 hover:bg-white/50': activeTab !== '{{ $key }}' }"
                class="px-6 py-3 text-sm whitespace-nowrap transition-all duration-200 first:rounded-tl-xl">
                {{ $tab }}
            </button>
        @endforeach
    </div>

    {{-- KONTEN TAB: COMPLIANCE --}}
    <div x-show="activeTab === 'compliance'" class="p-6 bg-white border border-slate-200 border-t-0 rounded-b-xl shadow-sm">
        
        <div class="mb-6">
            <h2 class="text-base font-semibold text-slate-800">Compliance Status per Standard</h2>
            <p class="text-sm text-emerald-700">Kepatuhan terhadap standar dan regulasi yang berlaku</p>
        </div>

        <div class="space-y-8">
            @foreach($standards as $std)
                <div>
                    {{-- Header Item --}}
                    <div class="flex justify-between items-end mb-2">
                        <div>
                            <div class="text-base font-semibold text-slate-800">{{ $std['code'] }}</div>
                            <div class="text-sm text-emerald-600">{{ $std['name'] }}</div>
                        </div>
                        <div class="text-right">
                            <div class="text-xl font-bold text-slate-700">{{ $std['score'] }}%</div>
                            <div class="text-xs text-slate-400">Target: {{ $std['target'] }}%</div>
                        </div>
                    </div>

                    {{-- Progress Bar (Warna Biru sesuai gambar) --}}
                    <div class="flex items-center gap-4">
                        <div class="relative w-full h-3 bg-slate-100 rounded-full overflow-hidden">
                            {{-- Menggunakan warna biru (blue-500) agar mirip gambar --}}
                            <div class="absolute top-0 left-0 h-3 bg-blue-500 rounded-full" style="width: {{ $std['score'] }}%"></div>
                        </div>
                        
                        {{-- Badge Status --}}
                        <span class="px-3 py-1 bg-green-50 text-green-700 border border-green-200 rounded-full text-xs font-medium whitespace-nowrap">
                            {{ $std['status'] }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="my-8 border-t border-slate-100"></div>

        {{-- BAGIAN BAWAH: CERTIFICATION & GAPS --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            {{-- KOLOM KIRI: Certification Status --}}
            <div>
                <h3 class="text-base font-semibold text-slate-800 mb-4">Certification Status</h3>
                <div class="space-y-4">
                    @foreach($certifications as $cert)
                        @php
                            // Logic warna background & badge
                            $bgClass = $cert['color'] === 'green' ? 'bg-emerald-50 border-emerald-100' : 'bg-orange-50 border-orange-100';
                            $badgeClass = $cert['color'] === 'green' ? 'bg-emerald-500 text-white' : 'bg-orange-200 text-orange-800';
                        @endphp

                        <div class="flex items-center justify-between p-4 border rounded-xl {{ $bgClass }}">
                            <div>
                                <div class="font-semibold text-slate-800">{{ $cert['name'] }}</div>
                                <div class="text-xs text-slate-500 mt-1">{{ $cert['desc'] }}</div>
                            </div>
                            <span class="px-3 py-1 rounded text-xs font-semibold {{ $badgeClass }}">
                                {{ $cert['status'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- KOLOM KANAN: Compliance Gaps --}}
            <div>
                <h3 class="text-base font-semibold text-slate-800 mb-4">Compliance Gaps</h3>
                <div class="space-y-4">
                    @foreach($compliance_gaps as $gap)
                        {{-- Style Kuning/Orange Pudar untuk Warning --}}
                        <div class="flex items-start gap-4 p-4 border border-amber-100 bg-amber-50/60 rounded-xl">
                            <div class="text-orange-500 mt-0.5">
                                {{-- Icon Warning (Circle Exclamation) --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold text-slate-800 text-sm">{{ $gap['title'] }}</div>
                                <div class="text-xs text-slate-500 mt-1">{{ $gap['desc'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>

   {{-- KONTEN TAB: AUDITS --}}
    <div x-show="activeTab === 'audits'" style="display: none;" class="p-6 bg-white border border-slate-200 border-t-0 rounded-b-xl shadow-sm">
        
        {{-- BAGIAN ATAS: AUDIT SCHEDULE --}}
        <div class="mb-10">
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-slate-800">Audit Schedule</h2>
                <p class="text-sm text-emerald-700">Jadwal audit internal dan eksternal</p>
            </div>

            <div class="overflow-x-auto border border-slate-200 rounded-xl">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-white">
                        <tr class="text-left text-slate-500">
                            <th class="px-6 py-4 font-medium">ID</th>
                            <th class="px-6 py-4 font-medium">Date</th>
                            <th class="px-6 py-4 font-medium">Type</th>
                            <th class="px-6 py-4 font-medium">Scope</th>
                            <th class="px-6 py-4 font-medium">Auditor</th>
                            <th class="px-6 py-4 font-medium">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @foreach($audit_schedule as $audit)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 text-slate-700 font-medium">{{ $audit['id'] }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $audit['date'] }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full border border-slate-200 bg-white text-xs font-medium text-slate-600 shadow-sm">
                                        {{ $audit['type'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-600">{{ $audit['scope'] }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $audit['auditor'] }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium border {{ $audit['status_class'] }}">
                                        {{ $audit['status'] }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- BAGIAN BAWAH: COMPLETED AUDITS --}}
        <div>
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-slate-800">Completed Audits</h2>
                <p class="text-sm text-emerald-700">Riwayat audit dan temuan</p>
            </div>

            <div class="space-y-6">
                @foreach($completed_audits as $item)
                    <div class="border border-slate-200 rounded-xl p-6 bg-white shadow-sm">
                        
                        {{-- Header Card --}}
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-800">{{ $item['title'] }}</h3>
                                <div class="text-sm text-emerald-600 mt-1 font-medium">{{ $item['id_range'] }}</div>
                            </div>
                            <div class="text-right flex items-center gap-3">
                                <div>
                                    <div class="text-3xl font-bold text-slate-700 leading-none">{{ $item['score'] }}</div>
                                    <div class="text-xs text-slate-500 mt-1">Score</div>
                                </div>
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-xs font-semibold">
                                    {{ $item['status'] }}
                                </span>
                            </div>
                        </div>

                        {{-- Metrics Findings (3 Kolom) --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            {{-- Major --}}
                            <div class="bg-red-50/50 border border-red-50 rounded-lg py-4 text-center">
                                <div class="text-2xl font-bold text-red-600 mb-1">{{ $item['findings']['major'] }}</div>
                                <div class="text-xs text-slate-500 font-medium">Major</div>
                            </div>
                            {{-- Minor --}}
                            <div class="bg-amber-50/50 border border-amber-50 rounded-lg py-4 text-center">
                                <div class="text-2xl font-bold text-amber-600 mb-1">{{ $item['findings']['minor'] }}</div>
                                <div class="text-xs text-slate-500 font-medium">Minor</div>
                            </div>
                            {{-- Observations --}}
                            <div class="bg-sky-50/50 border border-sky-50 rounded-lg py-4 text-center">
                                <div class="text-2xl font-bold text-sky-600 mb-1">{{ $item['findings']['observations'] }}</div>
                                <div class="text-xs text-slate-500 font-medium">Observations</div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex gap-3">
                            <button class="flex items-center gap-2 px-4 py-2 border border-slate-200 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-50 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                View Report
                            </button>
                            <button class="flex items-center gap-2 px-4 py-2 border border-slate-200 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-50 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Download
                            </button>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>

    </div>
    {{-- KONTEN TAB: CAPA --}}
    <div x-show="activeTab === 'capa'" style="display: none;" class="p-6 bg-white border border-slate-200 border-t-0 rounded-b-xl shadow-sm">
        
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-slate-800">CAPA Management</h2>
            <p class="text-sm text-emerald-700">Corrective and Preventive Action tracking</p>
        </div>

        <div class="space-y-6">
            @foreach($capa_list as $capa)
                <div class="border border-slate-200 rounded-xl p-6 bg-white hover:shadow-sm transition-shadow">
                    
                    {{-- Header Card: ID & Status --}}
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-800">{{ $capa['id'] }}</h3>
                            <div class="text-sm text-emerald-600 mt-0.5">{{ $capa['incident'] }}</div>
                        </div>
                        
                        @php
                            $statusClass = match($capa['status']) {
                                'In Progress' => 'bg-blue-50 text-blue-600 border border-blue-100',
                                'Completed' => 'bg-emerald-50 text-emerald-700 border border-emerald-100',
                                default => 'bg-slate-50 text-slate-600'
                            };
                            // Icon Check untuk Completed
                            $showIcon = $capa['status'] === 'Completed';
                        @endphp

                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-medium {{ $statusClass }}">
                            @if($showIcon)
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            @endif
                            {{ $capa['status'] }}
                        </span>
                    </div>

                    {{-- Detail Text --}}
                    <div class="space-y-2 text-sm mb-6">
                        <div class="flex gap-2">
                            <span class="text-emerald-700 font-medium min-w-[120px]">Root Cause:</span>
                            <span class="text-slate-700">{{ $capa['root_cause'] }}</span>
                        </div>
                        <div class="flex gap-2">
                            <span class="text-emerald-700 font-medium min-w-[120px]">Corrective Action:</span>
                            <span class="text-slate-700">{{ $capa['corrective'] }}</span>
                        </div>
                        <div class="flex gap-2">
                            <span class="text-emerald-700 font-medium min-w-[120px]">Preventive Action:</span>
                            <span class="text-slate-700">{{ $capa['preventive'] }}</span>
                        </div>
                        <div class="flex gap-2">
                            <span class="text-emerald-700 font-medium min-w-[120px]">Responsible:</span>
                            <span class="text-slate-700 font-medium">
                                {{ $capa['responsible'] }} • Due: {{ $capa['due_date'] }}
                            </span>
                        </div>
                    </div>

                    {{-- Progress Bar --}}
                    <div class="mb-4">
                        <div class="flex justify-between text-xs mb-1">
                            <span class="font-medium text-slate-700">Progress</span>
                            <span class="font-medium text-slate-700">{{ $capa['progress'] }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="bg-emerald-700 h-2 rounded-full transition-all duration-500" style="width: {{ $capa['progress'] }}%"></div>
                        </div>
                    </div>

                    {{-- Action Button (Jika status belum selesai) --}}
                    @if($capa['can_update'])
                        <button class="px-4 py-2 border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                            Update Progress
                        </button>
                    @endif

                </div>
            @endforeach
        </div>

    </div>
    {{-- KONTEN TAB: QUALITY INDICATORS --}}
    <div x-show="activeTab === 'quality_indicators'" style="display: none;" class="p-6 bg-white border border-slate-200 border-t-0 rounded-b-xl shadow-sm">
        
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-slate-800">Quality Indicators</h2>
            <p class="text-sm text-emerald-700">Key performance indicators untuk quality management</p>
        </div>

        <div class="overflow-x-auto border border-slate-200 rounded-xl">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-white">
                    <tr class="text-left text-slate-500">
                        <th class="px-6 py-4 font-medium w-1/3">Indicator</th>
                        <th class="px-6 py-4 font-medium">Current</th>
                        <th class="px-6 py-4 font-medium">Target</th>
                        <th class="px-6 py-4 font-medium">Performance</th>
                        <th class="px-6 py-4 font-medium">Trend</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @foreach($quality_indicators as $kpi)
                        <tr class="hover:bg-slate-50 transition-colors">
                            {{-- Indicator Name --}}
                            <td class="px-6 py-4 text-slate-800 font-medium">
                                {{ $kpi['name'] }}
                            </td>
                            
                            {{-- Current Value (Bold) --}}
                            <td class="px-6 py-4 text-slate-800 font-bold text-base">
                                {{ $kpi['current'] }}
                            </td>
                            
                            {{-- Target Value --}}
                            <td class="px-6 py-4 text-slate-500">
                                {{ $kpi['target'] }}
                            </td>
                            
                            {{-- Performance Badge --}}
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-medium">
                                    {{ $kpi['performance'] }}
                                </span>
                            </td>
                            
                            {{-- Trend Icon & Text --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2 {{ $kpi['trend_class'] }}">
                                    @if($kpi['trend'] == 'Up')
                                        {{-- Icon Panah Naik Zigzag --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                        </svg>
                                    @else
                                        {{-- Icon Stable (Panah Datar/Zigzag Datar) --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" /> 
                                            {{-- Note: Menggunakan icon trend umum, bisa disesuaikan jika ingin icon 'datar' spesifik --}}
                                        </svg>
                                    @endif
                                    <span class="text-xs font-medium">{{ $kpi['trend'] }}</span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    {{-- KONTEN TAB: DOCUMENTS --}}
    <div x-show="activeTab === 'documents'" style="display: none;" class="p-6 bg-white border border-slate-200 border-t-0 rounded-b-xl shadow-sm">
        
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <h2 class="text-lg font-semibold text-slate-800">Quality Documents</h2>
                <p class="text-sm text-emerald-700">Dokumen mutu dan SOP</p>
            </div>
            
            {{-- Tombol Trigger Modal --}}
            <button onclick="openDocModal()" class="inline-flex items-center gap-2 bg-emerald-800 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-emerald-900 transition-colors shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Upload Document
            </button>
        </div>

        {{-- Tabel Dokumen --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 text-sm">
                <thead>
                    <tr class="text-left text-slate-500 border-b border-slate-200">
                        <th class="px-4 py-4 font-medium">ID</th>
                        <th class="px-4 py-4 font-medium w-1/3">Document Title</th>
                        <th class="px-4 py-4 font-medium">Version</th>
                        <th class="px-4 py-4 font-medium">Last Update</th>
                        <th class="px-4 py-4 font-medium">Status</th>
                        <th class="px-4 py-4 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($documents as $doc)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            {{-- ID --}}
                            <td class="px-4 py-4 text-slate-600 font-medium align-middle">
                                {{ $doc['id'] }}
                            </td>
                            
                            {{-- Title --}}
                            <td class="px-4 py-4 text-slate-800 font-medium align-middle">
                                {{ $doc['title'] }}
                            </td>
                            
                            {{-- Version (Pill Style) --}}
                            <td class="px-4 py-4 align-middle">
                                <span class="inline-block px-2 py-0.5 border border-slate-200 rounded-md text-xs text-slate-600 bg-white">
                                    {{ $doc['version'] }}
                                </span>
                            </td>
                            
                            {{-- Last Update --}}
                            <td class="px-4 py-4 text-slate-600 align-middle">
                                {{ $doc['last_update'] }}
                            </td>
                            
                            {{-- Status Badge --}}
                            <td class="px-4 py-4 align-middle">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $doc['status_class'] }}">
                                    {{ $doc['status'] }}
                                </span>
                            </td>
                            
                            {{-- Actions --}}
                            <td class="px-4 py-4 text-right align-middle">
    <div class="flex items-center justify-end gap-3 text-slate-400">
        
        {{-- Tombol VIEW --}}
        @if(!empty($doc['file_path']))
            <a href="{{ route('quality.document.view', $doc['id']) }}" target="_blank" class="hover:text-emerald-600 transition-colors" title="View">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </a>
        @else
            {{-- Tombol View Disabled (Abu-abu) jika tidak ada file --}}
            <button class="text-slate-300 cursor-not-allowed" title="No File" disabled>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </button>
        @endif

        {{-- Tombol DOWNLOAD --}}
        @if(!empty($doc['file_path']))
            <a href="{{ route('quality.document.download', $doc['id']) }}" class="hover:text-emerald-600 transition-colors" title="Download">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
            </a>
        @else
             {{-- Tombol Download Disabled --}}
            <button class="text-slate-300 cursor-not-allowed" title="No File" disabled>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
            </button>
        @endif

    </div>
</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    </div>
    </div>

</div>

{{-- MODAL UPLOAD DOKUMEN --}}
<div id="docModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        {{-- Overlay Background --}}
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true" onclick="closeDocModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        {{-- Modal Panel --}}
        <div class="inline-block w-full max-w-lg px-6 pt-5 pb-6 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:w-full">
            
            <div class="flex justify-between items-center mb-5">
                <h3 class="text-lg font-semibold text-slate-800" id="modal-title">Upload Quality Document</h3>
                <button type="button" onclick="closeDocModal()" class="text-gray-400 hover:text-gray-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form id="docForm" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    {{-- Judul Dokumen --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Document Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm p-2.5 bg-slate-50 border" placeholder="e.g. SOP Pemeliharaan Alat">
                    </div>

                    {{-- Versi & Kategori --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Version <span class="text-red-500">*</span></label>
                            <input type="text" name="version" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm p-2.5 bg-slate-50 border" placeholder="e.g. v1.0">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <select name="category" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm p-2.5 bg-slate-50 border">
                                <option value="SOP">SOP</option>
                                <option value="Manual">Manual</option>
                                <option value="Policy">Policy</option>
                                <option value="Form">Form</option>
                            </select>
                        </div>
                    </div>

                    {{-- File Upload --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">File Document (PDF/Docx) <span class="text-red-500">*</span></label>
                        <input type="file" name="file" required accept=".pdf,.doc,.docx" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-gray-300 rounded-lg cursor-pointer bg-white">
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm p-2.5 bg-slate-50 border">
                            <option value="Current">Current</option>
                            <option value="Draft">Draft</option>
                            <option value="Review Needed">Review Needed</option>
                        </select>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeDocModal()" class="px-4 py-2 border border-slate-300 rounded-lg text-sm font-medium text-slate-700 bg-white hover:bg-slate-50">
                        Cancel
                    </button>
                    <button type="submit" id="btnSaveDoc" class="px-4 py-2 bg-emerald-700 text-white rounded-lg text-sm font-medium hover:bg-emerald-800 shadow-sm transition-colors">
                        Upload & Save
                    </button>
                </div>
            </form>
        </div>
      
</div>


@endsection

@push('scripts')
    {{-- Pastikan AlpineJS diload --}}
    {{-- <script src="//unpkg.com/alpinejs" defer></script> --}}

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // --- MODAL LOGIC ---
    function openDocModal() {
        $('#docModal').removeClass('hidden');
    }

    function closeDocModal() {
        $('#docModal').addClass('hidden');
        $('#docForm')[0].reset(); // Reset form saat ditutup
    }

    // --- AJAX SUBMIT ---
    $('#docForm').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        let btn = $('#btnSaveDoc');
        btn.prop('disabled', true).text('Uploading...');

        $.ajax({
            url: "{{ route('quality.store-document') }}", // Pastikan route ini dibuat
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert('Dokumen berhasil diupload!');
                closeDocModal();
                location.reload(); // Refresh halaman untuk melihat data baru
            },
            error: function(xhr) {
                let err = JSON.parse(xhr.responseText);
                alert('Gagal upload: ' + (err.message || 'Terjadi kesalahan'));
                btn.prop('disabled', false).text('Upload & Save');
            }
        });
    });
</script>
@endpush