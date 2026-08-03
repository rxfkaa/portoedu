<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'student_id',
        'title',
        'description',
        'image',
        'photo',
        'caption',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}

