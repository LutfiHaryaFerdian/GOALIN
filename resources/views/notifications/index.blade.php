<x-app-layout>
    <x-slot name="title">Notifikasi</x-slot>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        {{-- Header --}}
        <div class="flex items-end justify-between mb-10">
            <div>
                <p class="section-label mb-2">INBOX</p>
                <h1 class="font-display text-4xl md:text-5xl font-black uppercase tracking-tight text-[#0a0a0a]">NOTIFIKASI</h1>
            </div>
            @if($notifications->total() > 0)
                <form method="POST" action="{{ route('notifications.read-all') }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="flex items-center gap-2 text-sm font-medium text-[#737373] hover:text-[#0a0a0a] transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                        </svg>
                        Tandai semua dibaca
                    </button>
                </form>
            @endif
        </div>

        @if($notifications->isEmpty())
            <div class="text-center py-32">
                <p class="font-display text-6xl font-black uppercase text-[#f0f0f0]">KOSONG</p>
                <p class="text-[#737373] text-sm mt-4">Anda akan mendapat notifikasi saat ada pemesanan baru atau perubahan status.</p>
            </div>
        @else
            <div class="space-y-2">
                @foreach($notifications as $notif)
                    @php
                        $unread = $notif->isUnread();
                        $typeIcons = [
                            'booking_pending'   => ['icon' => 'clock',     'color' => 'text-amber-600'],
                            'booking_confirmed' => ['icon' => 'check',     'color' => 'text-[#16a34a]'],
                            'booking_cancelled' => ['icon' => 'x-circle',  'color' => 'text-[#dc2626]'],
                            'booking_completed' => ['icon' => 'clipboard', 'color' => 'text-[#2563eb]'],
                            'payment_reminder'  => ['icon' => 'banknotes', 'color' => 'text-orange-500'],
                        ];
                        $meta = $typeIcons[$notif->type] ?? ['icon' => 'bell', 'color' => 'text-[#737373]'];
                    @endphp
                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-white border transition-colors
                        {{ $unread ? 'border-l-2 border-l-[#16a34a] border-[#e5e5e5] bg-[#f0fdf4]' : 'border-[#e5e5e5]' }}">

                        <div class="w-9 h-9 rounded-xl bg-[#f5f5f5] flex items-center justify-center shrink-0 {{ $unread ? 'bg-[#f0fdf4]' : '' }}">
                            <x-icon name="{{ $meta['icon'] }}" class="w-4 h-4 {{ $meta['color'] }}" />
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-3">
                                <p class="text-sm {{ $unread ? 'font-semibold text-[#0a0a0a]' : 'font-medium text-[#404040]' }}">
                                    {{ $notif->title }}
                                </p>
                                @if($unread)
                                    <span class="w-2 h-2 rounded-full bg-[#16a34a] shrink-0 mt-1.5"></span>
                                @endif
                            </div>
                            <p class="text-xs text-[#737373] mt-0.5 leading-relaxed">{{ $notif->message }}</p>
                            <div class="flex items-center justify-between mt-2">
                                <span class="text-xs text-[#a3a3a3]">{{ $notif->created_at->diffForHumans() }}</span>
                                @if($unread)
                                    <form method="POST" action="{{ route('notifications.read', $notif) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-xs text-[#16a34a] hover:underline underline-offset-2 font-medium">
                                            Tandai dibaca
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6">{{ $notifications->links() }}</div>
        @endif
    </div>
</x-app-layout>
