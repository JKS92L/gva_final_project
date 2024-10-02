<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\Grade;
use App\Models\Hostel;
use App\Models\Teacher;
use App\Models\Bedspace;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class studentController extends Controller
{
    public function studentDetails()
    {
        return view('backend.students.student-details');
    }

    public function studentAdmission()
    {
        return view('backend.students.student-admission');
    }

    public function onlineAdmission()
    {
        return view('backend.students.online-admission');
    }

    public function disableStudent()
    {
        return view('backend.students.disable-students');
    }

    public function bulkDelete(){
        return view('backend.students.bulk-delete');
    }

    public function stuentCatergories()
    {
        return view('backend.students.student-categories');
    }

    // public function stuentRegister()
    // {
    //     return view('backend.students.student-register');
    // }

    // CRUD
    public function viewRegForm(){
        $departments = Department::all();
        $grades = Grade::all();
        $fees = Fee::all();
        // $users = Teacher::all(); // Fetch all users
        $hostels = Hostel::all(); // Fetch all hostels
        return view('backend.students.student-register', compact('departments', 'grades', 'fees', 'hostels'));
    }
    // AJAX method to fetch bedspaces for the selected hostel
    public function fetchBedspaces(Request $request)
    {
        $hostelId = $request->get('hostel_id');

        // Fetch bedspaces for the selected hostel
        if ($hostelId) {
            $bedspaces = Bedspace::where('hostel_id', $hostelId)->get();


           
            return response()->json([
                'status' => 'success',
                'bedspaces' => $bedspaces
            ]);
        }

        return response()->json(['status' => 'error', 'message' => 'Invalid hostel selected']);
    }




}
