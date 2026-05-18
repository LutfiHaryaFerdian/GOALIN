<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Field;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers    = User::count();
        $totalFields   = Field::count();
        $totalBookings = Booking::count();
        $totalRevenue  = Booking::whereIn('status', ['confirmed', 'completed'])->sum('total_price');

        $pendingBookings   = Booking::where('status', 'pending')->count();
        $confirmedBookings = Booking::where('status', 'confirmed')->count();

        $recentBookings = Booking::with(['user', 'field'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalFields',
            'totalBookings',
            'totalRevenue',
            'pendingBookings',
            'confirmedBookings',
            'recentBookings',
        ));
    }
}
