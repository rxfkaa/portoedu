<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioSetting extends Model
{
    protected $fillable = [
        'student_id',
        'theme',
        'is_public',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
