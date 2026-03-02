<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserDosen extends Model
{
    use HasFactory;

    protected $table = 'users_dosen';

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role_id',
        'blok',
        'departemen',
        'thumb_avatar',
        'remember_token',
        'remember_expires_at',
        'old',
        'kordinator',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'remember_expires_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    public function schedules()
    {
        return $this->hasMany(LabSchedule::class, 'instruktur_id');
    }
    public function setPasswordAttribute($value)
{
    if (!empty($value)) {
        $this->attributes['password'] = bcrypt($value);
    }
}
}