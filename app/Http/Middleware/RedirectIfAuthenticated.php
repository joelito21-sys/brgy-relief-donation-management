<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        // If no specific guards are provided, use all possible guards
        $guards = empty($guards) ? ['web', 'donor', 'admin'] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Skip if this is an API request
                if ($request->expectsJson()) {
                    return response()->json(['error' => 'Already authenticated.'], 400);
                }

                // Check if the current route is for admin login
                if ($request->is('admin*') || $request->routeIs('admin.*')) {
                    // If accessing admin routes and authenticated as admin, redirect to admin dashboard
                    if ($guard === 'admin') {
                        return redirect()->route('admin.dashboard');
                    }
                    // If accessing admin routes but authenticated as donor or other, allow access to admin login
                    // This allows donors to access admin login page without being redirected
                    continue;
                }

                // For non-admin routes, redirect based on the guard
                switch ($guard) {
                    case 'admin':
                        return redirect()->route('admin.dashboard');
                    case 'donor':
                        return redirect()->route('donor.dashboard');
                    default:
                        // For web guard, redirect to the appropriate login page
                        if (request()->is('admin*')) {
                            return redirect()->route('admin.login');
                        }
                        return redirect()->route('donor.login');
                }
            }
        }

        return $next($request);
    }
}
