<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicContactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        ContactMessage::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'pending'
        ]);

        try {
            $recipient = config('mail.from.address', 'admin@barangaycubacub.gov.ph'); // Default recipient

            // Check if specific recipient is requested in the subject
            if (str_contains($request->subject, 'serafinjoelito21@gmail.com')) {
                $recipient = 'serafinjoelito21@gmail.com';
            }

            \Illuminate\Support\Facades\Mail::to($recipient)->send(new \App\Mail\ContactMessageMail($request->all()));
        } catch (\Exception $e) {
            \Log::error('Contact form email error: ' . $e->getMessage());
            // Continue execution to show success message to user even if email fails
        }

        return redirect()->route('contact')->with('success', 'Your message has been sent successfully. We will get back to you soon!');
    }
}
