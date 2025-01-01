<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentClearOut extends Model
{
    use HasFactory;

    // Table name (optional if it follows Laravel's naming convention)
    protected $table = 'student_clear_out_details';

    // Mass assignable attributes
    protected $fillable = [
        'student_id',
        'academic_year_id',
        'academic_term_no',
        'clear_out_person',
        'check_out_time',
        'parent_id',
        'other_name',
        'other_nrc',
        'other_contact',
        'vehicle_reg',
        'brought_by_relationship',
        'cleared_by',
        'brought_by_name',
        'brought_by_contact',
        'brought_by_nrc',
        'brought_vehicle_reg',
    ];

    


    /**
     * Relationships
     */

    // Student relationship
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // Academic term relationship
    public function academicTerm()
    {
        return $this->belongsTo(SessionTerms::class, 'academic_term_id');
    }

    // Parent/Guardian relationship
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    // User who cleared the student
    public function clearedBy()
    {
        return $this->belongsTo(User::class, 'cleared_by');
    }
}
