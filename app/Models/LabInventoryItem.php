<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabInventoryItem extends Model
{
    use HasFactory;

    protected $table = 'lab_inventory_items';

    protected $fillable = [
        'item_type',                 // 'alat' / 'bahan'
        'code',
        'name',
        'category',
        'location',
        'status',
        'last_calibration_date',
        'next_calibration_date',
        'unit',
        'stock',
        'min_stock',
        'batch_lot',
        'expired_at',
        'notes',
    ];

    protected $casts = [
        'last_calibration_date' => 'date',
        'next_calibration_date' => 'date',
        'expired_at'            => 'date',
    ];

    public function loanItems()
    {
        return $this->hasMany(LoanItem::class, 'lab_inventory_item_id');
    }
}
