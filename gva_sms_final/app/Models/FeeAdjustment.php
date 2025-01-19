<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeAdjustment extends Model
{
    use HasFactory;

    protected $table = 'student_fee_adjustment';

    protected $fillable = [
        'student_id',
        'academic_year_id',
        'term_no',
        'waver_penalty_feeId',
        'adjustment_type',
        'amount',
        'reason',
        'adjustment_date',
    ];

    /**
     * Relationship with Student
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Scope for Waivers
     */
    public function scopeWaivers($query)
    {
        return $query->where('adjustment_type', 'waiver');
    }

    /**
     * Scope for Penalties
     */
    public function scopePenalties($query)
    {
        return $query->where('adjustment_type', 'penalty');
    }
    public function academicYear()
    {
        return $this->belongsTo(AcademicSession::class, 'academic_year_id');
        
    }

    public function adjustmentFeeCategory()
    {
        return $this->belongsTo(FeeCatergories::class, 'waver_penalty_feeId');
    }





}
