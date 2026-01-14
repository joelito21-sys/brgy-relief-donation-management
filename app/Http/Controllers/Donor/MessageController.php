<?php

namespace App\Http\Controllers\Donor;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = ContactMessage::where('donor_id', Auth::guard('donor')->id())
            ->latest()
            ->paginate(10);
            
        return view('donor.messages.index', compact('messages'));
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactMessage $message)
    {
        // Ensure the message belongs to the logged-in donor
        if ($message->donor_id !== Auth::guard('donor')->id()) {
            abort(403);
        }

        return view('donor.messages.show', compact('message'));
    }
}
