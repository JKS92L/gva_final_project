<?php

namespace App\Models;

use App\Models\Grade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

    protected $fillable = [
        'user_id',
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
        'hostel_id',
        'student_photo',
        'bedspace_id',
        'hostel_teacher_id',
        'active_status',
    ];

    protected $casts = [
        'dob' => 'date',
        'admission_date' => 'date',
        'fee_session_group_id' => 'array',
        'sibling_ids' => 'array',
    ];

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'class_id');
    }

    public function hostel()
    {
        return $this->belongsTo(Hostel::class, 'hostel_id');
    }

    public function bedspace()
    {
        return $this->belongsTo(Bedspace::class);
    }
    public function admissions()
    {
        return $this->hasMany(Admissions::class, 'student_id');
    }

    // public function siblings()
    // {
    //     return $this->hasManyThrough(
    //         Student::class,
    //         StudentSibling::class,
    //         'student_id',          // Foreign key on the student_sibling table
    //         'id',                  // Foreign key on the students table
    //         'id',                  // Local key on the students table
    //         'student_id'           // Local key on the student_sibling table
    //     );
    // }
    public function siblings()
    {
        return $this->belongsToMany(
            Student::class,
            'student_sibling',   // Pivot table
            'student_id',        // Foreign key on the pivot table for the current student
            'student_id',        // Foreign key on the pivot table for siblings
            'id',                // Local key on the students table
            'id'                 // Local key on the students table
        )->where('students.id', '!=', $this->id); // Exclude the current student
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tuckshop_transactions()
    {
        return $this->hasMany(TuckShopTransaction::class, 'student_id');
    }

    public function pocketMoneyAccount()
    {
        return $this->hasOne(PocketMoneyAccount::class, 'student_id');
    }


    // public function guardians
    public function guardians()
    {
        return $this->belongsToMany(
            User::class,
            'student_sibling',     // Pivot table
            'student_id',          // Foreign key on the pivot table for the student
            'parent_id',           // Foreign key on the pivot table for guardians
            'id',                  // Local key on the students table
            'id'                   // Local key on the users table (guardians)
        );
    }


   

    public function studentFee()
    {
        return $this->hasMany(StudentFee::class, 'student_id');
    }

    public function hostelTeacher()
    {
        return $this->belongsTo(User::class, 'hostel_teacher_id');
    }

}
