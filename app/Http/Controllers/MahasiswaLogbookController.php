<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Logbook;
use App\Models\LabSchedule;
use Carbon\Carbon;

class MahasiswaLogbookController extends Controller
{
    /**
     * Ambil list logbook mahasiswa (untuk AJAX)
     */
  public function list()
{
    $logbooks = Logbook::with('schedule')
        ->where('student_id', auth()->id())
        ->latest()
        ->get();

    return view('mahasiswa.partials.logbook-list', compact('logbooks'));
}

    /**
     * Simpan logbook
     */
    public function store(Request $request)
    {
        $request->validate([
            'lab_schedule_id' => 'required|exists:lab_schedules,id',
            'activity' => 'required'
        ]);

        $schedule = LabSchedule::findOrFail($request->lab_schedule_id);

        $filePath = null;

        if ($request->hasFile('documentation')) {

            $file = $request->file('documentation');
            $name = 'logbook_' . time() . '.' . $file->getClientOriginalExtension();

            $file->storeAs('public/logbooks', $name);

            $filePath = 'logbooks/' . $name;
        }

        $logbook = Logbook::create([
            'student_id'      => auth()->id(),
            'lab_schedule_id' => $schedule->id,
            'session_name'    => $schedule->judul,
            'session_code'    => 'LB-' . rand(100,999),
            'session_date'    => $schedule->tanggal,
            'activity'        => $request->activity,
            'competencies'    => json_encode($request->competencies),
            'documentation'   => $filePath,
            'status'          => $request->submit_type == 'draft' ? 'Draft' : 'Submitted'
        ]);

        return response()->json([
            'id' => $logbook->id,
            'session_name' => $logbook->session_name,
            'session_code' => $logbook->session_code,
            'session_date' => Carbon::parse($logbook->session_date)->format('Y-m-d'),
            'status' => $logbook->status,
            'score' => $logbook->score
        ]);
    }
}