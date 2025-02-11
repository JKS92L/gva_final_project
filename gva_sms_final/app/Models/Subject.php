<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'subjects';
    protected $fillable = [
        'name',
        'short_code',
        'subject_code',
        'department',
        'section',
        'active',
        'created_at',
        'updated_at',
    ];

    // Teachers with this subject as a major
    public function majorTeachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_major_subjects', 'subject_id', 'teacher_id');
    }

    // Teachers with this subject as a minor
    public function minorTeachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_minor_subjects', 'subject_id', 'teacher_id');
    }

    // Many-to-Many relationship with Grade (through class_subjects pivot table)
    public function grades()
    {
        return $this->belongsToMany(Grade::class, 'class_subjects')
            ->withPivot('academic_session_id', 'grade_id')
            ->withTimestamps();
    }

    // New relationship for teachers assigned to this subject in each class
    public function gradeSubjectTeachers()
    {
        return $this->belongsToMany(Grade::class, 'class_subject_teacher', 'subject_id', 'class_id')
            ->withPivot('teacher_id', 'academic_session_id')
            ->withTimestamps();
    }
}
