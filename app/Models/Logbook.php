<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    protected $fillable = [
        'student_id',
        'session_name',
        'session_code',
        'session_date',
        'activity',
        'competencies',
        'documentation',
        'status',
        'score'
    ];

    protected $casts = [
        'competencies' => 'array',
        'session_date' => 'date'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
    public function schedule()
{
    return $this->belongsTo(\App\Models\LabSchedule::class, 'session_name');
}
}