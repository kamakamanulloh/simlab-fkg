<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class QualityController extends Controller
{
    public function index()
    {
        // 1. Data Summary Cards (Bagian Atas)
        $summary = [
            'compliance' => [
                'value' => 92,
                'trend' => '+3%',
                'trend_desc' => 'from last quarter'
            ],
            'active_capa' => [
                'count' => 1,
                'desc' => '1 completed this month'
            ],
            'upcoming_audits' => [
                'count' => 2,
                'next' => 'Next: 2025-11-15'
            ],
            'audit_score' => [
                'score' => 92,
                'last_audit' => 'Latest audit (Oct 2025)'
            ]
        ];

        // 2. Data Standar Mutu (Isi Tab Compliance)
        $standards = [
            [
                'code' => 'ISO 15189:2022',
                'name' => 'Lab Medis',
                'score' => 88,
                'target' => 90,
                'status' => 'On Track'
            ],
            [
                'code' => 'ISO/IEC 17025:2017',
                'name' => 'Kompetensi Lab Pengujian',
                'score' => 92,
                'target' => 90,
                'status' => 'On Track'
            ],
            [
                'code' => 'Permenkes No. 411/2010',
                'name' => 'Laboratorium Klinik',
                'score' => 96,
                'target' => 100,
                'status' => 'On Track'
            ]
        ];
        $certifications = [
            [
                'name' => 'ISO 15189:2022',
                'desc' => 'Valid until: 2026-06-30',
                'status' => 'Valid',
                'color' => 'green' // Indikator warna
            ],
            [
                'name' => 'ISO/IEC 17025:2017',
                'desc' => 'Valid until: 2026-08-15',
                'status' => 'Valid',
                'color' => 'green'
            ],
            [
                'name' => 'GLP Certificate',
                'desc' => 'Renew due: 2025-12-20',
                'status' => 'Renew Soon',
                'color' => 'orange'
            ]
        ];

        $compliance_gaps = [
            [
                'title' => 'ISO 15189: Equipment calibration',
                'desc' => '2 equipment pending calibration'
            ],
            [
                'title' => 'SPMI: Training documentation',
                'desc' => '3 staff need updated certificates'
            ]
        ];
        $audit_schedule = [
            [
                'id' => 'AUD-2025-11',
                'date' => '2025-11-15',
                'type' => 'Internal Audit',
                'scope' => 'K3 & Limbah',
                'auditor' => 'Tim SPMI',
                'status' => 'Scheduled',
                'status_class' => 'bg-blue-50 text-blue-600 border-blue-100'
            ],
            [
                'id' => 'AUD-2025-12',
                'date' => '2025-12-10',
                'type' => 'ISO 15189',
                'scope' => 'Quality Management System',
                'auditor' => 'External Auditor',
                'status' => 'Planned',
                'status_class' => 'bg-blue-50 text-blue-600 border-blue-100'
            ],
        ];

        // --- DATA TAB AUDITS (BAGIAN BAWAH) ---
        $completed_audits = [
            [
                'title' => 'GLP Compliance',
                'id_range' => 'AUD-2025-10 • 2025-10-20',
                'score' => 92,
                'status' => 'Closed',
                'findings' => [
                    'major' => 0,
                    'minor' => 2,
                    'observations' => 5
                ]
            ]
        ];
        $capa_list = [
            [
                'id' => 'CAPA-002',
                'incident' => 'INC-003 - Alarm kebakaran palsu',
                'root_cause' => 'Sensor terlalu sensitif, perlu kalibrasi',
                'corrective' => 'Kalibrasi sistem alarm, update SOP',
                'preventive' => 'Pelatihan staf, inspeksi rutin',
                'responsible' => 'Budi Hartono',
                'due_date' => '2025-11-15',
                'progress' => 50,
                'status' => 'In Progress',
                'can_update' => true // Menampilkan tombol update
            ],
            [
                'id' => 'CAPA-001',
                'incident' => 'INC-001 - Tumpahan bahan kimia',
                'root_cause' => 'Penyimpanan tidak sesuai SOP',
                'corrective' => 'Reorganisasi area penyimpanan',
                'preventive' => 'Update SOP, training ulang',
                'responsible' => 'Budi Hartono',
                'due_date' => '2025-11-10',
                'progress' => 100,
                'status' => 'Completed',
                'can_update' => false
            ],
        ];
        $quality_indicators = [
            [
                'name' => 'Equipment Calibration Compliance',
                'current' => '96%',
                'target' => '95%',
                'performance' => 'On Target',
                'trend' => 'Up',
                'trend_class' => 'text-emerald-600' // Hijau
            ],
            [
                'name' => 'Incident Response Time (hours)',
                'current' => '4.2',
                'target' => '6',
                'performance' => 'On Target',
                'trend' => 'Up',
                'trend_class' => 'text-emerald-600'
            ],
            [
                'name' => 'Document Control Compliance',
                'current' => '98%',
                'target' => '95%',
                'performance' => 'On Target',
                'trend' => 'Stable',
                'trend_class' => 'text-slate-500' // Abu-abu
            ],
            [
                'name' => 'Training Completion Rate',
                'current' => '92%',
                'target' => '90%',
                'performance' => 'On Target',
                'trend' => 'Up',
                'trend_class' => 'text-emerald-600'
            ],
            [
                'name' => 'Audit Finding Closure Rate',
                'current' => '95%',
                'target' => '90%',
                'performance' => 'On Target',
                'trend' => 'Stable',
                'trend_class' => 'text-slate-500'
            ],
        ];
    $documentsFromDB = DB::table('quality_documents')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                // Mapping agar formatnya sama dengan array view Anda
                // Tentukan warna badge berdasarkan status
                $statusClass = match ($item->status) {
                    'Current' => 'bg-emerald-100 text-emerald-700', // Hijau
                    'Review Needed' => 'bg-amber-50 text-amber-700 border border-amber-200', // Kuning
                    'Draft' => 'bg-gray-100 text-gray-700', // Abu-abu
                    default => 'bg-blue-50 text-blue-700',
                };

                return [
                    'id' => $item->doc_id,
                    'title' => $item->title,
                    'version' => $item->version,
                    'last_update' => \Carbon\Carbon::parse($item->last_update)->format('Y-m-d'),
                    'status' => $item->status,
                    'status_class' => $statusClass,
                    'file_path' => $item->file_path // Opsional jika butuh link download
                ];
            });

        // Jika tabel kosong, bisa pakai data dummy sebagai fallback (Opsional)
        // Atau jika ingin menggabungkan:
        // $documents = $documentsFromDB->isEmpty() ? collect($dummyDocuments) : $documentsFromDB;
        
        // SAYA SARANKAN PAKAI DATA DB SAJA (agar data upload langsung muncul)
        $documents = $documentsFromDB; 

        return view('quality.index', compact(
            'summary', 'standards', 'certifications', 'compliance_gaps', 
            'audit_schedule', 'completed_audits', 'capa_list', 
            'quality_indicators', 'documents' // Kirim data documents dari DB
        ));
    }
    public function storeDocument(Request $request)
{
    // Validasi
    $request->validate([
        'title' => 'required|string|max:255',
        'version' => 'required|string|max:20',
        'file' => 'required|file|mimes:pdf,doc,docx|max:10240', // Max 10MB
    ]);

    try {
        // Upload File
        $path = $request->file('file')->store('quality_docs', 'public');

        // Generate ID Dummy (DOC-XXX)
        $lastId = \DB::table('quality_documents')->max('id') ?? 0;
        $docId = 'DOC-' . str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);

        // Simpan ke DB
        // Gunakan DB Facade atau Model
        \DB::table('quality_documents')->insert([
            'doc_id' => $docId,
            'title' => $request->title,
            'version' => $request->version,
            'category' => $request->category,
            'last_update' => now(),
            'status' => $request->status,
            'file_path' => $path,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Success'], 200);

    } catch (\Exception $e) {
        return response()->json(['message' => $e->getMessage()], 500);
    }
}
public function viewDocument($id)
{
    // Cari dokumen berdasarkan doc_id atau id tabel
    $doc = \DB::table('quality_documents')->where('doc_id', $id)->first();

    if (!$doc || !Storage::disk('public')->exists($doc->file_path)) {
        abort(404, 'File not found');
    }

    // Return file untuk dilihat di browser (inline)
    return response()->file(storage_path('app/public/' . $doc->file_path));
}

public function downloadDocument($id)
{
    $doc = \DB::table('quality_documents')->where('doc_id', $id)->first();

    if (!$doc || !Storage::disk('public')->exists($doc->file_path)) {
        abort(404, 'File not found');
    }

    // Force download
    return Storage::disk('public')->download($doc->file_path, $doc->title . '.' . pathinfo($doc->file_path, PATHINFO_EXTENSION));
}
}