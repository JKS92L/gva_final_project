<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function viewProfile(){
        $user = Auth::user(); // Fetch the currently authenticated user
        return view('admin.profile', compact('user'));
    }
}
