<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentHomePermission extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'student_home_permissions';

    // Primary key
    protected $primaryKey = 'id';

    // Timestamps
    public $timestamps = true;

    // Fillable fields for mass assignment
    protected $fillable = [
        'student_id',
        'academic_year_id',
        'academic_term_no',
        'permission_start',
        'permission_end',
        'reason',
        'deputy_comment',
        'approved_by_id',
    ];

    protected $casts = [
        'permission_start' => 'date',
        'permission_end' => 'date',
    ];

    /**
     * Relationship: belongs to a student.
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    /**
     * Relationship: belongs to an academic year.
     */
    public function academicYear()
    {
        return $this->belongsTo(AcademicSession::class, 'academic_year_id', 'id');
    }

    /**
     * Relationship: belongs to a parent (if applicable).
     */
    public function guardians()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Relationship: belongs to the user who approved the permission (Authorized By).
     */
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by_id', 'id');
    }

    /**
     * Relationship: has many permission logs.
     */
    public function logs()
    {
        return $this->hasMany(PermissionLogs::class, 'permission_id', 'id');
    }
}

