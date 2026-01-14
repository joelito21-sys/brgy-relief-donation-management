<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\DonationApprovedMail;
use App\Models\Donation;

Route::get('/test-email', function () {
    // Get the first approved donation or create a test one
    $donation = Donation::where('status', 'approved')->first();
    
    if (!$donation) {
        $donation = Donation::first();
        if ($donation) {
            $donation->status = 'approved';
            $donation->save();
        } else {
            return 'No donations found to test with.';
        }
    }
    
    // Send the email
    try {
        Mail::to('your-email@example.com')->send(new DonationApprovedMail($donation));
        return 'Test email sent successfully to your-email@example.com. Check your email and spam folder.';
    } catch (\Exception $e) {
        return 'Error sending email: ' . $e->getMessage();
    }
});
