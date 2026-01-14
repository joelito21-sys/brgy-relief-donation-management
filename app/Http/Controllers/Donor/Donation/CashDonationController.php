<?php

namespace App\Http\Controllers\Donor\Donation;

use Illuminate\Http\Request;
use App\Models\Donation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\CashDonationReceivedMail;

class CashDonationController extends BaseDonationController
{
    protected $donationType = 'cash';
    
    public function __construct()
    {
        $this->middleware('auth:donor');
    }
    
    /**
     * Show the cash donation form
     */
    public function index()
    {
        $donor = Auth::guard('donor')->user();
        
        return view('donor.donations.cash.index', [
            'donation' => session('pending_donation'),
            'donor' => $donor
        ]);
    }
    
    /**
     * Show the payment page for the selected method
     */
    public function showPaymentPage(Request $request, $method)
    {
        // Check if there's a pending donation in session
        $donation = $request->session()->get('pending_donation');
        
        // If no pending donation, create a temporary one with default values
        if (!$donation) {
            $donor = Auth::guard('donor')->user();
            $donation = [
                'amount' => ($method !== 'walkin') ? 0 : null, // Walk-in doesn't require amount
                'payment_method' => $method,
                'donation_id' => (string) Str::uuid(),
                'donor_name' => $donor->name,
                'donor_email' => $donor->email,
                'donor_phone' => $donor->phone ?? null,
                'message' => null
            ];
        }
        
        if (!in_array($method, ['gcash', 'paymaya', 'bank', 'walkin'])) {
            return redirect()->route('donor.donations.cash.index')
                ->with('error', 'Invalid payment method.');
        }
        
        return view("donor.donations.cash.payment.{$method}", [
            'amount' => $donation['amount'],
            'paymentMethod' => $method,
            'donationId' => $donation['donation_id'],
            'donorName' => $donation['donor_name'],
            'donorEmail' => $donation['donor_email'],
            'donorPhone' => $donation['donor_phone'],
            'message' => $donation['message'] ?? null
        ]);
    }
    
    /**
     * Show the payment gateway simulation page
     */
    public function showPaymentGateway(Request $request, $method)
    {
        // Check if there's a pending donation in session
        $donation = $request->session()->get('pending_donation');
        
        if (!$donation || $donation['amount'] <= 0) {
            return redirect()->route('donor.donations.cash.payment', ['method' => $method])
                ->with('error', 'Please set a donation amount first.');
        }
        
        if (!in_array($method, ['gcash', 'paymaya', 'bank'])) {
            return redirect()->route('donor.donations.cash.index')
                ->with('error', 'Invalid payment method.');
        }
        
        return view("donor.donations.cash.payment.{$method}-gateway", [
            'amount' => $donation['amount'],
            'paymentMethod' => $method,
            'donationId' => $donation['donation_id'],
        ]);
    }
    
