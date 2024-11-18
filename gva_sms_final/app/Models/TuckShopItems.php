<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TuckShopItems extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'tuckShop_items'; // Ensure this matches your actual table name

    // Fillable fields
    protected $fillable = [
        'name',
        'price',
        'stock_quantity',
        'restock_level',
    ];

    // Cast the decimal fields to ensure they are treated correctly
    protected $casts = [
        'price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'restock_level' => 'integer',
    ];

    public function tuckshop_transactions()
    {
        return $this->hasMany(TuckShopTransaction::class, 'item_id');
    }

}
