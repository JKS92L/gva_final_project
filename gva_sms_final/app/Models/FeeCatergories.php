<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeCatergories extends Model
{
    use HasFactory;



    protected $table = 'fee_categories'; // The tastudebfeeble name is "students"
    // The attributes that are mass assignable
    protected $fillable = [
        'fee_type',
        'fee_interval',
        'amount',
        'student_type',
        'account_no',
        'status',
        'comment'
    ];

    public function students()
    {
        return $this->hasMany(StudentFee::class, 'fee_category_id');
    }
    // Relationship with FeePayment
    public function payments()
    {
        return $this->hasMany(FeePayment::class, 'fee_category_id');
    }
    public function classFeeAdjustments()
    {
        return $this->hasMany(ClassFeeAdjustment::class, 'fee_category_id');
    }
    public function feeBalances()
    {
        return $this->hasMany(FeeBalance::class, 'fee_category_id');
    }


}
