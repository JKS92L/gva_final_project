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
use App\Rules\ValidTime;
use App\Models\Admissions;
use App\Models\Department;
use App\Models\StudentFee;
use App\Models\ParentDetail;
use App\Models\SessionTerms;
use App\Models\TermlyReport;
use Illuminate\Http\Request;
use App\Models\StudentParent;
use App\Helpers\CodeGenerator;
use App\Models\FeeCatergories;
use App\Models\PermissionLogs;
use App\Models\StudentClearIn;
use App\Models\StudentSibling;
use App\Helpers\AcademicHelper;
use App\Models\AcademicSession;
use App\Models\StudentClearOut;
use Illuminate\Validation\Rule;
use App\Services\StudentService;
use Illuminate\Support\Facades\DB;
use App\Models\studentDisciplinary;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\StudentHomePermission;
use App\Models\StudentSchoolTransfer;
use App\Models\StudentCheckInCheckOut;
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
                            'password' => Hash::make('gva-guardian'),
                            'role_id' => 5, // Guardian role
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
        $fees = FeeCatergories::all();
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
            'student_type' => 'required|in:day,boarder',
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


    //STUDENT DISCIPLINARY METHOD

    public function viewStudentDisciplinaryAction()
    {
        // Fetch students with related details and disciplinary records
        $students = Student::with([
            'grade',
            'disciplinaries' => function ($query) {
                $query->with('academicYear')->orderBy('incident_date', 'desc');
            }
        ])->get();

        return view('backend.students.student-disciplinary', compact('students'));
    }

    public function approveStudentDisciplinary(Request $request, $id)
    {
        $disciplinary = studentDisciplinary::findOrFail($id);
        $disciplinary->update([
            'status' => 'Approved',
            'comments' => $request->input('comments'),
            'approved_by' => auth()->user()->name, // Assuming user authentication
            'approval_date' => now(),
        ]);

        return redirect()->back()->with('success', 'Disciplinary action approved successfully.');
    }

    public function rejectStudentDisciplinary(Request $request, $id)
    {
        $disciplinary = studentDisciplinary::findOrFail($id);
        $disciplinary->update([
            'status' => 'Rejected',
            'comments' => $request->input('comments'),
        ]);

        return redirect()->back()->with('success', 'Disciplinary action rejected successfully.');
    }

    public function withdrawStudentDisciplinary(Request $request, $id)
    {
        $disciplinary = studentDisciplinary::findOrFail($id);
        $disciplinary->update([
            'status' => 'Withdrawn',
            'comments' => $request->input('comments'),
        ]);

        return redirect()->back()->with('success', 'Disciplinary action withdrawn successfully.');
    }
    public function deleteStudentDisciplinary($id)
    {
        $disciplinary = studentDisciplinary::findOrFail($id);

        // Optionally, delete attachments if stored
        if (!empty($disciplinary->attachments)) {
            foreach ($disciplinary->attachments as $file) {
                Storage::disk('public')->delete($file);
            }
        }

        $disciplinary->delete();

        return redirect()->back()->with('success', 'Disciplinary record deleted successfully.');
    }


    public function viewstudentDisciplinaryform()
    {
        // Fetch active academic sessions, sorted by the newest year first
        $academicYears = AcademicSession::with(['terms' => function ($query) {
            $query->select('id', 'term_number', 'academic_year_id')->orderBy('term_number', 'asc');
        }])
            ->select('id', 'academic_year')
            ->orderBy('academic_year', 'desc')
            ->get();

        // Fetch terms (from SessionTerms)
        $terms = SessionTerms::select('id', 'term_number', 'academic_year_id')->orderBy('term_number', 'asc')->get();


        // Fetch students with related check-ins and clearances, including hostel and bedspace
        $students = Student::with([
            'checkIns.hostel',
            'checkIns.bedspace',
            'clearIns',
            'latestCheckInCheckout',
            'guardians',
            'grade',
            'homePermissions'
        ])->get();

        // dd($students);
        return view('backend.students.student-disciplinary-case-form', compact('students',  'academicYears'));
    }

    public function storeStudentDisciplinaryAction(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'student_name' => 'required|exists:students,id',
            'incident_date' => 'required|date',
            'incident_time' => ['required', new ValidTime],
            'incident_location' => 'required|string|max:255',
            'reported_by' => 'required|string|max:255',
            'incident_description' => 'required|string',
            'disciplinary_action' => 'required|in:Warning,Suspension,Expulsion,Punishment',
            
            'suspension_start_date' => 'nullable|date',
            'suspension_end_date' => 'nullable|date|after_or_equal:suspension_start_date',
            'action_date' => 'required|date',
            'action_taken_by' => 'required|string|max:255',
            'action_description' => 'required|string',
            'academic_term' => 'required|string|regex:/^\d+-\d+$/',
            'attachments.*' => 'nullable|file|mimes:jpeg,png,pdf,doc,docx|max:2048',
        ]);

        // Parse academic_term into academic_year_id and term_no
        [$academic_year_id, $term_no] = explode('-', $validated['academic_term']);

        // Ensure directory exists
        $directoryPath = 'disciplinary/attachments';
        if (!Storage::disk('public')->exists($directoryPath)) {
            Storage::disk('public')->makeDirectory($directoryPath);
        }

        // Handle file uploads if any
        $attachments = [];
        $originalAttachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                if ($file->isValid()) {
                    // Generate a unique name for storage
                    $uniqueName = uniqid() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs($directoryPath, $uniqueName, 'public');

                    // Save original file name and unique path
                    $attachments[] = $path;
                    $originalAttachments[] = $file->getClientOriginalName();
                } else {
                    return redirect()->back()->withErrors(['attachments' => 'One or more files could not be uploaded.']);
                }
            }
        } else {
            return redirect()->back()->withErrors(['attachments' => 'No files were uploaded. Please upload at least one file.']);
        }

        // Create a new disciplinary record
        studentDisciplinary::create([
            'student_id' => $validated['student_name'],
            'incident_date' => $validated['incident_date'],
            'incident_time' => $validated['incident_time'],
            'incident_location' => $validated['incident_location'],
            'reported_by' => $validated['reported_by'],
            'incident_description' => $validated['incident_description'],
            'disciplinary_action' => $validated['disciplinary_action'],
            'suspension_start_date' => $validated['suspension_start_date'],
            'suspension_end_date' => $validated['suspension_end_date'],
            'action_date' => $validated['action_date'],
            'action_taken_by' => $validated['action_taken_by'],
            'action_description' => $validated['action_description'],
            'attachments' => $attachments, // Unique file paths stored
            'original_attachments_name' => $originalAttachments, // Store original names
            'status' => 'Pending',
            'academic_year_id' => $academic_year_id,
            'term_no' => $term_no,
        ]);

        // Redirect with success message
        return redirect()->back()->with('success', 'Disciplinary action submitted for review.');
    }

    //redirect to view disciplinary attachments
    public function viewAttachments($id)
    {
        $disciplinary = studentDisciplinary::with('student')->findOrFail($id);

        $attachments = $disciplinary->attachments;
        $originalAttachments = $disciplinary->original_attachments_name; // Adjusted field name
        $studentName = $disciplinary->student->firstname . ' ' . $disciplinary->student->lastname ?? 'Unknown'; // Get student name
        $className = $disciplinary->student->grade->gradeno . ' ' . $disciplinary->student->grade->class_name ?? 'Unknown'; // Get class name

        return view('backend.students.student-disciplinary-attachments', compact(
            'attachments',
            'originalAttachments',
            'studentName',
            'className'
        ));
    }



    //STUDENT TRANSFER RECORD METHODS
    public function viewStudentTransfer()
    {
        // Fetch academic years (from AcademicSession)
        $academicYears = AcademicSession::with(['terms' => function ($query) {
            $query->select('id', 'term_number', 'academic_year_id')->orderBy('term_number', 'asc');
        }])
            ->select('id', 'academic_year')
            ->orderBy('academic_year', 'desc')
            ->get();

        // Fetch terms (from SessionTerms)
        $terms = SessionTerms::select('id', 'term_number', 'academic_year_id')->orderBy('term_number', 'asc')->get();

        // Fetch all students with related data
        $allStudents = Student::with(['grade', 'guardians', 'siblings', 'admissions.academicSession', 'admissions.term', 'transfers.academicYear'])
            ->get();

        return view('backend.students.student-transfers', compact('academicYears', 'terms', 'allStudents'));
    }
    public function approveStudentSchoolTransfer($id)
    {
        $transfer = StudentSchoolTransfer::findOrFail($id);

        // Approve the transfer and set the approver's ID
        $transfer->status = 'Approved';
        $transfer->approved_by = auth()->user()->id; // Store the user's ID, not the name
        $transfer->approval_date = now(); // Set the approval date
        $transfer->save(); // Save the changes

        return redirect()->back()->with('success', 'Transfer approved successfully.');
    }

    public function updateStudentSchoolTransfer(Request $request, $id)
    {
        $request->validate([
            'new_school' => 'required|string|max:255',
            'transfer_date' => 'required|date',
            'status' => 'required|in:Pending,Approved,Rejected',
        ]);

        $transfer = StudentSchoolTransfer::findOrFail($id);
        $transfer->new_school = $request->new_school;
        $transfer->transfer_date = $request->transfer_date;
        $transfer->status = $request->status;
        $transfer->save();

        return redirect()->back()->with('success', 'Transfer details updated successfully.');
    }
    public function destroyStudentSchoolTransfe($id)
    {
        $transfer = StudentSchoolTransfer::findOrFail($id);
        $transfer->delete();

        return redirect()->back()->with('success', 'Transfer deleted successfully.');
    }














    //student store sch transfer
    public function storeStudentSchoolTransfer(Request $request)
    {
        $request->validate([
            'academic_term' => 'required|string', // Format: academic_year_id-term_no (e.g., "1-2")
            'student_id' => 'required|integer|exists:students,id',
            'new_school' => 'required|string|max:255',
            'transfer_date' => 'required|date',
            'status' => 'required|in:Pending,Approved,Rejected',
        ]);

        // Parse academic_term into academic_year_id and term_no
        $academicTermParts = explode('-', $request->academic_term);

        if (count($academicTermParts) !== 2) {
            return redirect()->back()->withErrors(['academic_term' => 'Invalid academic term format.']);
        }

        $academicYearId = (int) $academicTermParts[0];
        $termNo = (int) $academicTermParts[1];

        // Prepare data for storing
        $data = [
            'academic_year_id' => $academicYearId,
            'term_no' => $termNo,
            'student_id' => $request->student_id,
            'new_school' => $request->new_school,
            'transfer_date' => $request->transfer_date,
            'status' => $request->status,
        ];

        // If status is 'Approved', add the logged-in user's id to 'approved_by'
        if ($request->status === 'Approved') {
            $data['approved_by'] = auth()->id(); // Store the logged-in user's ID
            $data['approval_date'] = now(); // Optionally, store the approval date
        }

        // Store the data in the database
        StudentSchoolTransfer::create($data);

        return redirect()->back()->with('success', 'Student transfer recorded successfully!');
    }


    //STUDENT PERMISSIONS
    public function viewStudentPermissions()
    {
        // Fetch academic years and other required data
        $academicYearsWithTerms = AcademicHelper::getActiveAcademicYearsWithTerms();
        $hostels = Hostel::all();
        $bedspaces = Bedspace::all();

        // Fetch students with related data and eager load permissions and logs
        $students = Student::with([
            'checkIns.hostel',
            'checkIns.bedspace',
            'clearIns',
            'guardians',
            'grade',
            'homePermissions.logs', // Include logs relationship
            'termlyReports.academicYear',
        ])->get();

        return view('backend.students.student-permissions', compact('students', 'academicYearsWithTerms', 'bedspaces', 'hostels'));
    }


    public function storeStudentHomePermission(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'student_id' => 'required|exists:students,id',
            'academic_term' => 'required|string',
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
            'permission_status' => 'required|string|max:255',
            'approved_by' => 'required|string|max:255',
            'hostel_id' => 'nullable|exists:hostels,id',
            'bedspace_id' => 'nullable|exists:bedspaces,id',
        ]);

        // Extract academic year ID and term number
        if (!str_contains($request->input('academic_term'), '-')) {
            return back()->with('error', 'Invalid academic term format.');
        }

        [$academicYearId, $academicTermNo] = explode('-', $request->input('academic_term'));
        $studentId = $request->input('student_id');

        // Prepare data for insertion into student_home_permissions
        $data = [
            'student_id' => $studentId,
            'academic_year_id' => $academicYearId,
            'academic_term_no' => $academicTermNo,
            'permission_start' => $request->input('permission_start'),
            'permission_end' => $request->input('permission_end'),
            'pickup_time' => $request->input('pickup_time'),
            'pickup_person' => $request->input('pickup_person'),
            'reason' => $request->input('reason'),
            'deputy_comment' => $request->input('deputy_comment'),
            'permission_status' => $request->input('permission_status'),
            'approved_by_id' => $request->input('approved_by'),
        ];

        // Insert into student_home_permissions
        $permission = StudentHomePermission::create($data);

        // Insert into permission_logs
        PermissionLogs::create([
            'permission_id' => $permission->id,
            'student_id' => $studentId,
            // 'staff_id' => Auth::id(),
            'role_name' => 'student', // Assuming the logged-in user is a staff member
            'permission_status' => $request->input('permission_status'),
        ]);

        // Additional logic based on permission status
        if ($request->input('permission_status') === 'permission_granted') {
            // Fetch the student to determine their type and assigned hostel/bedspace
            $student = Student::with('checkIns')->find($studentId);

            if ($student) {
                if ($student->student_type === 'Boarder') {
                    // Insert into student_checkIn_checkout for boarders
                    StudentCheckInCheckOut::create([
                        'student_id' => $studentId,
                        'academic_year_id' => $academicYearId,
                        'academic_term_no' => $academicTermNo,
                        'hostel_id' => $request->input('hostel_id'),
                        'bedspace_id' => $request->input('bedspace_id'),
                        'room_status' => 'checked_out',
                    ]);
                }

                // Insert into termly_report for both boarders and dayscholars
                TermlyReport::create([
                    'academic_year_id' => $academicYearId,
                    'term_number' => $academicTermNo,
                    'student_id' => $studentId,
                    'reported_date' => now()->toDateString(),
                    'report_status' => 'reported_out',
                    'reported_by' => Auth::id(),
                ]);
            }

            // Insert into student_clear_out_details
            StudentClearOut::create([
                'student_id' => $studentId,
                'academic_year_id' => $academicYearId,
                'academic_term_no' => $academicTermNo,
                'clear_out_person' => $request->input('pickup_person'),
                'check_out_time' => $request->input('pickup_time'),
                'parent_id' => $request->input('pickup_person') === 'parent' ? $request->input('parent_id') : null,
                'other_name' => $request->input('pickup_person') === 'other' ? $request->input('other_name') : null,
                'other_nrc' => $request->input('pickup_person') === 'other' ? $request->input('other_nrc') : null,
                'other_contact' => $request->input('pickup_person') === 'other' ? $request->input('other_contact') : null,
                'vehicle_reg' => $request->input('vehicle_reg'),
                'pickup_by_relationship' => $request->input('pickup_person'),
                'cleared_by' => Auth::id(),
                'brought_by_name' => $request->input('other_name'),
                'brought_by_contact' => $request->input('other_contact'),
                'brought_by_nrc' => $request->input('other_nrc'),
                'brought_vehicle_reg' => $request->input('vehicle_reg'),
            ]);
        }

        // Redirect with success message
        return redirect()->route('student.permissions')
            ->with('success', 'Student home permission created successfully.');
    }

    public function updateStudentPermission(Request $request, $studentId)
    {
        $request->validate([
            'permission_status' => 'required|string',
            'permission_start' => 'nullable|date',
            'permission_end' => 'nullable|date|after_or_equal:permission_start',
            'reason' => 'nullable|string|max:255',
        ]);

        $permissionData = [
            'student_id' => $studentId,
            'permission_status' => $request->input('permission_status'),
            'permission_start' => $request->input('permission_start'),
            'permission_end' => $request->input('permission_end'),
            'reason' => $request->input('reason'),
            'approved_by_id' => auth()->id(), // Assuming the user making the change is the approver
        ];

        StudentHomePermission::updateOrCreate(
            ['student_id' => $studentId],
            $permissionData
        );

        return redirect()->back()->with('success', 'Permission updated successfully.');
    }


    public function fetchStudentPermissionsByYearAndStatus(Request $request)
    {
        $academicYearId = $request->input('academic_year_id');
        $term = $request->input('term');
        $status = $request->input('permission_status');

        // Fetch students with related data and filter by permissions
        $students = Student::with([
            'checkIns.hostel',
            'checkIns.bedspace',
            'clearIns',
            'guardians',
            'grade',
            'homePermissions' => function ($query) use ($academicYearId, $term) {
                $query->where('academic_year_id', $academicYearId)
                    ->where('academic_term_no', $term)
                    ->with('academicYear', 'logs'); // Include academicYear and logs
            },
            'termlyReports.academicYear',
        ])->whereHas('homePermissions.logs', function ($query) use ($status) {
            $query->where('permission_status', $status);
        })->get();

        // Map the data
        $students = $students->map(function ($student) {
            $homePermission = $student->homePermissions->last(); // Fetch latest permission
            $latestLog = $homePermission ? $homePermission->logs->last() : null; // Get latest log

            // Include additional data
            $student->latest_permission_status = $latestLog ? $latestLog->permission_status : 'not_permitted';
            $student->enrolled_year = $homePermission && $homePermission->academicYear
                ? $homePermission->academicYear->academic_year
                : 'Not enrolled';
            $student->enrolled_term = $homePermission ? $homePermission->academic_term_no : 'N/A';

            return $student;
        });

        return response()->json(['students' => $students]);
    }


    public function destroyStudentPermission($id)
    {
        // Find the record in the student_home_permissions table by ID
        $permission = StudentHomePermission::find($id);

        // Check if the record exists
        if (!$permission) {
            return redirect()->back()->with('error', 'Permission record not found.');
        }

        // Delete the record
        $permission->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Permission record deleted successfully.');
    }

    //STUDENT TERMLY REPORTS
    public function viewStudentTermlyReport()
    {
        // Fetch academic years (from AcademicSession)
        $academicYears = AcademicSession::with(['terms' => function ($query) {
            $query->select('id', 'term_number', 'academic_year_id')->orderBy('term_number', 'asc');
        }])
            ->select('id', 'academic_year')
            ->orderBy('academic_year', 'desc')
            ->get();

        $hostels = Hostel::all();
        $bedspaces = Bedspace::all();

        // Prepare terms in the sorted order
        // Fetch terms (from SessionTerms)
        $terms = SessionTerms::select('id', 'term_number', 'academic_year_id')->orderBy('term_number', 'asc')->get();

        // Fetch students with related check-ins and clearances, including hostel and bedspace
        $students = Student::with([
            'checkIns.hostel',
            'checkIns.bedspace',
            'clearIns',
            'latestCheckInCheckout',
            'guardians',
            'grade',
            'homePermissions',
            'termlyReports.academicYear' // Eager load academicYear in termlyReports
        ])->get();

        //dd($students);
        return view('backend.students.student-termly-admission', compact('students', 'academicYears', 'terms', 'bedspaces', 'hostels'));
    }
    //AJAX
    public function fetchStudentTermlyReport(Request $request) //---NOT BEING USED FOR NOW ---
    {
        $academicTerm = $request->input('academic_term');

        if ($academicTerm && strpos($academicTerm, '-') !== false) {
            [$yearId, $termNumber] = explode('-', $academicTerm);

            $students = Student::with([
                'checkIns.hostel',
                'checkIns.bedspace',
                'clearIns',
                'latestCheckInCheckout',
                'grade',
                'termlyReports.academicYear', //eager loarding - made by kj
                'termlyReports' => function ($query) use ($yearId, $termNumber) {
                    $query->where('academic_year_id', $yearId)
                        ->where('term_number', $termNumber);
                },
            ])
                ->whereHas('termlyReports', function ($query) use ($yearId, $termNumber) {
                    $query->where('academic_year_id', $yearId)
                        ->where('term_number', $termNumber);
                })
                ->get();
        } else {
            // Fetch all students without filtering
            $students = Student::with([
                'checkIns.hostel',
                'checkIns.bedspace',
                'clearIns',
                'latestCheckInCheckout',
                'grade',
                'termlyReports.academicYear',
            ])->get();
        }

        return response()->json([
            'students' => $students,
        ]);
    }

    public function getParentsByStudentId(Request $request)
    {
        $studentId = $request->query('student_id');

        if (!$studentId) {
            return response()->json(['success' => false, 'message' => 'Student ID is required.'], 400);
        }

        $parents = ParentDetail::where('student_id', $studentId)
            ->with('user:id,name,contact_number') // Include user details
            ->get()
            ->map(function ($parent) {
                return [
                    'user_id' => $parent->user->id,
                    'name' => $parent->user->name,
                    'contact_number' => $parent->user->contact_number,
                ];
            });

        if ($parents->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No parents found.'], 404);
        }

        return response()->json(['success' => true, 'parents' => $parents]);
    }

    //store dayscholars report for the term
    public function storeDayscholarStudentTermlyReport(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'academic_term' => 'required|string',
            'students' => 'required|array|min:1',
            'reported_date' => 'required|date',
            'report_status' => 'required|in:reported_in,reported_out',
        ]);

        // Extract year ID and term number from 'academic_term'
        [$yearId, $termNumber] = explode('-', $request->academic_term);

        $loggedInUserId = Auth::id();
        $errors = []; // To collect any validation errors for duplicate entries

        foreach ($validatedData['students'] as $studentId) {
            $student = Student::findOrFail($studentId);

            // Check if the student is a boarder
            if ($student->student_type === 'Boarder') {
                $errors[] = "Student {$student->firstname} {$student->lastname} cannot be admitted as they are a Boarder. Use the Checkin buttons for Boarders.";
                continue;
            }

            // Check if the student has already been reported for the same term, year, and status
            $existingReport = TermlyReport::where('academic_year_id', $yearId)
                ->where('term_number', $termNumber)
                ->where('student_id', $studentId)
                ->where('report_status', $request->report_status) // Check for status as well
                ->exists();

            if ($existingReport) {
                $academicYear = AcademicSession::find($yearId)->academic_year ?? 'Unknown Year';
                $term = $termNumber; // Assuming term number is directly usable

                $errors[] = "Student {$student->firstname} {$student->lastname} has already been reported as '{$request->report_status}' for Academic Year {$academicYear} - Term {$term}.";
                continue;
            }


            // Save each student's termly report
            TermlyReport::create([
                'academic_year_id' => $yearId,
                'term_number' => $termNumber,
                'student_id' => $student->id,
                'reported_date' => $request->reported_date,
                'reported_by' => $loggedInUserId,
                'report_status' => $request->report_status,
            ]);
        }

        // If there are any errors, redirect back with errors
        if (!empty($errors)) {
            return redirect()->back()->withErrors(['students' => $errors]);
        }

        // Redirect on success
        return redirect()->route('student.termly.report')->with('success', 'Students admitted successfully for the term.');
    }

    public function storeStudentCheckIn(Request $request)
    {
        // Validate the input data
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'academic_term' => 'required|string',
            'clearIn_person' => 'required|string',
            'check_in_time' => 'required|date_format:H:i',
            'other_name' => 'nullable|string|max:255',
            'other_nrc' => 'nullable|string',
            'vehicle_reg' => 'nullable|string',
            'parent_id' => 'nullable|exists:users,id',
            'other_contact' => 'nullable|string|max:15|regex:/^[0-9+\s()-]+$/',
            'pickup_by_relationship' => 'nullable|string|max:255',
            'cleared_by' => 'required|exists:users,id',
            'hostel_id' => 'nullable|exists:hostels,id',
            'bedspace_id' => 'nullable|exists:bedspaces,id',
        ]);

        // Extract academic year ID and term number
        if (strpos($request->input('academic_term'), '-') === false) {
            return back()->with('error', 'Invalid academic term format.');
        }

        [$academicYearId, $academicTermNo] = explode('-', $request->input('academic_term'));

        // Validate extracted values
        if (!is_numeric($academicYearId)) {
            return back()->with('error', 'Invalid academic term values.');
        }

        // Check for duplication in StudentClearIn
        // $existingCheckIn = StudentClearIn::where('student_id', $request->input('student_id'))
        // ->where('academic_year_id', $academicYearId)
        // ->where('academic_term_no', $academicTermNo)
        // ->exists();

        // if ($existingCheckIn) {
        //     return back()->with('error', 'This student has already been cleared in for the selected academic year and term.');
        // }

        // Process checkbox inputs
        $checkboxes = ['clearance_accounts', 'clearance_secretary', 'clearance_search', 'clearance_patron'];
        $processedCheckboxes = [];
        foreach ($checkboxes as $checkbox) {
            $processedCheckboxes[$checkbox] = filter_var($request->input($checkbox, false), FILTER_VALIDATE_BOOLEAN);
        }

        // Handle already assigned hostel/bedspace
        $studentId = $request->input('student_id');
        $student = Student::with(['hostel', 'bedspace', 'homePermissions'])->findOrFail($studentId);

        if ($student->hostel || $student->bedspace) {
            return back()->with('error', 'This student is already assigned to a hostel or bedspace.');
        }

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Store the check-in data
            StudentClearIn::create(array_merge($processedCheckboxes, [
                'student_id' => $studentId,
                'academic_year_id' => $academicYearId,
                'academic_term_no' => $academicTermNo,
                'check_in_time' => $request->input('check_in_time'),
                'brought_by_name' => $request->input('other_name'),
                'other_nrc' => $request->input('other_nrc'),
                'brought_vehicle_reg' => $request->input('vehicle_reg'),
                'brought_by_contact' => $request->input('other_contact'),
                'parent_id' => $request->input('parent_id'),
                'brought_by_relationship' => $request->input('brought_by_relationship'),
                'cleared_by' => Auth::id(),
            ]));

            // Insert into StudentCheckInCheckOut
            StudentCheckInCheckOut::create([
                'student_id' => $studentId,
                'academic_year_id' => $academicYearId,
                'academic_term_no' => $academicTermNo,
                'hostel_id' => $request->input('hostel_id'),
                'bedspace_id' => $request->input('bedspace_id'),
                'room_status' => 'checked_in',
            ]);

            // Update Bedspace occupied status
            $bedspace = Bedspace::findOrFail($request->input('bedspace_id'));
            $bedspace->update(['occupied_status' => 1]);

            // Insert into Termly Report
            TermlyReport::create([
                'academic_year_id' => $academicYearId,
                'term_number' => $academicTermNo,
                'student_id' => $studentId,
                'reported_date' => now()->toDateString(),
                'report_status' => 'reported_in',
                'reported_by' => Auth::id(),
            ]);

            // Insert permission log for "permission_expired"
            $latestPermission = $student->homePermissions->last();
            if ($latestPermission) {
                PermissionLogs::create([
                    'permission_id' => $latestPermission->id,
                    'student_id' => $studentId,
                    // 'staff_id' => Auth::id(),
                    'role_name' => 'student',
                    'permission_status' => PermissionLogs::STATUS_PERMISSION_EXPIRED,
                ]);
            }

            // Commit the transaction
            DB::commit();

            return redirect()->back()->with('success', 'Student checked in, termly report updated, and permission log updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Check-in failed: ' . $e->getMessage(), [
                'student_id' => $studentId,
                'academic_term_id' => $academicYearId,
                'academic_term_no' => $academicTermNo,
                'hostel_id' => $request->input('hostel_id'),
                'bedspace_id' => $request->input('bedspace_id'),
            ]);

            return back()->with('error', 'An error occurred during the check-in process. Please contact support.');
        }
    }

    //for dayscholars
    public function storeStudentCheckOut(Request $request)
    {
        // Validate the input data
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'academic_term' => 'required|string',
            'clearOut_person' => 'required|string',
            'check_out_time' => 'required|date_format:H:i',
            'other_name' => 'nullable|string|max:255',
            'other_nrc' => 'nullable|string',
            'vehicle_reg' => 'nullable|string',
            'parent_id' => 'nullable|exists:users,id',
            'other_contact' => 'nullable|string|max:15|regex:/^[0-9+\s()-]+$/',
            'pickup_by_relationship' => 'nullable|string|max:255',
            'cleared_by' => 'required|exists:users,id',
            'hostel_id' => 'nullable|exists:hostels,id',
            'bedspace_id' => 'nullable|exists:bedspaces,id',
        ]);

        // Extract academic year ID and term number
        if (strpos($request->input('academic_term'), '-') === false) {
            return back()->with('error', 'Invalid academic term format.');
        }

        [$academicYearId, $academicTermNo] = explode('-', $request->input('academic_term'));

        if (!is_numeric($academicYearId)) {
            return back()->with('error', 'Invalid academic term values.');
        }

        // Prevent duplication of student clear out
        $existingClearOut = StudentClearOut::where('student_id', $request->input('student_id'))
            ->where('academic_year_id', $academicYearId)
            ->where('academic_term_no', $academicTermNo)
            ->exists();

        if ($existingClearOut) {
            return back()->with('error', 'This student has already been cleared out for the selected academic year and term.');
        }

        // Validate the student's active check-in record
        $studentId = $request->input('student_id');
        $student = Student::with(['checkIns.hostel', 'checkIns.bedspace'])->findOrFail($studentId);

        $activeCheckIn = $student->checkIns->last();
        if (!$activeCheckIn || (!$activeCheckIn->hostel && !$activeCheckIn->bedspace)) {
            return back()->with('error', 'This student does not have an assigned hostel or bedspace.');
        }

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Store the check-out data
            StudentClearOut::create([
                'student_id' => $studentId,
                'academic_year_id' => $academicYearId,
                'academic_term_no' => $academicTermNo,
                'clear_out_person' => $request->input('clearOut_person'),
                'check_out_time' => $request->input('check_out_time'),
                'hostel_id' => $request->input('hostel_id') ?? $activeCheckIn->hostel_id,
                'bedspace_id' => $request->input('bedspace_id') ?? $activeCheckIn->bedspace_id,
                'parent_id' => $request->input('parent_id'),
                'other_name' => $request->input('other_name'),
                'other_nrc' => $request->input('other_nrc'),
                'other_contact' => $request->input('other_contact'),
                'vehicle_reg' => $request->input('vehicle_reg'),
                'pickup_by_relationship' => $request->input('pickup_by_relationship'),
                'cleared_by' => $request->input('cleared_by'),
            ]);

            // Update Termly Report with student check-out
            TermlyReport::create([
                'academic_year_id' => $academicYearId,
                'term_number' => $academicTermNo,
                'student_id' => $studentId,
                'reported_date' => now()->toDateString(),
                'report_status' => 'reported_out',
                'reported_by' => Auth::id(),
            ]);

            // Insert into StudentCheckInCheckOut
            StudentCheckInCheckOut::create([
                'student_id' => $studentId,
                'hostel_id' => $request->input('hostel_id') ?? $activeCheckIn->hostel_id,
                'bedspace_id' => $request->input('bedspace_id') ?? $activeCheckIn->bedspace_id,
                'academic_year_id' => $academicYearId,
                'academic_term_no' => $academicTermNo,
                'room_status' => 'checked_out',
                'timestamp' => now(),
            ]);

            // Free the bedspace (set as unoccupied)
            if ($activeCheckIn->bedspace) {
                Bedspace::where('id', $activeCheckIn->bedspace->id)->update(['occupied_status' => 0]);
            }

            // Commit the transaction
            DB::commit();

            return redirect()->back()->with('success', 'Student checked out successfully.');
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Check-out failed: ' . $e->getMessage(), [
                'student_id' => $studentId,
                'academic_term_id' => $academicYearId,
                'academic_term_no' => $academicTermNo,
                'hostel_id' => $request->input('hostel_id'),
                'bedspace_id' => $request->input('bedspace_id'),
            ]);

            return back()->with('error', 'An error occurred during the check-out process. Please contact support.');
        }
    }

    //student checkin and out for dayscholars
    public function storeDayscholarStudentReport(Request $request)
    {
        // Validate the input data
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'academic_term' => 'required|string',
            'report_status' => 'required|string|in:reported_in,reported_out',
            'clearIn_person' => 'nullable|string', // Used for check-in
            'check_in_time' => 'nullable|date_format:H:i', // Used for check-in
            'clearOut_person' => 'nullable|string', // Used for check-out
            'check_out_time' => 'nullable|date_format:H:i', // Used for check-out
            'other_name' => 'nullable|string|max:255',
            'other_nrc' => 'nullable|string',
            'vehicle_reg' => 'nullable|string',
            'parent_id' => 'nullable|exists:users,id',
            'other_contact' => 'nullable|string|max:15|regex:/^[0-9+\s()-]+$/',
            'pickup_by_relationship' => 'nullable|string|max:255',
            'cleared_by' => 'nullable|exists:users,id',
        ]);

        // Extract academic year ID and term number
        if (strpos($request->input('academic_term'), '-') === false) {
            return back()->with('error', 'Invalid academic term format.');
        }

        [$academicYearId, $academicTermNo] = explode('-', $request->input('academic_term'));

        if (!is_numeric($academicYearId)) {
            return back()->with('error', 'Invalid academic term values.');
        }

        // Determine the action based on report status
        $reportStatus = $request->input('report_status');
        $studentId = $request->input('student_id');

        DB::beginTransaction();

        try {
            if ($reportStatus === 'reported_in') {
                // Handle check-in logic
                $this->handleStudentCheckIn($request, $academicYearId, $academicTermNo, $studentId);
            } elseif (
                $reportStatus === 'reported_out'
            ) {
                // Handle check-out logic
                $this->handleStudentCheckOut($request, $academicYearId, $academicTermNo, $studentId);
            }

            DB::commit();

            return redirect()->back()->with('success', "Student $reportStatus successfully.");
        } catch (Exception $e) {
            DB::rollBack();

            Log::error("$reportStatus failed: " . $e->getMessage(), [
                'student_id' => $studentId,
                'academic_term_id' => $academicYearId,
                'academic_term_no' => $academicTermNo,
            ]);

            return back()->with('error', "An error occurred during the $reportStatus process. Please contact support.");
        }
    }
    //for dayscholars
    private function handleStudentCheckIn($request, $academicYearId, $academicTermNo, $studentId)
    {
        // Process checkbox inputs
        $checkboxes = ['clearance_accounts', 'clearance_secretary', 'clearance_search', 'clearance_patron'];
        $processedCheckboxes = [];
        foreach ($checkboxes as $checkbox) {
            $processedCheckboxes[$checkbox] = filter_var($request->input($checkbox, false), FILTER_VALIDATE_BOOLEAN);
        }

        // Store the check-in data
        StudentClearIn::create(array_merge($processedCheckboxes, [
            'student_id' => $studentId,
            'academic_year_id' => $academicYearId,
            'academic_term_no' => $academicTermNo,
            'check_in_time' => $request->input('check_in_time'),
            'brought_by_name' => $request->input('other_name'),
            'other_nrc' => $request->input('other_nrc'),
            'brought_vehicle_reg' => $request->input('vehicle_reg'),
            'brought_by_contact' => $request->input('other_contact'),
            'parent_id' => $request->input('parent_id'),
            'brought_by_relationship' => $request->input('pickup_by_relationship'),
            'cleared_by' => Auth::id(),
        ]));

        TermlyReport::create([
            'academic_year_id' => $academicYearId,
            'term_number' => $academicTermNo,
            'student_id' => $studentId,
            'reported_date' => now()->toDateString(),
            'report_status' => 'reported_in',
            'reported_by' => Auth::id(),
        ]);
    }
    //for dayscholars
    private function handleStudentCheckOut($request, $academicYearId, $academicTermNo, $studentId)
    {
        StudentClearOut::create([
            'student_id' => $studentId,
            'academic_year_id' => $academicYearId,
            'academic_term_no' => $academicTermNo,
            'clear_out_person' => $request->input('clearOut_person'),
            'check_out_time' => $request->input('check_out_time'),
            'parent_id' => $request->input('parent_id'),
            'other_name' => $request->input('other_name'),
            'other_nrc' => $request->input('other_nrc'),
            'other_contact' => $request->input('other_contact'),
            'vehicle_reg' => $request->input('vehicle_reg'),
            'pickup_by_relationship' => $request->input('pickup_by_relationship'),
            'cleared_by' => Auth::id(),
        ]);

        TermlyReport::create([
            'academic_year_id' => $academicYearId,
            'term_number' => $academicTermNo,
            'student_id' => $studentId,
            'reported_date' => now()->toDateString(),
            'report_status' => 'reported_out',
            'reported_by' => Auth::id(),
        ]);
    }




    //STUDENT ENROLLMENT METHODS
    public function viewEnrollmentProcess()
    {
        // Fetch academic years (from AcademicSession)
        $academicYears = AcademicSession::with(['terms' => function ($query) {
            $query->select('id', 'term_number', 'academic_year_id')->orderBy('term_number', 'asc');
        }])
            ->select('id', 'academic_year')
            ->orderBy('academic_year', 'desc')
            ->get();

        // Fetch terms (from SessionTerms)
        $terms = SessionTerms::select('id', 'term_number', 'academic_year_id')->orderBy('term_number', 'asc')->get();

        // Fetch other necessary data
        $grades = Grade::all();
        $fees = FeeCatergories::all();
        $hostels = Hostel::all();

        // Fetch all students with basic relationships
        $allStudents = Student::with(['grade', 'guardians', 'siblings', 'admissions.academicSession', 'admissions.term'])->get();

        // Filter students with admissions and map enrolled year and term
        $studentsWithAdmissions = $allStudents->filter(function ($student) {
            return $student->admissions->isNotEmpty();
        })->map(function ($student) {
            $admission = $student->admissions->first();
            if ($admission && $admission->academicSession) {
                $student->enrolled_year = $admission->academicSession->academic_year;
                $student->enrolled_term = $admission->academic_term_no;
                $student->admissionAppType = $admission->admissionAppType; // Add this line application_status
                $student->application_status = $admission->application_status;
            } else {
                $student->enrolled_year = 'Not enrolled';
                $student->enrolled_term = 'N/A';
                $student->admissionAppType = 'N/A'; // Add default value
            }
            return $student;
        });

        // dd($studentsWithAdmissions);
        // Pass data to the view
        return view('backend.students.enrollment-process', [
            'grades' => $grades,
            'fees' => $fees,
            'hostels' => $hostels,
            'students' => $studentsWithAdmissions, // For rendering the table
            'academicYears' => $academicYears, // For academic year dropdown
            'terms' => $terms, // For term dropdown
            'allStudents' => $allStudents // Reused with additional relationships
        ]);
    }


    public function viewEnrollmentRegister(Request $request)
    {
        $academicYears = AcademicSession::with(['terms' => function ($query) {
            $query->select('id', 'term_number', 'academic_year_id')->orderBy('term_number', 'asc');
        }])
            ->select('id', 'academic_year')
            ->orderBy('academic_year', 'desc')
            ->get();

        // Fetch terms (from SessionTerms)
        $terms = SessionTerms::select('id', 'term_number', 'academic_year_id')->orderBy('term_number', 'asc')->get();

        // Fetch other necessary data
        $grades = Grade::all();
        $fees = FeeCatergories::all();
        $hostels = Hostel::all();

        // Fetch all students with basic relationships
        $allStudents = Student::with(['grade', 'guardians', 'siblings', 'admissions.academicSession', 'admissions.term'])->get();
        // Pass data to the view
        return view('backend.students.enrollment-register', [
            'grades' => $grades,
            'fees' => $fees,
            'hostels' => $hostels,
            'academicYears' => $academicYears, // For academic year dropdown
            'terms' => $terms, // For term dropdown
            'allStudents' => $allStudents // Reused with additional relationships
        ]);
    }

    //fetch enrolment by year - ajax method:
    public function enrollmentFilterByYear(Request $request)
    {
        // Validate the input
        $request->validate([
            'academic_year_id' => 'required|integer',
            'term_number' => 'required|integer',
        ]);

        // Extract year and term from the request
        $academicYearId = $request->input('academic_year_id');
        $termNumber = $request->input('term_number');

        // Fetch students with relationships and filter by the given year and term
        $students = Student::with(['admissions.academicSession', 'admissions.term', 'grade', 'guardians'])
            ->whereHas('admissions', function ($query) use ($academicYearId, $termNumber) {
                $query->where('academic_year_id', $academicYearId)
                    ->where('academic_term_no', $termNumber);
            })
            ->get()
            ->map(function ($student) {
                $admission = $student->admissions->first();
                if ($admission && $admission->academicSession) {
                    $student->enrolled_year = $admission->academicSession->academic_year;
                    $student->enrolled_term = $admission->academic_term_no;
                } else {
                    $student->enrolled_year = 'Not enrolled';
                    $student->enrolled_term = 'N/A';
                }
                return $student;
            });

        // Return JSON response
        return response()->json(['students' => $students]);
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
            'fee_session_group_id.*' => 'exists:fee_categories,id',
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

            // / Extract academic year ID and term number
            if (!str_contains($request->input('academic_term'), '-')) {
                return back()->with('error', 'Invalid academic term format.');
            }

            [$academicYearId, $termId] = explode('-', $request->input('academic_term'));

            // Create admission record
            Admissions::create([
                'academic_year_id' => $academicYearId,
                'academic_term_no' => $termId,
                'admission_id' => $admissionId,
                'admissionAppType' => 'physical',
                'application_status' => 'Pending Review',
                'student_id' => $student->id
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
                        'fee_category_id' => $feeId,
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
                'aptitude_score' => 'required|integer|min:50|max:100',
            ]);

            $admission = Admissions::where('student_id', $id)->firstOrFail();
            $admission->update([
                'aptitude_score' => $request->apptude_score,
                'brief_comment' => 'Congratulations!, You passed our Aptitude Test!',
                'application_status' => 'Accepted'
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
                'brief_comment' => 'required|string|max:250',
                'aptitude_score' => 'required|integer|max:49',
            ]);

            $admission = Admissions::where('student_id', $id)->firstOrFail();
            $admission->update([
                'aptitude_score' => $request->apptude_score,
                'brief_comment' => $request->brief_comment,
                'application_status' => 'Rejected' //default
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
        $fees = FeeCatergories::all();
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





    // STUDENT CLASS REGISTER METHODS
    public function viewStudentClassRegister(Request $request)
    {

        // Fetch academic years (from AcademicSession)
        $academicYears = AcademicSession::with(['terms' => function ($query) {
            $query->select('id', 'term_number', 'academic_year_id')->orderBy('term_number', 'asc');
        }])
            ->select('id', 'academic_year')
            ->orderBy('academic_year', 'desc')
            ->get();

        // $hostels = Hostel::all();
        // $bedspaces = Bedspace::all();
        $grades = Grade::all();

        // Prepare terms in the sorted order
        // Fetch terms (from SessionTerms)
        $terms = SessionTerms::select('id', 'term_number', 'academic_year_id')->orderBy('term_number', 'asc')->get();

        return view('backend.students.student-class-register', compact('academicYears', 'terms', 'grades'));
    }

    //ajax call
    public function searchTermlyStudentsRegister(Request $request)
    {
        $academicYearId = $request->input('academic_year_id');
        $term = $request->input('term');
        $classId = $request->input('class_id');

        $students = Student::where(function ($query) use ($academicYearId, $term) {
            $query->whereHas('termlyReports', function ($subQuery) use ($academicYearId, $term) {
                if ($academicYearId) {
                    $subQuery->where('academic_year_id', $academicYearId);
                }
                if ($term) {
                    $subQuery->where('term_number', $term);
                }
            });
            $query->orWhereHas('checkIns', function ($subQuery) {
                $subQuery->whereNotNull('id');
            });
        })
            ->with([
                'checkIns.hostel',
                'checkIns.bedspace',
                'termlyReports' => function ($query) use ($academicYearId, $term) {
                    if ($academicYearId) {
                        $query->where('academic_year_id', $academicYearId);
                    }
                    if ($term) {
                        $query->where('term_number', $term);
                    }
                },
                'grade'
            ])
            ->when($classId, function ($query, $classId) {
                return $query->where('class_id', $classId);
            })
            ->get();

        return response()->json(['students' => $students]);
    }
    
  




    //create a method to search for statitistics for the student-class-register



    //STUDENT BULK DISABLE 
    public function viewStudentBulkDisable()
    {
        $academicYearsWithTerms = AcademicHelper::getActiveAcademicYearsWithTerms();
        return view('backend.students.student-bulk-disable', compact('academicYearsWithTerms'));
    }











    ///add more methods
}
