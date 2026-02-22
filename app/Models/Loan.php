<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Loan extends Model
{
    use HasFactory;

   // app/Models/Loan.php
protected $fillable = [
    'loan_code',
    'borrower_id',
    'borrower_name',
    'borrower_nip',
    'purpose',
    'start_at',
    'due_at',
    'status',
    'qr_result',
    'condition_photo_path',
];


    protected $casts = [
        'start_at'   => 'datetime',
        'due_at'     => 'datetime',
        'returned_at'=> 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(LoanItem::class);
    }

    // Helper status: terlambat atau tidak
    public function getIsLateAttribute(): bool
    {
        return $this->status === 'Dipinjam'
            && $this->due_at
            && $this->due_at->isPast();
    }
}
