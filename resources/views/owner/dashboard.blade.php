<x-app-layout>
    <x-slot name="title">Dashboard Owner</x-slot>

    <div class="flex">
        <x-sidebar section="owner" />

        <main class="flex-1 min-w-0 py-8 px-4 sm:px-8">
            {{-- Header --}}
            <div class="flex items-center justify-between mb-8">
                <div>
                    <p class="section-label">Owner Panel</p>
                    <h1 class="text-2xl font-extrabold text-gray-900">Selamat datang, {{ auth()->user()->name }}</h1>
                </div>
                <a href="{{ route('owner.fields.create') }}" class="btn-primary">
                    <x-icon name="plus" class="w-4 h-4" />
                    Tambah Lapangan
                </a>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <x-stat-card label="Total Lapangan"       :value="$totalFields"    icon="field"     color="green" />
                <x-stat-card label="Total Pemesanan"      :value="$totalBookings"  icon="clipboard" color="blue"  />
                <x-stat-card label="Menunggu Konfirmasi"  :value="$pendingCount"   icon="clock"     color="yellow" />
                <x-stat-card label="Total Pendapatan"
                    value="Rp {{ number_format($revenue, 0, ',', '.') }}"
                    icon="banknotes" color="green" />
            </div>

            {{-- Quick nav --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                @foreach([
                    ['owner.fields.index',   'field',    'Lapangan Saya',  'Kelola lapangan Anda'],
                    ['owner.bookings.index', 'clipboard','Pemesanan',       'Konfirmasi & kelola'],
                    ['notifications.index',  'bell',     'Notifikasi',      'Pesan & pemberitahuan'],
                ] as [$route, $icon, $label, $sub])
                    <a href="{{ route($route) }}"
                       class="card p-5 flex items-center gap-4 hover:shadow-sm transition-shadow group">
                        <div class="w-10 h-10 rounded-xl bg-primary-light flex items-center justify-center">
                            <x-icon name="{{ $icon }}" class="w-5 h-5 text-primary" />
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 group-hover:text-primary transition-colors text-sm">{{ $label }}</p>
                            <p class="text-xs text-gray-400">{{ $sub }}</p>
                        </div>
                        <x-icon name="chevron-right" class="w-4 h-4 text-gray-300 ml-auto" />
                    </a>
                @endforeach
            </div>

            {{-- Recent bookings --}}
            <div class="card overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-field">
                    <h2 class="font-bold text-gray-900">Pemesanan Terbaru</h2>
                    <a href="{{ route('owner.bookings.index') }}" class="text-sm text-primary hover:underline font-medium">
                        Lihat semua
                    </a>
                </div>
                @if($recentBookings->isEmpty())
                    <div class="py-12 text-center text-gray-400 text-sm">Belum ada pemesanan masuk.</div>
                @else
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
                                <div class="text-right">
                                    <p class="text-xs text-gray-400">{{ $booking->booking_date->format('d M Y') }}</p>
                                    <p class="text-sm font-bold text-gray-900">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </main>
    </div>
</x-app-layout>
