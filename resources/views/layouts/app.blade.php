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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Midtrans Snap.js --}}
    <script
        src="{{ config('midtrans.snap_url') }}"
        data-client-key="{{ config('midtrans.client_key') }}">
    </script>
</head>
<body class="h-full bg-accent font-sans antialiased">

{{-- ═══════════════════════════════════════════════
     NAVBAR
═══════════════════════════════════════════════ --}}
<header class="fixed top-0 inset-x-0 z-50 bg-primary border-b border-primary-dark" x-data="{ mobileOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between gap-6">

            {{-- Logo --}}
            <a href="{{ route('fields.index') }}" class="shrink-0">
                <x-logo variant="light" size="sm" />
            </a>

            {{-- Desktop nav --}}
            <nav class="hidden md:flex items-center gap-1">
                <a href="{{ route('fields.index') }}"
                   class="px-3 py-2 text-sm font-medium text-white/80 hover:text-white transition-colors
                          {{ request()->routeIs('fields.*') ? 'text-white border-b-2 border-white/60' : '' }}">
                    Cari Lapangan
                </a>
                @auth
                    @if(auth()->user()->isOwner())
                        <a href="{{ route('owner.dashboard') }}"
                           class="px-3 py-2 text-sm font-medium text-white/80 hover:text-white transition-colors
                                  {{ request()->routeIs('owner.*') ? 'text-white border-b-2 border-white/60' : '' }}">
                            Dashboard Owner
                        </a>
                    @endif
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                           class="px-3 py-2 text-sm font-medium text-white/80 hover:text-white transition-colors
                                  {{ request()->routeIs('admin.*') ? 'text-white border-b-2 border-white/60' : '' }}">
                            Admin
                        </a>
                    @endif
                    <a href="{{ route('bookings.index') }}"
                       class="px-3 py-2 text-sm font-medium text-white/80 hover:text-white transition-colors
                              {{ request()->routeIs('bookings.*') ? 'text-white border-b-2 border-white/60' : '' }}">
                        Pemesanan Saya
                    </a>
                @endauth
            </nav>

            {{-- Right side --}}
            <div class="flex items-center gap-2">
                @auth
                    {{-- Bell --}}
                    @php $unread = \App\Models\Notification::where('user_id', auth()->id())->whereNull('read_at')->count(); @endphp
                    <a href="{{ route('notifications.index') }}"
                       class="relative p-2 text-white/70 hover:text-white transition-colors rounded-lg hover:bg-white/10">
                        <x-icon name="bell" class="w-5 h-5" />
                        @if($unread > 0)
                            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-400 rounded-full ring-2 ring-primary"></span>
                        @endif
                    </a>

                    {{-- Avatar dropdown --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                                class="flex items-center gap-2 py-1.5 pl-1.5 pr-3 rounded-lg hover:bg-white/10 transition-colors">
                            <div class="w-7 h-7 rounded-lg bg-white/20 flex items-center justify-center text-white text-xs font-bold overflow-hidden">
                                @if(auth()->user()->avatar)
                                    <img src="{{ Storage::url(auth()->user()->avatar) }}" class="w-full h-full object-cover" alt="">
                                @else
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                @endif
                            </div>
                            <span class="text-sm font-medium text-white hidden sm:block">{{ auth()->user()->name }}</span>
                            <x-icon name="chevron-down" class="w-3.5 h-3.5 text-white/60" />
                        </button>
                        <div x-show="open" @click.outside="open = false" x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                             class="absolute right-0 mt-1 w-52 bg-white rounded-xl shadow-lg border border-field py-1 z-50">
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-accent transition-colors">
                                <x-icon name="user" class="w-4 h-4 text-gray-400" /> Profil Saya
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors text-left">
                                    <x-icon name="logout" class="w-4 h-4" /> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-white/80 hover:text-white px-3 py-2 transition-colors">Masuk</a>
                    <a href="{{ route('register') }}" class="text-sm font-semibold bg-white text-primary px-4 py-2 rounded-lg hover:bg-primary-light transition-colors">Daftar</a>
                @endauth

                {{-- Mobile toggle --}}
                <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 text-white/70 hover:text-white rounded-lg hover:bg-white/10">
                    <x-icon name="menu" class="w-5 h-5" x-show="!mobileOpen" />
                    <x-icon name="x-mark" class="w-5 h-5" x-show="mobileOpen" x-cloak />
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile drawer --}}
    <div x-show="mobileOpen" x-transition class="md:hidden border-t border-primary-dark bg-primary px-4 py-3 space-y-1">
        <a href="{{ route('fields.index') }}" class="block px-3 py-2 text-sm font-medium text-white/80 hover:text-white rounded-lg hover:bg-white/10 transition-colors">Cari Lapangan</a>
        @auth
            <a href="{{ route('bookings.index') }}" class="block px-3 py-2 text-sm font-medium text-white/80 hover:text-white rounded-lg hover:bg-white/10 transition-colors">Pemesanan Saya</a>
            <a href="{{ route('notifications.index') }}" class="block px-3 py-2 text-sm font-medium text-white/80 hover:text-white rounded-lg hover:bg-white/10 transition-colors">Notifikasi</a>
            @if(auth()->user()->isOwner())
                <a href="{{ route('owner.dashboard') }}" class="block px-3 py-2 text-sm font-medium text-white/80 hover:text-white rounded-lg hover:bg-white/10 transition-colors">Dashboard Owner</a>
            @endif
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 text-sm font-medium text-white/80 hover:text-white rounded-lg hover:bg-white/10 transition-colors">Admin</a>
            @endif
            <a href="{{ route('profile.edit') }}" class="block px-3 py-2 text-sm font-medium text-white/80 hover:text-white rounded-lg hover:bg-white/10 transition-colors">Profil</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full text-left px-3 py-2 text-sm font-medium text-red-300 hover:text-white rounded-lg hover:bg-white/10 transition-colors">Keluar</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="block px-3 py-2 text-sm font-medium text-white/80 hover:text-white rounded-lg hover:bg-white/10 transition-colors">Masuk</a>
            <a href="{{ route('register') }}" class="block px-3 py-2 text-sm font-medium text-white rounded-lg bg-white/10 transition-colors">Daftar</a>
        @endauth
    </div>
