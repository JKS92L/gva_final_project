<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCheckInCheckOut extends Model
{
    use HasFactory;

    protected $table = 'student_checkIn_checkout'; // Table name

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id',
        'hostel_id',
        'bedspace_id',
        'room_status',
    ];

    /**
     * Define the relationship with the Student model.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Define the relationship with the Hostel model.
     */
    public function hostel()
    {
        return $this->belongsTo(Hostel::class);
    }

    /**
     * Define the relationship with the Bedspace model.
     */
    public function bedspace()
    {
        return $this->belongsTo(Bedspace::class);
    }
}
