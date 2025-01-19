<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSchoolTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_year_id',
        'term_no',
        'student_id',
        'new_school',
        'transfer_date',
        'status',
        'approved_by',
        'approval_date',
    ];

    /**
     * Relationship with Student
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    /**
     * Relationship with User (Admin or Approver)
     */
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicSession::class, 'academic_year_id');
    }
}
