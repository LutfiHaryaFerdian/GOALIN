<x-app-layout>
    <x-slot name="title">Notifikasi</x-slot>

    {{-- Header dark --}}
    <div class="bg-[#0D3B2E] texture-field">
        <div class="max-w-[1280px] mx-auto px-5 md:px-12 py-16">
            <div class="flex items-end justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#C6FF00] mb-4">INBOX</p>
                    <h1 class="font-display font-extrabold uppercase leading-none text-white" style="font-size:clamp(40px,5vw,64px)">NOTIFIKASI.</h1>
                </div>
                @if($notifications->total() > 0)
                    <form method="POST" action="{{ route('notifications.read-all') }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn-ghost-white py-2.5 px-5 text-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                            </svg>
                            TANDAI SEMUA DIBACA
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <div class="max-w-[1280px] mx-auto px-5 md:px-12 py-12">
        @if($notifications->isEmpty())
            <div class="text-center py-32 border border-[rgba(26,26,26,0.1)]">
                <p class="font-display font-extrabold uppercase text-[rgba(26,26,26,0.07)]" style="font-size:clamp(40px,5vw,72px)">KOSONG</p>
                <p class="text-[#717974] text-sm mt-3">Tidak ada notifikasi saat ini.</p>
            </div>
        @else
            <div class="space-y-0 border border-[rgba(26,26,26,0.1)]">
                @foreach($notifications as $notif)
                    @php
                        $unread = $notif->isUnread();
                        $typeColors = [
                            'booking_pending'   => '#717974',
                            'booking_confirmed' => '#C6FF00',
                            'booking_cancelled' => '#BA1A1A',
                            'booking_completed' => '#1A1A1A',
                            'payment_reminder'  => '#C6FF00',
                        ];
                        $accentColor = $typeColors[$notif->type] ?? 'rgba(26,26,26,0.3)';
                    @endphp
                    <div class="flex border-b border-[rgba(26,26,26,0.08)] last:border-b-0 {{ $unread ? 'bg-white' : 'bg-[#F5F5F0]' }}"
                         style="{{ $unread ? 'border-left: 4px solid #C6FF00' : '' }}">
                        <div class="flex-1 flex items-start gap-4 p-5">
                            <div class="w-9 h-9 shrink-0 flex items-center justify-center {{ $unread ? 'bg-[#C6FF00]' : 'bg-[rgba(26,26,26,0.06)]' }}">
                                <x-icon name="{{ ['booking_pending'=>'clock','booking_confirmed'=>'check','booking_cancelled'=>'x-circle','booking_completed'=>'clipboard','payment_reminder'=>'banknotes'][$notif->type] ?? 'bell' }}"
                                        class="w-4 h-4 {{ $unread ? 'text-[#1A1A1A]' : 'text-[#717974]' }}" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-3">
                                    <p class="text-sm font-bold {{ $unread ? 'text-[#1A1A1A] uppercase tracking-[0.03em]' : 'text-[#717974]' }}">
                                        {{ $notif->title }}
                                    </p>
                                    @if($unread)
                                        <span class="w-2 h-2 avatar-circle bg-[#C6FF00] shrink-0 mt-1.5"></span>
                                    @endif
                                </div>
                                <p class="text-xs text-[#717974] mt-1 leading-relaxed">{{ $notif->message }}</p>
                                <div class="flex items-center justify-between mt-2">
                                    <span class="text-xs text-[rgba(26,26,26,0.4)]">{{ $notif->created_at->diffForHumans() }}</span>
                                    @if($unread)
                                        <form method="POST" action="{{ route('notifications.read', $notif) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-xs font-bold uppercase tracking-[0.05em] text-[#0D3B2E] hover:text-[#C6FF00] transition-colors">
                                                TANDAI DIBACA
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6">{{ $notifications->links() }}</div>
        @endif
    </div>
</x-app-layout>
