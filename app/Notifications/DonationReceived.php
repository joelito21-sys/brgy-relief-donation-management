<?php

namespace App\Notifications;

use App\Models\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DonationReceived extends Notification implements ShouldQueue
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
        return ['mail'];
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
            ->subject('Thank You for Your ' . $this->donation->type_label)
            ->greeting('Hello ' . $this->donation->donor_name . ',');

        // Add content based on donation type
        if ($this->donation->isCashDonation()) {
            $mailMessage->line('Thank you for your generous cash donation of ' . $this->donation->formatted_amount . '.')
                ->line('Payment Method: ' . ucfirst(str_replace('_', ' ', $this->donation->payment_method)));
                
            if ($this->donation->donation_frequency !== 'one_time') {
                $mailMessage->line('Your ' . $this->donation->donation_frequency . ' donation has been set up successfully.');
            }
        } elseif ($this->donation->isFoodDonation()) {
            $mailMessage->line('Thank you for your food donation of ' . $this->donation->quantity . ' ' . $this->donation->unit . ' of ' . $this->donation->food_name . '.');
        } elseif ($this->donation->isClothingDonation()) {
            $mailMessage->line('Thank you for your clothing donation of ' . $this->donation->quantity . ' items.');
        } elseif ($this->donation->isMedicineDonation()) {
            $mailMessage->line('Thank you for your medicine donation of ' . $this->donation->medicine_name . ' (' . $this->donation->dosage . ').');
        }

        // Add delivery information
        if ($this->donation->delivery_method === 'pickup') {
            $mailMessage->line('\n**Delivery Information:**')
                ->line('You have chosen to deliver the items to our collection center. Please find the details below:')
                ->line('\n**Location:** 123 Flood Relief Center, Barangay 123, City')
                ->line('**Hours:** Monday to Saturday, 9:00 AM - 5:00 PM');
        } else {
            $mailMessage->line('\n**Pickup Information:**')
                ->line('We have scheduled a pickup for your donation:')
                ->line('\n**Date:** ' . $this->donation->pickup_date->format('F j, Y'))
                ->line('**Time:** ' . ($this->donation->pickup_time === 'morning' ? '9:00 AM - 12:00 PM' : '1:00 PM - 5:00 PM'))
                ->line('**Address:** ' . $this->donation->pickup_address);
        }

        // Add next steps
        $mailMessage->line('\n**Next Steps:**')
            ->line('- Our team will review your donation and may contact you if we need any additional information.')
            ->line('- You will receive updates about the status of your donation.')
            ->line('- If you have any questions, please reply to this email.');

        // Add a thank you note
        $mailMessage->line('\nThank you for supporting our flood relief efforts. Your contribution will make a difference in the lives of those affected by the floods.');

        // Add a button to view donation status
        $mailMessage->action('View Donation Status', url('/donations/' . $this->donation->id))
            ->line('Thank you for your generosity and support!');

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
            'status' => $this->donation->status,
        ];
    }
}
