<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TuckShopTransaction extends Model
{
    use HasFactory;

    protected $table = 'tuckShop_transaction';

    protected $fillable = [
        'student_id',
        'academic_session_id',//interger
        'academic_term',// string, e.g term 1
        'item_id',
        'quantity',
        'total_cost',
        'reference_transaction_id',
        'transaction_date',
    ];

    protected $casts = [
        'total_cost' => 'decimal:2',
        'transaction_date' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function tuckshop_item()
    {
        return $this->belongsTo(TuckShopItem::class, 'item_id');
    }
     // Define relationship with PocketMoneyTransaction
    public function pocketMoneyTransactions()
    {
        return $this->hasMany(PocketMoneyTransaction::class, 'transaction_id');
    }

}

