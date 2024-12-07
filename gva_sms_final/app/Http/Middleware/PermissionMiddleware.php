<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
{
    public function handle($request, Closure $next, $permission)
    {
        $user = Auth::user();

        // Check if the user has the required permission
        if (!$user->hasPermission($permission)) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
