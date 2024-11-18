<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    protected $table = 'user_roles'; // Make sure this matches the table name in your migration

    protected $fillable = [
        'role_name',
        'description',
        'status'
    ];

    // Relationship to Users
    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
    
    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'user_roles_permissions', 'role_id', 'menu_id')
            ->withPivot('can_view', 'can_add', 'can_edit', 'can_delete');
    }

    public function submenus()
    {
        return $this->belongsToMany(Submenu::class, 'user_roles_permissions', 'role_id', 'submenu_id')
            ->withPivot('can_view', 'can_add', 'can_edit', 'can_delete');
    }

}
