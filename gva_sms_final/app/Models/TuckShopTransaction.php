<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TuckShopTransaction extends Model
{
    use HasFactory;

    // Define the table associated with the model (if it's not the plural form of the model name)
    protected $table = 'tuck_shop_transaction'; // Change this to your actual table name

    // Fillable fields
    protected $fillable = [
        'student_id',
        'item_id',
        'quantity',
        'total_cost',
        'transaction_date',
    ];

    // Cast the decimal fields to ensure they are treated correctly
    protected $casts = [
        'total_cost' => 'decimal:2',
        'transaction_date' => 'datetime',
    ];

    // Define the relationship with the Student model
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // Define the relationship with the Item model
    public function tuckshop_items()
    {
        return $this->belongsTo(TuckShopItems::class, 'item_id');
    }
    
}
