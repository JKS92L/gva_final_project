<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidTime implements Rule
{
    public function passes($attribute, $value)
    {
        // Check if the value matches the format HH:MM (24-hour format)
        return preg_match('/^([01]\d|2[0-3]):([0-5]\d)$/', $value);
    }

    public function message()
    {
        return 'The :attribute must be a valid time in HH:MM format.';
    }
}
