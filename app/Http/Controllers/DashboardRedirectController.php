<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardRedirectController extends Controller
{
    /**
     * Redirect users to appropriate dashboard based on authentication status
     */
    public function redirect(Request $request)
    {
        if (Auth::guard('donor')->check()) {
            return redirect()->route('donor.dashboard');
        } elseif (Auth::guard('resident')->check()) {
            return redirect()->route('resident.dashboard');
        } elseif (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        } elseif (Auth::check()) {
            return view('dashboard');
        }
        
        // If not authenticated, redirect to donor login
        return redirect()->route('donor.login');
    }
}
