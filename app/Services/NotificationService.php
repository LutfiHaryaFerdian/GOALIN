<?php

namespace App\Services;

use App\Mail\BookingCancelledMail;
use App\Mail\BookingCompletedMail;
use App\Mail\BookingConfirmedMail;
use App\Mail\BookingPendingMail;
use App\Models\Booking;
use App\Models\Notification;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    public static function send(int $userId, string $type, string $title, string $message, ?int $bookingId = null): void
    {
        Notification::create([
            'user_id'    => $userId,
            'booking_id' => $bookingId,
            'type'       => $type,
            'title'      => $title,
            'message'    => $message,
        ]);
    }

    public static function bookingPending(Booking $booking): void
    {
        $fieldName = $booking->field->name;
        $code      = $booking->booking_code;
        $date      = $booking->booking_date->format('d M Y');

        // Notify user (DB)
        self::send(
            $booking->user_id,
            'booking_pending',
            'Pemesanan Berhasil Dibuat',
            "Pemesanan Anda untuk lapangan {$fieldName} pada {$date} (kode: {$code}) sedang menunggu konfirmasi owner.",
            $booking->id,
        );

        // Notify owner (DB)
        self::send(
            $booking->field->owner_id,
            'booking_pending',
            'Pemesanan Baru Masuk',
            "Pemesanan baru untuk lapangan {$fieldName} pada {$date} dengan kode {$code}. Harap segera dikonfirmasi.",
            $booking->id,
        );

        // Send email to user
        Mail::to($booking->user->email)->send(new BookingPendingMail($booking));
    }

    public static function bookingConfirmed(Booking $booking): void
    {
        // Notify user (DB)
        self::send(
            $booking->user_id,
            'booking_confirmed',
            'Pemesanan Dikonfirmasi',
            "Pemesanan Anda (kode: {$booking->booking_code}) untuk lapangan {$booking->field->name} telah dikonfirmasi.",
            $booking->id,
        );

        // Send email to user
        Mail::to($booking->user->email)->send(new BookingConfirmedMail($booking));
    }

    public static function bookingCancelled(Booking $booking, string $cancelledBy = 'user'): void
    {
        $fieldName = $booking->field->name;
        $code      = $booking->booking_code;

        // Notify user (DB)
        self::send(
            $booking->user_id,
            'booking_cancelled',
            'Pemesanan Dibatalkan',
            "Pemesanan Anda (kode: {$code}) untuk lapangan {$fieldName} telah dibatalkan.",
            $booking->id,
        );

        if ($cancelledBy === 'owner') {
            self::send(
                $booking->field->owner_id,
                'booking_cancelled',
                'Pemesanan Dibatalkan',
                "Pemesanan (kode: {$code}) untuk lapangan {$fieldName} telah dibatalkan.",
                $booking->id,
            );
        }

        // Send email to user
        Mail::to($booking->user->email)->send(new BookingCancelledMail($booking));
    }

    public static function bookingCompleted(Booking $booking): void
    {
        // Notify user (DB)
        self::send(
            $booking->user_id,
            'booking_completed',
            'Pemesanan Selesai',
            "Pemesanan Anda (kode: {$booking->booking_code}) untuk lapangan {$booking->field->name} telah selesai. Terima kasih!",
            $booking->id,
        );

        // Send email to user
        Mail::to($booking->user->email)->send(new BookingCompletedMail($booking));
    }
}
