<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['text', 'icon', 'is_active'];

    public function submenus()
    {
        return $this->hasMany(Submenu::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForUser($query, $user)
    {
        return $query->whereHas('submenus', function ($q) use ($user) {
            $q->whereIn('id', $user->submenus->pluck('id'));
        })->active();
    }
}
