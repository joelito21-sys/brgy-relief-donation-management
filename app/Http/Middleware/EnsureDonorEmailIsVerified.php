<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureDonorEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $donor = Auth::guard('donor')->user();
        
        // Check if donor is authenticated and email is not verified
        if ($donor && !$donor->hasVerifiedEmail()) {
            // Log the donor out and redirect to verification
            Auth::guard('donor')->logout();
            
            return redirect()->route('donor.verification.show')
                ->with('error', 'Please verify your email address before accessing your dashboard.');
        }
        
        return $next($request);
    }
}
