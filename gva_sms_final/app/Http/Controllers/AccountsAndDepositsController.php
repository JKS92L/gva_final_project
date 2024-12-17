<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\AcademicSession;
use App\Helpers\TransactionHelper;
use App\Models\PocketMoneyAccount;
use Illuminate\Support\Facades\DB;
use App\Models\TuckShopTransaction;
use Illuminate\Support\Facades\Log;
use App\Models\PocketMoneyTransaction;

class AccountsAndDepositsController extends Controller
{
    // Display list of deposit records
    public function showDepositRecords()
    {
        $deposits = PocketMoneyAccount::with('student')->orderBy('created_at', 'desc')->get();
        $students = Student::with([
            'grade',
            'guardians'
        ])->get();

        // Fetch active academic sessions, sorted by the newest year first
        $academicSessions = AcademicSession::where('is_active', 1)->orderBy('academic_year', 'desc')->get();

        // Prepare terms in the sorted order
        $terms = [];
        foreach ($academicSessions as $session) {
            $terms[] = ['id' => $session->id . '-term1', 'name' => $session->academic_year . ' - Term 1'];
            $terms[] = ['id' => $session->id . '-term2', 'name' => $session->academic_year . ' - Term 2'];
            $terms[] = ['id' => $session->id . '-term3', 'name' => $session->academic_year . ' - Term 3'];
        }

        // Pass sorted terms to the view
        return view('backend.accountsAndDeposits.deposit-records', compact('deposits', 'students', 'terms'));
    }

