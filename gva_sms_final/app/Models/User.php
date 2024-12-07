<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

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

    // Define the relationship with the Teacher model

    public function parent()
    {
        return $this->hasOne(StudentParent::class);
    }

    // In User.php model
    public function student()
    {
        return $this->hasOne(Student::class, 'user_id');
    }

    // One-to-one relationship with Teacher
    public function teacher()
    {
        return $this->hasOne(Teacher::class, 'user_id');
    }
    // Relationship to the Role model
    public function role()
    {
        return $this->belongsTo(UserRole::class, 'role_id');
    }


    public function hasPermission($permission)
    {
        // Fetch user permissions from user_roles_permissions table
        return DB::table('user_roles_permissions')
            ->where('role_id', $this->role_id)
            ->where($permission, 1) // Check if the permission (e.g., can_view) is granted
            ->exists();
    }


}
