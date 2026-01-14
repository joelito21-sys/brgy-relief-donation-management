<?php

use App\Http\Controllers\Auth\ResidentAuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredResidentController;
use App\Http\Controllers\Auth\ResidentEmailVerificationController; // Add this
use App\Http\Controllers\Resident\DashboardController;
use App\Http\Controllers\Resident\ReliefRequestController;

// Resident Authentication Routes
Route::prefix('resident')->name('resident.')->group(function () {
    // Guest routes (not authenticated)
    Route::middleware(['guest:resident'])->group(function () {
        Route::get('/login', [ResidentAuthenticatedSessionController::class, 'create'])
            ->name('login');
            
        Route::post('/login', [ResidentAuthenticatedSessionController::class, 'store'])
            ->name('login.process');
        
        Route::get('/register', [RegisteredResidentController::class, 'create'])
            ->name('register');
            
        Route::post('/register', [RegisteredResidentController::class, 'store'])
            ->name('register.process');
            
        // Email Verification Routes
        Route::get('/verify-email', [ResidentEmailVerificationController::class, 'show'])
            ->name('verification.notice');
            
        Route::post('/verify-email', [ResidentEmailVerificationController::class, 'verify'])
            ->name('verification.verify');
            
        Route::post('/resend-verification', [ResidentEmailVerificationController::class, 'resend'])
            ->name('verification.resend');

        // OTP Password Reset Routes
        Route::get('forgot-password', [\App\Http\Controllers\Auth\Resident\ResidentForgotPasswordOtpController::class, 'showLinkRequestForm'])->name('password.request');
        Route::post('forgot-password', [\App\Http\Controllers\Auth\Resident\ResidentForgotPasswordOtpController::class, 'sendResetOtp'])->name('password.otp.send');
        Route::get('verify-otp', [\App\Http\Controllers\Auth\Resident\ResidentForgotPasswordOtpController::class, 'showVerifyOtpForm'])->name('password.otp.verify');
        Route::post('verify-otp', [\App\Http\Controllers\Auth\Resident\ResidentForgotPasswordOtpController::class, 'verifyOtp'])->name('password.otp.verify.process');
        Route::get('reset-password', [\App\Http\Controllers\Auth\Resident\ResidentForgotPasswordOtpController::class, 'showResetForm'])->name('password.reset.form');
        Route::post('reset-password', [\App\Http\Controllers\Auth\Resident\ResidentForgotPasswordOtpController::class, 'resetPassword'])->name('password.reset.process');
    });

    // Authenticated routes (basic auth required)
    Route::middleware(['auth:resident'])->group(function () {
        // Verification page (no approval required)
        Route::get('/verification', function () {
            return view('resident.auth.verification');
        })->name('verification');
        
        // Protected routes (approval required)
        Route::middleware(['resident.approved'])->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])
                ->name('dashboard');
            
            // Profile Management
            Route::get('/profile/edit', function () {
                return view('resident.profile.edit');
            })->name('profile.edit');
            
            Route::put('/profile', function () {
                // Handle profile update
                return back()->with('success', 'Profile updated successfully!');
            })->name('profile.update');
            
            Route::get('/profile/password', function () {
                return view('resident.profile.password');
            })->name('profile.password');
            
            // Relief Requests
            Route::get('/relief-requests', function () {
                $resident = auth()->guard('resident')->user();
                $reliefRequests = $resident->reliefRequests()->with(['items'])->latest()->get();
                $stats = [
                    'total_requests' => $resident->reliefRequests()->count(),
                    'pending_requests' => $resident->reliefRequests()->where('status', 'pending')->count(),
                    'approved_requests' => $resident->reliefRequests()->where('status', 'approved')->count(),
                    'completed_requests' => $resident->reliefRequests()->where('status', 'completed')->count(),
                ];
                return view('resident.relief-requests.index', compact('reliefRequests', 'stats'));
            })->name('relief-requests.index');
            
            Route::get('/relief-requests/create', function () {
                return view('resident.relief-requests.create');
            })->name('relief-requests.create');
            
            Route::post('/relief-requests', [ReliefRequestController::class, 'store'])
                ->name('relief-requests.store');
            
            Route::get('/relief-requests/{id}', [ReliefRequestController::class, 'show'])
                ->name('relief-requests.show');

            Route::get('/relief-requests/{id}/edit', [ReliefRequestController::class, 'edit'])
                ->name('relief-requests.edit');

            Route::put('/relief-requests/{id}', [ReliefRequestController::class, 'update'])
                ->name('relief-requests.update');
            
            Route::delete('/relief-requests/{id}', [ReliefRequestController::class, 'destroy'])
                ->name('relief-requests.destroy');
            
            // Donations Received
            Route::get('/donations', function () {
                $resident = auth()->guard('resident')->user();
                $distributions = $resident->receivedDonations()->with('distributed_items')->latest()->get();
                $stats = [
                    'total_received_items' => $distributions->sum(function($d) { return $d->distributed_items->count(); }),
                    'total_distributions' => $distributions->count(),
                    'last_distribution' => $distributions->first()?->distributed_at,
                ];
                return view('resident.donations.index', compact('distributions', 'stats'));
            })->name('donations.index');
            
            // Emergency Contact
            Route::get('/emergency', function () {
                return view('resident.emergency');
            })->name('emergency');
            
            // Help & Support
            Route::get('/help', function () {
                return view('resident.help');
            })->name('help');
        });
        
        // Logout route (no approval required)
        Route::post('/logout', [ResidentAuthenticatedSessionController::class, 'destroy'])
            ->name('logout');
    });
});