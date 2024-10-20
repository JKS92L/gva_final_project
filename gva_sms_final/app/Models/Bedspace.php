<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bedspace extends Model
{
    use HasFactory;

    protected $table = 'bedspaces';

    protected $fillable = [
        'hostel_id',
        'bedspace_no',
    ];

    // Relationship with Hostel model
    public function hostel()
    {
        return $this->belongsTo(Hostel::class, 'hostel_id', 'id');
    }
    // public function students() // one bedspace can only accommodate one student
    public function student()
    {
        return $this->hasOne(Student::class, 'bedspace_id');
    }

}
