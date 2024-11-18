<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermissions extends Model
{
    use HasFactory;

    // Define the table name if it differs from the model name in plural form
    protected $table = 'user_roles_permissions';

    // Allow mass assignment for specific fields
    protected $fillable = [
        'role_id',
        'menu_id',
        'submenu_id',
        'can_view',
        'can_add',
        'can_edit',
        'can_delete'
    ];
}
