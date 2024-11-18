<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\Models\UserPermissions;
use App\Models\UserRole; // Assuming you are using the 'UserRole' model

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
    public function storeRole(Request $request)
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
    // Delete a role from the database
    public function editUserPermissions(Request $request, $id)
    {
        $role = UserRole::findOrFail($id);

        // Fetch all active menus and their active submenus
        $menus = Menu::with(['submenus' => function ($query) {
            $query->where('is_active', 1);
        }])->where('is_active', 1)->get();

        // Fetch all permissions for this role, grouped by menu and submenu
        $rolePermissions = UserPermissions::where('role_id', $id)
            ->get()
            ->groupBy(['menu_id', 'submenu_id']); // Group by menu and submenu for organized structure

        return view('backend.user_management.edit-user-roles', compact('role', 'menus', 'rolePermissions'));
    }


    //Save user permissions
    public function saveUserRolePermissions(Request $request, $role_id)
    {
        $permissions = $request->input('permissions', []);

        // Delete all existing permissions for this role to ensure a fresh start
        UserPermissions::where('role_id', $role_id)->delete();

        foreach ($permissions as $menuId => $menuPermissions) {
            // Save permissions for each menu
            UserPermissions::updateOrCreate(
                [
                    'role_id' => $role_id,
                    'menu_id' => $menuId,
                    'submenu_id' => null // Null for main menu permissions
                ],
                [
                    'can_view' => $menuPermissions['can_view'] ?? 0,
                    'can_add' => $menuPermissions['can_add'] ?? 0,
                    'can_edit' => $menuPermissions['can_edit'] ?? 0,
                    'can_delete' => $menuPermissions['can_delete'] ?? 0
                ]
            );

            // Save permissions for each submenu under the menu
            if (isset($menuPermissions['submenus'])) {
                foreach ($menuPermissions['submenus'] as $submenuId => $submenuPermissions) {
                    UserPermissions::updateOrCreate(
                        [
                            'role_id' => $role_id,
                            'menu_id' => $menuId,
                            'submenu_id' => $submenuId
                        ],
                        [
                            'can_view' => $submenuPermissions['can_view'] ?? 0,
                            'can_add' => $submenuPermissions['can_add'] ?? 0,
                            'can_edit' => $submenuPermissions['can_edit'] ?? 0,
                            'can_delete' => $submenuPermissions['can_delete'] ?? 0
                        ]
                    );
                }
            }
        }

        return redirect()->back()->with('success', 'Permissions updated successfully');
    }

}
