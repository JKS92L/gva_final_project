<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentDetail extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ParentDetails';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',         // ID of the parent in the users table
        'student_id',      // ID of the associated student
        'relation',        // Relation to the student (e.g., Father, Mother, Guardian)
        'occupation',      // Parent's occupation
        'address',         // Parent's address
    ];

    /**
     * Get the parent (user) associated with the parent detail.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the student associated with the parent detail.
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
