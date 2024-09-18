<?php

namespace App\Http\Helpers;

use App\Models\Menu;

class MenuHelper
{
    public static function getMenusForUser($user)


    
    {
        // $menus = MenuHelper::getMenusForUser($user);
        // dd($menus);  // Check if menus are being fetched

        
        return Menu::with(['submenus' => function ($query) use ($user) {
            
            $query->active()->whereIn('id', $user->submenus->pluck('id'));
        }])->active()->get();
    }
}
