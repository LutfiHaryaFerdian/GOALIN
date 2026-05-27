<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Field;
use App\Models\FieldSchedule;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class BookingController extends Controller
{
    /**
     * Show the user's booking list.
     */
    public function index()
    {
        $bookings = Auth::user()->bookings()
            ->select(['id', 'user_id', 'field_id', 'schedule_id', 'booking_code',
                      'booking_date', 'start_time', 'end_time', 'total_price',
                      'status', 'payment_status', 'created_at'])
            ->with(['field.location', 'field.category', 'schedule'])
            ->latest()
            ->paginate(10);

        return Inertia::render('Bookings/Index', ['bookings' => $bookings->toArray()]);
    }

    /**
     * Show booking confirmation for one or more consecutive schedules.
     */
    public function create(Request $request)
    {
        $ids = $request->input('schedule_ids', []);

        // Fallback: support legacy single schedule_id
        if (empty($ids) && $request->filled('schedule_id')) {
            $ids = [$request->schedule_id];
        }

        if (empty($ids)) {
            return redirect()->route('fields.index')->with('error', 'Pilih minimal satu slot terlebih dahulu.');
        }

        $schedules = FieldSchedule::with('field.location', 'field.category')
            ->whereIn('id', $ids)
            ->orderBy('start_time')
            ->get();

        if ($schedules->isEmpty()) {
            return redirect()->back()->with('error', 'Slot tidak ditemukan.');
        }

        // All must be available
        $unavailable = $schedules->filter(fn($s) => !$s->isAvailable());
        if ($unavailable->isNotEmpty()) {
            return redirect()->back()->with('error', 'Satu atau lebih slot sudah tidak tersedia. Silakan pilih ulang.');
        }

        $field      = $schedules->first()->field;
        $totalPrice = $schedules->count() * $field->price_per_hour;
        // Backward compat: $schedule = first slot (used by any partial view)
        $schedule   = $schedules->first();

        return Inertia::render('Bookings/Create', [
            'schedule'   => $schedule->load('field.location', 'field.category')->toArray(),
            'schedules'  => $schedules->toArray(),
            'totalPrice' => $totalPrice,
        ]);
    }

    /**
     * Store a new booking (supports 1-4 consecutive slots).
     */
    public function store(Request $request)
    {
        $request->validate([
            'schedule_ids'   => ['required', 'array', 'min:1', 'max:4'],
            'schedule_ids.*' => ['required', 'exists:field_schedules,id'],
            'notes'          => ['nullable', 'string', 'max:500'],
        ]);

        try {
            $booking = DB::transaction(function () use ($request) {
                // Lock all selected rows to prevent race conditions
                $schedules = FieldSchedule::lockForUpdate()
                    ->whereIn('id', $request->schedule_ids)
                    ->orderBy('start_time')
                    ->get();

                if ($schedules->count() !== count($request->schedule_ids)) {
                    throw new \Exception('Satu atau lebih slot tidak ditemukan.');
                }

                // All must be available
                foreach ($schedules as $s) {
                    if (!$s->isAvailable()) {
                        throw new \Exception("Slot {$s->start_time} sudah dipesan. Silakan pilih slot lain.");
                    }
                }

                $first = $schedules->first();
                $last  = $schedules->last();
                $field = Field::findOrFail($first->field_id);

                $booking = Booking::create([
                    'user_id'        => Auth::id(),
                    'field_id'       => $field->id,
                    'schedule_id'    => $first->id,   // FK to first slot (backward compat)
                    'booking_date'   => $first->schedule_date,
                    'start_time'     => $first->start_time,
                    'end_time'       => $last->end_time,
                    'total_price'    => $schedules->count() * $field->price_per_hour,
                    'notes'          => $request->notes,
                    'status'         => 'pending',
                    'payment_status' => 'unpaid',
                ]);

                // Mark every selected slot as booked
                FieldSchedule::whereIn('id', $request->schedule_ids)
                    ->update(['status' => 'booked']);

                return $booking;
            });

            $booking->load(['field.owner', 'field.location']);
            NotificationService::bookingPending($booking);

            // Invalidate schedule cache so other users see updated slot status
            FieldController::forgetScheduleCache($booking->field_id);

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

        $booking->load(['field.location', 'field.category', 'field.owner']);
        return Inertia::render('Bookings/Show', ['booking' => $booking->toArray()]);
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

        $fieldId = $booking->field_id;

        DB::transaction(function () use ($booking, $request) {
            $booking->update([
                'status'              => 'cancelled',
                'cancellation_reason' => $request->cancellation_reason,
                'cancelled_at'        => now(),
            ]);

            // Revert ALL schedules in the booking's time window back to available
            FieldSchedule::where('field_id', $booking->field_id)
                ->where('schedule_date', $booking->booking_date)
                ->where('start_time', '>=', $booking->start_time)
                ->where('end_time', '<=', $booking->end_time)
                ->where('status', 'booked')
                ->update(['status' => 'available']);
        });

        $booking->load(['field.owner', 'field.location']);
        NotificationService::bookingCancelled($booking, 'user');

        // Invalidate schedule cache so slots appear as available again
        FieldController::forgetScheduleCache($fieldId);

        return redirect()->route('bookings.index')
            ->with('success', 'Pemesanan berhasil dibatalkan.');
    }
}
