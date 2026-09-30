<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Teacher extends Model {
    protected $fillable = ['user_id', 'nip', 'name', 'subject', 'phone', 'photo'];
    public function user() { return $this->belongsTo(User::class); }
    public function comments() { return $this->hasMany(Comment::class); }
}
