<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        // 1. Data Summary Cards (Atas)
        $summary = [
            'total_sesi' => [
                'value' => 237,
                'trend' => '+8%',
                'trend_type' => 'up', // up/down
                'desc' => 'dari periode sebelumnya'
            ],
            'total_partisipan' => [
                'value' => 2695,
                'trend' => '+5%',
                'trend_type' => 'up',
                'desc' => 'dari periode sebelumnya'
            ],
            'utilisasi_rata' => [
                'value' => '76%',
                'trend' => '-2%',
                'trend_type' => 'down',
                'desc' => 'dari periode sebelumnya'
            ],
            'compliance' => [
                'value' => '95%',
                'desc' => 'K3, GLP & ISO compliance'
            ]
        ];

        // 2. Data Utilisasi Lab (Progress Bar Tengah)
        $lab_utilizations = [
            [
                'name' => 'Lab 1',
                'usage_text' => '24/30 slot terpakai • 32 jam/minggu',
                'percentage' => 80,
                'target' => 75
            ],
            [
                'name' => 'Lab 2',
                'usage_text' => '16/20 slot terpakai • 28 jam/minggu',
                'percentage' => 80,
                'target' => 75
            ],
            [
                'name' => 'Lab 3',
                'usage_text' => '11/15 slot terpakai • 22 jam/minggu',
                'percentage' => 73,
                'target' => 75
            ],
            [
                'name' => 'Lab 4',
                'usage_text' => '18/25 slot terpakai • 25 jam/minggu',
                'percentage' => 72,
                'target' => 75
            ],
        ];

        // 3. Data Tren Bulanan (Kanan)
        $monthly_trends = [
            ['month' => 'Jul', 'sessions' => '45 sesi', 'percent' => 75],
            ['month' => 'Aug', 'sessions' => '48 sesi', 'percent' => 78],
            ['month' => 'Sep', 'sessions' => '52 sesi', 'percent' => 82],
            ['month' => 'Oct', 'sessions' => '50 sesi', 'percent' => 80],
            ['month' => 'Nov', 'sessions' => '42 sesi', 'percent' => 78],
        ];
