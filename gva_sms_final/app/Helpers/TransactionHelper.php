<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class TransactionHelper
{
    /**
     * Generate a unique transaction ID.
     *
     * @param string $prefix A prefix for the transaction ID (optional).
     * @return string A unique transaction ID.
     */
    public static function generateTransactionId(string $prefix = 'TXN'): string
    {
        $randomString = Str::upper(Str::random(6)); // Random alphanumeric string
        $timestamp = now()->format('YmdHis'); // Timestamp for uniqueness

        return $prefix . '-' . $randomString . '-' . $timestamp;
    }
}
