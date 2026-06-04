<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'GOALIN') }}@isset($title) — {{ $title }}@endisset</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700;800&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,700;1,9..40,400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased">

{{-- 2-column auth layout --}}
<div class="min-h-screen grid grid-cols-1 lg:grid-cols-[60%_40%]">

    {{-- Left panel: Forest green with texture --}}
    <div class="hidden lg:flex flex-col justify-between bg-[#0D3B2E] texture-field p-14 relative overflow-hidden">
        {{-- Logo --}}
        <a href="{{ route('landing') }}">
            <img src="{{ asset('images/logo.png') }}" alt="GOALIN" class="h-9 w-auto brightness-0 invert">
        </a>

        {{-- Center content --}}
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.15em] text-[#C6FF00] mb-4">PLATFORM BOOKING #1</p>
            <h1 class="font-display text-[64px] font-extrabold uppercase leading-[64px] tracking-[-0.01em] text-white mb-6">
                BOOKING<br>LAPANGAN<br><span class="text-[#C6FF00]">LEBIH MUDAH.</span>
            </h1>
            <p class="text-base text-[rgba(245,245,240,0.65)] leading-relaxed max-w-sm">
                Temukan, pesan, dan mainkan. Platform terlengkap untuk reservasi fasilitas olahraga di Indonesia.
            </p>
        </div>

        {{-- Bottom stats --}}
        <div class="flex items-center gap-8 border-t border-[rgba(255,255,255,0.1)] pt-8">
            <div>
                <p class="font-display text-3xl font-extrabold text-white">50+</p>
                <p class="text-xs text-[rgba(245,245,240,0.5)] uppercase tracking-widest mt-0.5">Lapangan</p>
            </div>
            <div class="w-px h-8 bg-[rgba(255,255,255,0.1)]"></div>
            <div>
                <p class="font-display text-3xl font-extrabold text-white">1K+</p>
                <p class="text-xs text-[rgba(245,245,240,0.5)] uppercase tracking-widest mt-0.5">Booking</p>
            </div>
            <div class="w-px h-8 bg-[rgba(255,255,255,0.1)]"></div>
            <div>
                <p class="font-display text-3xl font-extrabold text-white">10+</p>
                <p class="text-xs text-[rgba(245,245,240,0.5)] uppercase tracking-widest mt-0.5">Kota</p>
            </div>
        </div>
    </div>

    {{-- Right panel: Off-white form --}}
    <div class="flex flex-col justify-between min-h-screen bg-[#F5F5F0] px-8 sm:px-14 py-12">
        {{-- Mobile logo --}}
        <div class="lg:hidden mb-10">
            <a href="{{ route('landing') }}">
                <img src="{{ asset('images/logo.png') }}" alt="GOALIN" class="h-8 w-auto">
            </a>
        </div>

        {{-- Form area --}}
        <div class="w-full max-w-md mx-auto my-auto">
            {{ $slot }}
        </div>

        {{-- Footer link --}}
        <div class="text-center mt-8">
            <a href="{{ route('landing') }}" class="text-xs text-[#717974] hover:text-[#1A1A1A] transition-colors uppercase tracking-[0.05em] font-bold">
                ← Kembali ke Beranda
            </a>
        </div>
    </div>
</div>

</body>
</html>
