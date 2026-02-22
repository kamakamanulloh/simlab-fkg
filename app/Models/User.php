<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Auto hash password
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    // ======================
    // ROLE CHECKER (BENAR!)
    // ======================

    public function isAdmin()
    {
        return $this->role === 'Admin';
    }

    public function isKoordinator()
    {
        return $this->role === 'Koordinator Praktikum';
    }

    public function isKepalaLab()
    {
        return $this->role === 'Kepala Lab';
    }

    public function isTeknisi()
    {
        return $this->role === 'Teknisi';
    }

    public function isDosen()
    {
        return $this->role === 'Dosen';
    }

    public function isMahasiswa()
    {
        return $this->role === 'Mahasiswa';
    }

    public function isTimMutu()
    {
        return $this->role === 'Tim Mutu';
    }
}
