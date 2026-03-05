<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $fillable = [
        'nama_kelas',
        'angkatan'
    ];

    public function mahasiswa()
    {
        return $this->hasMany(User::class,'kelas','nama_kelas');
    }
}