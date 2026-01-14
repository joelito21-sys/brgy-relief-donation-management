<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - Appointment System
|--------------------------------------------------------------------------
*/

Route::middleware(['web', 'auth:donor'])->group(function () {
    
    // Check appointment availability
    Route::post('/appointments/check-availability', function (Request $request) {
        try {
            $date = $request->input('date');
            $time = $request->input('time');
            
            // Validate input
            if (!$date || !$time) {
                return response()->json(['error' => 'Date and time are required'], 400);
            }
            
            // For demo purposes, simulate checking against a database
            // In a real application, you would check against your appointments table
            
            // Simulate some booked slots for demonstration
            $bookedSlots = [
                '2024-12-15' => ['09:00', '10:00', '14:00'],
                '2024-12-16' => ['11:00', '15:00', '16:00'],
                '2024-12-17' => ['09:30', '10:30', '13:30'],
            ];
            
            // Check if the requested slot is booked
            $isBooked = isset($bookedSlots[$date]) && in_array($time, $bookedSlots[$date]);
            
            if ($isBooked) {
                // Get available slots inline to avoid function redeclaration
                $allSlots = [
                    '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
                    '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30'
                ];
                $availableSlots = array_diff($allSlots, $bookedSlots[$date] ?? []);
                $suggestions = array_slice(array_values($availableSlots), 0, 3);
                
                return response()->json([
                    'available' => false,
                    'message' => 'This appointment time is not available. Please choose a different date or time.',
                    'suggestions' => $suggestions
                ]);
            }
            
            return response()->json([
                'available' => true,
                'message' => 'Appointment slot is available'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to check availability',
                'message' => $e->getMessage()
            ], 500);
        }
    })->name('api.appointments.check-availability');
});
