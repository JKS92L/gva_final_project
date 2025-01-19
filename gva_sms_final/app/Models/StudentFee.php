<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentFee extends Model
{
    use HasFactory;

    protected $table = 'student_fees';

    protected $fillable = [
        'student_id',
        'fee_category_id',
        'academic_year_id',
        'term_no',
    ];

    /**
     * Define the relationship with the Student model.
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    /**
     * Define the relationship with the FeeCatergories model.
     */
    public function feeCategory()
    {
        return $this->belongsTo(FeeCatergories::class, 'fee_category_id');
    }

    /**
     * Define the relationship with the Grade model.
     */
    public function grade()
    {
        return $this->belongsTo(Grade::class, 'class_id');
    }

    /**
     * Define the relationship with the AcademicSession model.
     */
    public function academicYear()
    {
        return $this->belongsTo(AcademicSession::class, 'academic_year_id');
    }

    /**
     * Define the relationship with FeePayment model.
     */
    public function payments()
    {
        return $this->hasMany(FeePayment::class, 'fee_category_id', 'fee_category_id')
            ->where('student_id', $this->student_id);
    }
}
