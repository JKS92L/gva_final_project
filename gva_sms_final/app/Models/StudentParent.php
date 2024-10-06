<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentParent extends Model
{
    protected $table = 'parents'; // The table name is "students"
    protected $fillable = ['name', 'phone', 'email', 'address'];

    // Relationship to children (students)
    public function children()
    {
        return $this->hasMany(Student::class, 'parent_id');
    }
  
}
