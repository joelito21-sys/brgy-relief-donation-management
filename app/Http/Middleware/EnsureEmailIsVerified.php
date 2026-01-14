<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() ||
            ($request->user() instanceof \App\Models\Admin &&
             ! $request->user()->hasVerifiedEmail()) ||
            ($request->user() instanceof \App\Models\Donor &&
             ! $request->user()->hasVerifiedEmail())) {
            // Redirect to email verification page
            return redirect()->route('verification.notice')
                ->with('warning', 'Please verify your email address to access this page.');
        }
        
        return $next($request);
    }
}
