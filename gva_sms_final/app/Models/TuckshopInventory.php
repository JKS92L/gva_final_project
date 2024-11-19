<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TuckshopInventory extends Model
{
    use HasFactory;

    protected $table = 'tuckShop_items'; // Table name

    protected $fillable = [
        'name',
        'price',
        'stock_quantity',
        'restock_level',
    ];
}
