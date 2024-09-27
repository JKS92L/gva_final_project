<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller; // Import the base Controller class
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class teachersController extends Controller
{
    public function assignSubject(){
        return view('backend.teachers.assign-subject');
        // backend.user_management.user-list

    }

    public function assignResponsibility(){
        return view('backend.teachers.assign-responsibility');
    }

    public function cpdReport()
    {
        return view('backend.teachers.cpd-reports');
    }
    public function communicationLog()
    {
        return view('backend.teachers.communication-logs');
    }
    public function teachersReport()
    {
        return view('backend.teachers.teacher-reports');
    }

    public function lessonObservation()
    {
        return view('backend.teachers.lesson-observation');
    }

    public function fileMonitoring()
    {
        return view('backend.teachers.file-monitoring');
    }
  



























    // public function create()
    // {
    //     $teachers = Teacher::all();
    //     $classes = ClassModel::all();
    //     $subjects = Subject::all();

    //     return view('assign-subject', compact('teachers', 'classes', 'subjects'));
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'teacher_id' => 'required|exists:teachers,id',
    //         'class_id' => 'required|exists:classes,id',
    //         'subject_id' => 'required|exists:subjects,id',
    //         'academic_year' => 'required|string|max:4'
    //     ]);

    //     // Create the assignment
    //     TeacherSubjectAssignment::create([
    //         'teacher_id' => $request->teacher_id,
    //         'class_id' => $request->class_id,
    //         'subject_id' => $request->subject_id,
    //         'academic_year' => $request->academic_year,
    //     ]);

    //     return redirect()->back()->with('success', 'Subject assigned to teacher successfully.');
    
    // }
}