<x-app-layout>
    <x-slot name="title">Notifikasi</x-slot>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-white">Notifikasi</h1>
            @if($notifications->total() > 0)
                <form method="POST" action="{{ route('notifications.read-all') }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="text-xs text-gray-500 hover:text-emerald-400 transition-colors">
                        Tandai semua dibaca
                    </button>
                </form>
            @endif
        </div>

        @if($notifications->isEmpty())
            <div class="text-center py-20 bg-gray-900/40 border border-white/5 rounded-2xl">
                <div class="text-5xl mb-4">🔔</div>
                <h3 class="text-lg font-semibold text-white mb-2">Belum ada notifikasi</h3>
                <p class="text-sm text-gray-500">Anda akan mendapat notifikasi saat ada pemesanan baru atau perubahan status.</p>
            </div>
        @else
            <div class="space-y-2">
                @foreach($notifications as $notif)
                    @php
                        $typeIcons = [
                            'booking_pending'   => ['icon' => '⏳', 'color' => 'border-yellow-500/20 bg-yellow-500/5'],
                            'booking_confirmed' => ['icon' => '✅', 'color' => 'border-emerald-500/20 bg-emerald-500/5'],
                            'booking_cancelled' => ['icon' => '❌', 'color' => 'border-red-500/20 bg-red-500/5'],
                            'booking_completed' => ['icon' => '🏆', 'color' => 'border-blue-500/20 bg-blue-500/5'],
                            'payment_reminder'  => ['icon' => '💳', 'color' => 'border-orange-500/20 bg-orange-500/5'],
                            'system'            => ['icon' => '⚙️', 'color' => 'border-gray-500/20 bg-gray-500/5'],
                        ];
                        $meta = $typeIcons[$notif->type] ?? $typeIcons['system'];
                    @endphp
                    <div class="flex items-start gap-4 p-4 rounded-xl border {{ $meta['color'] }} {{ $notif->isUnread() ? 'border-l-2 border-l-emerald-500' : '' }} transition-colors">
                        <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-xl shrink-0">
                            {{ $meta['icon'] }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2">
                                <div>
                                    <p class="text-sm font-medium text-white {{ $notif->isUnread() ? '' : 'text-gray-300' }}">{{ $notif->title }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5 leading-relaxed">{{ $notif->message }}</p>
                                </div>
                                @if($notif->isUnread())
                                    <div class="w-2 h-2 rounded-full bg-emerald-500 shrink-0 mt-1.5"></div>
                                @endif
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <p class="text-xs text-gray-600">{{ $notif->created_at->diffForHumans() }}</p>
                                @if($notif->isUnread())
                                    <form method="POST" action="{{ route('notifications.read', $notif) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-xs text-gray-500 hover:text-emerald-400 transition-colors">
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
