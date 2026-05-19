<x-app-layout>
    <x-slot name="title">Kelola Pemesanan</x-slot>
    <div class="flex">
        <x-sidebar section="owner" />
        <main class="flex-1 min-w-0 py-8 px-4 sm:px-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <p class="section-label">Owner Panel</p>
                    <h1 class="text-2xl font-extrabold text-gray-900">Kelola Pemesanan</h1>
                </div>
                <form method="GET" class="flex items-center gap-2">
                    <select name="status"
                        class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary focus:border-transparent outline-none">
                        <option value="">Semua Status</option>
                        @foreach(['pending'=>'Pending','confirmed'=>'Dikonfirmasi','cancelled'=>'Dibatalkan','completed'=>'Selesai'] as $v => $l)
                            <option value="{{ $v }}" {{ request('status') === $v ? 'selected' : '' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn-secondary py-2 px-4 text-xs">
                        <x-icon name="filter" class="w-3.5 h-3.5" />
                        Filter
                    </button>
                </form>
            </div>

            @if($bookings->isEmpty())
                <div class="card p-12 text-center">
                    <div class="w-16 h-16 bg-primary-light rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <x-icon name="clipboard" class="w-8 h-8 text-primary" />
                    </div>
                    <p class="text-gray-400 text-sm">Belum ada pemesanan masuk.</p>
                </div>
            @else
                <div class="card overflow-hidden">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-field bg-accent">
                                <th class="text-left px-5 py-3 label">Kode</th>
                                <th class="text-left px-5 py-3 label">Pemesan</th>
                                <th class="text-left px-5 py-3 label">Lapangan</th>
                                <th class="text-left px-5 py-3 label">Tanggal & Waktu</th>
                                <th class="text-left px-5 py-3 label">Total</th>
                                <th class="text-left px-5 py-3 label">Status</th>
                                <th class="text-left px-5 py-3 label">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-field">
                            @foreach($bookings as $booking)
                                <tr class="hover:bg-accent transition-colors">
                                    <td class="px-5 py-3 font-mono text-xs text-gray-400">{{ $booking->booking_code }}</td>
                                    <td class="px-5 py-3 font-semibold text-gray-900 text-xs">{{ $booking->user->name }}</td>
                                    <td class="px-5 py-3 text-gray-600 text-xs">{{ $booking->field->name }}</td>
                                    <td class="px-5 py-3 text-xs text-gray-500">
                                        {{ $booking->booking_date->format('d M Y') }}<br>
                                        {{ substr($booking->start_time, 0, 5) }} – {{ substr($booking->end_time, 0, 5) }}
                                    </td>
                                    <td class="px-5 py-3 text-xs font-bold text-gray-900">
                                        Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-5 py-3">
                                        <x-status-badge :status="$booking->status" />
                                    </td>
                                    <td class="px-5 py-3">
                                        @if($booking->isPending())
                                            <div class="flex items-center gap-1.5">
                                                <form method="POST" action="{{ route('owner.bookings.confirm', $booking) }}">
                                                    @csrf @method('PATCH')
                                                    <button class="px-2.5 py-1 bg-primary-light text-primary text-xs font-semibold rounded-lg hover:bg-primary hover:text-white transition-colors">
                                                        Konfirmasi
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('owner.bookings.cancel', $booking) }}"
                                                      x-data x-on:submit.prevent="if(confirm('Batalkan pemesanan ini?')) $el.submit()">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="cancellation_reason" value="Dibatalkan oleh owner">
                                                    <button class="px-2.5 py-1 bg-red-50 text-red-500 text-xs font-semibold rounded-lg hover:bg-red-100 transition-colors">
                                                        Batalkan
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-300">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">{{ $bookings->links() }}</div>
            @endif
        </main>
    </div>
</x-app-layout>
