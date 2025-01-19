<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\FeeCatergories;

class FeeCatergoryController extends Controller
{
    /**
     * Display a listing of the fees.
     */
    public function index()
    {
        $fees = FeeCatergories::all();
        return response()->json($fees);
    }

    /**
     * Store a newly created fee in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fee_type' => 'required|string|max:255',
            'fee_interval' => 'required|string',
            'amount' => 'required|numeric',
            'student_type' => 'nullable|string',
            'account_no' => 'nullable|string',
        ]);

        $fee = FeeCatergories::create($request->all());
        return response()->json($fee, 201);
    }

    /**
     * Display the specified fee.
     */
    public function show(FeeCatergories $fee)
    {
        return response()->json($fee);
    }

    /**
     * Update the specified fee in storage.
     */
    public function update(Request $request, FeeCatergories $fee)
    {
        $request->validate([
            'fee_type' => 'required|string|max:255',
            'fee_interval' => 'required|string',
            'amount' => 'required|numeric',
            'student_type' => 'nullable|string',
            'account_no' => 'nullable|string',
        ]);

        $fee->update($request->all());
        return response()->json($fee);
    }

    /**
     * Remove the specified fee from storage.
     */
    public function destroy(FeeCatergories $fee)
    {
        $fee->delete();
        return response()->json(null, 204);
    }
}
