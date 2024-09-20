<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Fetch active menus and submenus
        $menus = Menu::with(['submenus' => function ($query) {
            $query->where('is_active', 1); // Fetch only active submenus
        }])->where('is_active', 1)->get(); // Fetch only active menus
        // Pass the menus to the view along with other data needed
        return view('admin.index', compact('menus'));
    }


}
