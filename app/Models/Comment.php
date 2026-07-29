<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Comment extends Model { protected $guarded = []; public function teacher() { return $this->belongsTo(Teacher::class); } public function project() { return $this->belongsTo(Project::class); } }
