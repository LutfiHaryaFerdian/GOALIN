<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Field;
use Illuminate\Http\Request;


class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'field.location', 'schedule']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('booking_code', 'ilike', "%{$request->search}%");
        }

        $bookings = $query->latest()->paginate(20)->withQueryString();

        return view('admin.bookings.index', [
            'bookings' => $bookings,
            'filters'  => $request->only(['status', 'search']),
        ]);
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'field.location', 'field.category', 'field.owner', 'schedule', 'paymentLogs']);

        return view('admin.bookings.show', ['booking' => $booking]);
    }
}
