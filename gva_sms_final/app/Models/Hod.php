<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hod extends Model
{
    protected $fillable = [
        'user_id',
        'department_id',
        'date_appointed',
        'term_duration',
        'notes',
        'active',
    ];

    // Relationship with Users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Departments
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
