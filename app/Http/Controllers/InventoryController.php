<?php

namespace App\Http\Controllers;

use App\Models\LabInventoryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;


class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'alat'); // 'alat' = peralatan, 'bahan' = bahan habis pakai
        $q   = $request->query('q');

        // ==============================
        // STAT KARTU ATAS
        // ==============================
        $totalAlat   = LabInventoryItem::where('item_type', 'peralatan')->count();
        $alatAktif   = LabInventoryItem::where('item_type', 'peralatan')
                        ->where('status', 'Aktif')
                        ->count();

        $totalBahan      = LabInventoryItem::where('item_type', 'bahan')->count();
        $bahanStokRendah = LabInventoryItem::where('item_type', 'bahan')
                            ->whereColumn('stock', '<=', 'min_stock')
                            ->count();

        $hariIni     = Carbon::today();
        $tigaPuluhHr = Carbon::today()->addDays(30);

        $mendekatiKedaluwarsa = LabInventoryItem::where('item_type', 'bahan')
            ->whereBetween('expired_at', [$hariIni, $tigaPuluhHr])
            ->count();

        $awalBulanIni  = Carbon::now()->startOfMonth();
        $akhirBulanIni = Carbon::now()->endOfMonth();

        $perluKalibrasi = LabInventoryItem::where('item_type', 'peralatan')
            ->whereBetween('next_calibration_date', [$awalBulanIni, $akhirBulanIni])
            ->count();

        // ==============================
        // LIST PERALATAN & BAHAN (TAB)
        // ==============================

        $equipmentQuery = LabInventoryItem::where('item_type', 'peralatan');
        $consumableQuery = LabInventoryItem::where('item_type', 'bahan');

        if ($q) {
            $equipmentQuery->where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                    ->orWhere('code', 'like', "%{$q}%")
                    ->orWhere('category', 'like', "%{$q}%")
                    ->orWhere('location', 'like', "%{$q}%");
            });

            $consumableQuery->where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                    ->orWhere('code', 'like', "%{$q}%")
                    ->orWhere('category', 'like', "%{$q}%")
                    ->orWhere('batch_lot', 'like', "%{$q}%");
            });
        }

        $equipments = $tab === 'alat'
            ? $equipmentQuery->orderBy('name')->paginate(10)->withQueryString()
            : null;

        $consumables = $tab === 'bahan'
            ? $consumableQuery->orderBy('name')->paginate(10)->withQueryString()
            : null;

        return view('inventory.index', compact(
            'tab',
            'q',
            'totalAlat',
            'alatAktif',
            'totalBahan',
            'bahanStokRendah',
            'mendekatiKedaluwarsa',
            'perluKalibrasi',
            'equipments',
            'consumables'
        ));
    }
    public function store(Request $request)
    {
        $type = $request->input('item_type');

        // aturan dasar
        $rules = [
            'item_type' => ['required', Rule::in(['peralatan', 'bahan'])],
            'code'      => ['required', 'string', 'max:50', 'unique:lab_inventory_items,code'],
            'name'      => ['required', 'string', 'max:255'],
            'category'  => ['nullable', 'string', 'max:100'],
            'location'  => ['nullable', 'string', 'max:100'],
        ];

        if ($type === 'peralatan') {
            $rules = array_merge($rules, [
                'status'                => ['required', 'string', 'max:50'],
                'last_calibration_date' => ['nullable', 'date'],
                'next_calibration_date' => ['nullable', 'date', 'after_or_equal:last_calibration_date'],
            ]);
        } elseif ($type === 'bahan') {
            $rules = array_merge($rules, [
                'unit'       => ['nullable', 'string', 'max:50'],
                'stock'      => ['required', 'integer', 'min:0'],
                'min_stock'  => ['required', 'integer', 'min:0'],
                'batch_lot'  => ['nullable', 'string', 'max:100'],
                'expired_at' => ['nullable', 'date'],
            ]);
        }

        $data = $request->validate($rules);

        LabInventoryItem::create($data);

        return response()->json([
            'status'  => 'ok',
            'message' => 'Item inventori berhasil disimpan.',
        ]);
    }
    public function exportPdf(Request $request)
    {
        // kalau mau ikut keyword di halaman, bisa ambil dari ?q=
        $search = $request->input('q');

        $equipmentsQuery = LabInventoryItem::where('item_type', 'peralatan');
        $consumablesQuery = LabInventoryItem::where('item_type', 'bahan');

        if ($search) {
            $equipmentsQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });

            $consumablesQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // ambil semua (tanpa paginate)
        $equipments  = $equipmentsQuery->orderBy('name')->get();
        $consumables = $consumablesQuery->orderBy('name')->get();

        $tanggalCetak = now()->format('d-m-Y H:i');

        $pdf = Pdf::loadView('inventory.export_pdf', compact(
            'equipments',
            'consumables',
            'tanggalCetak'
        ))->setPaper('a4', 'portrait');

        $filename = 'inventori_lab_'.now()->format('Ymd_His').'.pdf';

        // bisa pakai download() atau stream()
        return $pdf->download($filename);
        // return $pdf->stream($filename);
    }
    public function downloadTemplate(string $type)
{
    abort_unless(in_array($type, ['peralatan', 'bahan']), 404);

    $export = new class($type) implements FromArray, WithHeadings {
        protected string $type;

        public function __construct(string $type)
        {
            $this->type = $type;
        }

        public function headings(): array
        {
            if ($this->type === 'peralatan') {
                // HARUS sama urutan dengan mapping importExcel()
                return [
                    'item_type',             // A
                    'code',                  // B
                    'name',                  // C
                    'category',              // D
                    'location',              // E
                    'status',                // F
                    'last_calibration_date', // G
                    'next_calibration_date', // H
                ];
            }

            // bahan habis pakai
            return [
                'item_type',   // A
                'code',        // B
                'name',        // C
                'category',    // D
                'unit',        // E
                'stock',       // F
                'min_stock',   // G
                'batch_lot',   // H
                'expired_at',  // I
                'location',    // J
            ];
        }

        public function array(): array
        {
            if ($this->type === 'peralatan') {
                return [
                    [
                        'peralatan',          // item_type
                        'EQ-001',             // code
                        'Dental Chair Unit',  // name
                        'Furniture',          // category
                        'Lab 1',              // location
                        'Aktif',              // status
                        '2025-09-15',         // last_calibration_date
                        '2026-03-15',         // next_calibration_date
                    ],
                ];
            }

            // contoh data bahan
            return [
                [
                    'bahan',                // item_type
                    'SP-001',               // code
                    'Gloves Nitrile (L)',   // name
                    'PPE',                  // category
                    'box',                  // unit
                    450,                    // stock
                    100,                    // min_stock
                    'B2024-08',             // batch_lot
                    '2026-08-15',           // expired_at
                    'Storage A',            // location
                ],
            ];
        }
    };

    $filename = "template_{$type}_inventori_" . now()->format('Ymd_His') . '.xlsx';

    return Excel::download($export, $filename);
}

    /**
     * Import data inventori dari file CSV/Excel sederhana.
     * (Versi basic, baca CSV; nanti bisa ditingkatkan ke maatwebsite/excel).
     */
