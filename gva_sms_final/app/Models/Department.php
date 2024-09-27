<?php

namespace App\Models;

use App\Models\Hod;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name',
        'code',
        'status',
    ];

    // Relationship with HODs
    public function hods()
    {
        return $this->hasMany(Hod::class);
    }
}
