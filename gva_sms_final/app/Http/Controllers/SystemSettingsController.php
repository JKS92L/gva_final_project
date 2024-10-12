<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\ExamType;
use App\Models\ResultsGrade;
use Illuminate\Http\Request;
use App\Models\ResultsEffort;
use App\Models\AcademicSession;
use App\Models\SubjectTeacherComment;
use App\Models\PassingPercentageSetting;

class SystemSettingsController extends Controller
{
    //EFFORTS AND RESULTS GRADING SYSTEM
    public function ShowgeneralSettings()
    {
        // Fetch the first record (assuming there's only one settings row)

        $efforts = ResultsEffort::with('resultsGrade')->get();
        $results_grades = ResultsGrade::all();
        $examTypes = ExamType::all();
        $pass_percentage = PassingPercentageSetting::first();
        $subjectTeacherComments = SubjectTeacherComment::all();
        $fees = Fee::all();

        // Return the view with the fetched data
        return view('backend.settings.generalSettings', compact(
            'efforts',
            'results_grades',
            'examTypes',
            'pass_percentage',
            'subjectTeacherComments',
            'fees'

        ));
    }
    // update effort
    public function updateEffort(Request $request, $id)
    {
        $request->validate([
            'effort_letter' => 'required|string|max:1',
            'effort_comment' => 'required|string',
            'score_min' => 'required|integer',
            'score_max' => 'required|integer|gte:score_min', // Ensure max is greater than or equal to min
        ]);

        $effort = ResultsEffort::findOrFail($id);
        $effort->update($request->only('effort_letter', 'effort_comment'));

        // Update the associated results grade
        $resultsGrade = $effort->resultsGrade; // Assuming a one-to-one relationship
        $resultsGrade->score_min = $request->input('score_min');
        $resultsGrade->score_max = $request->input('score_max');
        $resultsGrade->save();

        return redirect()->route('efforts.index')->with('success', 'Effort updated successfully');
    }


    // update passing percentage
    public function updatePassingPercentage(Request $request)
    {
        $request->validate([
            'junior_passing_percentage' => 'required|numeric|min:0|max:100',
            'senior_passing_percentage' => 'required|numeric|min:0|max:100',
        ]);

        // Update settings (assuming a Settings model or use any preferred way to store)
        $settings = PassingPercentageSetting::first();
        $settings->update([
            'junior_passing_percentage' => $request->junior_passing_percentage,
            'senior_passing_percentage' => $request->senior_passing_percentage,
        ]);

        return redirect()->back()->with('success', 'Passing percentages updated successfully!');
    }


