<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;

    protected $table = 'academic_years';

    protected $fillable = [
        'academic_year',
        'term',
        'start_date',
        'end_date',
        'status',
        'created_by',
    ];

    // You can define relationships if needed
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
