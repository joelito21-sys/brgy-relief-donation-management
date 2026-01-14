<?php

namespace App\Mail;

use App\Models\Donor;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DonorOtpNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $donor;
    public $otp;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Donor  $donor
     * @param  string  $otp
     * @return void
     */
    public function __construct(Donor $donor, $otp)
    {
        $this->donor = $donor;
        $this->otp = $otp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Verify Your Donor Account - Flood Relief System')
                    ->view('emails.otp-notification', [
                        'user' => $this->donor,
                        'otp' => $this->otp
                    ]);
    }
}
