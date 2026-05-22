<x-app-layout>
    <x-slot name="title">Detail Pemesanan — Admin</x-slot>
    <div class="flex">
        <x-sidebar section="admin" />
        <main class="flex-1 min-w-0 py-8 px-4 sm:px-8">

            {{-- Header --}}
            <div class="flex items-center gap-3 mb-8">
                <a href="{{ route('admin.bookings.index') }}"
                   class="p-2 rounded-lg hover:bg-primary-light text-gray-400 hover:text-primary transition-colors">
                    <x-icon name="arrow-left" class="w-5 h-5" />
                </a>
                <div>
                    <p class="section-label">Admin Panel</p>
                    <h1 class="text-2xl font-extrabold text-gray-900">Detail Pemesanan</h1>
                </div>
                <span class="ml-auto font-mono text-xs text-gray-400 bg-gray-100 px-3 py-1 rounded-lg">
                    {{ $booking->booking_code }}
                </span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Left: Booking Info --}}
                <div class="lg:col-span-2 space-y-4">

                    {{-- Status & Field --}}
                    <div class="card p-6">
                        <div class="flex items-start justify-between gap-4 mb-5">
                            <div>
                                <div class="flex items-center gap-2 mb-2">
                                    <x-status-badge :status="$booking->status" />
                                    @if($booking->payment_status === 'paid')
                                        <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700">
                                            Lunas
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-700">
                                            Belum Bayar
                                        </span>
                                    @endif
                                </div>
                                <h2 class="text-xl font-bold text-gray-900">{{ $booking->field->name }}</h2>
                                <p class="text-sm text-gray-500 mt-0.5">{{ $booking->field->location->city }}</p>
                            </div>
                            <div class="text-right shrink-0">
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
                                <p class="font-semibold text-gray-900">
                                    {{ substr($booking->start_time, 0, 5) }} – {{ substr($booking->end_time, 0, 5) }} WIB
                                </p>
                            </div>
                            <div>
                                <p class="label">Dipesan pada</p>
                                <p class="font-semibold text-gray-900">{{ $booking->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            @if($booking->midtrans_order_id)
                                <div>
                                    <p class="label">Order ID Midtrans</p>
                                    <p class="font-mono text-xs text-gray-600">{{ $booking->midtrans_order_id }}</p>
                                </div>
                            @endif
                            @if($booking->midtrans_transaction_id)
                                <div>
                                    <p class="label">Transaction ID</p>
                                    <p class="font-mono text-xs text-gray-600">{{ $booking->midtrans_transaction_id }}</p>
                                </div>
                            @endif
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

                    {{-- ════════════════════════════════════════
                         RIWAYAT PEMBAYARAN
                    ════════════════════════════════════════ --}}
                    @if($booking->paymentLogs->isNotEmpty())
                        <div class="card overflow-hidden">
                            <div class="px-6 py-4 border-b border-field flex items-center gap-3">
                                <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900">Riwayat Pembayaran</h3>
                                    <p class="text-xs text-gray-400">{{ $booking->paymentLogs->count() }} notifikasi dari Midtrans</p>
                                </div>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="border-b border-field bg-accent">
                                            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Waktu</th>
                                            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                                            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Metode</th>
                                            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Jumlah</th>
                                            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden md:table-cell">Transaction ID</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-field">
                                        @foreach($booking->paymentLogs->sortByDesc('created_at') as $log)
                                            <tr class="hover:bg-accent transition-colors">
                                                <td class="px-5 py-3 text-xs text-gray-500">
                                                    {{ $log->created_at->format('d M Y, H:i') }}
                                                </td>
                                                <td class="px-5 py-3">
                                                    @php
                                                        $statusColors = [
                                                            'settlement' => 'bg-green-100 text-green-700',
                                                            'capture'    => 'bg-green-100 text-green-700',
                                                            'pending'    => 'bg-amber-100 text-amber-700',
                                                            'cancel'     => 'bg-red-100 text-red-700',
                                                            'expire'     => 'bg-red-100 text-red-700',
                                                            'deny'       => 'bg-red-100 text-red-700',
                                                        ];
                                                        $color = $statusColors[$log->transaction_status] ?? 'bg-gray-100 text-gray-600';
                                                    @endphp
                                                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $color }}">
                                                        {{ strtoupper($log->transaction_status) }}
                                                    </span>
                                                </td>
                                                <td class="px-5 py-3 text-xs text-gray-600">
                                                    {{ $log->payment_type ? str_replace('_', ' ', strtoupper($log->payment_type)) : '—' }}
                                                </td>
                                                <td class="px-5 py-3 text-xs font-bold text-gray-900">
                                                    @if($log->gross_amount)
                                                        Rp {{ number_format($log->gross_amount, 0, ',', '.') }}
                                                    @else
                                                        —
                                                    @endif
                                                </td>
                                                <td class="px-5 py-3 hidden md:table-cell">
                                                    <span class="font-mono text-xs text-gray-400">{{ $log->transaction_id ?? '—' }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                </div>

                {{-- Right: User & Field Info --}}
                <div class="space-y-4">

                    {{-- User --}}
                    <div class="card p-5">
                        <h3 class="font-bold text-gray-900 mb-3 flex items-center gap-2">
                            <x-icon name="user" class="w-4 h-4 text-gray-400" />
                            Data Pemesan
                        </h3>
                        <div class="space-y-2 text-sm">
                            <div>
                                <p class="label">Nama</p>
                                <p class="font-semibold text-gray-900">{{ $booking->user->name }}</p>
                            </div>
                            <div>
                                <p class="label">Email</p>
                                <p class="text-gray-600 break-all">{{ $booking->user->email }}</p>
                            </div>
                            @if($booking->user->phone)
                                <div>
                                    <p class="label">Telepon</p>
                                    <p class="text-gray-600">{{ $booking->user->phone }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Owner --}}
                    <div class="card p-5">
                        <h3 class="font-bold text-gray-900 mb-3 flex items-center gap-2">
                            <x-icon name="map-pin" class="w-4 h-4 text-gray-400" />
                            Data Owner
                        </h3>
                        <div class="space-y-2 text-sm">
                            <div>
                                <p class="label">Nama</p>
                                <p class="font-semibold text-gray-900">{{ $booking->field->owner->name }}</p>
                            </div>
                            <div>
                                <p class="label">Email</p>
                                <p class="text-gray-600 break-all">{{ $booking->field->owner->email }}</p>
                            </div>
                            <div>
                                <p class="label">Lapangan</p>
                                <p class="font-semibold text-gray-900">{{ $booking->field->name }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Payment Summary --}}
                    <div class="card p-5">
                        <h3 class="font-bold text-gray-900 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                            </svg>
                            Info Pembayaran
                        </h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <p class="label">Status</p>
                                @if($booking->payment_status === 'paid')
                                    <span class="text-green-600 font-semibold text-xs">Lunas</span>
                                @else
                                    <span class="text-amber-600 font-semibold text-xs">Belum Bayar</span>
                                @endif
                            </div>
                            @if($booking->midtrans_payment_type)
                                <div class="flex justify-between">
                                    <p class="label">Metode</p>
                                    <p class="text-xs font-semibold text-gray-900">
                                        {{ str_replace('_', ' ', strtoupper($booking->midtrans_payment_type)) }}
                                    </p>
                                </div>
                            @endif
                            <div class="flex justify-between pt-2 border-t border-field">
                                <p class="label">Total</p>
                                <p class="font-extrabold text-primary">
                                    Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </main>
    </div>
</x-app-layout>
