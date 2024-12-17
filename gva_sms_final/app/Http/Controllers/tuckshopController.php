<?php
namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\TuckShopItem;
use Illuminate\Http\Request;
use App\Models\AcademicSession;
use App\Models\TuckshopInventory;
use App\Helpers\TransactionHelper;
use App\Models\PocketMoneyAccount;
use Illuminate\Support\Facades\DB;
use App\Models\TuckShopTransaction;
use App\Models\PocketMoneyTransaction;
use Illuminate\Support\Facades\Log; // Import the Log facade

class tuckshopController extends Controller
{
    public function viewSales()
    {

        $deposits = PocketMoneyAccount::with('student')
            ->orderBy('created_at', 'desc')
            ->get();

        $students = Student::with(['grade', 'guardians'])->get();

        $items = TuckshopInventory::all()->map(function ($item) {
            $item->price = (float) $item->price; // Ensure price is numeric
            return $item;
        });

        // Paginate transactions (10 per page)
        $transactions = TuckShopTransaction::with(['student', 'tuckshop_item'])
            ->orderBy('transaction_date', 'desc')
            ->paginate(10);


        // Fetch active academic sessions, sorted by the newest year first
        $academicSessions = AcademicSession::where('is_active', 1)->orderBy('academic_year', 'desc')->get();

        // Prepare terms in the sorted order
        $terms = [];
        foreach ($academicSessions as $session) {
            $terms[] = ['id' => $session->id . '-term1', 'name' => $session->academic_year . ' - Term 1'];
            $terms[] = ['id' => $session->id . '-term2', 'name' => $session->academic_year . ' - Term 2'];
            $terms[] = ['id' => $session->id . '-term3', 'name' => $session->academic_year . ' - Term 3'];
        }

        return view('backend.tuckshop.tuckshop-sales', compact('deposits', 'students', 'items', 'transactions','terms'));
    }

