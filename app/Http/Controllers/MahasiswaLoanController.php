<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\LoanItem;
use App\Models\LabInventoryItem;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\LoanReturn;

class MahasiswaLoanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'purpose' => 'required|string|max:255',
            'lab_inventory_item_id' => 'required|exists:lab_inventory_items,id',
            'qty' => 'required|integer|min:1',
            'duration' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();

        try {

            $item = LabInventoryItem::findOrFail($request->lab_inventory_item_id);

            if ($item->stock < $request->qty) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Stok tidak mencukupi.'
                ], 422);
            }

            $start = Carbon::now();
            $due = Carbon::now()->addHours($request->duration);

            $loanCode = 'LN-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(3));

            $loan = Loan::create([
                'loan_code' => $loanCode,
                'borrower_id' => auth()->id(),
                'borrower_name' => auth()->user()->name,
                'borrower_nip' => auth()->user()->username ?? auth()->user()->nim,
                'purpose' => $request->purpose,
                'start_at' => $start,
                'due_at' => $due,
                'status' => 'Dipinjam',
                'qr_result' => null,
                'condition_photo_path' => null,
            ]);

            LoanItem::create([
                'loan_id' => $loan->id,
                'lab_inventory_item_id' => $item->id,
                'qty' => $request->qty,
            ]);

            // Kurangi stok
            $item->decrement('stock', $request->qty);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Peminjaman berhasil diajukan.',
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan.'
            ], 500);
        }
    }
    public function list()
{
    $loans = \App\Models\Loan::with('items.inventoryItem')
        ->where('borrower_id', auth()->id())
        ->latest()
        ->get();

    return view('mahasiswa.partials.peminjaman-list', compact('loans'));
}
public function returnLoan(Request $request)
{
    $request->validate([
        'loan_id' => 'required|exists:loans,id',
        'loan_item_id' => 'required|exists:loan_items,id',
        'condition' => 'required|string',
        'note' => 'nullable|string',
        'photo' => 'nullable|image|max:2048'
    ]);

    DB::beginTransaction();

    try {

        $loan = Loan::findOrFail($request->loan_id);

        // Upload Foto jika ada
        $photoPath = null;

        if ($request->hasFile('photo')) {

            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();

            $file->storeAs('public/loan_photos', $filename);

            $photoPath = 'loan_photos/' . $filename;
        }

        // Insert ke loan_returns
        LoanReturn::create([
            'loan_id' => $loan->id,
            'loan_item_id' => $request->loan_item_id,
            'returned_at' => now(),
            'condition' => $request->condition,
            'note' => $request->note,
        ]);

        // Update loan
        $loan->update([
            'status' => 'Dikembalikan',
            'condition_photo_path' => $photoPath
        ]);

        DB::commit();

        return response()->json([
            'status' => 'success',
            'message' => 'Pengembalian berhasil diselesaikan.'
        ]);

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'status' => 'error',
            'message' => 'Terjadi kesalahan.'
        ], 500);
    }
}
public function detailPengembalian($loanId)
{
    $loan = Loan::with(['items.inventoryItem'])
                ->where('id', $loanId)
                ->where('borrower_id', auth()->id())
                ->firstOrFail();

    $return = LoanReturn::where('loan_id', $loan->id)->first();

    if (!$return) {
        return response()->json([
            'message' => 'Data pengembalian tidak ditemukan'
        ], 404);
    }

    return response()->json([
        'condition'   => $return->condition,
        'note'        => $return->note,
        'returned_at' => $return->returned_at->format('Y-m-d H:i'),
        'photo'       => $loan->condition_photo_path
    ]);
}
}