    // SUBJECT TEACHER COMMENTS METHODS 
    public function storeComment(Request $request)
    {
        $request->validate([
            'results_grade_id' => 'required|exists:result_grades,id', // Adjust the validation as per your DB
            'comment' => 'required|string|max:255',
        ]);

        SubjectTeacherComment::create([
            'results_grade_id' => $request->results_grade_id,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Comment added successfully.');
    }
    // Update an existing comment
    public function updateComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        $comment = SubjectTeacherComment::findOrFail($id);
        $comment->update([
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Comment updated successfully.');
    }

    // Delete the comment
    public function destroyComment($id)
    {
        $comment = SubjectTeacherComment::findOrFail($id);
        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }


    //EXAM TYPES
    public function storeExamtype(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'weight' => 'required|numeric|min:1',
            'interval' => 'required|string|in:weekly,monthly,termly,topical',
        ]);

        // Create the new exam type
        $examType = new ExamType();
        $examType->name = $validatedData['name'];
        $examType->weight = $validatedData['weight'];
        $examType->interval = $validatedData['interval'];
        $examType->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Exam type added successfully.');
    }


    // update exam types
    public function updateExamtype(Request $request, $id)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'weight' => 'required|numeric|min:1',
            'interval' => 'required|string|in:weekly,monthly,termly,topical',
        ]);

        // Find the exam type by ID
        $examType = ExamType::findOrFail($id);

        // Update the exam type details
        $examType->name = $validatedData['name'];
        $examType->weight = $validatedData['weight'];
        $examType->interval = $validatedData['interval'];
        $examType->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Exam type updated successfully.');
    }
    // delete examType 
    public function destroyExamtype($id)
    {
        // Find the exam type by ID and delete it
        $examType = ExamType::findOrFail($id);
        $examType->delete();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Exam type deleted successfully.');
    }


    //EXAM FEES
    public function storeFee(Request $request)
    {
        // Validate and store the new fee
        $validated = $request->validate([
            'fee_type' => 'required|string|max:255',
            'interval' => 'required|string',
            'amount' => 'required|numeric',
            'student_type' => 'required|string',
            'account_id' => 'required|string',
            'status' => 'required|boolean',
        ]);

        // Create a new fee record
        Fee::create($validated);
        return redirect()->route('fees.index')->with('success', 'Fee added successfully.');
    }

    // updateFee
    public function updateFee(Request $request, $id)
    {
        // Validate the update request
        $validated = $request->validate([
            'fee_type' => 'required|string|max:255',
            'interval' => 'required|string',
            'amount' => 'required|numeric',
            'student_type' => 'required|string',
            'account_id' => 'required|string',
            'status' => 'required|boolean',
        ]);

        // Find the fee record and update it
        $fee = Fee::findOrFail($id);
        $fee->update($validated);

        return redirect()->route('fees.index')->with('success', 'Fee updated successfully.');
    }


    //delete
    public function destroyFee($id)
    {
        // Find the fee record and delete it
        $fee = Fee::findOrFail($id);
        $fee->delete();

        return redirect()->route('fees.index')->with('success', 'Fee deleted successfully.');
    }





    // ACADEMIC SESSION SETTINGS
    public function showSessionSettings()
    {
        // Fetch all academic sessions, ordered by the latest academic year, and paginated
        $academicSessions = AcademicSession::orderBy('academic_year', 'desc')->paginate(10);

        // Check if there is an active session
        $activeSession = AcademicSession::where('status', 'active')->first();

        // Pass the data to the view
        return view('backend.settings.academicSessions', [
            'academicSessions' => $academicSessions,
            'activeSession' => $activeSession
        ]);
    }

    // Method to store a new academic session
    public function storeAcademicSession(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'academic_year' => 'required|string|max:255',
            'term1_start' => 'required|date',
            'term1_end' => 'required|date|after_or_equal:term1_start',
            'term2_start' => 'required|date|after_or_equal:term1_end',
            'term2_end' => 'required|date|after_or_equal:term2_start',
            'term3_start' => 'required|date|after_or_equal:term2_end',
            'term3_end' => 'required|date|after_or_equal:term3_start',
        ]);

        // Create a new academic session
        AcademicSession::create([
            'academic_year' => $request->academic_year,
            'term1_start' => $request->term1_start,
            'term1_end' => $request->term1_end,
            'term2_start' => $request->term2_start,
            'term2_end' => $request->term2_end,
            'term3_start' => $request->term3_start,
            'term3_end' => $request->term3_end,
            'created_by' => auth()->id(), // Optional: Store the ID of the user creating the session
        ]);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Academic session created successfully.');
    }
    // edit academic sessions
    public function editAcademicSession($id)
    {
        // Fetch the academic session by ID
        $academicSession = AcademicSession::findOrFail($id);

        // Return the view with the academic session data
        return view('backend.settings.editAcademicSession', compact('academicSession'));
    }
    // update session
    public function updateAcademicSession(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'academic_year' => 'required|string|max:255',
            'term1_start' => 'required|date',
            'term1_end' => 'required|date|after_or_equal:term1_start',
            'term2_start' => 'required|date|after_or_equal:term1_end',
            'term2_end' => 'required|date|after_or_equal:term2_start',
            'term3_start' => 'required|date|after_or_equal:term2_end',
            'term3_end' => 'required|date|after_or_equal:term3_start',
        ]);

        // Find the academic session
        $academicSession = AcademicSession::findOrFail($id);

        // Update the academic session
        $academicSession->update([
            'academic_year' => $request->academic_year,
            'term1_start' => $request->term1_start,
            'term1_end' => $request->term1_end,
            'term2_start' => $request->term2_start,
            'term2_end' => $request->term2_end,
            'term3_start' => $request->term3_start,
            'term3_end' => $request->term3_end,
        ]);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Academic session updated successfully.');
    }

    // delete academic session
    public function destroyAcademicSession($id)
    {
        // Find the academic session
        $academicSession = AcademicSession::findOrFail($id);

        // Delete the academic session
        $academicSession->delete();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Academic session deleted successfully.');
    }
    


}
