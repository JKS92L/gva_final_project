<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class CodeGenerator
{
    /**
     * Generate a unique alphanumeric code.
     *
     * @param string $model
     * @param string $field
     * @param int $length
     * @return string
     */
    public static function uniqueCode($model, $field, $length = 5)
    {
        do {
            $code = strtoupper(Str::random($length));
        } while ($model::where($field, $code)->exists());

        return $code;
    }

}
