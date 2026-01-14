<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(10);
        return view('admin.contact_messages.index', compact('messages'));
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactMessage $contactMessage)
    {
        return view('admin.contact_messages.show', compact('contactMessage'));
    }

    /**
     * Reply to the specified resource.
     */
    public function reply(Request $request, ContactMessage $contactMessage)
    {
        $request->validate([
            'response' => 'required|string',
        ]);

        $contactMessage->update([
            'admin_response' => $request->response,
            'status' => 'replied',
            'responded_at' => now(),
        ]);

        // Send email 
        // Send email 
        try {
            Mail::to($contactMessage->email)->send(new \App\Mail\ContactMessageReplyMail($contactMessage, $request->response));
        } catch (\Exception $e) {
            \Log::error('Failed to send reply email: ' . $e->getMessage());
            // Continue even if email fails, as database update succeeded
        }

        return redirect()->route('admin.contact-messages.show', $contactMessage)
            ->with('success', 'Reply sent successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();
        return redirect()->route('admin.contact-messages.index')
            ->with('success', 'Message deleted successfully.');
    }
}
