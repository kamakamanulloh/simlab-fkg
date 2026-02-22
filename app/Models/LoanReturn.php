<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanReturn extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_item_id',
        'returned_at',
        'condition',
        'note',
    ];

    protected $casts = [
        'returned_at' => 'datetime',
    ];

    public function loanItem()
    {
        return $this->belongsTo(LoanItem::class);
    }
}
