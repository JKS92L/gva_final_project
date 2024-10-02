<?php

namespace App\Http\Controllers\Backend;

use App\Models\Fee;
use App\Models\User;
use App\Models\Grade;
use App\Models\Hostel;
use App\Models\Teacher;
use App\Models\Bedspace;
use App\Models\UserRole;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permission; // Assuming you have a Permission model

class UserManagementController extends Controller
{
    // Method to load the initial user list and hostels for the form
    public function view_user_List()
    {
        $departments = Department::all();
        $grades = Grade::all();
        $fees = Fee::all();
        $users = Teacher::all(); // Fetch all users
        $hostels = Hostel::all(); // Fetch all hostels

        return view('backend.user_management.user-list', compact('departments', 'grades', 'fees', 'hostels'));
    }

    // create teacher route


    // // AJAX method to fetch bedspaces for the selected hostel
    public function fetchBedspaces(Request $request)
    {
        $hostelId = $request->get('hostel_id');

        // Fetch bedspaces for the selected hostel
        if ($hostelId) {
            $bedspaces = Bedspace::where('hostel_id', $hostelId)->get();


            return view('backend.user_management.user-list', compact('bedspaces'));
            // return response()->json([
            //     'status' => 'success',
            //     'bedspaces' => $bedspaces
            // ]);
        }

        return response()->json(['status' => 'error', 'message' => 'Invalid hostel selected']);
    }
}
