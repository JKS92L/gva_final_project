<?php 
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Permission; // Assuming you have a Permission model

class UserManagementController extends Controller
{
    public function view_user_List()
    {
        $users = User::all(); // Fetch all users
        return view('backend.user_management.user-list', compact('users'));
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
