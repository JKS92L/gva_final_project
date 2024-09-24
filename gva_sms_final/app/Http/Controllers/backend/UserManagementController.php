<?php


namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class UserManagementController extends Controller
{
    public function userList()
    {
        // Logic for user list
        return view('backend.user_management.user-list');
        //resources/views/backend/user_management/user-list.blade.php
    }
    public function userResponsibility()
    {
        return view('backend.user_management.user-responsibilities');
    }
    public function userPermissions()
    {
        // Logic for user permissions
        return view('backend.user_management.user-permissions');
        
    }
}
