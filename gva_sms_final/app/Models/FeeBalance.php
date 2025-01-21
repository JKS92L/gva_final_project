<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeBalance extends Model
{
    use HasFactory;

    protected $table = 'fee_balances';

    protected $fillable = [
        'student_id',
        'fee_category_id',
        'fee_payment_id',
        'academic_year',
        'term',
        'total_fee',
        'amount_paid',
    ];

    /**
     * Accessor for balance_due (if needed, though it's stored as a generated column).
     */
    public function getBalanceDueAttribute()
    {
        return $this->total_fee - $this->amount_paid;
    }

    /**
     * Relationship with Student
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function feeCategory()
    {
        return $this->belongsTo(FeeCatergories::class, 'fee_category_id');
    }
    public function academicSession()
    {
        return $this->belongsTo(AcademicSession::class, 'academic_year_id');
    }

}
