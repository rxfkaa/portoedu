<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Student extends Model {
    protected $guarded = [];
    public function user() { return $this->belongsTo(User::class); }
    public function classRoom() { return $this->belongsTo(SchoolClass::class, 'class_id'); }
    public function achievements() { return $this->hasMany(Achievement::class); }
    public function certificates() { return $this->hasMany(Certificate::class); }
    public function projects() { return $this->hasMany(Project::class); }
}
