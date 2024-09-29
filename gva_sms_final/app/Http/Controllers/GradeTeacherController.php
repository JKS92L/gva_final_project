<?php

namespace App\Http\Controllers;

use App\Models\GradeTeacher;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Http\Request;

class GradeTeacherController extends Controller
{
    public function index()
    {
        $gradeTeachers = GradeTeacher::with(['grade', 'user'])->get();
        return view('grade_teachers.index', compact('gradeTeachers'));
    }

    public function create()
    {
        $grades = Grade::all();
        $teachers = User::where('role', 'teacher')->get();  // Assuming there's a role column
        return view('grade_teachers.create', compact('grades', 'teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'grade_id' => 'required|exists:grades,id',
            'academic_year' => 'required|integer',
            'date_assigned' => 'nullable|date',
            'remarks' => 'nullable|string',
            'active' => 'required|boolean'
        ]);

        GradeTeacher::create($validated);

        return redirect()->route('grade_teachers.index')->with('success', 'Grade teacher assigned successfully!');
    }

    public function show(GradeTeacher $gradeTeacher)
    {
        return view('grade_teachers.show', compact('gradeTeacher'));
    }

    public function edit(GradeTeacher $gradeTeacher)
    {
        $grades = Grade::all();
        $teachers = User::where('role', 'teacher')->get();
        return view('grade_teachers.edit', compact('gradeTeacher', 'grades', 'teachers'));
    }

    public function update(Request $request, GradeTeacher $gradeTeacher)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'grade_id' => 'required|exists:grades,id',
            'academic_year' => 'required|integer',
            'date_assigned' => 'nullable|date',
            'remarks' => 'nullable|string',
            'active' => 'required|boolean'
        ]);

        $gradeTeacher->update($validated);

        return redirect()->route('grade_teachers.index')->with('success', 'Grade teacher updated successfully!');
    }

    public function destroy(GradeTeacher $gradeTeacher)
    {
        $gradeTeacher->delete();

        return redirect()->route('grade_teachers.index')->with('success', 'Grade teacher removed successfully!');
    }
}