<?php

namespace App\Http\Controllers;

use App\Models\UserRole; // Assuming you are using the 'UserRole' model
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // Display a listing of roles
    public function index()
    {
        $roles = UserRole::all();
        return view('backend.user_management.user-roles', compact('roles'));
    }

    // Show the form for creating a new role
    public function create()
    {
        return view('roles.create');
    }

    // Store a newly created role in the database
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'role_name' => 'required|string|max:255|unique:user_roles',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        UserRole::create($validatedData);

        return redirect()->route('backend.user_management.user-roles')->with('success', 'Role created successfully.');
    }

    // Show the form for editing a role
    public function edit($id)
    {
        $role = UserRole::findOrFail($id);
        return view('roles.edit', compact('role'));
    }

    // Update an existing role in the database
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'role_name' => 'required|string|max:255|unique:user_roles,role_name,' . $id,
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $role = UserRole::findOrFail($id);
        $role->update($validatedData);

        return redirect()->route('backend.user_management.user-roles')->with('success', 'Role updated successfully.');
    }

    // Delete a role from the database
    public function destroy($id)
    {
        $role = UserRole::findOrFail($id);
        $role->delete();

        return redirect()->route('backend.user_management.user-roles')->with('success', 'Role deleted successfully.');
    }
}
