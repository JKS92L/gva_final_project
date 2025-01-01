<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentClearIn extends Model
{
    use HasFactory;
    protected $table = 'student_clear_in_details';
    protected $fillable = [
        'student_id',
        'academic_year_id',
        'academic_term_no',
        'clearance_accounts',
        'clearance_secretary',
        'clearance_search',
        'clearance_patron',
        'check_in_time',
        'brought_by_name',
        'brought_by_nrc',//new
        'brought_vehicle_reg', //new
        'parent_id', //new
        'other_contact', // Added this field
        'brought_by_relationship',
        'cleared_by',
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // public function academicTerm()
    // {
    //     return $this->belongsTo(SessionTerms::class, 'academic_term_id');
    // }

    public function clearedBy()
    {
        return $this->belongsTo(User::class, 'cleared_by');
    }
}

