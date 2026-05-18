<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FieldSchedule extends Model
{
    protected $fillable = [
        'field_id',
        'schedule_date',
        'start_time',
        'end_time',
        'status',
        'notes',
    ];

    protected $casts = [
        'schedule_date' => 'date',
    ];

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    public function booking()
    {
        return $this->hasOne(Booking::class, 'schedule_id');
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }
}
