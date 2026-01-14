<?php

namespace App\Mail;

use App\Models\ReliefRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReliefRequestSubmittedAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reliefRequest;

    /**
     * Create a new message instance.
     */
    public function __construct(ReliefRequest $reliefRequest)
    {
        $this->reliefRequest = $reliefRequest;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Relief Request - ' . ucfirst($this->reliefRequest->urgency_level) . ' Urgency',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.relief-request-admin',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
