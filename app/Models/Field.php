<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $fillable = [
        'category_id',
        'location_id',
        'owner_id',
        'name',
        'slug',
        'description',
        'price_per_hour',
        'status',
        'facilities',
        'images',
        'capacity',
    ];

    protected $casts = [
        'facilities' => 'array',
        'images' => 'array',
        'price_per_hour' => 'decimal:2',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(FieldCategory::class, 'category_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function schedules()
    {
        return $this->hasMany(FieldSchedule::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Helpers
    public function getFirstImageAttribute(): ?string
    {
        return $this->images[0] ?? null;
    }

    public function getAverageRatingAttribute(): float
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }
}
