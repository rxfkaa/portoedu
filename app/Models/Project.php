<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'student_id',
        'title',
        'slug',
        'category',
        'description',
        'technology',
        'image',
        'thumbnail',
        'github',
        'demo',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'project_skill');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}

