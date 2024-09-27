<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'teachers';

    // Specify the fields that are mass assignable
    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'gender',
        'date_of_birth',
        'email',
        'phone_number',
        'address',
        'city',
        'state',
        'country',
        'photo',
        'employee_id',
        'date_of_hire',
        'subject',
        'department',
        'position',
        'years_of_experience',
        'qualifications',
        'certifications',
        'class_assigned',
        'school_branch',
        'username',
        'password',
        'role',
        'status',
        'last_login',
        'password_reset_token',
        'working_days',
        'working_hours_start',
        'working_hours_end',
        'emergency_contact_name',
        'emergency_contact_relation',
        'emergency_contact_phone',
        'national_id',
        'bank_account_number'
    ];

    // Hidden attributes for serialization
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Cast fields to appropriate data types
    protected $casts = [
        'working_days' => 'array',  // Stores JSON data
        'last_login' => 'datetime',
        'working_hours_start' => 'datetime:H:i',
        'working_hours_end' => 'datetime:H:i',
    ];

    // Define relationships

    /**
     * A teacher may have a role (belongs to one role).
     */
    // public function role()
    // {
    //     return $this->belongsTo(Role::class, 'role_id');
    // }

    /**
     * A teacher may be assigned to multiple classes.
     * Define a many-to-many relationship if classes are in another table.
     */
    // public function classes()
    // {
    //     return $this->belongsToMany(ClassModel::class, 'class_teacher', 'teacher_id', 'class_id');
    // }
}
