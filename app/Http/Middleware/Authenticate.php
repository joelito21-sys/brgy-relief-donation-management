<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if ($request->is('admin/*')) {
                return route('admin.login.form');
            }
            if ($request->is('donor/*') || $request->is('donations/*')) {
                return route('donor.login');
            }
            // Default fallback to donor login since it's the main user type
            return route('donor.login');
        }
    }
}
