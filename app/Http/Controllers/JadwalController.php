<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LabSchedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
   public function index(Request $request)
{
    // ============================
    // FILTER TANGGAL (optional)
    // ============================
    $filterDate = $request->query('tanggal'); // contoh: ?tanggal=2025-11-06

    if ($filterDate) {
        $selectedDate = Carbon::parse($filterDate)->format('Y-m-d');

        $schedules = LabSchedule::whereDate('tanggal', $selectedDate)
            ->orderBy('waktu')
            ->get();

        $weekRange = Carbon::parse($filterDate)->startOfWeek()->format('d M Y')
                    .' – '.
                    Carbon::parse($filterDate)->endOfWeek()->format('d M Y');

    } else {
        // ============================
        // DEFAULT: WEEKLY FILTER
        // ============================
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek   = Carbon::now()->endOfWeek();

        $weekRange = $startOfWeek->format('d M Y').' – '.$endOfWeek->format('d M Y');

        $schedules = LabSchedule::whereBetween('tanggal', [
                $startOfWeek->format('Y-m-d'),
                $endOfWeek->format('Y-m-d')
            ])
            ->orderBy('tanggal')
            ->orderBy('waktu')
            ->get();
    }

    // ============================
    // KETERSEDIAAN RUANGAN (REAL)
    // ============================
    $today = Carbon::now()->format('Y-m-d');

    $roomsToday = LabSchedule::select('ruangan', DB::raw('count(*) as total'))
        ->whereDate('tanggal', $today)
        ->groupBy('ruangan')
        ->get()
        ->map(function ($row) {
            return [
                'nama' => $row->ruangan,
                'info' => $row->total == 0 ? '2 slot tersedia' : (3 - $row->total).' slot tersedia'
            ];
        });

    // ============================
    // UTILISASI RUANGAN MINGGUAN
    // ============================
    $weeklyUsage = LabSchedule::select('ruangan', DB::raw('count(*) as total'))
        ->whereBetween('tanggal', [
            Carbon::now()->startOfWeek()->format('Y-m-d'),
            Carbon::now()->endOfWeek()->format('Y-m-d')
        ])
        ->groupBy('ruangan')
        ->get()
        ->map(function ($row) {
            return [
                'nama'   => $row->ruangan,
                'persen' => min(100, $row->total * 20), // contoh hitungan dummy: 1 jadwal = 20%
            ];
        });
            $dosen = DB::table('users')
                ->select('id','name')
                ->where('role','Dosen')
                ->orderBy('name','asc')
                ->get();

    return view('jadwal.index', compact(
        'weekRange', 'schedules', 'roomsToday', 'weeklyUsage', 'filterDate','dosen'
    ));
}
       public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'           => ['required', 'string', 'max:255'],
            'jenis'           => ['nullable', 'string', 'max:100'],
            'ruangan'         => ['nullable', 'string', 'max:150'],
            'tanggal'         => ['required', 'date'],
            'waktu'           => ['required', 'string', 'max:50'],
            'instruktur_id'      => ['required', 'exists:users,id'],
            'jumlah_peserta'  => ['nullable', 'integer', 'min:1'],
            'catatan'         => ['nullable', 'string'],
        ]);

        $validated['created_by'] = auth()->id();
        $validated['status']     = 'menunggu';

        $schedule = LabSchedule::create($validated);

        

        return response()->json([
            'status'  => 'ok',
            'message' => 'Jadwal berhasil diajukan dan menunggu persetujuan.',
            'data'    => $schedule,
        ]);
    }
 public function byDate(Request $request)
{
    $query = LabSchedule::with('instruktur')
                ->orderBy('tanggal')
                ->orderBy('waktu');

    if ($request->start && $request->end) {
        $query->whereBetween('tanggal', [
            $request->start,
            $request->end
        ]);
    } elseif ($request->start) {
        $query->whereDate('tanggal', $request->start);
    }

    $schedules = $query->get();

    return view('jadwal.partials.list', compact('schedules'));
}
public function show($id)
{
    return response()->json(
        LabSchedule::findOrFail($id)
    );
}

public function update(Request $request, $id)
{
    $schedule = LabSchedule::findOrFail($id);

    $schedule->update($request->validate([
        'judul' => 'required',
        'jenis' => 'nullable',
        'ruangan' => 'nullable',
        'tanggal' => 'required|date',
        'waktu' => 'required',
        'instruktur' => 'nullable',
        'jumlah_peserta' => 'nullable|integer',
        'catatan' => 'nullable',
    ]));

    return response()->json([
        'status' => 'ok',
        'message' => 'Jadwal berhasil diperbarui'
    ]);
}

public function destroy($id)
{
    LabSchedule::findOrFail($id)->delete();

    return response()->json([
        'status' => 'ok',
        'message' => 'Jadwal berhasil dihapus'
    ]);
}

}
