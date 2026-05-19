@props(['field'])

<a href="{{ route('fields.show', $field->slug) }}"
   class="card group flex flex-col overflow-hidden hover:shadow-md transition-shadow duration-300">

    {{-- Image --}}
    <div class="aspect-video bg-accent overflow-hidden relative">
        @if($field->first_image)
            <img src="{{ Storage::url($field->first_image) }}"
                 alt="{{ $field->name }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        @else
            <div class="w-full h-full flex items-center justify-center bg-primary-light">
                <x-icon name="field" class="w-12 h-12 text-primary opacity-40" />
            </div>
        @endif
        {{-- Price badge --}}
        <div class="absolute bottom-3 right-3">
            <span class="bg-white/95 backdrop-blur-sm text-primary font-bold text-sm px-3 py-1 rounded-lg shadow-sm">
                Rp {{ number_format($field->price_per_hour, 0, ',', '.') }}<span class="font-normal text-gray-500">/jam</span>
            </span>
        </div>
    </div>

    {{-- Body --}}
    <div class="p-5 flex flex-col flex-1">
        {{-- Category --}}
        <span class="text-xs font-semibold text-primary uppercase tracking-wide mb-1">
            {{ $field->category->name }}
        </span>

        {{-- Name --}}
        <h3 class="text-base font-bold text-gray-900 mb-2 group-hover:text-primary transition-colors line-clamp-1">
            {{ $field->name }}
        </h3>

        {{-- Location --}}
        <p class="flex items-center gap-1.5 text-sm text-gray-500 mb-4">
            <x-icon name="map-pin" class="w-4 h-4 shrink-0" />
            {{ $field->location->city }}, {{ $field->location->province }}
        </p>

        {{-- Rating + CTA --}}
        <div class="flex items-center justify-between mt-auto pt-4 border-t border-field">
            <div class="flex items-center gap-1">
                <x-icon name="star" class="w-4 h-4 text-amber-400" />
                <span class="text-sm font-semibold text-gray-700">
                    {{ $field->average_rating > 0 ? number_format($field->average_rating, 1) : '—' }}
                </span>
                @if($field->reviews->count() > 0)
                    <span class="text-xs text-gray-400">({{ $field->reviews->count() }})</span>
                @endif
            </div>
            <span class="text-sm font-semibold text-primary flex items-center gap-1">
                Lihat Detail <x-icon name="chevron-right" class="w-4 h-4" />
            </span>
        </div>
    </div>
</a>
