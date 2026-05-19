<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'GOALIN') }}@isset($title) — {{ $title }}@endisset</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-white font-sans antialiased">

<div class="min-h-screen flex">

    {{-- Left panel — green brand side --}}
    <div class="hidden lg:flex lg:w-5/12 xl:w-1/2 flex-col pitch-bg relative overflow-hidden">
        {{-- Pitch line overlay --}}
        <div class="absolute inset-0 bg-primary/40"></div>

        {{-- Center circle decoration --}}
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 border-2 border-white/15 rounded-full"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-4 h-4 bg-white/20 rounded-full"></div>
        {{-- Halfway line --}}
        <div class="absolute top-0 bottom-0 left-1/2 w-px bg-white/10"></div>
        {{-- Goal boxes --}}
        <div class="absolute top-1/2 -translate-y-1/2 left-0 w-24 h-40 border-2 border-white/15 border-l-0"></div>
        <div class="absolute top-1/2 -translate-y-1/2 right-0 w-24 h-40 border-2 border-white/15 border-r-0"></div>

        {{-- Content --}}
        <div class="relative z-10 flex flex-col h-full px-12 py-10">
            <div class="mb-auto">
                <x-logo variant="light" size="sm" />
            </div>
            <div class="mb-auto text-center">
                <x-logo variant="light" size="lg" />
                <p class="mt-6 text-white/70 text-lg font-medium leading-relaxed">
                    Platform reservasi lapangan olahraga.<br>Temukan, pesan, dan bermain.
                </p>
            </div>
            <p class="text-white/40 text-xs">&copy; {{ date('Y') }} GOALIN</p>
        </div>
    </div>

    {{-- Right panel — form --}}
    <div class="flex-1 flex flex-col justify-center py-12 px-6 sm:px-12 lg:px-16 xl:px-24">
        {{-- Mobile logo --}}
        <div class="lg:hidden mb-10 flex justify-center">
            <x-logo variant="dark" size="sm" />
        </div>

        <div class="mx-auto w-full max-w-sm">
            {{ $slot }}
        </div>
    </div>
</div>

</body>
</html>
