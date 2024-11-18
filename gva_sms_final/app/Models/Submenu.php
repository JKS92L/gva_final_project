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
    public function roles()
    {
        return $this->belongsToMany(UserRole::class, 'user_roles_permissions', 'submenu_id', 'role_id')
            ->withPivot('can_view', 'can_add', 'can_edit', 'can_delete');
    }
    
}
