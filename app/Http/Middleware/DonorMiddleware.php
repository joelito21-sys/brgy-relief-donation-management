<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DonorMiddleware
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
        if (!Auth::guard('donor')->check()) {
            return redirect()->route('donor.login')
                ->with('error', 'Please login to access the donor area.');
        }

        // Since we're using a dedicated Donor model and guard,
        // any authenticated user is a donor
        return $next($request);
    }
}
