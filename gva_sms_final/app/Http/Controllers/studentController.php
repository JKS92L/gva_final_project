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
use App\Models\Admissions;
use App\Models\Department;
use App\Models\StudentFee;
use App\Models\ParentDetail;
use Illuminate\Http\Request;
use App\Models\StudentParent;
use App\Helpers\CodeGenerator;
use App\Models\StudentSibling;
use App\Models\AcademicSession;
use Illuminate\Validation\Rule;
use App\Services\StudentService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\StudentHomePermission;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class StudentController extends Controller
{

    //fetch student By ID
    protected function fetchStudent($studentId)
    {
        return Student::with([
            'grade',                // Fetch the class/grade associated with the student
            'hostel',               // Fetch the hostel details
            'bedspace',             // Fetch the assigned bedspace
            'siblings',             // Fetch sibling relationships
            'user',                 // Fetch the related user (login details)
            'tuckshop_transactions', // Fetch tuck shop transactions
            'pocketMoneyAccount',   // Fetch pocket money account details
            'guardians',            // Fetch guardians (parents) through the pivot table
            'studentFee',          // Fetch fee details for the student
            'hostelTeacher'         // Fetch the hostel teacher
        ])->find($studentId);
    }

    // public function fetchStudentDetails()
    // {
    //     $students = Student::with(['grade', 'hostel', 'bedspace', 'guardians'])->get();

    //     // Attach sibling details for each student
    //     foreach ($students as $student) {
    //         // Fetch sibling IDs
    //         $siblingIds = StudentSibling::where('parent_id', function ($query) use ($student) {
    //             $query->select('parent_id')
    //             ->from('student_sibling')
    //             ->where('student_id', $student->id)
    //             ->limit(1);
    //         })
    //         ->where('student_id', '!=', $student->id)
    //         ->pluck('student_id')
    //         ->toArray();

    //         // Attach siblings as a relationship-like property
    //         $student->setRelation('siblings', Student::whereIn('id', $siblingIds)->get());
    //     }

    //     // Aggregated data for stats
    //     $stats = [
    //         'boarders' => Student::where('student_type', 'Boarder')->count(),
    //         'dayScholars' => Student::where('student_type', 'Day-Scholar')->count(),
    //         'boys' => Student::where('gender', 'male')->count(),
    //         'girls' => Student::where('gender', 'female')->count(),
    //     ];

    //     return view('backend.students.student-details', compact('students', 'stats'));
    // }

    public function viewStudentDetails()
    {
        $students = Student::with(['grade', 'hostel', 'bedspace', 'guardians'])->get();

        // Attach sibling details for each student
        foreach ($students as $student) {
            // Fetch sibling IDs
            $siblingIds = StudentSibling::where('parent_id', function ($query) use ($student) {
                $query->select('parent_id')
                    ->from('student_sibling')
                    ->where('student_id', $student->id)
                    ->limit(1);
            })
                ->where('student_id', '!=', $student->id)
                ->pluck('student_id')
                ->toArray();

            // Attach siblings as a relationship-like property
            $student->setRelation('siblings', Student::whereIn('id', $siblingIds)->get());
        }

        // Aggregated data for stats
        $stats = [
            'boarders' => Student::where('student_type', 'Boarder')->count(),
            'dayScholars' => Student::where('student_type', 'Day-Scholar')->count(),
            'boys' => Student::where('gender', 'male')->count(),
            'girls' => Student::where('gender', 'female')->count(),
        ];

        return view('backend.students.student-details', compact('students', 'stats'));
    }

    //Ajax call for registration form
    public function fetchGuardianDetails(Request $request)
    {
        $siblingId = $request->input('sibling_id');

        // Fetch sibling relationships to get parent IDs
        $parentIds = StudentSibling::where('student_id', $siblingId)->pluck('parent_id');

        // Fetch ParentDetail records related to the parents
        $guardians = ParentDetail::whereIn('user_id', $parentIds)
            ->with('user') // Load related User details
            ->get();

        $response = [];
        foreach ($guardians as $index => $guardian) {
            $response['guardian' . ($index + 1)] = [
                'name' => $guardian->user->name ?? null,
                'contact_number' => $guardian->user->contact_number ?? null,
                'email' => $guardian->user->email ?? null,
                'guardian_gender' => $guardian->guardian_gender ?? null,
                'occupation' => $guardian->occupation ?? null,
                'address' => $guardian->address ?? null,
            ];
        }

        return response()->json($response);
    }

    // student CRUD
    // //register a new student and related records

    //

    // public function storeEnrollmentRecord(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'username' => 'required|string|max:255|unique:users,username',
    //         'student_email' => 'required|email|unique:users,email|max:255',
    //         // Add other validations here...
    //     ]);

    //     DB::beginTransaction();
    //     try {
    //         // Perform your data processing logic here...

    //         DB::commit();
    //         return response()->json(['success' => true, 'message' => 'Enrollment record saved successfully.']);
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
    //     }
    // }

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
            'medical_condition' => 'nullable|string|max:255',
            'nrc_id_no' => 'nullable|string|max:255',
            'religion' => 'nullable|string|max:255',
            'bedspace_id' => 'nullable|exists:bedspaces,id',
            'hostel_id' => 'nullable|exists:hostels,id',

            // Guardian details
            'guardian1_name' => 'nullable|string|max:255',
            'guardian1_phone' => 'nullable|string|max:15',
            'guardian1_email' => 'nullable|email|max:255',
            'guardian1_gender' => 'nullable|string|max:255',
            'guardian1_occupation' => 'nullable|string|max:255',
            'guardian1_relationship' => 'nullable|string|max:255',
            'guardian1_address' => 'nullable|string|max:500',
            'guardian2_name' => 'nullable|string|max:255',
            'guardian2_phone' => 'nullable|string|max:15',
            'guardian2_email' => 'nullable|email|max:255',
            'guardian2_gender' => 'nullable|string|max:255',
            'guardian2_occupation' => 'nullable|string|max:255',
            'guardian2_relationship' => 'nullable|string|max:255',
            'guardian2_address' => 'nullable|string|max:500',

            // Sibling selection
            'sibling_id' => 'nullable|exists:students,id',

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

            // Update the bedspace status if a bedspace is assigned
            if ($request->filled('bedspace_id')) {
                $bedspace = Bedspace::findOrFail($request->input('bedspace_id'));
                $bedspace->update(['occupied_status' => 1]);
            }

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
                'religion' => $request->input('religion'),
                'nrc_id_no' => $request->input('nrc_id_no'),
                'medical_condition' => $request->input('medical_condition'),
                'bedspace_id' => $request->input('bedspace_id'),
                'hostel_id' => $request->input('hostel_id'),
                'student_photo' => $photoPath,
                'active_status' => 'enrolled',
            ]);

            // Handle sibling selection
            if ($request->filled('sibling_id')) {
                $siblingId = $request->input('sibling_id');

                // Fetch sibling's parent details
                $siblingParents = ParentDetail::where('student_id', $siblingId)->get();

                foreach ($siblingParents as $siblingParent) {
                    // Update parent details for the new student
                    ParentDetail::updateOrCreate(
                        [
                            'student_id' => $student->id,
                            'user_id' => $siblingParent->user_id,
                        ],
                        [
                            'relation' => $request->input('guardian1_relationship'), // Adjust as needed
                            'occupation' => $siblingParent->occupation,
                            'guardian_gender' => $siblingParent->guardian_gender,
                            'address' => $siblingParent->address,
                        ]
                    );

                    // Create sibling relationship
                    StudentSibling::updateOrCreate(
                        [
                            'student_id' => $student->id,
                            'parent_id' => $siblingParent->user_id,
                        ]
                    );
                }
            } else {
                // Handle new parent creation if no sibling is selected
                $guardianIds = [];

                foreach (['guardian1', 'guardian2'] as $guardian) {
                    if ($request->filled("{$guardian}_name")) {

                        $guardianUser = User::create([
                            'username' => $request->input("{$guardian}_name"),
                            'email' => $request->input("{$guardian}_email"),
                            'name' => $request->input("{$guardian}_name"),
                            'contact_number' => $request->input("{$guardian}_phone"),
                            'password' => Hash::make('defaultpassword'),
                            'role_id' => 4, // Guardian role
                            'status' => 1,
                        ]);

                        ParentDetail::create([
                            'user_id' => $guardianUser->id,
                            'student_id' => $student->id,
                            'relation' => $request->input("{$guardian}_relationship"),
                            'occupation' => $request->input("{$guardian}_occupation"),
                            'guardian_gender' => $request->input("{$guardian}_gender"),
                            'address' => $request->input("{$guardian}_address"),
                        ]);


                        $guardianIds[] = $guardianUser->id;
                    }
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



    // edit student view
    public function editStudent($id)
    {
        // Fetch the student with related data
        $student = Student::with([
            'user',                   // Fetch the associated user
            'grade',                  // Fetch the associated grade (class)
            'hostel',                 // Fetch the associated hostel
            'bedspace',               // Fetch the associated bedspace
            'siblings',               // Fetch siblings of the student
            'guardians',              // Fetch guardians (parent users)
            'studentFee',
        ])->findOrFail($id);

        // Fetch the guardians with additional details from ParentDetails
        $guardians = $student->guardians->map(function ($guardian) {
            $parentDetails = ParentDetail::where('user_id', $guardian->id)
                ->where('student_id', $guardian->pivot->student_id ?? null)
                ->first();

            return [
                'name' => $guardian->name ?? '',
                'contact_number' => $guardian->contact_number ?? '',
                'email' => $guardian->email ?? '',
                'occupation' => $parentDetails->occupation ?? '',
                'relationship' => $parentDetails->relation ?? '',
                'address' => $parentDetails->address ?? '',
                'guardian_gender' => $parentDetails->guardian_gender ?? '',
            ];
        });


        // Ensure guardian data is properly structured for the form
        $guardian1 = $guardians->get(0, []);
        $guardian2 = $guardians->get(1, []);

        // Fetch additional data required for the form
        $grades = Grade::all();
        $hostels = Hostel::all();
        $bedspaces = Bedspace::where('hostel_id', $student->hostel_id)->get();
        $fees = Fee::all();
        $students = Student::where('id', '!=', $id)->get();

        // Fetch siblings of the student from the `student_sibling` table
        $siblings = StudentSibling::where('parent_id', function ($query) use ($student) {
            $query->select('parent_id')
                ->from('student_sibling')
                ->where('student_id', $student->id)
                ->limit(1);
        })
            ->where(
                'student_id',
                '!=',
                $student->id
            )
            ->pluck('student_id')
            ->toArray();

        // Return the view with all required data compacted
        return view(
            'backend.students.edit-student',
            compact(
                'student',
                'grades',
                'hostels',
                'bedspaces',
                'students',
                'fees',
                'siblings',
                'guardian1',
                'guardian2'
            )
        );
    }
    //UPDATE STUDENT SECTIONS viewreg
    public function updateGeneralDetails($studentId, $data)
    {
        $validatedData = Validator::make($data, [
            'ecz_no' => 'nullable|numeric',
            'firstname' => 'required|string|max:255',
            'lastname' => 'nullable|string|max:255',
            'other_name' => 'nullable|string|max:255',
            'gender' => 'required|in:male,female',
            'dob' => 'required|date',
            'nrc_id_no' => 'nullable|string|max:20',
            'admission_date' => 'nullable|date',
            'medical_condition' => 'nullable|string|max:1000',
            'religion' => 'nullable|string|max:100',
            'class_id' => 'required|exists:grades,id',
            'student_type' => 'required|in:Day scholar,Boarder',
            'student_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ])->validate();

        $student = Student::find($studentId);

        if (!$student) {
            return redirect()->back()->withErrors(['error' => 'Student not found.']);
        }

        // Handle photo upload
        if (isset($data['student_photo']) && $data['student_photo']->isValid()) {
            $this->deleteOldPhoto($student->student_photo);
            $validatedData['student_photo'] = $this->uploadPhoto($data['student_photo']);
        }

        // Update student details
        $student->update($validatedData);

        // Update user's name field
        if ($student->user) { // Ensure the student has an associated user
            $fullName = trim("{$validatedData['firstname']} {$validatedData['lastname']}");
            $student->user->update(['name' => $fullName]);
        }

        return redirect()
            ->route('students.edit', $student->id)
            ->with('success', 'Student general details updated successfully.');
    }

    protected function deleteOldPhoto($photo)
    {
        if ($photo && Storage::exists('public/uploads/students/' . $photo)) {
            Storage::delete('public/uploads/students/' . $photo);
        }
    }

    protected function uploadPhoto($photo)
    {
        $photoPath = $photo->store('uploads/students', 'public');
        return basename($photoPath); // Return only the file name for storage in the database
    }


    public function updateHostelDetails($studentId, $data)
    {
        // Validate the input data
        $validatedData = Validator::make($data, [
            'hostel_id' => 'nullable|exists:hostels,id',
            'bedspace_id' => 'nullable|exists:bedspaces,id',
        ])->validate();

        // Find the student
        $student = Student::find($studentId);

        if (!$student) {
            return redirect()->back()->withErrors(['error' => 'Student not found.']);
        }

        // Validate hostel gender if provided
        if (isset($validatedData['hostel_id'])) {
            $hostel = Hostel::find($validatedData['hostel_id']);

            if (!$hostel) {
                return redirect()->back()->withErrors(['error' => 'Selected hostel not found.']);
            }

            if ($hostel->hostel_gender !== $student->gender) {
                return redirect()->back()->withErrors(['error' => 'Student gender does not match the selected hostel.']);
            }
        }

        // Check bedspace if provided
        if (isset($validatedData['bedspace_id'])) {
            $bedspace = Bedspace::find($validatedData['bedspace_id']);

            if (!$bedspace) {
                return redirect()->back()->withErrors(['error' => 'Selected bedspace not found.']);
            }

            if ($bedspace->hostel_id != $validatedData['hostel_id']) {
                return redirect()->back()->withErrors(['error' => 'Selected bedspace does not belong to the selected hostel.']);
            }

            // Check if the bedspace is already occupied
            if ($bedspace->occupied_status === 1) {
                return redirect()->back()->withErrors(['error' => 'Selected bedspace is already occupied.']);
            }
        }

        // Release the previous bedspace, if any
        if ($student->bedspace_id) {
            $previousBedspace = Bedspace::find($student->bedspace_id);
            if ($previousBedspace) {
                $previousBedspace->update(['occupied_status' => 0]); // Mark previous bedspace as not occupied
                $student->update(['bedspace_id' => null]); // Unassign bedspace from student
            }
        }

        // Update the student's hostel and bedspace
        $student->update([
            'hostel_id' => $validatedData['hostel_id'] ?? null,
            'bedspace_id' => $validatedData['bedspace_id'] ?? null,
        ]);

        // Update the selected bedspace as occupied
        if (isset($validatedData['bedspace_id'])) {
            $bedspace->update(['occupied_status' => 1]); // Mark as occupied
        }

        return redirect()
            ->route('students.edit', $student->id)
            ->with('success', 'Hostel and bedspace details updated successfully.');
    }
    public function updateGuardianDetails($studentId, array $data)
    {
        // Fetch the student record
        $student = Student::with('guardians')->findOrFail($studentId);

        // Fetch Guardians
        $guardians = $student->guardians;

        // Update Guardian 1
        if (isset($guardians[0])) {
            $guardian1 = $guardians[0];

            // Update Guardian 1 User table fields
            $guardian1->update([
                'name' => $data['guardian1_name'] ?? $guardian1->name,
                'contact_number' => $data['guardian1_phone'] ?? $guardian1->contact_number,
                'email' => $data['guardian1_email'] ?? $guardian1->email,
            ]);

            // Update Guardian 1 ParentDetails table fields
            $parentDetails1 = ParentDetail::where('user_id', $guardian1->id)
                ->where('student_id', $student->id)
                ->first();

            if ($parentDetails1) {
                $parentDetails1->update([
                    'guardian_gender' => $data['guardian1_gender'] ?? $parentDetails1->guardian_gender,
                    'relation' => $data['guardian1_relationship'] ?? $parentDetails1->relation,
                    'occupation' => $data['guardian1_occupation'] ?? $parentDetails1->occupation,
                    'address' => $data['guardian1_address'] ?? $parentDetails1->address,
                ]);
            }
        }

        // Update Guardian 2
        if (isset($guardians[1])) {
            $guardian2 = $guardians[1];

            // Update Guardian 2 User table fields
            $guardian2->update([
                'name' => $data['guardian2_name'] ?? $guardian2->name,
                'contact_number' => $data['guardian2_phone'] ?? $guardian2->contact_number,
                'email' => $data['guardian2_email'] ?? $guardian2->email,
            ]);

            // Update Guardian 2 ParentDetails table fields
            $parentDetails2 = ParentDetail::where('user_id', $guardian2->id)
                ->where('student_id', $student->id)
                ->first();

            if ($parentDetails2) {
                $parentDetails2->update([
                    'guardian_gender' => $data['guardian2_gender'] ?? $parentDetails2->guardian_gender,
                    'relation' => $data['guardian2_relationship'] ?? $parentDetails2->relation,
                    'occupation' => $data['guardian2_occupation'] ?? $parentDetails2->occupation,
                    'address' => $data['guardian2_address'] ?? $parentDetails2->address,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Guardian details updated successfully.');
    }


    public function updateFeeDetails($studentId, $data)
    {
        // Fetch the student record
        $student = Student::findOrFail($studentId);

        // Extract selected fee IDs from the data
        $selectedFeeIds = $data['fee_session_group_id'] ?? [];

        // Fetch existing fee IDs associated with the student
        $existingFeeIds = $student->studentFee->pluck('fee_id')->toArray();

        // Determine which fees to add
        $feesToAdd = array_diff($selectedFeeIds, $existingFeeIds);

        // Determine which fees to remove
        $feesToRemove = array_diff($existingFeeIds, $selectedFeeIds);

        // Add new fees to the student
        foreach ($feesToAdd as $feeId) {
            StudentFee::create([
                'student_id' => $student->id,
                'fee_id' => $feeId,
            ]);
        }

        // Remove unselected fees
        if (!empty($feesToRemove)) {
            StudentFee::where('student_id', $student->id)
                ->whereIn('fee_id', $feesToRemove)
                ->delete();
        }

        return redirect()->back()->with('success', 'Student  Fees updated successfully.');
    }


    public function updateLoginDetails($studentId, $data)
    {
        // Fetch the student and associated user
        $student = Student::with('user')->findOrFail($studentId);

        $user = $student->user;

        if (!$user) {
            throw new Exception('Associated user not found for this student.');
        }

        // Update the User's login details
        $user->update([
            'username' => $data['username'] ?? $user->username,
            'contact_number' => $data['student_phone_number'] ?? $user->contact_number,
            'email' => $data['student_email'] ?? $user->email,
        ]);

        return redirect()->back()->with('success', 'Student  Login details updated successfully.');
    }



    public function updateStudentAllSection(Request $request, $studentId)
    {
        $section = $request->input('section');
        $data = $request->except('_token', '_method', 'section');

        $student = $this->fetchStudent($studentId);
        if (!$student) {
            return redirect()->back()->withErrors(['error' => 'Student not found.']);
        }

        //cleaner switch using an array map for each section to the method
        $methods = [
            'generalDetails' => 'updateGeneralDetails',
            'studentHostels' => 'updateHostelDetails',
            'studentGuardian' => 'updateGuardianDetails',
            'studentFees' => 'updateFeeDetails',
            'studentLoginDetails' => 'updateLoginDetails',
        ];

        if (!isset($methods[$section])) {
            return redirect()->back()->withErrors(['error' => 'Invalid section provided.']);
        }

        return $this->{$methods[$section]}($studentId, $data);
    }

    public function destroyStudent($id)
    {
        DB::transaction(function () use ($id) {
            // Fetch the student and associated user
            $student = Student::with('user', 'bedspace')->findOrFail($id);

            // Set bedspace as unoccupied if the student is associated with one
            if ($student->bedspace) {
                $student->bedspace->update(['occupied_status' => 0]);
            }

            // Delete related records from ParentDetails table
            ParentDetail::where('student_id', $student->id)->delete();

            // Delete related records from StudentSibling table
            StudentSibling::where('student_id', $student->id)->delete();

            // Delete related records from StudentFee table
            StudentFee::where('student_id', $student->id)->delete();

            // Delete the associated user if it exists
            if ($student->user) {
                $student->user->delete();
            }

            // Delete the student
            $student->delete();
        });

        return redirect()->route('student-details')->with('success', 'Student and all related records deleted successfully');
    }


    //STUDENT ADMISSION METHODS
    public function viewTermlyAdmissions()
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

        $students = Student::with(['grade', 'hostel', 'bedspace', 'guardians'])->get();

        // Attach sibling details for each student
        foreach ($students as $student) {
            // Fetch sibling IDs
            $siblingIds = StudentSibling::where('parent_id', function ($query) use ($student) {
                $query->select('parent_id')
                    ->from('student_sibling')
                    ->where('student_id', $student->id)
                    ->limit(1);
            })
                ->where('student_id', '!=', $student->id)
                ->pluck('student_id')
                ->toArray();

            // Attach siblings as a relationship-like property
            $student->setRelation('siblings', Student::whereIn('id', $siblingIds)->get());
        }

        // Aggregated data for stats
        // $stats = [
        //     'boarders' => Student::where('student_type', 'Boarder')->count(),
        //     'dayScholars' => Student::where('student_type', 'Day-Scholar')->count(),
        //     'boys' => Student::where('gender', 'male')->count(),
        //     'girls' => Student::where('gender', 'female')->count(),
        // ];
        return view('backend.students.student-admission', compact('students', 'terms'));
    }
    public function storeStudentHomePermission(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'student_id' => 'required|exists:students,id',
            'academic_term' => 'required|string', // Validate as string for splitting
            'permission_start' => 'required|date',
            'permission_end' => 'required|date|after_or_equal:permission_start',
            'pickup_time' => 'required',
            'pickup_person' => 'required|in:parent,other',
            'parent_id' => 'nullable|exists:users,id',
            'other_name' => 'nullable|string|max:255',
            'other_nrc' => 'nullable|string|max:255',
            'other_contact' => 'nullable|string|max:255',
            'vehicle_reg' => 'nullable|string|max:255',
            'reason' => 'required|string',
            'deputy_comment' => 'nullable|string',
            'approved_by' => 'required|string|max:255',
        ]);

        // Extract academic year ID and term number
        if (!str_contains($request->input('academic_term'), '-')) {
            return back()->with('error', 'Invalid academic term format.');
        }

        [$academicYearId, $termId] = explode('-', $request->input('academic_term'));

        // Prepare data for insertion
        $data = [
            'student_id' => $request->input('student_id'),
            'academic_year_id' => $academicYearId,
            'academic_term_no' => $termId,
            'permission_start' => $request->input('permission_start'),
            'permission_end' => $request->input('permission_end'),
            'pickup_time' => $request->input('pickup_time'),
            'pickup_person' => $request->input('pickup_person'),
            'parent_id' => $request->input('parent_id'),
            'other_name' => $request->input('other_name'),
            'other_nrc' => $request->input('other_nrc'),
            'other_contact' => $request->input('other_contact'),
            'vehicle_reg' => $request->input('vehicle_reg'),
            'reason' => $request->input('reason'),
            'deputy_comment' => $request->input('deputy_comment'),
            'approved_by' => $request->input('approved_by'),
        ];

        // Insert data into the database
        StudentHomePermission::create($data);

        // Redirect with success message
        return redirect()->route('student.termly.admission')
        ->with('success', 'Student home permission created successfully.');
    }







    //STUDENT ENROLLMENT METHODS
    public function viewEnrollmentProcess()
    {
        $grades = Grade::all();
        $fees = Fee::all();
        $hostels = Hostel::all();
        // Eager load the grades with students
        $students = Student::with('grade', 'admissions', 'guardians', 'siblings')->get();
        return view('backend.students.enrollment-process', compact('grades', 'fees', 'hostels', 'students'));
    }
    public function storeEnrollmentRecord(Request $request)
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
            'medical_condition' => 'nullable|string|max:255',
            'nrc_id_no' => 'nullable|string|max:255',
            'religion' => 'nullable|string|max:255',

            // Guardian details
            'guardian1_name' => 'nullable|string|max:255',
            'guardian1_phone' => 'nullable|string|max:15',
            'guardian1_email' => 'nullable|email|max:255',
            'guardian1_gender' => 'nullable|string|max:255',
            'guardian1_occupation' => 'nullable|string|max:255',
            'guardian1_relationship' => 'nullable|string|max:255',
            'guardian1_address' => 'nullable|string|max:500',
            'guardian2_name' => 'nullable|string|max:255',
            'guardian2_phone' => 'nullable|string|max:15',
            'guardian2_email' => 'nullable|email|max:255',
            'guardian2_gender' => 'nullable|string|max:255',
            'guardian2_occupation' => 'nullable|string|max:255',
            'guardian2_relationship' => 'nullable|string|max:255',
            'guardian2_address' => 'nullable|string|max:500',

            // Sibling selection
            'sibling_id' => 'nullable|exists:students,id',

            // Fee selection
            'fee_session_group_id' => 'nullable|array',
            'fee_session_group_id.*' => 'exists:fees,id',
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
                'religion' => $request->input('religion'),
                'nrc_id_no' => $request->input('nrc_id_no'),
                'medical_condition' => $request->input('medical_condition'),
                'student_photo' => $photoPath,
                'active_status' => 'pending',
            ]);

            // Generate a unique admission ID
            $admissionId = CodeGenerator::uniqueAdmissionID(Admissions::class, 'admission_id');

            // Create admission record
            Admissions::create([
                'admission_id' => $admissionId,
                'student_id' => $student->id,
            ]);

            // Handle sibling selection
            if ($request->filled('sibling_id')) {
                $siblingId = $request->input('sibling_id');
                $siblingParents = ParentDetail::where('student_id', $siblingId)->get();

                foreach ($siblingParents as $siblingParent) {
                    ParentDetail::updateOrCreate(
                        [
                            'student_id' => $student->id,
                            'user_id' => $siblingParent->user_id,
                        ],
                        [
                            'relation' => $request->input('guardian1_relationship'),
                            'occupation' => $siblingParent->occupation,
                            'guardian_gender' => $siblingParent->guardian_gender,
                            'address' => $siblingParent->address,
                        ]
                    );

                    StudentSibling::updateOrCreate(
                        [
                            'student_id' => $student->id,
                            'parent_id' => $siblingParent->user_id,
                        ]
                    );
                }
            } else {
                // Handle new parent creation if no sibling is selected
                $guardianIds = [];

                foreach (['guardian1', 'guardian2'] as $guardian) {
                    if ($request->filled("{$guardian}_name")) {
                        $guardianUser = User::create([
                            'username' => $request->input("{$guardian}_name"),
                            'email' => $request->input("{$guardian}_email"),
                            'name' => $request->input("{$guardian}_name"),
                            'contact_number' => $request->input("{$guardian}_phone"),
                            'password' => Hash::make('gva-guardian'),
                            'role_id' => 4, // Guardian role
                            'status' => 1,
                        ]);

                        ParentDetail::create([
                            'user_id' => $guardianUser->id,
                            'student_id' => $student->id,
                            'relation' => $request->input("{$guardian}_relationship"),
                            'occupation' => $request->input("{$guardian}_occupation"),
                            'guardian_gender' => $request->input("{$guardian}_gender"),
                            'address' => $request->input("{$guardian}_address"),
                        ]);

                        $guardianIds[] = $guardianUser->id;
                    }
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
            return redirect()->back()->with('success', 'Enrollment record saved successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error occurred: ' . $e->getMessage());
            return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);
        }
    }
    public function studentAdmissionApprove(Request $request, $id)
    {
        try {
            $request->validate([
                'apptude_score' => 'required|integer|min:50|max:100',
            ]);

            $admission = Admissions::where('student_id', $id)->firstOrFail();
            $admission->update([
                'apptude_score' => $request->apptude_score,
                'reject_reasons' => 'PASSED',
            ]);

            $student = Student::findOrFail($id);
            $student->update([
                'active_status' => 'enrolled',
                'admission_date' => now(), // Sets the current date and time
            ]);


            return redirect()->back()->with('success', 'Student enrollment approved successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while approving the student enrollment.');
        }
    }

    public function studentAdmissionReject(Request $request, $id)
    {
        try {
            $request->validate([
                'reject_reasons' => 'required|string|max:250',
                'apptude_score' => 'required|integer|max:49',
            ]);

            $admission = Admissions::where('student_id', $id)->firstOrFail();
            $admission->update([
                'apptude_score' => $request->apptude_score,
                'reject_reasons' => $request->reject_reasons,
            ]);

            $student = Student::findOrFail($id);
            $student->update([
                'active_status' => 'rejected',
                'admission_date' => null, // Sets admission_date to null for rejected students
            ]);


            return redirect()->back()->with('success', 'Student enrollment rejected successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while rejecting the student enrollment.');
        }
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
    //Add also the logic to only fetch the unoccupied bedspaces from this method:
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
    //


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

        // Fetch only unoccupied bedspaces for the given hostel ID
        $bedspaces = Bedspace::where('hostel_id', $request->get('hostel_id'))
            ->where('occupied_status', 0)
            ->get();

        return response()->json([
            'status' => $bedspaces->isNotEmpty() ? 'success' : 'error',
            'bedspaces' => $bedspaces,
            'message' => $bedspaces->isNotEmpty() ? null : 'No unoccupied bedspaces found for the selected hostel.',
        ]);
    }






    ///add more methods
}
