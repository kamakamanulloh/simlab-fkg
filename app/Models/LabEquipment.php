<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabEquipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'category',
        'location',
        'status',
        'last_calibration_date',
        'next_calibration_date',
        'notes',
    ];
}
