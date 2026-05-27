<x-app-layout>
    <x-slot name="title">Pemesanan Saya</x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        {{-- Header --}}
        <div class="flex items-end justify-between mb-10">
            <div>
                <p class="section-label mb-2">RIWAYAT</p>
                <h1 class="font-display text-4xl md:text-5xl font-black uppercase tracking-tight text-[#0a0a0a]">PEMESANAN<br>SAYA</h1>
            </div>
            <a href="{{ route('fields.index') }}" class="btn-dark hidden sm:inline-flex">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Pesan Baru
            </a>
        </div>

        @if($bookings->isEmpty())
            <div class="text-center py-32">
                <p class="font-display text-6xl font-black uppercase text-[#f0f0f0]">BELUM ADA</p>
                <p class="text-[#737373] text-sm mt-4 mb-8">Anda belum pernah memesan lapangan olahraga.</p>
                <a href="{{ route('fields.index') }}" class="btn-dark">Cari Lapangan Sekarang</a>
            </div>
        @else
            <div class="space-y-3">
                @foreach($bookings as $booking)
                    <div class="bg-white border border-[#e5e5e5] hover:border-[#0a0a0a] transition-colors duration-200 rounded-2xl p-5">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2 mb-2">
                                    <x-status-badge :status="$booking->status" />
                                    <span class="text-xs text-[#a3a3a3] font-mono">{{ $booking->booking_code }}</span>
                                </div>
                                <h3 class="font-bold text-[#0a0a0a] truncate">{{ $booking->field->name }}</h3>
                                <div class="flex flex-wrap items-center gap-4 mt-2 text-xs text-[#737373]">
                                    <span class="flex items-center gap-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                                        </svg>
                                        {{ $booking->booking_date->locale('id')->isoFormat('D MMM Y') }}
                                    </span>
                                    <span class="flex items-center gap-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>
                                        {{ substr($booking->start_time, 0, 5) }} – {{ substr($booking->end_time, 0, 5) }}
                                    </span>
                                    <span class="flex items-center gap-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
                                        </svg>
                                        {{ $booking->field->location->city }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 shrink-0">
                                <div class="text-right">
                                    <p class="text-xs text-[#a3a3a3]">Total</p>
                                    <p class="text-base font-bold text-[#0a0a0a]">Rp{{ number_format($booking->total_price, 0, ',', '.') }}</p>
                                </div>
                                <a href="{{ route('bookings.show', $booking) }}" class="btn-secondary py-2 px-4 text-xs">
                                    Detail
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
                                    </svg>
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
