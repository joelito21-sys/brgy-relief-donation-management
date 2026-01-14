<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentWebhookController extends Controller
{
    public function handleGcashWebhook(Request $request)
    {
        // Verify the webhook signature (important for security)
        // This is a simplified example - implement proper verification based on GCash docs
        $payload = $request->all();
        
        Log::info('GCash Webhook Received:', $payload);

        // Process the webhook
        if (isset($payload['data']['attributes']['data']['attributes']['status']) && 
            $payload['data']['attributes']['data']['attributes']['status'] === 'successful') {
            
            $referenceId = $payload['data']['attributes']['data']['attributes']['reference_number'] ?? null;
            
            if ($referenceId) {
                $donation = Donation::where('reference_number', $referenceId)->first();
                
                if ($donation) {
                    $donation->update([
                        'status' => 'completed',
                        'paid_at' => now(),
                        'payment_reference' => $payload['data']['id'] ?? null,
                        'payment_details' => json_encode($payload)
                    ]);
                    
                    Log::info("Donation {$donation->id} marked as paid");
                    return response()->json(['status' => 'success']);
                }
            }
        }
        
        return response()->json(['status' => 'ignored'], 200);
    }

    public function handlePaymayaWebhook(Request $request)
    {
        // Similar implementation for PayMaya
        $payload = $request->all();
        
        Log::info('PayMaya Webhook Received:', $payload);

        // Process the webhook - adjust according to PayMaya's webhook format
        if (isset($payload['status']) && $payload['status'] === 'PAYMENT_SUCCESS') {
            $referenceId = $payload['requestReferenceNumber'] ?? null;
            
            if ($referenceId) {
                $donation = Donation::where('reference_number', $referenceId)->first();
                
                if ($donation) {
                    $donation->update([
                        'status' => 'completed',
                        'paid_at' => now(),
                        'payment_reference' => $payload['id'] ?? null,
                        'payment_details' => json_encode($payload)
                    ]);
                    
                    Log::info("PayMaya Donation {$donation->id} marked as paid");
                    return response()->json(['status' => 'success']);
                }
            }
        }
        
        return response()->json(['status' => 'ignored'], 200);
    }
}
