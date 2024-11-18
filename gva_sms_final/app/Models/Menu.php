<?php

namespace App\Models;

use App\Models\Submenu;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class Menu extends Model

{
    use HasFactory;

    protected $table = 'menus'; // if not using default table name
    protected $fillable = ['menu_name', 'icon', 'is_active'];

    public function submenus()
    {
        return $this->hasMany(Submenu::class);
    }
    public function roles()
    {
        return $this->belongsToMany(UserRole::class, 'user_roles_permissions', 'menu_id', 'role_id')
            ->withPivot('can_view', 'can_add', 'can_edit', 'can_delete');
    }
}
