<?php

namespace App\Notifications;

use App\Models\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewDonationReceived extends Notification implements ShouldQueue
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
        $this->donation = $donation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $mailMessage = (new MailMessage)
            ->subject('New ' . $this->donation->type_label . ' Received')
            ->greeting('Hello Admin,')
            ->line('A new ' . strtolower($this->donation->type_label) . ' has been received with the following details:');

        // Add donation details based on type
        if ($this->donation->isCashDonation()) {
            $mailMessage->line('- Amount: ' . $this->donation->formatted_amount)
                ->line('- Payment Method: ' . ucfirst(str_replace('_', ' ', $this->donation->payment_method)));
        } else {
            $mailMessage->line('- Donor: ' . $this->donation->donor_name);
            
            if ($this->donation->isFoodDonation()) {
                $mailMessage->line('- Food Item: ' . $this->donation->food_name)
                    ->line('- Quantity: ' . $this->donation->quantity . ' ' . $this->donation->unit);
            } elseif ($this->donation->isClothingDonation()) {
                $mailMessage->line('- Type: ' . implode(', ', $this->donation->clothing_types))
                    ->line('- Quantity: ' . $this->donation->quantity . ' items');
            } elseif ($this->donation->isMedicineDonation()) {
                $mailMessage->line('- Medicine: ' . $this->donation->medicine_name)
                    ->line('- Dosage: ' . $this->donation->dosage)
                    ->line('- Quantity: ' . $this->donation->quantity . ' ' . ($this->donation->form === 'other' ? $this->donation->other_form : $this->donation->form . 's'));
            }
        }

        // Add delivery information
        $mailMessage->line('\n**Delivery Information:**')
            ->line('- Method: ' . ($this->donation->delivery_method === 'pickup' ? 'Donor will deliver' : 'Scheduled pickup'));
            
        if ($this->donation->delivery_method === 'pickup_arranged') {
            $mailMessage->line('- Pickup Date: ' . $this->donation->pickup_date->format('F j, Y'))
                ->line('- Pickup Time: ' . ($this->donation->pickup_time === 'morning' ? '9:00 AM - 12:00 PM' : '1:00 PM - 5:00 PM'))
                ->line('- Address: ' . $this->donation->pickup_address);
        } else {
            $mailMessage->line('- Donor will deliver to: 123 Flood Relief Center, Barangay 123, City');
        }

        // Add contact information
        $mailMessage->line('\n**Donor Contact Information:**')
            ->line('- Email: ' . $this->donation->donor_email)
            ->line('- Phone: ' . $this->donation->donor_phone)
            ->line('- Address: ' . $this->donation->donor_address);

        // Add a button to view the donation in the admin panel
        $mailMessage->action('View Donation Details', url('/admin/donations/' . $this->donation->id))
            ->line('Please review this donation and update its status accordingly.');

        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'donation_id' => $this->donation->id,
            'type' => $this->donation->type,
            'donor_name' => $this->donation->donor_name,
            'amount' => $this->donation->amount,
            'status' => $this->donation->status,
            'created_at' => now(),
        ];
    }
}
