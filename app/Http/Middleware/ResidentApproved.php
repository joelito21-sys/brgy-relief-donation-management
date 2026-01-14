<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ResidentApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $resident = Auth::guard('resident')->user();
        
        // Check if user is authenticated as resident
        if (!$resident) {
            return redirect()->route('resident.login');
        }
        
        // Check if resident is approved
        if (!$resident->isApproved()) {
            // If rejected, show error and logout
            if ($resident->isRejected()) {
                Auth::guard('resident')->logout();
                return redirect()->route('resident.login')
                    ->with('error', 'Your registration has been rejected. Please contact support for more information.');
            }
            
            // If pending, redirect to verification page
            return redirect()->route('resident.verification');
        }
        
        return $next($request);
    }
}
