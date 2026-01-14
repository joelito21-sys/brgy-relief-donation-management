<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\ReliefRequestController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\DonorController;
use App\Http\Controllers\Admin\DonationController;
use App\Http\Controllers\Admin\DistributionController;
use App\Http\Controllers\Admin\DistributionNotificationController;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ResidentManagementController;
use App\Http\Controllers\Admin\PaymentAccountController;
use App\Http\Controllers\Admin\SearchController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Guest routes (not authenticated)
        Route::middleware('guest:admin')->group(function () {
            Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login.form');
            Route::post('/login', [AdminAuthController::class, 'login'])->name('login');
        });

        // Test route to verify admin routes are working
        Route::get('/test', function() {
            return 'Admin routes are working!';
        })->name('test');
        
        // Logout route (should be accessible when authenticated)
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        // Protected admin routes (require authentication)
        Route::middleware(['auth:admin'])->group(function () {
            // Dashboard
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
            
            // Activity Logs
            Route::get('/activities', [ActivityLogController::class, 'index'])->name('activities');
            
            // Profile
            Route::get('/profile', [AdminAuthController::class, 'profile'])->name('profile');
            Route::put('/profile', [AdminAuthController::class, 'updateProfile'])->name('profile.update');
            
            // Admin Users Management
            Route::resource('admins', AdminUserController::class)->except(['show']);
            
            // Residents Management
            Route::get('residents/create', [ResidentManagementController::class, 'create'])->name('residents.create');
            Route::post('residents', [ResidentManagementController::class, 'store'])->name('residents.store');
            Route::get('residents', [ResidentManagementController::class, 'index'])->name('residents.index');
            Route::get('residents/{resident}', [ResidentManagementController::class, 'show'])->name('residents.show');
            Route::post('residents/{resident}/approve', [ResidentManagementController::class, 'approve'])->name('residents.approve');
            Route::post('residents/{resident}/reject', [ResidentManagementController::class, 'reject'])->name('residents.reject');
            Route::post('residents/bulk-approve', [ResidentManagementController::class, 'bulkApprove'])->name('residents.bulk.approve');
            Route::post('residents/bulk-reject', [ResidentManagementController::class, 'bulkReject'])->name('residents.bulk.reject');
            Route::delete('residents/{resident}', [ResidentManagementController::class, 'destroy'])->name('residents.destroy');
            
            // Areas Management
            Route::resource('areas', AreaController::class);
            
            // Donors Management
            Route::resource('donors', DonorController::class);
            Route::patch('donors/{donor}/toggle-status', [DonorController::class, 'toggleStatus'])->name('donors.toggle-status');
        
            // Donations Management
            Route::resource('donations', DonationController::class);
            Route::post('donations/bulk-update', [DonationController::class, 'bulkUpdate'])->name('donations.bulk-update');
            Route::post('donations/{donation}/accept', [DonationController::class, 'accept'])->name('donations.accept');
            Route::post('donations/{donation}/reject', [DonationController::class, 'reject'])->name('donations.reject');
            Route::get('donations/type/{type}', [DonationController::class, 'showByType'])->name('donations.type');
            Route::patch('donations/{donation}/status', [DonationController::class, 'updateStatus'])->name('donations.updateStatus');
        
            // Relief Requests Management
            Route::resource('relief-requests', ReliefRequestController::class);
        
            // Inventory Management
            Route::resource('inventory', InventoryController::class);
        
            // Distributions Management
            Route::resource('distributions', DistributionController::class);
        
            // Distribution Notifications Management
            Route::resource('distribution-notifications', DistributionNotificationController::class);
            Route::post('distribution-notifications/{distributionNotification}/send', [DistributionNotificationController::class, 'send'])->name('distribution-notifications.send');
        
            // QR Scanner for Distribution Confirmations
            Route::prefix('scanner')->name('scanner.')->group(function () {
                Route::get('/', [\App\Http\Controllers\Admin\QRScannerController::class, 'index'])->name('index');
                Route::post('/verify', [\App\Http\Controllers\Admin\QRScannerController::class, 'verify'])->name('verify');
                Route::post('/confirm', [\App\Http\Controllers\Admin\QRScannerController::class, 'confirm'])->name('confirm');
                Route::get('/stats/{notification}', [\App\Http\Controllers\Admin\QRScannerController::class, 'stats'])->name('stats');
            });
        
            // Reports
            Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
            Route::post('reports/generate', [ReportController::class, 'generate'])->name('reports.generate');
            
            // Test route for reports
            Route::get('reports/test', function() {
                \Log::info('Test route called');
                return 'Test route working';
            })->name('reports.test');
        
            // Analytics
            Route::get('analytics', [AnalyticsController::class, 'index'])->name('analytics');
        
            // Settings
            Route::get('settings', [SettingController::class, 'index'])->name('settings');
            Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
            
            // Payment Accounts
            Route::get('payment-accounts/gcash', [PaymentAccountController::class, 'gcash'])->name('payment-accounts.gcash');
            Route::get('payment-accounts/paymaya', [PaymentAccountController::class, 'paymaya'])->name('payment-accounts.paymaya');
            Route::get('payment-accounts/bank', [PaymentAccountController::class, 'bank'])->name('payment-accounts.bank');
            
            // Search
            Route::get('search', [SearchController::class, 'search'])->name('search');
            
            // Bulk actions for relief requests
            Route::post('relief-requests/bulk', [ReliefRequestController::class, 'bulkUpdate'])->name('relief-requests.bulk');
            
            // Export relief requests
            Route::post('relief-requests/export', [ReliefRequestController::class, 'export'])->name('relief-requests.export');
            
            // Relief request verification route
            Route::get('relief-requests/verify/{claimCode}', [ReliefRequestController::class, 'verify'])->name('relief-requests.verify');
            
            // Additional routes for relief requests
            Route::prefix('relief-requests/{reliefRequest}')->name('relief-requests.')->group(function () {
                // Approve a relief request
                Route::patch('approve', [ReliefRequestController::class, 'approve'])->name('approve');
                
                // Reject a relief request
                Route::patch('reject', [ReliefRequestController::class, 'reject'])->name('reject');
                
                // Mark as ready for pickup
                Route::patch('ready-for-pickup', [ReliefRequestController::class, 'readyForPickup'])->name('ready-for-pickup');
                
                // Mark as claimed
                Route::patch('mark-claimed', [ReliefRequestController::class, 'markAsClaimed'])->name('mark-claimed');
                
                // Mark as delivered
                Route::patch('mark-delivered', [ReliefRequestController::class, 'markAsDelivered'])->name('mark-delivered');
                
                // Download QR code
                Route::get('download-qr', [ReliefRequestController::class, 'downloadQrCode'])->name('download-qr');
                
                // Print claim slip
                Route::get('print', [ReliefRequestController::class, 'print'])->name('print');
                
                // Activity logs
                Route::get('activity-logs', [ReliefRequestController::class, 'activityLogs'])->name('activity-logs');
            });
            
            // Contact Messages Management
            Route::resource('contact-messages', \App\Http\Controllers\Admin\ContactMessageController::class)->only(['index', 'show', 'destroy']);
            Route::post('contact-messages/{contactMessage}/reply', [\App\Http\Controllers\Admin\ContactMessageController::class, 'reply'])->name('contact-messages.reply');
            
        }); // End of auth:admin middleware group
    }); // End of admin. route group