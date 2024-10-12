<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PassingPercentageSetting extends Model
{
    // use HasFactory;

    protected $fillable = [
        'junior_passing_percentage',
        'senior_passing_percentage',
    ];

    // Optionally, you can define any helper methods related to the percentages here
}
