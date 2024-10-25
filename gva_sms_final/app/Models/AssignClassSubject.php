<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignClassSubject extends Model
{
    use HasFactory;
    protected  $table = 'class_subjects';

    protected $fillable = [
        'academic_session_id',
        'class_id',
        'subject_id '
    ];

    public function grades()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    public function subjects()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function academicSession()
    {
        return $this->hasMany(AcademicSession::class, 'academic_session_id');
    }
    public function assignedTeachers()
    {
        return $this->hasMany(ClassSubjectTeacher::class, 'class_id', 'grade_id')
            ->where('session_id', session('current_academic_session_id')); // Ensure it matches current session
    }
}
