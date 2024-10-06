<?php

namespace App\Models;

use App\Models\Grade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'students'; // The table name is "students"

    // Specify which attributes are mass assignable
    protected $fillable = [
        'ecz_no',
        'class_id',
        'student_type',
        'firstname',
        'lastname',
        'other_name',
        'gender',
        'dob',
        'nrc_id_no',
        'religion',
        'admission_date',
        'medical_condition',
        'sibling_ids',
        'student_photo',
        'hostel_id',
        'bedspace_id',
        'hostel_teacher_id',
        'father_name',
        'father_phone',
        'father_occupation',
        'father_email',
        'father_address',
        'mother_name',
        'mother_phone',
        'mother_occupation',
        'mother_email',
        'mother_address',
        'fee_session_group_id',
        'username',
        'student_phone_number',
        'student_email',
        'password'
    ];

    // Define casts for attributes that should be automatically converted to native types
    protected $casts = [
        'dob' => 'date',
        'admission_date' => 'date',
        'fee_session_group_id' => 'array', // JSON field
        'sibling_ids' => 'array', // JSON field
    ];

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function hostel()
    {
        return $this->belongsTo(Hostel::class);
    }

    // Relationship to Parent (for siblings)
    public function parent()
    {
        return $this->belongsTo(Parent::class);
    }

    // Relationship for Siblings (students who share the same parent)
    public function siblings()
    {
        return $this->hasMany(Student::class, 'parent_id', 'parent_id')
        ->where('id', '!=', $this->id);  // Exclude the current student
    }
}
