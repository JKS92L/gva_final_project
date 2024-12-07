<?php

namespace App\Models;

use App\Models\Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
    public function hasPermission($permission)
    {
        $roleId = Auth::user()->role_id;

        return DB::table('user_roles_permissions')
        ->where('role_id', $roleId)
            ->where('submenu_id', $this->id)
            ->where($permission, 1)
            ->exists();
    }

}
