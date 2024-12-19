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
        'student_photo',
        'active_status',
    ];

    protected $casts = [
        'dob' => 'date',
        'admission_date' => 'date',
        'fee_session_group_id' => 'array',
        'sibling_ids' => 'array',
    ];
    public function enrolledTerm()
    {
        $admission = $this->admissions()->with('term')->first();

        return $admission ? $admission->term : null;
    }

    public function getAdmittedYearAndTerm()
    {
        // Fetch the first admission record
        $admission = $this->admissions()
            ->with(['academicSession'])
            ->first();

        if (!$admission || !$admission->academicSession) {
            return 'Not enrolled';
        }

        // Construct year and term details
        $academicYear = $admission->academicSession->academic_year;
        $termNumber = $admission->academic_term_no;

        return "{$academicYear} - Term {$termNumber}";
    }



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
    /**
     * Define the relationship with the StudentCheckin model.
     */
    public function checkins()
    {
        return $this->hasMany(StudentCheckInCheckOut::class);
    }

    /**
     * Get the latest check-in or check-out record for the student.
     */
    public function latestCheckin()
    {
        return $this->hasOne(StudentCheckInCheckOut::class)->latestOfMany();
    }


    /**
     * Get the latest check-out record specifically.
     */
    public function latestCheckout()
    {
        return $this->hasOne(StudentCheckInCheckOut::class)
            ->latestOfMany()
            ->where('room_status', 'check_out');
    }

    public function admissions()
    {
        return $this->hasMany(Admissions::class, 'student_id');
    }

    /**
     * Define the relationship with the StudentClearIn model.
     */
    public function clearanceRecords()
    {
        return $this->hasMany(StudentClearIn::class, 'student_id');
    }

    /**
     * Get the latest clearance record for the student.
     */
    public function latestClearance()
    {
        return $this->hasOne(StudentClearIn::class, 'student_id')->latestOfMany();
    }

    /**
     * Get the clearance record for a specific term.
     */
    public function clearanceForTerm($academicTermId)
    {
        return $this->hasOne(StudentClearIn::class, 'student_id')->where('academic_term_id', $academicTermId)->first();
    }

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


    public function admission()
    {
        return $this->hasOne(Admissions::class, 'student_id');
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
