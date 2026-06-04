{{-- Shared Owner/Admin sidebar layout partial --}}
@props(['section' => 'owner'])

@php
    $isAdmin = $section === 'admin';
    $links = $isAdmin ? [
        ['route' => 'admin.dashboard',      'icon' => 'shield',    'label' => 'DASHBOARD'],
        ['route' => 'admin.users.index',    'icon' => 'users',     'label' => 'PENGGUNA'],
        ['route' => 'admin.bookings.index', 'icon' => 'clipboard', 'label' => 'SEMUA PEMESANAN'],
        ['route' => 'fields.index',         'icon' => 'field',     'label' => 'LAPANGAN'],
    ] : [
        ['route' => 'owner.dashboard',      'icon' => 'store',     'label' => 'DASHBOARD'],
        ['route' => 'owner.fields.index',   'icon' => 'field',     'label' => 'LAPANGAN SAYA'],
        ['route' => 'owner.bookings.index', 'icon' => 'clipboard', 'label' => 'PEMESANAN'],
        ['route' => 'notifications.index',  'icon' => 'bell',      'label' => 'NOTIFIKASI'],
    ];
@endphp

<aside class="w-64 shrink-0 bg-[#0D3B2E] texture-field min-h-screen hidden lg:flex flex-col">
    {{-- Logo --}}
    <div class="px-6 py-6 border-b border-[rgba(255,255,255,0.1)]">
        <a href="{{ route('landing') }}">
            <img src="{{ asset('images/logo.png') }}" alt="GOALIN" class="h-7 w-auto brightness-0 invert">
        </a>
    </div>

    <nav class="flex-1 py-6 px-3">
        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[rgba(245,245,240,0.35)] px-3 mb-4">
            {{ $isAdmin ? 'ADMIN PANEL' : 'OWNER PANEL' }}
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

        <div class="border-t border-[rgba(255,255,255,0.1)] pt-4 mt-6">
            <a href="{{ route('profile.edit') }}"
               class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                </svg>
                PROFIL
            </a>
        </div>
    </nav>

    {{-- Bottom logout --}}
    <div class="px-3 py-5 border-t border-[rgba(255,255,255,0.1)]">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sidebar-link w-full text-left text-[#C6FF00]/70 hover:text-[#C6FF00]">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9"/>
                </svg>
                KELUAR
            </button>
        </form>
    </div>
</aside>
