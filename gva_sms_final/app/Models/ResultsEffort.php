<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultsEffort extends Model
{
    protected $table = 'results_efforts';

    protected $fillable = [
        'effort_letter',
        'effort_comment',
        'results_grade_id', // Foreign key from ResultsGrade
    ];


    
    public function resultsGrade()
    {
        return $this->belongsTo(ResultsGrade::class, 'results_grade_id');
    }
}
