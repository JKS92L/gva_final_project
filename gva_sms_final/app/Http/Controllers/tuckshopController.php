<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\TuckshopInventory;
use App\Models\PocketMoneyAccount;

class tuckshopController extends Controller
{
    // public function viewSales()
    // {
    //     $deposits = PocketMoneyAccount::with('student')->orderBy('deposit_date', 'desc')->get();
    //     $students = Student::with(['grade', 'parent'])->get();

    //     // Add balance for each student and filter those with deposits > 0.00
    //     $students = $students->filter(function ($student) {
    //         $student->balance = PocketMoneyAccount::where('student_id', $student->id)
    //             ->sum('deposit_amount'); // Calculate the total deposits
    //         return $student->balance > 0; // Only include students with balance > 0
    //     });

    //     return view('backend.tuckshop.tuckshop-sales', compact('deposits', 'students'));
    // }

    public function viewSales()
    {
        $deposits = PocketMoneyAccount::with('student')->orderBy('deposit_date', 'desc')->get();
        $students = Student::with(['grade', 'parent'])->get();
        $items = TuckshopInventory::all()->map(function ($item) {
            $item->price = (float) $item->price; // Ensure price is a number
            return $item;
        });
        return view('backend.tuckshop.tuckshop-sales', compact('deposits', 'students', 'items'));
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
            \Log::error('Error editing inventory: ' . $e->getMessage());
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
}
