<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hostel extends Model
{
    use HasFactory;

    protected $table = 'hostels';

    protected $primaryKey = 'hostel_id';

    protected $fillable = [
        'hostel_name',
        'total_rooms',
        'total_bedspaces',
        'hostel_teacher_id',
        'status',
        'hostel_gender',
    ];

    // Relation to the Teacher model
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'hostel_teacher_id');
    }
}
