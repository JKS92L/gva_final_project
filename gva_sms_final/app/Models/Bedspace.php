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
        return $this->belongsTo(Hostel::class, 'hostel_id');
    }
}
