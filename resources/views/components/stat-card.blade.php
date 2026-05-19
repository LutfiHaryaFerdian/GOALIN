@props(['label', 'value', 'icon' => 'field', 'color' => 'green', 'sub' => null])

@php
$colors = [
    'green'  => ['bg' => 'bg-primary-light', 'text' => 'text-primary',  'icon' => 'text-primary'],
    'yellow' => ['bg' => 'bg-amber-50',       'text' => 'text-amber-600','icon' => 'text-amber-500'],
    'red'    => ['bg' => 'bg-red-50',         'text' => 'text-red-600',  'icon' => 'text-red-500'],
    'blue'   => ['bg' => 'bg-blue-50',        'text' => 'text-blue-600', 'icon' => 'text-blue-500'],
    'gray'   => ['bg' => 'bg-gray-50',        'text' => 'text-gray-600', 'icon' => 'text-gray-500'],
];
$c = $colors[$color] ?? $colors['green'];
@endphp

<div class="card p-6">
    <div class="flex items-start justify-between">
        <div>
            <p class="label">{{ $label }}</p>
            <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $value }}</p>
            @if($sub)
                <p class="text-xs text-gray-400 mt-1">{{ $sub }}</p>
            @endif
        </div>
        <div class="p-2.5 rounded-xl {{ $c['bg'] }}">
            <x-icon name="{{ $icon }}" class="w-6 h-6 {{ $c['icon'] }}" />
        </div>
    </div>
</div>
