
@extends('layouts.app')

@section('title', 'Dashboard SIM-Lab')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="space-y-3">
        <h1 class="text-2xl font-semibold text-emerald-900">Dashboard Laboratorium</h1>
        <p class="text-sm text-emerald-700">
            Ringkasan kinerja dan aktivitas laboratorium keterampilan klinik.
        </p>

        {{-- KARTU RINGKASAN --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-2">

            {{-- Utilisasi Ruang --}}
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-emerald-50">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <div class="text-xs text-slate-500">Utilisasi Ruang</div>
                        <div class="text-2xl font-semibold text-emerald-700 mt-1">
                            {{ $stats['utilisasi_ruang'] }}%
                        </div>
                    </div>
                    <div class="text-slate-400 text-lg">📅</div>
                </div>
                <div class="mt-3">
                    <div class="w-full h-2 rounded-full bg-emerald-100 overflow-hidden">
                        <div class="h-full bg-emerald-500" style="width: {{ $stats['utilisasi_ruang'] }}%"></div>
                    </div>
                </div>
            </div>

            {{-- Alat Aktif --}}
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-emerald-50">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <div class="text-xs text-slate-500">Alat Aktif</div>
                        <div class="text-2xl font-semibold text-emerald-700 mt-1">
                            {{ $stats['alat_aktif'] }}
                        </div>
                    </div>
                    <div class="text-slate-400 text-lg">📦</div>
                </div>
                <div class="mt-3">
                    <div class="w-full h-2 rounded-full bg-emerald-100 overflow-hidden">
                        <div class="h-full bg-emerald-500" style="width: {{ $stats['alat_aktif_pct'] }}%"></div>
                    </div>
                    <div class="text-xs text-slate-500 mt-2">
                        {{ $stats['alat_aktif_pct'] }}% dalam kondisi baik
                    </div>
                </div>
            </div>

            {{-- Peminjaman Aktif --}}
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-emerald-50">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <div class="text-xs text-slate-500">Peminjaman Aktif</div>
                        <div class="text-2xl font-semibold text-emerald-700 mt-1">
                            {{ $stats['peminjaman_aktif'] }}
                        </div>
                    </div>
                    <div class="text-slate-400 text-lg">📈</div>
                </div>
            </div>

            {{-- Insiden K3 --}}
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-emerald-50">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <div class="text-xs text-slate-500">Insiden K3</div>
                        <div class="text-2xl font-semibold text-emerald-700 mt-1">
                            {{ $stats['insiden_k3'] }}
                        </div>
                    </div>
                    <div class="text-slate-400 text-lg">⚠️</div>
                </div>
                <div class="mt-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-[11px] text-emerald-700 border border-emerald-100">
                        ✓ Zero incident
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- GRAFIK ATAS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        {{-- Utilisasi Mingguan --}}
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-emerald-50">
            <div class="mb-4">
                <div class="text-sm font-semibold text-slate-800">Utilisasi Ruang Mingguan</div>
                <div class="text-xs text-emerald-700">
                    Persentase penggunaan ruang praktikum
                </div>
            </div>
            <canvas id="chartWeeklyUsage" class="w-full h-48"></canvas>
        </div>

        {{-- Status Peralatan --}}
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-emerald-50">
            <div class="mb-4">
                <div class="text-sm font-semibold text-slate-800">Status Peralatan</div>
                <div class="text-xs text-emerald-700">
                    Distribusi kondisi alat laboratorium
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="w-40 h-40">
                    <canvas id="chartStatusPeralatan"></canvas>
                </div>
                <div class="text-xs space-y-1">
                    <div>Aktif: {{ $alatAktif }}</div>
                    <div>Rusak: {{ $alatRusak }}</div>
                    <div>Kalibrasi: {{ $alatKalibrasi }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- TREND PEMINJAMAN --}}
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-emerald-50">
        <div class="mb-4">
            <div class="text-sm font-semibold text-slate-800">Trend Peminjaman Alat</div>
            <div class="text-xs text-emerald-700">
                5 bulan terakhir
            </div>
        </div>
        <canvas id="chartTrendPeminjaman" class="w-full h-56"></canvas>
    </div>

    {{-- AKTIVITAS --}}
 
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        {{-- Peringatan & Notifikasi --}}
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-emerald-50">
            <div class="text-sm font-semibold text-slate-800 mb-4">Peringatan & Notifikasi</div>
            <div class="space-y-3 text-xs">
                <div class="rounded-xl bg-amber-50 border border-amber-100 px-4 py-3">
                    <div class="font-medium text-amber-800 mb-1">8 bahan mendekati tanggal kedaluwarsa</div>
                    <div class="text-amber-700">Dalam 30 hari ke depan</div>
                </div>
                <div class="rounded-xl bg-sky-50 border border-sky-100 px-4 py-3">
                    <div class="font-medium text-sky-800 mb-1">12 alat jadwal kalibrasi bulan ini</div>
                    <div class="text-sky-700">3 sudah selesai, 9 pending</div>
                </div>
                <div class="rounded-xl bg-emerald-50 border border-emerald-100 px-4 py-3">
                    <div class="font-medium text-emerald-800 mb-1">
                        Pelatihan K3 terjadwal 15 November 2025
                    </div>
                    <div class="text-emerald-700">28 peserta terdaftar</div>
                </div>
            </div>
        </div>

        {{-- Aktivitas Terakhir --}}
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-emerald-50">
            <div class="text-sm font-semibold text-slate-800 mb-4">Aktivitas Terakhir</div>
            <div class="space-y-3 text-xs">
                @foreach($recentActivities as $act)
                <div class="flex gap-3">
                    <span class="mt-1 w-2 h-2 rounded-full bg-emerald-500"></span>
                    <div>
                        <div class="font-medium text-slate-800">
                            {{ $act->judul }}
                        </div>
                        <div class="text-slate-500">
                            {{ $act->created_at->diffForHumans() }}
                            • oleh {{ $act->creator->name ?? '-' }}
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // =========================
    // WEEKLY USAGE
    // =========================
    const weeklyLabels = @json($weeklyLabels);
    const weeklyValues = @json($weeklyValues);

    new Chart(document.getElementById('chartWeeklyUsage'), {
        type: 'bar',
        data: {
            labels: weeklyLabels,
            datasets: [{
                label: 'Utilisasi',
                data: weeklyValues,
                borderWidth: 1
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    // =========================
    // STATUS PERALATAN
    // =========================
    new Chart(document.getElementById('chartStatusPeralatan'), {
        type: 'pie',
        data: {
            labels: ['Aktif', 'Rusak', 'Kalibrasi'],
            datasets: [{
                data: [{{ $alatAktif }}, {{ $alatRusak }}, {{ $alatKalibrasi }}],
                borderWidth: 1
            }]
        },
        options: {
            plugins: { legend: { display: false } }
        }
    });

    // =========================
    // TREND PEMINJAMAN
    // =========================
    const trendLabels = @json($trendLabels);
    const trendValues = @json($trendValues);

    new Chart(document.getElementById('chartTrendPeminjaman'), {
        type: 'line',
        data: {
            labels: trendLabels,
            datasets: [{
                label: 'Peminjaman',
                data: trendValues,
                tension: 0.35,
                borderWidth: 2
            }]
        },
        options: {
            plugins: { legend: { position: 'bottom' } },
            scales: { y: { beginAtZero: true } }
        }
    });
</script>
@endpush
