<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insiden extends Model
{
   protected $fillable = [
    'id_insiden',
    'tgl_kejadian',
    'tgl_pelaporan',
    'unit',
    'lokasi',
    'jenis_insiden',
    'nama_pelapor',
    'jabatan',
    'kontak',
    'status_pelapor',
    'judul',
    'deskripsi',
    'jenis_dampak',
    'tingkat_keparahan',
    'kategori_ncr',
    'dokumen_pendukung',
];
protected $casts = [
    'bukti' => 'array',
];

}
