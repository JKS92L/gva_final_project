<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSubjectTeacher extends Model
{
    use HasFactory;
    protected  $table = 'class_subject_teachers';

    protected $fillable = [
        'session_id',
        'class_id',
        'subject_id',
        'teacher_id',
    ];


    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function classes()
    {
        return $this->belongsTo(Grade::class, 'class_id'); // Assuming Grade model represents the class
    }
}
