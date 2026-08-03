<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'student_id',
        'name',
        'organization_name',
        'position',
        'start_date',
        'end_date',
        'started_at',
        'ended_at',
        'description',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'started_at' => 'date',
        'ended_at' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}