    /**
     * Handle payment method selection and redirect to appropriate payment page
     */
    public function redirectToPayment(Request $request)
    {
        $donor = Auth::guard('donor')->user();
        
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|in:gcash,paymaya,bank,walkin',
            'message' => 'nullable|string|max:1000',
        ]);
        
        $amount = $validated['amount'];
        $paymentMethod = $validated['payment_method'];
        
        // Store the donation in session temporarily
        $request->session()->put('pending_donation', [
            'amount' => $amount,
            'payment_method' => $paymentMethod,
            'donation_id' => (string) Str::uuid(),
            'donor_name' => $donor->name,
            'donor_email' => $donor->email,
            'donor_phone' => $donor->phone ?? null,
            'message' => $validated['message'] ?? null,
        ]);
        
        // Redirect to the appropriate payment page
        return redirect()->route('donor.donations.cash.payment', ['method' => $paymentMethod]);
    }
    
    /**
     * Update the donation amount for the payment method
     */
    public function updateAmount(Request $request, $method)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1'
        ]);
        
        $donor = Auth::guard('donor')->user();
        
        // Store the donation in session temporarily
        $request->session()->put('pending_donation', [
            'amount' => $request->amount,
            'payment_method' => $method,
            'donation_id' => (string) Str::uuid(),
            'donor_name' => $donor->name,
            'donor_email' => $donor->email,
            'donor_phone' => $donor->phone ?? null,
            'message' => null,
        ]);
        
        // Redirect back to the payment page with the updated amount
        return redirect()->route('donor.donations.cash.payment', ['method' => $method]);
    }
    
    /**
     * Process the payment
     */
    public function processPayment(Request $request, $method)
    {
        $donation = $request->session()->pull('pending_donation');
        
        if (!$donation && $method !== 'walkin') {
            return redirect()->route('donor.donations.cash.index')
                ->with('error', 'Session expired. Please try again.');
        }
        
        // Validate based on payment method
        $validationRules = [];
        
        // If payment was completed through gateway, terms is not required
        if (!$request->has('payment_completed')) {
            $validationRules['terms'] = 'required|accepted';
        }
        
        if ($method === 'bank') {
            $validationRules['reference_number'] = 'required|string|max:50';
            if (!$request->has('payment_completed')) {
                $validationRules['receipt'] = 'required|file|mimes:jpeg,png,jpg,pdf|max:2048';
            }
            $validationRules['bank_name'] = 'nullable|string|in:BPI,BDO,METROBANK';
            $validationRules['sender_name'] = 'nullable|string|max:255';
            $validationRules['amount'] = 'required|numeric|min:1';
        } elseif ($method === 'walkin') {
            $validationRules['appointment_date'] = 'required|date|after:today';
            $validationRules['appointment_time'] = 'required|string';
            $validationRules['appointment_type'] = 'required|string|in:consultation,direct_donation,item_dropoff,followup';
            $validationRules['appointment_notes'] = 'nullable|string|max:1000';
            // Walk-in doesn't require amount
        } else {
            $validationRules['reference_number'] = 'required|string|max:50';
            $validationRules['amount'] = 'required|numeric|min:1';
        }
        
        $validated = $request->validate($validationRules);
        
        // Handle file upload if present
        $receiptPath = null;
        if ($request->hasFile('receipt')) {
            $receiptPath = $request->file('receipt')->store('donation-receipts', 'public');
        }
        
        // Create the donation record
        $donor = Auth::guard('donor')->user();
        
        // For walk-in appointments, we don't have an amount yet
        $amount = $method === 'walkin' ? 0 : $validated['amount'];
        
        $donationRecord = new Donation([
            'id' => $donation['donation_id'] ?? (string) Str::uuid(),
            'donor_id' => Auth::guard('donor')->id(),
            'donor_name' => $donor->name,
            'donor_email' => $donor->email,
            'donor_phone' => $donor->phone ?? '',
            'donor_address' => $donor->address ?? '',
            'type' => 'cash',
            'amount' => $amount,
            'status' => $method === 'walkin' ? 'pending' : 'completed', // Walk-in is pending until actual donation
            'payment_method' => $method,
            'delivery_method' => 'in_person', // Walk-in donations are in-person
            'reference_number' => $validated['reference_number'] ?? null,
            'message' => $donation['message'] ?? null,
            'payment_details' => [
                'bank_name' => $validated['bank_name'] ?? null,
                'sender_name' => $validated['sender_name'] ?? null,
                'receipt_path' => $receiptPath,
                'appointment_date' => $validated['appointment_date'] ?? null,
                'appointment_time' => $validated['appointment_time'] ?? null,
                'appointment_type' => $validated['appointment_type'] ?? null,
                'appointment_notes' => $validated['appointment_notes'] ?? null,
            ]
        ]);
        
        $donationRecord->save();
        
        // Send thank you email with receipt to donor (except for walk-in which is just an appointment)
        if ($method !== 'walkin') {
            try {
                Mail::to($donationRecord->donor_email)->send(new CashDonationReceivedMail($donationRecord));
            } catch (\Exception $e) {
                // Log the error but don't fail the donation process
                \Log::error('Failed to send cash donation receipt email: ' . $e->getMessage());
            }
        } elseif ($method === 'walkin') {
            try {
                // Send notification to admin/specific email
                Mail::raw("New Walk-in Donation Appointment\n\nDonor: {$donationRecord->donor_name}\nDate: {$validated['appointment_date']}\nTime: {$validated['appointment_time']}\nPurpose: {$validated['appointment_type']}\nNotes: " . ($validated['appointment_notes'] ?? 'None'), function ($message) use ($donationRecord) {
                    $message->to('serafinjoelito21@gmail.com')
                            ->subject('New Walk-in Donation Appointment - ' . $donationRecord->reference_number);
                });

                // Create a ContactMessage so admin can reply and donor sees it
                \App\Models\ContactMessage::create([
                    'name' => $donationRecord->donor_name,
                    'email' => $donationRecord->donor_email,
                    'subject' => 'Walk-in Appointment Request - ' . $donationRecord->reference_number,
                    'message' => "Appointment Date: {$validated['appointment_date']}\nTime: {$validated['appointment_time']}\nPurpose: {$validated['appointment_type']}\nNotes: " . ($validated['appointment_notes'] ?? 'None'),
                    'status' => 'pending',
                    'donor_id' => $donationRecord->donor_id,
                ]);

                // Send confirmation email to donor
                 Mail::to($donationRecord->donor_email)->send(new \App\Mail\WalkinConfirmationMail($donationRecord));

            } catch (\Exception $e) {
                \Log::error('Failed to send walk-in notification email: ' . $e->getMessage());
            }
        }
        
        // Clear the pending donation from session
        $request->session()->forget('pending_donation');
        
        // Redirect to thank you page
        return redirect()->route('donor.donations.thank-you', $donationRecord->id);
    }
    
    /**
     * Show thank you page
     */
    public function thankYou(Donation $donation)
    {
        if ($donation->donor_id !== Auth::guard('donor')->id()) {
            abort(403);
        }
        
        return view('donor.donations.thank-you', [
            'donation' => $donation
        ]);
    }
    
    /**
     * Get validation rules based on payment method
     */
    protected function getPaymentValidationRules($method)
    {
        $rules = [
            'reference_number' => 'required|string|max:100',
            'terms' => 'required|accepted',
        ];
        
        if ($method === 'bank') {
            $rules['sender_name'] = 'required|string|max:255';
            $rules['bank_name'] = 'required|string|in:BPI,BDO,METROBANK';
            $rules['receipt'] = 'nullable|file|mimes:jpeg,png,pdf|max:5120'; // 5MB max
            $rules['message'] = 'nullable|string|max:1000';
        }
        
        return $rules;
    }
    
    /**
     * Get validation rules for the donation form
     */
    /**
     * Process the donation
     */
    public function store(Request $request)
    {
        // This method is kept for backward compatibility
        // Actual processing is now handled by processPayment method
        return redirect()->route('donor.donations.cash.index');
    }
    
    /**
     * Get validation rules for the donation form
     */
    protected function getValidationRules()
    {
        return [
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|in:gcash,paymaya,bank',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'nullable|string|max:1000',
        ];
    }
}
