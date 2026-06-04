<x-app-layout>
    <x-slot name="title">Pemesanan Saya</x-slot>

    {{-- Header dark --}}
    <div class="bg-[#0D3B2E] texture-field">
        <div class="max-w-[1280px] mx-auto px-5 md:px-12 py-16">
            <div class="flex items-end justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#C6FF00] mb-4">RIWAYAT</p>
                    <h1 class="font-display font-extrabold uppercase leading-none text-white" style="font-size:clamp(40px,5vw,64px)">PEMESANAN<br>SAYA.</h1>
                </div>
                <a href="{{ route('fields.index') }}" class="hidden sm:flex btn-primary py-3 px-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    PESAN BARU
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-[1280px] mx-auto px-5 md:px-12 py-12">
        @if($bookings->isEmpty())
            <div class="text-center py-32 border border-[rgba(26,26,26,0.1)]">
                <p class="font-display font-extrabold uppercase text-[rgba(26,26,26,0.07)]" style="font-size:clamp(40px,5vw,72px)">BELUM ADA</p>
                <p class="text-[#717974] text-sm mt-3 mb-8">Anda belum pernah memesan lapangan olahraga.</p>
                <a href="{{ route('fields.index') }}" class="btn-forest">CARI LAPANGAN SEKARANG</a>
            </div>
        @else
            <div class="space-y-0 border border-[rgba(26,26,26,0.1)]">
                @foreach($bookings as $booking)
                    @php
                        $accentColor = match($booking->status) {
                            'confirmed' => '#C6FF00',
                            'completed' => '#1A1A1A',
                            'cancelled' => '#BA1A1A',
                            default     => 'rgba(26,26,26,0.3)',
                        };
                    @endphp
                    <div class="bg-white border-b border-[rgba(26,26,26,0.1)] last:border-b-0 flex"
                         style="border-left: 4px solid {{ $accentColor }}">
                        <div class="flex-1 p-6">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center gap-2 mb-2">
                                        <x-status-badge :status="$booking->status" />
                                        <span class="text-xs text-[#717974] font-mono">{{ $booking->booking_code }}</span>
                                    </div>
                                    <h3 class="font-display text-xl font-bold uppercase text-[#1A1A1A] leading-tight">{{ $booking->field->name }}</h3>
                                    <div class="flex flex-wrap items-center gap-4 mt-2 text-xs text-[#717974]">
                                        <span class="flex items-center gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/></svg>
                                            {{ $booking->booking_date->locale('id')->isoFormat('D MMM Y') }}
                                        </span>
                                        <span class="flex items-center gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                                            {{ substr($booking->start_time,0,5) }} – {{ substr($booking->end_time,0,5) }}
                                        </span>
                                        <span class="flex items-center gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                                            {{ $booking->field->location->city }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4 shrink-0">
                                    <div class="text-right">
                                        <p class="text-xs text-[#717974] uppercase tracking-[0.05em]">TOTAL</p>
                                        <p class="font-display text-xl font-bold text-[#1A1A1A]">Rp{{ number_format($booking->total_price,0,',','.') }}</p>
                                    </div>
                                    <a href="{{ route('bookings.show', $booking) }}" class="btn-forest py-2 px-5 text-xs">
                                        DETAIL →
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-8">{{ $bookings->links() }}</div>
        @endif
    </div>
</x-app-layout>
