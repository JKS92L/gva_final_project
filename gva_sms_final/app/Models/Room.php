<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $table = 'hostel_rooms';

    protected $fillable = [
        'hostel_id',
        'room_number'
    ];

    public function hostel()
    {
        return $this->belongsTo(Hostel::class);
    }

    // Relationship with Bedspace model
    public function bedspaces()
    {
        return $this->hasMany(Bedspace::class);
    }
}
