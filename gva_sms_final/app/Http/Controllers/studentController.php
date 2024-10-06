<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\User;
use App\Models\Grade;
use App\Models\Hostel;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Bedspace;
use App\Models\Department;
use App\Models\StudentParent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function studentDetails()
    {
        // Fetch all students with related data like grade, hostel, siblings, and guardians
        $students = Student::with(['grade', 'siblings', 'hostel'])->get();
        return view('backend.students.student-details', compact('students'));
    }

    public function studentAdmission()
    {
        return view('backend.students.student-admission');
    }

    public function onlineAdmission()
    {
        return view('backend.students.online-admission');
    }

    public function disableStudent()
    {
        return view('backend.students.disable-students');
    }

    public function bulkDelete()
    {
        return view('backend.students.bulk-delete');
    }

    public function studentCategories()
    {
        return view('backend.students.student-categories');
    }

    // Method to show the student registration form
    public function viewRegForm()
    {
        $departments = Department::all();
        $grades = Grade::all();
        $fees = Fee::all();
        $hostels = Hostel::all();

        return view('backend.students.student-register', compact('departments', 'grades', 'fees', 'hostels'));
    }

    // AJAX method to fetch bedspaces for the selected hostel
    public function fetchBedspaces(Request $request)
    {
        $bedspaces = Bedspace::where('hostel_id', $request->get('hostel_id'))->get();

        return response()->json([
            'status' => $bedspaces->isNotEmpty() ? 'success' : 'error',
            'bedspaces' => $bedspaces,
            'message' => $bedspaces->isNotEmpty() ? null : 'No bedspaces found.'
        ]);
    }

    // Store a new student and link siblings and parent (both nullable)
    public function store(Request $request)
    {
        // Validate request data including photo validation
        $request->validate([
            'ecz_no' => 'required|string|max:255',
            'class_id' => 'required|exists:grades,id',
            'student_type' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'gender' => 'required|string|max:10',
            'dob' => 'required|date',
            'nrc_id_no' => 'nullable|string|max:255',
            'religion' => 'nullable|string|max:255',
            'admission_date' => 'required|date',
            'medical_condition' => 'nullable|string|max:255',
            'hostel_id' => 'nullable|exists:hostels,hostel_id',
            'sibling_ids' => 'nullable|array',
            'student_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:4048', // Validate image
            'bedspace_id' => 'nullable|exists:bedspaces,id',
            'hostel_teacher_id' => 'nullable|exists:teachers,id',
            'father_name' => 'nullable|string|max:255',
            'father_phone' => 'nullable|string|max:15',
            'father_occupation' => 'nullable|string|max:255',
            'father_email' => 'nullable|email|max:255',
            'father_address' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'mother_phone' => 'nullable|string|max:15',
            'mother_occupation' => 'nullable|string|max:255',
            'mother_email' => 'nullable|email|max:255',
            'mother_address' => 'nullable|string|max:255',
            'fee_session_group_id' => 'nullable|exists:fees,fee_id',
            'username' => 'required|string|max:255|unique:students,username',
            'student_phone_number' => 'nullable|string|max:15',
            'student_email' => 'required|email|unique:students,student_email|max:255',
            'password' => 'required|string|min:4|confirmed'
        ]);

        DB::beginTransaction();

        try {
            // Handle the file upload (if a file was uploaded)
            $photoPath = null;
            if ($request->hasFile('student_photo')) {
                $photo = $request->file('student_photo');
                $photoPath = $photo->store('uploads/students', 'public'); // Store the photo in the 'public' disk
            }

            // Create or fetch the parent
            $parent = null;
            if ($request->input('father_name') || $request->input('mother_name')) {
                $parent = StudentParent::firstOrCreate(
                    ['father_name' => $request->input('father_name'), 'mother_name' => $request->input('mother_name')],
                    [
                        'father_phone' => $request->input('father_phone'),
                        'mother_phone' => $request->input('mother_phone'),
                        'father_email' => $request->input('father_email'),
                        'mother_email' => $request->input('mother_email'),
                        'father_address' => $request->input('father_address'),
                        'mother_address' => $request->input('mother_address'),
                    ]
                );
            }

            // Create the student record
            $student = Student::create([
                'ecz_no' => $request->input('ecz_no'),
                'class_id' => $request->input('class_id'),
                'student_type' => $request->input('student_type'),
                'firstname' => $request->input('firstname'),
                'lastname' => $request->input('lastname'),
                'other_name' => $request->input('other_name'),
                'gender' => $request->input('gender'),
                'dob' => $request->input('dob'),
                'nrc_id_no' => $request->input('nrc_id_no'),
                'religion' => $request->input('religion'),
                'admission_date' => $request->input('admission_date'),
                'medical_condition' => $request->input('medical_condition'),
                'hostel_id' => $request->input('hostel_id'),
                'sibling_ids' => $request->input('sibling_ids'),
                'student_photo' => $photoPath, // Save the photo path
                'bedspace_id' => $request->input('bedspace_id'),
                'hostel_teacher_id' => $request->input('hostel_teacher_id'),
                'parent_id' => $parent ? $parent->id : null,  // Nullable parent ID
                'username' => $request->input('username'),
                'student_phone_number' => $request->input('student_phone_number'),
                'student_email' => $request->input('student_email'),
                'password' => Hash::make($request->input('password')),  // Hash the password before saving
            ]);

            // If siblings are provided, link them
            if ($request->has('sibling_ids')) {
                foreach ($request->input('sibling_ids') as $siblingId) {
                    $sibling = Student::find($siblingId);
                    if ($sibling) {
                        $sibling->parent_id = $student->parent_id;
                        $sibling->save();
                    }
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Student registered successfully!');
        } catch (\PDOException $e) {
            // Rollback the transaction if there's an exception
            DB::rollBack();

            // Log and return the error
            Log::error('Database error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Database error: ' . $e->getMessage());
        } catch (\Exception $e) {
            DB::rollBack();

            // Log and return general error
            Log::error('An error occurred: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    // Other methods...
}
