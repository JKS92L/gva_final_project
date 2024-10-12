<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectTeacherComment extends Model
{
    use HasFactory;
protected $table = 'res_subject_teachers_comments';
    protected $fillable = ['results_grade_id', 'comment'];

    public function resultsGrade()
    {
        return $this->belongsTo(ResultsGrade::class, 'results_grade_id');
    }
}
