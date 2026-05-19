<x-app-layout>
    <x-slot name="title">Cari Lapangan</x-slot>

    {{-- ── Filter Hero ── --}}
    <div class="bg-primary border-b border-primary-dark">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <h1 class="text-2xl font-extrabold text-white mb-1">Cari Lapangan Olahraga</h1>
            <p class="text-white/60 text-sm mb-6">Temukan lapangan terbaik di kotamu</p>

            <form method="GET" action="{{ route('fields.index') }}"
                  class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                {{-- Search --}}
                <div class="lg:col-span-2 flex items-center gap-3 bg-white/10 border border-white/20 rounded-xl px-4 py-2.5 focus-within:ring-2 focus-within:ring-white/40">
                    <x-icon name="search" class="w-4 h-4 text-white/50 shrink-0" />
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari nama lapangan..."
                           class="flex-1 bg-transparent text-sm text-white placeholder-white/40 outline-none">
                </div>

                {{-- Category --}}
                <select name="category"
                        class="bg-white/10 border border-white/20 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-white/40 appearance-none">
                    <option value="" class="text-gray-900">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->slug }}" class="text-gray-900"
                            {{ request('category') === $cat->slug ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>

                {{-- City --}}
                <select name="city"
                        class="bg-white/10 border border-white/20 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-white/40 appearance-none">
                    <option value="" class="text-gray-900">Semua Kota</option>
                    @foreach($cities as $city)
                        <option value="{{ $city }}" class="text-gray-900"
                            {{ request('city') === $city ? 'selected' : '' }}>{{ $city }}</option>
                    @endforeach
                </select>

                <button type="submit"
                        class="sm:col-span-2 lg:col-span-4 w-full btn-primary justify-center py-2.5 bg-white text-primary hover:bg-primary-light">
                    <x-icon name="search" class="w-4 h-4" />
                    Cari Lapangan
                </button>
            </form>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Active filters --}}
        @if(request('search') || request('category') || request('city'))
            <div class="flex flex-wrap items-center gap-2 mb-6 p-3 bg-primary-light rounded-xl border border-field">
                <span class="text-xs font-semibold text-primary">Filter:</span>
                @if(request('search'))
                    <span class="flex items-center gap-1 text-xs bg-white border border-field rounded-full px-3 py-1 text-gray-700">
                        "{{ request('search') }}"
                        <a href="{{ request()->fullUrlWithoutQuery(['search']) }}" class="text-gray-400 hover:text-red-500 ml-1">
                            <x-icon name="x-mark" class="w-3 h-3" />
                        </a>
                    </span>
                @endif
                @if(request('category'))
                    <span class="flex items-center gap-1 text-xs bg-white border border-field rounded-full px-3 py-1 text-gray-700">
                        {{ $categories->firstWhere('slug', request('category'))?->name }}
                        <a href="{{ request()->fullUrlWithoutQuery(['category']) }}" class="text-gray-400 hover:text-red-500 ml-1">
                            <x-icon name="x-mark" class="w-3 h-3" />
                        </a>
                    </span>
                @endif
                @if(request('city'))
                    <span class="flex items-center gap-1 text-xs bg-white border border-field rounded-full px-3 py-1 text-gray-700">
                        {{ request('city') }}
                        <a href="{{ request()->fullUrlWithoutQuery(['city']) }}" class="text-gray-400 hover:text-red-500 ml-1">
                            <x-icon name="x-mark" class="w-3 h-3" />
                        </a>
                    </span>
                @endif
                <a href="{{ route('fields.index') }}" class="text-xs text-red-500 hover:underline ml-auto">Reset semua</a>
            </div>
        @endif

        {{-- Results header --}}
        <div class="flex items-center justify-between mb-6">
            <p class="text-sm text-gray-500">
                <span class="font-semibold text-gray-900">{{ $fields->total() }}</span> lapangan ditemukan
            </p>
        </div>

        {{-- Grid --}}
        @if($fields->isEmpty())
            <div class="text-center py-24 bg-white rounded-2xl border border-field">
                <div class="w-16 h-16 bg-primary-light rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <x-icon name="search" class="w-8 h-8 text-primary" />
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Lapangan tidak ditemukan</h3>
                <p class="text-gray-500 text-sm mb-6">Coba ubah filter pencarian Anda</p>
                <a href="{{ route('fields.index') }}" class="btn-secondary">Lihat Semua Lapangan</a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($fields as $field)
                    <x-field-card :field="$field" />
                @endforeach
            </div>

            @if($fields->hasPages())
                <div class="mt-10">
                    {{ $fields->links() }}
                </div>
            @endif
        @endif
    </div>
</x-app-layout>
