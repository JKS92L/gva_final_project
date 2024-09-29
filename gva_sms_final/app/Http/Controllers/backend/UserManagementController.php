<?php

namespace App\Http\Controllers\Backend;

use App\Models\Fee;
use App\Models\User;
use App\Models\Grade;
use App\Models\Hostel;
use App\Models\Teacher;
use App\Models\UserRole;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permission; // Assuming you have a Permission model

class UserManagementController extends Controller
{
    public function view_user_List()
    {
        $departments = Department::all();
        $grades = Grade::all();
        $fees = Fee::all();
        $users = Teacher::all(); // Fetch all users
        $hostels = Hostel::all();

        return view(
            'backend.user_management.user-list',
            compact(
                'departments',
                'grades',
                'fees',
                'hostels'
            )
        );
    }

    public function userResponsibility()
    {
        // Add any logic related to responsibilities
        return view('backend.user_management.user-responsibilities');
    }

    // public function userPermissions()
    // {
    //     $permissions = Permission::all(); // Fetch all permissions
    //     return view('backend.user_management.user-permissions', compact('permissions'));
    // }

    // public function userRoles()
    // {
    //     $roles = UserRole::all(); // Fetch all roles
    //     return view('backend.user_management.user-roles', compact('roles'));
    // }
}
