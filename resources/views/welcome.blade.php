<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GOALIN — Pesan Lapangan Olahraga Terbaik</title>
    <meta name="description" content="Temukan dan pesan lapangan olahraga terbaik di kotamu. Futsal, basket, badminton, tenis, dan lebih banyak lagi.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white">

{{-- ═══════ NAVBAR ═══════ --}}
<header class="fixed top-0 inset-x-0 z-50 bg-primary border-b border-primary-dark" x-data="{ mobileOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between gap-6">
            <a href="/" class="shrink-0"><x-logo variant="light" size="sm" /></a>
            <nav class="hidden md:flex items-center gap-1">
                <a href="#fields" class="px-3 py-2 text-sm font-medium text-white/80 hover:text-white transition-colors">Lapangan</a>
                <a href="#features" class="px-3 py-2 text-sm font-medium text-white/80 hover:text-white transition-colors">Fitur</a>
                <a href="#how" class="px-3 py-2 text-sm font-medium text-white/80 hover:text-white transition-colors">Cara Kerja</a>
            </nav>
            <div class="flex items-center gap-2">
                <a href="{{ route('login') }}" class="text-sm font-medium text-white/80 hover:text-white px-3 py-2 transition-colors">Masuk</a>
                <a href="{{ route('register') }}" class="text-sm font-semibold bg-white text-primary px-4 py-2 rounded-lg hover:bg-primary-light transition-colors">Daftar Gratis</a>
                <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 text-white/70 hover:text-white rounded-lg hover:bg-white/10">
                    <x-icon name="menu" class="w-5 h-5" x-show="!mobileOpen" />
                    <x-icon name="x-mark" class="w-5 h-5" x-show="mobileOpen" x-cloak />
                </button>
            </div>
        </div>
    </div>
    <div x-show="mobileOpen" x-cloak class="md:hidden border-t border-primary-dark bg-primary px-4 py-3 space-y-1">
        <a href="#fields" class="block px-3 py-2 text-sm text-white/80 hover:text-white rounded-lg hover:bg-white/10">Lapangan</a>
        <a href="#features" class="block px-3 py-2 text-sm text-white/80 hover:text-white rounded-lg hover:bg-white/10">Fitur</a>
        <a href="{{ route('login') }}" class="block px-3 py-2 text-sm text-white/80 hover:text-white rounded-lg hover:bg-white/10">Masuk</a>
        <a href="{{ route('register') }}" class="block px-3 py-2 text-sm font-semibold text-white bg-white/10 rounded-lg">Daftar Gratis</a>
    </div>
</header>

{{-- ═══════ HERO ═══════ --}}
<section class="relative min-h-screen flex items-center pitch-bg overflow-hidden pt-16">
    {{-- Vignette overlay --}}
    <div class="absolute inset-0 bg-gradient-to-b from-primary/60 via-primary/30 to-primary/80 pointer-events-none"></div>
    {{-- Right image fade --}}
    <div class="absolute right-0 top-0 bottom-0 w-1/2 bg-gradient-to-l from-primary/80 to-transparent pointer-events-none hidden lg:block"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
        <div class="max-w-3xl">
            <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-full text-white/80 text-xs font-semibold tracking-wide border border-white/20 mb-6">
                <x-icon name="field" class="w-4 h-4" />
                Platform Reservasi Lapangan Olahraga #1
            </span>

            <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold text-white leading-[1.05] tracking-tight text-balance mb-6">
                Pesan Lapangan.<br>
                <span class="text-white/60">Main Sekarang.</span>
            </h1>

            <p class="text-lg text-white/70 leading-relaxed max-w-xl mb-10">
                Temukan lapangan futsal, basket, badminton, dan olahraga lainnya di kotamu.
                Cek jadwal real-time, pesan dalam hitungan detik.
            </p>

            {{-- Search bar --}}
            <div class="bg-white rounded-2xl shadow-2xl p-2 flex flex-col sm:flex-row gap-2 max-w-2xl">
                <div class="flex-1 flex items-center gap-3 px-4 py-2 bg-gray-50 rounded-xl">
                    <x-icon name="search" class="w-5 h-5 text-gray-400 shrink-0" />
                    <form method="GET" action="{{ route('fields.index') }}" class="flex-1 flex items-center">
                        <input type="text" name="search" placeholder="Cari nama lapangan atau kota..."
                               class="flex-1 bg-transparent text-sm text-gray-700 placeholder-gray-400 outline-none">
                        <button type="submit" class="btn-primary ml-2 py-2.5 px-5 whitespace-nowrap">
                            <x-icon name="search" class="w-4 h-4" />
                            Cari
                        </button>
                    </form>
                </div>
            </div>

            {{-- Quick links --}}
            <div class="flex flex-wrap items-center gap-3 mt-6 text-sm text-white/60">
                <span>Populer:</span>
                @foreach(['futsal', 'basket', 'badminton', 'tenis'] as $cat)
                    <a href="{{ route('fields.index', ['category' => $cat]) }}"
                       class="px-3 py-1 bg-white/10 hover:bg-white/20 border border-white/20 rounded-full transition-colors text-white/80 hover:text-white capitalize">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Scroll cue --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-white/40 text-xs">
        <span>Gulir ke bawah</span>
        <div class="w-px h-8 bg-white/20 animate-pulse"></div>
    </div>
