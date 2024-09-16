<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // Define the relationship to users
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
