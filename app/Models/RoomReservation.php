<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomReservation extends Model
{
    protected $fillable = [
        'user_id',
        'tujuan',
        'tanggal',
        'waktu',
        'jumlah_peserta',
        'status'
    ];
}