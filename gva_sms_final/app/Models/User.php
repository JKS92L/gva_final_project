<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Define the table name if it differs from 'users'
    protected $table = 'users';

    // Specify the attributes that are mass assignable
    protected $fillable = [
        'name',
        'username',
        'contact_number', // New field
        'email',
        'password',
        'role_id',
        'status',  // New field
        'profile_picture',  // New field
        'remember_token',
        'email_verified_at',  // New field
    ];

    // Specify attributes that should be hidden in arrays, such as in API responses
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Cast attributes to native types
    protected $casts = [
        'email_verified_at' => 'datetime',
        'status' => 'boolean',  // Cast 'status' to a boolean
    ];
}
