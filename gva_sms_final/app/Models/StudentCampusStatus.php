<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCampusStatus extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'student_status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id',
        'permission_type',
        'reference_id',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'status' => 'string',
    ];

    /**
     * Relationship: A student status belongs to a student.
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    /**
     * Relationship: A reference can point to another model (e.g., permission or user).
     * Update the related model class if required.
     */
    // public function reference()
    // {
    //     // Replace `RelatedModel` with the actual model class (e.g., User or Permission).
    //     return $this->belongsTo(RelatedModel::class, 'reference_id');
    // }
}
