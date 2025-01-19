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
        'room_id',
        'bedspace_no',
        'occupied_status'
    ];

    // Relationship with Hostel model
    public function hostel()
    {
        return $this->belongsTo(Hostel::class, 'hostel_id');
    }

    // Relationship with Room model
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    // Relationship with Student model (one bedspace accommodates one student)
    public function student()
    {
        return $this->hasOne(Student::class, 'bedspace_id');
    }
}
