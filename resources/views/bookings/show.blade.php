<x-app-layout>
    <x-slot name="title">Detail Pemesanan</x-slot>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-center gap-3 mb-8">
            <a href="{{ route('bookings.index') }}"
               class="p-2 rounded-lg hover:bg-primary-light text-gray-400 hover:text-primary transition-colors">
                <x-icon name="arrow-left" class="w-5 h-5" />
            </a>
            <div>
                <h1 class="text-2xl font-extrabold text-gray-900">Detail Pemesanan</h1>
                <p class="text-xs font-mono text-gray-400 mt-0.5">{{ $booking->booking_code }}</p>
            </div>
        </div>

        {{-- Status card --}}
        <div class="card p-6 mb-4">
            <div class="flex items-start justify-between gap-4 mb-5">
                <div>
                    <x-status-badge :status="$booking->status" />
                    <h2 class="text-xl font-bold text-gray-900 mt-2">{{ $booking->field->name }}</h2>
                    <p class="flex items-center gap-1.5 text-sm text-gray-500 mt-1">
                        <x-icon name="map-pin" class="w-4 h-4 text-primary" />
                        {{ $booking->field->location->city }}
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-400">Total</p>
                    <p class="text-2xl font-extrabold text-primary">
                        Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 pt-5 border-t border-field text-sm">
                <div>
                    <p class="label">Kategori</p>
                    <p class="font-semibold text-gray-900">{{ $booking->field->category->name }}</p>
                </div>
                <div>
                    <p class="label">Tanggal</p>
                    <p class="font-semibold text-gray-900">
                        {{ $booking->booking_date->locale('id')->isoFormat('dddd, D MMMM Y') }}
                    </p>
                </div>
                <div>
                    <p class="label">Waktu</p>
                    <p class="font-semibold text-gray-900 flex items-center gap-1.5">
                        <x-icon name="clock" class="w-4 h-4 text-primary" />
                        {{ substr($booking->start_time, 0, 5) }} – {{ substr($booking->end_time, 0, 5) }} WIB
                    </p>
                </div>
                <div>
                    <p class="label">Dipesan pada</p>
                    <p class="font-semibold text-gray-900">{{ $booking->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>

            @if($booking->notes)
                <div class="mt-4 pt-4 border-t border-field">
                    <p class="label">Catatan</p>
                    <p class="text-sm text-gray-600">{{ $booking->notes }}</p>
                </div>
            @endif

            @if($booking->cancellation_reason)
                <div class="mt-4 p-3 bg-red-50 rounded-xl border border-red-100">
                    <p class="label text-red-500">Alasan Pembatalan</p>
                    <p class="text-sm text-red-700">{{ $booking->cancellation_reason }}</p>
                </div>
            @endif
        </div>

        {{-- Cancel form (pending only) --}}
        @if($booking->isPending() && $booking->user_id === auth()->id())
            <div class="card p-6 border-red-100">
                <h3 class="font-bold text-gray-900 mb-1">Batalkan Pemesanan</h3>
                <p class="text-sm text-gray-500 mb-4">
                    Pembatalan akan mengembalikan slot jadwal ke status tersedia.
                </p>
                <form method="POST" action="{{ route('bookings.cancel', $booking) }}"
                      x-data x-on:submit.prevent="if(confirm('Yakin ingin membatalkan pemesanan ini?')) $el.submit()">
                    @csrf
                    @method('PATCH')
                    <input type="text" name="cancellation_reason"
                        placeholder="Alasan pembatalan (opsional)"
                        class="input mb-3">
                    <button type="submit" class="btn-danger w-full justify-center">
                        <x-icon name="x-circle" class="w-4 h-4" />
                        Batalkan Pemesanan
                    </button>
                </form>
            </div>
        @endif
    </div>
</x-app-layout>
