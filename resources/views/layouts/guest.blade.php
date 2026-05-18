<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'GOALIN') }} — {{ $title ?? 'Masuk & Daftar' }}</title>
    <meta name="description" content="Masuk atau daftar ke GOALIN untuk memesan lapangan olahraga favoritmu.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full bg-gray-950 font-outfit antialiased flex flex-col justify-center items-center relative overflow-hidden">

    <!-- Background decoration -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-emerald-600/5 rounded-full blur-2xl"></div>
    </div>

    <!-- Logo -->
    <div class="mb-8 text-center">
        <a href="{{ route('fields.index') }}" class="inline-flex items-center gap-2 group">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-400 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-500/30 group-hover:shadow-emerald-500/50 transition-shadow">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9V8h2v8zm4 0h-2V8h2v8z"/>
                </svg>
            </div>
            <span class="text-2xl font-bold tracking-tight">
                <span class="text-white">GOAL</span><span class="text-emerald-400">IN</span>
            </span>
        </a>
        <p class="mt-2 text-sm text-gray-500">Platform Pemesanan Lapangan Olahraga</p>
    </div>

    <!-- Card -->
    <div class="w-full max-w-md mx-auto px-4">
        <div class="bg-gray-900/80 backdrop-blur-md border border-white/10 rounded-2xl p-8 shadow-2xl shadow-black/50">
            {{ $slot }}
        </div>
    </div>

    <p class="mt-8 text-xs text-gray-600">&copy; {{ date('Y') }} GOALIN. All rights reserved.</p>

</body>
</html>
