<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submenu extends Model
{
    use HasFactory;

    protected $fillable = ['menu_id', 'text', 'icon', 'is_active'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
