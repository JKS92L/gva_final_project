<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Fee;
use App\Models\User;
use App\Models\Grade;
use App\Models\Hostel;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Bedspace;
use App\Models\Department;
use App\Models\StudentFee;
use App\Models\ParentDetail;
use Illuminate\Http\Request;
use App\Models\StudentParent;
use App\Models\StudentSibling;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    // public function studentDetails()
    // {
    //     // Fetch all students with related data like grade, hostel, siblings, and guardians
    //     $students = Student::with(['grade', 'siblings', 'hostel', 'bedspace', 'parent'])->get();
    //     return view('backend.students.student-details', compact('students'));
    // }

    public function studentDetails()
    {
        $students = Student::with(['grade', 'siblings', 'hostel', 'bedspace', 'parent'])->get();
        return view('backend.students.student-details', compact('students'));
    }






    // student CRUD
    public function editStudent($id)
    {
        // Fetch the student with related data (grade, siblings, hostel, bedspace, parent) and user data
        $student = Student::with(['grade', 'siblings', 'hostel', 'bedspace', 'parent', 'user'])
            ->findOrFail($id);

        // Fetch the user associated with the student
        $user = $student->user; // Assuming the User model is defined with the proper relationship

        // Fetch all grades for the class dropdown
        $grades = Grade::all();

        // Fetch all hostels for the hostel dropdown
        $hostels = Hostel::all();

        // Fetch bedspaces for the selected hostel
        $bedspaces = Bedspace::where('hostel_id', $student->hostel_id)->get();

        // Fetch all students excluding the current one for the siblings select field
        $students = Student::where('id', '!=', $id)->get();

        // Fetch all fees and decode the fee_session_group_id JSON
        $fees = Fee::all();
        $selectedFeeIds = json_decode($student->fee_session_group_id, true) ?? []; // Default to an empty array if null

        // Fetch the siblings of the current student
        $siblings = Student::whereHas('siblings', function ($query) use ($id) {
            $query->where('student_id', $id);
        })->get();

        // Return the edit view with the student and user data, and other necessary data
        return view('backend.students.edit-student', compact('student', 'user', 'grades', 'hostels', 'bedspaces', 'students', 'fees', 'selectedFeeIds', 'siblings'));
    }



    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $student->update($request->all());
        return redirect()->route('student-details')->with('success', 'Student updated successfully');
    }
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        return redirect()->route('student-details')->with('success', 'Student deleted successfully');
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
        // Eager load the grades with students
        $students = Student::with('grade')->get();

        return view('backend.students.student-register', compact('departments', 'grades', 'fees', 'hostels', 'students'));
    }


    //AJAX method call - fetch hostels by gender
    public function getHostelsByGender($gender)
    {
        // Fetch active hostels filtered by gender
        $hostels = Hostel::active()->where('hostel_gender', strtolower($gender))->get();

        // Return the hostels as JSON response
        return response()->json($hostels);
    }

    // AJAX method to fetch bedspaces for the selected hostel
    public function fetchBedspaces(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'hostel_id' => 'required|exists:hostels,id',
        ]);

        // Fetch bedspaces for the given hostel ID
        $bedspaces = Bedspace::where('hostel_id', $request->get('hostel_id'))->get();

        return response()->json([
            'status' => $bedspaces->isNotEmpty() ? 'success' : 'error',
            'bedspaces' => $bedspaces,
            'message' => $bedspaces->isNotEmpty() ? null : 'No bedspaces found for the selected hostel.',
        ]);
    }



    // //register a new student and related records
    public function storeStudentAndParentDetails(Request $request)
    {
        // Validate request data
        $request->validate([
            // User fields
            'username' => 'required|string|max:255|unique:users,username',
            'student_email' => 'required|email|unique:users,email|max:255',
            'student_phone_number' => 'nullable|string|max:15',

            // Student fields
            'ecz_no' => 'required|string|max:255',
            'class_id' => 'required|exists:grades,id',
            'student_type' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'gender' => 'required|string|max:10',
            'dob' => 'required|date',
            'admission_date' => 'required|date',

            // Guardian details
            'guardian1_name' => 'nullable|string|max:255',
            'guardian1_phone' => 'nullable|string|max:15',
            'guardian1_email' => 'nullable|email|max:255|unique:users,email',
            'guardian1_occupation' => 'nullable|string|max:255',
            'guardian1_relationship' => 'nullable|string|max:255',
            'guardian1_address' => 'nullable|string|max:500',
            'guardian2_name' => 'nullable|string|max:255',
            'guardian2_phone' => 'nullable|string|max:15',
            'guardian2_email' => 'nullable|email|max:255|unique:users,email',
            'guardian2_occupation' => 'nullable|string|max:255',
            'guardian2_relationship' => 'nullable|string|max:255',
            'guardian2_address' => 'nullable|string|max:500',

            // Sibling selection
            'sibling_ids' => 'nullable|array',
            'sibling_ids.*' => 'exists:students,id', // Ensure sibling IDs are valid

            // Fee selection
            'fee_session_group_id' => 'nullable|array',
            'fee_session_group_id.*' => 'exists:fees,id', // Ensure fee IDs are valid
        ]);

        DB::beginTransaction();

        try {
            // Handle student profile picture if provided
            $photoPath = $request->hasFile('student_photo')
                ? $request->file('student_photo')->store('uploads/students', 'public')
                : null;

            // Create student user account
            $user = User::create([
                'username' => $request->input('username'),
                'email' => $request->input('student_email'),
                'contact_number' => $request->input('student_phone_number'),
                'name' => $request->input('firstname') . ' ' . $request->input('lastname'),
                'password' => Hash::make('gva-student'),
                'role_id' => 3, // Student role ID
                'profile_picture' => $photoPath,
                'status' => 1,
            ]);

            // Create student record
            $student = Student::create([
                'user_id' => $user->id,
                'ecz_no' => $request->input('ecz_no'),
                'class_id' => $request->input('class_id'),
                'student_type' => $request->input('student_type'),
                'firstname' => $request->input('firstname'),
                'lastname' => $request->input('lastname'),
                'gender' => $request->input('gender'),
                'dob' => $request->input('dob'),
                'admission_date' => $request->input('admission_date'),
                'student_photo' => $photoPath,
            ]);

            // Handle siblings
            if ($request->filled('sibling_ids')) {
                $siblingParentIds = StudentSibling::whereIn('student_id', $request->input('sibling_ids'))
                    ->pluck('parent_id')
                    ->unique();

                foreach ($siblingParentIds as $parentId) {
                    StudentSibling::create([
                        'student_id' => $student->id,
                        'parent_id' => $parentId,
                    ]);
                }
            } else {
                // If no siblings, handle new parent creation
                $guardianIds = [];

                if ($request->filled('guardian1_name')) {
                    $guardian1 = User::create([
                        'username' => $request->input('guardian1_name'),
                        'email' => $request->input('guardian1_email'),
                        'name' => $request->input('guardian1_name'),
                        'contact_number' => $request->input('guardian1_phone'),
                        'password' => Hash::make('defaultpassword'), // Default password
                        'role_id' => 4, // Guardian role
                        'status' => 1,
                    ]);

                    ParentDetail::create([
                        'user_id' => $guardian1->id,
                        'student_id' => $student->id,
                        'relation' => $request->input('guardian1_relationship'),
                        'occupation' => $request->input('guardian1_occupation'),
                        'address' => $request->input('guardian1_address'),
                    ]);

                    $guardianIds[] = $guardian1->id;
                }

                if ($request->filled('guardian2_name')) {
                    $guardian2 = User::create([
                        'username' => $request->input('guardian2_name'),
                        'email' => $request->input('guardian2_email'),
                        'name' => $request->input('guardian2_name'),
                        'contact_number' => $request->input('guardian2_phone'),
                        'password' => Hash::make('gva-parent'),
                        'role_id' => 4,
                        'status' => 1,
                    ]);

                    ParentDetail::create([
                        'user_id' => $guardian2->id,
                        'student_id' => $student->id,
                        'relation' => $request->input('guardian2_relationship'),
                        'occupation' => $request->input('guardian2_occupation'),
                        'address' => $request->input('guardian2_address'),
                    ]);

                    $guardianIds[] = $guardian2->id;
                }

                foreach ($guardianIds as $parentId) {
                    StudentSibling::create([
                        'student_id' => $student->id,
                        'parent_id' => $parentId,
                    ]);
                }
            }

            // Handle fees
            if ($request->filled('fee_session_group_id')) {
                $feeData = [];
                foreach ($request->input('fee_session_group_id') as $feeId) {
                    $feeData[] = [
                        'student_id' => $student->id,
                        'fee_id' => $feeId,
                    ];
                }
                StudentFee::insert($feeData);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Student, related details, and fees registered successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error occurred: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }


    ///add more methods
}
