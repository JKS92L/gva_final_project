<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller; // Import the base Controller class
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function viewProfile()
    {
        $user = Auth::user(); // Fetch the currently authenticated user
        return view('backend.profile', compact('user'));
    }
}

