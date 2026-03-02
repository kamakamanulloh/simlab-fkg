<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelatihan;

class PelatihanController extends Controller
{
    /**
     * List semua pelatihan
     */
    public function index()
    {
        $pelatihans = Pelatihan::latest()->get();

        return view('pelatihan.index', compact('pelatihans'));
    }

    /**
     * Simpan data pelatihan (AJAX)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelatihan'     => 'required|string|max:255',
            'jenis_pelatihan'    => 'required|string|max:100',
            'lokasi'             => 'required|string|max:255',
            'level'              => 'required|string|max:100',
            'kuota'              => 'required|integer|min:1',
            'status_pelaksanaan' => 'required|string|max:100',
            'hasil'              => 'required|string|max:100',
        ]);

        $pelatihan = Pelatihan::create($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Data pelatihan berhasil disimpan',
            'data'    => $pelatihan
        ]);
    }

    /**
     * Detail pelatihan (untuk edit modal)
     */
    public function show($id)
    {
        $pelatihan = Pelatihan::findOrFail($id);

        return response()->json($pelatihan);
    }

    /**
     * Update pelatihan
     */
    public function update(Request $request, $id)
    {
        $pelatihan = Pelatihan::findOrFail($id);

        $validated = $request->validate([
            'nama_pelatihan'     => 'required|string|max:255',
            'jenis_pelatihan'    => 'required|string|max:100',
            'lokasi'             => 'required|string|max:255',
            'level'              => 'required|string|max:100',
            'kuota'              => 'required|integer|min:1',
            'status_pelaksanaan' => 'required|string|max:100',
            'hasil'              => 'required|string|max:100',
        ]);

        $pelatihan->update($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Data pelatihan berhasil diperbarui',
            'data'    => $pelatihan
        ]);
    }

    /**
     * Hapus pelatihan
     */
    public function destroy($id)
    {
        $pelatihan = Pelatihan::findOrFail($id);
        $pelatihan->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Data pelatihan berhasil dihapus'
        ]);
    }
}