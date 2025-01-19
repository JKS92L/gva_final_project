<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeePayment extends Model
{
    use HasFactory;

    protected $table = 'fee_payments';

    protected $fillable = [
        'student_id',
        'fee_category_id',
        'term_no',
        'academic_year_id',
        'amount_paid',
        'payment_date',
        'payment_method',
        'reference_no',
        'attachment_url',
        'attachment_title',
        'payment_status',
        'actioned_by',
        'payment_status',
        'actioned_date',
        'actioned_by',
        'action_comment',
    ];


    protected $casts = [
        'payment_date' => 'datetime',
        'actioned_date' => 'datetime',
        'amount_paid' => 'float',
        'term_no' => 'integer',
        'academic_year_id' => 'integer'
    ];
    /**
     * Relationship with Student
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Relationship with FeeCategory
     */
    public function feeCategory()
    {
        return $this->belongsTo(FeeCatergories::class);
    }

    /**
     * Relationship with AcademicSession
     */
    public function academicSession()
    {
        return $this->belongsTo(AcademicSession::class, 'academic_year_id');
    }

    /**
     * Relationship with SessionTerms
     */
    // public function term()
    // {
    //     return $this->belongsTo(SessionTerms::class, 'term_no', 'term_no');
    // }
}
