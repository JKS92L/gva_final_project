<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class studentController extends Controller
{
    public function studentDetails()
    {
        return view('admin.students.student-details');
    }

    public function studentAdmission()
    {
        return view('admin.students.student-admission');
    }

    public function onlineAdmission()
    {
        return view('admin.students.online-admission');
    }

    public function disableStudent()
    {
        return view('admin.students.disable-students');
    }

    public function bulkDelete(){
        return view('admin.students.bulk-delete');
    }

    public function stuentCatergories()
    {
        return view('admin.students.student-categories');
    }

    public function stuentRegister()
    {
        return view('admin.students.student-register');
    }






}
