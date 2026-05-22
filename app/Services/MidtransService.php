<?php

namespace App\Services;

use App\Models\Booking;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = config('midtrans.is_sanitized');
        Config::$is3ds        = config('midtrans.is_3ds');
    }

    /**
     * Generate Snap Token untuk halaman pembayaran.
     */
    public function createSnapToken(Booking $booking): string
    {
        $orderId = 'GOALIN-' . $booking->id . '-' . time();

        // Hitung total jam dari total_price / price_per_hour
        // (total_hours tidak disimpan di DB, dihitung dinamis)
        $pricePerHour = (int) $booking->field->price_per_hour;
        $totalHours   = $pricePerHour > 0
            ? (int) round($booking->total_price / $pricePerHour)
            : 1;

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => (int) $booking->total_price,
            ],
            'customer_details' => [
                'first_name' => $booking->user->name,
                'email'      => $booking->user->email,
                'phone'      => $booking->user->phone ?? '',
            ],
            'item_details' => [
                [
                    'id'       => 'FIELD-' . $booking->field->id,
                    'price'    => $pricePerHour,
                    'quantity' => $totalHours,
                    'name'     => substr($booking->field->name . ' (' . $totalHours . ' jam)', 0, 50),
                ],
            ],
            'callbacks' => [
                'finish' => route('payment.finish'),
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        // Simpan order_id dan snap_token ke booking
        $booking->update([
            'midtrans_order_id'   => $orderId,
            'midtrans_snap_token' => $snapToken,
        ]);

        return $snapToken;
    }

    /**
     * Handle notifikasi webhook dari Midtrans.
     */
    public function handleNotification(): array
    {
        $notification = new Notification();

        return [
            'order_id'           => $notification->order_id,
            'transaction_id'     => $notification->transaction_id,
            'transaction_status' => $notification->transaction_status,
            'fraud_status'       => $notification->fraud_status ?? null,
            'payment_type'       => $notification->payment_type,
            'gross_amount'       => $notification->gross_amount,
            'raw'                => json_encode($notification),
        ];
    }
}
