<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ContactMessageReplyNotification extends Notification
{
    use Queueable;

    protected $reply;

    public function __construct($reply)
    {
        $this->reply = $reply;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Reply to Your Contact Message')
            ->line('An admin replied to your message:')
            ->line($this->reply)
            ->line('Thank you for contacting us!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'reply' => $this->reply,
        ];
    }
}
