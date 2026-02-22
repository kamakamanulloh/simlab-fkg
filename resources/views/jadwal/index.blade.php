@extends('layouts.app')

@section('title', 'Jadwal & Reservasi - SIM-Lab')

@section('content')
<div class="space-y-6">

    {{-- HEADER HALAMAN --}}
    <div class="flex items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-emerald-900">Manajemen Jadwal & Reservasi</h1>
            <p class="text-sm text-emerald-700">
                Kelola jadwal praktikum, OSCE, dan pelatihan laboratorium.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <button
                class="inline-flex items-center gap-2 rounded-xl border border-emerald-100 bg-white px-4 py-2 text-xs font-medium text-emerald-800 shadow-sm hover:bg-emerald-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M16 12l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Export
            </button>

            <button
                id="btnOpenModalJadwal"
                type="button"
                class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2 text-xs font-medium text-white shadow-lg shadow-emerald-300/40 hover:bg-emerald-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 4v16m8-8H4"/>
                </svg>
                Buat Jadwal Baru
            </button>
        </div>
    </div>

    {{-- GRID UTAMA: KALENDER + DAFTAR JADWAL --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

        {{-- KALENDER --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-emerald-50">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <div class="text-sm font-semibold text-slate-800">Kalender</div>
                    <div class="text-xs text-emerald-700">Pilih tanggal untuk melihat jadwal</div>
                </div>
                <div class="flex items-center gap-2 text-xs text-slate-500">
                    <span class="w-2 h-2 rounded-full bg-emerald-600"></span> Ada jadwal
                </div>
            </div>

            {{-- header bulan (static example) --}}
            <div class="flex items-center justify-between mt-4 mb-2">
    <button id="btnPrevMonth"
        class="w-8 h-8 flex items-center justify-center rounded-full text-slate-500 hover:bg-emerald-50">‹</button>

    <div id="calendarTitle" class="text-sm font-medium text-slate-800"></div>

    <button id="btnNextMonth"
        class="w-8 h-8 flex items-center justify-center rounded-full text-slate-500 hover:bg-emerald-50">›</button>
</div>

            {{-- nama hari --}}
            <div class="grid grid-cols-7 text-[11px] text-slate-400 mb-1">
    <div class="text-center">Su</div>
    <div class="text-center">Mo</div>
    <div class="text-center">Tu</div>
    <div class="text-center">We</div>
    <div class="text-center">Th</div>
    <div class="text-center">Fr</div>
    <div class="text-center">Sa</div>
</div>
          <div id="calendarGrid" class="grid grid-cols-7 gap-y-1 text-xs"></div>
        </div>

        {{-- DAFTAR JADWAL --}}
        <div id="scheduleList" class="mt-3 space-y-3 text-xs">
    @include('jadwal.partials.list', ['schedules' => $schedules])
</div>


    </div>

    {{-- BAGIAN BAWAH --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

        {{-- KETERSEDIAAN RUANGAN HARI INI --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-emerald-50">
            <div class="mb-4">
                <div class="text-sm font-semibold text-slate-800">Ketersediaan Ruangan Hari Ini</div>
                <div class="text-xs text-emerald-700">Slot tersisa</div>
            </div>

            <div class="space-y-2">
                @forelse($roomsToday as $room)
                    <div class="flex items-center justify-between rounded-xl bg-emerald-50 px-4 py-2 text-xs">
                        <div class="font-medium text-slate-800">{{ $room['nama'] }}</div>
                        <div class="text-emerald-700">{{ $room['info'] }}</div>
                    </div>
                @empty
                    <div class="text-xs text-slate-500">Belum ada data ruangan hari ini.</div>
                @endforelse
            </div>
        </div>

        {{-- UTILISASI RUANGAN --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-emerald-50">
            <div class="mb-2">
                <div class="text-sm font-semibold text-slate-800">Utilisasi Ruangan Mingguan</div>
                <div class="text-xs text-emerald-700">Periode {{ $weekRange }}</div>
            </div>

            <div class="mt-3 space-y-4">
                @forelse($weeklyUsage as $lab)
                    <div class="space-y-1">
                        <div class="flex items-center justify-between text-[11px] text-slate-600">
                            <span>{{ $lab['nama'] }}</span>
                            <span class="text-emerald-700 font-medium">{{ $lab['persen'] }}%</span>
                        </div>

                        <div class="w-full h-2.5 rounded-full bg-emerald-50 overflow-hidden">
                            <div class="h-full bg-emerald-600 rounded-full"
                                style="width: {{ $lab['persen'] }}%"></div>
                        </div>
                    </div>
                @empty
                    <div class="text-xs text-slate-500">Tidak ada data utilisasi minggu ini.</div>
                @endforelse
            </div>
        </div>

    </div>

</div>

{{-- ========================= --}}
{{-- MODAL JADWAL BARU --}}
{{-- ========================= --}}
@include('jadwal.modal')

@endsection

@push('scripts')
@include('jadwal.script')
@endpush
