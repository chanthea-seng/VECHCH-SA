<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NewNotification extends Notification
{
    use Queueable;

    protected $message;
    protected $type;

    public function __construct($message, $type)
    {
        $this->message = $message;
        $this->type = $type;
    }

    public function via($notifiable)
    {
        return ['database']; // Save in DB
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->message,
            'type' => $this->type,
        ];
    }
}
