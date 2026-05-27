<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Field;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $owner = Auth::user();

        $fieldIds = Field::where('owner_id', $owner->id)->pluck('id');

        $totalFields    = $fieldIds->count();
        $totalBookings  = Booking::whereIn('field_id', $fieldIds)->count();
        $pendingCount   = Booking::whereIn('field_id', $fieldIds)->where('status', 'pending')->count();
        $confirmedCount = Booking::whereIn('field_id', $fieldIds)->where('status', 'confirmed')->count();
        $revenue        = Booking::whereIn('field_id', $fieldIds)
                            ->whereIn('status', ['confirmed', 'completed'])
                            ->sum('total_price');

        $recentBookings = Booking::whereIn('field_id', $fieldIds)
                            ->with(['user', 'field', 'schedule'])
                            ->latest()
                            ->take(5)
                            ->get();

        return Inertia::render('Owner/Dashboard', [
            'totalFields'    => $totalFields,
            'totalBookings'  => $totalBookings,
            'pendingCount'   => $pendingCount,
            'revenue'        => $revenue,
            'recentBookings' => $recentBookings->toArray(),
        ]);
    }
}
