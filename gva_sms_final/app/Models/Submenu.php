<?php

namespace App\Models;
use App\Models\Menu;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Submenu extends Model
{
    use HasFactory;
    protected $table = 'submenus'; // if not using default table name
    protected $fillable = ['menu_id', 'submenu_name', 'is_active'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
