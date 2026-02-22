<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'lab_inventory_item_id',
        'qty',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function inventoryItem()
    {
        return $this->belongsTo(LabInventoryItem::class, 'lab_inventory_item_id');
    }

    public function returns()
    {
        return $this->hasMany(LoanReturn::class);
    }
}
