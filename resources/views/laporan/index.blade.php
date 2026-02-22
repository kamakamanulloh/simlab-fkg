@extends('layouts.app')
@section('title', 'Laporan & Analitik - SIM-Lab')

@section('content')

{{-- HEADER: JUDUL & FILTER --}}
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-slate-800">Dashboard Pelaporan & Analitik</h1>
        <p class="text-sm text-emerald-700 mt-1">
            Laporan komprehensif aktivitas dan kinerja laboratorium
        </p>
    </div>

    <div class="flex items-center gap-3">
        {{-- Dropdown Periode --}}
        <div class="relative">
            <select class="appearance-none bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-32 p-2.5 pr-8">
                <option>Bulanan</option>
                <option>Mingguan</option>
                <option>Tahunan</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </div>
        </div>

        {{-- Tombol Export PDF --}}
        {{-- Tombol Export PDF (Header) --}}
<a href="{{ route('laporan.export_pdf') }}" target="_blank" class="inline-flex items-center gap-2 bg-emerald-800 text-white px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-emerald-900 transition-colors shadow-sm">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
    </svg>
    Export PDF
</a>
    </div>
</div>

{{-- SECTION 1: SUMMARY CARDS --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    {{-- Card 1: Total Sesi --}}
    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
        <div class="flex justify-between items-start mb-4">
            <div class="text-sm font-medium text-slate-600">Total Sesi</div>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
        </div>
        <div class="text-3xl font-bold text-slate-800 mb-1">{{ $summary['total_sesi']['value'] }}</div>
        <div class="flex items-center text-xs">
            <span class="text-emerald-600 font-medium flex items-center gap-0.5">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                {{ $summary['total_sesi']['trend'] }}
            </span>
            <span class="text-slate-400 ml-1">{{ $summary['total_sesi']['desc'] }}</span>
        </div>
    </div>

    {{-- Card 2: Total Partisipan --}}
    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
        <div class="flex justify-between items-start mb-4">
            <div class="text-sm font-medium text-slate-600">Total Partisipan</div>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
        </div>
        <div class="text-3xl font-bold text-slate-800 mb-1">{{ $summary['total_partisipan']['value'] }}</div>
        <div class="flex items-center text-xs">
            <span class="text-emerald-600 font-medium flex items-center gap-0.5">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                {{ $summary['total_partisipan']['trend'] }}
            </span>
            <span class="text-slate-400 ml-1">{{ $summary['total_partisipan']['desc'] }}</span>
        </div>
    </div>

    {{-- Card 3: Utilisasi Rata-rata --}}
    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
        <div class="flex justify-between items-start mb-4">
            <div class="text-sm font-medium text-slate-600">Utilisasi Rata-rata</div>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
        </div>
        <div class="text-3xl font-bold text-slate-800 mb-1">{{ $summary['utilisasi_rata']['value'] }}</div>
        <div class="flex items-center text-xs">
            <span class="text-orange-500 font-medium flex items-center gap-0.5">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                {{ $summary['utilisasi_rata']['trend'] }}
            </span>
            <span class="text-slate-400 ml-1">{{ $summary['utilisasi_rata']['desc'] }}</span>
        </div>
    </div>

    {{-- Card 4: Compliance Rate --}}
    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
        <div class="flex justify-between items-start mb-4">
            <div class="text-sm font-medium text-slate-600">Compliance Rate</div>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
        </div>
        <div class="text-3xl font-bold text-emerald-600 mb-1">{{ $summary['compliance']['value'] }}</div>
        <div class="text-xs text-slate-400">
            {{ $summary['compliance']['desc'] }}
        </div>
    </div>
</div>

{{-- SECTION 2: TABS & CONTENT --}}
<div class="bg-slate-50/50 rounded-xl mb-6" x-data="{ activeTab: 'ruang' }">
    {{-- Tab Navigation --}}
    <div class="flex overflow-x-auto border-b border-slate-200 bg-emerald-50/50 rounded-t-xl">
        @foreach(['Utilisasi Ruang', 'Penggunaan Alat', 'Partisipasi', 'Pemeliharaan', 'K3 & Limbah'] as $index => $tab)
            @php $key = strtolower(explode(' ', $tab)[0]); @endphp
            <button 
                @click="activeTab = '{{ $key }}'"
                :class="{ 'border-b-2 border-emerald-600 bg-white font-semibold text-emerald-800': activeTab === '{{ $key }}', 'text-slate-500 hover:text-slate-700 hover:bg-white/50': activeTab !== '{{ $key }}' }"
                class="px-6 py-3 text-sm whitespace-nowrap transition-all duration-200 first:rounded-tl-xl">
                {{ $tab }}
            </button>
        @endforeach
    </div>

    {{-- Content: Utilisasi Ruang --}}
    <div x-show="activeTab === 'utilisasi'" class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-6 bg-white border border-slate-200 border-t-0 rounded-b-xl shadow-sm">
        
        {{-- Kolom Kiri: Progress Bars --}}
        <div class="lg:col-span-2 space-y-8">
            <div class="mb-4">
                <h2 class="text-base font-semibold text-slate-800">Utilisasi Ruangan per Lab</h2>
                <p class="text-sm text-emerald-700">Periode: November 2025</p>
            </div>

            @foreach($lab_utilizations as $lab)
                <div class="relative">
                    {{-- Label Atas --}}
                    <div class="flex justify-between items-end mb-2">
                        <div>
                            <div class="text-base font-medium text-slate-800">{{ $lab['name'] }}</div>
                            <div class="text-xs text-slate-500">{{ $lab['usage_text'] }}</div>
                        </div>
                        <div class="text-xl font-bold text-slate-700">{{ $lab['percentage'] }}%</div>
                    </div>

                    {{-- Progress Track --}}
                    <div class="relative w-full h-3 bg-slate-200 rounded-full">
                        {{-- Bar Fill --}}
                        <div class="absolute top-0 left-0 h-3 bg-emerald-800 rounded-full" style="width: {{ $lab['percentage'] }}%"></div>
                        
                        {{-- Target Marker (Garis kecil di 75%) --}}
                        <div class="absolute top-0 w-0.5 h-4 -mt-0.5 bg-slate-400 z-10" style="left: {{ $lab['target'] }}%"></div>
                    </div>

                    {{-- Scale Labels Bawah --}}
                    <div class="flex justify-between text-[10px] text-slate-400 mt-1">
                        <span>0%</span>
                        <span class="relative" style="left: 10%">Target: {{ $lab['target'] }}%</span>
                        <span>100%</span>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Kolom Kanan: Tren Utilisasi --}}
        <div class="bg-white border border-slate-100 rounded-xl p-4 shadow-sm h-fit">
            <div class="mb-4">
                <h3 class="text-sm font-semibold text-slate-800">Tren Utilisasi</h3>
                <p class="text-xs text-emerald-600">5 bulan terakhir</p>
            </div>

            <div class="space-y-4">
                @foreach($monthly_trends as $trend)
                    <div class="flex items-center justify-between p-2 border border-slate-50 rounded-lg hover:bg-slate-50 transition-colors">
                        <div>
                            <div class="text-sm font-medium text-slate-800">{{ $trend['month'] }}</div>
                            <div class="text-xs text-slate-500">{{ $trend['sessions'] }}</div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-bold text-emerald-700">{{ $trend['percent'] }}%</div>
                            {{-- Mini Bar --}}
                            <div class="w-16 h-1.5 bg-slate-100 rounded-full mt-1 ml-auto">
                                <div class="h-1.5 bg-emerald-600 rounded-full" style="width: {{ $trend['percent'] }}%"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    {{-- KONTEN TAB: PENGGUNAAN ALAT --}}
    <div x-show="activeTab === 'penggunaan'" style="display: none;" class="p-6 bg-white border border-slate-200 border-t-0 rounded-b-xl shadow-sm">
        
        {{-- Header Section --}}
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-slate-800">Statistik Penggunaan Alat</h2>
            <p class="text-sm text-emerald-600">Frekuensi dan intensitas penggunaan peralatan</p>
        </div>

        {{-- List Cards --}}
        <div class="space-y-6">
            @foreach($equipment_stats as $item)
                <div class="border border-slate-200 rounded-xl p-6 hover:shadow-sm transition-shadow bg-white">
                    
                    {{-- Row 1: Judul, Info Unit, dan Avg Usage --}}
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between mb-6 gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-800">{{ $item['name'] }}</h3>
                            <div class="text-sm text-emerald-600 mt-1">{{ $item['unit_info'] }}</div>
                        </div>

                        <div class="text-right">
                            <div class="flex items-center justify-end gap-3">
                                <span class="text-2xl font-bold text-slate-800">{{ $item['avg_usage'] }}%</span>
                                
                                {{-- Badge Status --}}
                                @php
                                    $badgeClass = match($item['status']) {
                                        'Critical' => 'bg-red-500 text-white',
                                        'High' => 'bg-emerald-800 text-white',
                                        default => 'bg-slate-500 text-white'
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $badgeClass }}">
                                    {{ $item['status'] }}
                                </span>
                            </div>
                            <div class="text-xs text-slate-500 mt-1">Avg. Usage</div>
                        </div>
                    </div>

                    {{-- Row 2: Kotak Statistik (Availability & Utilization) --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Availability Box --}}
                        <div class="bg-slate-50/80 rounded-lg py-4 px-6 text-center border border-slate-100">
                            <div class="text-xs text-slate-500 font-medium mb-1">Availability</div>
                            <div class="text-2xl font-bold text-emerald-900">{{ $item['availability'] }}%</div>
                        </div>

                        {{-- Utilization Box --}}
                        <div class="bg-slate-50/80 rounded-lg py-4 px-6 text-center border border-slate-100">
                            <div class="text-xs text-slate-500 font-medium mb-1">Utilization</div>
                            <div class="text-2xl font-bold text-emerald-900">{{ $item['utilization'] }}%</div>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

    </div>
    {{-- KONTEN TAB: PARTISIPASI --}}
    <div x-show="activeTab === 'partisipasi'" style="display: none;" class="p-6 bg-white border border-slate-200 border-t-0 rounded-b-xl shadow-sm">
        
    
        {{-- Bagian Bawah: Daftar Kelas (Gambar 2) --}}
        <div>
            <div class="mb-5">
                <h2 class="text-base font-semibold text-slate-800">Partisipasi Mahasiswa per Kelas</h2>
                <p class="text-sm text-emerald-600">Tingkat kehadiran dan penyelesaian</p>
            </div>

            <div class="space-y-5">
                @foreach($class_participation as $kelas)
                    <div class="border border-slate-200 rounded-xl p-5 hover:border-emerald-200 transition-colors">
                        {{-- Info Text Atas --}}
                        <div class="flex justify-between items-end mb-3">
                            <div>
                                <h3 class="text-base font-semibold text-slate-800">{{ $kelas['name'] }}</h3>
                                <div class="text-sm text-emerald-600 mt-1">
                                    {{ $kelas['attended'] }}/{{ $kelas['total'] }} mahasiswa hadir
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-emerald-800">{{ $kelas['completion'] }}%</div>
                                <div class="text-xs text-slate-500">Completion</div>
                            </div>
                        </div>

                        {{-- Progress Bar --}}
                        <div class="w-full bg-slate-200 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-emerald-800 h-2.5 rounded-full" style="width: {{ $kelas['completion'] }}%"></div>
                        </div>
                    </div>
                    
                @endforeach
            </div>
        </div>
    {{-- Bagian Atas: Summary Cards (Gambar 1) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            @foreach($participation_summary as $summary)
                <div class="border border-slate-200 rounded-xl p-6 text-center">
                    <div class="text-sm font-medium text-slate-700 mb-3 text-left">{{ $summary['title'] }}</div>
                    
                    <div class="text-4xl font-bold text-emerald-800 mb-2">{{ $summary['value'] }}</div>
                    
                    <div class="text-sm text-emerald-600 font-medium">
                        {{ $summary['desc'] }}
                    </div>
                </div>
            @endforeach
        </div>

    </div>
    <div x-show="activeTab === 'pemeliharaan'" style="display: none;" class="p-6 bg-white border border-slate-200 border-t-0 rounded-b-xl shadow-sm">
        
        {{-- BAGIAN ATAS: METRICS & UPCOMING --}}
      
        {{-- BAGIAN BAWAH: LAPORAN PEMELIHARAAN (Sesuai Gambar 2) --}}
        <div>
            <div class="mb-5">
                <h2 class="text-base font-semibold text-slate-800">Laporan Pemeliharaan & Kalibrasi</h2>
                <p class="text-sm text-emerald-600">Status dan compliance pemeliharaan peralatan</p>
            </div>

            <div class="space-y-4">
                @foreach($maintenance_compliance as $report)
                    <div class="border border-slate-200 rounded-xl p-6 bg-white">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="text-base font-medium text-slate-800">{{ $report['title'] }}</h3>
                                <div class="text-sm text-emerald-600 mt-1">{{ $report['details'] }}</div>
                            </div>
                            @if($report['score'])
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-emerald-800">{{ $report['score'] }}%</div>
                                    <div class="text-xs text-slate-500">Compliance</div>
                                </div>
                            @endif
                        </div>

                        {{-- Progress Bar (Hanya jika has_bar = true) --}}
                        @if($report['has_bar'])
                            <div class="w-full bg-slate-200 rounded-full h-3 overflow-hidden mt-1">
                                <div class="bg-emerald-800 h-3 rounded-full" style="width: {{ $report['score'] }}%"></div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
              <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            
            {{-- Kolom Kiri: Maintenance Metrics --}}
            <div>
                <h2 class="text-base font-semibold text-slate-800 mb-4">Maintenance Metrics</h2>
                <div class="space-y-4">
                    @foreach($maintenance_metrics as $metric)
                        <div class="flex items-center justify-between p-5 border border-slate-200 rounded-xl bg-white">
                            <div>
                                <div class="text-base font-medium text-slate-800">{{ $metric['title'] }}</div>
                                <div class="text-xs text-emerald-600 mt-0.5">{{ $metric['subtitle'] }}</div>
                            </div>
                            <div class="text-2xl font-bold text-emerald-800">{{ $metric['value'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Kolom Kanan: Upcoming Maintenance --}}
            <div>
                <h2 class="text-base font-semibold text-slate-800 mb-4">Upcoming Maintenance</h2>
                <div class="space-y-4">
                    @foreach($upcoming_maintenance as $item)
                        <div class="flex items-start gap-4 p-5 border border-slate-200 rounded-xl bg-white">
                            {{-- Icon Wrench --}}
                            <div class="text-emerald-700 mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-base font-medium text-slate-800">{{ $item['tool'] }}</div>
                                <div class="text-sm text-emerald-600 mt-0.5">
                                    {{ $item['type'] }} • Due: {{ $item['due'] }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        </div>

    </div>
    {{-- KONTEN TAB: K3 & LIMBAH --}}
    <div x-show="activeTab === 'k3'" style="display: none;" class="p-6 bg-white border border-slate-200 border-t-0 rounded-b-xl shadow-sm">
        
        {{-- BAGIAN ATAS: SUMMARY CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            @foreach($k3_summary as $item)
                <div class="border border-slate-200 rounded-xl p-6 bg-white flex flex-col justify-between h-40">
                    <div class="text-base font-medium text-slate-800">{{ $item['title'] }}</div>
                    
                    <div class="text-center mt-2">
                        <div class="text-4xl font-bold text-emerald-600 mb-1">{{ $item['value'] }}</div>
                        <div class="text-xs text-slate-500">{{ $item['unit'] }}</div>
                    </div>

                    {{-- Progress Bar (Jika Ada) --}}
                    @if($item['has_bar'])
                        <div class="w-full bg-slate-100 rounded-full h-2 mt-3">
                            <div class="bg-emerald-800 h-2 rounded-full" style="width: {{ $item['bar_val'] }}%"></div>
                        </div>
                    @else
                         {{-- Spacer biar tinggi kartu sama --}}
                         <div class="h-2 mt-3"></div>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- BAGIAN BAWAH: LAPORAN DETAIL --}}
        <div>
            <div class="mb-5">
                <h2 class="text-base font-semibold text-slate-800">Laporan K3 & Manajemen Limbah</h2>
                <p class="text-sm text-emerald-600">Compliance dan incident tracking</p>
            </div>

            <div class="space-y-6">
                
                {{-- Card 1: K3 Inspections --}}
                <div class="border border-slate-200 rounded-xl p-6 bg-white">
                    <div class="flex justify-between items-start mb-4">
                        <div class="text-base font-medium text-slate-800">K3 Inspections</div>
                        <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-medium">
                            {{ $k3_reports['inspections']['status'] }}
                        </span>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="bg-slate-50 rounded-lg p-4 text-center">
                            <div class="text-xs text-slate-500 mb-1">Scheduled</div>
                            <div class="text-xl font-bold text-emerald-800">{{ $k3_reports['inspections']['scheduled'] }}</div>
                        </div>
                        <div class="bg-slate-50 rounded-lg p-4 text-center">
                            <div class="text-xs text-slate-500 mb-1">Completed</div>
                            <div class="text-xl font-bold text-emerald-800">{{ $k3_reports['inspections']['completed'] }}</div>
                        </div>
                        <div class="bg-slate-50 rounded-lg p-4 text-center">
                            <div class="text-xs text-slate-500 mb-1">Findings</div>
                            <div class="text-xl font-bold text-emerald-800">{{ $k3_reports['inspections']['findings'] }}</div>
                        </div>
                    </div>
                </div>

                {{-- Card 2: Incident Reports --}}
                <div class="border border-slate-200 rounded-xl p-6 bg-white">
                    <div class="text-base font-medium text-slate-800 mb-4">Incident Reports</div>
                    <div class="grid grid-cols-4 gap-4">
                        <div class="bg-slate-50 rounded-lg p-4 text-center">
                            <div class="text-xs text-slate-500 mb-1">Total</div>
                            <div class="text-xl font-bold text-emerald-800">{{ $k3_reports['incidents']['total'] }}</div>
                        </div>
                        <div class="bg-slate-50 rounded-lg p-4 text-center">
                            <div class="text-xs text-slate-500 mb-1">Major</div>
                            <div class="text-xl font-bold text-emerald-800">{{ $k3_reports['incidents']['major'] }}</div>
                        </div>
                        <div class="bg-slate-50 rounded-lg p-4 text-center">
                            <div class="text-xs text-slate-500 mb-1">Minor</div>
                            <div class="text-xl font-bold text-emerald-800">{{ $k3_reports['incidents']['minor'] }}</div>
                        </div>
                        <div class="bg-slate-50 rounded-lg p-4 text-center">
                            <div class="text-xs text-slate-500 mb-1">Resolved</div>
                            <div class="text-xl font-bold text-emerald-800">{{ $k3_reports['incidents']['resolved'] }}</div>
                        </div>
                    </div>
                </div>

                {{-- Card 3: Waste Management --}}
                <div class="border border-slate-200 rounded-xl p-6 bg-white">
                    <div class="flex justify-between items-start mb-4">
                        <div class="text-base font-medium text-slate-800">Waste Management</div>
                        <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-medium">
                            {{ $k3_reports['waste']['status'] }}
                        </span>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="bg-slate-50 rounded-lg p-4 text-center">
                            <div class="text-xs text-slate-500 mb-1">Volume</div>
                            <div class="text-xl font-bold text-emerald-800">{{ $k3_reports['waste']['volume'] }}</div>
                        </div>
                        <div class="bg-slate-50 rounded-lg p-4 text-center">
                            <div class="text-xs text-slate-500 mb-1">B3</div>
                            <div class="text-xl font-bold text-emerald-800">{{ $k3_reports['waste']['b3'] }}</div>
                        </div>
                        <div class="bg-slate-50 rounded-lg p-4 text-center">
                            <div class="text-xs text-slate-500 mb-1">Disposal</div>
                            <div class="text-xl font-bold text-emerald-800">{{ $k3_reports['waste']['disposal'] }}</div>
                        </div>
                    </div>
                </div>

                {{-- Card 4: PPE Compliance --}}
                <div class="border border-slate-200 rounded-xl p-6 bg-white">
                    <div class="text-base font-medium text-slate-800 mb-4">PPE Compliance</div>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="bg-slate-50 rounded-lg p-4 text-center">
                            <div class="text-xs text-slate-500 mb-1">Checkpoints</div>
                            <div class="text-xl font-bold text-emerald-800">{{ $k3_reports['ppe']['checkpoints'] }}</div>
                        </div>
                        <div class="bg-slate-50 rounded-lg p-4 text-center">
                            <div class="text-xs text-slate-500 mb-1">Compliant</div>
                            <div class="text-xl font-bold text-emerald-800">{{ $k3_reports['ppe']['compliant'] }}</div>
                        </div>
                        <div class="bg-slate-50 rounded-lg p-4 text-center">
                            <div class="text-xs text-slate-500 mb-1">Rate</div>
                            <div class="text-xl font-bold text-emerald-800">{{ $k3_reports['ppe']['rate'] }}%</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

{{-- SECTION 3: GENERATE LAPORAN (GAMBAR BAWAH) --}}
<div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 mt-6">
    <div class="mb-5">
        <h2 class="text-lg font-semibold text-slate-800">Generate Laporan Detail</h2>
        <p class="text-sm text-emerald-700">Export laporan utilisasi dalam berbagai format</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        {{-- Button 1: PDF --}}
        <button class="flex flex-col items-center justify-center p-6 border border-slate-200 rounded-xl hover:bg-slate-50 hover:border-emerald-300 hover:shadow-md transition-all group">
            <div class="w-10 h-10 mb-3 bg-slate-50 rounded-full flex items-center justify-center group-hover:bg-white group-hover:text-emerald-600 text-slate-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <span class="text-sm font-semibold text-slate-700 group-hover:text-emerald-800">Laporan PDF</span>
        </button>

        {{-- Button 2: Excel --}}
        <button class="flex flex-col items-center justify-center p-6 border border-slate-200 rounded-xl hover:bg-slate-50 hover:border-emerald-300 hover:shadow-md transition-all group">
            <div class="w-10 h-10 mb-3 bg-slate-50 rounded-full flex items-center justify-center group-hover:bg-white group-hover:text-emerald-600 text-slate-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <span class="text-sm font-semibold text-slate-700 group-hover:text-emerald-800">Excel Analytics</span>
        </button>

        {{-- Button 3: Grafik --}}
        <button class="flex flex-col items-center justify-center p-6 border border-slate-200 rounded-xl hover:bg-slate-50 hover:border-emerald-300 hover:shadow-md transition-all group">
            <div class="w-10 h-10 mb-3 bg-slate-50 rounded-full flex items-center justify-center group-hover:bg-white group-hover:text-emerald-600 text-slate-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                </svg>
            </div>
            <span class="text-sm font-semibold text-slate-700 group-hover:text-emerald-800">Grafik Visual</span>
        </button>
    </div>
</div>

@endsection

@push('scripts')
    {{-- Script AlpineJS untuk Tab Interactivity --}}
    {{-- <script src="//unpkg.com/alpinejs" defer></script> --}}
@endpush