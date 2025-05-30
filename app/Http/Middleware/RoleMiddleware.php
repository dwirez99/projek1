<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        if (!Auth::user()->hasRole($role)) {
            abort(403, 'Unauthorized'); // atau redirect ke halaman lain
        }

        return $next($request);
    }
}
