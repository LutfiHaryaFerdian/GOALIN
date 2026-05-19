<x-app-layout>
    <x-slot name="title">Pemesanan Saya</x-slot>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-extrabold text-gray-900">Pemesanan Saya</h1>
                <p class="text-sm text-gray-500 mt-0.5">Riwayat dan status pemesanan lapangan Anda</p>
            </div>
            <a href="{{ route('fields.index') }}" class="btn-primary hidden sm:inline-flex">
                <x-icon name="plus" class="w-4 h-4" />
                Pesan Baru
            </a>
        </div>

        @if($bookings->isEmpty())
            <div class="card p-16 text-center">
                <div class="w-16 h-16 bg-primary-light rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <x-icon name="clipboard" class="w-8 h-8 text-primary" />
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Belum ada pemesanan</h3>
                <p class="text-gray-500 text-sm mb-6">Anda belum pernah memesan lapangan olahraga.</p>
                <a href="{{ route('fields.index') }}" class="btn-primary inline-flex">
                    Cari Lapangan Sekarang
                </a>
            </div>
        @else
            <div class="space-y-3">
                @foreach($bookings as $booking)
                    <div class="card p-5 hover:shadow-sm transition-shadow">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2 mb-2">
                                    <x-status-badge :status="$booking->status" />
                                    <span class="text-xs text-gray-400 font-mono">{{ $booking->booking_code }}</span>
                                </div>
                                <h3 class="font-bold text-gray-900 truncate">{{ $booking->field->name }}</h3>
                                <div class="flex flex-wrap items-center gap-3 mt-1.5 text-xs text-gray-500">
                                    <span class="flex items-center gap-1">
                                        <x-icon name="calendar" class="w-3.5 h-3.5" />
                                        {{ $booking->booking_date->locale('id')->isoFormat('D MMM Y') }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <x-icon name="clock" class="w-3.5 h-3.5" />
                                        {{ substr($booking->start_time, 0, 5) }} – {{ substr($booking->end_time, 0, 5) }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <x-icon name="map-pin" class="w-3.5 h-3.5" />
                                        {{ $booking->field->location->city }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 shrink-0">
                                <div class="text-right">
                                    <p class="text-xs text-gray-400">Total</p>
                                    <p class="text-base font-extrabold text-gray-900">
                                        Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                    </p>
                                </div>
                                <a href="{{ route('bookings.show', $booking) }}"
                                   class="btn-secondary py-2 px-4 text-xs">
                                    Detail <x-icon name="chevron-right" class="w-3.5 h-3.5" />
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">{{ $bookings->links() }}</div>
        @endif
    </div>
</x-app-layout>
