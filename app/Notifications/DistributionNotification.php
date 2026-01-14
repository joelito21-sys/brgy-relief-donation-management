<?php

namespace App\Notifications;

use App\Models\DistributionNotification as DistributionNotificationModel;
use App\Models\DistributionConfirmation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DistributionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $distributionNotification;
    public $confirmation;

    /**
     * Create a new notification instance.
     */
    public function __construct(DistributionNotificationModel $distributionNotification, ?DistributionConfirmation $confirmation = null)
    {
        $this->distributionNotification = $distributionNotification;
        $this->confirmation = $confirmation;
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
        $mailMessage = (new MailMessage)
            ->subject($this->distributionNotification->title)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line($this->distributionNotification->message)
            ->line('**Distribution Details:**')
            ->line('- Date: ' . $this->distributionNotification->formatted_scheduled_date)
            ->line('- Location: ' . $this->distributionNotification->location)
            ->line('- Type: ' . ucfirst($this->distributionNotification->distribution_type));
            
        if ($this->distributionNotification->target_area) {
            $mailMessage->line('- Target Area: ' . $this->distributionNotification->target_area);
        }
            
        if ($this->distributionNotification->additional_info) {
            $mailMessage->line("\n**Additional Information:**")
                ->line($this->distributionNotification->additional_info);
        }

        // Add QR code information if confirmation exists
        if ($this->confirmation) {
            $mailMessage->line("\n---")
                ->line('**🎫 YOUR CLAIM CODE:**')
                ->line('**' . $this->confirmation->qr_code . '**')
                ->line('Present this code or show the QR code below at the distribution site to claim your relief package.');
        }
            
        $mailMessage->line("\nPlease make sure to be at the distribution location on time.")
            ->line('Bring a valid ID for verification.')
            ->line('Thank you for your cooperation!');
            
        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->distributionNotification->title,
            'message' => $this->distributionNotification->message,
            'distribution_type' => $this->distributionNotification->distribution_type,
            'location' => $this->distributionNotification->location,
            'scheduled_date' => $this->distributionNotification->scheduled_date,
            'target_area' => $this->distributionNotification->target_area,
            'distribution_notification_id' => $this->distributionNotification->id,
            'qr_code' => $this->confirmation ? $this->confirmation->qr_code : null,
        ];
    }
}

