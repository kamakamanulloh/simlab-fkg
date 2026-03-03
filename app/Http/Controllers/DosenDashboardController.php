<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\LabSchedule;

class DosenDashboardController extends Controller
{
    public function index()
    {
         $user = auth()->user();

          $today = Carbon::today();
        $sevenDaysLater = Carbon::today()->addDays(7);

        // ==============================
        // HITUNG SESI MENDATANG
        // ==============================
         $sesiMendatang = DB::table('lab_schedules')
            ->where('instruktur_id', $user->id)
            ->whereBetween('tanggal', [
                $today->format('Y-m-d'),
                $sevenDaysLater->format('Y-m-d')
            ])
            ->count();
               $jadwalMengajar = LabSchedule::where('instruktur_id', $user->id)
        ->whereBetween('tanggal', [$today, $sevenDaysLater])
        ->orderBy('tanggal', 'asc')
        ->get();

        $stats = [
            'kelas_aktif' => 3,
            'total_mahasiswa' => 57,
            'logbook_pending' => 3,
            'dinilai_minggu_ini' => 12,
            'sesi_mendatang' => $sesiMendatang,
        ];



        $logbooks = [
            [
                'nama' => 'Siti Aminah',
                'nim' => '2021045',
                'tanggal' => '2025-11-05',
                'sesi' => 'Periodonsia - Sesi 2',
                'skills' => [
                    'Scaling supragingival',
                    'Fluor polishing',
                    'Polishing'
                ],
                'status' => 'Pending'
            ]
        ];

        return view('dashboard.dosen', compact('stats','logbooks', 'jadwalMengajar'));
    }
}