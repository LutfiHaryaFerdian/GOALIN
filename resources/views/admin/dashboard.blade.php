<x-app-layout>
    <x-slot name="title">Admin Dashboard</x-slot>
    <div class="flex">
        <x-sidebar section="admin" />
        <main class="flex-1 min-w-0 py-10 px-4 sm:px-8">
            <div class="mb-10">
                <p class="section-label mb-2">ADMIN PANEL</p>
                <h1 class="font-display text-4xl md:text-5xl font-black uppercase tracking-tight text-[#0a0a0a]">DASHBOARD</h1>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
                @foreach([
                    ['Total Pengguna',  $totalUsers,   'USERS'],
                    ['Total Lapangan',  $totalFields,  'FIELDS'],
                    ['Total Pemesanan', $totalBookings,'BOOKINGS'],
                    ['Pendapatan',      'Rp ' . number_format($totalRevenue, 0, ',', '.'), 'REVENUE'],
                ] as [$label, $value, $tag])
                    <div class="bg-white border border-[#e5e5e5] rounded-2xl p-5">
                        <p class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#a3a3a3] mb-2">{{ $tag }}</p>
                        <p class="font-display text-3xl font-black text-[#0a0a0a] leading-none">{{ $value }}</p>
                        <p class="text-xs text-[#737373] mt-1">{{ $label }}</p>
                    </div>
                @endforeach
            </div>

            {{-- Status summary --}}
            <div class="grid grid-cols-2 gap-4 mb-10">
                <div class="bg-white border border-[#e5e5e5] rounded-2xl p-5 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-display text-4xl font-black text-[#0a0a0a] leading-none">{{ $pendingBookings }}</p>
                        <p class="text-xs text-[#a3a3a3] mt-1">Menunggu Konfirmasi</p>
                    </div>
                </div>
                <div class="bg-white border border-[#e5e5e5] rounded-2xl p-5 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-[#f0fdf4] flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#16a34a]" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-display text-4xl font-black text-[#0a0a0a] leading-none">{{ $confirmedBookings }}</p>
                        <p class="text-xs text-[#a3a3a3] mt-1">Dikonfirmasi</p>
                    </div>
                </div>
            </div>

            {{-- Recent bookings --}}
            <div class="bg-white border border-[#e5e5e5] rounded-2xl overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-[#f5f5f5]">
                    <h2 class="font-semibold text-[#0a0a0a]">Pemesanan Terbaru</h2>
                    <a href="{{ route('admin.bookings.index') }}" class="text-sm text-[#16a34a] hover:underline underline-offset-2 font-medium">Lihat semua</a>
                </div>
                <div class="divide-y divide-[#f5f5f5]">
                    @foreach($recentBookings as $booking)
                        <div class="flex items-center justify-between px-6 py-4 hover:bg-[#f8f8f6] transition-colors">
                            <div>
                                <div class="flex items-center gap-2 mb-0.5">
                                    <span class="text-xs font-mono text-[#a3a3a3]">{{ $booking->booking_code }}</span>
                                    <x-status-badge :status="$booking->status" />
                                </div>
                                <p class="text-sm font-semibold text-[#0a0a0a]">{{ $booking->user->name }}</p>
                                <p class="text-xs text-[#a3a3a3]">{{ $booking->field->name }}</p>
                            </div>
                            <p class="text-xs text-[#a3a3a3]">{{ $booking->created_at->format('d M Y') }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
