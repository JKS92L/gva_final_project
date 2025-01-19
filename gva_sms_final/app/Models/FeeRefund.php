<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeRefund extends Model
{
    use HasFactory;

    protected $table = 'fee_refunds';

    protected $fillable = [
        'student_id',
        'amount',
        'refund_date',
        'remarks',
    ];

    /**
     * Relationship with Student
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Scope to filter refunds by date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('refund_date', [$startDate, $endDate]);
    }
}
