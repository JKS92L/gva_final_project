<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicSession extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'academicYear';

    // Define fillable fields for mass assignment
    protected $fillable = [
        'academic_year',
        'term1_start',
        'term1_end',
        'term2_start',
        'term2_end',
        'term3_start',
        'term3_end',
        'status',
        'created_by',
    ];

    // Define relationships, if any
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Optionally, you can add custom accessors or methods to work with the terms more easily

    // Accessor to get the active term dates
    public function getActiveTermDates()
    {
        // Assuming you want to retrieve dates for all terms in one go
        return [
            'term1' => [
                'start' => $this->term1_start,
                'end' => $this->term1_end,
            ],
            'term2' => [
                'start' => $this->term2_start,
                'end' => $this->term2_end,
            ],
            'term3' => [
                'start' => $this->term3_start,
                'end' => $this->term3_end,
            ],
        ];
    }

    // Add a method to check the current active status
    public function isActive()
    {
        return $this->status === 'active';
    }
}
