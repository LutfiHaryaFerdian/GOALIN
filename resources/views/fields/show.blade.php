<x-app-layout>
    <x-slot name="title">{{ $field->name }}</x-slot>
    <x-slot name="metaDescription">{{ $field->description }}</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
            <a href="{{ route('fields.index') }}" class="hover:text-gray-300 transition-colors">Lapangan</a>
            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-400">{{ $field->name }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Field Detail -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Image Gallery -->
                <div class="rounded-2xl overflow-hidden bg-gray-900/60 border border-white/5 h-72 md:h-96">
                    @if($field->images && count($field->images) > 0)
                        <img src="{{ Storage::url($field->images[0]) }}" alt="{{ $field->name }}"
                            class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center">
                            <span class="text-8xl mb-3">{{ $field->category->icon ?? '🏟️' }}</span>
                            <span class="text-gray-600">{{ $field->category->name }}</span>
                        </div>
                    @endif
                </div>

                <!-- Field Info -->
                <div class="bg-gray-900/60 border border-white/5 rounded-2xl p-6">
                    <div class="flex flex-wrap items-start justify-between gap-4 mb-4">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="px-2.5 py-1 bg-emerald-500/10 border border-emerald-500/20 rounded-full text-xs text-emerald-400 font-medium">
                                    {{ $field->category->icon ?? '' }} {{ $field->category->name }}
                                </span>
                            </div>
                            <h1 class="text-2xl md:text-3xl font-bold text-white">{{ $field->name }}</h1>
                            <div class="flex items-center gap-1.5 mt-1 text-gray-400 text-sm">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ $field->location->name }}, {{ $field->location->city }}
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Harga per jam</p>
                            <p class="text-2xl font-bold text-emerald-400">Rp {{ number_format($field->price_per_hour, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    @if($field->description)
                        <p class="text-gray-400 text-sm leading-relaxed mb-4">{{ $field->description }}</p>
                    @endif

                    <!-- Facilities -->
                    @if($field->facilities)
                        <div>
                            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Fasilitas</h3>
                            <div class="flex flex-wrap gap-2">
                                @php
                                    $facilityIcons = ['parkir' => '🚗', 'toilet' => '🚻', 'mushola' => '🕌', 'wifi' => '📶', 'ac' => '❄️', 'kantin' => '🍜', 'loker' => '🔒'];
                                @endphp
                                @foreach($field->facilities as $facility)
                                    <span class="flex items-center gap-1.5 px-3 py-1.5 bg-white/5 border border-white/10 rounded-lg text-sm text-gray-300">
                                        {{ $facilityIcons[$facility] ?? '✓' }} {{ ucfirst($facility) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Owner Info -->
                <div class="bg-gray-900/60 border border-white/5 rounded-2xl p-5">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Informasi Owner</h3>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-400 to-teal-600 flex items-center justify-center font-bold text-white">
                            {{ strtoupper(substr($field->owner->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-medium text-white">{{ $field->owner->name }}</p>
                            @if($field->owner->phone)
                                <p class="text-xs text-gray-500">{{ $field->owner->phone }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Reviews -->
                @if($field->reviews->count() > 0)
                    <div class="bg-gray-900/60 border border-white/5 rounded-2xl p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-semibold text-white">Ulasan</h3>
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                <span class="text-sm font-semibold text-white">{{ number_format($field->average_rating, 1) }}</span>
                                <span class="text-xs text-gray-500">({{ $field->reviews->count() }} ulasan)</span>
                            </div>
                        </div>
                        <div class="space-y-4">
                            @foreach($field->reviews->take(3) as $review)
                                <div class="flex gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-400 to-pink-600 flex items-center justify-center font-bold text-xs text-white shrink-0">
                                        {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="text-xs font-medium text-white">{{ $review->user->name }}</span>
                                            <div class="flex">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-3 h-3 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-700' }}" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                                @endfor
                                            </div>
                                        </div>
                                        <p class="text-xs text-gray-400">{{ $review->comment }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right: Schedule Booking -->
            <div class="lg:col-span-1">
                <div class="sticky top-24 bg-gray-900/80 border border-white/10 rounded-2xl p-5">
                    <h2 class="text-base font-semibold text-white mb-4">Pilih Jadwal</h2>

                    <!-- Date Tabs -->
                    <div x-data="{ selectedDate: '{{ $dates[0] }}' }">
                        <div class="flex gap-1.5 overflow-x-auto pb-2 mb-4 scrollbar-none">
                            @foreach($dates as $date)
                                <button @click="selectedDate = '{{ $date }}'"
                                    :class="selectedDate === '{{ $date }}' ? 'bg-emerald-500 text-white border-emerald-500' : 'bg-white/5 text-gray-400 border-white/10 hover:border-white/20'"
                                    class="flex-shrink-0 flex flex-col items-center px-3 py-2 rounded-xl border text-center transition-all min-w-[56px]">
                                    <span class="text-[10px] font-medium">{{ \Carbon\Carbon::parse($date)->locale('id')->isoFormat('ddd') }}</span>
                                    <span class="text-sm font-bold">{{ \Carbon\Carbon::parse($date)->format('d') }}</span>
                                    <span class="text-[9px]">{{ \Carbon\Carbon::parse($date)->locale('id')->isoFormat('MMM') }}</span>
                                </button>
                            @endforeach
                        </div>

                        <!-- Time Slots per Date -->
                        @foreach($dates as $date)
                            <div x-show="selectedDate === '{{ $date }}'" x-cloak>
                                @if(isset($schedules[$date]) && $schedules[$date]->count() > 0)
                                    <div class="grid grid-cols-2 gap-2 max-h-80 overflow-y-auto pr-1">
                                        @foreach($schedules[$date] as $schedule)
                                            @php $available = $schedule->isAvailable(); @endphp
                                            @if($available && auth()->check())
                                                <a href="{{ route('bookings.create', ['schedule_id' => $schedule->id]) }}"
                                                    class="flex flex-col items-center py-3 rounded-xl border border-emerald-500/30 bg-emerald-500/5 hover:bg-emerald-500/15 hover:border-emerald-500/60 text-emerald-400 transition-all cursor-pointer group">
                                                    <span class="text-xs font-semibold">{{ substr($schedule->start_time, 0, 5) }}</span>
                                                    <span class="text-[10px] text-gray-500 group-hover:text-gray-400">{{ substr($schedule->end_time, 0, 5) }}</span>
                                                </a>
                                            @elseif($available && !auth()->check())
                                                <a href="{{ route('login') }}"
                                                    class="flex flex-col items-center py-3 rounded-xl border border-emerald-500/30 bg-emerald-500/5 hover:bg-emerald-500/15 text-emerald-400 transition-all">
                                                    <span class="text-xs font-semibold">{{ substr($schedule->start_time, 0, 5) }}</span>
                                                    <span class="text-[10px] text-gray-500">{{ substr($schedule->end_time, 0, 5) }}</span>
                                                </a>
                                            @else
                                                <div class="flex flex-col items-center py-3 rounded-xl border border-white/5 bg-white/2 opacity-50 cursor-not-allowed">
                                                    <span class="text-xs font-semibold text-gray-600">{{ substr($schedule->start_time, 0, 5) }}</span>
                                                    <span class="text-[10px] text-gray-700">{{ $schedule->status === 'booked' ? 'Terpesan' : 'Ditutup' }}</span>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <div class="py-8 text-center">
                                        <p class="text-sm text-gray-500">Tidak ada slot tersedia untuk tanggal ini.</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach

                        <!-- Legend -->
                        <div class="mt-4 pt-4 border-t border-white/5 flex gap-4 text-xs text-gray-500">
                            <div class="flex items-center gap-1.5">
                                <div class="w-3 h-3 rounded bg-emerald-500/20 border border-emerald-500/30"></div>
                                <span>Tersedia</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <div class="w-3 h-3 rounded bg-white/5 border border-white/10 opacity-50"></div>
                                <span>Terpesan/Tutup</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
