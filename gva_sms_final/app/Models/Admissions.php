<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admissions extends Model
{
    use HasFactory;

    protected $table = 'admissions';

    protected $fillable = [
        'academic_year_id',
        'academic_term_no',
        'admission_id',
        'student_id',
        'admissionAppType',
        'apptude_score',
        'application_status',
        'brief_comment',
    ];

    public $timestamps = true;

    public function term()
    {
        return $this->belongsTo(SessionTerms::class, 'academic_term_no');
    }

    // Relationship with Student model
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // Relationship with AcademicSession model
    public function academicSession()
    {
        return $this->belongsTo(AcademicSession::class, 'academic_year_id');
    }
}
