<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'ecz_no',
        'sibling_grade',
        'sibling_names',
        // Add other necessary fields
    ];

    protected $casts = [
        'sibling_names' => 'array', // If you want to store sibling names as an array
    ];
}
