<?php

namespace App\Mail;

use App\Models\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CashDonationReceivedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $donation;

    /**
     * Create a new message instance.
     *
     * @param Donation $donation
     * @return void
     */
    public function __construct(Donation $donation)
    {
        $this->donation = $donation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Thank You for Your Cash Donation - Receipt #' . $this->donation->reference_number)
                    ->view('emails.donations.cash-receipt')
                    ->with([
                        'donation' => $this->donation,
                    ]);
    }
}
