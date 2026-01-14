<?php

namespace App\Notifications;

use App\Models\ReliefRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReliefRequestSubmitted extends Notification implements ShouldQueue
{
    use Queueable;

    public $reliefRequest;

    /**
     * Create a new notification instance.
     */
    public function __construct(ReliefRequest $reliefRequest)
    {
        $this->reliefRequest = $reliefRequest;
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
        $assistanceTypes = is_array($this->reliefRequest->assistance_types) 
            ? implode(', ', $this->reliefRequest->assistance_types) 
            : $this->reliefRequest->assistance_types;

        return (new MailMessage)
            ->subject('Relief Request Submitted - Reference #' . $this->reliefRequest->id)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your relief request has been submitted successfully!')
            ->line('**Request Details:**')
            ->line('- Reference Number: #' . $this->reliefRequest->id)
            ->line('- Urgency Level: ' . ucfirst($this->reliefRequest->urgency_level ?? 'Normal'))
            ->line('- Assistance Requested: ' . $assistanceTypes)
            ->line('- Household Size: ' . $this->reliefRequest->household_size)
            ->line('- Status: **Pending Review**')
            ->line('')
            ->line('Our team will review your request and get back to you as soon as possible.')
            ->line('')
            ->line('If you have any questions, please contact our office or reply to this email.')
            ->action('View Request Status', route('resident.relief-requests.show', $this->reliefRequest->id))
            ->line('Thank you for reaching out to us. We are here to help!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Relief Request Submitted',
            'message' => 'Your relief request #' . $this->reliefRequest->id . ' has been submitted and is pending review.',
            'relief_request_id' => $this->reliefRequest->id,
            'urgency_level' => $this->reliefRequest->urgency_level,
            'status' => 'pending',
            'type' => 'relief_request_submitted',
        ];
    }
}
