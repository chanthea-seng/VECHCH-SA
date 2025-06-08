<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class BookingConfirmedNotification extends Notification
{
    use Queueable;

    protected $booking;

    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        return ['database', 'mail', 'broadcast']; // Sends via database, email, and WebSocket
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Booking Has Been Confirmed')
            ->greeting('Hello ' . $notifiable->name)
            ->line('Your booking with ID #' . $this->booking->id . ' has been confirmed.')
            ->action('View Booking', url('/bookings/' . $this->booking->id))
            ->line('Thank you for using our service!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'booking_id' => $this->booking->id,
            'message' => 'Your booking has been confirmed by the admin.',
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'booking_id' => $this->booking->id,
            'message' => 'Your booking has been confirmed by the admin.',
        ]);
    }
}
