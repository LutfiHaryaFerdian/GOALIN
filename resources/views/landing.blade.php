<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GOALIN — Pesan Lapangan Olahraga</title>
    <meta name="description" content="Platform booking lapangan olahraga terbaik. Temukan dan pesan lapangan futsal, basket, badminton, dan lebih banyak di kotamu.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white font-sans antialiased" x-data>

{{-- ─── NAVBAR ─────────────────────────────────────────────────────── --}}
<header class="sticky top-0 z-50 bg-white border-b border-[#e5e5e5]" x-data="{ mobileOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <a href="{{ route('landing') }}" class="flex items-center gap-1">
                <span class="font-display text-2xl font-bold uppercase tracking-tight text-[#3C3C3C]">GOALIN</span>
                <span class="w-1.5 h-1.5 rounded-full bg-[#58CC02] mb-3"></span>
            </a>
            <nav class="hidden md:flex items-center gap-8">
                <a href="{{ route('fields.index') }}" class="text-sm font-bold text-[#777777] hover:text-[#3C3C3C] transition-colors">Lapangan</a>
                @auth
                    <a href="{{ route('bookings.index') }}" class="text-sm font-bold text-[#777777] hover:text-[#3C3C3C] transition-colors">Pemesanan</a>
                    @if(auth()->user()->isOwner())
                        <a href="{{ route('owner.dashboard') }}" class="text-sm font-bold text-[#777777] hover:text-[#3C3C3C] transition-colors">Dashboard</a>
                    @endif
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-[#777777] hover:text-[#3C3C3C] transition-colors">Admin</a>
                    @endif
                @endauth
            </nav>
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('fields.index') }}" class="btn-primary text-sm px-5 py-2.5">Cari Lapangan</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-bold text-[#777777] hover:text-[#3C3C3C] transition-colors hidden sm:block">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-dark text-xs px-5 py-2.5">Daftar Gratis</a>
                @endauth
                <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 text-[#777777] hover:text-[#3C3C3C] rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <div x-show="mobileOpen" x-transition class="md:hidden border-t border-[#e5e5e5] bg-white px-4 py-3 space-y-1">
        <a href="{{ route('fields.index') }}" class="block px-3 py-2.5 text-sm font-bold text-[#3C3C3C] hover:bg-[#F7F7F7] rounded-xl">Lapangan</a>
        @auth
            <a href="{{ route('bookings.index') }}" class="block px-3 py-2.5 text-sm font-bold text-[#3C3C3C] hover:bg-[#F7F7F7] rounded-xl">Pemesanan</a>
        @else
            <a href="{{ route('login') }}" class="block px-3 py-2.5 text-sm font-bold text-[#3C3C3C] hover:bg-[#F7F7F7] rounded-xl">Masuk</a>
            <a href="{{ route('register') }}" class="block px-3 py-2.5 text-sm font-bold text-center text-[#3C3C3C] bg-[#F7F7F7] rounded-xl">Daftar Gratis</a>
        @endauth
    </div>
</header>

{{-- ─── SECTION 1: HERO ───────────────────────────────────────────── --}}
<section class="bg-white min-h-[90vh] flex flex-col justify-center relative overflow-hidden pitch-lines">
    {{-- Subtle pitch texture overlay --}}
    <div class="absolute inset-0 pitch-lines opacity-40 pointer-events-none"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        <div class="lg:col-span-8">
            {{-- Section eyebrow --}}
            <p class="section-label mb-6">PLATFORM BOOKING LAPANGAN #1</p>

            {{-- Headline --}}
            <h1 class="font-display text-[4.5rem] sm:text-[6rem] md:text-[8rem] lg:text-[10rem] font-black uppercase leading-none tracking-tighter text-[#3c3c3c] max-w-4xl">
                BOOK YOUR<br>
                <span class="relative inline-block">
                    FIELD.
                    <span class="absolute -bottom-2 left-0 right-0 h-2 md:h-3 bg-[#58cc02] rounded-full"></span>
                </span>
            </h1>

            {{-- Sub --}}
            <p class="mt-10 text-lg text-[#777777] max-w-md leading-relaxed">
                Temukan dan pesan lapangan olahraga favoritmu dalam hitungan detik.
            </p>

            {{-- CTA --}}
            <div class="flex flex-wrap items-center gap-4 mt-8">
                <a href="{{ route('fields.index') }}" class="btn-primary px-8 py-4 text-base">
                    Cari Lapangan
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
                <a href="#cara-kerja" class="btn-ghost text-base">
                    Cara Kerja
                </a>
            </div>

            {{-- Stat bar --}}
            <div class="flex flex-wrap items-center gap-8 mt-16 pt-8 border-t border-[#e5e5e5]">
                <div>
                    <p class="font-display text-3xl font-bold text-[#3c3c3c]">{{ $totalFields }}+</p>
                    <p class="text-xs text-[#777777] uppercase tracking-widest mt-0.5">Lapangan</p>
                </div>
                <div class="w-px h-8 bg-[#e5e5e5]"></div>
                <div>
                    <p class="font-display text-3xl font-bold text-[#3c3c3c]">{{ $totalCities }}</p>
                    <p class="text-xs text-[#777777] uppercase tracking-widest mt-0.5">Kota</p>
                </div>
                <div class="w-px h-8 bg-[#e5e5e5]"></div>
                <div>
                    <p class="font-display text-3xl font-bold text-[#3c3c3c]">{{ $totalBookings }}+</p>
                    <p class="text-xs text-[#777777] uppercase tracking-widest mt-0.5">Booking</p>
                </div>
            </div>
        </div>

        {{-- Mascot --}}
        <div class="lg:col-span-4 flex justify-center lg:justify-end animate-bounce" style="animation-duration: 3.5s;">
            <x-sporty-mascot class="w-72 h-72 md:w-[22rem] md:h-[22rem] hover:scale-105 transition-transform duration-300" />
        </div>
    </div>
</section>

{{-- ─── SECTION 2: KATEGORI ───────────────────────────────────────── --}}
@if($categories->count() > 0)
<section class="bg-[#F7F7F7] py-20 md:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="section-label mb-2">JENIS LAPANGAN</p>
        <h2 class="font-display text-3xl md:text-4xl font-bold uppercase text-[#3C3C3C] mb-10">Semua Olahraga,<br>Satu Platform.</h2>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('fields.index') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 border-2 border-[#E5E5E5] rounded-full text-sm font-bold text-[#3C3C3C] bg-white hover:bg-[#3C3C3C] hover:text-white hover:border-[#3C3C3C] transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z"/>
                </svg>
                Semua
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('fields.index', ['category' => $cat->slug]) }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 border-2 border-[#E5E5E5] rounded-full text-sm font-bold text-[#3C3C3C] bg-white hover:bg-[#3C3C3C] hover:text-white hover:border-[#3C3C3C] transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418"/>
                    </svg>
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ─── SECTION 3: LAPANGAN UNGGULAN ─────────────────────────────── --}}
<section class="bg-white py-20 md:py-28">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-12">
            <div>
                <p class="section-label mb-2">LAPANGAN TERSEDIA</p>
                <h2 class="font-display text-3xl md:text-5xl font-bold uppercase text-[#3C3C3C] leading-tight">
                    Temukan lapangan<br>di kotamu.
                </h2>
            </div>
            <a href="{{ route('fields.index') }}" class="hidden sm:flex items-center gap-2 text-sm font-bold text-[#3C3C3C] hover:text-[#58CC02] transition-colors">
                Lihat Semua
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                </svg>
            </a>
        </div>

        @if($featuredFields->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($featuredFields as $field)
                    <a href="{{ route('fields.show', $field->slug) }}"
                       class="group bg-white rounded-2xl overflow-hidden border-2 border-[#E5E5E5] hover:border-[#3C3C3C] transition-colors duration-300 cursor-pointer block" style="box-shadow: 0 4px 0 #E5E5E5;">
                        <div class="aspect-[4/3] overflow-hidden bg-[#f5f5f5]">
                            @if($field->first_image)
                                <img src="{{ Storage::url($field->first_image) }}"
                                     alt="{{ $field->name }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-[#d4d4d4]" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-5">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-bold uppercase tracking-widest text-[#777777]">{{ $field->category->name }}</span>
                                <span class="text-xs font-bold text-[#58CC02]">Tersedia</span>
                            </div>
                            <h3 class="text-base font-bold text-[#3C3C3C] leading-tight line-clamp-1">{{ $field->name }}</h3>
                            <p class="text-sm text-[#777777] mt-1">{{ $field->location->city }}</p>
                            <div class="flex items-center justify-between mt-4 pt-4 border-t border-[#f5f5f5]">
                                <span class="text-base font-bold text-[#3C3C3C]">
                                    Rp{{ number_format($field->price_per_hour, 0, ',', '.') }}<span class="text-xs font-normal text-[#777777]">/jam</span>
                                </span>
                                <span class="text-xs font-bold text-[#3C3C3C] underline underline-offset-2 group-hover:text-[#58CC02] transition-colors">Pesan →</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-20 border border-[#e5e5e5] rounded-2xl">
                <p class="font-display text-4xl font-bold uppercase text-[#e5e5e5]">BELUM ADA LAPANGAN</p>
                <p class="text-sm text-[#737373] mt-2">Lapangan akan segera tersedia.</p>
            </div>
        @endif

        <div class="sm:hidden text-center mt-8">
            <a href="{{ route('fields.index') }}" class="btn-secondary">Lihat Semua Lapangan</a>
        </div>
    </div>
</section>

{{-- ─── SECTION 4: CARA KERJA ─────────────────────────────────────── --}}
<section id="cara-kerja" class="bg-[#F7F7F7] py-20 md:py-28">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="section-label mb-2">CARA KERJA</p>
        <h2 class="font-display text-3xl md:text-5xl font-bold uppercase text-[#3C3C3C] leading-tight mb-16">
            3 langkah.<br>Lapangan siap.
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach([
                ['01', 'Cari', 'Temukan lapangan berdasarkan jenis dan lokasi.'],
                ['02', 'Pilih Waktu', 'Cek ketersediaan slot secara real-time.'],
                ['03', 'Pesan', 'Konfirmasi dan bayar dalam satu langkah.'],
            ] as [$num, $title, $desc])
                <div class="relative">
                    <p class="font-display text-8xl font-black text-[#f0f0f0] leading-none select-none mb-2">{{ $num }}</p>
                    <h3 class="font-display text-2xl font-bold uppercase text-[#3C3C3C] -mt-8">{{ $title }}</h3>
                    <p class="text-sm text-[#777777] mt-2 leading-relaxed max-w-xs">{{ $desc }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ─── SECTION 5: STATS (DARK) ───────────────────────────────────── --}}
<section class="bg-[#3C3C3C] py-20 md:py-28">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 md:gap-0 divide-y md:divide-y-0 md:divide-x divide-white/10">
            @foreach([
                [$totalFields . '+', 'Lapangan Aktif'],
                [$totalCities, 'Kota di Indonesia'],
                [$totalBookings . '+', 'Booking Berhasil'],
            ] as [$val, $label])
                <div class="md:px-12 first:pl-0 last:pr-0 py-8 md:py-0">
                    <p class="font-display text-6xl md:text-8xl font-black text-white leading-none">{{ $val }}</p>
                    <p class="text-sm uppercase tracking-widest text-[#777777] mt-3">{{ $label }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ─── SECTION 6: CTA BOTTOM ─────────────────────────────────────── --}}
