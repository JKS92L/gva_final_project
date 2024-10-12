<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultsGrade extends Model
{
    protected $table = 'result_grades'; // Specify table name if necessary

    protected $fillable = [
        'grade',
        'min_score',
        'max_score',
    ];

    // Define the relationship with Efforts
    public function resultsEfforts()
    {
        return $this->hasMany(ResultsEffort::class, 'results_grade_id');
    }
}
