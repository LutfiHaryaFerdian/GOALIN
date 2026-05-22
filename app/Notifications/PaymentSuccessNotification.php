<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentSuccessNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Booking $booking) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title'       => 'Pembayaran Berhasil',
            'body'        => "Pembayaran untuk pemesanan {$this->booking->booking_code} telah berhasil dikonfirmasi.",
            'booking_id'  => $this->booking->id,
            'booking_code'=> $this->booking->booking_code,
            'field_name'  => $this->booking->field->name,
            'type'        => 'payment_success',
        ];
    }
}
