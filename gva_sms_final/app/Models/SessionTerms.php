<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionTerms extends Model
{
    use HasFactory;

    protected $table = 'session_terms';

    protected $fillable = [
        'academic_year_id',
        'term_number',
        'status',
        'created_on',
        'updated_on',
    ];

    // Belongs to an academic session
    public function academicSession()
    {
        return $this->belongsTo(AcademicSession::class, 'academic_year_id');
    }

    // Admissions associated with this term
    public function admissions()
    {
        return $this->hasMany(Admissions::class, 'academic_term_no', 'term_number');
    }

    // Students indirectly related through admissions
    public function students()
    {
        return $this->hasManyThrough(
            Student::class,
            Admissions::class,
            'academic_term_no', // Foreign key on Admissions
            'id',               // Foreign key on Student
            'term_number',      // Local key on SessionTerms
            'student_id'        // Local key on Admissions
        );
    }

    // Subjects taught in this term
    public function subjects()
    {
        return $this->hasManyThrough(
            Subject::class,
            AssignClassSubject::class,
            'session_term_id', // Foreign key on AssignClassSubject
            'id',              // Foreign key on Subject
            'id',              // Local key on SessionTerms
            'subject_id'       // Local key on AssignClassSubject
        );
    }

    // Teachers teaching in this term
    public function teachers()
    {
        return $this->hasManyThrough(
            Teacher::class,
            AssignClassSubject::class,
            'session_term_id', // Foreign key on AssignClassSubject
            'id',              // Foreign key on Teacher
            'id',              // Local key on SessionTerms
            'teacher_id'       // Local key on AssignClassSubject
        );
    }
}
