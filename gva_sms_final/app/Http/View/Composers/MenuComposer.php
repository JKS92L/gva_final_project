<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Menu;

class MenuComposer
{
    public function compose(View $view)
    {
        // Fetch active menus and submenus
        $menus = Menu::with(['submenus' => function ($query) {
            $query->where('is_active', 1); // Fetch only active submenus
        }])->where('is_active', 1)->get(); // Fetch only active menus

        // Share the menus with the view
        $view->with('menus', $menus);
    }
}