</header>

{{-- Flash messages --}}
@if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-end="opacity-0 -translate-y-2"
         class="fixed top-20 right-4 z-50 flex items-center gap-3 bg-white border-l-4 border-primary text-gray-800 px-4 py-3 rounded-xl shadow-lg max-w-sm text-sm">
        <x-icon name="check" class="w-5 h-5 text-primary shrink-0" />
        <span>{{ session('success') }}</span>
        <button @click="show=false" class="ml-auto text-gray-400 hover:text-gray-600"><x-icon name="x-mark" class="w-4 h-4" /></button>
    </div>
@endif
@if(session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-end="opacity-0 -translate-y-2"
         class="fixed top-20 right-4 z-50 flex items-center gap-3 bg-white border-l-4 border-red-500 text-gray-800 px-4 py-3 rounded-xl shadow-lg max-w-sm text-sm">
        <x-icon name="x-circle" class="w-5 h-5 text-red-500 shrink-0" />
        <span>{{ session('error') }}</span>
        <button @click="show=false" class="ml-auto text-gray-400 hover:text-gray-600"><x-icon name="x-mark" class="w-4 h-4" /></button>
    </div>
@endif
@if(session('info'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-end="opacity-0 -translate-y-2"
         class="fixed top-20 right-4 z-50 flex items-center gap-3 bg-white border-l-4 border-blue-500 text-gray-800 px-4 py-3 rounded-xl shadow-lg max-w-sm text-sm">
        <x-icon name="bell" class="w-5 h-5 text-blue-500 shrink-0" />
        <span>{{ session('info') }}</span>
        <button @click="show=false" class="ml-auto text-gray-400 hover:text-gray-600"><x-icon name="x-mark" class="w-4 h-4" /></button>
    </div>
@endif

{{-- Page content --}}
<main class="pt-16 min-h-screen">
    {{ $slot }}
</main>

{{-- Footer --}}
<footer class="bg-white border-t border-field mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            <div>
                <x-logo variant="dark" size="sm" />
                <p class="mt-3 text-sm text-gray-500 leading-relaxed max-w-xs">
                    Platform reservasi lapangan olahraga. Temukan, pesan, dan bermain.
                </p>
            </div>
            <div>
                <p class="label mb-3">Layanan</p>
                <ul class="space-y-2">
                    <li><a href="{{ route('fields.index') }}" class="text-sm text-gray-500 hover:text-primary transition-colors">Cari Lapangan</a></li>
                    @auth
                        <li><a href="{{ route('bookings.index') }}" class="text-sm text-gray-500 hover:text-primary transition-colors">Pemesanan Saya</a></li>
                    @else
                        <li><a href="{{ route('register') }}" class="text-sm text-gray-500 hover:text-primary transition-colors">Daftar Gratis</a></li>
                    @endauth
                </ul>
            </div>
            <div>
                <p class="label mb-3">Untuk Owner</p>
                <ul class="space-y-2">
                    <li><a href="{{ route('register') }}" class="text-sm text-gray-500 hover:text-primary transition-colors">Daftarkan Lapangan</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-field pt-6 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-xs text-gray-400">&copy; {{ date('Y') }} GOALIN. All rights reserved.</p>
            <p class="text-xs text-gray-400">Bangun dengan semangat untuk pecinta olahraga.</p>
        </div>
    </div>
</footer>

</body>
</html>