public function importExcel(Request $request)
{
    $request->validate([
        'item_type_import' => 'required|in:peralatan,bahan',
        'file_import'      => 'required|file|mimes:xlsx,xls',
    ]);

    $type = $request->input('item_type_import');
    $file = $request->file('file_import');

    $collection = Excel::toCollection(null, $file)->first(); // sheet pertama

    if (!$collection || $collection->count() <= 1) {
        return response()->json([
            'status'  => 'error',
            'message' => 'File kosong atau format tidak sesuai. Pastikan menggunakan template yang disediakan.',
        ], 422);
    }

    // Lewati baris header (index 0)
    $rowsProcessed = 0;

    foreach ($collection->skip(1) as $row) {
        // pastikan row minimal ada kolom code & name
        $code = $row[1] ?? null;
        $name = $row[2] ?? null;

        if (!$code && !$name) {
            continue; // baris kosong, skip
        }

        if ($type === 'peralatan') {
            // [A] item_type, [B] code, [C] name, [D] category, [E] location, [F] status, [G] last_cal, [H] next_cal
            LabInventoryItem::updateOrCreate(
                ['code' => $code],
                [
                    'item_type'             => 'peralatan',
                    'code'                  => $code,
                    'name'                  => $name,
                    'category'              => $row[3] ?? null,
                    'location'              => $row[4] ?? null,
                    'status'                => $row[5] ?? null,
                    'last_calibration_date' => $row[6] ?? null,
                    'next_calibration_date' => $row[7] ?? null,
                ]
            );
        } else {
            // [A] item_type, [B] code, [C] name, [D] category, [E] unit, [F] stock, [G] min_stock, [H] batch_lot, [I] expired_at, [J] location
            LabInventoryItem::updateOrCreate(
                ['code' => $code],
                [
                    'item_type'  => 'bahan',
                    'code'       => $code,
                    'name'       => $name,
                    'category'   => $row[3] ?? null,
                    'unit'       => $row[4] ?? null,
                    'stock'      => (int)($row[5] ?? 0),
                    'min_stock'  => (int)($row[6] ?? 0),
                    'batch_lot'  => $row[7] ?? null,
                    'expired_at' => $row[8] ?? null,
                    'location'   => $row[9] ?? null,
                ]
            );
        }

        $rowsProcessed++;
    }

    return response()->json([
        'status'  => 'ok',
        'message' => "Import berhasil, {$rowsProcessed} baris diproses.",
    ]);
}

}
