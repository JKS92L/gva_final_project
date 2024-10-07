<?php

namespace App\Models;

use App\Models\GradeTeacher;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'gradeno',
        'class_name',
        'level',
        'capacity',
        'status'
    ];

    // Relationship with teacher
    public function teachers()
    {
        return $this->hasMany(GradeTeacher::class);
    }

    //the grade can have many students
    public function students()
    {
        return $this->hasMany(Student::class, 'class_id'); // The 'class_id' is the foreign key in the students table.
    }

}
