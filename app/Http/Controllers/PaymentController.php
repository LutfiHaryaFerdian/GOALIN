<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\PaymentLog;
use App\Services\MidtransService;
use App\Services\NotificationService;
use Illuminate\Http\Request;

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
     * Halaman finish setelah user selesai di popup Snap.
     */
    public function finish(Request $request)
    {
        return redirect()->route('bookings.index')
            ->with('info', 'Pembayaran sedang diproses. Status akan diperbarui otomatis.');
    }
}
