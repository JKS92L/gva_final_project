<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        if (Auth::check()) {
            // Redirect already authenticated users to their respective dashboard
            return $this->authenticated(request(), Auth::user());
        }

        return view('auth.login');
    }

    protected function authenticated(Request $request, $user)
    {
        $dashboardRoutes = [
            1 => 'admin.dashboard',   // Admin these are routes
            2 => 'teacher.dashboard', // Teacher
            3 => 'student.dashboard', // Student
            5 => 'parent.dashboard',  // Parent
        ];

        // Redirect to role-specific dashboard if defined, else fallback
        $route = $dashboardRoutes[$user->role_id] ?? '/';

        return redirect()->route($route);
    }
}
