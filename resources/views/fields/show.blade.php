<x-app-layout>
    <x-slot name="title">{{ $field->name }}</x-slot>

    {{-- Full-width image header --}}
    <div class="relative h-72 md:h-96 bg-primary-light overflow-hidden">
        @if($field->images && count($field->images) > 0)
            <img src="{{ Storage::url($field->images[0]) }}" alt="{{ $field->name }}"
                 class="w-full h-full object-cover">
        @else
            <div class="w-full h-full flex items-center justify-center">
                <x-icon name="field" class="w-20 h-20 text-primary opacity-20" />
            </div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
        <div class="absolute bottom-0 inset-x-0 px-4 sm:px-6 lg:px-8 pb-6 max-w-7xl mx-auto">
            <span class="inline-block px-3 py-1 bg-white/95 text-primary text-xs font-bold rounded-full mb-3 uppercase tracking-wide">
                {{ $field->category->name }}
            </span>
            <h1 class="text-3xl md:text-4xl font-extrabold text-white">{{ $field->name }}</h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8">
            <a href="{{ route('fields.index') }}" class="hover:text-primary transition-colors">Lapangan</a>
            <x-icon name="chevron-right" class="w-3.5 h-3.5" />
            <span class="text-gray-700">{{ $field->name }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- ── Left: Field info ── --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Meta row --}}
                <div class="flex flex-wrap gap-4 text-sm text-gray-500">
                    <span class="flex items-center gap-1.5">
                        <x-icon name="map-pin" class="w-4 h-4 text-primary" />
                        {{ $field->location->name }}, {{ $field->location->city }}
                    </span>
                    <span class="flex items-center gap-1.5">
                        <x-icon name="banknotes" class="w-4 h-4 text-primary" />
                        Rp {{ number_format($field->price_per_hour, 0, ',', '.') }}/jam
                    </span>
                    @if($field->reviews->count() > 0)
                        <span class="flex items-center gap-1.5">
                            <x-icon name="star" class="w-4 h-4 text-amber-400" />
                            {{ number_format($field->average_rating, 1) }}
                            <span class="text-gray-400">({{ $field->reviews->count() }} ulasan)</span>
                        </span>
                    @endif
                </div>

                {{-- Description --}}
                @if($field->description)
                    <div class="card p-6">
                        <h2 class="text-sm font-bold uppercase tracking-wide text-gray-400 mb-3">Tentang Lapangan</h2>
                        <p class="text-gray-600 text-sm leading-relaxed">{{ $field->description }}</p>
                    </div>
                @endif

                {{-- Facilities --}}
                @if($field->facilities && count($field->facilities) > 0)
                    <div class="card p-6">
                        <h2 class="text-sm font-bold uppercase tracking-wide text-gray-400 mb-4">Fasilitas</h2>
                        @php
                            $facilityIcons = [
                                'parkir'=>'car', 'toilet'=>'user', 'mushola'=>'star',
                                'wifi'=>'bell', 'ac'=>'clock', 'kantin'=>'banknotes', 'loker'=>'shield',
                            ];
                        @endphp
                        <div class="flex flex-wrap gap-2">
                            @foreach($field->facilities as $facility)
                                <span class="flex items-center gap-2 px-3 py-1.5 bg-primary-light text-primary rounded-lg text-sm font-medium">
                                    <x-icon name="{{ $facilityIcons[$facility] ?? 'check' }}" class="w-4 h-4" />
                                    {{ ucfirst($facility) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Owner info --}}
                <div class="card p-6">
                    <h2 class="text-sm font-bold uppercase tracking-wide text-gray-400 mb-4">Pengelola</h2>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-primary-light flex items-center justify-center font-bold text-primary">
                            {{ strtoupper(substr($field->owner->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $field->owner->name }}</p>
                            @if($field->owner->phone)
                                <p class="text-sm text-gray-500">{{ $field->owner->phone }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Reviews --}}
                @if($field->reviews->count() > 0)
                    <div class="card p-6">
                        <h2 class="text-sm font-bold uppercase tracking-wide text-gray-400 mb-4">
                            Ulasan ({{ $field->reviews->count() }})
                        </h2>
                        <div class="space-y-4">
                            @foreach($field->reviews->take(3) as $review)
                                <div class="flex gap-3 pb-4 border-b border-field last:border-0 last:pb-0">
                                    <div class="w-8 h-8 rounded-lg bg-primary-light flex items-center justify-center text-xs font-bold text-primary shrink-0">
                                        {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="text-sm font-semibold text-gray-900">{{ $review->user->name }}</span>
                                            <div class="flex">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <x-icon name="star" class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-200' }}" />
                                                @endfor
                                            </div>
                                        </div>
                                        <p class="text-sm text-gray-500">{{ $review->comment }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- ── Right: Schedule sticky sidebar ── --}}
            <div class="lg:col-span-1">

                @php
                    // Prepare lean JSON for Alpine (only fields it needs)
                    $schedulesJson = [];
                    foreach ($schedules as $date => $slots) {
                        $schedulesJson[$date] = $slots->map(fn($s) => [
                            'id'         => $s->id,
                            'start_time' => substr($s->start_time, 0, 5),
                            'end_time'   => substr($s->end_time, 0, 5),
                            'status'     => $s->status,
                        ])->values()->toArray();
                    }
                @endphp

                <script>
                window.slotPicker = function(pricePerHour, allSlots, initialDate, isAuth, loginUrl) {
                    return {
                        pricePerHour,
                        allSlots,
                        selectedDate: initialDate,
                        selectedSlots: [],
                        consecutiveError: false,
                        isAuth,
                        loginUrl,

                        get currentSlots() {
                            return this.allSlots[this.selectedDate] || [];
                        },
                        get totalPrice() {
                            return this.selectedSlots.length * this.pricePerHour;
                        },
                        get timeRange() {
                            if (!this.selectedSlots.length) return '';
                            return this.selectedSlots[0].start_time + ' – '
                                 + this.selectedSlots[this.selectedSlots.length - 1].end_time + ' WIB';
                        },

                        selectDate(date) {
                            this.selectedDate = date;
                            this.selectedSlots = [];
                            this.consecutiveError = false;
                        },
                        isSelected(id) {
                            return this.selectedSlots.some(s => s.id === id);
                        },
                        toggleSlot(slot) {
                            if (!this.isAuth) { window.location.href = this.loginUrl; return; }
                            if (slot.status !== 'available') return;
                            this.consecutiveError = false;

                            // Deselect from either end only
                            if (this.isSelected(slot.id)) {
                                const idx = this.selectedSlots.findIndex(s => s.id === slot.id);
                                if (idx === 0 || idx === this.selectedSlots.length - 1) {
                                    this.selectedSlots.splice(idx, 1);
                                }
                                return;
                            }

                            if (this.selectedSlots.length === 0) {
                                this.selectedSlots.push(slot); return;
                            }
                            if (this.selectedSlots.length >= 4) return;

                            // Must be adjacent
                            const allIds  = this.currentSlots.map(s => s.id);
                            const selIdxs = this.selectedSlots.map(s => allIds.indexOf(s.id)).sort((a,b)=>a-b);
                            const newIdx  = allIds.indexOf(slot.id);
                            const min = selIdxs[0], max = selIdxs[selIdxs.length - 1];

                            if (newIdx !== min - 1 && newIdx !== max + 1) {
                                this.consecutiveError = true;
                                setTimeout(() => { this.consecutiveError = false; }, 3000);
                                return;
                            }
                            newIdx < min ? this.selectedSlots.unshift(slot) : this.selectedSlots.push(slot);
                        },
                        getSlotClass(slot) {
                            if (slot.status === 'booked')    return 'slot-booked';
                            if (slot.status !== 'available') return 'slot-closed';
                            return this.isSelected(slot.id) ? 'slot-selected' : 'slot-available';
                        },
                        formatPrice(n) {
                            return 'Rp\u00a0' + new Intl.NumberFormat('id-ID').format(n);
                        },
                        submitBooking() {
                            if (this.selectedSlots.length) this.$refs.bookingForm.submit();
                        }
                    };
                };
                </script>

                <div class="sticky top-24 card p-5"
                     x-data="slotPicker(
                         {{ $field->price_per_hour }},
                         {{ Js::from($schedulesJson) }},
                         '{{ $dates[0] }}',
                         {{ auth()->check() ? 'true' : 'false' }},
                         '{{ route('login') }}'
                     )">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="font-bold text-gray-900">Pilih Jadwal</h2>
                        <span class="text-sm font-bold text-primary">
                            Rp {{ number_format($field->price_per_hour, 0, ',', '.') }}<span class="text-gray-400 font-normal">/jam</span>
                        </span>
                    </div>

                    {{-- Date tabs --}}
                    <div class="flex gap-1.5 overflow-x-auto pb-2 mb-4" style="-ms-overflow-style:none;scrollbar-width:none;">
                        @foreach($dates as $date)
                            <button @click="selectDate('{{ $date }}')"
                                :class="selectedDate === '{{ $date }}'
                                    ? 'bg-primary text-white'
                                    : 'bg-accent text-gray-600 hover:bg-primary-light hover:text-primary'"
                                class="shrink-0 flex flex-col items-center px-3 py-2 rounded-xl text-center transition-colors min-w-[52px]">
                                <span class="text-[10px] font-semibold uppercase">
                                    {{ \Carbon\Carbon::parse($date)->locale('id')->isoFormat('ddd') }}
                                </span>
                                <span class="text-base font-extrabold leading-none mt-0.5">
                                    {{ \Carbon\Carbon::parse($date)->format('d') }}
                                </span>
                                <span class="text-[9px] mt-0.5 opacity-70">
                                    {{ \Carbon\Carbon::parse($date)->format('M') }}
                                </span>
                            </button>
                        @endforeach
                    </div>

                    {{-- Slot grid (Alpine-rendered) --}}
                    <div class="grid grid-cols-2 gap-2 max-h-72 overflow-y-auto pr-0.5">
                        <template x-for="slot in currentSlots" :key="slot.id">
                            <button @click="toggleSlot(slot)"
                                    :class="getSlotClass(slot)"
                                    :disabled="slot.status !== 'available'"
                                    class="flex flex-col items-center py-2.5 w-full rounded-xl transition-all">
                                <span class="font-bold text-xs" x-text="slot.start_time"></span>
                                <span class="text-[10px] opacity-70" x-text="slot.end_time"></span>
                                <span x-show="slot.status === 'booked'" class="text-[10px]">Terpesan</span>
                                <span x-show="slot.status !== 'available' && slot.status !== 'booked'" class="text-[10px]">Tutup</span>
                                <span x-show="isSelected(slot.id)" class="text-[9px] font-bold mt-0.5">&#10003; Dipilih</span>
                            </button>
                        </template>
                        <p x-show="currentSlots.length === 0"
                           class="col-span-2 text-center py-8 text-sm text-gray-400">
                            Tidak ada slot untuk tanggal ini.
                        </p>
                    </div>

                    {{-- Consecutive error --}}
                    <div x-show="consecutiveError" x-transition
                         class="mt-3 p-2.5 bg-red-50 border border-red-100 rounded-xl text-xs text-red-600 text-center">
                        &#9888; Pilih slot yang berurutan (maks. 4 jam)
                    </div>

                    {{-- Booking summary --}}
                    <div x-show="selectedSlots.length > 0" x-transition class="mt-4 pt-4 border-t border-field space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Durasi</span>
                            <span class="font-semibold text-gray-900" x-text="selectedSlots.length + ' jam'"></span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Waktu</span>
                            <span class="font-semibold text-gray-900" x-text="timeRange"></span>
                        </div>
                        <div class="flex justify-between text-sm mb-3">
                            <span class="text-gray-500">Total</span>
                            <span class="font-extrabold text-primary" x-text="formatPrice(totalPrice)"></span>
                        </div>

                        {{-- Hidden form — inputs injected by Alpine x-for --}}
                        <form x-ref="bookingForm" method="GET"
                              action="{{ route('bookings.create') }}">
                            <template x-for="slot in selectedSlots" :key="slot.id">
                                <input type="hidden" name="schedule_ids[]" :value="slot.id">
                            </template>
                        </form>

                        @auth
                            <button @click="submitBooking()"
                                    class="btn-primary w-full justify-center text-sm py-2.5 mt-1">
                                Pesan Sekarang
                            </button>
                        @else
                            <a href="{{ route('login') }}"
                               class="btn-primary w-full justify-center text-sm py-2.5 mt-1 text-center block">
                                Login untuk Memesan
                            </a>
                        @endauth
                    </div>

                    {{-- Legend (hidden when summary shown) --}}
                    <div x-show="selectedSlots.length === 0"
                         class="mt-4 pt-4 border-t border-field flex gap-4 text-xs text-gray-400">
                        <span class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded bg-primary-light border border-primary/30 inline-block"></span> Tersedia
                        </span>
                        <span class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded bg-gray-100 inline-block"></span> Terpesan
                        </span>
                    </div>

                    @guest
                        <div class="mt-4 p-3 bg-primary-light rounded-xl text-center">
                            <p class="text-xs text-primary font-medium mb-2">Login untuk memesan</p>
                            <a href="{{ route('login') }}" class="btn-primary w-full justify-center text-xs py-2">
                                Masuk Sekarang
                            </a>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
