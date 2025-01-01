<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermlyReport extends Model
{
    protected $table = 'student_termly_reports'; // Table name
    protected $fillable = [
        'academic_year_id',
        'term_number',
        'student_id',
        'reported_date',
        'report_status',
        'reported_by',
    ];

    // Relationship to Academic Year
    public function academicYear()
    {
        return $this->belongsTo(AcademicSession::class, 'academic_year_id');
    }

    // Relationship to Student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Relationship to Reporter (User)
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }
}

