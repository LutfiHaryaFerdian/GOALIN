<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\FieldCategory;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class FieldController extends Controller
{
    /**
     * Public listing of fields with filters.
     * Categories & cities are cached — invalidated by Owner\FieldController on store/update.
     */
    public function index(Request $request)
    {
        $query = Field::with(['category', 'location', 'owner', 'reviews'])
            ->select(['id', 'name', 'slug', 'category_id', 'location_id', 'owner_id',
                      'price_per_hour', 'status', 'facilities', 'images', 'capacity',
                      'created_at'])
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

        $fields = $query->latest()->paginate(9)->withQueryString();

        // Cache dropdown data — 1 hour TTL; forget when category/location changes
        $categories = Cache::remember('fieldcategories.active', 3600, function () {
            return FieldCategory::where('is_active', true)->orderBy('name')->get();
        });

        $cities = Cache::remember('locations.active.cities', 3600, function () {
            return Location::where('is_active', true)->distinct()->orderBy('city')->pluck('city');
        });

        return Inertia::render('Fields/Index', [
            'fields'     => $fields->toArray(),
            'categories' => $categories->values(),
            'cities'     => $cities->values(),
            'filters'    => $request->only(['search', 'category', 'city']),
        ]);
    }

    /**
     * Show field detail with 7-day schedule grid.
     * Schedules are cached per field per date-range — 5 min TTL.
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

        $schedules = $this->getSchedules($field->id, $dates);

        return Inertia::render('Fields/Show', [
            'field'     => array_merge($field->toArray(), [
                'images'  => $field->images ?? [],
                'owner'   => $field->owner ? $field->owner->only(['name', 'phone']) : null,
                'reviews' => $field->reviews ?? [],
            ]),
            'schedules' => $schedules->map(fn($day) => $day->toArray())->toArray(),
            'dates'     => $dates,
            'pollUrl'   => route('fields.slot-status', $field->slug),
        ]);
    }

    /**
     * API: Return JSON slot status for polling (public, lightweight).
     * Route: GET /fields/{slug}/slot-status?dates[]=2026-05-23
     */
    public function slotStatus(string $slug)
    {
        $field = Field::select(['id', 'slug'])
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        $dates = request()->input('dates', []);

        // Clamp to at most 7 dates to prevent abuse
        $dates = collect($dates)->take(7)->filter(function ($d) {
            return preg_match('/^\d{4}-\d{2}-\d{2}$/', $d);
        })->values()->toArray();

        if (empty($dates)) {
            return response()->json(['slots' => []]);
        }

        // Build compact status map — cached 60s so poll interval 30s gets fresh data
        $cacheKey = "field.slot_status.{$field->id}." . implode(',', $dates);
        $slots = Cache::remember($cacheKey, 60, function () use ($field, $dates) {
            return \App\Models\FieldSchedule::select(['id', 'schedule_date', 'start_time', 'end_time', 'status'])
                ->where('field_id', $field->id)
                ->whereIn('schedule_date', $dates)
                ->orderBy('schedule_date')
                ->orderBy('start_time')
                ->get()
                ->mapWithKeys(fn($s) => [$s->id => $s->status]);
        });

        return response()->json(['slots' => $slots]);
    }

    /**
     * Fetch schedules from cache or database.
     * Cache key: field.schedules.{fieldId}.{startDate}.{endDate}
     * TTL: 5 minutes (300s) — invalidated on booking/cancel/schedule-update
     */
    public static function getSchedules(int $fieldId, array $dates): \Illuminate\Support\Collection
    {
        $cacheKey = "field.schedules.{$fieldId}." . implode(',', $dates);

        return Cache::remember($cacheKey, 300, function () use ($fieldId, $dates) {
            return \App\Models\FieldSchedule::select(['id', 'field_id', 'schedule_date',
                                                      'start_time', 'end_time', 'status', 'notes'])
                ->where('field_id', $fieldId)
                ->whereIn('schedule_date', $dates)
                ->orderBy('schedule_date')
                ->orderBy('start_time')
                ->get()
                ->groupBy(fn($s) => $s->schedule_date->format('Y-m-d'));
        });
    }

    /**
     * Helper: build the 7-day dates array from today.
     */
    public static function nextSevenDays(): array
    {
        return collect(range(0, 6))->map(fn($i) => now()->addDays($i)->format('Y-m-d'))->toArray();
    }

    /**
     * Forget all schedule-related caches for a given field.
     * Call this from BookingController and ScheduleController after mutations.
     */
    public static function forgetScheduleCache(int $fieldId): void
    {
        // Forget the 7-day grid used on the public show page
        $dates7 = self::nextSevenDays();
        Cache::forget("field.schedules.{$fieldId}." . implode(',', $dates7));

        // Forget the 14-day grid used by the owner schedule page
        $dates14 = collect(range(0, 13))->map(fn($i) => now()->addDays($i)->format('Y-m-d'))->toArray();
        Cache::forget("field.schedules.{$fieldId}." . implode(',', $dates14));

        // Also clear any polling status caches (can't enumerate keys exactly, flush prefix if using redis tags)
        // For file/database driver we just clear the 7-day polling key
        foreach (collect(range(0, 6))->map(fn($i) => now()->addDays($i)->format('Y-m-d'))->chunk(7) as $chunk) {
            Cache::forget("field.slot_status.{$fieldId}." . $chunk->implode(','));
        }
        Cache::forget("field.slot_status.{$fieldId}." . implode(',', $dates7));
    }
}
