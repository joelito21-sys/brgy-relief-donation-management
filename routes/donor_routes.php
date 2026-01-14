<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\DonorAuthenticatedSessionController;
use App\Http\Controllers\Auth\DonorRegisteredUserController;
use App\Http\Controllers\Auth\Donor\DonorForgotPasswordController;
use App\Http\Controllers\Auth\Donor\DonorResetPasswordController;
use App\Http\Controllers\Donor\DashboardController;
use App\Http\Controllers\Donor\Donation\DonationHistoryController;
use App\Http\Controllers\Donor\Donation\CashDonationController;
use App\Http\Controllers\Donor\Donation\FoodDonationController;
use App\Http\Controllers\Donor\Donation\ClothingDonationController;
use App\Http\Controllers\Donor\Donation\MedicineDonationController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\Donor\ProfileController;

Route::prefix('donor')
    ->name('donor.')
    ->middleware(['web'])
    ->group(function () {
        // Authentication Routes
        Route::middleware(['guest:donor'])->group(function () {
            // Login
            Route::get('login', [DonorAuthenticatedSessionController::class, 'create'])->name('login');
            Route::post('login', [DonorAuthenticatedSessionController::class, 'store']);
            
            // Register
            Route::get('register', [\App\Http\Controllers\Auth\DonorRegisteredUserController::class, 'create'])->name('register');
            Route::post('register', [\App\Http\Controllers\Auth\DonorRegisteredUserController::class, 'store']);

            // Email Verification
            Route::get('verify-email', [\App\Http\Controllers\Auth\DonorEmailVerificationController::class, 'show'])->name('verification.show');
            Route::post('verify-email', [\App\Http\Controllers\Auth\DonorEmailVerificationController::class, 'verify'])->name('verification.verify');
            Route::post('verify-email/resend', [\App\Http\Controllers\Auth\DonorEmailVerificationController::class, 'resend'])->name('verification.resend');
            
            // OTP Password Reset Routes
            Route::get('forgot-password', [\App\Http\Controllers\Auth\Donor\DonorForgotPasswordOtpController::class, 'showLinkRequestForm'])->name('password.request');
            Route::post('forgot-password', [\App\Http\Controllers\Auth\Donor\DonorForgotPasswordOtpController::class, 'sendResetOtp'])->name('password.otp.send');
            Route::get('verify-otp', [\App\Http\Controllers\Auth\Donor\DonorForgotPasswordOtpController::class, 'showVerifyOtpForm'])->name('password.otp.verify');
            Route::post('verify-otp', [\App\Http\Controllers\Auth\Donor\DonorForgotPasswordOtpController::class, 'verifyOtp'])->name('password.otp.verify.process');
            Route::get('reset-password', [\App\Http\Controllers\Auth\Donor\DonorForgotPasswordOtpController::class, 'showResetForm'])->name('password.reset.form');
            Route::post('reset-password', [\App\Http\Controllers\Auth\Donor\DonorForgotPasswordOtpController::class, 'resetPassword'])->name('password.reset.process');
        });

        // Protected Routes
        Route::middleware(['auth:donor'])->group(function () {
            // Dashboard
            Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
            
            // Profile
            Route::get('profile', [ProfileController::class, 'edit'])->name('profile');
            Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

            // Donation Management
            Route::prefix('donations')->name('donations.')->group(function () {
                // Main donation type selection
                Route::get('/', function () {
                    return view('donor.donations.types.index');
                })->name('index');
                
                // Donation History
                Route::get('history', [DonationHistoryController::class, 'index'])->name('history');
                
                // Cash Donations
                Route::prefix('cash')
                    ->name('cash.')
                    ->controller(CashDonationController::class)
                    ->group(function () {
                        // Show donation form
                        Route::get('/', 'index')->name('index');
                        
                        // Handle payment method selection
                        Route::post('/redirect', 'redirectToPayment')->name('redirect');
                        
                        // Payment method pages
                        Route::get('/payment/{method}', 'showPaymentPage')
                            ->where('method', 'gcash|paymaya|bank|walkin')
                            ->name('payment');
                            
                        // Update amount for payment method
                        Route::post('/payment/{method}/amount', 'updateAmount')
                            ->where('method', 'gcash|paymaya|bank|walkin')
                            ->name('update-amount');
                            
                        // Payment gateway simulation pages
                        Route::get('/gateway/{method}', 'showPaymentGateway')
                            ->where('method', 'gcash|paymaya|bank')
                            ->name('gateway');
                            
                        // Process payment
                        Route::post('/process/{method}', 'processPayment')
                            ->where('method', 'gcash|paymaya|bank|walkin')
                            ->name('process');
                            
                        // Thank you page
                        Route::get('thank-you/{donation}', 'thankYou')
                            ->name('thank-you');
                    });
                
                // Food Donations
                Route::get('food', [FoodDonationController::class, 'create'])->name('food.create');
                Route::post('food', [FoodDonationController::class, 'store'])->name('food.store');
                
                // Clothing Donations
                Route::get('clothing', [ClothingDonationController::class, 'create'])->name('clothing.create');
                Route::post('clothing', [ClothingDonationController::class, 'store'])->name('clothing.store');
                
                // Medicine Donations
                Route::get('medicine', [MedicineDonationController::class, 'create'])->name('medicine.create');
                Route::post('medicine', [MedicineDonationController::class, 'store'])->name('medicine.store');
                
                // QR Code for Donation Tracking
                Route::get('{donation}/qrcode', [QrCodeController::class, 'show'])->name('qrcode');
            });

            // Logout
            Route::post('logout', [DonorAuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
                
            // Additional donation routes
            Route::prefix('donations')->name('donations.')->group(function () {
                // Show single donation
                Route::get('{donation}', [DonationHistoryController::class, 'show'])->name('show');
                Route::get('thank-you/{donation}', [DonationHistoryController::class, 'thankYou'])->name('thank-you');
                
                // Cash Donation Routes
                Route::prefix('cash')
                    ->name('cash.')
                    ->controller(CashDonationController::class)
                    ->group(function () {
                        // Show donation form
                        Route::get('/', 'index')->name('index');
                        
                        // Handle payment method selection
                        Route::post('/redirect', 'redirectToPayment')->name('redirect');
                        
                        // Payment method pages
                        Route::get('/payment/{method}', 'showPaymentPage')
                            ->where('method', 'gcash|paymaya|bank|walkin')
                            ->name('payment');
                            
                        // Process payment
                        Route::post('/process/{method}', 'processPayment')
                            ->where('method', 'gcash|paymaya|bank|walkin')
                            ->name('process');
                            
                        // Thank you page
                        Route::get('thank-you/{donation}', 'thankYou')
                            ->name('thank-you');
                    });
                
                // Food Donation Routes
                Route::prefix('food')
                    ->name('food.')
                    ->controller(FoodDonationController::class)
                    ->group(function () {
                        Route::get('/', 'index')->name('index');
                        Route::post('/', 'store')->name('store');
                    });
                
                // Clothing Donation Routes
                Route::prefix('clothing')
                    ->name('clothing.')
                    ->controller(ClothingDonationController::class)
                    ->group(function () {
                        Route::get('/', 'index')->name('index');
                        Route::post('/', 'store')->name('store');
                    });
                
                // Medicine Donation Routes
                Route::prefix('medicine')
                    ->name('medicine.')
                    ->controller(MedicineDonationController::class)
                    ->group(function () {
                        Route::get('/', 'index')->name('index');
                        Route::post('/', 'store')->name('store');
                    });
            });
            
            // Additional Features
            Route::get('activities', function () {
                return view('donor.activities');
            })->name('activities');
            
            // About Page
            Route::get('about', function () {
                // Get total donations amount
                $totalDonations = 0;
                $peopleHelped = 0;
                $totalDonors = 0;
                $completedReliefRequests = 0;

                try {
                    // Get total donations amount
                    $totalDonations = \App\Models\Donation::sum('amount') ?? 0;
                    
                    // Get total people helped (from relief requests)
                    if (class_exists(\App\Models\ReliefRequest::class)) {
                        $peopleHelped = \App\Models\ReliefRequest::whereIn('status', ['delivered', 'claimed'])
                            ->sum('family_members') ?? 0;
                            
                        $completedReliefRequests = \App\Models\ReliefRequest::whereIn('status', ['delivered', 'claimed'])->count();
                    }
                    
                    // Get total number of donors
                    $totalDonors = \App\Models\Donor::count();
                    
                } catch (\Exception $e) {
                    // Log the error but don't break the page
                    \Log::error('Error loading donor about page statistics: ' . $e->getMessage());
                }
                
                return view('donor.about', [
                    'totalDonations' => $totalDonations,
                    'peopleHelped' => $peopleHelped,
                    'totalDonors' => $totalDonors,
                    'completedReliefRequests' => $completedReliefRequests
                ]);
            })->name('about');
            
            // Contact Page
            // Contact Page
            Route::match(['get', 'post'], 'contact', function (\Illuminate\Http\Request $request) {
                if ($request->isMethod('post')) {
                    $validated = $request->validate([
                        'name' => 'required|string|max:255',
                        'email' => 'required|email|max:255',
                        'subject' => 'required|string|max:255',
                        'message' => 'required|string',
                    ]);

                    \App\Models\ContactMessage::create([
                        ...$validated,
                        'donor_id' => \Illuminate\Support\Facades\Auth::guard('donor')->id(),
                    ]);
                    
                    return back()->with('success', 'Thank you for contacting us! Your message has been sent successfully.');
                }
                return view('donor.contact');
            })->name('contact');

            // My Messages
            Route::get('messages', [\App\Http\Controllers\Donor\MessageController::class, 'index'])->name('messages.index');
            Route::get('messages/{message}', [\App\Http\Controllers\Donor\MessageController::class, 'show'])->name('messages.show');

            // QR Code Generation
            Route::prefix('qrcode')->name('qrcode.')->group(function () {
                Route::get('gcash', [QrCodeController::class, 'generateGcashQr'])->name('gcash');
                Route::get('paymaya', [QrCodeController::class, 'generatePaymayaQr'])->name('paymaya');
                Route::get('bank', [QrCodeController::class, 'generateBankQr'])->name('bank');
            });
            
            // Settings
            Route::get('settings', function () {
                return view('donor.settings');
            })->name('settings');
        });
    });