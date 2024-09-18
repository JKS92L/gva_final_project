<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\MenuHelper;
use Illuminate\Support\Facades\Auth;

class SidebarController extends Controller
{
    public function index()
    {
        // Fetch the authenticated user
        $user = Auth::user();

        if (!$user) {
            return []; // or redirect to login
        }
        // Get menus for the user using the helper
        $menus = MenuHelper::getMenusForUser($user);
       dd($menus);
        // Pass menus to the sidebar view
        return view('adminlte::partials.sidebar.left-sidebar', compact('menus'));
        //sms_project/vendor/jeroennoten/laravel-adminlte/resources/views/partials/sidebar/left-sidebar.blade.php

      
    }
}
