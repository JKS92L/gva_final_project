<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Http\Requests\StoreAcademicYearRequest;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    // Display a listing of the academic years
    public function index()
    {
        $academicYears = AcademicYear::all();
        return response()->json($academicYears);
    }

    // Show the form for creating a new academic year
    public function create()
    {
        // Normally, this would return a view in a full app, but for an API:
        return response()->json(['message' => 'Provide academic year details']);
    }

    // Store a newly created academic year in storage
    public function store(StoreAcademicYearRequest $request)
    {
        $validated = $request->validated();
        $academicYear = AcademicYear::create($validated);

        return response()->json([
            'message' => 'Academic year created successfully',
            'data' => $academicYear
        ], 201);
    }

    // Display the specified academic year
    public function show($id)
    {
        $academicYear = AcademicYear::findOrFail($id);
        return response()->json($academicYear);
    }

    // Show the form for editing the specified academic year
    public function edit($id)
    {
        $academicYear = AcademicYear::findOrFail($id);
        return response()->json($academicYear);
    }

    // Update the specified academic year in storage
    public function update(StoreAcademicYearRequest $request, $id)
    {
        $academicYear = AcademicYear::findOrFail($id);
        $validated = $request->validated();

        $academicYear->update($validated);
        return response()->json([
            'message' => 'Academic year updated successfully',
            'data' => $academicYear
        ]);
    }

    // Remove the specified academic year from storage
    public function destroy($id)
    {
        $academicYear = AcademicYear::findOrFail($id);
        $academicYear->delete();

        return response()->json([
            'message' => 'Academic year deleted successfully'
        ], 204);
    }
}
