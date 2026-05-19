<x-app-layout>
    <x-slot name="title">Admin Dashboard</x-slot>
    <div class="flex">
        <x-sidebar section="admin" />
        <main class="flex-1 min-w-0 py-8 px-4 sm:px-8">
            <div class="mb-8">
                <p class="section-label">Admin Panel</p>
                <h1 class="text-2xl font-extrabold text-gray-900">Dashboard</h1>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <x-stat-card label="Total Pengguna"  :value="$totalUsers"    icon="users"     color="blue"   />
                <x-stat-card label="Total Lapangan"  :value="$totalFields"   icon="field"     color="green"  />
                <x-stat-card label="Total Pemesanan" :value="$totalBookings" icon="clipboard" color="gray"   />
                <x-stat-card label="Total Pendapatan"
                    value="Rp {{ number_format($totalRevenue, 0, ',', '.') }}"
                    icon="banknotes" color="green" />
            </div>

            {{-- Status summary --}}
            <div class="grid grid-cols-2 gap-4 mb-8">
                <div class="card p-5 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center">
                        <x-icon name="clock" class="w-6 h-6 text-amber-500" />
                    </div>
                    <div>
                        <p class="text-3xl font-extrabold text-gray-900">{{ $pendingBookings }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">Menunggu Konfirmasi</p>
                    </div>
                </div>
                <div class="card p-5 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-primary-light flex items-center justify-center">
                        <x-icon name="check" class="w-6 h-6 text-primary" />
                    </div>
                    <div>
                        <p class="text-3xl font-extrabold text-gray-900">{{ $confirmedBookings }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">Dikonfirmasi</p>
                    </div>
                </div>
            </div>

            {{-- Recent bookings --}}
            <div class="card overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-field bg-accent">
                    <h2 class="font-bold text-gray-900">Pemesanan Terbaru</h2>
                    <a href="{{ route('admin.bookings.index') }}" class="text-sm text-primary hover:underline font-medium">Lihat semua</a>
                </div>
                <div class="divide-y divide-field">
                    @foreach($recentBookings as $booking)
                        <div class="flex items-center justify-between px-6 py-3.5 hover:bg-accent transition-colors">
                            <div>
                                <div class="flex items-center gap-2 mb-0.5">
                                    <span class="text-xs font-mono text-gray-400">{{ $booking->booking_code }}</span>
                                    <x-status-badge :status="$booking->status" />
                                </div>
                                <p class="text-sm font-semibold text-gray-900">{{ $booking->user->name }}</p>
                                <p class="text-xs text-gray-400">{{ $booking->field->name }}</p>
                            </div>
                            <p class="text-xs text-gray-400">{{ $booking->created_at->format('d M Y') }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
