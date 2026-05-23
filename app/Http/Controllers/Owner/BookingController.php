<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FieldController;
use App\Models\Booking;
use App\Models\Field;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $fieldIds = Field::where('owner_id', Auth::id())->pluck('id');

        $query = Booking::whereIn('field_id', $fieldIds)
            ->select(['id', 'user_id', 'field_id', 'schedule_id', 'booking_code',
                      'booking_date', 'start_time', 'end_time', 'total_price',
                      'status', 'payment_status', 'created_at'])
            ->with(['user', 'field', 'schedule']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->latest()->paginate(15);

        return view('owner.bookings.index', compact('bookings'));
    }

    public function confirm(Booking $booking)
    {
        $this->authorizeOwner($booking);

        if (!$booking->isPending()) {
            return redirect()->back()->with('error', 'Hanya pemesanan pending yang dapat dikonfirmasi.');
        }

        $booking->update([
            'status'       => 'confirmed',
            'confirmed_at' => now(),
        ]);

        $booking->load(['field', 'user']);
        NotificationService::bookingConfirmed($booking);

        return redirect()->back()->with('success', "Pemesanan {$booking->booking_code} berhasil dikonfirmasi.");
    }

    public function cancel(Request $request, Booking $booking)
    {
        $this->authorizeOwner($booking);

        if ($booking->isCancelled()) {
            return redirect()->back()->with('error', 'Pemesanan sudah dibatalkan.');
        }

        $request->validate([
            'cancellation_reason' => ['required', 'string', 'max:255'],
        ]);

        $fieldId = $booking->field_id;

        DB::transaction(function () use ($booking, $request) {
            $booking->update([
                'status'              => 'cancelled',
                'cancellation_reason' => $request->cancellation_reason,
                'cancelled_at'        => now(),
            ]);

            $booking->schedule->update(['status' => 'available']);
        });

        $booking->load(['field', 'user']);
        NotificationService::bookingCancelled($booking, 'owner');

        // Invalidate schedule cache so users see the freed slot immediately
        FieldController::forgetScheduleCache($fieldId);

        return redirect()->back()->with('success', "Pemesanan {$booking->booking_code} berhasil dibatalkan.");
    }

    public function complete(Booking $booking)
    {
        $this->authorizeOwner($booking);

        if (!$booking->isConfirmed()) {
            return redirect()->back()->with('error', 'Hanya pemesanan yang sudah dikonfirmasi yang dapat diselesaikan.');
        }

        $booking->update([
            'status'       => 'completed',
        ]);

        $booking->load(['field.location', 'user']);
        NotificationService::bookingCompleted($booking);

        return redirect()->back()->with('success', "Pemesanan {$booking->booking_code} ditandai selesai.");
    }

    private function authorizeOwner(Booking $booking): void
    {
        $fieldIds = Field::where('owner_id', Auth::id())->pluck('id');
        if (!$fieldIds->contains($booking->field_id)) {
            abort(403);
        }
    }
}
