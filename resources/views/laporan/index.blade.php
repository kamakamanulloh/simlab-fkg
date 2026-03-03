@extends('layouts.app')
@section('title', 'Laporan & Analitik - SIM-Lab')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-slate-800">
                Dashboard Pelaporan & Analitik
            </h1>
            <p class="text-sm text-emerald-700 mt-1">
                Laporan komprehensif aktivitas dan kinerja laboratorium
            </p>
        </div>

        <div class="flex items-center gap-3">

            {{-- Dropdown --}}
            <select class="bg-white border border-slate-200 text-sm rounded-lg px-4 py-2 focus:ring-emerald-500 focus:border-emerald-500">
                <option>Bulanan</option>
                <option>Mingguan</option>
                <option>Tahunan</option>
            </select>

            {{-- Export Button --}}
            <a href="{{ route('laporan.export_pdf') }}" target="_blank"
               class="inline-flex items-center gap-2 bg-emerald-800 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-emerald-900 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Export PDF
            </a>
        </div>
    </div>

    {{-- SUMMARY CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

        @foreach($summary as $item)
        <div class="bg-white p-6 rounded-2xl border border-emerald-100 shadow-sm hover:shadow-md transition">

            <div class="flex justify-between mb-4">
                <div class="text-sm text-slate-600 font-medium">
                    {{ $item['title'] }}
                </div>
                <div class="text-slate-400">
                    {!! $item['icon'] !!}
                </div>
            </div>

            <div class="text-3xl font-bold text-slate-800">
                {{ $item['value'] }}
            </div>

            @if(isset($item['trend']))
            <div class="flex items-center gap-1 text-xs mt-2">
                <span class="text-emerald-600 font-semibold">
                    {{ $item['trend'] }}
                </span>
                <span class="text-slate-400">
                    {{ $item['desc'] }}
                </span>
            </div>
            @endif

        </div>
        @endforeach

    </div>

    {{-- TABS CONTAINER --}}
    <div x-data="{ activeTab: 'utilisasi' }"
         class="bg-emerald-50 rounded-2xl shadow-sm">

        {{-- TAB NAV --}}
        <div class="flex gap-1 bg-emerald-100 p-1 rounded-t-2xl overflow-x-auto">

            @php
                $tabs = [
                    'utilisasi' => 'Utilisasi Ruang',
                    'penggunaan' => 'Penggunaan Alat',
                    'partisipasi' => 'Partisipasi',
                    'pemeliharaan' => 'Pemeliharaan',
                    'k3' => 'K3 & Limbah'
                ];
            @endphp

            @foreach($tabs as $key => $label)
            <button @click="activeTab='{{ $key }}'"
                :class="activeTab==='{{ $key }}'
                    ? 'bg-white text-emerald-800 shadow font-semibold'
                    : 'text-emerald-700 hover:bg-white/60'"
                class="px-6 py-2 text-sm rounded-xl transition whitespace-nowrap">
                {{ $label }}
            </button>
            @endforeach
        </div>

        {{-- TAB CONTENT --}}
        <div class="bg-white rounded-b-2xl p-8 border border-emerald-100">

            {{-- UTILISASI RUANG --}}
            <div x-show="activeTab==='utilisasi'" class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- LEFT --}}
                <div class="lg:col-span-2 space-y-10">

                    <div>
                        <h2 class="text-base font-semibold text-slate-800">
                            Utilisasi Ruangan per Lab
                        </h2>
                        <p class="text-sm text-emerald-600">
                            Periode: November 2025
                        </p>
                    </div>

                    @foreach($lab_utilizations as $lab)
                    <div>

                        <div class="flex justify-between items-end mb-2">
                            <div>
                                <div class="text-base font-medium text-slate-800">
                                    {{ $lab['name'] }}
                                </div>
                                <div class="text-xs text-slate-500">
                                    {{ $lab['usage_text'] }}
                                </div>
                            </div>

                            <div class="text-xl font-bold text-emerald-800">
                                {{ $lab['percentage'] }}%
                            </div>
                        </div>

                        {{-- PROGRESS --}}
                        <div class="relative w-full h-4 bg-emerald-100 rounded-full overflow-hidden">

                            <div class="absolute left-0 top-0 h-4 bg-emerald-800 rounded-full"
                                 style="width: {{ $lab['percentage'] }}%">
                            </div>

                            {{-- Target Marker --}}
                            <div class="absolute top-0 bottom-0 w-0.5 bg-slate-500"
                                 style="left: {{ $lab['target'] }}%">
                            </div>
                        </div>

                        {{-- SCALE --}}
                        <div class="relative mt-2 text-xs text-slate-400 h-4">
                            <span class="absolute left-0">0%</span>

                            <span class="absolute -translate-x-1/2"
                                  style="left: {{ $lab['target'] }}%">
                                Target: {{ $lab['target'] }}%
                            </span>

                            <span class="absolute right-0">100%</span>
                        </div>

                    </div>
                    @endforeach

                </div>

                {{-- RIGHT CARD --}}
                <div class="bg-white border border-emerald-100 rounded-2xl p-5 shadow-sm h-fit">

                    <div class="mb-4">
                        <h3 class="text-sm font-semibold text-slate-800">
                            Tren Utilisasi
                        </h3>
                        <p class="text-xs text-emerald-600">
                            5 bulan terakhir
                        </p>
                    </div>

                    <div class="space-y-4">
                        @foreach($monthly_trends as $trend)
                        <div class="flex justify-between items-center p-3 rounded-xl hover:bg-emerald-50 transition">

                            <div>
                                <div class="text-sm font-medium text-slate-800">
                                    {{ $trend['month'] }}
                                </div>
                                <div class="text-xs text-slate-500">
                                    {{ $trend['sessions'] }}
                                </div>
                            </div>

                            <div class="text-right">
                                <div class="text-sm font-bold text-emerald-700">
                                    {{ $trend['percent'] }}%
                                </div>

                                <div class="w-20 h-2 bg-emerald-100 rounded-full mt-1 ml-auto">
                                    <div class="h-2 bg-emerald-700 rounded-full"
                                         style="width: {{ $trend['percent'] }}%">
                                    </div>
                                </div>
                            </div>

                        </div>
                        @endforeach
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>

@endsection