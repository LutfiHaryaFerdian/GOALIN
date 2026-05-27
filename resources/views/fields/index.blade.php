<x-app-layout>
    <x-slot name="title">Cari Lapangan</x-slot>

    {{-- ── Header ── --}}
    <div class="bg-white border-b border-[#e5e5e5]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-8">
            <p class="section-label mb-2">TEMUKAN LAPANGAN</p>
            <h1 class="font-display text-4xl md:text-6xl font-black uppercase tracking-tight text-[#0a0a0a] mb-8">CARI LAPANGAN</h1>

            {{-- Filter bar --}}
            <form method="GET" action="{{ route('fields.index') }}"
                  class="flex flex-col sm:flex-row gap-3">
                {{-- Search --}}
                <div class="flex-1 flex items-center gap-3 bg-[#f8f8f6] border border-[#e5e5e5] rounded-full px-5 py-3 focus-within:border-[#0a0a0a] transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#a3a3a3] shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari nama lapangan..."
                           class="flex-1 bg-transparent text-sm text-[#0a0a0a] placeholder-[#a3a3a3] outline-none">
                </div>

                {{-- Category --}}
                <select name="category"
                        class="bg-[#f8f8f6] border border-[#e5e5e5] rounded-full px-5 py-3 text-sm text-[#404040] focus:outline-none focus:border-[#0a0a0a] transition-colors appearance-none">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>

                {{-- City --}}
                <select name="city"
                        class="bg-[#f8f8f6] border border-[#e5e5e5] rounded-full px-5 py-3 text-sm text-[#404040] focus:outline-none focus:border-[#0a0a0a] transition-colors appearance-none">
                    <option value="">Semua Kota</option>
                    @foreach($cities as $city)
                        <option value="{{ $city }}" {{ request('city') === $city ? 'selected' : '' }}>{{ $city }}</option>
                    @endforeach
                </select>

                <button type="submit" class="btn-dark whitespace-nowrap">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                    </svg>
                    Cari
                </button>
            </form>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Active filters --}}
        @if(request('search') || request('category') || request('city'))
            <div class="flex flex-wrap items-center gap-2 mb-8">
                <span class="text-xs font-semibold text-[#737373] uppercase tracking-wide">Filter aktif:</span>
                @if(request('search'))
                    <span class="flex items-center gap-1.5 text-xs bg-white border border-[#e5e5e5] rounded-full px-3 py-1.5 text-[#404040]">
                        "{{ request('search') }}"
                        <a href="{{ request()->fullUrlWithoutQuery(['search']) }}" class="text-[#a3a3a3] hover:text-[#dc2626] transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    </span>
                @endif
                @if(request('category'))
                    <span class="flex items-center gap-1.5 text-xs bg-white border border-[#e5e5e5] rounded-full px-3 py-1.5 text-[#404040]">
                        {{ $categories->firstWhere('slug', request('category'))?->name }}
                        <a href="{{ request()->fullUrlWithoutQuery(['category']) }}" class="text-[#a3a3a3] hover:text-[#dc2626] transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    </span>
                @endif
                @if(request('city'))
                    <span class="flex items-center gap-1.5 text-xs bg-white border border-[#e5e5e5] rounded-full px-3 py-1.5 text-[#404040]">
                        {{ request('city') }}
                        <a href="{{ request()->fullUrlWithoutQuery(['city']) }}" class="text-[#a3a3a3] hover:text-[#dc2626] transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    </span>
                @endif
                <a href="{{ route('fields.index') }}" class="text-xs text-[#dc2626] hover:underline underline-offset-2 ml-auto">Reset semua</a>
            </div>
        @endif

        {{-- Results count --}}
        <div class="flex items-center justify-between mb-6">
            <p class="text-sm text-[#737373]">
                <span class="font-semibold text-[#0a0a0a]">{{ $fields->total() }}</span> lapangan ditemukan
            </p>
        </div>

        {{-- Grid --}}
        @if($fields->isEmpty())
            <div class="text-center py-32">
                <p class="font-display text-6xl font-black uppercase text-[#f0f0f0]">KOSONG</p>
                <p class="text-[#737373] text-sm mt-4 mb-8">Lapangan tidak ditemukan. Coba ubah filter pencarian.</p>
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
