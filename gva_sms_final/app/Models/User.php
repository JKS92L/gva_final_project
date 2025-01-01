<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'username',
        'contact_number',
        'email',
        'password',
        'role_id',
        'status',
        'profile_picture',
        'remember_token',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'status' => 'boolean',
    ];

    public function student()
    {
        return $this->hasOne(Student::class, 'user_id');
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class, 'user_id');
    }

    public function role()
    {
        return $this->belongsTo(UserRole::class, 'role_id');
    }
 public function parentDetails()
    {
        return $this->hasMany(ParentDetail::class, 'user_id');
    }


    public function siblingRelationships()
    {
        return $this->hasMany(StudentSibling::class, 'parent_id', 'id');
    }

    public function children()
    {
        return $this->hasManyThrough(
            Student::class,
            StudentSibling::class,
            'parent_id', // Foreign key on the StudentSibling table
            'id',        // Foreign key on the Students table
            'id',        // Local key on the Users table
            'student_id' // Local key on the StudentSibling table
        );
    }

    public function hasPermission($permission)
    {
        return DB::table('user_roles_permissions')
            ->where('role_id', $this->role_id)
            ->where($permission, 1)
            ->exists();
    }
   
}