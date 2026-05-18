<x-app-layout>
    <x-slot name="title">Kelola Pemesanan</x-slot>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-white">Kelola Pemesanan</h1>
            <!-- Filter -->
            <form method="GET" class="flex items-center gap-2">
                <select name="status" class="px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-gray-300 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                </select>
                <button type="submit" class="px-3 py-2 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-lg text-xs transition-all hover:bg-emerald-500/20">Filter</button>
            </form>
        </div>

        @if($bookings->isEmpty())
            <div class="text-center py-16 bg-gray-900/40 border border-white/5 rounded-2xl">
                <div class="text-4xl mb-3">📭</div>
                <p class="text-gray-500">Belum ada pemesanan masuk.</p>
            </div>
        @else
            <div class="bg-gray-900/60 border border-white/5 rounded-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-white/5">
                                <th class="text-left px-5 py-3 text-xs text-gray-500 font-medium">Kode</th>
                                <th class="text-left px-5 py-3 text-xs text-gray-500 font-medium">Pemesan</th>
                                <th class="text-left px-5 py-3 text-xs text-gray-500 font-medium">Lapangan</th>
                                <th class="text-left px-5 py-3 text-xs text-gray-500 font-medium">Tanggal & Waktu</th>
                                <th class="text-left px-5 py-3 text-xs text-gray-500 font-medium">Total</th>
                                <th class="text-left px-5 py-3 text-xs text-gray-500 font-medium">Status</th>
                                <th class="text-left px-5 py-3 text-xs text-gray-500 font-medium">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach($bookings as $booking)
                                @php
                                    $sc = ['pending' => 'text-yellow-400 bg-yellow-500/10 border-yellow-500/20','confirmed' => 'text-emerald-400 bg-emerald-500/10 border-emerald-500/20','cancelled' => 'text-red-400 bg-red-500/10 border-red-500/20','completed' => 'text-blue-400 bg-blue-500/10 border-blue-500/20'];
                                @endphp
                                <tr class="hover:bg-white/2 transition-colors">
                                    <td class="px-5 py-3 font-mono text-xs text-gray-400">{{ $booking->booking_code }}</td>
                                    <td class="px-5 py-3 text-white text-xs">{{ $booking->user->name }}</td>
                                    <td class="px-5 py-3 text-gray-300 text-xs">{{ $booking->field->name }}</td>
                                    <td class="px-5 py-3 text-gray-400 text-xs">
                                        {{ $booking->booking_date->format('d M Y') }}<br>
                                        {{ substr($booking->start_time, 0, 5) }} – {{ substr($booking->end_time, 0, 5) }}
                                    </td>
                                    <td class="px-5 py-3 text-white text-xs font-medium">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                    <td class="px-5 py-3">
                                        <span class="px-2 py-0.5 rounded-full border text-[10px] font-medium {{ $sc[$booking->status] ?? '' }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3">
                                        <div class="flex items-center gap-2">
                                            @if($booking->isPending())
                                                <form method="POST" action="{{ route('owner.bookings.confirm', $booking) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="px-2.5 py-1 bg-emerald-500/10 hover:bg-emerald-500/20 border border-emerald-500/20 text-emerald-400 rounded-lg text-[11px] transition-all">
                                                        Konfirmasi
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('owner.bookings.cancel', $booking) }}"
                                                    x-data x-on:submit.prevent="if(confirm('Batalkan pemesanan ini?')) $el.submit()">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="cancellation_reason" value="Dibatalkan oleh owner">
                                                    <button type="submit" class="px-2.5 py-1 bg-red-500/10 hover:bg-red-500/20 border border-red-500/20 text-red-400 rounded-lg text-[11px] transition-all">
                                                        Batalkan
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-xs text-gray-600">—</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-6">{{ $bookings->links() }}</div>
        @endif
    </div>
</x-app-layout>
