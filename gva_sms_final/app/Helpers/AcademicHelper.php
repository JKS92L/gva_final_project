<?php

namespace App\Helpers;

use App\Models\AcademicSession;

class AcademicHelper
{
    /**
     * Get academic years with their associated terms.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getActiveAcademicYearsWithTerms()
    {
        return AcademicSession::with(['terms' => function ($query) {
            $query->select('id', 'term_number', 'academic_year_id')->orderBy('term_number', 'asc');
        }])
            ->where('is_active', 1) // Fetch only active academic years
            ->select('id', 'academic_year')
            ->orderBy('academic_year', 'desc')
            ->get();
    }
}
