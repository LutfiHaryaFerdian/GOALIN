<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\PaymentLog;
use App\Services\MidtransService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Transaction;

class PaymentController extends Controller
{
    public function __construct(private MidtransService $midtrans) {}

    /**
     * Generate Snap Token dan kembalikan ke frontend via JSON.
     */
    public function getSnapToken(Booking $booking)
    {
        // Pastikan booking milik user yang login
        abort_if($booking->user_id !== auth()->id(), 403);

        // Hanya booking dengan payment_status unpaid yang boleh dibayar
        abort_if(
            $booking->payment_status !== 'unpaid',
            422,
            'Booking ini sudah dibayar atau tidak valid.'
        );

        // Jika sudah punya snap token, kembalikan yang lama
        if ($booking->midtrans_snap_token) {
            return response()->json(['snap_token' => $booking->midtrans_snap_token]);
        }

        $booking->load(['user', 'field']);
        $snapToken = $this->midtrans->createSnapToken($booking);

        return response()->json(['snap_token' => $snapToken]);
    }

    /**
     * Webhook: terima notifikasi pembayaran dari Midtrans.
     */
    public function notification(Request $request)
    {
        try {
            $data = $this->midtrans->handleNotification();
        } catch (\Exception $e) {
            \Log::error('Midtrans notification error: ' . $e->getMessage());
            return response()->json(['message' => 'Invalid notification'], 400);
        }

        // Cari booking berdasarkan midtrans_order_id
        $booking = Booking::where('midtrans_order_id', $data['order_id'])
                          ->with(['user', 'field'])
                          ->first();

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        // Simpan log pembayaran
        PaymentLog::create([
            'booking_id'         => $booking->id,
            'order_id'           => $data['order_id'],
            'transaction_id'     => $data['transaction_id'],
            'transaction_status' => $data['transaction_status'],
            'payment_type'       => $data['payment_type'],
            'gross_amount'       => $data['gross_amount'],
            'raw_payload'        => $data['raw'],
        ]);

        // Update status booking berdasarkan status transaksi Midtrans
        $transactionStatus = $data['transaction_status'];
        $fraudStatus       = $data['fraud_status'];

        if ($transactionStatus === 'capture') {
            $paymentStatus = $fraudStatus === 'accept' ? 'paid' : 'unpaid';
        } elseif ($transactionStatus === 'settlement') {
            $paymentStatus = 'paid';
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $paymentStatus = 'unpaid';
            // Reset snap token agar user bisa generate ulang
            $booking->update(['midtrans_snap_token' => null]);
        } else {
            $paymentStatus = 'unpaid'; // pending
        }

        $booking->update([
            'payment_status'          => $paymentStatus,
            'midtrans_transaction_id' => $data['transaction_id'],
            'midtrans_payment_type'   => $data['payment_type'],
        ]);

        // Kirim notifikasi & email jika pembayaran berhasil
        if ($paymentStatus === 'paid') {
            try {
                NotificationService::send(
                    $booking->user_id,
                    'payment_success',
                    'Pembayaran Berhasil',
                    "Pembayaran untuk pemesanan {$booking->booking_code} (lapangan {$booking->field->name}) telah berhasil.",
                    $booking->id,
                );
                \Mail::to($booking->user->email)->send(new \App\Mail\PaymentSuccessMail($booking));
            } catch (\Exception $e) {
                \Log::error('Payment success notification error: ' . $e->getMessage());
            }
        }

        return response()->json(['message' => 'OK']);
    }

    /**
     * Cek status transaksi langsung ke Midtrans API dan update DB.
     * Dipanggil oleh frontend (Alpine.js) setelah Snap popup onSuccess/onPending.
     */
    public function checkStatus(Booking $booking)
    {
        abort_if($booking->user_id !== auth()->id(), 403);

        if (!$booking->midtrans_order_id) {
            return response()->json(['payment_status' => $booking->payment_status]);
        }

        try {
            // Setup Midtrans config
            Config::$serverKey    = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');

            // Query status langsung ke Midtrans
            $status = Transaction::status($booking->midtrans_order_id);

            $transactionStatus = $status->transaction_status ?? null;
            $fraudStatus       = $status->fraud_status ?? null;
            $paymentType       = $status->payment_type ?? null;
            $transactionId     = $status->transaction_id ?? null;

            if ($transactionStatus === 'capture') {
                $paymentStatus = $fraudStatus === 'accept' ? 'paid' : 'unpaid';
            } elseif ($transactionStatus === 'settlement') {
                $paymentStatus = 'paid';
            } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                $paymentStatus = 'unpaid';
                $booking->update(['midtrans_snap_token' => null]);
            } else {
                $paymentStatus = 'unpaid'; // pending / other
            }

            // Update hanya jika statusnya berubah
            if ($booking->payment_status !== $paymentStatus) {
                $booking->update([
                    'payment_status'          => $paymentStatus,
                    'midtrans_transaction_id' => $transactionId,
                    'midtrans_payment_type'   => $paymentType,
                ]);

                // Log jika belum ada entry untuk transaksi ini
                if ($transactionId) {
                    PaymentLog::firstOrCreate(
                        ['transaction_id' => $transactionId],
                        [
                            'booking_id'         => $booking->id,
                            'order_id'           => $booking->midtrans_order_id,
                            'transaction_status' => $transactionStatus,
                            'payment_type'       => $paymentType,
                            'gross_amount'       => $status->gross_amount ?? $booking->total_price,
                            'raw_payload'        => json_encode($status),
                        ]
                    );
                }

                // Kirim notifikasi jika baru saja lunas
                if ($paymentStatus === 'paid') {
                    $booking->load(['user', 'field']);
                    try {
                        NotificationService::send(
                            $booking->user_id,
                            'payment_success',
                            'Pembayaran Berhasil',
                            "Pembayaran untuk {$booking->booking_code} telah berhasil.",
                            $booking->id,
                        );
                        \Mail::to($booking->user->email)
                            ->send(new \App\Mail\PaymentSuccessMail($booking));
                    } catch (\Exception $e) {
                        \Log::error('checkStatus notification error: ' . $e->getMessage());
                    }
                }
            }

            return response()->json(['payment_status' => $paymentStatus]);

        } catch (\Exception $e) {
            \Log::error('Midtrans checkStatus error: ' . $e->getMessage());
            // Kembalikan status dari DB jika Midtrans API error
            return response()->json(['payment_status' => $booking->payment_status]);
        }
    }

    /**
     * Halaman finish setelah user selesai di popup Snap.
     */
    public function finish(Request $request)
    {
        $orderId = $request->query('order_id');

        // Jika ada order_id, coba temukan booking dan update status
        if ($orderId) {
            $booking = Booking::where('midtrans_order_id', $orderId)->first();
            if ($booking && $booking->user_id === auth()->id()) {
                return redirect()->route('bookings.show', $booking)
                    ->with('info', 'Pembayaran sedang diproses. Status akan diperbarui otomatis.');
            }
        }

        return redirect()->route('bookings.index')
            ->with('info', 'Pembayaran sedang diproses. Status akan diperbarui otomatis.');
    }
}