$top_equipment = [
            [
                'rank' => 1,
                'name' => 'X-Ray Unit',
                'usage' => '60% usage rate',
            ],
            [
                'rank' => 2,
                'name' => 'Autoclave',
                'usage' => '52% usage rate',
            ],
            [
                'rank' => 3,
                'name' => 'Handpiece',
                'usage' => '45% usage rate',
            ],
        ];

        $equipment_health = [
            [
                'title' => 'Operational',
                'subtitle' => '95% uptime',
                'badge' => 'Excellent',
                'type' => 'success' // Hijau
            ],
            [
                'title' => 'Under Maintenance',
                'subtitle' => '3 units',
                'badge' => 'Warning',
                'type' => 'warning' // Kuning
            ],
            [
                'title' => 'Calibration Due',
                'subtitle' => '2 units this week',
                'badge' => 'Scheduled',
                'type' => 'neutral' // Putih/Gray
            ],
        ];
        $equipment_stats = [
            [
                'name' => 'X-Ray Unit',
                'unit_info' => '2/2 unit digunakan',
                'avg_usage' => 60,
                'status' => 'Critical', // Badge Merah
                'availability' => 0,
                'utilization' => 60
            ],
            [
                'name' => 'Autoclave',
                'unit_info' => '5/5 unit digunakan',
                'avg_usage' => 52,
                'status' => 'High', // Badge Hijau Tua
                'availability' => 0,
                'utilization' => 52
            ],
            [
                'name' => 'Handpiece',
                'unit_info' => '18/20 unit digunakan',
                'avg_usage' => 45,
                'status' => 'High', // Badge Hijau Tua
                'availability' => 10,
                'utilization' => 45
            ],
        ];
        $participation_summary = [
            [
                'title' => 'Avg Attendance',
                'value' => '94%',
                'desc' => 'Across all classes'
            ],
            [
                'title' => 'Avg Completion',
                'value' => '96%',
                'desc' => 'Task completion rate'
            ],
            [
                'title' => 'Active Students',
                'value' => '81',
                'desc' => 'This semester'
            ]
        ];

        $class_participation = [
            [
                'name' => 'Kelas A - Endodontik',
                'attended' => 23,
                'total' => 24,
                'completion' => 96,
            ],
            [
                'name' => 'Kelas B - Periodonsia',
                'attended' => 20,
                'total' => 22,
                'completion' => 91,
            ],
            [
                'name' => 'Kelas C - Konservasi',
                'attended' => 19,
                'total' => 20,
                'completion' => 95,
            ],
            [
                'name' => 'Workshop Radiologi',
                'attended' => 15,
                'total' => 15,
                'completion' => 100,
            ],
        ];
        $maintenance_metrics = [
            [
                'title' => 'Overall Compliance',
                'subtitle' => 'PM & Calibration',
                'value' => '90%'
            ],
            [
                'title' => 'Avg Response Time',
                'subtitle' => 'For corrective actions',
                'value' => '4.2h'
            ],
            [
                'title' => 'Equipment Uptime',
                'subtitle' => 'Overall availability',
                'value' => '96.5%'
            ],
        ];

        $upcoming_maintenance = [
            [
                'tool' => 'Autoclave EQ-003',
                'type' => 'Preventive',
                'due' => '10 Nov 2025',
            ],
            [
                'tool' => 'Ultrasonic Scaler',
                'type' => 'Calibration',
                'due' => '10 Nov 2025',
            ],
        ];

        // --- DATA TAB PEMELIHARAAN (BAGIAN BAWAH) ---
        $maintenance_compliance = [
            [
                'title' => 'Preventive Maintenance',
                'details' => '11/12 completed • 1 overdue',
                'score' => 92,
                'has_bar' => true
            ],
            [
                'title' => 'Calibration',
                'details' => '7/8 completed • 1 overdue',
                'score' => 88,
                'has_bar' => true
            ],
            [
                'title' => 'Corrective Maintenance',
                'details' => '5 total • Avg response: 4.2h',
                'score' => null, // Tidak ada skor persen di gambar
                'has_bar' => false
            ],
        ];
        $k3_summary = [
            [
                'title' => 'Zero Incident Days',
                'value' => 45,
                'unit' => 'Consecutive days',
                'has_bar' => false
            ],
            [
                'title' => 'K3 Compliance',
                'value' => '97%',
                'unit' => 'Overall compliance rate',
                'has_bar' => true,
                'bar_val' => 97
            ],
            [
                'title' => 'Waste Disposal',
                'value' => '100%',
                'unit' => 'Proper disposal rate',
                'has_bar' => true,
                'bar_val' => 100
            ]
        ];

        // --- DATA TAB K3 & LIMBAH (BAGIAN BAWAH) ---
        $k3_reports = [
            'inspections' => [
                'scheduled' => 22,
                'completed' => 22,
                'findings' => 3,
                'status' => 'Compliant'
            ],
            'incidents' => [
                'total' => 2,
                'major' => 0,
                'minor' => 2,
                'resolved' => 2
            ],
            'waste' => [
                'volume' => '145 kg',
                'b3' => '12 kg',
                'disposal' => '100%',
                'status' => 'Compliant'
            ],
            'ppe' => [
                'checkpoints' => 50,
                'compliant' => 48,
                'rate' => 96
            ]
        ];
        return view('laporan.index', compact('summary', 'lab_utilizations', 'monthly_trends',
        'top_equipment', 'equipment_health','equipment_stats','participation_summary', 'class_participation',
        'maintenance_metrics', 'upcoming_maintenance', 'maintenance_compliance',
        'k3_summary', 'k3_reports'

    ));
    }
    public function exportPdf()
    {
        // 1. KITA GUNAKAN DATA YANG SAMA DENGAN METHOD INDEX
        // (Copy-paste semua array data dari method index ke sini)
        
        $summary = [
            'total_sesi' => ['value' => 237, 'trend' => '+8%', 'desc' => 'dari periode lalu'],
            'total_partisipan' => ['value' => 2695, 'trend' => '+5%', 'desc' => 'dari periode lalu'],
            'utilisasi_rata' => ['value' => '76%', 'trend' => '-2%', 'desc' => 'dari periode lalu'],
            'compliance' => ['value' => '95%', 'desc' => 'K3, GLP & ISO compliance']
        ];

        $lab_utilizations = [
            ['name' => 'Lab 1', 'percentage' => 80],
            ['name' => 'Lab 2', 'percentage' => 80],
            ['name' => 'Lab 3', 'percentage' => 73],
            ['name' => 'Lab 4', 'percentage' => 72],
        ];

        $equipment_stats = [
            ['name' => 'X-Ray Unit', 'avg_usage' => 60, 'status' => 'Critical'],
            ['name' => 'Autoclave', 'avg_usage' => 52, 'status' => 'High'],
            ['name' => 'Handpiece', 'avg_usage' => 45, 'status' => 'High'],
        ];

        $participation_summary = [
            ['title' => 'Avg Attendance', 'value' => '94%'],
            ['title' => 'Avg Completion', 'value' => '96%'],
        ];
        
        // Data K3 Summary
        $k3_summary = [
            ['title' => 'Zero Incident Days', 'value' => 45],
            ['title' => 'K3 Compliance', 'value' => '97%'],
            ['title' => 'Waste Disposal', 'value' => '100%'],
        ];

        // 2. GENERATE PDF
        // Kita load view khusus PDF (bukan view index dashboard karena CSS Tailwind tidak support penuh di PDF)
        $pdf = Pdf::loadView('laporan.pdf', compact(
            'summary', 
            'lab_utilizations', 
            'equipment_stats', 
            'participation_summary',
            'k3_summary'
        ));

        // Setup kertas (A4 Landscape agar muat banyak kolom)
        $pdf->setPaper('a4', 'landscape');

        // 3. DOWNLOAD
        return $pdf->download('Laporan-SIM-Lab-' . date('Y-m-d') . '.pdf');
    }
}