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
        'user_id',                // Foreign key linking to the users table
        'ecz_no',                 // Examination number
        'class_id',               // Foreign key for the class the student belongs to
        'student_type',           // Type of student (e.g., full-time, part-time)
        'firstname',              // Student's first name
        'lastname',               // Student's last name
        'other_name',             // Any other names
        'gender',                 // Gender of the student
        'dob',                    // Date of birth
        'nrc_id_no',              // National Registration Card ID number
        'religion',               // Student's religion
        'admission_date',         // Date of admission
        'medical_condition',      // Any medical conditions the student has
        'hostel_id',              // Foreign key for the hostel (if applicable)
        'sibling_ids',            // JSON-encoded array of sibling IDs
        'student_photo',          // Path to the student's photo
        'bedspace_id',            // Foreign key for the bedspace in the hostel
        'hostel_teacher_id',      // Foreign key for the hostel teacher
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
        return $this->belongsTo(Grade::class, 'class_id'); // 'class_id' is the foreign key in the students table.
    }
    

    public function hostel()
    {
        return $this->belongsTo(Hostel::class);
    }
    public function bedspace()
    {
        return $this->belongsTo(Bedspace::class);
    }

    // Relationship for Siblings (students who share the same parent)
    public function siblings()
    {
        return $this->hasMany(Student::class, 'parent_id', 'parent_id')
            ->where('id', '!=', $this->id);  // Exclude the current student
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(StudentParent::class, 'parent_id');
    }

}
