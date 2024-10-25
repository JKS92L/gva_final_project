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
        'user_id',
        'first_name',
        'last_name',
        'middle_name',
        'gender',
        'date_of_birth',
        'address',
        'province',
        'town',
        'country',
        'employee_id',
        'date_of_hire',
        'department_id',
        'bank_account_no',
        'bank_name',
        'years_of_experience',
        'qualifications',
        'certifications',
        'working_days',
        'working_hours_start',
        'working_hours_end',
        'emergency_contact_name',
        'emergency_contact_relation',
        'emergency_contact_phone',
        'national_id'
    ];


    // Hidden attributes for serialization

    // Cast fields to appropriate data types
    protected $casts = [
        'working_days' => 'array',  // Stores JSON data
        'last_login' => 'datetime',
        'working_hours_start' => 'datetime:H:i',
        'working_hours_end' => 'datetime:H:i',
        // 'subject_major_ids' => 'array',
        // 'subject_minor_ids' => 'array',

    ];
    // Relationship to the User model (one-to-one)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    // Relationship to the Department model
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    // Relationship for major subjects
    public function majorSubjects()
    {
        return $this->belongsToMany(Subject::class, 'teacher_major_subjects', 'teacher_id', 'subject_id');
    }

    // Relationship for minor subjects
    public function minorSubjects()
    {
        return $this->belongsToMany(Subject::class, 'teacher_minor_subjects', 'teacher_id', 'subject_id');
    }

    public function classes()
    {
        return $this->belongsToMany(Grade::class, 'class_subject_teacher')
        ->withPivot('subject_id', 'subject_type')
        ->withTimestamps();
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'class_subject_teacher')
        ->withPivot('class_id', 'subject_type')
        ->withTimestamps();
    }




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
