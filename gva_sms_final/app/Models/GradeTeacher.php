<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradeTeacher extends Model
{
    protected $fillable = [
        'user_id',
        'grade_id',
        'academic_year',
        'date_assigned',
        'remarks',
        'active'
    ];

    // Relationship with Grade
    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
