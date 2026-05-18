<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'GOALIN') }} — {{ $title ?? 'Sports Field Booking' }}</title>
    <meta name="description" content="{{ $metaDescription ?? 'GOALIN — Temukan dan pesan lapangan olahraga terbaik di kotamu dengan mudah dan cepat.' }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800&family=inter:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-gray-950 text-white font-outfit antialiased">

    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-gray-950/80 backdrop-blur-md border-b border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                <!-- Logo -->
                <a href="{{ route('fields.index') }}" class="flex items-center gap-2 group">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-400 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-500/30 group-hover:shadow-emerald-500/50 transition-shadow">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9V8h2v8zm4 0h-2V8h2v8z"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold tracking-tight">
                        <span class="text-white">GOAL</span><span class="text-emerald-400">IN</span>
                    </span>
                </a>

                <!-- Desktop Nav -->
                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ route('fields.index') }}" class="text-sm text-gray-400 hover:text-white transition-colors {{ request()->routeIs('fields.*') ? 'text-white' : '' }}">
                        Cari Lapangan
                    </a>
                    @auth
                        @if(auth()->user()->isOwner())
                            <a href="{{ route('owner.dashboard') }}" class="text-sm text-gray-400 hover:text-white transition-colors {{ request()->routeIs('owner.*') ? 'text-white' : '' }}">
                                Dashboard Owner
                            </a>
                        @endif
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-400 hover:text-white transition-colors {{ request()->routeIs('admin.*') ? 'text-white' : '' }}">
                                Admin Panel
                            </a>
                        @endif
                        <a href="{{ route('bookings.index') }}" class="text-sm text-gray-400 hover:text-white transition-colors {{ request()->routeIs('bookings.*') ? 'text-white' : '' }}">
                            Pemesanan Saya
                        </a>
                    @endauth
                </div>

                <!-- Right side -->
                <div class="flex items-center gap-3">
                    @auth
                        <!-- Notification Bell -->
                        @php
                            $unreadCount = \App\Models\Notification::where('user_id', auth()->id())->whereNull('read_at')->count();
                        @endphp
                        <a href="{{ route('notifications.index') }}" class="relative p-2 text-gray-400 hover:text-white transition-colors" title="Notifikasi">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            @if($unreadCount > 0)
                                <span class="absolute top-1 right-1 w-4 h-4 bg-emerald-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center animate-pulse">
                                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                </span>
                            @endif
                        </a>

                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2 pl-2 pr-3 py-1.5 rounded-full bg-white/5 hover:bg-white/10 transition-colors border border-white/10">
                                <div class="w-6 h-6 rounded-full bg-gradient-to-br from-emerald-400 to-teal-600 flex items-center justify-center text-xs font-bold text-white overflow-hidden">
                                    @if(auth()->user()->avatar)
                                        <img src="{{ Storage::url(auth()->user()->avatar) }}" class="w-full h-full object-cover" alt="Avatar">
                                    @else
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    @endif
                                </div>
                                <span class="text-sm text-gray-300 hidden sm:block">{{ auth()->user()->name }}</span>
                                <svg class="w-3 h-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="open" @click.outside="open = false" x-transition
                                class="absolute right-0 mt-2 w-48 bg-gray-900 border border-white/10 rounded-xl shadow-xl shadow-black/50 overflow-hidden py-1">
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-white/5 transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    Profil Saya
                                </a>
                                <div class="border-t border-white/10 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-400 hover:text-red-300 hover:bg-white/5 transition-colors text-left">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-400 hover:text-white transition-colors">Masuk</a>
                        <a href="{{ route('register') }}" class="text-sm px-4 py-2 bg-emerald-500 hover:bg-emerald-400 text-white rounded-lg font-medium transition-colors shadow-lg shadow-emerald-500/20">
                            Daftar
                        </a>
                    @endauth

                    <!-- Mobile menu button -->
                    <button id="mobile-menu-btn" class="md:hidden p-2 text-gray-400 hover:text-white" x-data @click="$dispatch('toggle-mobile-menu')">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-data="{ open: false }" @toggle-mobile-menu.window="open = !open">
            <div x-show="open" x-transition class="md:hidden border-t border-white/5 bg-gray-950/95 px-4 py-4 space-y-2">
                <a href="{{ route('fields.index') }}" class="block text-sm text-gray-300 hover:text-white py-2">Cari Lapangan</a>
                @auth
                    <a href="{{ route('bookings.index') }}" class="block text-sm text-gray-300 hover:text-white py-2">Pemesanan Saya</a>
                    <a href="{{ route('notifications.index') }}" class="block text-sm text-gray-300 hover:text-white py-2">Notifikasi</a>
                    @if(auth()->user()->isOwner())
                        <a href="{{ route('owner.dashboard') }}" class="block text-sm text-gray-300 hover:text-white py-2">Dashboard Owner</a>
                    @endif
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="block text-sm text-gray-300 hover:text-white py-2">Admin Panel</a>
                    @endif
                    <div class="pt-2 border-t border-white/10">
                        <a href="{{ route('profile.edit') }}" class="block text-sm text-gray-300 hover:text-white py-2">Profil Saya</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="block text-sm text-red-400 hover:text-red-300 py-2">Keluar</button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="block text-sm text-gray-300 hover:text-white py-2">Masuk</a>
                    <a href="{{ route('register') }}" class="block text-sm text-emerald-400 hover:text-emerald-300 py-2 font-medium">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)"
            class="fixed top-20 right-4 z-50 flex items-center gap-3 px-4 py-3 bg-emerald-500/20 border border-emerald-500/30 rounded-xl backdrop-blur-sm max-w-sm">
            <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="text-sm text-emerald-300">{{ session('success') }}</p>
            <button @click="show = false" class="ml-auto text-emerald-400/60 hover:text-emerald-400">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    @endif
    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
            class="fixed top-20 right-4 z-50 flex items-center gap-3 px-4 py-3 bg-red-500/20 border border-red-500/30 rounded-xl backdrop-blur-sm max-w-sm">
            <svg class="w-5 h-5 text-red-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="text-sm text-red-300">{{ session('error') }}</p>
            <button @click="show = false" class="ml-auto text-red-400/60 hover:text-red-400">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    @endif

    <!-- Page Content -->
    <main class="pt-16">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="mt-20 border-t border-white/5 bg-gray-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-400 to-teal-600 flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9V8h2v8zm4 0h-2V8h2v8z"/></svg>
                        </div>
                        <span class="text-lg font-bold"><span class="text-white">GOAL</span><span class="text-emerald-400">IN</span></span>
                    </div>
                    <p class="text-sm text-gray-500 leading-relaxed">Platform pemesanan lapangan olahraga terpercaya. Temukan dan pesan lapangan terbaik di kotamu.</p>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-300 mb-3">Layanan</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('fields.index') }}" class="text-sm text-gray-500 hover:text-gray-300 transition-colors">Cari Lapangan</a></li>
                        @auth
                            <li><a href="{{ route('bookings.index') }}" class="text-sm text-gray-500 hover:text-gray-300 transition-colors">Pemesanan Saya</a></li>
                        @else
                            <li><a href="{{ route('register') }}" class="text-sm text-gray-500 hover:text-gray-300 transition-colors">Daftar Sekarang</a></li>
                        @endauth
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-300 mb-3">Untuk Owner</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('register') }}" class="text-sm text-gray-500 hover:text-gray-300 transition-colors">Daftarkan Lapangan</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 pt-6 border-t border-white/5 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-gray-600">&copy; {{ date('Y') }} GOALIN. All rights reserved.</p>
                <p class="text-xs text-gray-600">Made with ❤️ for sports lovers</p>
            </div>
        </div>
    </footer>

</body>
</html>
