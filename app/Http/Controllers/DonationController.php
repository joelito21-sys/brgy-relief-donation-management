<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\DonationReceipt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class DonationController extends Controller
{
    /**
     * Show the payment options page with QR codes
     */
    public function showPaymentOptions()
    {
        return view('donate.payment-options');
    }

    /**
     * Show the donation form.
     */
    public function showDonationForm()
    {
        $donor = Auth::guard('donor')->user();
        return view('donations.create', compact('donor'));
    }

    /**
     * Process the donation.
     */
    public function processDonation(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:cash,food,medicine,clothes',
            'amount' => 'required_if:type,cash|numeric|min:1|nullable',
            'payment_method' => 'required_if:type,cash|in:gcash,paymaya,bank_transfer,walk_in|nullable',
            'reference_number' => 'nullable|string|max:255',
            'message' => 'nullable|string|max:1000',
            'item_description' => 'required_unless:type,cash|string|max:1000|nullable',
            'quantity' => 'required_unless:type,cash|integer|min:1|nullable',
        ]);

        $donor = Auth::guard('donor')->user();
        
        // Create the donation
        $donation = new Donation();
        $donation->donor_id = $donor->id;
        $donation->type = $validated['type'];
        $donation->amount = $validated['amount'] ?? 0;
        $donation->payment_method = $validated['payment_method'] ?? null;
        $donation->reference_number = $validated['reference_number'] ?? null;
        $donation->donor_name = $donor->name;
        $donation->donor_email = $donor->email;
        $donor_phone = $donor->phone ?? '';
        $donation->donor_phone = $donor_phone;
        $donation->donor_address = $donor->address;
        $donation->message = $validated['message'] ?? null;
        $donation->status = 'pending';
        
        // For non-cash donations, store item details in admin_notes
        if ($donation->type !== 'cash') {
            $donation->admin_notes = "Item: " . ($validated['item_description'] ?? '') . 
                                  "\nQuantity: " . ($validated['quantity'] ?? 1);
        }
        
        $donation->save();

        // Generate QR code for digital payments
        if (in_array($donation->payment_method, ['gcash', 'paymaya']) && $donation->type === 'cash') {
            $this->generatePaymentQRCode($donation);
        }

        // Send receipt email
        try {
            Mail::to($donor->email)->send(new DonationReceipt($donation));
        } catch (\Exception $e) {
            Log::error('Failed to send donation receipt email: ' . $e->getMessage());
        }

        return redirect()->route('donation.receipt', $donation->id)
            ->with('success', 'Thank you for your donation! A receipt has been sent to your email.');
    }
    
    /**
     * Generate QR code for payment
     */
    protected function generatePaymentQRCode(Donation $donation)
    {
        try {
            // Create directory if it doesn't exist
            $directory = 'public/qrcodes/donations/' . $donation->id;
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory, 0755, true);
            }
            
            // Generate payment URL based on payment method
            $paymentData = [
                'donation_id' => $donation->id,
                'amount' => $donation->amount,
                'currency' => 'PHP',
                'description' => 'Donation to Flood Relief',
                'timestamp' => now()->toIso8601String()
            ];
            
            if ($donation->payment_method === 'gcash') {
                // GCash payment URL format (this is a simplified example)
                $paymentUrl = "https://gcash.com/pay/FloodRelief/" . $donation->id;
                $paymentData['payment_method'] = 'gcash';
            } else {
                // PayMaya payment URL format (this is a simplified example)
                $paymentUrl = "https://paymaya.com/pay/FloodRelief/" . $donation->id;
                $paymentData['payment_method'] = 'paymaya';
            }
            
            // Generate QR code
            $qrOptions = new QROptions([
                'version' => 5,
                'outputType' => QRCode::OUTPUT_IMAGE_PNG,
                'eccLevel' => QRCode::ECC_L,
                'scale' => 10,
                'imageBase64' => false,
                'imageTransparent' => false,
            ]);
            
            $qrcode = new QRCode($qrOptions);
            $qrCodeImage = $qrcode->render(json_encode($paymentData));
            
            // Save QR code to storage
            $filename = 'qrcode_' . $donation->id . '_' . time() . '.png';
            Storage::put($directory . '/' . $filename, base64_decode(explode(',', $qrCodeImage)[1]));
            
            // Save QR code path to donation record
            $donation->update([
                'admin_notes' => ($donation->admin_notes ?? '') . "\nQR Code: storage/qrcodes/donations/{$donation->id}/{$filename}"
            ]);
            
            return true;
            
        } catch (\Exception $e) {
            Log::error('Failed to generate QR code: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Show the donation receipt.
     */
    public function showReceipt($id)
    {
        $donation = Donation::where('donor_id', Auth::guard('donor')->id())
            ->findOrFail($id);
            
        return view('donations.receipt', compact('donation'));
    }

    /**
     * List all donations for the donor.
     */
    public function myDonations()
    {
        $donations = Donation::where('donor_id', Auth::guard('donor')->id())
            ->latest()
            ->paginate(10);
            
        return view('donations.index', compact('donations'));
    }
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
