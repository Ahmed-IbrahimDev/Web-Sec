<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Check if the user has the required role(s).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|array  ...$roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // The super_admin has all permissions.
        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        // Handle role parsing correctly
        if (count($roles) === 1 && strpos($roles[0], '|') !== false) {
            // Single parameter with pipe-separated roles: 'admin|owner'
            $roleList = explode('|', $roles[0]);
        } else {
            // Multiple parameters or single role: ['admin'], ['admin', 'owner']
            $roleList = $roles;
        }

        if (!$user->hasAnyRole($roleList)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
