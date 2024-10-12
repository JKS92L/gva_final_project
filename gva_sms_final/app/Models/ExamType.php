<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamType extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'exam_types';

    // Fillable fields
    protected $fillable = [
        'name',
        'weight',
        'interval'
    ];



    
}
