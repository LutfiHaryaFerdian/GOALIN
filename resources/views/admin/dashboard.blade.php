<x-app-layout>
    <x-slot name="title">Admin Dashboard</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-2xl font-bold text-white mb-8">Admin Dashboard</h1>

        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-gray-900/60 border border-white/5 rounded-2xl p-5">
                <p class="text-xs text-gray-500 mb-1">Total Pengguna</p>
                <p class="text-3xl font-bold text-white">{{ $totalUsers }}</p>
            </div>
            <div class="bg-gray-900/60 border border-white/5 rounded-2xl p-5">
                <p class="text-xs text-gray-500 mb-1">Total Lapangan</p>
                <p class="text-3xl font-bold text-white">{{ $totalFields }}</p>
            </div>
            <div class="bg-gray-900/60 border border-white/5 rounded-2xl p-5">
                <p class="text-xs text-gray-500 mb-1">Total Pemesanan</p>
                <p class="text-3xl font-bold text-white">{{ $totalBookings }}</p>
            </div>
            <div class="bg-gray-900/60 border border-emerald-500/10 rounded-2xl p-5">
                <p class="text-xs text-gray-500 mb-1">Total Pendapatan</p>
                <p class="text-xl font-bold text-emerald-400">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Status Summary -->
        <div class="grid grid-cols-2 gap-4 mb-8">
            <div class="bg-gray-900/60 border border-yellow-500/10 rounded-xl p-4 flex items-center gap-3">
                <span class="text-3xl">⏳</span>
                <div>
                    <p class="text-2xl font-bold text-yellow-400">{{ $pendingBookings }}</p>
                    <p class="text-xs text-gray-500">Menunggu Konfirmasi</p>
                </div>
            </div>
            <div class="bg-gray-900/60 border border-emerald-500/10 rounded-xl p-4 flex items-center gap-3">
                <span class="text-3xl">✅</span>
                <div>
                    <p class="text-2xl font-bold text-emerald-400">{{ $confirmedBookings }}</p>
                    <p class="text-xs text-gray-500">Dikonfirmasi</p>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
            <a href="{{ route('admin.users.index') }}" class="p-4 bg-gray-900/60 border border-white/5 rounded-xl hover:border-emerald-500/30 text-center group transition-all">
                <div class="text-2xl mb-2">👥</div>
                <p class="text-sm font-medium text-white group-hover:text-emerald-400 transition-colors">Pengguna</p>
            </a>
            <a href="{{ route('admin.bookings.index') }}" class="p-4 bg-gray-900/60 border border-white/5 rounded-xl hover:border-emerald-500/30 text-center group transition-all">
                <div class="text-2xl mb-2">📋</div>
                <p class="text-sm font-medium text-white group-hover:text-emerald-400 transition-colors">Semua Pemesanan</p>
            </a>
            <a href="{{ route('fields.index') }}" class="p-4 bg-gray-900/60 border border-white/5 rounded-xl hover:border-emerald-500/30 text-center group transition-all">
                <div class="text-2xl mb-2">🏟️</div>
                <p class="text-sm font-medium text-white group-hover:text-emerald-400 transition-colors">Semua Lapangan</p>
            </a>
            <a href="{{ route('notifications.index') }}" class="p-4 bg-gray-900/60 border border-white/5 rounded-xl hover:border-emerald-500/30 text-center group transition-all">
                <div class="text-2xl mb-2">🔔</div>
                <p class="text-sm font-medium text-white group-hover:text-emerald-400 transition-colors">Notifikasi</p>
            </a>
        </div>

        <!-- Recent Bookings -->
        <div class="bg-gray-900/60 border border-white/5 rounded-2xl overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-white/5">
                <h2 class="text-sm font-semibold text-white">Pemesanan Terbaru (10)</h2>
                <a href="{{ route('admin.bookings.index') }}" class="text-xs text-emerald-400 hover:text-emerald-300">Lihat semua →</a>
            </div>
            <div class="divide-y divide-white/5">
                @foreach($recentBookings as $booking)
                    @php $sc = ['pending' => 'text-yellow-400','confirmed' => 'text-emerald-400','cancelled' => 'text-red-400','completed' => 'text-blue-400']; @endphp
                    <div class="flex items-center justify-between px-6 py-3 hover:bg-white/2 transition-colors">
                        <div>
                            <p class="text-xs text-gray-500 font-mono">{{ $booking->booking_code }}</p>
                            <p class="text-sm text-white">{{ $booking->user->name }} → {{ $booking->field->name }}</p>
                        </div>
                        <div class="text-right">
                            <span class="text-xs {{ $sc[$booking->status] ?? 'text-gray-400' }}">{{ ucfirst($booking->status) }}</span>
                            <p class="text-xs text-gray-500">{{ $booking->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
