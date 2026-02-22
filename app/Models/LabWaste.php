<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabWaste extends Model
{
    use HasFactory;
    protected $fillable = [
        'jenis_limbah',
        'kategori',
        'lokasi',
        'status',
        'berat',
        'kondisi_wadah',
        'volume_wadah',
        'apd',
        'keterangan',
        'status_verifikasi',
        'alur_pembuangan',
    ];
}
