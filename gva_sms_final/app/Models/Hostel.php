<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hostel extends Model
{
    use HasFactory;

    // Define the table name if it doesn't follow the plural convention
    protected $table = 'hostels';

   

    // Allow mass assignment for these fields
    protected $fillable = [
        'hostel_name',
        'hostel_name',
        'total_rooms',
        'total_bedspaces',
        'hostel_teacher_id',
        'status',
        'hostel_gender',
    ];

    // Constants for the hostel status
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    // Relationship with the Teacher model
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'hostel_teacher_id');
    }



    // A hostel can have many students
    public function students()
    {
        return $this->hasMany(Student::class, 'hostel_id');
    }

    // Relationship with the Bedspace model
    public function bedspaces()
    {
        return $this->hasMany(Bedspace::class, 'hostel_id', 'id');
    }

    // Scope to filter active hostels
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    // Get the gender attribute in a readable format
    public function getGenderAttribute()
    {
        return ucfirst($this->hostel_gender); // Returns "Male" or "Female"
    }
}
