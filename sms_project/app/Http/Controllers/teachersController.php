<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class teachersController extends Controller
{
    public function assignSubject(){
        return view('admin.teachers.assign-subject');

    }

    public function assignResponsibility(){
        return view('admin.teachers.assign-responsibility');
    }

    public function cpdReport()
    {
        return view('admin.teachers.cpd-reports');
    }
    public function communicationLog()
    {
        return view('admin.teachers.communication-logs');
    }
    public function teachersReport()
    {
        return view('admin.teachers.teacher-reports');
    }

    public function lessonObservation()
    {
        return view('admin.teachers.lesson-observation');
    }

    public function fileMonitoring()
    {
        return view('admin.teachers.file-monitoring');
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
