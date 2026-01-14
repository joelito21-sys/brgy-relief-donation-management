<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login')
                ->with('error', 'Please login to access the admin area.');
        }

        // Check if the user has the admin role
        $user = Auth::guard('admin')->user();
        if (!$user->isAdmin()) {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login')
                ->with('error', 'You do not have permission to access the admin area.');
        }

        return $next($request);
    }
}
