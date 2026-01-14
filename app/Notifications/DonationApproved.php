<?php

namespace App\Notifications;

use App\Mail\DonationApprovedMail;
use App\Models\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class DonationApproved extends Notification implements ShouldQueue
{
    use Queueable;

    public $donation;

    /**
     * Create a new notification instance.
     *
     * @param Donation $donation
     * @return void
     */
    public function __construct(Donation $donation)
    {
        $this->donation = $donation->load('donor');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable)
    {
        return (new DonationApprovedMail($this->donation))
            ->to($this->donation->donor->email ?? $notifiable->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'donation_id' => $this->donation->id,
            'amount' => $this->donation->amount,
            'type' => $this->donation->type,
        ];
    }
}
