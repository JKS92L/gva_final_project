<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class studentDisciplinary extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'student_disciplinaries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id',
        'academic_year_id',
        'term_no',
        'incident_date',
        'incident_time',
        'incident_location',
        'reported_by',
        'incident_description',
        'disciplinary_action',
        'suspension_start_date',
        'suspension_end_date',
        'action_date',
        'action_taken_by',
        'action_description',
        'attachments',
        'original_attachments_name',
        'status',
        'approved_by',
        'approval_date',
        'comments',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'attachments' => 'array',
        'original_attachments_name'
        => 'array',
        'incident_date' => 'date',
        'suspension_start_date' => 'date',
        'suspension_end_date' => 'date',
        'action_date' => 'date',
        'approval_date' => 'date',
    ];

    /**
     * Get the student associated with the disciplinary record.
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    
    public function academicYear()
    {
        return $this->belongsTo(AcademicSession::class, 'academic_year_id');
    }
}
