<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'GOALIN') }}@isset($title) — {{ $title }}@endisset</title>
    <meta name="description" content="{{ $metaDescription ?? 'GOALIN — Pesan lapangan olahraga terbaik di kotamu.' }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Midtrans Snap.js --}}
    <script
        src="{{ config('midtrans.snap_url') }}"
        data-client-key="{{ config('midtrans.client_key') }}">
    </script>
</head>
<body class="h-full bg-canvas font-sans antialiased">

{{-- ═══════════════════════════════════════════════
     NAVBAR — white, sticky, border-b only
═══════════════════════════════════════════════ --}}
<header class="sticky top-0 z-50 bg-white border-b border-[#e5e5e5]" x-data="{ mobileOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between gap-6">

            {{-- Logo --}}
            <a href="{{ route('landing') }}" class="flex items-center gap-1 shrink-0">
                <span class="font-display text-2xl font-bold uppercase tracking-tight text-[#0a0a0a]">GOALIN</span>
                <span class="w-1.5 h-1.5 rounded-full bg-[#16a34a] mb-3"></span>
            </a>

            {{-- Desktop nav --}}
            <nav class="hidden md:flex items-center gap-8">
                <a href="{{ route('fields.index') }}"
                   class="text-sm font-medium transition-colors {{ request()->routeIs('fields.*') ? 'text-[#0a0a0a]' : 'text-[#737373] hover:text-[#0a0a0a]' }}">
                    Lapangan
                </a>
                @auth
                    <a href="{{ route('bookings.index') }}"
                       class="text-sm font-medium transition-colors {{ request()->routeIs('bookings.*') ? 'text-[#0a0a0a]' : 'text-[#737373] hover:text-[#0a0a0a]' }}">
                        Pemesanan
                    </a>
                    @if(auth()->user()->isOwner())
                        <a href="{{ route('owner.dashboard') }}"
                           class="text-sm font-medium transition-colors {{ request()->routeIs('owner.*') ? 'text-[#0a0a0a]' : 'text-[#737373] hover:text-[#0a0a0a]' }}">
                            Dashboard
                        </a>
                    @endif
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                           class="text-sm font-medium transition-colors {{ request()->routeIs('admin.*') ? 'text-[#0a0a0a]' : 'text-[#737373] hover:text-[#0a0a0a]' }}">
                            Admin
                        </a>
                    @endif
                @endauth
            </nav>

            {{-- Right side --}}
            <div class="flex items-center gap-2">
                @auth
                    {{-- Bell icon --}}
                    @php $unread = \App\Models\Notification::where('user_id', auth()->id())->whereNull('read_at')->count(); @endphp
                    <a href="{{ route('notifications.index') }}"
                       class="relative p-2 text-[#737373] hover:text-[#0a0a0a] transition-colors rounded-lg hover:bg-[#f5f5f5]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"/>
                        </svg>
                        @if($unread > 0)
                            <span class="absolute top-1 right-1 flex h-3.5 w-3.5 items-center justify-center rounded-full bg-[#16a34a] text-[9px] font-bold text-white">
                                {{ $unread > 9 ? '9+' : $unread }}
                            </span>
                        @endif
                    </a>

                    {{-- Avatar dropdown --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                                class="flex items-center justify-center w-8 h-8 rounded-full bg-[#0a0a0a] text-white text-xs font-bold hover:bg-[#404040] transition-colors">
                            @if(auth()->user()->avatar)
                                <img src="{{ Storage::url(auth()->user()->avatar) }}" class="w-full h-full object-cover rounded-full" alt="">
                            @else
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            @endif
                        </button>
                        <div x-show="open" @click.outside="open = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="absolute right-0 mt-2 w-48 bg-white border border-[#e5e5e5] rounded-2xl shadow-lg py-1 z-50">
                            <div class="px-4 py-2.5 border-b border-[#f5f5f5]">
                                <p class="text-xs font-semibold text-[#0a0a0a] truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-[#737373] truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-[#404040] hover:bg-[#f8f8f6] transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                                </svg>
                                Profil Saya
                            </a>
                            <div class="border-t border-[#f5f5f5] my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-[#dc2626] hover:bg-red-50 transition-colors text-left">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9"/>
                                    </svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-[#737373] hover:text-[#0a0a0a] transition-colors hidden sm:block">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-dark text-xs px-4 py-2">Daftar</a>
                @endauth

                {{-- Mobile hamburger --}}
                <button @click="mobileOpen = !mobileOpen"
                        class="md:hidden p-2 text-[#737373] hover:text-[#0a0a0a] rounded-lg hover:bg-[#f5f5f5] transition-colors">
                    <svg x-show="!mobileOpen" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                    </svg>
                    <svg x-show="mobileOpen" x-cloak xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile drawer --}}
    <div x-show="mobileOpen" x-transition
         class="md:hidden border-t border-[#e5e5e5] bg-white px-4 py-3 space-y-1">
        <a href="{{ route('fields.index') }}" class="block px-3 py-2.5 text-sm font-medium text-[#404040] hover:text-[#0a0a0a] hover:bg-[#f5f5f5] rounded-xl transition-colors">
            Lapangan
        </a>
        @auth
            <a href="{{ route('bookings.index') }}" class="block px-3 py-2.5 text-sm font-medium text-[#404040] hover:text-[#0a0a0a] hover:bg-[#f5f5f5] rounded-xl transition-colors">Pemesanan</a>
            <a href="{{ route('notifications.index') }}" class="block px-3 py-2.5 text-sm font-medium text-[#404040] hover:text-[#0a0a0a] hover:bg-[#f5f5f5] rounded-xl transition-colors">Notifikasi</a>
            @if(auth()->user()->isOwner())
                <a href="{{ route('owner.dashboard') }}" class="block px-3 py-2.5 text-sm font-medium text-[#404040] hover:text-[#0a0a0a] hover:bg-[#f5f5f5] rounded-xl transition-colors">Dashboard Owner</a>
            @endif
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2.5 text-sm font-medium text-[#404040] hover:text-[#0a0a0a] hover:bg-[#f5f5f5] rounded-xl transition-colors">Admin</a>
            @endif
            <a href="{{ route('profile.edit') }}" class="block px-3 py-2.5 text-sm font-medium text-[#404040] hover:text-[#0a0a0a] hover:bg-[#f5f5f5] rounded-xl transition-colors">Profil</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full text-left px-3 py-2.5 text-sm font-medium text-[#dc2626] hover:bg-red-50 rounded-xl transition-colors">Keluar</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="block px-3 py-2.5 text-sm font-medium text-[#404040] hover:text-[#0a0a0a] hover:bg-[#f5f5f5] rounded-xl transition-colors">Masuk</a>
            <a href="{{ route('register') }}" class="block px-3 py-2.5 text-sm font-semibold text-[#0a0a0a] bg-[#f5f5f5] rounded-xl text-center">Daftar</a>
        @endauth
    </div>
</header>

{{-- Flash messages --}}
@if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-end="opacity-0 -translate-y-2"
         class="fixed top-20 right-4 z-50 flex items-center gap-3 bg-white border border-[#e5e5e5] border-l-4 border-l-[#16a34a] text-[#0a0a0a] px-4 py-3 rounded-2xl shadow-sm max-w-sm text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#16a34a] shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
        </svg>
        <span>{{ session('success') }}</span>
        <button @click="show=false" class="ml-auto text-[#a3a3a3] hover:text-[#737373]">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
@endif
@if(session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-end="opacity-0 -translate-y-2"
         class="fixed top-20 right-4 z-50 flex items-center gap-3 bg-white border border-[#e5e5e5] border-l-4 border-l-[#dc2626] text-[#0a0a0a] px-4 py-3 rounded-2xl shadow-sm max-w-sm text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#dc2626] shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
        </svg>
        <span>{{ session('error') }}</span>
        <button @click="show=false" class="ml-auto text-[#a3a3a3] hover:text-[#737373]">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
@endif
@if(session('info'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-end="opacity-0 -translate-y-2"
         class="fixed top-20 right-4 z-50 flex items-center gap-3 bg-white border border-[#e5e5e5] border-l-4 border-l-[#2563eb] text-[#0a0a0a] px-4 py-3 rounded-2xl shadow-sm max-w-sm text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#2563eb] shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/>
        </svg>
        <span>{{ session('info') }}</span>
        <button @click="show=false" class="ml-auto text-[#a3a3a3] hover:text-[#737373]">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
@endif

{{-- Page content --}}
<main class="pt-0 min-h-screen">
    {{ $slot }}
</main>

{{-- Footer --}}
<footer class="bg-white border-t border-[#e5e5e5] mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            {{-- Logo + tagline --}}
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-1">
                    <span class="font-display text-xl font-bold uppercase tracking-tight text-[#0a0a0a]">GOALIN</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-[#16a34a] mb-2"></span>
                </div>
                <span class="text-xs text-[#a3a3a3]">Platform booking lapangan olahraga</span>
            </div>
            {{-- Links --}}
            <div class="flex items-center gap-6">
                <a href="{{ route('fields.index') }}" class="text-xs text-[#737373] hover:text-[#0a0a0a] transition-colors">Lapangan</a>
                @auth
                    <a href="{{ route('bookings.index') }}" class="text-xs text-[#737373] hover:text-[#0a0a0a] transition-colors">Pemesanan</a>
                @else
                    <a href="{{ route('register') }}" class="text-xs text-[#737373] hover:text-[#0a0a0a] transition-colors">Daftar Gratis</a>
                @endauth
            </div>
            {{-- Copyright --}}
            <p class="text-xs text-[#a3a3a3]">&copy; {{ date('Y') }} GOALIN.</p>
        </div>
    </div>
</footer>

</body>
</html>
