<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'student_id',
        'name',
        'level',
        'icon'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_skill');
    }
}
