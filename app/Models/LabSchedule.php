<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabSchedule extends Model
{
    use HasFactory;

    protected $table = 'lab_schedules';

    protected $fillable = [
        'judul',
        'jenis',
        'ruangan',
        'tanggal',
        'waktu',
        'instruktur_id',
        'jumlah_peserta',
        'catatan',
        'status',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function instruktur()
    {
        return $this->belongsTo(UserDosen::class, 'instruktur_id');
    }
}
