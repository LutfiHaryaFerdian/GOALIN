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
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700;800&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,700;1,9..40,400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Midtrans Snap.js --}}
    <script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
    @stack('styles')
</head>
<body class="h-full bg-[#F5F5F0] text-[#1A1A1A] font-sans antialiased">

{{-- ═══════════════════════════════════════════
     NAVBAR — canvas bg, sticky, editorial
═══════════════════════════════════════════ --}}
<header class="sticky top-0 z-50 bg-[#F5F5F0] border-b border-[rgba(26,26,26,0.1)]"
        x-data="{ mobileOpen: false }">
    <div class="max-w-[1280px] mx-auto px-5 md:px-12 flex items-center justify-between h-16">

        {{-- Logo --}}
        <a href="{{ route('landing') }}" class="shrink-0">
            <img src="{{ asset('images/logo.png') }}" alt="GOALIN" class="h-8 w-auto">
        </a>

        {{-- Desktop nav --}}
        <nav class="hidden md:flex items-center gap-8">
            <a href="{{ route('fields.index') }}"
               class="text-sm font-bold uppercase tracking-[0.05em] {{ request()->routeIs('fields.*') ? 'text-[#0D3B2E] border-b-2 border-[#C6FF00] pb-0.5' : 'text-[#1A1A1A] hover:text-[#0D3B2E]' }} transition-colors">
                LAPANGAN
            </a>
            @auth
                <a href="{{ route('bookings.index') }}"
                   class="text-sm font-bold uppercase tracking-[0.05em] {{ request()->routeIs('bookings.*') ? 'text-[#0D3B2E] border-b-2 border-[#C6FF00] pb-0.5' : 'text-[#1A1A1A] hover:text-[#0D3B2E]' }} transition-colors">
                    PEMESANAN
                </a>
                @if(auth()->user()->isOwner())
                    <a href="{{ route('owner.dashboard') }}"
                       class="text-sm font-bold uppercase tracking-[0.05em] {{ request()->routeIs('owner.*') ? 'text-[#0D3B2E] border-b-2 border-[#C6FF00] pb-0.5' : 'text-[#1A1A1A] hover:text-[#0D3B2E]' }} transition-colors">
                        DASHBOARD
                    </a>
                @endif
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}"
                       class="text-sm font-bold uppercase tracking-[0.05em] {{ request()->routeIs('admin.*') ? 'text-[#0D3B2E] border-b-2 border-[#C6FF00] pb-0.5' : 'text-[#1A1A1A] hover:text-[#0D3B2E]' }} transition-colors">
                        ADMIN
                    </a>
                @endif
            @endauth
        </nav>

        {{-- Right side --}}
        <div class="hidden md:flex items-center gap-3">
            @auth
                {{-- Bell --}}
                @php $unread = \App\Models\Notification::where('user_id', auth()->id())->whereNull('read_at')->count(); @endphp
                <a href="{{ route('notifications.index') }}" class="relative p-2 text-[#1A1A1A] hover:text-[#0D3B2E] transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"/>
                    </svg>
                    @if($unread > 0)
                        <span class="absolute top-0.5 right-0.5 flex h-4 w-4 avatar-circle items-center justify-center bg-[#C6FF00] text-[#1A1A1A] text-[9px] font-bold">
                            {{ $unread > 9 ? '9+' : $unread }}
                        </span>
                    @endif
                </a>

                {{-- Avatar dropdown --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                            class="flex items-center justify-center w-8 h-8 avatar-circle bg-[#0D3B2E] text-[#C6FF00] text-xs font-bold hover:bg-[#0a2e23] transition-colors">
                        @if(auth()->user()->avatar)
                            <img src="{{ Storage::url(auth()->user()->avatar) }}" class="w-full h-full object-cover avatar-circle" alt="">
                        @else
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        @endif
                    </button>
                    <div x-show="open" @click.outside="open = false"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="absolute right-0 mt-1 w-52 bg-[#0D3B2E] border border-[rgba(255,255,255,0.1)] z-50">
                        <div class="px-5 py-3 border-b border-[rgba(255,255,255,0.1)]">
                            <p class="text-xs font-bold text-[#C6FF00] truncate uppercase tracking-[0.05em]">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-[rgba(245,245,240,0.5)] truncate mt-0.5">{{ auth()->user()->email }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="block px-5 py-3 text-sm font-bold uppercase tracking-[0.05em] text-[#F5F5F0] hover:bg-white/5 transition-colors">PROFIL</a>
                        <hr class="border-[rgba(255,255,255,0.1)]">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-5 py-3 text-sm font-bold uppercase tracking-[0.05em] text-[#C6FF00] hover:bg-white/5 transition-colors">KELUAR</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="text-sm font-bold uppercase tracking-[0.05em] text-[#1A1A1A] hover:text-[#0D3B2E] transition-colors">LOG IN</a>
                <a href="{{ route('register') }}" class="btn-primary py-2.5 px-5 text-xs">MULAI BOOKING</a>
            @endauth

            {{-- Mobile hamburger --}}
            <button @click="mobileOpen = true" class="md:hidden p-2 text-[#1A1A1A]">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                </svg>
            </button>
        </div>

        {{-- Mobile hamburger (visible on mobile) --}}
        <button @click="mobileOpen = true" class="md:hidden p-2 text-[#1A1A1A]">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
            </svg>
        </button>
    </div>

    {{-- Mobile full-screen overlay --}}
    <div x-show="mobileOpen"
         x-cloak
         x-transition:enter="transition duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] bg-[#0D3B2E] texture-field flex flex-col p-8">
        <div class="flex items-center justify-between mb-12">
            <img src="{{ asset('images/logo.png') }}" alt="GOALIN" class="h-7 w-auto brightness-0 invert">
            <button @click="mobileOpen = false" class="text-[#C6FF00]">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <nav class="flex flex-col gap-5">
            <a @click="mobileOpen = false" href="{{ route('fields.index') }}"
               class="font-display text-5xl font-extrabold uppercase tracking-tight text-[#F5F5F0] hover:text-[#C6FF00] transition-colors">LAPANGAN</a>
            @auth
                <a @click="mobileOpen = false" href="{{ route('bookings.index') }}"
                   class="font-display text-5xl font-extrabold uppercase tracking-tight text-[#F5F5F0] hover:text-[#C6FF00] transition-colors">PEMESANAN</a>
                <a @click="mobileOpen = false" href="{{ route('notifications.index') }}"
                   class="font-display text-5xl font-extrabold uppercase tracking-tight text-[#F5F5F0] hover:text-[#C6FF00] transition-colors">NOTIFIKASI</a>
                @if(auth()->user()->isOwner())
                    <a @click="mobileOpen = false" href="{{ route('owner.dashboard') }}"
                       class="font-display text-5xl font-extrabold uppercase tracking-tight text-[#F5F5F0] hover:text-[#C6FF00] transition-colors">DASHBOARD</a>
                @endif
                @if(auth()->user()->isAdmin())
                    <a @click="mobileOpen = false" href="{{ route('admin.dashboard') }}"
                       class="font-display text-5xl font-extrabold uppercase tracking-tight text-[#F5F5F0] hover:text-[#C6FF00] transition-colors">ADMIN</a>
                @endif
                <a @click="mobileOpen = false" href="{{ route('profile.edit') }}"
                   class="font-display text-5xl font-extrabold uppercase tracking-tight text-[#F5F5F0] hover:text-[#C6FF00] transition-colors">PROFIL</a>
            @else
                <a @click="mobileOpen = false" href="{{ route('login') }}"
                   class="font-display text-5xl font-extrabold uppercase tracking-tight text-[#F5F5F0] hover:text-[#C6FF00] transition-colors">LOG IN</a>
                <a @click="mobileOpen = false" href="{{ route('register') }}"
                   class="font-display text-5xl font-extrabold uppercase tracking-tight text-[#C6FF00]">DAFTAR</a>
            @endauth
        </nav>
        @auth
            <div class="mt-auto">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-ghost-white w-full justify-center py-3">KELUAR</button>
                </form>
            </div>
        @endauth
    </div>
</header>

{{-- Flash messages --}}
@if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-end="opacity-0 translate-y-2"
         class="fixed top-4 right-4 z-[200] bg-[#C6FF00] text-[#1A1A1A] px-5 py-3 text-sm font-bold uppercase tracking-[0.05em] border border-[#1A1A1A] flex items-center gap-3 max-w-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
        </svg>
        <span>{{ session('success') }}</span>
    </div>
@endif
@if(session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-end="opacity-0 translate-y-2"
         class="fixed top-4 right-4 z-[200] bg-[#BA1A1A] text-white px-5 py-3 text-sm font-bold uppercase tracking-[0.05em] flex items-center gap-3 max-w-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
        </svg>
        <span>{{ session('error') }}</span>
    </div>
@endif
@if(session('info'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-end="opacity-0 translate-y-2"
         class="fixed top-4 right-4 z-[200] bg-[#0D3B2E] text-[#F5F5F0] px-5 py-3 text-sm font-bold uppercase tracking-[0.05em] flex items-center gap-3 max-w-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/>
        </svg>
        <span>{{ session('info') }}</span>
    </div>
@endif

{{-- Page content --}}
<main class="min-h-screen">
    {{ $slot }}
</main>

{{-- FOOTER --}}
<footer class="bg-[#0D3B2E] texture-field">
    <div class="max-w-[1280px] mx-auto px-5 md:px-12 py-16">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
            {{-- Brand --}}
            <div class="md:col-span-2">
                <img src="{{ asset('images/logo.png') }}" alt="GOALIN" class="h-8 w-auto brightness-0 invert mb-4">
                <p class="text-sm text-[rgba(245,245,240,0.6)] leading-relaxed max-w-xs">
                    Platform terlengkap untuk reservasi fasilitas olahraga. Temukan lapangan terbaik di kotamu.
                </p>
            </div>
            {{-- Menu --}}
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.15em] text-[rgba(245,245,240,0.4)] mb-4">NAVIGASI</p>
                <div class="flex flex-col gap-3">
                    <a href="{{ route('fields.index') }}" class="text-sm text-[rgba(245,245,240,0.7)] hover:text-[#C6FF00] transition-colors font-medium">Lapangan</a>
                    @auth
                        <a href="{{ route('bookings.index') }}" class="text-sm text-[rgba(245,245,240,0.7)] hover:text-[#C6FF00] transition-colors font-medium">Pemesanan</a>
                    @else
                        <a href="{{ route('register') }}" class="text-sm text-[rgba(245,245,240,0.7)] hover:text-[#C6FF00] transition-colors font-medium">Daftar Gratis</a>
                        <a href="{{ route('login') }}" class="text-sm text-[rgba(245,245,240,0.7)] hover:text-[#C6FF00] transition-colors font-medium">Masuk</a>
                    @endauth
                </div>
            </div>
            {{-- Legal --}}
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.15em] text-[rgba(245,245,240,0.4)] mb-4">LEGAL</p>
                <div class="flex flex-col gap-3">
                    <span class="text-sm text-[rgba(245,245,240,0.7)] font-medium">Syarat &amp; Ketentuan</span>
                    <span class="text-sm text-[rgba(245,245,240,0.7)] font-medium">Kebijakan Privasi</span>
                </div>
            </div>
        </div>
        <hr class="border-t border-[rgba(255,255,255,0.1)] mt-12 mb-6">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-2">
            <p class="text-xs text-[#717974]">&copy; {{ date('Y') }} GOALIN. Hak cipta dilindungi.</p>
            <p class="text-xs text-[#717974]">Made with <span class="text-[#C6FF00]">◆</span> in Indonesia</p>
        </div>
    </div>
</footer>

@stack('scripts')
</body>
</html>
