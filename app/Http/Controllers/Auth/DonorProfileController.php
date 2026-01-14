<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DonorProfileController extends Controller
{
    /**
     * Show the donor's profile form.
     */
    public function edit()
    {
        return view('donor.profile.edit', [
            'user' => Auth::guard('donor')->user()
        ]);
    }

    /**
     * Update the donor's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::guard('donor')->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('donors')->ignore($user->id)],
        ]);

        $user->update($validated);

        return redirect()->route('donor.profile.edit')
            ->with('status', 'profile-updated');
    }

    /**
     * Delete the donor's account.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user('donor');

        Auth::guard('donor')->logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
