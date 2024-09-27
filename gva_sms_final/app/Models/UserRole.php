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
}
