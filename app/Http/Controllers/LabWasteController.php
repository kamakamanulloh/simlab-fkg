<?php

namespace App\Http\Controllers;

use App\Models\LabWaste;
use Illuminate\Http\Request;

class LabWasteController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'jenis_limbah'        => 'required|string|max:100',
            'kategori'            => 'required|string|max:100',
            'lokasi'              => 'required|string|max:100',
            'status'              => 'required|string|max:50',
            'berat'               => 'required|numeric|min:0',
            'kondisi_wadah'       => 'required|string|max:50',
            'volume_wadah'        => 'required|string|max:50',
            'apd'                 => 'required|string|max:50',
            'keterangan'          => 'nullable|string',
            'status_verifikasi'   => 'required|string|max:50',
            'alur_pembuangan'     => 'required|string|max:50',
        ]);

        LabWaste::create($data);

        return response()->json([
            'status'  => 'ok',
            'message' => 'Data limbah berhasil disimpan',
        ]);
    }
}
