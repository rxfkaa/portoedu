<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Achievement extends Model {
    protected $guarded = []; protected $casts = ['date' => 'date', 'verified_at' => 'datetime'];
    public function student() { return $this->belongsTo(Student::class); }
    public function verifier() { return $this->belongsTo(Teacher::class, 'verified_by'); }
}
