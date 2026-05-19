@props(['variant' => 'light', 'size' => 'sm'])

@php
    $isLight = $variant === 'light';
    $markColor  = $isLight ? '#ffffff' : '#1a7a3c';
    $textColor  = $isLight ? 'text-white' : 'text-primary';
    $sizes = ['sm' => ['ball' => 28, 'text' => 'text-xl'], 'lg' => ['ball' => 72, 'text' => 'text-5xl']];
    $s = $sizes[$size] ?? $sizes['sm'];
@endphp

<div class="flex items-center gap-2.5 select-none">
    {{-- Soccer ball SVG mark --}}
    <svg width="{{ $s['ball'] }}" height="{{ $s['ball'] }}" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        {{-- Outer circle --}}
        <circle cx="20" cy="20" r="19" stroke="{{ $markColor }}" stroke-width="1.8"/>
        {{-- Center pentagon (top) --}}
        <polygon points="20,7 24.8,11.5 23,17 17,17 15.2,11.5" fill="{{ $markColor }}" opacity=".9"/>
        {{-- Pentagon bottom-right --}}
        <polygon points="30,15.5 33.5,22 29.5,27.5 24.5,26 23,20" fill="{{ $markColor }}" opacity=".9"/>
        {{-- Pentagon bottom-left --}}
        <polygon points="10,15.5 17,20 15.5,26 10.5,27.5 6.5,22" fill="{{ $markColor }}" opacity=".9"/>
        {{-- Pentagon bottom-center-right --}}
        <polygon points="26.5,31 23,35.5 17,35.5 13.5,31 17,26.5 23,26.5" fill="{{ $markColor }}" opacity=".9"/>
        {{-- Connecting lines --}}
        <line x1="20" y1="7" x2="20" y2="1" stroke="{{ $markColor }}" stroke-width="1.4" opacity=".5"/>
        <line x1="33.5" y1="22" x2="38.5" y2="19" stroke="{{ $markColor }}" stroke-width="1.4" opacity=".5"/>
        <line x1="6.5" y1="22" x2="1.5" y2="19" stroke="{{ $markColor }}" stroke-width="1.4" opacity=".5"/>
        <line x1="26.5" y1="31" x2="30" y2="36" stroke="{{ $markColor }}" stroke-width="1.4" opacity=".5"/>
        <line x1="13.5" y1="31" x2="10" y2="36" stroke="{{ $markColor }}" stroke-width="1.4" opacity=".5"/>
    </svg>

    {{-- Wordmark --}}
    <span class="{{ $s['text'] }} font-extrabold tracking-[0.08em] {{ $textColor }}" style="letter-spacing:0.08em">GOALIN</span>
</div>