<section class="bg-white py-24 md:py-32">
    <div class="max-w-2xl mx-auto px-4 text-center">
        <p class="section-label mb-4 text-center">BERGABUNG SEKARANG</p>
        <h2 class="font-display text-5xl md:text-7xl font-black uppercase text-[#3C3C3C] leading-none mb-6">
            SIAP BERMAIN?
        </h2>
        <p class="text-[#777777] text-base mb-10">
            Daftar gratis dan mulai pesan lapangan sekarang.
        </p>
        <div class="flex flex-wrap items-center justify-center gap-4">
            @guest
                <a href="{{ route('register') }}" class="btn-dark px-8 py-4 text-base">
                    Daftar Sekarang
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
                <a href="{{ route('login') }}" class="btn-secondary px-8 py-4 text-base">Masuk</a>
            @else
                <a href="{{ route('fields.index') }}" class="btn-dark px-8 py-4 text-base">
                    Cari Lapangan
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            @endguest
        </div>
    </div>
</section>

{{-- ─── FOOTER ─────────────────────────────────────────────────────── --}}
<footer class="bg-white border-t border-[#e5e5e5]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-1">
                    <span class="font-display text-xl font-bold uppercase tracking-tight text-[#3C3C3C]">GOALIN</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-[#58CC02] mb-2"></span>
                </div>
                <span class="text-xs text-[#a3a3a3]">Platform booking lapangan olahraga</span>
            </div>
            <div class="flex items-center gap-6">
                <a href="{{ route('fields.index') }}" class="text-xs text-[#777777] hover:text-[#3C3C3C] transition-colors">Lapangan</a>
                <a href="{{ route('register') }}" class="text-xs text-[#777777] hover:text-[#3C3C3C] transition-colors">Daftar</a>
            </div>
            <p class="text-xs text-[#a3a3a3]">&copy; {{ date('Y') }} GOALIN.</p>
        </div>
    </div>
</footer>

</body>
</html>
