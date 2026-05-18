<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\FieldCategory;
use App\Models\Location;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    /**
     * Public listing of fields with filters.
     */
    public function index(Request $request)
    {
        $query = Field::with(['category', 'location', 'owner', 'reviews'])
            ->where('status', 'active');

        // Filter by category slug
        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        // Filter by city
        if ($request->filled('city')) {
            $query->whereHas('location', fn($q) => $q->where('city', $request->city));
        }

        // Search by keyword
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                  ->orWhere('description', 'ilike', "%{$search}%");
            });
        }

        $fields     = $query->latest()->paginate(9)->withQueryString();
        $categories = FieldCategory::where('is_active', true)->orderBy('name')->get();
        $cities     = Location::where('is_active', true)->distinct()->orderBy('city')->pluck('city');

        return view('fields.index', compact('fields', 'categories', 'cities'));
    }

    /**
     * Show field detail with 7-day schedule grid.
     */
    public function show(string $slug)
    {
        $field = Field::with(['category', 'location', 'owner', 'reviews.user'])
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        // Build schedule grid for next 7 days
        $dates = [];
        for ($i = 0; $i < 7; $i++) {
            $dates[] = now()->addDays($i)->format('Y-m-d');
        }

        $schedules = $field->schedules()
            ->whereIn('schedule_date', $dates)
            ->orderBy('schedule_date')
            ->orderBy('start_time')
            ->get()
            ->groupBy(fn($s) => $s->schedule_date->format('Y-m-d'));

        return view('fields.show', compact('field', 'schedules', 'dates'));
    }
}
