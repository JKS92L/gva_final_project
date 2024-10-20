<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionTerms extends Model
{
    use HasFactory;

    protected $table = 'session_terms';

    // Define fillable fields for mass assignment
    protected $fillable = [
        'academic_year_id',
        'term_number',
        'status',
        'created_on',
        'updated_on',
    ];

    // Define relationship with AcademicSession model
    public function academicSession()
    {
        return $this->belongsTo(AcademicSession::class, 'academic_year_id');
    }
}
