<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CostAnalysis extends Model
{
    protected $fillable = [
        'jenis_tindakan',
        'detail_perbaikan',
        'biaya',
        'status_pengerjaan'
    ];
}