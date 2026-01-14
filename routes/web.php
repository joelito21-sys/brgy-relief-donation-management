<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\DashboardRedirectController;
use App\Http\Controllers\PublicContactController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Main routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// About page with real statistics
Route::get('/about', function () {
    // Get total donations amount
    $totalDonations = 0;
    $topDonor = null;
    $peopleHelped = 0;
    $totalDonors = 0;
    $completedReliefRequests = 0;

    try {
        // Get total donations amount
        $totalDonations = \App\Models\Donation::sum('amount') ?? 0;
        
        // Get top donor
        $topDonor = \App\Models\Donor::select('donors.name', \DB::raw('SUM(donations.amount) as total_donated'))
            ->leftJoin('donations', 'donors.id', '=', 'donations.donor_id')
            ->groupBy('donors.id', 'donors.name')
            ->orderBy('total_donated', 'DESC')
            ->first();
        
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
        \Log::error('Error loading about page statistics: ' . $e->getMessage());
    }
    
    return view('about', [
        'totalDonations' => $totalDonations,
        'topDonor' => $topDonor,
        'peopleHelped' => $peopleHelped,
        'totalDonors' => $totalDonors,
        'completedReliefRequests' => $completedReliefRequests
    ]);
})->name('about');

// Terms of Service
Route::get('/terms', function () {
    return view('terms');
})->name('terms');

// Privacy Policy
Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

// Contact page
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact/send', [PublicContactController::class, 'store'])->name('contact.send');

// Authentication Routes
require __DIR__.'/auth.php';

// Resident Routes (load before donor routes to avoid conflicts)
require __DIR__.'/resident_routes.php';

// Donor Routes
require __DIR__.'/donor_routes.php';

// Include other route files
require __DIR__.'/admin.php';
require __DIR__.'/admin_donations.php';
require __DIR__.'/check-table.php';
require __DIR__.'/temp.php';
require __DIR__.'/api_appointments.php';

