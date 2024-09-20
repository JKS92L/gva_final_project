<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Submenu;
use Illuminate\Http\Request;

class AdminSidebarController extends Controller
{
    /**
     * Display a listing of the menus and their submenus.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Fetch active menus with their active submenus
        $menus = Menu::with(['submenus' => function ($query) {
            $query->where('is_active', 1); // Fetch only active submenus
        }])->where('is_active', 1)->get(); // Fetch only active menus

        return view('admin.body.left-sidebar', compact('menus')); // Return the data to the sidebar view
    }

    /**
     * Show the form for creating a new menu or submenu.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sidebar-create'); // Render form for creating menu or submenu
    }

    /**
     * Store a newly created menu in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'menu_name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
        ]);

        // Create a new menu
        Menu::create([
            'menu_name' => $request->input('menu_name'),
            'icon' => $request->input('icon'),
            'is_active' => $request->input('is_active', 1),
        ]);

        return redirect()->route('admin.sidebar.index')->with('success', 'Menu created successfully.');
    }

    /**
     * Display the specified menu with its submenus.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        $menu->load('submenus'); // Load related submenus

        return view('admin.sidebar-show', compact('menu')); // Display the menu and submenus
    }

    /**
     * Show the form for editing the specified menu.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        return view('admin.sidebar-edit', compact('menu')); // Display the edit form
    }

    /**
     * Update the specified menu in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        // Validate input
        $request->validate([
            'menu_name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
        ]);

        // Update menu
        $menu->update([
            'menu_name' => $request->input('menu_name'),
            'icon' => $request->input('icon'),
            'is_active' => $request->input('is_active', $menu->is_active),
        ]);

        return redirect()->route('admin.sidebar.index')->with('success', 'Menu updated successfully.');
    }

    /**
     * Remove the specified menu from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        // Delete the menu
        $menu->delete();

        return redirect()->route('admin.sidebar.index')->with('success', 'Menu deleted successfully.');
    }
}
