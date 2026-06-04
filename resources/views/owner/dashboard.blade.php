<x-app-layout>
    <x-slot name="title">Dashboard Owner</x-slot>

    <div class="flex min-h-screen">
        <x-sidebar section="owner" />

        <main class="flex-1 min-w-0 bg-[#F5F5F0]">
            {{-- Top bar --}}
            <div class="bg-white border-b border-[rgba(26,26,26,0.1)] px-8 py-5 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.15em] text-[#717974]">OWNER PANEL</p>
                    <h1 class="font-display text-2xl font-bold uppercase text-[#1A1A1A] leading-tight mt-0.5">DASHBOARD</h1>
                </div>
                <a href="{{ route('owner.fields.create') }}" class="btn-primary py-2.5 px-5 text-xs hidden sm:flex">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    TAMBAH LAPANGAN
                </a>
            </div>

            <div class="p-8">
                {{-- Welcome --}}
                <div class="mb-8">
                    <p class="text-[#717974] text-sm">Selamat datang,</p>
                    <p class="font-display text-3xl font-bold uppercase text-[#0D3B2E]">{{ auth()->user()->name }}</p>
                </div>

                {{-- Stat Cards --}}
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-0 border border-[rgba(26,26,26,0.1)] mb-8">
                    @foreach([
                        ['LAPANGAN', $totalFields, 'Total Lapangan'],
                        ['BOOKING',  $totalBookings, 'Total Pemesanan'],
                        ['PENDING',  $pendingCount, 'Menunggu'],
                        ['REVENUE',  'Rp ' . number_format($revenue,0,',','.'), 'Pendapatan'],
                    ] as [$tag, $value, $label])
                        <div class="bg-white p-6 border-r border-b border-[rgba(26,26,26,0.1)] last:border-r-0 relative overflow-hidden">
                            <div class="absolute top-3 right-3 w-8 h-8 bg-[#C6FF00] flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#1A1A1A]" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/>
                                </svg>
                            </div>
                            <p class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#717974] mb-3">{{ $tag }}</p>
                            <p class="font-display text-3xl font-extrabold text-[#0D3B2E] leading-none">{{ $value }}</p>
                            <p class="text-xs text-[#717974] mt-1">{{ $label }}</p>
                        </div>
                    @endforeach
                </div>

                {{-- Quick nav --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-0 border border-[rgba(26,26,26,0.1)] mb-8">
                    @foreach([
                        ['owner.fields.index',   'field',    'LAPANGAN SAYA',  'Kelola lapangan Anda'],
                        ['owner.bookings.index', 'clipboard','PEMESANAN',       'Konfirmasi & kelola'],
                        ['notifications.index',  'bell',     'NOTIFIKASI',      'Pesan & pemberitahuan'],
                    ] as [$route, $icon, $label, $sub])
                        <a href="{{ route($route) }}"
                           class="group bg-white border-r border-[rgba(26,26,26,0.1)] last:border-r-0 p-6 flex items-center gap-4 hover:bg-[#F5F5F0] transition-colors">
                            <div class="w-10 h-10 bg-[#F5F5F0] group-hover:bg-[#C6FF00] flex items-center justify-center shrink-0 transition-colors">
                                <x-icon name="{{ $icon }}" class="w-5 h-5 text-[#717974] group-hover:text-[#1A1A1A]" />
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold uppercase tracking-[0.05em] text-[#1A1A1A]">{{ $label }}</p>
                                <p class="text-xs text-[#717974]">{{ $sub }}</p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[rgba(26,26,26,0.2)] group-hover:text-[#1A1A1A] transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
                            </svg>
                        </a>
                    @endforeach
                </div>

                {{-- Recent bookings --}}
                <div class="bg-white border border-[rgba(26,26,26,0.1)] overflow-hidden">
                    <div class="flex items-center justify-between px-6 py-4 border-b border-[rgba(26,26,26,0.08)] bg-[#F5F5F0]">
                        <h2 class="text-sm font-bold uppercase tracking-[0.05em] text-[#1A1A1A]">PEMESANAN TERBARU</h2>
                        <a href="{{ route('owner.bookings.index') }}" class="text-xs font-bold uppercase tracking-[0.05em] text-[#0D3B2E] hover:text-[#C6FF00] transition-colors">
                            LIHAT SEMUA →
                        </a>
                    </div>
                    @if($recentBookings->isEmpty())
                        <div class="py-16 text-center text-[#717974] text-sm">Belum ada pemesanan masuk.</div>
                    @else
                        <div class="divide-y divide-[rgba(26,26,26,0.06)]">
                            @foreach($recentBookings as $booking)
                                <div class="flex items-center justify-between px-6 py-4 hover:bg-[#F5F5F0] transition-colors">
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="text-xs font-mono text-[#717974]">{{ $booking->booking_code }}</span>
                                            <x-status-badge :status="$booking->status" />
                                        </div>
                                        <p class="text-sm font-bold text-[#1A1A1A]">{{ $booking->user->name }}</p>
                                        <p class="text-xs text-[#717974]">{{ $booking->field->name }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-[#717974]">{{ $booking->booking_date->format('d M Y') }}</p>
                                        <p class="text-sm font-bold text-[#1A1A1A]">Rp {{ number_format($booking->total_price,0,',','.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
