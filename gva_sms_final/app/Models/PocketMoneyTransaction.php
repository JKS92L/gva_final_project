<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PocketMoneyTransaction extends Model
{
    use HasFactory;

    protected $table = 'pocket_money_transactions';

    protected $fillable = [
        'transaction_type',       // Type of transaction: deposit, purchase, refund, etc.
        'transaction_id',             // Foreign key to pocket_money_accounts
        'transaction_amount',     // Transaction amount (positive for deposit, negative for purchase)
        'balance_before',         // Balance before the transaction
        'balance_after',          // Balance after the transaction
        'transaction_date',       // Date and time of the transaction
        'description',            // Optional transaction description
        'transaction_reference',  // Optional reference or receipt number
        'status',                 // Transaction status: pending, completed, failed
    ];

    /**
     * Relationship with the PocketMoneyAccount model.
     * Each transaction belongs to one pocket money account.
     */
    public function account()
    {
        return $this->belongsTo(PocketMoneyAccount::class, 'transaction_id', 'id');
    }
    public function tuckShopTransaction()
    {
        return $this->belongsTo(TuckShopTransaction::class, 'transaction_id', 'id');
    }
}
