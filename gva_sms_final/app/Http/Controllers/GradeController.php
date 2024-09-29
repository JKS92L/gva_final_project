<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index()
    {
        $grades = Grade::all();
        return view('grades.index', compact('grades'));
    }

    public function create()
    {
        return view('grades.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'gradeno' => 'required|integer',
            'class_name' => 'required|string',
            'section' => 'nullable|string',
            'level' => 'nullable|string',
            'capacity' => 'nullable|integer',
            'status' => 'required|in:active,inactive'
        ]);

        Grade::create($validated);

        return redirect()->route('grades.index')->with('success', 'Grade created successfully!');
    }

    public function show(Grade $grade)
    {
        return view('grades.show', compact('grade'));
    }

    public function edit(Grade $grade)
    {
        return view('grades.edit', compact('grade'));
    }

    public function update(Request $request, Grade $grade)
    {
        $validated = $request->validate([
            'gradeno' => 'required|integer',
            'class_name' => 'required|string',
            'section' => 'nullable|string',
            'level' => 'nullable|string',
            'capacity' => 'nullable|integer',
            'status' => 'required|in:active,inactive'
        ]);

        $grade->update($validated);

        return redirect()->route('grades.index')->with('success', 'Grade updated successfully!');
    }

    public function destroy(Grade $grade)
    {
        $grade->delete();

        return redirect()->route('grades.index')->with('success', 'Grade deleted successfully!');
    }
}
