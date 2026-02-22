<?php
namespace App\Http\Controllers;
use App\Models\Loan;
use App\Models\LoanItem;
use App\Models\LabInventoryItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class LoanController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // --- STATISTIK ---
        $stats = [
            'aktif'          => Loan::where('status', 'Dipinjam')->count(),
            'terlambat'      => Loan::where('status', 'Dipinjam')->where('due_at', '<', $today)->count(),
            'dikembalikan'   => Loan::whereDate('returned_at', $today)->count(),
            'tanggal_return' => $today->translatedFormat('j F Y'),
            'mendekati_due'  => Loan::where('status', 'Dipinjam')
                                    ->whereBetween('due_at', [$today, $today->copy()->addHours(4)])
                                    ->count(),
            'deadline_info'  => 'Dalam 4 jam ke depan',
        ];

        // --- LIST PEMINJAMAN (misal 10 terakhir) ---
        $loanRows = Loan::with(['items.inventoryItem'])
            ->latest('start_at')
            ->take(10)
            ->get();

        $loans = $loanRows->map(function (Loan $loan) {
            return [
                'id'           => $loan->loan_code,
                'borrower'     => $loan->borrower_name,
                'borrower_nim' => $loan->borrower_id,
                'purpose'      => $loan->purpose,
                'start_at'     => optional($loan->start_at)->format('Y-m-d H:i'),
                'due_at'       => optional($loan->due_at)->format('Y-m-d H:i'),
                'status'       => $loan->status === 'Dipinjam' && $loan->isLate ? 'Terlambat' : $loan->status,
                'items'        => $loan->items->map(function (LoanItem $li) {
                    return [
                        'name' => optional($li->inventoryItem)->name ?? '-',
                        'qty'  => $li->qty,
                    ];
                })->toArray(),
            ];
        })->toArray();

        $totalLoans = Loan::count();

        // --- ALAT TERSEDIA UNTUK DIPINJAM ---
        $availableEquipments = LabInventoryItem::where('item_type', 'peralatan')
            ->where('stock', '>', 0)
            ->orderBy('name')
            ->take(10)
            ->get(['id', 'code', 'name', 'stock'])
            ->map(function (LabInventoryItem $item) {
                return [
                    'id'    => $item->id,
                    'code'  => $item->code,
                    'name'  => $item->name,
                    'stock' => $item->stock,
                ];
            })->toArray();

        return view('peminjaman.index', compact(
            'stats',
            'loans',
            'totalLoans',
            'availableEquipments'
        ));
    }
public function store(Request $request)
{
    $data = $request->validate([
        'borrower_id'       => ['required','integer','exists:users,id'],
        'borrower_nip'      => ['nullable','string','max:50'],
        'purpose'           => ['required', 'string', 'max:255'],
        'start_at'          => ['required', 'date'],
        'due_at'            => ['required', 'date', 'after_or_equal:start_at'],
        'items'             => ['required', 'array'],
        'items.*'           => ['nullable', 'integer', 'min:0'],
        'qr_result'         => ['nullable','string'],
        'condition_photo'   => ['nullable','image','max:5120'], // max 5MB
    ]);

    // ambil hanya alat yang qty > 0
    $items = collect($data['items'])->filter(fn($qty) => $qty > 0);

    if ($items->isEmpty()) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Pilih minimal 1 alat yang akan dipinjam.',
        ], 422);
    }
$borrower = User::find($data['borrower_id']);

if (!$borrower) {
    return response()->json([
        'status' => 'error',
        'message' => 'Peminjam tidak ditemukan.'
    ], 422);
}

    DB::beginTransaction();
    try {
        // Buat loan (simpan borrower id)
        // Generate kode pinjam yang sederhana (boleh disesuaikan)
        $nextNumber = (Loan::max('id') ?? 0) + 1;
        $loanCode = 'LN-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

       $loan = Loan::create([
    'loan_code'         => $loanCode,
    'borrower_id'       => $data['borrower_id'],
    'borrower_name'     => $borrower->name,           // <- tambahkan ini
    'borrower_nip'      => $data['borrower_nip'] ?? null,
    'purpose'           => $data['purpose'],
    'start_at'          => $data['start_at'],
    'due_at'            => $data['due_at'],
    'status'            => 'Dipinjam',
    'qr_result'         => $data['qr_result'] ?? null,
]);

        // Simpan foto kondisi (jika ada)
        if ($request->hasFile('condition_photo')) {
            $path = $request->file('condition_photo')->store('loan_photos', 'public');
            $loan->condition_photo_path = $path;
            $loan->save();
        }

        // Proses items: buat loan_items dan kurangi stok
        foreach ($items as $inventoryId => $qty) {
            /** @var LabInventoryItem $inv */
            $inv = LabInventoryItem::lockForUpdate()->find($inventoryId);
            if (!$inv) {
                DB::rollBack();
                return response()->json([
                    'status' => 'error',
                    'message' => "Item dengan ID {$inventoryId} tidak ditemukan."
                ], 422);
            }

            if ($inv->stock < $qty) {
                DB::rollBack();
                return response()->json([
                    'status' => 'error',
                    'message' => "Stok {$inv->name} tidak mencukupi (tersisa: {$inv->stock})."
                ], 422);
            }

            LoanItem::create([
                'loan_id'                => $loan->id,
                'lab_inventory_item_id'  => $inv->id,
                'qty'                    => $qty,
            ]);

            $inv->decrement('stock', $qty);
        }

        DB::commit();

        return response()->json([
            'status'  => 'ok',
            'message' => 'Peminjaman berhasil dibuat.',
            'loan_id' => $loan->id,
        ]);
    } catch (\Throwable $e) {
        DB::rollBack();
        \Log::error('Loan store error: '.$e->getMessage());
        return response()->json([
            'status'  => 'error',
            'message' => 'Terjadi kesalahan saat menyimpan peminjaman.',
        ], 500);
    }
}
  public function searchBorrowers(Request $request)
    {
        $q = $request->input('q', '');

        $users = User::query()
            ->when($q, function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                      ->orWhere('nip', 'like', "%{$q}%");
            })
            ->orderBy('name')
            ->limit(20)
            ->get();

        // format untuk Select2
        $results = $users->map(function ($u) {
            return [
                'id'   => $u->id,
                'text' => "{$u->name} ({$u->nip})",
                'nip'  => $u->nip,
            ];
        });

        return response()->json(['results' => $results]);
    }
}
