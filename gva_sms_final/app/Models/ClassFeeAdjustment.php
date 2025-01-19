<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassFeeAdjustment extends Model
{
    use HasFactory;

    protected $table = 'class_fee_adjustments';

    protected $fillable = [
        'academic_year_id',
        'term_no',
        'class_id',
        'student_type',
        'adjustment_type',
        'amount',
        'reason',
        'adjustment_date',
    ];

    /**
     * Relationship with Academic Year
     */
    public function academicYear()
    {
        return $this->belongsTo(AcademicSession::class, 'academic_year_id');
    }

    /**
     * Relationship with Grade
     */
    public function grade()
    {
        return $this->belongsTo(Grade::class, 'class_id');
    }
    /**
     * Relationship with FeeCategory
     */
    public function feeCategory()
    {
        return $this->belongsTo(FeeCatergories::class, 'fee_category_id');
    }

}

