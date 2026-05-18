<x-app-layout>
    <x-slot name="title">Pemesanan Saya</x-slot>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-2xl font-bold text-white mb-6">Pemesanan Saya</h1>

        @if($bookings->isEmpty())
            <div class="text-center py-20 bg-gray-900/40 border border-white/5 rounded-2xl">
                <div class="text-5xl mb-4">📋</div>
                <h3 class="text-lg font-semibold text-white mb-2">Belum ada pemesanan</h3>
                <p class="text-gray-500 text-sm mb-6">Anda belum pernah memesan lapangan olahraga.</p>
                <a href="{{ route('fields.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-500 hover:bg-emerald-400 text-white rounded-xl font-medium text-sm transition-all shadow-lg shadow-emerald-500/20">
                    Cari Lapangan Sekarang
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($bookings as $booking)
                    @php
                        $statusColors = [
                            'pending'   => 'bg-yellow-500/10 border-yellow-500/20 text-yellow-400',
                            'confirmed' => 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400',
                            'cancelled' => 'bg-red-500/10 border-red-500/20 text-red-400',
                            'completed' => 'bg-blue-500/10 border-blue-500/20 text-blue-400',
                        ];
                        $statusLabels = [
                            'pending'   => 'Menunggu Konfirmasi',
                            'confirmed' => 'Dikonfirmasi',
                            'cancelled' => 'Dibatalkan',
                            'completed' => 'Selesai',
                        ];
                    @endphp
                    <div class="bg-gray-900/60 border border-white/5 rounded-2xl p-5 hover:border-white/10 transition-colors">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-xs px-2 py-0.5 rounded-full border {{ $statusColors[$booking->status] ?? '' }}">
                                        {{ $statusLabels[$booking->status] ?? $booking->status }}
                                    </span>
                                    <span class="text-xs text-gray-600 font-mono">{{ $booking->booking_code }}</span>
                                </div>
                                <h3 class="font-semibold text-white">{{ $booking->field->name }}</h3>
                                <div class="flex flex-wrap items-center gap-3 mt-1 text-xs text-gray-500">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        {{ $booking->booking_date->locale('id')->isoFormat('D MMM Y') }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        {{ substr($booking->start_time, 0, 5) }} – {{ substr($booking->end_time, 0, 5) }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        {{ $booking->field->location->city }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="text-right">
                                    <p class="text-xs text-gray-600">Total</p>
                                    <p class="text-base font-bold text-white">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                                </div>
                                <a href="{{ route('bookings.show', $booking) }}" class="px-3 py-2 bg-white/5 hover:bg-white/10 border border-white/10 text-gray-300 rounded-xl text-xs transition-all whitespace-nowrap">
                                    Detail →
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
