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

    /**
     * Generate a unique admission ID in the format ADM001.
     *
     * @param string $model
     * @param string $field
     * @param string $prefix
     * @param int $padding
     * @return string
     */
    public static function uniqueAdmissionID($model, $field, $prefix = 'ADM', $padding = 3)
    {
        do {
            // Get the last ID's numeric part and increment it
            $lastRecord = $model::select($field)->orderBy('id', 'desc')->first();
            $nextId = $lastRecord ? intval(substr($lastRecord->$field, strlen($prefix))) + 1 : 1;

            // Generate the padded ID
            $code = $prefix . str_pad($nextId, $padding, '0', STR_PAD_LEFT);
        } while ($model::where($field, $code)->exists());

        return $code;
    }
    
}
