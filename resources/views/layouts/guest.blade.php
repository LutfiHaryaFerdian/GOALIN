<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'GOALIN') }}@isset($title) — {{ $title }}@endisset</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full bg-[#f8f8f6] font-sans antialiased">

{{-- Back link --}}
<div class="absolute top-0 left-0 right-0 z-10 flex items-center justify-between px-6 pt-6">
    <a href="{{ route('landing') }}" class="flex items-center gap-1">
        <span class="font-display text-lg font-bold uppercase tracking-tight text-[#0a0a0a]">GOALIN</span>
        <span class="w-1.5 h-1.5 rounded-full bg-[#16a34a] mb-2"></span>
    </a>
    <a href="{{ route('landing') }}" class="flex items-center gap-1.5 text-xs text-[#737373] hover:text-[#0a0a0a] transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
        </svg>
        Beranda
    </a>
</div>

{{-- Centered card --}}
<div class="min-h-screen flex items-center justify-center py-24 px-4">
    <div class="w-full max-w-md">
        {{-- Card --}}
        <div class="bg-white rounded-3xl border border-[#e5e5e5] p-8 md:p-10">
            {{ $slot }}
        </div>
    </div>
</div>

</body>
</html>
