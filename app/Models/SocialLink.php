<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    protected $fillable = [
        'student_id',
        'platform',
        'url',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
