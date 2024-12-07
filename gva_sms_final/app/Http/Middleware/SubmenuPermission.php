<?php 
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class SubmenuPermission
{
public function handle($request, Closure $next)
{
$user = Auth::user();
$currentRoute = Route::currentRouteName(); // Get the current route name

// Check if the user has permission to view the route
$hasPermission = DB::table('user_roles_permissions')
->join('submenus', 'user_roles_permissions.submenu_id', '=', 'submenus.id')
->where('user_roles_permissions.role_id', $user->role_id)
->where('submenus.url', $currentRoute)
->where('user_roles_permissions.can_view', 1)
->exists();

if (!$hasPermission) {
abort(403, 'Unauthorized access.');
}

return $next($request);
}
}