</section>

{{-- ═══════ STATS STRIP ═══════ --}}
<section class="bg-white border-b border-field">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            @foreach([['50+', 'Lapangan Terdaftar'],['5', 'Kota Tersedia'],['100+', 'Booking Per Hari'],['4.8', 'Rating Rata-rata']] as [$num, $label])
                <div>
                    <p class="text-4xl font-extrabold text-primary">{{ $num }}</p>
                    <p class="mt-1 text-sm text-gray-500">{{ $label }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════ FEATURES ═══════ --}}
<section id="features" class="py-24 bg-accent">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <p class="section-label">Kenapa GOALIN?</p>
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900">Semua yang Anda butuhkan</h2>
            <p class="mt-3 text-gray-500 max-w-xl mx-auto">Platform lengkap untuk menemukan dan memesan lapangan olahraga dengan cepat dan mudah.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach([
                ['search',    'Cari Lapangan',           'Temukan lapangan terbaik berdasarkan lokasi, kategori, dan harga. Filter canggih untuk hasil akurat.'],
                ['calendar',  'Jadwal Real-Time',        'Lihat ketersediaan slot secara langsung. Tidak ada double-booking — sistem kami menjamin itu.'],
                ['clipboard', 'Konfirmasi Instan',       'Pesan dalam hitungan detik. Dapatkan kode booking langsung di email dan notifikasi Anda.'],
            ] as [$icon, $title, $desc])
                <div class="card p-8 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-primary-light rounded-xl flex items-center justify-center mb-5">
                        <x-icon name="{{ $icon }}" class="w-6 h-6 text-primary" />
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $title }}</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">{{ $desc }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════ HOW IT WORKS ═══════ --}}
<section id="how" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <p class="section-label">Cara Kerja</p>
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900">Tiga langkah mudah</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 relative">
            {{-- Connecting line --}}
            <div class="hidden md:block absolute top-8 left-1/6 right-1/6 h-px bg-field"></div>

            @foreach([
                ['01', 'search',    'Temukan Lapangan',  'Gunakan filter lokasi, jenis olahraga, dan tanggal untuk menemukan lapangan yang cocok.'],
                ['02', 'calendar',  'Pilih Jadwal',      'Lihat slot waktu yang tersedia dan pilih waktu yang paling pas untuk Anda.'],
                ['03', 'clipboard', 'Konfirmasi Booking','Isi detail pemesanan dan dapatkan konfirmasi instan. Selesai — siap bermain!'],
            ] as [$step, $icon, $title, $desc])
                <div class="flex flex-col items-center text-center relative">
                    <div class="w-16 h-16 bg-primary rounded-2xl flex items-center justify-center mb-5 shadow-lg shadow-primary/20 relative z-10">
                        <x-icon name="{{ $icon }}" class="w-8 h-8 text-white" />
                    </div>
                    <span class="text-xs font-bold text-primary tracking-widest mb-2">LANGKAH {{ $step }}</span>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $title }}</h3>
                    <p class="text-sm text-gray-500 leading-relaxed max-w-xs">{{ $desc }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════ FIELD PREVIEW ═══════ --}}
<section id="fields" class="py-24 bg-accent">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-10">
            <div>
                <p class="section-label">Lapangan Pilihan</p>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900">Tersedia hari ini</h2>
            </div>
            <a href="{{ route('fields.index') }}" class="btn-secondary hidden sm:inline-flex">
                Lihat Semua <x-icon name="chevron-right" class="w-4 h-4" />
            </a>
        </div>

        @php
            $fields = \App\Models\Field::with(['category', 'location', 'reviews'])
                ->where('status', 'active')->latest()->take(3)->get();
        @endphp

        @if($fields->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($fields as $field)
                    <x-field-card :field="$field" />
                @endforeach
            </div>
        @endif

        <div class="mt-8 text-center sm:hidden">
            <a href="{{ route('fields.index') }}" class="btn-secondary">
                Lihat Semua Lapangan <x-icon name="chevron-right" class="w-4 h-4" />
            </a>
        </div>
    </div>
</section>

{{-- ═══════ CTA BANNER ═══════ --}}
<section class="bg-primary py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-4">Siap untuk bermain?</h2>
        <p class="text-white/70 text-lg mb-8">Bergabung dengan ribuan pemain yang sudah mempercayai GOALIN.</p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('register') }}"
               class="bg-white text-primary font-bold px-8 py-3.5 rounded-xl hover:bg-primary-light transition-colors text-sm inline-flex items-center gap-2 shadow-lg">
                <x-icon name="plus" class="w-4 h-4" />
                Daftar Sekarang — Gratis
            </a>
            <a href="{{ route('fields.index') }}"
               class="border border-white/30 text-white font-semibold px-8 py-3.5 rounded-xl hover:bg-white/10 transition-colors text-sm inline-flex items-center gap-2">
                Jelajahi Lapangan <x-icon name="chevron-right" class="w-4 h-4" />
            </a>
        </div>
    </div>
</section>

{{-- ═══════ FOOTER ═══════ --}}
<footer class="bg-white border-t border-field">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <x-logo variant="dark" size="sm" />
            <p class="text-xs text-gray-400">&copy; {{ date('Y') }} GOALIN. All rights reserved.</p>
        </div>
    </div>
</footer>

</body>
</html>
