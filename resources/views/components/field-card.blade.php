@props(['field'])

<a href="{{ route('fields.show', $field->slug) }}"
   class="group bg-white rounded-2xl overflow-hidden border border-[#e5e5e5] hover:border-[#0a0a0a] transition-colors duration-300 block">

    {{-- Image --}}
    <div class="aspect-[4/3] overflow-hidden bg-[#f5f5f5] relative">
        @if($field->first_image)
            <img src="{{ Storage::url($field->first_image) }}"
                 alt="{{ $field->name }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        @else
            <div class="w-full h-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-[#d4d4d4]" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
                </svg>
            </div>
        @endif
    </div>

    {{-- Body --}}
    <div class="p-5">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-semibold uppercase tracking-widest text-[#737373]">{{ $field->category->name }}</span>
            <span class="text-xs font-semibold text-[#16a34a]">Tersedia</span>
        </div>
        <h3 class="text-base font-bold text-[#0a0a0a] leading-tight line-clamp-1">{{ $field->name }}</h3>
        <p class="text-sm text-[#737373] mt-1">{{ $field->location->city }}</p>
        <div class="flex items-center justify-between mt-4 pt-4 border-t border-[#f5f5f5]">
            <span class="text-base font-bold text-[#0a0a0a]">
                Rp{{ number_format($field->price_per_hour, 0, ',', '.') }}<span class="text-xs font-normal text-[#737373]">/jam</span>
            </span>
            <span class="text-xs font-semibold text-[#0a0a0a] underline underline-offset-2 group-hover:text-[#16a34a] transition-colors">Pesan →</span>
        </div>
    </div>
</a>
