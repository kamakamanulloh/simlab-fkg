<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pelatihan extends Model
{
    use HasFactory;

    protected $table = 'pelatihans';

    protected $fillable = [
        'nama_pelatihan',
        'jenis_pelatihan',
        'lokasi',
        'level',
        'kuota',
        'status_pelaksanaan',
        'hasil',
        'alat_status',
'bahan_status',
'k3_status',
'materi',
    ];

    protected $casts = [
        'kuota' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}