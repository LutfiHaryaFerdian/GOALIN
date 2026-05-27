<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Field;
use App\Models\FieldCategory;
use App\Models\Location;

class LandingController extends Controller
{
    public function index()
    {
        $categories = FieldCategory::where('is_active', true)->get();

        $featuredFields = Field::with(['category', 'location'])
            ->where('status', 'active')
            ->latest()
            ->take(6)
            ->get();

        $totalFields   = Field::where('status', 'active')->count();
        $totalBookings = Booking::where('status', 'confirmed')->count();
        $totalCities   = Location::distinct('city')->count('city');

        return view('landing', compact(
            'categories',
            'featuredFields',
            'totalFields',
            'totalBookings',
            'totalCities'
        ));
    }
}
