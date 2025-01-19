<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeStructure extends Model
{
    use HasFactory;

    protected $table = 'fee_structures';

    protected $fillable = [
        'fee_category_id',
        'class_id',
        'student_type',
        'academic_year_id',
        'term_no',
        'amount',
    ];

    // Relationship with FeeCategory
    public function feeCategory()
    {
        return $this->belongsTo(FeeCatergories::class);
    }

    // Relationship with Class
    public function class()
    {
        return $this->belongsTo(Grade::class); // Assuming your class model is named Grade
    }

    // Relationship with Academic Session
    public function academicSession()
    {
        return $this->belongsTo(AcademicSession::class, 'academic_year_id');
    }

    // Relationship with Terms
   
}

