<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GOALIN — Platform Booking Lapangan Olahraga #1</title>
    <meta name="description" content="Platform terlengkap untuk reservasi fasilitas olahraga. Temukan dan pesan lapangan futsal, basket, badminton di kotamu.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700;800&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,700;1,9..40,400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F5F5F0] font-sans antialiased" x-data>

{{-- ─── NAVBAR ─────────────────────────────── --}}
<header class="sticky top-0 z-50 bg-[#F5F5F0] border-b border-[rgba(26,26,26,0.1)]" x-data="{ mobileOpen: false }">
    <div class="max-w-[1280px] mx-auto px-5 md:px-12 flex h-16 items-center justify-between">
        <a href="{{ route('landing') }}" class="shrink-0">
            <img src="{{ asset('images/logo.png') }}" alt="GOALIN" class="h-8 w-auto">
        </a>
        <nav class="hidden md:flex items-center gap-8">
            <a href="{{ route('fields.index') }}" class="text-sm font-bold uppercase tracking-[0.05em] text-[#1A1A1A] hover:text-[#0D3B2E] transition-colors">LAPANGAN</a>
            @auth
                <a href="{{ route('bookings.index') }}" class="text-sm font-bold uppercase tracking-[0.05em] text-[#1A1A1A] hover:text-[#0D3B2E] transition-colors">PEMESANAN</a>
                @if(auth()->user()->isOwner())
                    <a href="{{ route('owner.dashboard') }}" class="text-sm font-bold uppercase tracking-[0.05em] text-[#1A1A1A] hover:text-[#0D3B2E] transition-colors">DASHBOARD</a>
                @endif
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold uppercase tracking-[0.05em] text-[#1A1A1A] hover:text-[#0D3B2E] transition-colors">ADMIN</a>
                @endif
            @endauth
        </nav>
        <div class="hidden md:flex items-center gap-3">
            @auth
                <a href="{{ route('fields.index') }}" class="btn-primary py-2.5 px-5 text-xs">CARI LAPANGAN</a>
            @else
                <a href="{{ route('login') }}" class="text-sm font-bold uppercase tracking-[0.05em] text-[#1A1A1A] hover:text-[#0D3B2E] transition-colors">LOG IN</a>
                <a href="{{ route('register') }}" class="btn-primary py-2.5 px-5 text-xs">MULAI BOOKING</a>
            @endauth
        </div>
        <button @click="mobileOpen = true" class="md:hidden p-2 text-[#1A1A1A]">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
            </svg>
        </button>
    </div>
    {{-- Mobile overlay --}}
    <div x-show="mobileOpen" x-cloak
         class="fixed inset-0 z-[100] bg-[#0D3B2E] texture-field flex flex-col p-8">
        <div class="flex items-center justify-between mb-12">
            <img src="{{ asset('images/logo.png') }}" alt="GOALIN" class="h-7 brightness-0 invert">
            <button @click="mobileOpen = false" class="text-[#C6FF00]">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <nav class="flex flex-col gap-5">
            <a @click="mobileOpen=false" href="{{ route('fields.index') }}" class="font-display text-5xl font-extrabold uppercase text-[#F5F5F0] hover:text-[#C6FF00] transition-colors">LAPANGAN</a>
            @auth
                <a @click="mobileOpen=false" href="{{ route('bookings.index') }}" class="font-display text-5xl font-extrabold uppercase text-[#F5F5F0] hover:text-[#C6FF00] transition-colors">PEMESANAN</a>
            @else
                <a @click="mobileOpen=false" href="{{ route('login') }}" class="font-display text-5xl font-extrabold uppercase text-[#F5F5F0] hover:text-[#C6FF00] transition-colors">LOG IN</a>
                <a @click="mobileOpen=false" href="{{ route('register') }}" class="font-display text-5xl font-extrabold uppercase text-[#C6FF00]">DAFTAR</a>
            @endauth
        </nav>
    </div>
</header>

{{-- ─── SECTION 1: HERO ─────────────────────── --}}
<section class="relative min-h-[92vh] flex flex-col justify-center overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
         style="background-image: url('{{ asset('images/hero-field.png') }}')"></div>
    <div class="absolute inset-0 bg-[#0D3B2E]/75"></div>
    <div class="relative max-w-[1280px] mx-auto px-5 md:px-12 py-24 md:py-32">
        <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#C6FF00] mb-6">PLATFORM BOOKING LAPANGAN #1</p>
        <h1 class="font-display font-extrabold uppercase leading-none tracking-[-0.02em] text-white mb-6"
            style="font-size:clamp(52px,8vw,96px); line-height:1;">
            BOOKING LAPANGAN<br><span class="text-[#C6FF00]">LEBIH MUDAH.</span>
        </h1>
        <p class="text-base md:text-lg text-[rgba(255,255,255,0.7)] max-w-lg leading-relaxed mb-10">
            Platform terlengkap untuk reservasi fasilitas olahraga. Real-time, tanpa antri, langsung main.
        </p>
        <div class="flex flex-wrap items-center gap-4 mb-16">
            <a href="{{ route('fields.index') }}" class="btn-primary px-8 py-4 text-base">CARI LAPANGAN →</a>
            <a href="{{ route('register') }}" class="btn-ghost-white px-8 py-4 text-base">DAFTAR GRATIS</a>
        </div>
        {{-- Quick search bar --}}
        <form method="GET" action="{{ route('fields.index') }}"
              class="flex flex-col sm:flex-row gap-0 bg-white/10 border border-white/20 backdrop-blur-sm max-w-3xl">
            <select name="category"
                    class="flex-1 bg-transparent border-0 border-r border-white/20 px-5 py-4 text-sm font-bold text-white uppercase tracking-[0.05em] focus:outline-none appearance-none cursor-pointer">
                <option value="" class="text-[#1A1A1A]">SEMUA JENIS</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}" class="text-[#1A1A1A]">{{ strtoupper($cat->name) }}</option>
                @endforeach
            </select>
            <select name="city"
                    class="flex-1 bg-transparent border-0 border-r border-white/20 px-5 py-4 text-sm font-bold text-white uppercase tracking-[0.05em] focus:outline-none appearance-none cursor-pointer">
                <option value="" class="text-[#1A1A1A]">SEMUA KOTA</option>
                @foreach(\App\Models\Location::select('city')->distinct()->orderBy('city')->pluck('city') as $city)
                    <option value="{{ $city }}" class="text-[#1A1A1A]">{{ strtoupper($city) }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-[#C6FF00] text-[#1A1A1A] text-sm font-bold uppercase tracking-[0.05em] px-8 py-4 hover:bg-[#b8f000] transition-colors whitespace-nowrap">
                CEK JADWAL
            </button>
        </form>
    </div>
</section>

{{-- ─── SECTION 2: STATS STRIP ──────────────── --}}
<section class="bg-[#F5F5F0] border-b border-[rgba(26,26,26,0.1)]">
    <div class="max-w-[1280px] mx-auto px-5 md:px-12">
        <div class="grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-[rgba(26,26,26,0.1)]">
            @foreach([
                [$totalFields . '+', 'LAPANGAN TERVERIFIKASI'],
                [$totalBookings . '+', 'BOOKING BERHASIL'],
                [$totalCities, 'KOTA DI INDONESIA'],
            ] as [$val, $label])
                <div class="px-8 py-10 md:py-12">
                    <p class="font-display font-extrabold uppercase leading-none text-[#0D3B2E]" style="font-size:clamp(40px,5vw,60px)">{{ $val }}</p>
                    <p class="text-xs font-bold uppercase tracking-[0.15em] text-[#717974] mt-2">{{ $label }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ─── SECTION 3: CARA KERJA ───────────────── --}}
<section id="cara-kerja" class="bg-[#F5F5F0] py-24 md:py-32">
    <div class="max-w-[1280px] mx-auto px-5 md:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
            <div>
                <p class="section-label mb-4">PROSES CEPAT</p>
                <h2 class="font-display font-extrabold uppercase leading-none text-[#1A1A1A] mb-6" style="font-size:clamp(40px,5vw,56px)">SEMUDAH<br>1-2-3.</h2>
                <p class="text-base text-[#717974] leading-relaxed max-w-sm">
                    Dari pencarian hingga konfirmasi, selesaikan dalam hitungan menit — tanpa telepon, tanpa antri.
                </p>
            </div>
            <div class="space-y-0">
                @foreach([
                    ['01', 'CARI LAPANGAN', 'Temukan lapangan berdasarkan jenis olahraga dan lokasi yang kamu inginkan.'],
                    ['02', 'PILIH WAKTU', 'Cek ketersediaan slot secara real-time dan pilih jam yang sesuai jadwalmu.'],
                    ['03', 'PESAN & MAIN', 'Konfirmasi pemesanan dan bayar dalam satu langkah. Lapangan siap untukmu.'],
                ] as [$num, $title, $desc])
                    <div class="group flex gap-6 p-6 hover:border-l-2 hover:border-[#C6FF00] hover:pl-5 transition-all border-b border-[rgba(26,26,26,0.08)] last:border-b-0">
                        <p class="font-display font-extrabold text-[80px] leading-none text-[rgba(26,26,26,0.06)] select-none shrink-0 w-20 -mt-3">{{ $num }}</p>
                        <div>
                            <h3 class="font-display font-bold uppercase text-[22px] text-[#1A1A1A] leading-tight mb-2">{{ $title }}</h3>
                            <p class="text-sm text-[#717974] leading-relaxed">{{ $desc }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ─── SECTION 4: LAPANGAN UNGGULAN ─────────── --}}
<section class="bg-[#F5F5F0] py-24">
    <div class="max-w-[1280px] mx-auto px-5 md:px-12">
        <div class="flex items-end justify-between mb-12">
            <div>
                <p class="section-label mb-3">LAPANGAN TERSEDIA</p>
                <h2 class="font-display font-extrabold uppercase leading-none text-[#1A1A1A]" style="font-size:clamp(36px,4vw,48px)">TEMUKAN LAPANGAN<br>DI KOTAMU.</h2>
            </div>
            <a href="{{ route('fields.index') }}" class="hidden sm:flex items-center gap-2 text-sm font-bold uppercase tracking-[0.05em] text-[#1A1A1A] hover:text-[#0D3B2E] transition-colors">
                LIHAT SEMUA →
            </a>
        </div>
        @if($featuredFields->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-0 border border-[rgba(26,26,26,0.1)]">
                @foreach($featuredFields as $field)
                    <a href="{{ route('fields.show', $field->slug) }}"
                       class="group bg-white border-r border-b border-[rgba(26,26,26,0.1)] cursor-pointer block last:border-r-0 even:last:border-r-0">
                        <div class="aspect-[4/3] overflow-hidden bg-[#1A1A1A]">
                            @if($field->first_image)
                                <img src="{{ Storage::url($field->first_image) }}" alt="{{ $field->name }}"
                                     class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-105 transition-all duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-[#1A1A1A]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-[rgba(255,255,255,0.2)]" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-6 border-t border-[rgba(26,26,26,0.1)]">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs font-bold uppercase tracking-[0.05em] text-[#717974]">{{ $field->category->name }}</span>
                                <span class="text-xs font-bold uppercase tracking-[0.05em] bg-[#C6FF00] text-[#1A1A1A] px-2 py-0.5">TERSEDIA</span>
                            </div>
                            <h3 class="font-display text-xl font-bold uppercase leading-tight text-[#1A1A1A]">{{ $field->name }}</h3>
                            <p class="text-sm text-[#717974] mt-1">{{ $field->location->city }}</p>
                            <div class="flex items-center justify-between mt-4 pt-4 border-t border-[rgba(26,26,26,0.1)]">
                                <span class="font-bold text-[#1A1A1A]">Rp{{ number_format($field->price_per_hour,0,',','.') }}<span class="text-xs font-normal text-[#717974]">/jam</span></span>
                                <span class="text-xs font-bold uppercase tracking-wide text-[#1A1A1A]">PESAN →</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-24 border border-[rgba(26,26,26,0.1)]">
                <p class="font-display text-5xl font-extrabold uppercase text-[rgba(26,26,26,0.08)]">BELUM ADA LAPANGAN</p>
                <p class="text-sm text-[#717974] mt-3">Lapangan akan segera tersedia.</p>
            </div>
        @endif
    </div>
</section>

{{-- ─── SECTION 5: KATEGORI (dark) ─────────────── --}}
@if($categories->count() > 0)
<section class="bg-[#0D3B2E] texture-field py-24 md:py-32">
    <div class="max-w-[1280px] mx-auto px-5 md:px-12">
        <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#C6FF00] mb-4">JENIS LAPANGAN</p>
        <h2 class="font-display font-extrabold uppercase leading-none text-white mb-12" style="font-size:clamp(40px,5vw,72px)">SEMUA JENIS<br>LAPANGAN.</h2>
        <div class="flex flex-wrap gap-3">
            @foreach($categories as $cat)
                @php $count = \App\Models\Field::whereHas('category', fn($q) => $q->where('id', $cat->id))->count(); @endphp
                <a href="{{ route('fields.index', ['category' => $cat->slug]) }}"
                   class="group flex items-center gap-4 bg-white/10 hover:bg-[#C6FF00] border border-white/20 hover:border-[#C6FF00] px-6 py-4 transition-colors duration-200">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.15em] text-[#C6FF00] group-hover:text-[#0D3B2E] transition-colors">{{ $count }} LAPANGAN</p>
                        <h3 class="font-display text-2xl font-extrabold uppercase text-white group-hover:text-[#0D3B2E] leading-tight transition-colors">{{ $cat->name }}</h3>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white/40 group-hover:text-[#0D3B2E] shrink-0 ml-2 transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ─── SECTION 6: FITUR ────────────────────── --}}
<section class="bg-[#F5F5F0] py-24 md:py-32">
    <div class="max-w-[1280px] mx-auto px-5 md:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div>
                <p class="section-label mb-4">TEKNOLOGI PINTAR</p>
                <h2 class="font-display font-extrabold uppercase leading-none text-[#0D3B2E] mb-10" style="font-size:clamp(36px,4vw,52px)">MANAJEMEN<br>TANPA KENDALA.</h2>
                <div class="space-y-0">
                    @foreach([
                        ['Real-time Booking', 'Slot tersedia diperbarui secara instan. Tidak ada double booking.'],
                        ['Notifikasi Otomatis', 'Konfirmasi dan pengingat dikirim langsung via email.'],
                        ['Dashboard Mudah', 'Kelola lapangan, jadwal, dan pemesanan dari satu tempat.'],
                        ['Pembayaran Aman', 'Integrasi Midtrans — QRIS, transfer, kartu kredit.'],
                    ] as [$title, $desc])
                        <div class="flex gap-5 p-6 border-b border-[rgba(26,26,26,0.08)] last:border-b-0 hover:border-l-2 hover:border-[#C6FF00] hover:pl-5 transition-all">
                            <div class="w-1 bg-[#C6FF00] shrink-0 self-stretch"></div>
                            <div>
                                <p class="text-sm font-bold uppercase tracking-[0.05em] text-[#1A1A1A] mb-1">{{ $title }}</p>
                                <p class="text-sm text-[#717974]">{{ $desc }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="bg-[#0D3B2E] texture-field p-12 flex flex-col justify-center min-h-[420px]">
                <p class="font-display text-7xl font-extrabold uppercase leading-none text-[#C6FF00] mb-4">0<br>DOUBLE<br>BOOKING.</p>
                <p class="text-sm text-[rgba(245,245,240,0.6)] leading-relaxed">Sistem kami memastikan setiap slot hanya bisa dipesan satu kali. Aman dan terpercaya.</p>
            </div>
        </div>
    </div>
</section>

{{-- ─── SECTION 7: CTA BOTTOM ───────────────── --}}
<section class="bg-[#C6FF00] py-24 md:py-32">
    <div class="max-w-[1280px] mx-auto px-5 md:px-12 text-center">
        <p class="text-xs font-bold uppercase tracking-[0.2em] text-[rgba(26,26,26,0.5)] mb-4">BERGABUNG SEKARANG</p>
        <h2 class="font-display font-extrabold uppercase leading-none text-[#0D3B2E] mb-8" style="font-size:clamp(48px,6vw,80px)">SIAP BOOKING<br>LAPANGAN SEKARANG?</h2>
        @guest
            <a href="{{ route('register') }}" class="btn-forest px-10 py-5 text-base">DAFTAR GRATIS SEKARANG →</a>
        @else
            <a href="{{ route('fields.index') }}" class="btn-forest px-10 py-5 text-base">CARI LAPANGAN SEKARANG →</a>
        @endguest
    </div>
</section>

{{-- ─── FOOTER ──────────────────────────────── --}}
<footer class="bg-[#0D3B2E] texture-field">
    <div class="max-w-[1280px] mx-auto px-5 md:px-12 py-16">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
            <div class="md:col-span-2">
                <img src="{{ asset('images/logo.png') }}" alt="GOALIN" class="h-8 w-auto brightness-0 invert mb-4">
                <p class="text-sm text-[rgba(245,245,240,0.6)] leading-relaxed max-w-xs">Platform terlengkap untuk reservasi fasilitas olahraga di Indonesia.</p>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.15em] text-[rgba(245,245,240,0.4)] mb-4">NAVIGASI</p>
                <div class="flex flex-col gap-3">
                    <a href="{{ route('fields.index') }}" class="text-sm text-[rgba(245,245,240,0.7)] hover:text-[#C6FF00] transition-colors">Lapangan</a>
                    <a href="{{ route('register') }}" class="text-sm text-[rgba(245,245,240,0.7)] hover:text-[#C6FF00] transition-colors">Daftar Gratis</a>
                    <a href="{{ route('login') }}" class="text-sm text-[rgba(245,245,240,0.7)] hover:text-[#C6FF00] transition-colors">Masuk</a>
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

</body>
</html>
