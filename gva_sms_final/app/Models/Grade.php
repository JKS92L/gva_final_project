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

    // Relationship with GradeTeacher
    public function teachers()
    {
        return $this->hasMany(GradeTeacher::class);
    }
}
