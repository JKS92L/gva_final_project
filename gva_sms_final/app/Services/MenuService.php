<?php

namespace App\Services;

use App\Models\Menu;
use Illuminate\Support\Facades\Auth;

// class MenuService
// {
//     /**
//      * Fetch unique menus based on user role permissions.
//      *
//      * @return \Illuminate\Database\Eloquent\Collection
//      */
//     public static function getMenusByRole()
//     {
//         $user = Auth::user(); // Get the logged-in user
//         $roleId = $user->role_id; // Get the user's role ID

//         // Fetch menus and submenus based on role permissions
//         $menus = Menu::with(['submenus' => function ($query) use ($roleId) {
//             $query->join('user_roles_permissions', function ($join) use ($roleId) {
//                 $join->on('submenus.id', '=', 'user_roles_permissions.submenu_id')
//                     ->where('user_roles_permissions.role_id', '=', $roleId)
//                     ->where('user_roles_permissions.can_view', '=', 1);
//             });
//         }])
//             ->join('user_roles_permissions', function ($join) use ($roleId) {
//                 $join->on('menus.id', '=', 'user_roles_permissions.menu_id')
//                     ->where('user_roles_permissions.role_id', '=', $roleId)
//                     ->where('user_roles_permissions.can_view', '=', 1);
//             })
//             ->where('menus.is_active', 1) // Only active menus
//             ->select('menus.*') // Select only menu columns
//             ->distinct() // Ensure unique menus
//             ->get();

//         return $menus;
//     }
// }
class MenuService
{
    public static function getMenusByRole()
    {
        $user = Auth::user(); // Get the logged-in user
        $roleId = $user->role_id; // Get the user's role ID

        // Fetch menus and submenus based on role permissions
        $menus = Menu::with(['submenus' => function ($query) use ($roleId) {
            $query->join('user_roles_permissions', function ($join) use ($roleId) {
                $join->on('submenus.id', '=', 'user_roles_permissions.submenu_id')
                    ->where('user_roles_permissions.role_id', '=', $roleId)
                    ->where('user_roles_permissions.can_view', '=', 1);
            })
                ->select('submenus.*'); // Select submenu columns
        }])
            ->join('user_roles_permissions', function ($join) use ($roleId) {
                $join->on('menus.id', '=', 'user_roles_permissions.menu_id')
                    ->where('user_roles_permissions.role_id', '=', $roleId)
                    ->where('user_roles_permissions.can_view', '=', 1);
            })
            ->where('menus.is_active', 1) // Only active menus
            ->select('menus.*') // Select menu columns
            ->distinct() // Ensure unique menus
            ->get();

        return $menus;
    }
}
