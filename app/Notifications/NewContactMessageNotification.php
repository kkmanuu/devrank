<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\ContactMessage;

class NewContactMessageNotification extends Notification
{
    use Queueable;

    protected $contactMessage;

    public function __construct(ContactMessage $contactMessage)
    {
        $this->contactMessage = $contactMessage;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Contact Message')
            ->line('You have received a new contact message.')
            ->line('From: ' . $this->contactMessage->name)
            ->line('Message: ' . $this->contactMessage->message)
            ->action('View Message', url('/admin/contact-messages'))
            ->line('Thank you!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'contact_message_id' => $this->contactMessage->id,
            'name' => $this->contactMessage->name,
            'message' => $this->contactMessage->message,
        ];
    }
}
