<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeTransaction extends Model
{
    use HasFactory;

    protected $table = 'fee_transactions';

    protected $fillable = [
        'payment_id',
        'transaction_date',
        'amount',
        'transaction_type',
        'remarks',
    ];

    /**
     * Relationship with Payment
     */
    public function payment()
    {
        return $this->belongsTo(FeePayment::class);
    }

    /**
     * Scope for filtering transactions by type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('transaction_type', $type);
    }

    /**
     * Scope for filtering transactions by date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('transaction_date', [$startDate, $endDate]);
    }
}
