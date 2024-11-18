<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\PocketMoneyAccount;

class AccountsAndDepositsController extends Controller
{
    // Display list of deposit records
    public function showDepositRecords()
    {
        $deposits = PocketMoneyAccount::with('student')->orderBy('deposit_date', 'desc')->get();
        $students = Student::with(['grade', 'parent'])->get();
        return view('backend.accountsAndDeposits.deposit-records', compact('deposits', 'students'));
    }

    // Store a new deposit record
    public function storeDeposit(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'deposit_amount' => 'required|numeric',
            'deposit_method' => 'required|in:cash,bank',
        ]);

        PocketMoneyAccount::create($request->all());

        return redirect()->back()->with('success', 'Deposit added successfully.');
    }
    // Update method to handle form submission
    public function updateDeposit(Request $request, $id)
    {
        $request->validate([
            'deposit_amount' => 'required|numeric|min:0',
            'deposit_method' => 'required|string|max:255',
            'receipt_number' => 'nullable|string|max:255',
            'deposit_date' => 'required|date',
        ]);

        $deposit = PocketMoneyAccount::findOrFail($id);
        $deposit->update([
            'deposit_amount' => $request->deposit_amount,
            'deposit_method' => $request->deposit_method,
            'receipt_number' => $request->receipt_number,
            'deposit_date' => $request->deposit_date,
        ]);

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
            ->orderBy('deposit_date', 'desc')
            ->get();
        $students = Student::with(['grade', 'parent'])->get();

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
        // $balanceReports = PocketMoneyAccount::with('pupil')
        //     ->selectRaw('pupil_id, SUM(deposit_amount) as total_deposits')
        //     ->groupBy('pupil_id')
        //     ->get();
///Applications/XAMPP/xamppfiles/htdocs/adminlte_pro1/gva_sms_final/resources/views/backend/accountsAndDeposits/balance-report.blade.php
        return view('backend.accountsAndDeposits.balance-report');
    }
}
