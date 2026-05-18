<x-app-layout>
    <x-slot name="title">Cari Lapangan Olahraga</x-slot>

    <!-- Hero Section -->
    <section class="relative py-20 px-4 overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-emerald-500/8 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-teal-500/8 rounded-full blur-3xl"></div>
        </div>
        <div class="max-w-7xl mx-auto text-center relative">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 leading-tight">
                Temukan <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-400">Lapangan</span><br>
                Olahraga Terbaik
            </h1>
            <p class="text-gray-400 text-lg mb-10 max-w-xl mx-auto">Pesan lapangan olahraga favoritmu dengan mudah, cepat, dan terpercaya.</p>

            <!-- Search Form -->
            <form method="GET" action="{{ route('fields.index') }}" class="flex flex-col sm:flex-row gap-3 max-w-3xl mx-auto">
                <div class="flex-1 relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama lapangan..."
                        class="w-full pl-10 pr-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500/50 transition-all">
                </div>
                <select name="category" class="px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all min-w-[140px]">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>
                            {{ $cat->icon }} {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                <select name="city" class="px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all min-w-[140px]">
                    <option value="">Semua Kota</option>
                    @foreach($cities as $city)
                        <option value="{{ $city }}" {{ request('city') === $city ? 'selected' : '' }}>{{ $city }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 text-white rounded-xl font-medium text-sm transition-all shadow-lg shadow-emerald-500/20 whitespace-nowrap">
                    Cari
                </button>
            </form>
        </div>
    </section>

    <!-- Field Listings -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">

        <!-- Active Filters -->
        @if(request('search') || request('category') || request('city'))
            <div class="flex flex-wrap items-center gap-2 mb-6">
                <span class="text-sm text-gray-500">Filter aktif:</span>
                @if(request('search'))
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-500/10 border border-emerald-500/20 rounded-full text-xs text-emerald-400">
                        "{{ request('search') }}"
                        <a href="{{ request()->fullUrlWithoutQuery(['search']) }}" class="hover:text-white">×</a>
                    </span>
                @endif
                @if(request('category'))
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-500/10 border border-emerald-500/20 rounded-full text-xs text-emerald-400">
                        {{ $categories->firstWhere('slug', request('category'))?->name }}
                        <a href="{{ request()->fullUrlWithoutQuery(['category']) }}" class="hover:text-white">×</a>
                    </span>
                @endif
                @if(request('city'))
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-500/10 border border-emerald-500/20 rounded-full text-xs text-emerald-400">
                        {{ request('city') }}
                        <a href="{{ request()->fullUrlWithoutQuery(['city']) }}" class="hover:text-white">×</a>
                    </span>
                @endif
                <a href="{{ route('fields.index') }}" class="text-xs text-gray-500 hover:text-gray-300 underline">Reset semua</a>
            </div>
        @endif

        <!-- Results count -->
        <p class="text-sm text-gray-500 mb-6">
            Menampilkan <span class="text-white font-medium">{{ $fields->total() }}</span> lapangan
        </p>

        @if($fields->isEmpty())
            <div class="text-center py-24">
                <div class="text-6xl mb-4">🏟️</div>
                <h3 class="text-xl font-semibold text-white mb-2">Lapangan tidak ditemukan</h3>
                <p class="text-gray-500 mb-6">Coba ubah filter pencarian Anda</p>
                <a href="{{ route('fields.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 hover:bg-emerald-500/20 transition-colors text-sm">
                    Lihat Semua Lapangan
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($fields as $field)
                    <a href="{{ route('fields.show', $field->slug) }}" class="group block bg-gray-900/60 border border-white/5 rounded-2xl overflow-hidden hover:border-emerald-500/30 hover:bg-gray-900/80 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-emerald-500/10">
                        <!-- Image -->
                        <div class="relative h-48 bg-gradient-to-br from-gray-800 to-gray-900 overflow-hidden">
                            @if($field->first_image)
                                <img src="{{ Storage::url($field->first_image) }}" alt="{{ $field->name }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center">
                                    <span class="text-5xl mb-2">{{ $field->category->icon ?? '🏟️' }}</span>
                                    <span class="text-xs text-gray-600">{{ $field->category->name }}</span>
                                </div>
                            @endif
                            <!-- Category Badge -->
                            <div class="absolute top-3 left-3">
                                <span class="px-2.5 py-1 bg-black/60 backdrop-blur-sm rounded-full text-xs text-gray-300 border border-white/10">
                                    {{ $field->category->icon ?? '' }} {{ $field->category->name }}
                                </span>
                            </div>
                            <!-- Price Badge -->
                            <div class="absolute top-3 right-3">
                                <span class="px-2.5 py-1 bg-emerald-500/90 backdrop-blur-sm rounded-full text-xs text-white font-semibold">
                                    Rp {{ number_format($field->price_per_hour, 0, ',', '.') }}/jam
                                </span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-5">
                            <h3 class="font-semibold text-white text-base mb-1 group-hover:text-emerald-400 transition-colors line-clamp-1">{{ $field->name }}</h3>
                            <div class="flex items-center gap-1 text-gray-500 text-xs mb-3">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ $field->location->city }}, {{ $field->location->province }}
                            </div>
                            <p class="text-xs text-gray-500 line-clamp-2 mb-4">{{ $field->description }}</p>

                            <!-- Facilities -->
                            @if($field->facilities)
                                <div class="flex flex-wrap gap-1.5 mb-4">
                                    @foreach(array_slice($field->facilities, 0, 3) as $facility)
                                        <span class="px-2 py-0.5 bg-white/5 rounded-full text-[10px] text-gray-400 capitalize">{{ $facility }}</span>
                                    @endforeach
                                    @if(count($field->facilities) > 3)
                                        <span class="px-2 py-0.5 bg-white/5 rounded-full text-[10px] text-gray-500">+{{ count($field->facilities) - 3 }} lainnya</span>
                                    @endif
                                </div>
                            @endif

                            <!-- Rating & Reviews -->
                            <div class="flex items-center justify-between pt-3 border-t border-white/5">
                                <div class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                    <span class="text-xs text-gray-400">{{ $field->average_rating > 0 ? number_format($field->average_rating, 1) : 'Baru' }}</span>
                                    @if($field->reviews->count() > 0)
                                        <span class="text-xs text-gray-600">({{ $field->reviews->count() }})</span>
                                    @endif
                                </div>
                                <span class="text-xs text-emerald-400 font-medium group-hover:underline">Lihat Detail →</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($fields->hasPages())
                <div class="mt-10 flex justify-center">
                    {{ $fields->links() }}
                </div>
            @endif
        @endif
    </section>
</x-app-layout>
