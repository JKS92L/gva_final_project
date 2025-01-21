<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Models\AcademicSession;
use App\Models\AssignClassSubject;
use Illuminate\Support\Facades\DB;
use App\Models\ClassSubjectTeacher;

class AcademicsController extends Controller
{


    // public function viewAssignClassSubjects()
    // {
    //     // Retrieve data from your models
    //     $academicYears = AcademicSession::all();  // Assuming you have a model for academic years
    //     $subjects = Subject::all();            // Assuming you have a Subject model
    //     $grades = Grade::all(); // Assuming you have a Grade model with related classes
    //     return view('backend.academic.assign-class-subjects', compact('academicYears', 'subjects', 'grades'));
    // }
    public function viewAssignClassSubjects()
    {
        // Fetch active academic sessions, sorted by the newest year first
        $academicSessions = AcademicSession::where('is_active', 1)->orderBy('academic_year', 'desc')->get();

        // Prepare terms in the sorted order
        $terms = [];
        foreach ($academicSessions as $session) {
            $terms[] = ['id' => $session->id . '-term1', 'name' => $session->academic_year . ' - Term 1'];
            $terms[] = ['id' => $session->id . '-term2', 'name' => $session->academic_year . ' - Term 2'];
            $terms[] = ['id' => $session->id . '-term3', 'name' => $session->academic_year . ' - Term 3'];
        }
        // Retrieve grades with subjects and academic sessions, paginated
        $assignments = Grade::with(['subjects' => function ($query) {
            $query->withPivot('academic_session_id');
        }])->paginate(20); // Change 10 to the number of items you want per page

        $academicYears = AcademicSession::all();  // Fetch all academic sessions
        $allSubjects = Subject::all();
        $grades = Grade::all();           // Fetch all subjects

        return view('backend.academics.assign-class-subjects', compact(
            'assignments',
            'academicYears',
            'allSubjects',
            'grades'

        ));
    }


    // ASSIGN SUBJECTS TO CLASS
    //assign subject to class
    public function assignClassSubjects(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'academic_session' => 'required|exists:AcademicYear,id',
            'grade' => 'required|exists:grades,id',
            'subjects' => 'required|array|min:1',
            'subjects.*' => 'exists:subjects,id', // Ensure each subject exists
        ]);

        // Get the grade and academic session
        $grade = Grade::find($validatedData['grade']);
        $academicSessionId = $validatedData['academic_session'];

        // Attach each subject to the grade with the academic session
        foreach ($validatedData['subjects'] as $subjectId) {
            // Using the attach method to add to pivot table
            $grade->subjects()->attach($subjectId, ['academic_session_id' => $academicSessionId]);
        }

        // Return a success message or redirect back
        return redirect()->back()->with('success', 'Subjects successfully assigned to the grade!');
    }
    public function updateClassSubjects(Request $request)
    {
        $validatedData = $request->validate([
            'grade_id' => 'required|exists:grades,id',
            'academic_session_id' => 'required|exists:academicYear,id',
            'subjects' => 'required|array|min:1',
            'subjects.*' => 'exists:subjects,id',
        ]);

        // Update the subjects for the grade and academic session in the pivot table
        $grade = Grade::findOrFail($request->grade_id);
        $grade->subjects()->syncWithPivotValues($request->subjects, ['academic_session_id' => $request->academic_session_id]);

        return redirect()->back()->with('success', 'Subjects successfully updated!');
    }

    // destroy assigned grades
    public function destroyClassSubjects(Request $request)
    {
        $validatedData = $request->validate([
            'grade_id' => 'required|exists:grades,id',
            'academic_session_id' => 'required|exists:academicYear,id',
        ]);

        // Detach all subjects assigned to the grade for the given academic session
        $grade = Grade::findOrFail($request->grade_id);
        $grade->subjects()->wherePivot('academic_session_id', $request->academic_session_id)->detach();

        return redirect()->back()->with('success', 'Subjects successfully deleted!');
    }

    //CLASS SUBJECT TEACHERS 
    public function viewClassSubjectsTeachers()
    {

        // Get the most recent or current academic session
        $currentSession = AcademicSession::where('is_active', 1)->first();

        // Fetch grades with assigned subjects for the current academic session
        $gradesWithSubjects = Grade::whereHas('subjects', function ($query) use ($currentSession) {
            $query->where('class_subjects.academic_session_id', $currentSession->id);
        })->with(['subjects' => function ($query) use ($currentSession) {
            $query->wherePivot('academic_session_id', $currentSession->id);
        }])->get();

        return view('backend.academics.assign-class-subject-teacher', compact('gradesWithSubjects'));
    }

    //AJAX Query to fetch the grades and their subject teachers 
    public function fetchSubjectsAndTeachers($id)
    {
        $classSubjects = AssignClassSubject::with([
            'subjects.majorTeachers',
            'subjects.minorTeachers',
            'assignedTeachers' => function ($query) {
                // Join teachers table explicitly to fetch assigned teachers
                $query->join('teachers', 'class_subject_teachers.teacher_id', '=', 'teachers.id');
            }
        ])
        ->where('grade_id', $id)
        ->get();
        // dd($classSubjects->toSql());

        return response()->json([
            'classSubjects' => $classSubjects,
        ]);
    }







    // assign teacher to class subjects
    public function assignSubjectTeachersToClass(Request $request)
    {
        $validatedData = $request->validate([
            'session_id' => 'required|integer',
            'class_id' => 'required|integer',
            'subjects' => 'required|array',
            'subjects.*.subject_id' => 'required|integer',
            'subjects.*.teacher_id' => 'required|integer',
        ]);

        // Loop through each subject and assigned teacher, updating or creating entries
        foreach ($validatedData['subjects'] as $subject) {
            ClassSubjectTeacher::updateOrCreate(
                [
                    'session_id' => $validatedData['session_id'],
                    'class_id' => $validatedData['class_id'],
                    'subject_id' => $subject['subject_id'],
                ],
                [
                    'teacher_id' => $subject['teacher_id'],
                ]
            );
        }

        return response()->json(['message' => 'Teachers assigned successfully'], 200);
    }




    //ATTENDACE REGISTER
    public function viewAttendanceRegister()
    {
        // Additional logic can be added here if necessary (e.g., fetching data)
        return view('backend.academics.student-attendance-register');
    }
}
