<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    protected $fillable = [
        'student_id',
        'company',
        'position',
        'address',
        'started_at',
        'ended_at',
        'description',
        'logo'
    ];

    protected $casts = [
        'started_at' => 'date',
        'ended_at' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
