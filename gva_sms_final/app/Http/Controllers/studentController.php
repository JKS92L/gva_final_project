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
        $students = Student::with(['grade', 'siblings', 'hostel', 'bedspace', 'parent'])->get();
        return view('backend.students.student-details', compact('students'));
    }

    // student CRUD
    public function edit($id)
    {
        // Fetch the student with related data (grade, siblings, hostel, bedspace, parent) and user data
        $student = Student::with(['grade', 'siblings', 'hostel', 'bedspace', 'parent', 'user'])
        ->findOrFail($id);

        // Fetch the user associated with the student
        $user = $student->user; // Assuming the User model is defined with the proper relationship

        // Fetch all grades for the class dropdown
        $grades = Grade::all();

        // Fetch all hostels for the hostel dropdown
        $hostels = Hostel::all(); // Ensure you have a Hostel model

        // Fetch bedspaces for the selected hostel
        $bedspaces = Bedspace::where('hostel_id', $student->hostel_id)->get(); // Assuming bedspaces have a 'hostel_id' column

        // Fetch all students for the siblings select field
        $students = Student::where('sibling_ids', '!=', $id)->get(); // Get all students except the current one

        // Fetch all fees and decode the fee_session_group_id JSON
        $fees = Fee::all(); // Fetch all fees
        // Decode the fee_session_group_id JSON, ensuring it's always an array
        $selectedFeeIds = json_decode($student->fee_session_group_id, true) ?? []; // Default to an empty array if null


        // Return the edit view with the student and user data, and other necessary data
        return view('backend.students.edit', compact('student', 'user', 'grades', 'hostels', 'bedspaces', 'students', 'fees', 'selectedFeeIds'));
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

    //register a new student
    public function store(Request $request)
    {
        // Validate request data including photo validation
        $request->validate([
            // User table fields
            'username' => 'required|string|max:255|unique:users,username',
            'student_email' => 'required|email|unique:users,email|max:255',
            'student_phone_number' => 'nullable|string|max:15',
            'password' => 'required|string|min:4|confirmed',

            // Student table fields
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
            'student_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:4048',
            'bedspace_id' => 'nullable|exists:bedspaces,id',
            'hostel_teacher_id' => 'nullable|exists:teachers,id',

            // Parent table fields
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
        ]);

        DB::beginTransaction();

        try {
            // Handle file upload (if photo exists)
            $photoPath = $request->hasFile('student_photo') ? $request->file('student_photo')->store('uploads/students', 'public') : null;

            // Create student user account in the 'users' table
            $user = User::create([
                'username' => $request->input('username'),
                'contact_number' => $request->input('student_phone_number'),
                'email' => $request->input('student_email'),
                'role_id' => 3, // Student role ID
                'name' => $request->input('firstname') . ' ' . $request->input('lastname'),
                'password' => Hash::make($request->input('password')),
                'profile_picture' => $photoPath,
                'status' => 1, // Active status
            ]);

            // Create student record in the 'students' table
            $student = Student::create([
                'user_id' => $user->id,
                'ecz_no' => $request->input('ecz_no'),
                'class_id' => $request->input('class_id'),
                'student_type' => $request->input('student_type'),
                'firstname' => $request->input('firstname'),
                'lastname' => $request->input('lastname'),
                'gender' => $request->input('gender'),
                'dob' => $request->input('dob'),
                'nrc_id_no' => $request->input('nrc_id_no'),
                'religion' => $request->input('religion'),
                'admission_date' => $request->input('admission_date'),
                'medical_condition' => $request->input('medical_condition'),
                'hostel_id' => $request->input('hostel_id'),
                'sibling_ids' => json_encode($request->input('sibling_ids', [])),
                'student_photo' => $photoPath,
                'bedspace_id' => $request->input('bedspace_id'),
                'hostel_teacher_id' => $request->input('hostel_teacher_id'),
            ]);

            // Handle sibling linking and check if parent should be disabled
            if (!empty($request->input('sibling_ids'))) {
                // Link siblings and fetch the parent from the first sibling
                $this->linkSiblings($request->input('sibling_ids'), $student);
            } else {
                // Create or link parent record in the 'parents' table
                $parent = $this->createOrUpdateParent($request, $student);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Student and parent registered successfully!');
        } catch (\PDOException $e) {
            DB::rollBack();
            Log::error('Database error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Database error: ' . $e->getMessage());
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('An error occurred: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Create or update the parent record in the 'parents' and 'users' table.
     */
    protected function createOrUpdateParent($request, $student)
    {
        // Check if parent exists by email (father or mother)
        $parent = StudentParent::where('father_email', $request->input('father_email'))
            ->orWhere('mother_email', $request->input('mother_email'))
            ->first();

        if (!$parent) {
            // First, create the parent user account
            $parentUser = User::create([
                'username' => $request->input('father_email') ?: $request->input('mother_email'),
                'email' => $request->input('father_email') ?: $request->input('mother_email'),
                'contact_number' => $request->input('mother_phone') . '/' . $request->input('father_phone'),
                'role_id' => 5, // Parent role ID
                'name' => $request->input('father_name') ?: $request->input('mother_name'),
                'password' => Hash::make('gva-sms'), // Set default password, to be updated by parent
                'status' => 1, // Active status
            ]);

            // Now create the parent record and insert the user_id from the created user
            $parent = StudentParent::create([
                'user_id' => $parentUser->id, // Associate with the user created above
                'student_ids' => json_encode([$student->id]), // Insert student ID
                'father_name' => $request->input('father_name'),
                'mother_name' => $request->input('mother_name'),
                'father_phone' => $request->input('father_phone'),
                'mother_phone' => $request->input('mother_phone'),
                'father_email' => $request->input('father_email'),
                'mother_email' => $request->input('mother_email'),
                'father_address' => $request->input('father_address'),
                'mother_address' => $request->input('mother_address'),
            ]);
        }

        // Set the parent_id in the student record
        $student->parent_id = $parent->id;
        $student->save();

        return $parent;
    }


    /**
     * Link siblings to the same parent.
     **/
    protected function linkSiblings(array $siblingIds, $student)
    {
        if (count($siblingIds) > 0) {
            // Assume the first sibling has the correct parent (use the first sibling's parent_id)
            $firstSibling = Student::find($siblingIds[0]);

            if ($firstSibling && $firstSibling->parent_id) {
                // Set the new student's parent_id to that of the first sibling
                $student->parent_id = $firstSibling->parent_id;
                $student->save();
            }

            // Link the newly registered student ID to each existing sibling's sibling_ids
            foreach ($siblingIds as $siblingId) {
                $sibling = Student::find($siblingId);
                if ($sibling) {
                    // Decode the existing sibling_ids from JSON
                    $currentSiblingIds = json_decode($sibling->sibling_ids, true) ?? [];

                    // Check if the new student's ID is already in the array to avoid duplicates
                    if (!in_array($student->id, $currentSiblingIds)) {
                        // Add the new student's ID to the sibling_ids
                        $currentSiblingIds[] = $student->id;

                        // Encode the array back to JSON and save it
                        $sibling->sibling_ids = json_encode($currentSiblingIds);
                        $sibling->save();
                    }

                    // Optionally, ensure the sibling shares the same parent_id
                    if ($sibling->parent_id !== $student->parent_id) {
                        $sibling->parent_id = $student->parent_id;
                        $sibling->save();
                    }
                }
            }
        }
    }
}
