<?php

namespace App\Models;

use App\Models\GradeTeacher;
use App\Models\Student;
use App\Models\Subject;  // Import the Subject model
use App\Models\Teacher;  // Import the Teacher model
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'gradeno',
        'class_name',
        'level',
        'capacity',
        'status',
    ];

    // Relationship with teachers
    public function teachers()
    {
        return $this->hasMany(GradeTeacher::class);
    }

    // Relationship with students
    public function students()
    {
        return $this->hasMany(Student::class, 'class_id'); // 'class_id' is the foreign key in the students table.
    }
    // Relationship with subjects
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'class_subjects')
            ->withPivot('academic_session_id', 'subject_id')
            ->withTimestamps();
    }

    // New relationship for subjects and teachers for each class
    public function subjectTeachers()
    {
        return $this->belongsToMany(Subject::class, 'class_subject_teachers')
            ->withPivot('teacher_id', 'academic_session_id')
            ->withTimestamps();
    }
    public function academicSessions()
    {
        return $this->hasManyThrough(AcademicSession::class, 'class_subjects', 'grade_id', 'id', 'id', 'academic_session_id');
    }
}
