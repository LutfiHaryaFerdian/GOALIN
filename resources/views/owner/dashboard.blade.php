<x-app-layout>
    <x-slot name="title">Dashboard Owner</x-slot>

    <div class="flex">
        <x-sidebar section="owner" />

        <main class="flex-1 min-w-0 py-10 px-4 sm:px-8">
            {{-- Header --}}
            <div class="flex items-end justify-between mb-10">
                <div>
                    <p class="section-label mb-2">OWNER PANEL</p>
                    <h1 class="font-display text-4xl md:text-5xl font-black uppercase tracking-tight text-[#0a0a0a]">
                        SELAMAT<br>DATANG
                    </h1>
                    <p class="text-[#737373] text-sm mt-1">{{ auth()->user()->name }}</p>
                </div>
                <a href="{{ route('owner.fields.create') }}" class="btn-dark hidden sm:inline-flex">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    Tambah Lapangan
                </a>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
                @foreach([
                    ['Total Lapangan', $totalFields, 'LAPANGAN'],
                    ['Total Pemesanan', $totalBookings, 'BOOKING'],
                    ['Menunggu', $pendingCount, 'PENDING'],
                    ['Pendapatan', 'Rp ' . number_format($revenue, 0, ',', '.'), 'REVENUE'],
                ] as [$label, $value, $tag])
                    <div class="bg-white border border-[#e5e5e5] rounded-2xl p-5">
                        <p class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#a3a3a3] mb-2">{{ $tag }}</p>
                        <p class="font-display text-3xl font-black text-[#0a0a0a] leading-none">{{ $value }}</p>
                        <p class="text-xs text-[#737373] mt-1">{{ $label }}</p>
                    </div>
                @endforeach
            </div>

            {{-- Quick nav --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-10">
                @foreach([
                    ['owner.fields.index',   'field',    'Lapangan Saya',  'Kelola lapangan Anda'],
                    ['owner.bookings.index', 'clipboard','Pemesanan',       'Konfirmasi & kelola'],
                    ['notifications.index',  'bell',     'Notifikasi',      'Pesan & pemberitahuan'],
                ] as [$route, $icon, $label, $sub])
                    <a href="{{ route($route) }}"
                       class="group bg-white border border-[#e5e5e5] hover:border-[#0a0a0a] transition-colors rounded-2xl p-5 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-[#f5f5f5] flex items-center justify-center shrink-0">
                            <x-icon name="{{ $icon }}" class="w-5 h-5 text-[#737373]" />
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-[#0a0a0a] text-sm">{{ $label }}</p>
                            <p class="text-xs text-[#a3a3a3]">{{ $sub }}</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#d4d4d4] group-hover:text-[#0a0a0a] transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
                        </svg>
                    </a>
                @endforeach
            </div>

            {{-- Recent bookings --}}
            <div class="bg-white border border-[#e5e5e5] rounded-2xl overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-[#f5f5f5]">
                    <h2 class="font-semibold text-[#0a0a0a]">Pemesanan Terbaru</h2>
                    <a href="{{ route('owner.bookings.index') }}" class="text-sm text-[#16a34a] hover:underline underline-offset-2 font-medium">
                        Lihat semua
                    </a>
                </div>
                @if($recentBookings->isEmpty())
                    <div class="py-16 text-center text-[#a3a3a3] text-sm">Belum ada pemesanan masuk.</div>
                @else
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
                                <div class="text-right">
                                    <p class="text-xs text-[#a3a3a3]">{{ $booking->booking_date->format('d M Y') }}</p>
                                    <p class="text-sm font-bold text-[#0a0a0a]">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </main>
    </div>
</x-app-layout>
