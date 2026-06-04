<x-app-layout>
    <x-slot name="title">Admin Dashboard</x-slot>

    <div class="flex min-h-screen">
        <x-sidebar section="admin" />

        <main class="flex-1 min-w-0 bg-[#F5F5F0]">
            {{-- Top bar --}}
            <div class="bg-white border-b border-[rgba(26,26,26,0.1)] px-8 py-5">
                <p class="text-xs font-bold uppercase tracking-[0.15em] text-[#717974]">ADMIN PANEL</p>
                <h1 class="font-display text-2xl font-bold uppercase text-[#1A1A1A] leading-tight mt-0.5">DASHBOARD</h1>
            </div>

            <div class="p-8">
                {{-- Stat Cards --}}
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-0 border border-[rgba(26,26,26,0.1)] mb-8">
                    @foreach([
                        ['USERS',     $totalUsers,   'Total Pengguna'],
                        ['FIELDS',    $totalFields,  'Total Lapangan'],
                        ['BOOKINGS',  $totalBookings,'Total Pemesanan'],
                        ['REVENUE',   'Rp ' . number_format($totalRevenue,0,',','.'), 'Pendapatan'],
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

                {{-- Status summary --}}
                <div class="grid grid-cols-2 gap-0 border border-[rgba(26,26,26,0.1)] mb-8">
                    <div class="bg-white p-6 border-r border-[rgba(26,26,26,0.1)] flex items-center gap-4">
                        <div class="w-12 h-12 bg-[#F5F5F0] flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#717974]" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-display text-4xl font-extrabold text-[#1A1A1A] leading-none">{{ $pendingBookings }}</p>
                            <p class="text-xs font-bold uppercase tracking-[0.05em] text-[#717974] mt-1">MENUNGGU KONFIRMASI</p>
                        </div>
                    </div>
                    <div class="bg-white p-6 flex items-center gap-4">
                        <div class="w-12 h-12 bg-[#C6FF00] flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#1A1A1A]" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-display text-4xl font-extrabold text-[#1A1A1A] leading-none">{{ $confirmedBookings }}</p>
                            <p class="text-xs font-bold uppercase tracking-[0.05em] text-[#717974] mt-1">DIKONFIRMASI</p>
                        </div>
                    </div>
                </div>

                {{-- Recent bookings table --}}
                <div class="bg-white border border-[rgba(26,26,26,0.1)] overflow-hidden">
                    <div class="flex items-center justify-between px-6 py-4 border-b border-[rgba(26,26,26,0.08)] bg-[#F5F5F0]">
                        <h2 class="text-sm font-bold uppercase tracking-[0.05em] text-[#1A1A1A]">PEMESANAN TERBARU</h2>
                        <a href="{{ route('admin.bookings.index') }}" class="text-xs font-bold uppercase tracking-[0.05em] text-[#0D3B2E] hover:text-[#C6FF00] transition-colors">LIHAT SEMUA →</a>
                    </div>
                    <table class="w-full">
                        <thead>
                            <tr class="bg-[#F5F5F0] border-b border-[rgba(26,26,26,0.08)]">
                                <th class="text-left px-6 py-3 text-[10px] font-bold uppercase tracking-[0.15em] text-[#717974]">KODE</th>
                                <th class="text-left px-6 py-3 text-[10px] font-bold uppercase tracking-[0.15em] text-[#717974]">PEMESAN</th>
                                <th class="text-left px-6 py-3 text-[10px] font-bold uppercase tracking-[0.15em] text-[#717974]">STATUS</th>
                                <th class="text-right px-6 py-3 text-[10px] font-bold uppercase tracking-[0.15em] text-[#717974]">TANGGAL</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[rgba(26,26,26,0.05)]">
                            @foreach($recentBookings as $booking)
                                <tr class="hover:bg-[#F5F5F0] transition-colors">
                                    <td class="px-6 py-4">
                                        <span class="text-xs font-mono text-[#717974]">{{ $booking->booking_code }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-bold text-[#1A1A1A]">{{ $booking->user->name }}</p>
                                        <p class="text-xs text-[#717974]">{{ $booking->field->name }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <x-status-badge :status="$booking->status" />
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <p class="text-xs text-[#717974]">{{ $booking->created_at->format('d M Y') }}</p>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
