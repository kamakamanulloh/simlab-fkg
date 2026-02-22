<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Insiden;
use App\Models\LabSchedule;
use App\Models\LabInventoryItem;
use App\Models\Loan;

class DashboardController extends Controller
{
    public function index()
    {
        // =========================
        // INSIDEN K3
        // =========================
        $insidenK3 = Insiden::whereMonth('tgl_kejadian', Carbon::now()->month)
                            ->whereYear('tgl_kejadian', Carbon::now()->year)
                            ->count();

        // =========================
        // AKTIVITAS TERAKHIR
        // =========================
        $recentActivities = LabSchedule::with('creator')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // =========================
        // UTILISASI RUANG MINGGUAN
        // =========================
        $weeklyUsage = LabSchedule::selectRaw('DAYNAME(tanggal) as day, COUNT(*) as total')
            ->whereBetween('tanggal', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])
            ->groupBy('day')
            ->get();

        $weeklyLabels = $weeklyUsage->pluck('day');
        $weeklyValues = $weeklyUsage->pluck('total');

        // =========================
        // STATUS PERALATAN
        // =========================
        $totalAlat = LabInventoryItem::where('item_type', 'alat')->count();

        $alatAktif = LabInventoryItem::where('item_type', 'alat')
            ->where('status', 'Aktif')
            ->count();

        $alatRusak = LabInventoryItem::where('item_type', 'alat')
            ->where('status', 'Rusak')
            ->count();

        $alatKalibrasi = LabInventoryItem::where('item_type', 'alat')
            ->where('status', 'Kalibrasi')
            ->count();

        $alatAktifPct = $totalAlat > 0 ? round(($alatAktif / $totalAlat) * 100) : 0;

        // =========================
        // PEMINJAMAN AKTIF
        // =========================
        $peminjamanAktif = Loan::where('status', 'Dipinjam')->count();

        // =========================
        // TREND PEMINJAMAN (5 bulan terakhir)
        // =========================
        $trendLoans = Loan::selectRaw('MONTH(start_at) as month, COUNT(*) as total')
            ->where('start_at', '>=', now()->subMonths(5))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $trendLabels = $trendLoans->pluck('month');
        $trendValues = $trendLoans->pluck('total');

        // =========================
        // STATS KARTU
        // =========================
        $stats = [
            'utilisasi_ruang'   => $weeklyValues->sum() > 0 ? round(($weeklyValues->sum() / 20) * 100) : 0, // estimasi
            'alat_aktif'        => $alatAktif,
            'alat_aktif_pct'    => $alatAktifPct,
            'peminjaman_aktif' => $peminjamanAktif,
            'insiden_k3'        => $insidenK3,
        ];

        return view('dashboard.index', compact(
            'stats',
            'recentActivities',
            'weeklyLabels',
            'weeklyValues',
            'alatAktif',
            'alatRusak',
            'alatKalibrasi',
            'trendLabels',
            'trendValues'
        ));
    }
}
