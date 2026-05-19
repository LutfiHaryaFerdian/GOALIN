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

<aside class="w-56 shrink-0 bg-white border-r border-field min-h-screen hidden lg:block">
    <nav class="py-6 px-3 space-y-0.5 sticky top-16">
        <p class="label px-4 mb-3">{{ $isAdmin ? 'Admin Panel' : 'Owner Panel' }}</p>
        @foreach($links as $link)
            <a href="{{ route($link['route']) }}"
               class="sidebar-link {{ request()->routeIs($link['route']) ? 'active' : '' }}">
                <x-icon name="{{ $link['icon'] }}" class="w-4 h-4" />
                {{ $link['label'] }}
            </a>
        @endforeach
        <div class="border-t border-field pt-3 mt-3">
            <a href="{{ route('profile.edit') }}" class="sidebar-link">
                <x-icon name="user" class="w-4 h-4" />
                Profil
            </a>
        </div>
    </nav>
</aside>
