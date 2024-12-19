<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicSession extends Model
{
    use HasFactory;

    protected $table = 'academicYear';

    protected $fillable = [
        'academic_year',
        'term1_start',
        'term1_end',
        'term2_start',
        'term2_end',
        'term3_start',
        'term3_end',
        'is_active',
        'created_by',
    ];

    // Creator of the session
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Related session terms
    public function terms()
    {
        return $this->hasMany(SessionTerms::class, 'academic_year_id');
    }

    // Subjects assigned through AssignClassSubject
    public function classSubjects()
    {
        return $this->hasManyThrough(
            Subject::class,
            AssignClassSubject::class,
            'academic_session_id', // Foreign key on AssignClassSubject
            'id', // Foreign key on Subject
            'id', // Local key on AcademicSession
            'subject_id' // Local key on AssignClassSubject
        );
    }

    // Alternative relationship for active/current terms
    public function currentTerms()
    {
        return $this->hasMany(SessionTerms::class, 'session_id');
    }

    // Helper to get active term dates
    public function getActiveTermDates()
    {
        return [
            'term1' => ['start' => $this->term1_start, 'end' => $this->term1_end],
            'term2' => ['start' => $this->term2_start, 'end' => $this->term2_end],
            'term3' => ['start' => $this->term3_start, 'end' => $this->term3_end],
        ];
    }

    // Check if the session is active
    public function isActive()
    {
        return $this->is_active === 1;
    }
    public function term()
    {
        return $this->belongsTo(SessionTerms::class, 'academic_term_no');
    }

}
