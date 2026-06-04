<x-app-layout>
    <x-slot name="title">Cari Lapangan</x-slot>

    {{-- Header dark --}}
    <div class="bg-[#0D3B2E] texture-field">
        <div class="max-w-[1280px] mx-auto px-5 md:px-12 py-16">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#C6FF00] mb-4">TEMUKAN LAPANGAN</p>
            <h1 class="font-display font-extrabold uppercase leading-none text-white mb-10" style="font-size:clamp(40px,5vw,64px)">CARI LAPANGAN.</h1>

            {{-- Filter bar --}}
            <form method="GET" action="{{ route('fields.index') }}"
                  class="flex flex-col sm:flex-row gap-0 border border-white/20 bg-white/10 backdrop-blur-sm max-w-3xl">
                <div class="flex-1 flex items-center gap-3 border-b sm:border-b-0 sm:border-r border-white/20 px-5 py-3.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white/50 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari nama lapangan..."
                           class="flex-1 bg-transparent text-sm font-medium text-white placeholder-white/50 outline-none border-0">
                </div>
                <select name="category" class="bg-transparent border-b sm:border-b-0 sm:border-r border-white/20 px-5 py-3.5 text-sm font-bold text-white uppercase tracking-[0.05em] focus:outline-none appearance-none cursor-pointer">
                    <option value="" class="text-[#1A1A1A]">SEMUA JENIS</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->slug }}" {{ request('category')===$cat->slug ? 'selected' : '' }} class="text-[#1A1A1A]">{{ strtoupper($cat->name) }}</option>
                    @endforeach
                </select>
                <select name="city" class="bg-transparent border-b sm:border-b-0 sm:border-r border-white/20 px-5 py-3.5 text-sm font-bold text-white uppercase tracking-[0.05em] focus:outline-none appearance-none cursor-pointer">
                    <option value="" class="text-[#1A1A1A]">SEMUA KOTA</option>
                    @foreach($cities as $city)
                        <option value="{{ $city }}" {{ request('city')===$city ? 'selected' : '' }} class="text-[#1A1A1A]">{{ strtoupper($city) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-[#C6FF00] text-[#1A1A1A] text-sm font-bold uppercase tracking-[0.05em] px-8 py-3.5 hover:bg-[#b8f000] transition-colors whitespace-nowrap">
                    CARI
                </button>
            </form>
        </div>
    </div>

    <div class="max-w-[1280px] mx-auto px-5 md:px-12 py-12">

        {{-- Active filters --}}
        @if(request('search') || request('category') || request('city'))
            <div class="flex flex-wrap items-center gap-2 mb-8 pb-6 border-b border-[rgba(26,26,26,0.1)]">
                <span class="text-xs font-bold uppercase tracking-[0.1em] text-[#717974]">FILTER AKTIF:</span>
                @if(request('search'))
                    <span class="flex items-center gap-1.5 text-xs font-bold bg-[#1A1A1A] text-[#F5F5F0] px-3 py-1">
                        "{{ request('search') }}"
                        <a href="{{ request()->fullUrlWithoutQuery(['search']) }}" class="text-[#C6FF00] hover:text-white transition-colors ml-1">✕</a>
                    </span>
                @endif
                @if(request('category'))
                    <span class="flex items-center gap-1.5 text-xs font-bold bg-[#1A1A1A] text-[#F5F5F0] px-3 py-1">
                        {{ strtoupper($categories->firstWhere('slug', request('category'))?->name ?? '') }}
                        <a href="{{ request()->fullUrlWithoutQuery(['category']) }}" class="text-[#C6FF00] hover:text-white transition-colors ml-1">✕</a>
                    </span>
                @endif
                @if(request('city'))
                    <span class="flex items-center gap-1.5 text-xs font-bold bg-[#1A1A1A] text-[#F5F5F0] px-3 py-1">
                        {{ strtoupper(request('city')) }}
                        <a href="{{ request()->fullUrlWithoutQuery(['city']) }}" class="text-[#C6FF00] hover:text-white transition-colors ml-1">✕</a>
                    </span>
                @endif
                <a href="{{ route('fields.index') }}" class="text-xs font-bold uppercase tracking-[0.05em] text-[#BA1A1A] hover:underline underline-offset-2 ml-auto">RESET</a>
            </div>
        @endif

        {{-- Count --}}
        <div class="flex items-center justify-between mb-8">
            <p class="text-sm text-[#717974]">
                <span class="font-bold text-[#1A1A1A]">{{ $fields->total() }}</span> lapangan ditemukan
            </p>
        </div>

        {{-- Grid --}}
        @if($fields->isEmpty())
            <div class="text-center py-32 border border-[rgba(26,26,26,0.1)]">
                <p class="font-display font-extrabold uppercase text-[rgba(26,26,26,0.07)]" style="font-size:clamp(48px,6vw,80px)">TIDAK ADA LAPANGAN</p>
                <p class="text-[#717974] text-sm mt-3 mb-8">Coba ubah filter pencarian.</p>
                <a href="{{ route('fields.index') }}" class="btn-forest">LIHAT SEMUA</a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-0 border border-[rgba(26,26,26,0.1)]">
                @foreach($fields as $field)
                    <a href="{{ route('fields.show', $field->slug) }}"
                       class="group bg-white border-r border-b border-[rgba(26,26,26,0.1)] cursor-pointer block">
                        <div class="aspect-[4/3] overflow-hidden bg-[#1A1A1A]">
                            @if($field->first_image)
                                <img src="{{ Storage::url($field->first_image) }}" alt="{{ $field->name }}"
                                     class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-105 transition-all duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-white/20" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
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

            @if($fields->hasPages())
                <div class="mt-10 flex items-center justify-center gap-1">
                    {{-- Pagination styled flat --}}
                    {{ $fields->onEachSide(1)->links() }}
                </div>
            @endif
        @endif
    </div>
</x-app-layout>
