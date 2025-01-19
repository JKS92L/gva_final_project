<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Hostel;
use App\Models\Student;
use App\Models\Bedspace;
use App\Models\ClassFee;
use App\Models\FeeBalance;
use App\Models\FeePayment;
use App\Models\StudentFee;
use App\Models\FeeStructure;
use App\Models\TermlyReport;
use Illuminate\Http\Request;
use App\Models\FeeAdjustment;
use App\Models\FeeCatergories;
use App\Models\FeeTransaction;
use App\Helpers\AcademicHelper;
use App\Models\AcademicSession;
use App\Models\ClassFeeAdjustment;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class StudentFeeController extends Controller
{
    //

    public function viewSubmitPayments()
    {
        $grades = Grade::all();
        $academicYears = AcademicHelper::getActiveAcademicYearsWithTerms();
        $hostels = Hostel::all();
        $bedspaces = Bedspace::all();
        $allStudents = Student::with(['grade', 'guardians', 'siblings', 'admissions.academicSession', 'admissions.term'])->get();

        return view('backend.studentFees.fee-collection', compact('academicYears', 'grades', 'allStudents'));
    }


    public function viewStudentPayment($student_id)
    {
        $academicYears = AcademicHelper::getActiveAcademicYearsWithTerms();

        // Fetch the student along with all related data
        $student = Student::with([
            'guardians',
            'studentFee',
            'grade',
            'feeCategories',
            'feePayments',
            'feeBalances',
            'feeAdjustments', // Adding student's fee adjustments
        ])->where('id', $student_id)->first();

        if (!$student) {
            abort(404, 'Student not found.');
        }

        // Fetch the latest termly report for the student
        $latestTermlyReport = TermlyReport::where('student_id', $student_id)
            ->latest('reported_date') // Sort by the most recent report date
            ->first();

        $latestAcademicYear = null;

        if ($latestTermlyReport) {
            $latestAcademicYear = [
                'academic_year' => $latestTermlyReport->academicYear->academic_year ?? null,
                'term_number' => $latestTermlyReport->term_number ?? null,
            ];
        }
        // Fetch the class fees for the student's class
        $classFees = ClassFee::with(['feeCategory', 'academicYear'])
            ->where('class_id', $student->class_id)
            ->get()->all();

        // Fetch class fee adjustments based on the student's class and type
        $classFeeAdjustments = ClassFeeAdjustment::where('class_id', $student->class_id)
            ->where('student_type', $student->student_type)
            ->get();

        // Fetch any global fee adjustments (if required)
        $feeAdjustments = FeeAdjustment::where('student_id', $student_id)
            ->get();

        return view('backend.studentFees.student-fee-payment', compact(
            'student',
            'academicYears',
            'classFeeAdjustments',
            'classFees',
            'feeAdjustments',
            'latestAcademicYear' // Pass the latest academic year and term to the view
        ));
    }

    // public function storeFeePayment(Request $request)
    // {
    //     // Validate the request data
    //     $validatedData = $request->validate([
    //         'student_id' => 'required|integer|exists:students,id',
    //         'fee_category_id' => 'required|integer|exists:fee_categories,id',
    //         'academic_year_id' => 'required|integer|exists:academicYear,id',
    //         'term_no' => 'required|integer|min:1|max:3',
    //         'amount_paid' => 'required|numeric|min:0.01',
    //         'payment_date' => 'required|date',
    //         'payment_method' => 'required|string|in:Cash,Bank Transfer,Mobile Money',
    //         'reference_no' => 'nullable|string|max:255',
    //         'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    //     ]);

    //     // Handle file upload if attachment is provided
    //     $attachmentPath = null;
    //     if ($request->hasFile('attachment')) {
    //         $attachmentPath = $request->file('attachment')->store('payments', 'public');
    //     }

    //     // Determine the payment status based on the logged-in user's role
    //     $paymentStatus = auth()->user()->role_id === 1 ? 'approved' : 'pending';

    //     // Start a database transaction
    //     DB::beginTransaction();

    //     try {
    //         // Insert payment record into the `fee_payments` table
    //         $payment = FeePayment::create([
    //             'student_id' => $validatedData['student_id'],
    //             'fee_category_id' => $validatedData['fee_category_id'],
    //             'term_no' => $validatedData['term_no'],
    //             'academic_year_id' => $validatedData['academic_year_id'],
    //             'amount_paid' => $validatedData['amount_paid'],
    //             'payment_date' => $validatedData['payment_date'],
    //             'payment_method' => $validatedData['payment_method'],
    //             'reference_no' => $validatedData['reference_no'] ?? null,
    //             'attachment_url' => $attachmentPath,
    //             'attachment_title' => $request->file('attachment') ? $request->file('attachment')->getClientOriginalName() : null,
    //             'payment_status' => $paymentStatus, // Set the determined payment status
    //             'actioned_by' => auth()->id(),
    //             'actioned_date' => now(),
    //             'action_comment' => 'Payment recorded successfully by Grandview Accounts Office',
    //         ]);

    //         // Fetch the total fee amount from the `fee_categories` table
    //         $totalFee = FeeCatergories::where('id', $validatedData['fee_category_id'])->value('amount') ?? 0;

    //         // Update the fee balance for the student in the `fee_balances` table
    //         $feeBalance = FeeBalance::firstOrNew([
    //             'student_id' => $validatedData['student_id'],
    //             'academic_year' => $validatedData['academic_year_id'],
    //             'term' => $validatedData['term_no'],
    //         ]);

    //         $feeBalance->total_fee = $feeBalance->total_fee ?? $totalFee; // Set total_fee only if it's not already set
    //         $feeBalance->amount_paid += $validatedData['amount_paid']; // Increment the amount_paid
    //         $feeBalance->save();

    //         // Record a transaction in the `fee_transactions` table
    //         FeeTransaction::create([
    //             'payment_id' => $payment->id,
    //             'transaction_date' => $validatedData['payment_date'],
    //             'amount' => $validatedData['amount_paid'],
    //             'transaction_type' => 'payment', // Indicates a payment
    //             'remarks' => 'Payment recorded via ' . $validatedData['payment_method'],
    //         ]);

    //         // Commit the transaction
    //         DB::commit();

    //         return redirect()->back()->with('success', 'Payment submitted and records updated successfully!');
    //     } catch (\Exception $e) {
    //         // Rollback the transaction in case of an error
    //         DB::rollBack();

    //         return redirect()->back()->withErrors('Failed to process payment: ' . $e->getMessage());
    //     }
    // }






    //view history


    public function storeFeePayment(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'student_id' => 'required|integer|exists:students,id',
            'fee_category_id' => 'required|integer|exists:fee_categories,id',
            'academic_year_id' => 'required|integer|exists:academicYear,id',
            'term_no' => 'required|integer|min:1|max:3',
            'amount_paid' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string|in:Cash,Bank Transfer,Mobile Money',
            'reference_no' => 'nullable|string|max:255',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Handle file upload if attachment is provided
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('payments', 'public');
        }

        // Determine the payment status based on the logged-in user's role
        $paymentStatus = auth()->user()->role_id === 1 ? 'approved' : 'pending';

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Insert payment record into the `fee_payments` table
            $payment = FeePayment::create([
                'student_id' => $validatedData['student_id'],
                'fee_category_id' => $validatedData['fee_category_id'],
                'term_no' => $validatedData['term_no'],
                'academic_year_id' => $validatedData['academic_year_id'],
                'amount_paid' => $validatedData['amount_paid'],
                'payment_date' => $validatedData['payment_date'],
                'payment_method' => $validatedData['payment_method'],
                'reference_no' => $validatedData['reference_no'] ?? null,
                'attachment_url' => $attachmentPath,
                'attachment_title' => $request->file('attachment') ? $request->file('attachment')->getClientOriginalName() : null,
                'payment_status' => $paymentStatus, // Set the determined payment status
                'actioned_by' => auth()->id(),
                'actioned_date' => now(),
                'action_comment' => 'Payment recorded successfully by Grandview Accounts Office',
            ]);

            // If payment is approved, update fee balance and transaction records
            if ($paymentStatus === 'approved') {
                $this->updateFeeBalanceAndTransaction($payment, $validatedData);
            }

            // Commit the transaction
            DB::commit();

            return redirect()->back()->with('success', 'Payment submitted successfully!');
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollBack();

            return redirect()->back()->withErrors('Failed to process payment: ' . $e->getMessage());
        }
    }

    //UPDATE STUDENT FEE HELPER FUNCTION FOR APPROVE PAYMENT AND STOREFEE PAYMENT
    private function updateFeeBalanceAndTransaction(FeePayment $payment, array $validatedData = [])
    {
        // Fetch the total fee amount from the `fee_categories` table
        $totalFee = FeeCatergories::where('id', $payment->fee_category_id)->value('amount') ?? 0;

        // Update the fee balance
        $feeBalance = FeeBalance::firstOrNew([
            'student_id' => $payment->student_id,
            'academic_year' => $payment->academic_year_id,
            'term' => $payment->term_no,
        ]);

        $feeBalance->total_fee = $feeBalance->total_fee ?? $totalFee;
        $feeBalance->amount_paid += $payment->amount_paid;
        $feeBalance->save();

        // Record a transaction in the `fee_transactions` table
        FeeTransaction::create([
            'payment_id' => $payment->id,
            'transaction_date' => $payment->payment_date,
            'amount' => $payment->amount_paid,
            'transaction_type' => 'payment', // Indicates a payment
            'remarks' => 'Payment recorded via ' . $payment->payment_method,
        ]);
    }






    public function showReceipt($id)
    {
        // Fetch the transaction along with its related data
        $transaction = FeePayment::with(['student', 'feeCategory', 'academicSession'])->findOrFail($id);

        // Fetch all payments made by the same student for the same fee category
        $relatedPayments = FeePayment::where('student_id', $transaction->student_id)
            ->where('fee_category_id', $transaction->fee_category_id)
            ->where('id', '!=', $transaction->id) // Exclude the current transaction
            ->get();

        // Return the view with the transaction details and related payments
        return view('backend.studentFees.student-payment-history', compact('transaction', 'relatedPayments'));
    }

    // ajax call 
    public function filterFeeCategories(Request $request)
    {
        $request->validate([
            'academic_year_id' => 'required|integer|exists:academicYear,id',
            'term_no' => 'required|integer|min:1|max:3',
            'fee_category_id' => 'nullable|integer|exists:fee_categories,id',
            'student_id' => 'required|integer|exists:students,id',
        ]);

        // Query Fee Categories
        $query = FeeCatergories::with(['students' => function ($query) use ($request) {
            $query->where('student_id', $request->student_id);
        }, 'payments' => function ($query) use ($request) {
            $query->where('academic_year_id', $request->academic_year_id)
                ->where('term_no', $request->term_no);
        }]);

        if ($request->fee_category_id) {
            $query->where('id', $request->fee_category_id);
        }

        $feeCategories = $query->get()->map(function ($category) {
            $totalPaid = $category->payments->sum('amount_paid');
            $balance = $category->amount - $totalPaid;

            $recentTransaction = $category->payments->sortByDesc('payment_date')->first();

            return [
                'fee_type' => $category->fee_type,
                'fee_interval' => $category->fee_interval,
                'amount' => $category->amount,
                'total_paid' => $totalPaid,
                'balance' => $balance,
                'recent_transaction' => $recentTransaction ? [
                    'amount_paid' => $recentTransaction->amount_paid,
                    'payment_date' => $recentTransaction->payment_date->toDateString(),
                    'payment_status' => $recentTransaction->payment_status,
                    'id' => $recentTransaction->id,
                ] : null,
                'status' => $totalPaid == 0 ? 'Not Yet Paid' : ($balance > 0 ? 'Partial' : 'Paid'),
                'status_class' => $totalPaid == 0 ? 'bg-danger' : ($balance > 0 ? 'bg-warning' : 'bg-success'),
            ];
        });

        return response()->json(['data' => $feeCategories]);
    }

    //FEE STRUCTURE METHODS 
    public function viewFeeStructures()
    {
        // Fetch necessary data
        $academicYears = AcademicHelper::getActiveAcademicYearsWithTerms();
        $feeCategories = FeeCatergories::all(); // Fetch all fee categories
        $grades = Grade::all(); // Fetch all classes/grades
        $students = Student::all(); // Fetch all students

        // Fetch recent individual fee adjustments
        $studentFeeAdjustments = FeeAdjustment::with('student')->latest()->limit(10)->get();

        // Fetch recent class fee adjustments
        $classFeeAdjustments = ClassFeeAdjustment::with(['grade', 'feeCategory'])->latest()->limit(10)->get();

        // Fetch assigned class fees
        $classFees = ClassFee::with(['feeCategory', 'grade', 'academicYear'])
            ->orderBy('academic_year_id')
            ->orderBy('term_no')
            ->orderBy('class_id')
            ->get();

        // Fetch assigned individual student fees
        $studentFees = StudentFee::with(['feeCategory', 'student', 'academicYear'])
            ->orderBy('academic_year_id')
            ->orderBy('term_no')
            ->orderBy('student_id')
            ->get();

        // Return the Blade template with all data
        return view('backend.studentFees.student-fee-structure', compact(
            'academicYears',
            'feeCategories',
            'grades',
            'students',
            'studentFeeAdjustments',
            'classFeeAdjustments',
            'classFees',
            'studentFees'
        ));
    }


    // FEE STRUCTURE CRUD
    public function storeStructure(Request $request)
    {
        // Validate the input data
        $validated = $request->validate([
            'fee_type' => 'required|string|max:255',
            'interval' => 'required|string', // Matches the form's `interval` input
            'amount' => 'required|numeric',
            'student_type' => 'required|string',
            'account_id' => 'required|string', // Matches the form's `account_id` input
            'status' => 'required|string',
            'circumstance_explanation' => 'nullable|string|max:255', // Optional for circumstantial explanation
        ]);

        // Map form inputs to the model's column names
        $data = [
            'fee_type' => $validated['fee_type'],
            'fee_interval' => $validated['interval'], // `fee_interval` matches the model column
            'amount' => $validated['amount'],
            'student_type' => $validated['student_type'],
            'account_no' => $validated['account_id'], // `account_no` matches the model column
            'status' => $validated['status'],
            'comment' => $request->interval === 'circumstantial' ? $request->circumstance_explanation : null, // Add comment conditionally
        ];

        // Create a new fee record
        FeeCatergories::create($data);

        return redirect()->back()->with('success', 'Fee Category added successfully.');
    }

    public function updateFeeStructure(Request $request, $id)
    {
        // Validate the request data
        $validated = $request->validate([
            'fee_type' => 'required|string|max:255',
            'fee_interval' => 'required|string',
            'amount' => 'required|numeric',
            'student_type' => 'required|string',
            'account_no' => 'required|string|max:255',
            'status' => 'required|boolean',
            'comment' => 'nullable|string|max:500',
        ]);

        // Find the fee category by ID
        $feeCategory = FeeCatergories::findOrFail($id);

        // Update the fee category with validated data
        $feeCategory->update($validated);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Fee category updated successfully.');
    }

    public function destroyFeeStructure($id)
    {
        $feeCategory = FeeCatergories::findOrFail($id);

        // Optional: Add additional logic for associated data cleanup, if needed.

        $feeCategory->delete();

        return redirect()->back()->with('success', 'Fee category deleted successfully.');
    }


    //CLASS FEE ASSIGNMENT 

    public function storeStudentAndClassFee(Request $request)
    {
        $rules = [
            'academic_year_id' => 'required|exists:academicYear,id',
            'term_no' => 'required|integer|in:1,2,3',
            'feeScope' => 'required|in:class,individual',
            'student_type' => 'required|string|in:boarder,day,all,selective',
            'fee_category_id' => 'required|array',
            'fee_category_id.*' => 'exists:fee_categories,id',
        ];

        if ($request->feeScope === 'class') {
            $rules['class_id'] = 'required|exists:grades,id';
        } elseif ($request->feeScope === 'individual') {
            $rules['student_ids'] = 'required|array';
            $rules['student_ids.*'] = 'exists:students,id';
        }

        $validated = $request->validate($rules);

        $scope = $validated['feeScope'];
        $studentType = $validated['student_type'];
        $duplicates = [];
        $createdFees = [];
        $createdClassFees = [];

        DB::transaction(function () use ($validated, $scope, $studentType, &$duplicates, &$createdFees, &$createdClassFees) {
            if ($scope === 'class') {
                // Insert class fees for the specified class and fee categories
                foreach ($validated['fee_category_id'] as $feeCategoryId) {
                    $exists = ClassFee::where('academic_year_id', $validated['academic_year_id'])
                        ->where('term_no', $validated['term_no'])
                        ->where('class_id', $validated['class_id'])
                        ->where('fee_category_id', $feeCategoryId)
                        ->exists();

                    if ($exists) {
                        $duplicates[] = ['class_id' => $validated['class_id'], 'fee_category_id' => $feeCategoryId];
                    } else {
                        $createdClassFees[] = [
                            'fee_category_id' => $feeCategoryId,
                            'class_id' => $validated['class_id'],
                            'academic_year_id' => $validated['academic_year_id'],
                            'term_no' => $validated['term_no'],
                        ];
                    }
                }

                if (!empty($createdClassFees)) {
                    ClassFee::insert($createdClassFees);
                }

                // Handle individual student fees based on student_type
                $students = collect();

                if ($studentType === 'all') {
                    $students = Student::where('class_id', $validated['class_id'])->get();
                } elseif (in_array($studentType, ['boarder', 'day'])) {
                    $students = Student::where('class_id', $validated['class_id'])
                        ->where('student_type', $studentType)
                        ->get();
                }

                foreach ($students as $student) {
                    foreach ($validated['fee_category_id'] as $feeCategoryId) {
                        $exists = StudentFee::where('academic_year_id', $validated['academic_year_id'])
                            ->where('term_no', $validated['term_no'])
                            ->where('student_id', $student->id)
                            ->where('fee_category_id', $feeCategoryId)
                            ->exists();

                        if ($exists) {
                            $duplicates[] = ['student_id' => $student->id, 'fee_category_id' => $feeCategoryId];
                        } else {
                            $createdFees[] = [
                                'fee_category_id' => $feeCategoryId,
                                'student_id' => $student->id,
                                'academic_year_id' => $validated['academic_year_id'],
                                'term_no' => $validated['term_no'],
                            ];
                        }
                    }
                }

                if (!empty($createdFees)) {
                    StudentFee::insert($createdFees);
                }
            } elseif ($scope === 'individual' && $studentType === 'selective' || 'all') {
                foreach ($validated['student_ids'] as $studentId) {
                    foreach ($validated['fee_category_id'] as $feeCategoryId) {
                        $exists = StudentFee::where('academic_year_id', $validated['academic_year_id'])
                            ->where('term_no', $validated['term_no'])
                            ->where('student_id', $studentId)
                            ->where('fee_category_id', $feeCategoryId)
                            ->exists();

                        if ($exists) {
                            $duplicates[] = ['student_id' => $studentId, 'fee_category_id' => $feeCategoryId];
                        } else {
                            $createdFees[] = [
                                'fee_category_id' => $feeCategoryId,
                                'student_id' => $studentId,
                                'academic_year_id' => $validated['academic_year_id'],
                                'term_no' => $validated['term_no'],
                            ];
                        }
                    }
                }

                if (!empty($createdFees)) {
                    StudentFee::insert($createdFees);
                }
            }
        });

        return response()->json([
            'success' => true,
            'message' => count($duplicates) > 0
                ? 'Some fees were already assigned.'
                : 'Fees assigned successfully!',
            'summary' => [
                'total_duplicates' => count($duplicates),
                'total_created_class_fees' => count($createdClassFees),
                'total_created_student_fees' => count($createdFees),
            ],
            'duplicates' => $duplicates,
        ]);
    }

    public function destroyClassFees($id)
    {
        try {
            // Find the class fee record by ID
            $classFee = ClassFee::findOrFail($id);

            // Delete the record
            $classFee->delete();

            // Redirect with success message
            return redirect()->back()->with('success', 'Class fee record deleted successfully.');
        } catch (\Exception $e) {
            // Redirect with error message
            return redirect()->back()->with('error', 'Failed to delete class fee record: ' . $e->getMessage());
        }
    }
    public function destroyStudentFees($id)
    {
        try {
            // Find the student fee record by ID
            $studentFee = StudentFee::findOrFail($id);

            // Delete the record
            $studentFee->delete();

            // Redirect with success message
            return redirect()->back()->with('success', 'Student fee record deleted successfully.');
        } catch (\Exception $e) {
            // Redirect with error message
            return redirect()->back()->with('error', 'Failed to delete student fee record: ' . $e->getMessage());
        }
    }

    //storeFeeAdjustment
    public function storeFeeAdjustment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'academic_year_id' => 'required|exists:academicYear,id',
            'term_no' => 'required|integer|in:1,2,3',
            'adjustment_scope' => 'required|in:bulkStudent,classAdjustment',
            'waver_penalty_feeId' => 'required|string',
            'adjustment_type' => 'required|in:waiver,penalty',
            'amount' => 'required|numeric|min:0.01',
            'adjustment_date' => 'required|date',
            'reason' => 'required|string|max:255',
            'student_ids' => 'required_if:adjustment_scope,bulkStudent|array',
            'student_ids.*' => 'exists:students,id',
            'student_type' => 'required_if:adjustment_scope,classAdjustment|in:day,boarder,all',
            'class_id' => 'required_if:adjustment_scope,classAdjustment|exists:grades,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        try {
            if ($request->adjustment_scope === 'bulkStudent') {
                foreach ($request->student_ids as $studentId) {
                    $exists = FeeAdjustment::where([
                        ['student_id', '=', $studentId],
                        ['academic_year_id', '=', $request->academic_year_id],
                        ['term_no', '=', $request->term_no],
                        ['adjustment_type', '=', $request->adjustment_type],
                    ])->exists();

                    if ($exists) {
                        return response()->json([
                            'success' => false,
                            'message' => 'A ' . $request->adjustment_type . ' adjustment already exists for this student in the selected academic year and term.'
                        ], 422);
                    }

                    FeeAdjustment::create([
                        'student_id' => $studentId,
                        'academic_year_id' => $request->academic_year_id,
                        'term_no' => $request->term_no,
                        'adjustment_type' => $request->adjustment_type,
                        'waver_penalty_feeId' => $request->waver_penalty_feeId,
                        'amount' => $request->amount,
                        'reason' => $request->reason,
                        'adjustment_date' => $request->adjustment_date,
                    ]);
                }
            } elseif ($request->adjustment_scope === 'classAdjustment') {
                $exists = ClassFeeAdjustment::where([
                    ['class_id', '=', $request->class_id],
                    ['academic_year_id', '=', $request->academic_year_id],
                    ['term_no', '=', $request->term_no],
                    ['adjustment_type', '=', $request->adjustment_type],
                ])->exists();

                if ($exists) {
                    return response()->json([
                        'success' => false,
                        'message' => 'A ' . $request->adjustment_type . ' adjustment already exists for this class in the selected academic year and term.'
                    ], 422);
                }

                ClassFeeAdjustment::create([
                    'academic_year_id' => $request->academic_year_id,
                    'term_no' => $request->term_no,
                    'class_id' => $request->class_id,
                    'student_type' => $request->student_type,
                    'adjustment_type' => $request->adjustment_type,
                    'amount' => $request->amount,
                    'reason' => $request->reason,
                    'adjustment_date' => $request->adjustment_date,
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Fee adjustment saved successfully!']);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Method to delete class fee adjustment
    public function destroyClassAdjustFee($id)
    {
        try {
            // Find the class fee adjustment by ID
            $classFeeAdjustment = ClassFeeAdjustment::findOrFail($id);

            // Delete the record
            $classFeeAdjustment->delete();

            // Set a success flash message
            session()->flash('success', 'Class fee adjustment deleted successfully.');
        } catch (\Exception $e) {
            // If the record is not found or another error occurs
            session()->flash('error', 'Failed to delete class fee adjustment: ' . $e->getMessage());
        }

        // Redirect back to the previous page
        return redirect()->back();
    }
    // Method to delete student fee adjustment
    public function destroyStudentAdjustFee($id)
    {
        try {
            // Find the student fee adjustment by ID
            $studentFeeAdjustment = FeeAdjustment::findOrFail($id);

            // Delete the record
            $studentFeeAdjustment->delete();

            // Set a success flash message
            session()->flash('success', 'Student fee adjustment deleted successfully.');
        } catch (\Exception $e) {
            // If the record is not found or another error occurs
            session()->flash('error', 'Failed to delete student fee adjustment: ' . $e->getMessage());
        }

        // Redirect back to the previous page
        return redirect()->back();
    }


    public function viewpaymentReport()
    {
        // Fetch academic years
        $academicYears = AcademicHelper::getActiveAcademicYearsWithTerms();
        $feeCategory = FeeCatergories::all();

        // Fetch payments grouped by term_no and academic_year_id
        $paymentsGrouped = FeePayment::selectRaw(
            'term_no, academic_year_id, payment_status, SUM(amount_paid) as total_amount, COUNT(*) as total_requests'
        )
            ->groupBy('term_no', 'academic_year_id', 'payment_status')
            ->get()
            ->groupBy('payment_status');

        // Handle cases where a payment status might not exist
        $totalPayments = $paymentsGrouped->get('approved', collect())->sum('total_amount');
        $totalPending = $paymentsGrouped->get('pending', collect())->sum('total_requests');
        $totalRejected = $paymentsGrouped->get('rejected', collect())->sum('total_requests');

        // Calculate total outstanding balances
        $totalOutstanding = StudentFee::query()
            ->with('feeCategory') // Ensure relationships are loaded
            ->get()
            ->map(function ($studentFee) {
                $totalFee = $studentFee->feeCategory->amount; // Fee amount for this category
                $payments = FeePayment::query()
                    ->where('student_id', $studentFee->student_id)
                    ->where('academic_year_id', $studentFee->academic_year_id)
                    ->where('term_no', $studentFee->term_no)
                    ->where('fee_category_id', $studentFee->fee_category_id)
                    ->sum('amount_paid');

                return max(0, $totalFee - $payments); // Return outstanding balance (non-negative)
            })
            ->sum(); // Sum up all outstanding balances

        $pendingRequests = FeePayment::query()
            ->select('id', 'student_id', 'fee_category_id', 'amount_paid', 'payment_status', 'attachment_title', 'attachment_url', 'term_no', 'academic_year_id', 'created_at')
            ->where('payment_status', 'pending')
            ->with(['student', 'feeCategory', 'academicSession']) // Load relationships
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($item) {
                return $item->academic_year_id . '-' . $item->term_no; // Group by academic year and term
            });

        // dd($pendingRequests);


        // Return view with data
        return view('backend.studentFees.student-fee-report', [
            'academicYears' => $academicYears,
            'feeCategories' => $feeCategory,
            'totalPayments' => $totalPayments,
            'totalPending' => $totalPending,
            'totalRejected' => $totalRejected,
            'totalOutstanding' => $totalOutstanding,
            'pendingRequests' => $pendingRequests,
        ]);
    }

    //admin fee payment approve
    // public function approveFeePayment(Request $request)
    // {
    //     // Validate the request
    //     $validated = $request->validate([
    //         'payment_id' => 'required|exists:fee_payments,id',
    //         'action_comment' => 'nullable|string|max:255',
    //     ]);

    //     // Fetch the payment record
    //     $feePayment = FeePayment::find($validated['payment_id']);

    //     if (!$feePayment) {
    //         return redirect()->back()->withErrors(['error' => 'Payment record not found.']);
    //     }

    //     // Update the payment status and other fields
    //     $feePayment->update([
    //         'payment_status' => 'approved',
    //         'actioned_date' => now(),
    //         'actioned_by' => auth()->id(), // Assuming the user is authenticated
    //         'action_comment' => $validated['action_comment'] ?? null,
    //     ]);

    //     // Return a success response
    //     return redirect()->back()->with('success', 'Payment status updated successfully.');
    // }



    public function approveFeePayment(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'payment_id' => 'required|exists:fee_payments,id',
            'action_comment' => 'nullable|string|max:255',
        ]);

        // Fetch the payment record
        $feePayment = FeePayment::find($validated['payment_id']);

        if (!$feePayment) {
            return redirect()->back()->withErrors(['error' => 'Payment record not found.']);
        }

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Update the payment status and other fields
            $feePayment->update([
                'payment_status' => 'approved',
                'actioned_date' => now(),
                'actioned_by' => auth()->id(),
                'action_comment' => $validated['action_comment'] ?? null,
            ]);

            // Update fee balance and transaction records
            $this->updateFeeBalanceAndTransaction($feePayment);

            // Commit the transaction
            DB::commit();

            return redirect()->back()->with('success', 'Payment approved successfully!');
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollBack();

            return redirect()->back()->withErrors('Failed to approve payment: ' . $e->getMessage());
        }
    }



    public function rejectFeePayment(Request $request)
    {
        $request->validate([
            'payment_id' => 'required|exists:fee_payments,id',
            'reject_comment' => 'nullable|string|max:255',
        ]);

        $payment = FeePayment::findOrFail($request->payment_id);
        $payment->update([
            'payment_status' => 'rejected',
            'actioned_by' => auth()->id(),
            'actioned_date' => now(),
            'action_comment' => $request->reject_comment,
        ]);

        return redirect()->back()->with('success', 'Fee payment has been rejected successfully.');
    }

    //ajax call 
    public function fetchOutstandingBalances(Request $request)
    {
        $request->validate([
            'academic_year_id' => 'required|integer',
            'term_no' => 'required|integer',
            'fee_category_id' => 'required|integer',
        ]);

        $academicYearId = $request->academic_year_id;
        $termNo = $request->term_no;
        $feeCategoryId = $request->fee_category_id;

        // Fetch the academic year details
        $academicYear = AcademicSession::find($academicYearId);
        if (!$academicYear) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid academic year ID.',
            ], 404);
        }

        // Fetch all students assigned to the selected fee category, term, and academic year
        $studentsWithFees = StudentFee::query()
            ->where('academic_year_id', $academicYearId)
            ->where('term_no', $termNo)
            ->where('fee_category_id', $feeCategoryId)
            ->with(['student', 'feeCategory'])
            ->get();

        $outstandingBalances = $studentsWithFees->map(function ($studentFee) use ($feeCategoryId, $academicYear, $termNo) {
            $totalFee = $studentFee->feeCategory->amount;
            $payments = FeePayment::query()
                ->where('student_id', $studentFee->student_id)
                ->where('academic_year_id', $academicYear->id)
                ->where('term_no', $termNo)
                ->where('fee_category_id', $feeCategoryId)
                ->sum('amount_paid');

            $balanceDue = $totalFee - $payments;

            return [
                'student_id' => $studentFee->student_id,
                'student_name' => $studentFee->student->firstname . ' ' . $studentFee->student->lastname,
                'academic_year' => $academicYear->academic_year, // Use the readable academic year
                'term_no' => $termNo,
                'fee_category' => $studentFee->feeCategory->fee_type,
                'total_fee' => $totalFee,
                'amount_paid' => $payments,
                'balance_due' => $balanceDue,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $outstandingBalances->filter(function ($balance) {
                return $balance['balance_due'] > 0; // Only return students with outstanding balances
            })->values(),
        ]);
    }


















    //end 
}