    // Handle sales transaction
    public function processTransaction(Request $request)
    {
        try {
            // Log incoming request data
            Log::info('Processing transaction request', $request->all());

            // Step 1: Validate input
            $validated = $request->validate([
                'academic_term' => 'required', // Assume the input is in the format "sessionId-termId" (e.g., "1-2")
                'student_id' => 'required|exists:students,id',
                'item_id' => 'required|array',
                'item_id.*' => 'exists:tuckShop_items,id',
                'quantity' => 'required|array',
                'quantity.*' => 'integer|min:1',
                'total_cost' => 'required|numeric|min:0',
                'withdraw_code' => 'required|string',
            ]);

            // Step 2: Extract academic session ID and term ID
            if (!str_contains($validated['academic_term'], '-')) {
                Log::warning('Invalid academic_term format', ['academic_term' => $validated['academic_term']]);
                return back()->with('error', 'Invalid academic term format.');
            }

            list($academicSessionId, $termId) = explode('-', $validated['academic_term']);
            Log::info('Academic session and term extracted', [
                'academic_session_id' => $academicSessionId,
                'term_id' => $termId,
            ]);

            // Step 3: Verify Student's Account and Balance
            $studentAccount = PocketMoneyAccount::where([
                'student_id' => $validated['student_id'],
                'withdraw_code' => $validated['withdraw_code']
            ])->first();

            if (!$studentAccount) {
                Log::warning('Invalid withdraw code or account not found', [
                    'student_id' => $validated['student_id'],
                    'withdraw_code' => $validated['withdraw_code']
                ]);
                return back()->with('error', 'Invalid withdraw code provided.');
            }

            if ($studentAccount->current_amount < $validated['total_cost']) {
                Log::warning('Insufficient funds in account', [
                    'student_id' => $validated['student_id'],
                    'current_balance' => $studentAccount->current_amount,
                    'required_amount' => $validated['total_cost'],
                ]);
                return back()->with('error', 'Insufficient funds in the student’s account.');
            }

            // Step 4: Process Transaction
            DB::beginTransaction();
            Log::info('Transaction processing started', ['student_id' => $validated['student_id']]);

            $balanceBefore = $studentAccount->current_amount;
            $balanceAfter = $balanceBefore - $validated['total_cost'];

            // Deduct the total cost from the student's account
            $studentAccount->update(['current_amount' => $balanceAfter]);
            Log::info('Account balance updated', [
                'student_id' => $validated['student_id'],
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
            ]);

            // Log tuckshop transactions and collect their IDs
            $tuckShopTransactionIds = [];

            foreach ($validated['item_id'] as $index => $itemId) {
                $quantity = $validated['quantity'][$index];
                $item = TuckShopItem::findOrFail($itemId);

                if ($item->stock_quantity < $quantity) {
                    Log::warning('Item out of stock or insufficient quantity', [
                        'item_id' => $itemId,
                        'requested_quantity' => $quantity,
                        'available_stock' => $item->stock_quantity,
                    ]);
                    throw new \Exception("Item {$item->name} is out of stock or has insufficient quantity.");
                }

                // Deduct stock for the item
                $item->decrement('stock_quantity', $quantity);
                Log::info('Stock deducted', ['item_id' => $itemId, 'quantity' => $quantity]);

                // Log the individual item purchase in `TuckShopTransaction`
                $tuckShopTransaction = TuckShopTransaction::create([
                    'student_id' => $validated['student_id'],
                    'academic_session_id' => $academicSessionId,
                    'academic_term' => $termId,
                    'item_id' => $itemId,
                    'quantity' => $quantity,
                    'total_cost' => $quantity * $item->price,
                    'transaction_date' => now(),
                    'reference_transaction_id' => TransactionHelper::generateTransactionId(),
                ]);

                $tuckShopTransactionIds[] = $tuckShopTransaction->id; // Collect the transaction ID
            }

            // Log the overall transaction in `pocket_money_transactions`
            foreach ($tuckShopTransactionIds as $transactionId) {
                PocketMoneyTransaction::create([
                    'transaction_type' => 'purchase',
                    'transaction_id' => $transactionId, // Use the tuckshop transaction ID
                    'transaction_amount' => $validated['total_cost'],
                    'balance_before' => $balanceBefore,
                    'balance_after' => $balanceAfter,
                    'transaction_date' => now(),
                    'description' => 'Tuck shop purchase',
                    'academic_term_id' => $termId,
                    'academic_session_id' => $academicSessionId,
                    'transaction_reference' => TransactionHelper::generateTransactionId(),
                    'status' => 'completed',
                ]);
            }

            Log::info('Transaction logged in pocket_money_transactions', ['student_id' => $validated['student_id']]);

            DB::commit();
            Log::info('Transaction committed successfully', ['student_id' => $validated['student_id']]);

            return back()->with('success', 'Transaction processed successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error', ['errors' => $e->errors()]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Transaction failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }


    


    //INVENTORY TAB
    public function viewInventory()
    {
        $inventory = TuckshopInventory::all();

        return view('backend.tuckshop.tuckshop-inventory-management', compact('inventory'));
    }

    public function addInventory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tuckShop_items,name',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'restock_level' => 'required|integer|min:0',
        ]);

        try {
            TuckshopInventory::create([
                'name' => $validated['name'],
                'price' => $validated['price'],
                'stock_quantity' => $validated['stock_quantity'],
                'restock_level' => $validated['restock_level'],
            ]);

            return redirect()->back()->with('success', 'Item added successfully!');
        } catch (\Exception $e) {
            Log::error('Error adding inventory: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to add item.');
        }
    }

    public function editInventory(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'restock_level' => 'required|integer|min:0',
        ]);

        try {
            $item = TuckshopInventory::findOrFail($id);
            $item->update($validated);

            return redirect()->back()->with('success', 'Item updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error editing inventory: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update item.');
        }
    }
    public function deleteInventory($id)
    {
        try {
            $item = TuckshopInventory::findOrFail($id);
            $item->delete();

            return redirect()->back()->with('success', 'Item deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Error deleting inventory: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete item.');
        }
    }
    public function updateInventory(Request $request, $id){
        
    }

}
