{{-- Shared Owner/Admin sidebar layout partial --}}
@props(['section' => 'owner'])

@php
    $isAdmin = $section === 'admin';
    $links = $isAdmin ? [
        ['route' => 'admin.dashboard',      'icon' => 'shield',    'label' => 'Dashboard'],
        ['route' => 'admin.users.index',    'icon' => 'users',     'label' => 'Pengguna'],
        ['route' => 'admin.bookings.index', 'icon' => 'clipboard', 'label' => 'Semua Pemesanan'],
        ['route' => 'fields.index',         'icon' => 'field',     'label' => 'Lapangan'],
    ] : [
        ['route' => 'owner.dashboard',        'icon' => 'store',    'label' => 'Dashboard'],
        ['route' => 'owner.fields.index',     'icon' => 'field',    'label' => 'Lapangan Saya'],
        ['route' => 'owner.bookings.index',   'icon' => 'clipboard','label' => 'Pemesanan'],
        ['route' => 'notifications.index',    'icon' => 'bell',     'label' => 'Notifikasi'],
    ];
@endphp

<aside class="w-60 shrink-0 bg-white border-r border-[#e5e5e5] min-h-screen hidden lg:block">
    <nav class="py-8 px-4 sticky top-16">
        <p class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#a3a3a3] px-4 mb-4">
            {{ $isAdmin ? 'Admin Panel' : 'Owner Panel' }}
        </p>
        <div class="space-y-0.5">
            @foreach($links as $link)
                <a href="{{ route($link['route']) }}"
                   class="sidebar-link {{ request()->routeIs($link['route']) ? 'active' : '' }}">
                    <x-icon name="{{ $link['icon'] }}" class="w-4 h-4" />
                    {{ $link['label'] }}
                </a>
            @endforeach
        </div>
        <div class="border-t border-[#f5f5f5] pt-4 mt-6">
            <a href="{{ route('profile.edit') }}" class="sidebar-link">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                </svg>
                Profil
            </a>
        </div>
    </nav>
</aside>
