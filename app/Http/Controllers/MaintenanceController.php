<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class MaintenanceController extends Controller
{
    public function index()
    {
        // --- Dummy Data untuk Card Summary ---
        $bulanIni = Carbon::now()->monthName . ' ' . Carbon::now()->year;
        $summary = [
            'pemeliharaan_selesai' => 3,
            'pemeliharaan_bulan_ini' => '1 selesai',
            'kalibrasi_terjadwal' => 2,
            'kalibrasi_30_hari' => 'Dalam 30 hari',
            'kalibrasi_terlambat' => 1,
            'kalibrasi_perlu_ditangani' => 'Perlu segera ditangani',
            'biaya_bulan_ini' => 'Rp 5.05M',
            'biaya_persen' => '+8% dari bulan lalu',
        ];

        // --- Dummy Data untuk Riwayat Pemeliharaan (Table) ---
        $maintenances = [
            [
                'id' => 'MT-001',
                'alat' => 'Autoclave',
                'eq_code' => 'EQ-003',
                'jenis' => 'Preventive',
                'tanggal' => '2025-11-10',
                'teknisi' => 'Teknisi Budi',
                'biaya' => 'Rp 500K',
                'status' => 'Terjadwal',
            ],
            [
                'id' => 'MT-002',
                'alat' => 'Mikroskop Operasi',
                'eq_code' => 'EQ-006',
                'jenis' => 'Corrective',
                'tanggal' => '2025-11-05',
                'teknisi' => 'Vendor PT Medis',
                'biaya' => 'Rp 1.250K',
                'status' => 'Selesai',
            ],
            [
                'id' => 'MT-003',
                'alat' => 'Dental X-Ray Unit',
                'eq_code' => 'EQ-005',
                'jenis' => 'Calibration',
                'tanggal' => '2025-11-08',
                'teknisi' => 'PT Kalibrasi Indo',
                'biaya' => 'Rp 2.500K',
                'status' => 'Berlangsung',
            ],
        ];
        
        // --- Dummy Data untuk Pemeliharaan Mendatang (30 Hari) ---
        $upcoming = [
            [
                'judul' => 'Autoclave - Pemeliharaan Preventif',
                'tanggal' => '10 November 2025',
                'eq_code' => 'EQ-003',
                'icon_class' => 'text-blue-500', // Contoh untuk custom icon/warna
                'sisa_hari' => '5 hari lagi',
            ],
            [
                'judul' => 'Ultrasonic Scaler - Kalibrasi',
                'tanggal' => '10 November 2025',
                'eq_code' => 'EQ-004',
                'icon_class' => 'text-purple-500',
                'sisa_hari' => '5 hari lagi',
            ],
        ];

        return view('pemeliharaan.index', compact(
            'summary',
            'maintenances',
            'upcoming',
            'bulanIni'
        ));
    }
}