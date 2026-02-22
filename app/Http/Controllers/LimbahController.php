<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Insiden;
use App\Models\LabWaste;

class LimbahController extends Controller
{
    public function index()
    {
        // --- 1. Summary Cards Data (Sesuai Screenshot) ---
        $summary = [
            'insiden_bulan_ini' => 3,
            'insiden_selesai' => 2,
            'zero_incident_target' => 0, // Target
            'zero_incident_actual' => 0, // Actual Major Incident
            'limbah_b3_total' => 37.8,
            'kepatuhan_k3' => 95,
        ];

        // --- 2. Data Table: Laporan Insiden (Tab K3 & Insiden) ---
        $incidents = [
            [
                'id' => 'INC-001',
                'judul' => 'Tumpahan bahan kimia di area penyimpanan',
                'tanggal' => '2025-10-28',
                'tingkat' => 'Sedang',
                'pelapor' => 'Teknisi Budi',
                'capa' => 'CAPA-001',
                'status' => 'Selesai',
            ],
            [
                'id' => 'INC-002',
                'judul' => 'Luka gores ringan saat pembersihan alat gelas',
                'tanggal' => '2025-11-02',
                'tingkat' => 'Ringan',
                'pelapor' => 'Asisten Siti',
                'capa' => '-',
                'status' => 'Selesai',
            ],
            [
                'id' => 'INC-003',
                'judul' => 'Bau menyengat dari saluran pembuangan wastafel',
                'tanggal' => '2025-11-05',
                'tingkat' => 'Ringan',
                'pelapor' => 'Dr. Ahmad',
                'capa' => 'CAPA-003',
                'status' => 'Investigasi', // Asumsi status belum selesai
            ],
        ];

      $waste_logs = LabWaste::orderBy('created_at', 'desc')->get();
$trainings = [
            [
                'id' => 1,
                'judul' => 'Pelatihan K3 Dasar Laboratorium',
                'vendor' => 'PT Safety First Indonesia',
                'durasi' => '4 jam',
                'tanggal' => '2025-11-15',
                'peserta_current' => 28,
                'peserta_max' => 30,
                'topik' => ['Hazard identification', 'PPE usage', 'Emergency response'],
                'status' => 'Terjadwal',
            ],
            [
                'id' => 2,
                'judul' => 'Penanganan Limbah B3',
                'vendor' => 'PT Waste Management Indo',
                'durasi' => '3 jam',
                'tanggal' => '2025-10-25',
                'peserta_current' => 15,
                'peserta_max' => 15,
                'topik' => ['Klasifikasi limbah', 'Segregasi', 'Dokumentasi'],
                'status' => 'Selesai',
            ],
        ];

       $checklists = [
            ['task' => 'Pencahayaan ruangan memadai', 'status' => 'ok'],
            ['task' => 'Ventilasi berfungsi dengan baik', 'status' => 'ok'],
            ['task' => 'APAR dalam kondisi baik dan tidak kadaluwarsa', 'status' => 'ok'],
            ['task' => 'Emergency exit tidak terhalang', 'status' => 'ok'],
            ['task' => 'Eyewash station berfungsi', 'status' => 'ok'],
            ['task' => 'Safety shower berfungsi', 'status' => 'warning'], // Item bermasalah
            ['task' => 'Spill kit tersedia dan lengkap', 'status' => 'ok'],
            ['task' => 'Tempat sampah terpisah (B3 dan non-B3)', 'status' => 'ok'],
        ];

        // Hitung Skor & Progress
        $totalItems = count($checklists);
        $completedItems = collect($checklists)->where('status', 'ok')->count();
        $complianceScore = $totalItems > 0 ? round(($completedItems / $totalItems) * 100) : 0;
        
        // Ambil item yang perlu tindak lanjut (status warning)
        $actionItems = collect($checklists)->where('status', 'warning');

        return view('limbah.index', compact(
            'summary', 'incidents', 'waste_logs', 'trainings', // Variabel lama
            'checklists', 'complianceScore', 'completedItems', 'totalItems', 'actionItems' // Variabel baru
        ));
    }
    public function store(Request $request)
{
    // $request->validate([
    //     'id_insiden' => 'required',
    //     'tgl_kejadian' => 'required',
    //     'tgl_pelaporan' => 'required',
    //     'unit' => 'required',
    //     'lokasi' => 'required',
    //     'jenis_insiden' => 'required',
    //     'nama_pelapor' => 'required',
    //     'jabatan' => 'required',
    //     'judul' => 'nullable',
    //     'deskripsi' => 'required',
    //     'jenis_dampak' => 'required',
    //     'tingkat_keparahan' => 'required',
    //     'kategori_ncr' => 'required',
    // ]);

    // Upload file nanti kita tambah
$paths = [];

if ($request->hasFile('bukti')) {
    foreach ($request->file('bukti') as $file) {
        $paths[] = $file->store('bukti_insiden', 'public');
    }
}
$idInsiden = $this->generateIdInsiden();

  Insiden::create([
    'id_insiden'        => $idInsiden,
    'tgl_kejadian'      => $request->tgl_kejadian,
    'tgl_pelaporan'     => $request->tgl_lapor,
    'unit'              => $request->unit,
    'lokasi'            => $request->lokasi,
    'jenis_insiden'     => $request->jenis_insiden,
    'nama_pelapor'      => $request->nama_pelapor,
    'jabatan'           => $request->jabatan,
    'kontak'            => $request->kontak,
    'status_pelapor'    => $request->status_pelapor,
    'judul'             => $request->judul,
    'deskripsi'         => $request->deskripsi,
    'jenis_dampak'      => $request->jenis_dampak,
    'tingkat_keparahan' => $request->tingkat_keparahan,
    'kategori_ncr'      => $request->kategori_ncr,
    'dokumen_pendukung' => json_encode($paths),
]);

    return response()->json(['message' => 'Berhasil']);
}
public function list()
{
    $data = Insiden::orderBy('created_at', 'desc')->get();

    return response()->json($data);
}
private function generateIdInsiden()
{
    $last = Insiden::orderBy('id', 'desc')->first();

    if (!$last) {
        return 'INC-001';
    }

    $lastNumber = intval(substr($last->id_insiden, 4)); // ambil angka
    $newNumber = $lastNumber + 1;

    return 'INC-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
}
public function show($id)
{
    $data = Insiden::findOrFail($id);
    return response()->json($data);
}
public function showByKode($id_insiden)
{
    $data = Insiden::where('id_insiden', $id_insiden)->firstOrFail();
    return response()->json($data);
}


}