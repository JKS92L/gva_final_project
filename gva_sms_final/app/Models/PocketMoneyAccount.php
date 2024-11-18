<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// PocketMoneyAccount.php

class PocketMoneyAccount extends Model
{
    use HasFactory;

    protected $table = 'pocket_money_account';

    protected $fillable = [
        'student_id',
        'deposit_amount',
        'deposit_date',
        'deposit_method',
        'receipt_number',
        'bank_account',
        'deposit_description',
    ];

    protected $dates = ['deposit_date'];

    protected $casts = [
        'deposit_date' => 'datetime',
    ];

    // Define relationship with the Student model
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}

