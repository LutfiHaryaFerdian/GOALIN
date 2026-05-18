<x-app-layout>
    <x-slot name="title">Semua Pemesanan</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-2xl font-bold text-white mb-6">Semua Pemesanan</h1>

        <form method="GET" class="flex flex-wrap gap-3 mb-6">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode booking..."
                class="px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white placeholder-gray-600 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50 flex-1 min-w-40">
            <select name="status" class="px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-lg text-sm hover:bg-emerald-500/20 transition-all">Filter</button>
        </form>

        <div class="bg-gray-900/60 border border-white/5 rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-white/5">
                            <th class="text-left px-5 py-3 text-xs text-gray-500 font-medium">Kode</th>
                            <th class="text-left px-5 py-3 text-xs text-gray-500 font-medium">Pengguna</th>
                            <th class="text-left px-5 py-3 text-xs text-gray-500 font-medium">Lapangan</th>
                            <th class="text-left px-5 py-3 text-xs text-gray-500 font-medium">Tanggal</th>
                            <th class="text-left px-5 py-3 text-xs text-gray-500 font-medium">Total</th>
                            <th class="text-left px-5 py-3 text-xs text-gray-500 font-medium">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($bookings as $booking)
                            @php $sc = ['pending' => 'text-yellow-400 bg-yellow-500/10 border-yellow-500/20','confirmed' => 'text-emerald-400 bg-emerald-500/10 border-emerald-500/20','cancelled' => 'text-red-400 bg-red-500/10 border-red-500/20','completed' => 'text-blue-400 bg-blue-500/10 border-blue-500/20']; @endphp
                            <tr class="hover:bg-white/2">
                                <td class="px-5 py-3 font-mono text-xs text-gray-400">{{ $booking->booking_code }}</td>
                                <td class="px-5 py-3 text-white text-xs">{{ $booking->user->name }}</td>
                                <td class="px-5 py-3 text-gray-300 text-xs">{{ $booking->field->name }}</td>
                                <td class="px-5 py-3 text-gray-400 text-xs">{{ $booking->booking_date->format('d M Y') }}</td>
                                <td class="px-5 py-3 text-white text-xs">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                <td class="px-5 py-3"><span class="px-2 py-0.5 rounded-full border text-[10px] font-medium {{ $sc[$booking->status] ?? '' }}">{{ ucfirst($booking->status) }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-6">{{ $bookings->links() }}</div>
    </div>
</x-app-layout>
