<x-app-layout>
    <x-slot name="title">Detail Pemesanan #{{ $booking->booking_code }}</x-slot>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('bookings.index') }}" class="p-2 rounded-lg bg-white/5 hover:bg-white/10 text-gray-400 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h1 class="text-xl font-bold text-white">Detail Pemesanan</h1>
        </div>

        @php
            $statusColors = ['pending' => 'bg-yellow-500/10 border-yellow-500/20 text-yellow-400','confirmed' => 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400','cancelled' => 'bg-red-500/10 border-red-500/20 text-red-400','completed' => 'bg-blue-500/10 border-blue-500/20 text-blue-400'];
            $statusLabels = ['pending' => 'Menunggu Konfirmasi','confirmed' => 'Dikonfirmasi','cancelled' => 'Dibatalkan','completed' => 'Selesai'];
        @endphp

        <!-- Status Card -->
        <div class="bg-gray-900/60 border border-white/5 rounded-2xl p-6 mb-4">
            <div class="flex items-start justify-between gap-4 mb-4">
                <div>
                    <p class="text-xs text-gray-500 mb-1">Kode Pemesanan</p>
                    <p class="text-lg font-mono font-bold text-white">{{ $booking->booking_code }}</p>
                </div>
                <span class="px-3 py-1.5 rounded-full border text-sm font-medium {{ $statusColors[$booking->status] ?? '' }}">
                    {{ $statusLabels[$booking->status] ?? $booking->status }}
                </span>
            </div>

            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-xs text-gray-600 mb-1">Lapangan</p>
                    <p class="text-white font-medium">{{ $booking->field->name }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 mb-1">Kota</p>
                    <p class="text-white font-medium">{{ $booking->field->location->city }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 mb-1">Tanggal</p>
                    <p class="text-white font-medium">{{ $booking->booking_date->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 mb-1">Waktu</p>
                    <p class="text-white font-medium">{{ substr($booking->start_time, 0, 5) }} – {{ substr($booking->end_time, 0, 5) }} WIB</p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 mb-1">Kategori</p>
                    <p class="text-white font-medium">{{ $booking->field->category->name }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 mb-1">Total Harga</p>
                    <p class="text-emerald-400 font-bold text-base">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                </div>
            </div>

            @if($booking->notes)
                <div class="mt-4 pt-4 border-t border-white/5">
                    <p class="text-xs text-gray-600 mb-1">Catatan</p>
                    <p class="text-sm text-gray-300">{{ $booking->notes }}</p>
                </div>
            @endif

            @if($booking->cancellation_reason)
                <div class="mt-4 pt-4 border-t border-white/5">
                    <p class="text-xs text-gray-600 mb-1">Alasan Pembatalan</p>
                    <p class="text-sm text-red-400">{{ $booking->cancellation_reason }}</p>
                </div>
            @endif
        </div>

        <!-- Actions -->
        @if($booking->isPending() && $booking->user_id === auth()->id())
            <div class="bg-gray-900/40 border border-red-500/10 rounded-2xl p-5">
                <h3 class="text-sm font-semibold text-white mb-2">Batalkan Pemesanan</h3>
                <p class="text-xs text-gray-500 mb-4">Pembatalan akan mengembalikan slot jadwal menjadi tersedia.</p>
                <form method="POST" action="{{ route('bookings.cancel', $booking) }}"
                    x-data x-on:submit.prevent="if(confirm('Yakin ingin membatalkan pemesanan ini?')) $el.submit()">
                    @csrf
                    @method('PATCH')
                    <input type="text" name="cancellation_reason" placeholder="Alasan pembatalan (opsional)"
                        class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white placeholder-gray-600 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/30 mb-3">
                    <button type="submit"
                        class="w-full py-2.5 bg-red-500/10 hover:bg-red-500/20 border border-red-500/20 text-red-400 rounded-xl text-sm font-medium transition-all">
                        Batalkan Pemesanan
                    </button>
                </form>
            </div>
        @endif
    </div>
</x-app-layout>
