<x-app-layout>
    <x-slot name="title">Notifikasi</x-slot>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-extrabold text-gray-900">Notifikasi</h1>
                <p class="text-sm text-gray-500 mt-0.5">Pemberitahuan pemesanan dan aktivitas akun</p>
            </div>
            @if($notifications->total() > 0)
                <form method="POST" action="{{ route('notifications.read-all') }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn-ghost text-xs">
                        <x-icon name="check" class="w-4 h-4" />
                        Tandai semua dibaca
                    </button>
                </form>
            @endif
        </div>

        @if($notifications->isEmpty())
            <div class="card p-16 text-center">
                <div class="w-16 h-16 bg-primary-light rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <x-icon name="bell" class="w-8 h-8 text-primary" />
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Belum ada notifikasi</h3>
                <p class="text-sm text-gray-500">Anda akan mendapat notifikasi saat ada pemesanan baru atau perubahan status.</p>
            </div>
        @else
            <div class="space-y-2">
                @foreach($notifications as $notif)
                    @php
                        $typeIcons = [
                            'booking_pending'   => ['icon' => 'clock',     'color' => 'text-amber-500',  'bg' => 'bg-amber-50'],
                            'booking_confirmed' => ['icon' => 'check',     'color' => 'text-primary',    'bg' => 'bg-primary-light'],
                            'booking_cancelled' => ['icon' => 'x-circle',  'color' => 'text-red-500',    'bg' => 'bg-red-50'],
                            'booking_completed' => ['icon' => 'clipboard', 'color' => 'text-blue-500',   'bg' => 'bg-blue-50'],
                            'payment_reminder'  => ['icon' => 'banknotes', 'color' => 'text-orange-500', 'bg' => 'bg-orange-50'],
                        ];
                        $meta = $typeIcons[$notif->type] ?? ['icon' => 'bell', 'color' => 'text-gray-400', 'bg' => 'bg-gray-50'];
                        $unread = $notif->isUnread();
                    @endphp
                    <div class="flex items-start gap-4 p-4 rounded-xl bg-white border
                        {{ $unread ? 'border-l-4 border-l-primary border-field bg-accent' : 'border-field' }}
                        transition-colors hover:border-primary/30">

                        <div class="w-10 h-10 rounded-xl {{ $meta['bg'] }} flex items-center justify-center shrink-0">
                            <x-icon name="{{ $meta['icon'] }}" class="w-5 h-5 {{ $meta['color'] }}" />
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-3">
                                <p class="text-sm font-{{ $unread ? 'semibold' : 'medium' }} text-gray-900">
                                    {{ $notif->title }}
                                </p>
                                @if($unread)
                                    <span class="w-2 h-2 rounded-full bg-primary shrink-0 mt-1.5"></span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-500 mt-0.5 leading-relaxed">{{ $notif->message }}</p>
                            <div class="flex items-center justify-between mt-2">
                                <span class="text-xs text-gray-400">{{ $notif->created_at->diffForHumans() }}</span>
                                @if($unread)
                                    <form method="POST" action="{{ route('notifications.read', $notif) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-xs text-primary hover:underline font-medium">
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
