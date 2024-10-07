<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentParent extends Model
{
    protected $table = 'parents'; // The table name is "students"
    protected $fillable = [
        'father_name',
        'mother_name',
        'father_phone',
        'mother_phone',
        'father_email',
        'mother_email',
        'father_address',
        'mother_address',
        'student_ids', // This will be updated as needed, initially empty
    ];


    // Relationship to children (students)
    public function students()
    {
        return $this->hasMany(Student::class, 'parent_id');
    }
    

}
