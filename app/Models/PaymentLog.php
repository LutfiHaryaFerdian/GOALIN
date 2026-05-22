<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentLog extends Model
{
    protected $fillable = [
        'booking_id',
        'order_id',
        'transaction_id',
        'transaction_status',
        'payment_type',
        'gross_amount',
        'raw_payload',
    ];

    protected $casts = [
        'raw_payload'  => 'array',
        'gross_amount' => 'decimal:2',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}
