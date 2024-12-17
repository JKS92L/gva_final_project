<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSibling extends Model
{
    use HasFactory;

    protected $table = 'student_sibling';

    protected $fillable = [
        'parent_id',
        'student_id',
        'is_active',
    ];

    public function guardians()
    {
        return $this->belongsTo(ParentDetail::class, 'parent_id');
    }

    public function siblings()
    {
        return $this->hasMany(StudentSibling::class, 'parent_id', 'parent_id')
            ->where('student_id', '!=', $this->student_id);
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function parentUser()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }
}
