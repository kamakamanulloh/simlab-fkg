<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LabSchedule;
use Carbon\Carbon;
use App\Models\LabInventoryItem;

class MahasiswaDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

     $alatList = LabInventoryItem::where('stock', '>', 0)
    ->orderBy('name')
    ->get();
      $sessions = LabSchedule::whereDate('tanggal', '<=', now())
        ->orderByDesc('tanggal')
        ->get();

        $progress = [
            [
                'nama' => 'Konservasi Gigi',
                'done' => 10,
                'total' => 12,
                'avg' => 87,
            ],
            [
                'nama' => 'Endodontik',
                'done' => 6,
                'total' => 8,
                'avg' => 85,
            ],
        ];

        return view('dashboard.mahasiswa', compact('progress','alatList','sessions'));
    }

    public function jadwalByDate(Request $request)
{
    $user = auth()->user();

    $start = $request->start 
        ? Carbon::parse($request->start) 
        : Carbon::today();

    $end = $request->end 
        ? Carbon::parse($request->end) 
        : Carbon::today()->addDays(7);

    $schedules = LabSchedule::whereBetween('tanggal', [$start, $end])
       
        ->orderBy('tanggal')
        ->orderBy('waktu')
        ->get()
        ->groupBy('tanggal'); // biar rapi per hari

    return view('mahasiswa.partials.jadwal-list', compact('schedules'));
}
}