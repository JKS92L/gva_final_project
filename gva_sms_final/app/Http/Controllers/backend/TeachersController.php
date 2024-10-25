<?php

namespace App\Http\Controllers\Backend;

use App\Models\Fee;
use App\Models\User;
use App\Models\Grade;
use App\Models\Hostel;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\UserRole;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller; // Import the base Controller class

class TeachersController extends Controller
{
    public function assignSubject()
    {
        return view('backend.teachers.assign-subject');
        // backend.user_management.user-list

    }

    public function assignResponsibility()
    {
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

    // MANAGE TEACHERS view & CRUD 
    public function viewTeachersList()
    {
        // Fetch teachers with their related user, subjects, and department
        $teachers = Teacher::with(['user.role', 'majorSubjects', 'minorSubjects', 'department'])->get();

        return view('backend.teachers.manage-teachers', compact('teachers'));
    }

    // teachers registration form
    public function viewTeachersRegForm()
    {
        $departments = Department::all();
        $grades = Grade::all();
        $fees = Fee::all();
        $users = Teacher::all(); // Fetch all users
        $hostels = Hostel::all(); // Fetch all hostels
        $roles = UserRole::all();
        $subjects = Subject::all();
        return view('backend.teachers.create-teacher', compact(
            'departments',
            'grades',
            'fees',
            'hostels',
            'roles',
            'subjects'
        ));
    }

    //teacher store
    public function storeTeachers(Request $request)
    {
        // Validate the form input
        $request->validate([
            'user_id' => 'exists:users,id',
            'username' => 'required|string|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'phoneNumber' => 'required|string|max:15',
            'firstname' => 'required|string|max:255',
            'middleName' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'certifications' => 'nullable|string|max:255',
            'dob' => 'required|date',
            'address' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'town' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'bankAccountNo' => 'required',
            'bankName' => 'required|nullable|string',
            'employeeId' => 'required|string|unique:teachers,employee_id',
            'hireDate' => 'required|date',
            'role_id' => 'required|exists:user_roles,id',
            'national_id' => 'required|string|max:20',
            'department' => 'required|exists:departments,id',
            'yearsExperience' => 'required|integer|min:0',
            'qualifications' => 'required|string|max:255',
            'major_subjects' => 'required|array',
            'minor_subjects' => 'required|array',
            'working_days_count' => 'required|integer|between:1,7',
            'working_time_start' => 'nullable|date_format:H:i',
            'working_time_end' => 'nullable|date_format:H:i|after:working_time_start',
            'profile_picture' => 'nullable|string',
            'emergencyContactName' => 'required|string|max:255',
            'emergencyContactRelation' => 'required|string|max:255',
            'emergencyContactPhone' => 'required|string|max:15'
        ]);

        try {
            // Start a transaction to ensure both user and teacher records are inserted together
            DB::beginTransaction();

            // Create the User first
            $user = User::create([
                'username' => $request->input('username'),
                'contact_number' => $request->input('phoneNumber'),
                'email' => $request->input('email'),
                'role_id' => $request->input('role_id'),
                'name' => $request->input('firstname') . ' ' . $request->input('lastname'),
                'password' => Hash::make('gva-staff'), // Default password
                'profile_picture' => $request->input('profile_picture') ?? null,
                'status' => 1, // Active status
            ]);

            // Create the Teacher using the user_id from the newly created User
            $teacher = Teacher::create([
                'user_id' => $user->id,  // Link the user_id to the teacher
                'first_name' => $request->input('firstname'),
                'middle_name' => $request->input('middleName') ?? null,
                'last_name' => $request->input('lastname'),
                'gender' => $request->input('gender'),
                'date_of_birth' => $request->input('dob'),
                'address' => $request->input('address'),
                'province' => $request->input('province'),
                'town' => $request->input('town'),
                'country' => $request->input('country'),
                'employee_id' => $request->input('employeeId'),
                'date_of_hire' => $request->input('hireDate'),
                'department_id' => $request->input('department'),
                'bank_account_no' => $request->input('bankAccountNo'),
                'bank_name' => $request->input('bankName'),
                'years_of_experience' => $request->input('yearsExperience'),
                'qualifications' => $request->input('qualifications'),
                'certifications' => $request->input('certifications') ?? null,
                'working_days' => $request->input('working_days_count'),
                'working_hours_start' => $request->input('working_time_start'),
                'working_hours_end' => $request->input('working_time_end'),
                'emergency_contact_name' => $request->input('emergencyContactName'),
                'emergency_contact_phone' => $request->input('emergencyContactPhone'),
                'emergency_contact_relation' => $request->input('emergencyContactRelation'),
                'national_id' => $request->input('national_id')
            ]);

            // Attach major subjects to the teacher
            $teacher->majorSubjects()->attach($request->input('major_subjects'));

            // Attach minor subjects to the teacher
            $teacher->minorSubjects()->attach($request->input('minor_subjects'));

            // Commit the transaction if all insertions succeed
            DB::commit();

            return redirect()->back()->with('success', 'Teacher added successfully!');
        } catch (\Illuminate\Database\QueryException $e) {
            // Rollback the transaction if any query fails
            DB::rollBack();

            // Log the detailed SQL error for debugging
            Log::error('SQL Error: ' . $e->getMessage());

            return redirect()->back()->withErrors([
                'error' => 'A database error occurred: ' . $e->getMessage(),
            ]);
        } catch (\Exception $e) {
            // Rollback the transaction if any other exception occurs
            DB::rollBack();

            // Log the general exception for debugging
            Log::error('Error: ' . $e->getMessage());

            return redirect()->back()->withErrors([
                'error' => 'An error occurred: ' . $e->getMessage(),
            ]);
        }
    }
    // edit teacher
    public function editTeacher($id)
    {
        // Fetch the teacher by ID
        $teacher = Teacher::findOrFail($id);

        // Fetch the required data
        $departments = Department::all();
        $subjects = Subject::all();
        $roles = UserRole::all();

        // Pass the data to the view 
        return view('backend.teachers.teachers-edit', compact('teacher', 'departments', 'subjects', 'roles'));
    }

    //update teacher
    public function updateTeacher(Request $request, $id)
    {
        // Find the teacher to get the associated user ID
        $teacher = Teacher::findOrFail($id);
        $user = $teacher->user;

        // Validate the request data
        $request->validate([
            'username' => 'required|string|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phoneNumber' => 'required|string|max:15',
            'firstname' => 'required|string|max:255',
            'middleName' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'certifications' => 'nullable|string|max:255',
            'dob' => 'required|date',
            'address' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'town' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'bankAccountNo' => 'required|integer|min:0',
            'bankName' => 'nullable|string',
            'employeeId' => 'required|string|unique:teachers,employee_id,' . $teacher->id,
            'hireDate' => 'required|date',
            'role_id' => 'required|exists:user_roles,id',
            'national_id' => 'required|string|max:20',
            'department' => 'required|exists:departments,id',
            'yearsExperience' => 'required|integer|min:0',
            'qualifications' => 'required|string|max:255',
            'major_subjects' => 'required|array',
            'minor_subjects' => 'required|array',
            'working_days_count' => 'required|integer|between:1,7',
            'working_time_start' => 'nullable|date_format:H:i',
            'working_time_end' => 'nullable|date_format:H:i|after:working_time_start',
            'profile_picture' => 'nullable|string',
            'emergencyContactName' => 'required|string|max:255',
            'emergencyContactRelation' => 'required|string|max:255',
            'emergencyContactPhone' => 'required|string|max:15'
        ]);

        try {
            // Start a transaction
            DB::beginTransaction();

            // Update the User details
            $user->update([
                'username' => $request->input('username'),
                'contact_number' => $request->input('phoneNumber'),
                'email' => $request->input('email'),
                'role_id' => $request->input('role_id'),
                'name' => $request->input('firstname') . ' ' . $request->input('lastname'),
                'profile_picture' => $request->input('profile_picture') ?? $user->profile_picture,
            ]);

            // Update the Teacher details
            $teacher->update([
                'first_name' => $request->input('firstname'),
                'middle_name' => $request->input('middleName') ?? null,
                'last_name' => $request->input('lastname'),
                'gender' => $request->input('gender'),
                'date_of_birth' => $request->input('dob'),
                'address' => $request->input('address'),
                'province' => $request->input('province'),
                'town' => $request->input('town'),
                'country' => $request->input('country'),
                'employee_id' => $request->input('employeeId'),
                'date_of_hire' => $request->input('hireDate'),
                'department_id' => $request->input('department'),
                'bank_account_no' => $request->input('bankAccountNo'),
                'bank_name' => $request->input('bankName'),
                'years_of_experience' => $request->input('yearsExperience'),
                'qualifications' => $request->input('qualifications'),
                'certifications' => $request->input('certifications') ?? null,
                'working_days' => $request->input('working_days_count'),
                'working_hours_start' => $request->input('working_time_start'),
                'working_hours_end' => $request->input('working_time_end'),
                'emergency_contact_name' => $request->input('emergencyContactName'),
                'emergency_contact_phone' => $request->input('emergencyContactPhone'),
                'emergency_contact_relation' => $request->input('emergencyContactRelation'),
                'national_id' => $request->input('national_id')
            ]);

            // Update major and minor subjects
            $teacher->majorSubjects()->sync($request->major_subjects);
            $teacher->minorSubjects()->sync($request->minor_subjects);

            // Commit the transaction
            DB::commit();

            return redirect()->route('teachers.list')->with('success', 'Teacher updated successfully.');
        } catch (\Exception $e) {
            // Rollback transaction if an error occurs
            DB::rollBack();
            Log::error('Error: ' . $e->getMessage());

            return redirect()->back()->withErrors([
                'error' => 'An error occurred: ' . $e->getMessage(),
            ]);
        }
    }






    // delete teacher
    public function destroyTeacher($id)
    {
        // Find the teacher by ID
        $teacher = Teacher::findOrFail($id);

        try {
            // Optionally: Delete associated user account and any other related records
            $teacher->user()->delete();

            // Delete the teacher record
            $teacher->delete();

            // Redirect with success message
            return
                redirect()->back()->with('success', 'Teacher deleted successfully!');
        } catch (\Exception $e) {
            // Handle the error and redirect back with an error message
            return
                redirect()->back()->with('error', 'Something went wrong to delete the teacher');
        }
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