    // Store a new deposit record
    public function storeDeposit(Request $request)
    {
        // Validate incoming request
        $validatedData = $request->validate([
            'student_id' => 'required|exists:students,id',
            'academic_term' => 'required|string', // Format: session_id-termX
            'deposit_amount' => 'required|numeric|min:1',
            'deposit_method' => 'required|in:cash,bank',
            'receipt_number' => 'nullable|string|max:50',
            'deposit_description' => 'nullable|string|max:255',
        ]);

        // Extract academic session and term from the provided academic_term
        list($academicSessionId, $term) = explode('-', $validatedData['academic_term']);

        // Ensure the academic session exists
        $academicSession = AcademicSession::findOrFail($academicSessionId);

        $studentId = $validatedData['student_id'];
        $newDepositAmount = $validatedData['deposit_amount'];

        // Fetch or create the student's account record for this session and term
        $account = PocketMoneyAccount::firstOrCreate(
            [
                'student_id' => $studentId,
                'academic_session_id' => $academicSessionId,
                'academic_term' => $term,
            ],
            [
                'initial_deposit' => $newDepositAmount,
                'current_amount' => $newDepositAmount,
                'deposit_method' => $validatedData['deposit_method'],
                'receipt_number' => $validatedData['receipt_number'] ?? null,
                'deposit_description' => $validatedData['deposit_description'] ?? null,
            ]
        );

        // Determine the balance before and after the transaction
        $balanceBefore = $account->wasRecentlyCreated ? 0.00 : $account->current_amount;
        $balanceAfter = $balanceBefore + $newDepositAmount;

        // Update account balances if the account already exists
        if (!$account->wasRecentlyCreated) {
            $account->update([
                'initial_deposit' => $account->initial_deposit + $newDepositAmount,
                'current_amount' => $balanceAfter,
            ]);
        }

        // Generate a unique transaction reference using the helper class
        $transactionReference = TransactionHelper::generateTransactionId();
        // Log the deposit transaction
        PocketMoneyTransaction::create([
            'transaction_type' => 'deposit',
            'transaction_id' => $account->id, // Reference to PocketMoneyAccount's ID
            'transaction_amount' => $newDepositAmount,
            'balance_before' => $balanceBefore,
            'balance_after' => $balanceAfter,
            'transaction_date' => now(),
            'description' => $validatedData['deposit_description'] ?? 'Pocket money deposit',
            'transaction_reference' => $transactionReference,
            'status' => 'completed', // Assuming deposits are instantly completed
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Deposit added successfully.');
    }


    // pocket money withdraw
    public function storeWithdrawal(Request $request)
    {
        $validated = $request->validate([
            'transaction_id' => 'required|exists:pocket_money_account,id', // Ensure valid PocketMoneyAccount ID
            'withdraw_amount' => 'required|numeric|min:1', // Positive amount
            'withdraw_description' => 'nullable|string|max:255', // Optional description
        ]);

        // Retrieve the pocket money account record
        $account = PocketMoneyAccount::findOrFail($validated['transaction_id']);

        // Ensure sufficient funds for the withdrawal
        if ($validated['withdraw_amount'] > $account->current_amount) {
            return redirect()->back()->with('error', 'Withdrawal amount exceeds current balance.');
        }

        // Calculate balances
        $balanceBefore = $account->current_amount;
        $balanceAfter = $balanceBefore - $validated['withdraw_amount'];

        // Deduct the withdrawal amount and update the account
        $account->update(['current_amount' => $balanceAfter]);


        // Generate a unique transaction reference using the helper class
        $transactionReference = TransactionHelper::generateTransactionId();
        // Log the withdrawal transaction
        PocketMoneyTransaction::create([
            'transaction_type' => 'withdrawal',
            'transaction_id' => $account->id, // Link to the pocket money account
            'transaction_amount' => $validated['withdraw_amount'],
            'description' => $validated['withdraw_description'] ?? 'Withdrawal',
            'balance_before' => $balanceBefore,
            'balance_after' => $balanceAfter,
            'transaction_reference' => $transactionReference,
            'status' => 'completed',
            'transaction_date' => now(),
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Withdrawal processed successfully.');
    }

















    // Update method to handle form submission
    public function updateDeposit(Request $request, $id)
    {
        // Validate incoming request
        $validatedData = $request->validate([
            'deposit_amount' => 'required|numeric|min:1', // Ensure positive amount
            'deposit_method' => 'required|in:cash,bank', // Limit to accepted methods
            'receipt_number' => 'nullable|string|max:50', // Optional receipt number
            'deposit_description' => 'nullable|string|max:255', // Optional description
        ]);

        // Find the existing deposit account
        $account = PocketMoneyAccount::findOrFail($id);

        // Calculate balance adjustment
        $newDepositAmount = $validatedData['deposit_amount'];
        $balanceBefore = $account->current_amount;
        $balanceAfter = $balanceBefore - $account->deposit_amount + $newDepositAmount;

        // Generate a unique transaction reference using the helper class
        $transactionReference = TransactionHelper::generateTransactionId();

        // Update the deposit account
        $account->update([
            'initial_deposit' => $account->initial_deposit - $account->deposit_amount + $newDepositAmount,
            'current_amount' => $balanceAfter,
            'deposit_method' => $validatedData['deposit_method'],
            'receipt_number' => $validatedData['receipt_number'] ?? $account->receipt_number,
            'deposit_description' => $validatedData['deposit_description'] ?? $account->deposit_description,
        ]);

        // Log the updated deposit transaction
        PocketMoneyTransaction::create([
            'transaction_type' => 'deposit_update',
            'transaction_id' => $account->id, // Reference to PocketMoneyAccount's ID
            'transaction_amount' => $newDepositAmount,
            'balance_before' => $balanceBefore,
            'balance_after' => $balanceAfter,
            'transaction_date' => now(),
            'description' => $validatedData['deposit_description'] ?? 'Deposit update',
            'transaction_reference' => $transactionReference,
            'status' => 'updated', // Indicate this is an update
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Deposit updated successfully.');
    }



    // Delete method to handle record deletion
    public function destroyDeposit($id)
    {
        $deposit = PocketMoneyAccount::findOrFail($id);
        $deposit->delete();

        return redirect()->back()->with('success', 'Deposit deleted successfully.');
    }



    // Display bank deposit reconciliation
    public function showBankReconciliation()
    {
        $bankDeposits = PocketMoneyAccount::with('student')
            ->where('deposit_method', 'bank')
            ->orderBy('created_at', 'desc')
            ->get();
        $students = Student::with(['grade', 'guardians'])->get();

        return view('backend.accountsAndDeposits.bank-reconciliation', compact('bankDeposits', 'students'));
    }

    // AccountsAndDepositsController.php

    // AccountsAndDepositsController.php

    public function storeBankReconciliation(Request $request)
    {
        $request->validate([
            'pupil_id' => 'required|exists:students,id',
            'amount' => 'required|numeric|min:1',
            'transaction_date' => 'required|date',
            'bank_account' => 'nullable|integer',
            'receipt_number' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:250',
        ]);

        try {
            // Attempt to create a bank deposit record
            PocketMoneyAccount::create([
                'student_id' => $request->input('pupil_id'),
                'deposit_amount' => $request->input('amount'),
                'deposit_date' => $request->input('transaction_date'),
                'deposit_method' => 'bank',
                'receipt_number' => $request->input('receipt_number'),
                'bank_account' => $request->input('bank_account'),
                'deposit_description' => $request->input('description'),
            ]);

            return redirect()->route('accounts.expenses.bank-reconciliation')
                ->with('success', 'Bank deposit successfully recorded.');
        } catch (\Exception $e) {
            // Log the error message and return a failure response
            Log::error("Bank reconciliation failed: " . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to store bank deposit. Please try again.']);
        }
    }


    //update bank recocilliation
    public function updateBankReconciliation(Request $request, $id)
    {
        // Validate input data
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'deposit_amount' => 'required|numeric|min:1',
            'bank_account' => 'nullable|integer',
            'receipt_number' => 'nullable|string|max:50',
            'deposit_description' => 'nullable|string|max:250',
            'deposit_date' => 'required|date',
        ]);

        try {
            // Find and update the record
            $bankDeposit = PocketMoneyAccount::findOrFail($id);
            $bankDeposit->update([
                'student_id' => $request->input('student_id'),
                'deposit_amount' => $request->input('deposit_amount'),
                'bank_account' => $request->input('bank_account'),
                'receipt_number' => $request->input('receipt_number'),
                'deposit_description' => $request->input('deposit_description'),
                'deposit_date' => $request->input('deposit_date'),
            ]);

            // Redirect with a success message
            return redirect()->route('accounts.expenses.bank-reconciliation')
                ->with('success', 'Bank reconciliation record updated successfully.');
        } catch (\Exception $e) {
            // Redirect with an error message if update fails
            return redirect()->route('accounts.expenses.bank-reconciliation')
                ->with('error', 'Failed to update the bank reconciliation record. Please try again.');
        }
    }



    public function destroyBankReconciliation($id)
    {
        $record = PocketMoneyAccount::findOrFail($id);
        $record->delete();

        return redirect()->route('accounts.expenses.bank-reconciliation')
            ->with('success', 'Record deleted successfully.');
    }

    public function filterBankReconciliation(Request $request)
    {
        // Validate input dates
        $request->validate([
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date',
        ]);

        // Initialize the query
        $query = PocketMoneyAccount::query();

        // Apply date range filter if dates are provided
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('deposit_date', [$request->from_date, $request->to_date]);
        }

        // Filter by deposit method (bank)
        $query->where('deposit_method', 'bank');

        // Get filtered records
        $filteredRecords = $query->get();

        // Render the records into a partial Blade view and return the HTML
        return view('backend.accountsAndDeposits.partials.reconciliation_table_body', compact('filteredRecords'))->render();
    }

    // Display balance report filtered by pupil, class, etc.
    public function showBalanceReport()
    {
        // Fetch PocketMoneyAccounts with related student, grade, and transaction sums
        $accounts = PocketMoneyAccount::with(['student.grade'])
            ->withSum(['transactions as total_withdrawn' => function ($query) {
                $query->where('transaction_type', 'withdrawal');
            }], 'transaction_amount')
            ->withSum(['transactions as total_spent' => function ($query) {
                $query->where('transaction_type', 'purchase');
            }], 'transaction_amount')
            ->get();

        // Fetch total spent on purchases directly from TuckShopTransactions
        $tuckShopExpenses = TuckShopTransaction::select('student_id', DB::raw('SUM(total_cost) as total_spent'))
            ->groupBy('student_id')
            ->pluck('total_spent', 'student_id');

        // Calculate total cash withdrawals directly
        $totalCashWithdraws = PocketMoneyTransaction::where('transaction_type', 'withdrawal')
            ->sum('transaction_amount');

        // Prepare the balances data for the view
        $balances = $accounts->map(function ($account) use ($tuckShopExpenses) {
            $studentId = $account->student->id;
            return [
                'student' => $account->student,
                'grade_class' => $account->student->grade->gradeno . ' ' . $account->student->grade->class_name,
                'initial_balance' => number_format($account->initial_deposit, 2),
                'current_balance' => number_format($account->current_amount, 2),
                'tuckshop_expenses' => number_format($tuckShopExpenses[$studentId] ?? 0, 2), // Use TuckShopTransaction data
                'total_withdrawn' => number_format($account->total_withdrawn ?? 0, 2),
            ];
        });

        // Calculate summary totals
        $totalDeposits = $accounts->sum('initial_deposit');
        $totalSpent = $tuckShopExpenses->sum();
        $totalWithdrawn = $accounts->sum('total_withdrawn');
        $netBalance = $accounts->sum('current_amount');
        $pupilCount = $balances->count();

        return view('backend.accountsAndDeposits.balance-report', compact(
            'balances',
            'totalDeposits',
            'totalSpent',
            'totalWithdrawn',
            'totalCashWithdraws', // Pass to view
            'netBalance',
            'pupilCount'
        ));
    }
}
