<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'class_id',
        'nis',
        'nisn',
        'name',
        'birth_place',
        'birth_date',
        'gender',
        'address',
        'phone',
        'photo',
        'bio',
        'github',
        'linkedin',
        'website',
        'instagram',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classRoom()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function achievements()
    {
        return $this->hasMany(Achievement::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function organizations()
    {
        return $this->hasMany(Organization::class);
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    public function internships()
    {
        return $this->hasMany(Internship::class);
    }

    public function portfolioSetting()
    {
        return $this->hasOne(PortfolioSetting::class);
    }

    public function socialLinks()
    {
        return $this->hasMany(SocialLink::class);
    }
}
