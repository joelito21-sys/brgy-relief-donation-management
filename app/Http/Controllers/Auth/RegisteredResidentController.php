<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use App\Models\FamilyMember;
use App\Models\VerificationOtp;
use App\Mail\OtpNotification; // Updated class name
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;

class RegisteredResidentController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('resident.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'suffix' => ['nullable', 'string', 'max:10'],
            'birthdate' => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:residents'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['required', 'string', 'max:20'],
            'house_number' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'], // Purok/Street
            'subdivision' => ['nullable', 'string', 'max:255'],
            'barangay' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:10'],
            'id_number' => ['required', 'string', 'max:50', 'unique:residents'],
            'id_type' => ['required', 'string', 'max:50'],
            'valid_id_front' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:4096'],
            'valid_id_back' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:4096'],
            'emergency_contact_name' => ['required', 'string', 'max:255'],
            'emergency_contact_phone' => ['required', 'string', 'max:20'],
            // Family members validation
            'family_member_names' => ['nullable', 'array'],
            'family_member_names.*' => ['required', 'string', 'max:255'],
            'family_member_relationships' => ['nullable', 'array'],
            'family_member_relationships.*' => ['required', 'string', 'max:50'],
            'family_member_ages' => ['nullable', 'array'],
            'family_member_ages.*' => ['nullable', 'integer', 'min:0', 'max:150'],
            // Face verification - must be verified
            'face_verified' => ['required', 'accepted'],
        ], [
            'birthdate.before_or_equal' => 'You must be at least 18 years old to register.',
            'family_member_names.*.required' => 'Each family member must have a name.',
            'family_member_relationships.*.required' => 'Each family member must have a relationship specified.',
            'face_verified.accepted' => 'Face verification is required. Please upload a valid ID with your face visible and take a matching selfie.',
        ]);

        // Check if the person trying to register is already listed as a family member
        $fullName = trim($request->first_name . ' ' . ($request->middle_name ? $request->middle_name . ' ' : '') . $request->last_name . ($request->suffix ? ' ' . $request->suffix : ''));
        
        $existingFamilyMember = FamilyMember::whereRaw('LOWER(full_name) = ?', [strtolower($fullName)])->first();
        
        if ($existingFamilyMember) {
            $headOfHousehold = $existingFamilyMember->resident;
            return back()->withInput()->withErrors([
                'first_name' => 'You are already registered as a family member under ' . $headOfHousehold->first_name . ' ' . $headOfHousehold->last_name . '\'s household. Only one account per household is allowed.'
            ]);
        }

        $validIdFrontPath = null;
        if ($request->hasFile('valid_id_front')) {
            $validIdFrontPath = $request->file('valid_id_front')->store('residents/valid_ids', 'public');
        }

        $validIdBackPath = null;
        if ($request->hasFile('valid_id_back')) {
            $validIdBackPath = $request->file('valid_id_back')->store('residents/valid_ids', 'public');
        }

        // Calculate family members count (including the resident)
        $familyMemberCount = 1; // Start with 1 for the resident
        if ($request->has('family_member_names') && is_array($request->family_member_names)) {
            $familyMemberCount += count($request->family_member_names);
        }

        $resident = Resident::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'suffix' => $request->suffix,
            'birthdate' => $request->birthdate,
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
            'house_number' => $request->house_number,
            'address' => $request->address,
            'subdivision' => $request->subdivision,
            'barangay' => $request->barangay,
            'city' => $request->city,
            'province' => $request->province,
            'country' => $request->country,
            'postal_code' => $request->postal_code,
            'id_number' => $request->id_number,
            'id_type' => $request->id_type,
            'valid_id_front' => $validIdFrontPath,
            'valid_id_back' => $validIdBackPath,
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_phone' => $request->emergency_contact_phone,
            'family_members' => $familyMemberCount,
            'approval_status' => Resident::STATUS_PENDING,
        ]);

        // Save family members
        if ($request->has('family_member_names') && is_array($request->family_member_names)) {
            foreach ($request->family_member_names as $index => $name) {
                if (!empty($name)) {
                    FamilyMember::create([
                        'resident_id' => $resident->id,
                        'full_name' => $name,
                        'relationship' => $request->family_member_relationships[$index] ?? null,
                        'age' => $request->family_member_ages[$index] ?? null,
                    ]);
                }
            }
        }

        event(new Registered($resident));

        // Generate OTP for email verification
        $otp = VerificationOtp::generateOtpForUser($resident->id, 'resident');
        
        if ($otp) {
            try {
                // Send OTP email
                Mail::to($resident->email)->send(new OtpNotification($resident, $otp->plain_otp, 'resident'));
                
                // Store OTP in session for development/debug
                session(['resident_otp' => $otp->plain_otp, 'resident_id' => $resident->id]);
                
                // Redirect to verification page
                return redirect(route('resident.verification.notice'));
            } catch (\Exception $e) {
                \Log::error('Failed to send OTP email: ' . $e->getMessage());
                
                // Store OTP in session for fallback
                session(['resident_otp' => $otp->plain_otp, 'resident_id' => $resident->id]);
                
                // Redirect to verification page
                return redirect(route('resident.verification.notice'))
                    ->with('warning', 'Email service unavailable. Please use the debug code for testing.');
            }
        }

        // If OTP generation fails, log the user in directly (fallback)
        Auth::guard('resident')->login($resident);
        return redirect(route('resident.verification'));
    }
}
