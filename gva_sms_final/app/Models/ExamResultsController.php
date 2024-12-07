<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamResultsController extends Model
{
    use HasFactory;

    public function viewEnterResults(){
        // Fetch active academic sessions, sorted by the newest year first
        $academicSessions = AcademicSession::where('is_active', 1)->orderBy('academic_year', 'desc')->get();
        $grades = Grade::all();
        // Prepare terms in the sorted order
        $terms = [];
        foreach ($academicSessions as $session) {
            $terms[] = ['id' => $session->id . '-term1', 'name' => $session->academic_year . ' - Term 1'];
            $terms[] = ['id' => $session->id . '-term2', 'name' => $session->academic_year . ' - Term 2'];
            $terms[] = ['id' => $session->id . '-term3', 'name' => $session->academic_year . ' - Term 3'];
        }

        return view('backend.examination.enter-results',compact('terms', 'grades'));
    }






}