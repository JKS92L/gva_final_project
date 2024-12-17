<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentFee extends Model
{
    use HasFactory;
    protected $table = 'student_fees'; // The table name is "students"
    protected $fillable = [
        'student_id',
        'fee_id',
    ];

    /**
     * Define the relationship with the Student model.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Define the relationship with the Fee model.
     */
    // public function fee()
    // {
    //     return $this->belongsTo(Fee::class);
    // }
}
