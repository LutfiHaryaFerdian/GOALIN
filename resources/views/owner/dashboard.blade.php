<x-app-layout>
    <x-slot name="title">Dashboard Owner</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-white">Dashboard Owner</h1>
                <p class="text-sm text-gray-500 mt-1">Selamat datang, {{ auth()->user()->name }}</p>
            </div>
            <a href="{{ route('owner.fields.create') }}"
                class="flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 text-white rounded-xl text-sm font-medium transition-all shadow-lg shadow-emerald-500/20">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Lapangan
            </a>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-gray-900/60 border border-white/5 rounded-2xl p-5">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs text-gray-500">Total Lapangan</p>
                    <span class="text-2xl">🏟️</span>
                </div>
                <p class="text-2xl font-bold text-white">{{ $totalFields }}</p>
            </div>
            <div class="bg-gray-900/60 border border-white/5 rounded-2xl p-5">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs text-gray-500">Total Pemesanan</p>
                    <span class="text-2xl">📋</span>
                </div>
                <p class="text-2xl font-bold text-white">{{ $totalBookings }}</p>
            </div>
            <div class="bg-gray-900/60 border border-yellow-500/10 rounded-2xl p-5">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs text-gray-500">Menunggu Konfirmasi</p>
                    <span class="text-2xl">⏳</span>
                </div>
                <p class="text-2xl font-bold text-yellow-400">{{ $pendingCount }}</p>
            </div>
            <div class="bg-gray-900/60 border border-emerald-500/10 rounded-2xl p-5">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs text-gray-500">Total Pendapatan</p>
                    <span class="text-2xl">💰</span>
                </div>
                <p class="text-xl font-bold text-emerald-400">Rp {{ number_format($revenue, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Quick Nav -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            <a href="{{ route('owner.fields.index') }}" class="flex items-center gap-3 p-4 bg-gray-900/60 border border-white/5 rounded-xl hover:border-emerald-500/30 hover:bg-gray-900/80 transition-all group">
                <div class="w-10 h-10 rounded-lg bg-emerald-500/10 flex items-center justify-center text-emerald-400 group-hover:bg-emerald-500/20 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-white">Lapangan Saya</p>
                    <p class="text-xs text-gray-500">Kelola lapangan</p>
                </div>
            </a>
            <a href="{{ route('owner.bookings.index') }}" class="flex items-center gap-3 p-4 bg-gray-900/60 border border-white/5 rounded-xl hover:border-emerald-500/30 hover:bg-gray-900/80 transition-all group">
                <div class="w-10 h-10 rounded-lg bg-blue-500/10 flex items-center justify-center text-blue-400 group-hover:bg-blue-500/20 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-white">Pemesanan</p>
                    <p class="text-xs text-gray-500">Konfirmasi & kelola</p>
                </div>
            </a>
            <a href="{{ route('notifications.index') }}" class="flex items-center gap-3 p-4 bg-gray-900/60 border border-white/5 rounded-xl hover:border-emerald-500/30 hover:bg-gray-900/80 transition-all group">
                <div class="w-10 h-10 rounded-lg bg-purple-500/10 flex items-center justify-center text-purple-400 group-hover:bg-purple-500/20 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-white">Notifikasi</p>
                    <p class="text-xs text-gray-500">Lihat semua</p>
                </div>
            </a>
        </div>

        <!-- Recent Bookings -->
        <div class="bg-gray-900/60 border border-white/5 rounded-2xl overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-white/5">
                <h2 class="text-sm font-semibold text-white">Pemesanan Terbaru</h2>
                <a href="{{ route('owner.bookings.index') }}" class="text-xs text-emerald-400 hover:text-emerald-300 transition-colors">Lihat semua →</a>
            </div>
            @if($recentBookings->isEmpty())
                <div class="py-10 text-center text-gray-500 text-sm">Belum ada pemesanan.</div>
            @else
                <div class="divide-y divide-white/5">
                    @foreach($recentBookings as $booking)
                        @php
                            $statusColors = ['pending' => 'text-yellow-400','confirmed' => 'text-emerald-400','cancelled' => 'text-red-400','completed' => 'text-blue-400'];
                        @endphp
                        <div class="flex items-center justify-between px-6 py-3 hover:bg-white/2 transition-colors">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-gray-500 font-mono">{{ $booking->booking_code }}</span>
                                    <span class="text-xs {{ $statusColors[$booking->status] ?? '' }}">● {{ ucfirst($booking->status) }}</span>
                                </div>
                                <p class="text-sm text-white truncate">{{ $booking->user->name }} — {{ $booking->field->name }}</p>
                            </div>
                            <div class="text-right shrink-0 ml-4">
                                <p class="text-xs text-gray-500">{{ $booking->booking_date->format('d M Y') }}</p>
                                <p class="text-sm font-medium text-white">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
