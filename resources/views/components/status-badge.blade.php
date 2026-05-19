@props(['status'])

@php
    $classes = match($status) {
        'pending'   => 'badge-pending',
        'confirmed' => 'badge-confirmed',
        'cancelled' => 'badge-cancelled',
        'completed' => 'badge-completed',
        default     => 'bg-gray-100 text-gray-600 rounded-full px-3 py-0.5 text-xs font-semibold',
    };
    $labels = [
        'pending'   => 'Menunggu',
        'confirmed' => 'Dikonfirmasi',
        'cancelled' => 'Dibatalkan',
        'completed' => 'Selesai',
    ];
@endphp

<span class="{{ $classes }}">{{ $labels[$status] ?? ucfirst($status) }}</span>
