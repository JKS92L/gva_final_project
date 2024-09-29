<?php

namespace App\Http\Controllers;

use App\Models\Hostel;
use Illuminate\Http\Request;

class HostelController extends Controller
{
    public function index()
    {
        // Fetch all hostels with the associated teacher
        $hostels = Hostel::with('teacher')->get();
        return response()->json($hostels);
    }

    public function create()
    {
        // Return view to create a hostel (for web if needed)
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'hostel_name' => 'required|string|max:100',
            'total_rooms' => 'required|string|max:20',
            'total_bedspaces' => 'required|string|max:200',
            'hostel_teacher_id' => 'required|exists:teachers,id',
            'status' => 'required|in:active,inactive',
            'hostel_gender' => 'required|in:male,female',
        ]);

        $hostel = Hostel::create($validatedData);

        return response()->json(['message' => 'Hostel created successfully', 'data' => $hostel]);
    }

    public function show($id)
    {
        $hostel = Hostel::with('teacher')->findOrFail($id);
        return response()->json($hostel);
    }

    public function edit($id)
    {
        // Return view to edit a hostel (for web if needed)
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'hostel_name' => 'required|string|max:100',
            'total_rooms' => 'required|string|max:20',
            'total_bedspaces' => 'required|string|max:200',
            'hostel_teacher_id' => 'required|exists:teachers,id',
            'status' => 'required|in:active,inactive',
            'hostel_gender' => 'required|in:male,female',
        ]);

        $hostel = Hostel::findOrFail($id);
        $hostel->update($validatedData);

        return response()->json(['message' => 'Hostel updated successfully', 'data' => $hostel]);
    }

    public function destroy($id)
    {
        $hostel = Hostel::findOrFail($id);
        $hostel->delete();

        return response()->json(['message' => 'Hostel deleted successfully']);
    }
}
