<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomReservation;
use Carbon\Carbon;

class MahasiswaReservationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'tujuan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu' => 'required|string',
            'jumlah_peserta' => 'required|integer|min:1'
        ]);

        $reservation = RoomReservation::create([
            'user_id' => auth()->id(),
            'tujuan' => $request->tujuan,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'jumlah_peserta' => $request->jumlah_peserta,
            'status' => 'menunggu'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Reservasi berhasil diajukan.',
            'data' => $reservation
        ]);
    }
}
