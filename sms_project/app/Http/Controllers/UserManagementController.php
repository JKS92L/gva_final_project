<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class UserManagementController extends Controller
{
    public function userList()
    {
        // Logic for user list
        return view('admin.user_management.user-list');
    }

    public function userPermissions()
    {
        // Logic for user permissions
        return view('admin.user_management.user-permissions');
    }
    public function showDashboard()
    {
        // Sample data
        $data = [
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'values' => [65, 80, 80, 81, 56, 55, 40]
        ];
        // Fetch data from database
        $salesData = [
            ['x' => 'January', 'value' => 10000],
            ['x' => 'February', 'value' => 12000],
            ['x' => 'March', 'value' => 18000],
            ['x' => 'April', 'value' => 11000]
        ];

        return view('admin.dashboard', compact('data', 'salesData'));
    }

    public function userResponsibility(){
        return view('admin.user_management.user-responsibilities');
    }

    
}


