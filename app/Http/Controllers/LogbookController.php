<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogbookController extends Controller
{
    /**
     * Menampilkan halaman Logbook Digital dengan data capaian dan entri.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // --- Dummy Data untuk Contoh Tampilan ---
        // Dalam aplikasi nyata, data ini diambil dari model database
        
        // Data Ringkasan Logbook
        $summary = [
            'total_entry' => 3,
            'dinilai' => 2,
            'menunggu' => 1,
            'rata_rata' => 88.2,
        ];

        // Data Mahasiswa (untuk tab Capaian Kompetensi)
        $student = [
            'nama' => 'Muhammad Rizki',
            'nim' => '2021001',
            'semester' => 5,
            'progress_percent' => 75, // 18/24
        ];
        
        // Data Capaian Kompetensi per Kategori
        $competencies = [
            [
                'nama' => 'Konservasi Gigi',
                'capaian_count' => 10,
                'total_count' => 12,
                'rata_rata' => 87,
                'persen' => 83,
            ],
            [
                'nama' => 'Endodontik',
                'capaian_count' => 6,
                'total_count' => 8,
                'rata_rata' => 85,
                'persen' => 75,
            ],
            [
                'nama' => 'Periodonsia',
                'capaian_count' => 8,
                'total_count' => 10,
                'rata_rata' => 89,
                'persen' => 80,
            ],
            [
                'nama' => 'Prostodonsia',
                'capaian_count' => 11,
                'total_count' => 14,
                'rata_rata' => 91,
                'persen' => 79,
            ],
        ];

        // Data Remidiasi & Terbaik
        $remediations = [
            ['nama' => 'Root Canal Treatment - Obturasi', 'bidang' => 'Endodontik', 'nilai' => 65],
            ['nama' => 'Crown Preparation', 'bidang' => 'Prostodonsia', 'nilai' => 68],
        ];

        $bests = [
            ['nama' => 'Composite Restoration', 'bidang' => 'Konservasi Gigi', 'nilai' => 95],
            ['nama' => 'Complete Denture Impression', 'bidang' => 'Prostodonsia', 'nilai' => 94],
        ];


      $logEntries = [
        [
            'mahasiswa' => 'Muhammad Rizki', 'nim' => '2021001', 'tanggal' => '2025-11-05', 'status' => 'Dinilai',
            'sesi' => 'Praktikum Endodontik - Sesi 1', 'aktivitas' => ['Preparasi akses kavitas', 'Cleaning & shaping', 'Obturasi'],
            'penilaian' => [
                ['nama' => 'Diagnosis', 'nilai' => 85],
                ['nama' => 'Preparasi', 'nilai' => 90],
                ['nama' => 'Obturasi', 'nilai' => 88],
            ],
            'feedback' => 'Teknik preparasi sudah baik. Perhatikan kedalaman kerja.',
            'lampiran_count' => 3
        ],
        [
            'mahasiswa' => 'Siti Aminah', 'nim' => '2021045', 'tanggal' => '2025-11-05', 'status' => 'Menunggu',
            'sesi' => 'Praktikum Periodonsia - Sesi 2', 'aktivitas' => ['Scaling supragingival', 'Root planing', 'Polishing'],
            'penilaian' => [], // Belum dinilai
            'feedback' => null,
            'lampiran_count' => 1
        ],
    ];
    // --------------------------------------------------------------------

    return view('logbook.index', compact(
        'summary',
        'student',
        'competencies',
        'remediations',
        'bests',
        'logEntries' // BARU: Tambahkan ini ke compact
    ));
    }
}