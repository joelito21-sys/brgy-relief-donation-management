<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewDonationNotification extends Notification
{
    use Queueable;

    public $donation;

    /**
     * Create a new notification instance.
     */
    public function __construct($donation)
    {
        $this->donation = $donation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $donation = $this->donation;
        $amount = number_format($donation->amount, 2);
        $donorName = $donation->donor_name ?? 'Anonymous';
        
        return (new MailMessage)
            ->subject("New Donation Received - ₱{$amount} from {$donorName}")
            ->line("A new donation has been received with the following details:")
            ->line("")
            ->line("Donor: {$donorName}")
            ->line("Amount: ₱{$amount}")
            ->line("Type: " . ucfirst($donation->type))
            ->line("Payment Method: " . ($donation->payment_method ? ucfirst(str_replace('_', ' ', $donation->payment_method)) : 'N/A'))
            ->line("Reference: {$donation->reference_number}")
            ->action('View Donation', route('admin.donations.show', $donation->id))
            ->line('Thank you for using our application!');
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
            'donor_name' => $this->donation->donor_name,
            'type' => $this->donation->type,
            'payment_method' => $this->donation->payment_method,
            'reference_number' => $this->donation->reference_number,
            'message' => "New {$this->donation->type} donation received from {$this->donation->donor_name}",
            'url' => route('admin.donations.show', $this->donation->id)
        ];
    }
}
