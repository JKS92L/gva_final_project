<?php

namespace App\Http\Controllers;

use App\Services\MenuService; 
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // fetch the menus and submenus based on the role
    public function dashboard()
    {
        // Fetch menus for the logged-in user
        $menus = MenuService::getMenusByRole();

        // Determine the user's dashboard view based on their role
        $role = Auth::user()->role_id;

        switch ($role) {
            case 1: // Admin
                $view = 'admin.index'; //blade path
                break;
            case 2: // Teacher
                $view = 'users.teacher.index';
                break;
            case 3: // Student
                $view = 'users.student.index';
                break;
            case 5: // Parent
                $view = 'users.parent.index';
                break;
            default:
                abort(403, 'Unauthorized access.');
        }

        // Pass menus to the dashboard view
        return view($view, compact('menus'));
    }

    public function studentDashboard()
    {
        return view('dashboards.student');
    }

    // public function parentDashboard()
    // {
    //     return view('dashboards.parent');
    // }



}
