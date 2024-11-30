<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Helpers\CodeGenerator;
use App\Models\PocketMoneyTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PocketMoneyAccount extends Model
{
    use HasFactory;

    protected $table = 'pocket_money_account';

    protected $fillable = [
        'student_id',
        'academic_session_id',
        'academic_term',
        'current_amount',
        'initial_deposit',
        'receipt_number',
        'deposit_method',
        'bank_account',
        'deposit_description',
        'withdraw_code'
    ];

   

    protected $casts = [
        'deposit_date' => 'datetime',
    ];

    /**
     * Mutator for the withdraw_code attribute.
     * Automatically generates a unique code if not provided.
     */
    public function setWithdrawCodeAttribute($value)
    {
        $this->attributes['withdraw_code'] = $value ?: CodeGenerator::uniqueCode(PocketMoneyAccount::class, 'withdraw_code');
    }

    // Generate a unique withdraw code using the helper
    protected static function booted()
    {
        static::creating(function ($account) {
            if (empty($account->withdraw_code)) {
                $account->withdraw_code = CodeGenerator::uniqueCode(PocketMoneyAccount::class, 'withdraw_code');
            }
        });
    }

    // Define relationship with the Student model
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function deposits()
    {
        return $this->hasMany(PocketMoneyAccount::class, 'transaction_id');
    }

    /**
     * Relationship with pocket money transactions.
     */
    public function transactions()
    {
        return $this->hasMany(PocketMoneyTransaction::class, 'transaction_id', 'id');
    }

 

}
