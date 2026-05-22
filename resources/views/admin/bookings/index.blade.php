<x-app-layout>
    <x-slot name="title">Semua Pemesanan</x-slot>
    <div class="flex">
        <x-sidebar section="admin" />
        <main class="flex-1 min-w-0 py-8 px-4 sm:px-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <p class="section-label">Admin Panel</p>
                    <h1 class="text-2xl font-extrabold text-gray-900">Semua Pemesanan</h1>
                </div>
                <form method="GET" class="flex gap-2">
                    <div class="flex items-center gap-2 border border-gray-200 rounded-lg px-3 py-2 bg-white">
                        <x-icon name="search" class="w-4 h-4 text-gray-400" />
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Kode booking..."
                            class="text-sm outline-none bg-transparent w-32 text-gray-700 placeholder-gray-400">
                    </div>
                    <select name="status"
                        class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-transparent outline-none bg-white">
                        <option value="">Semua Status</option>
                        @foreach(['pending'=>'Pending','confirmed'=>'Dikonfirmasi','cancelled'=>'Dibatalkan','completed'=>'Selesai'] as $v => $l)
                            <option value="{{ $v }}" {{ request('status') === $v ? 'selected' : '' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn-primary py-2 px-4 text-sm">
                        <x-icon name="filter" class="w-4 h-4" />
                    </button>
                </form>
            </div>

            <div class="card overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-field bg-accent">
                            <th class="text-left px-5 py-3 ">Kode</th>
                            <th class="text-left px-5 py-3 ">Pengguna</th>
                            <th class="text-left px-5 py-3 ">Lapangan</th>
                            <th class="text-left px-5 py-3  hidden md:table-cell">Tanggal</th>
                            <th class="text-left px-5 py-3  hidden sm:table-cell">Total</th>
                            <th class="text-left px-5 py-3 ">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-field">
                        @forelse($bookings as $booking)
                            <tr class="hover:bg-accent transition-colors cursor-pointer"
                                onclick="window.location='{{ route('admin.bookings.show', $booking) }}'">
                                <td class="px-5 py-3 font-mono text-xs text-gray-400">{{ $booking->booking_code }}</td>
                                <td class="px-5 py-3 text-xs font-semibold text-gray-900">{{ $booking->user->name }}</td>
                                <td class="px-5 py-3 text-xs text-gray-600">{{ $booking->field->name }}</td>
                                <td class="px-5 py-3 text-xs text-gray-400 hidden md:table-cell">
                                    {{ $booking->booking_date->format('d M Y') }}
                                </td>
                                <td class="px-5 py-3 text-xs font-bold text-gray-900 hidden sm:table-cell">
                                    Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-2">
                                        <x-status-badge :status="$booking->status" />
                                        @if($booking->payment_status === 'paid')
                                            <span class="hidden lg:inline-flex items-center rounded-full bg-green-100 px-2 py-0.5 text-xs font-semibold text-green-700">Lunas</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-5 py-12 text-center text-sm text-gray-400">Tidak ada data pemesanan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6">{{ $bookings->links() }}</div>
        </main>
    </div>
</x-app-layout>
