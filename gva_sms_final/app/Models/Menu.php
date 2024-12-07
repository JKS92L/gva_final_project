<?php

namespace App\Models;

use App\Models\Submenu;
use App\Models\UserRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
    public function hasPermission($permission)
    {
        $roleId = Auth::user()->role_id;

        return DB::table('user_roles_permissions')
        ->where('role_id', $roleId)
            ->where('menu_id', $this->id)
            ->where($permission, 1)
            ->exists();
    }


}
