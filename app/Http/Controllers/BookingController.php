<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Field;
use App\Models\FieldSchedule;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Show the user's booking list.
     */
    public function index()
    {
        $bookings = Auth::user()->bookings()
            ->with(['field.location', 'field.category', 'schedule'])
            ->latest()
            ->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show booking form for a specific schedule.
     */
    public function create(Request $request)
    {
        $schedule = FieldSchedule::with('field.location')->findOrFail($request->schedule_id);

        if (!$schedule->isAvailable()) {
            return redirect()->back()->with('error', 'Slot ini sudah tidak tersedia. Silakan pilih slot lain.');
        }

        return view('bookings.create', compact('schedule'));
    }

    /**
     * Store a new booking with double-booking protection.
     */
    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => ['required', 'exists:field_schedules,id'],
            'notes'       => ['nullable', 'string', 'max:500'],
        ]);

        try {
            $booking = DB::transaction(function () use ($request) {
                // Lock the schedule row to prevent race conditions
                $schedule = FieldSchedule::lockForUpdate()->findOrFail($request->schedule_id);

                if (!$schedule->isAvailable()) {
                    throw new \Exception('Slot ini sudah dipesan oleh orang lain. Silakan pilih slot lain.');
                }

                $field = Field::findOrFail($schedule->field_id);

                // Calculate total price (1 hour per slot)
                $totalPrice = $field->price_per_hour;

                $booking = Booking::create([
                    'user_id'      => Auth::id(),
                    'field_id'     => $field->id,
                    'schedule_id'  => $schedule->id,
                    'booking_date' => $schedule->schedule_date,
                    'start_time'   => $schedule->start_time,
                    'end_time'     => $schedule->end_time,
                    'total_price'  => $totalPrice,
                    'notes'        => $request->notes,
                    'status'       => 'pending',
                    'payment_status' => 'unpaid',
                ]);

                // Mark schedule as booked
                $schedule->update(['status' => 'booked']);

                return $booking;
            });

            // Send notifications (outside transaction to avoid locks)
            $booking->load(['field.owner', 'field.location']);
            NotificationService::bookingPending($booking);

            return redirect()->route('bookings.show', $booking)
                ->with('success', "Pemesanan berhasil! Kode booking Anda: {$booking->booking_code}");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show a single booking detail.
     */
    public function show(Booking $booking)
    {
        // Ensure user owns this booking
        if ($booking->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $booking->load(['field.location', 'field.category', 'schedule']);

        return view('bookings.show', compact('booking'));
    }

    /**
     * Cancel a pending booking.
     */
    public function cancel(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if (!$booking->isPending()) {
            return redirect()->back()->with('error', 'Hanya pemesanan dengan status pending yang dapat dibatalkan.');
        }

        $request->validate([
            'cancellation_reason' => ['nullable', 'string', 'max:255'],
        ]);

        DB::transaction(function () use ($booking, $request) {
            $booking->update([
                'status'              => 'cancelled',
                'cancellation_reason' => $request->cancellation_reason,
                'cancelled_at'        => now(),
            ]);

            // Revert schedule to available
            $booking->schedule->update(['status' => 'available']);
        });

        $booking->load(['field.owner', 'field.location']);
        NotificationService::bookingCancelled($booking, 'user');

        return redirect()->route('bookings.index')
            ->with('success', 'Pemesanan berhasil dibatalkan.');
    }
}
