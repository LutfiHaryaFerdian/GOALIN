<x-app-layout>
    <x-slot name="title">{{ $field->name }}</x-slot>

    {{-- Full-width image header --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
        <div class="relative aspect-[16/9] rounded-3xl overflow-hidden bg-[#f5f5f5]">
            @if($field->images && count($field->images) > 0)
                <img src="{{ Storage::url($field->images[0]) }}" alt="{{ $field->name }}"
                     class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-[#d4d4d4]" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
                    </svg>
                </div>
            @endif
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm text-[#a3a3a3] mb-6">
            <a href="{{ route('fields.index') }}" class="hover:text-[#0a0a0a] transition-colors">Lapangan</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
            </svg>
            <span class="text-[#0a0a0a] font-medium">{{ $field->name }}</span>
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
                    <div class="bg-white border border-[#e5e5e5] rounded-2xl p-6">
                        <h2 class="section-label mb-3">Tentang Lapangan</h2>
                        <p class="text-[#404040] text-sm leading-relaxed">{{ $field->description }}</p>
                    </div>
                @endif

                {{-- Facilities --}}
                @if($field->facilities && count($field->facilities) > 0)
                    <div class="bg-white border border-[#e5e5e5] rounded-2xl p-6">
                        <h2 class="section-label mb-4">Fasilitas</h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach($field->facilities as $facility)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#f5f5f5] text-[#404040] rounded-full text-sm font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-[#16a34a]" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                                    </svg>
                                    {{ ucfirst($facility) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Owner info --}}
                <div class="bg-white border border-[#e5e5e5] rounded-2xl p-6">
                    <h2 class="section-label mb-4">Pengelola</h2>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-[#0a0a0a] flex items-center justify-center font-bold text-white text-sm">
                            {{ strtoupper(substr($field->owner->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-[#0a0a0a]">{{ $field->owner->name }}</p>
                            @if($field->owner->phone)
                                <p class="text-sm text-[#737373]">{{ $field->owner->phone }}</p>
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
                        },

                        // ── Real-time slot polling ──────────────────────────────────────────
                        _pollTimer: null,
                        _pollUrl: null,
                        _pollDates: null,
                        _lastPollAt: null,
                        slotUpdated: false,

                        initPolling(url, dates) {
                            this._pollUrl   = url;
                            this._pollDates = dates;
                            this._schedulePoll();
                        },
                        _schedulePoll() {
                            this._pollTimer = setInterval(() => this._doPoll(), 30000);
                        },
                        async _doPoll() {
                            try {
                                const params = this._pollDates.map(d => `dates[]=${d}`).join('&');
                                const res    = await fetch(`${this._pollUrl}?${params}`, {
                                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                                });
                                if (!res.ok) return;
                                const data = await res.json();
                                this._applySlotUpdate(data.slots || {});
                                this._lastPollAt = new Date();
                            } catch (e) { /* silent fail — network issues shouldn't break UX */ }
                        },
                        _applySlotUpdate(fresh) {
                            let changed = false;
                            // Patch status in allSlots without replacing the whole object
                            for (const date in this.allSlots) {
                                this.allSlots[date].forEach(slot => {
                                    if (fresh[slot.id] !== undefined && fresh[slot.id] !== slot.status) {
                                        slot.status = fresh[slot.id];
                                        changed = true;
                                        // If user had this slot selected and it's now booked/closed, deselect it
                                        if (slot.status !== 'available') {
                                            this.selectedSlots = this.selectedSlots.filter(s => s.id !== slot.id);
                                        }
                                    }
                                });
                            }
                            if (changed) {
                                this.slotUpdated = true;
                                setTimeout(() => { this.slotUpdated = false; }, 4000);
                            }
                        },
                        destroyPolling() {
                            if (this._pollTimer) clearInterval(this._pollTimer);
                        }
                    };
                };
                </script>

                <div class="sticky top-24 bg-white border border-[#e5e5e5] rounded-3xl p-6"
                     x-data="slotPicker(
                         {{ $field->price_per_hour }},
                         {{ Js::from($schedulesJson) }},
                         '{{ $dates[0] }}',
                         {{ auth()->check() ? 'true' : 'false' }},
                         '{{ route('login') }}'
                     )"
                     x-init="initPolling('{{ route('fields.slot-status', $field->slug) }}', {{ Js::from($dates) }})"
                     @destroy="destroyPolling()">
                    <div class="flex items-center justify-between mb-1">
                        <h2 class="font-semibold text-[#0a0a0a]">Pilih Jadwal</h2>
                        <div class="flex items-center gap-2">
                            <span class="flex items-center gap-1 text-[10px] text-[#16a34a] font-semibold">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#16a34a] animate-pulse inline-block"></span>
                                Live
                            </span>
                            <span class="text-sm font-bold text-[#0a0a0a]">
                                Rp {{ number_format($field->price_per_hour, 0, ',', '.') }}<span class="text-[#a3a3a3] font-normal">/jam</span>
                            </span>
                        </div>
                    </div>

                    {{-- Slot-updated toast --}}
                    <div x-show="slotUpdated" x-transition
                         class="mb-3 p-2 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-700 text-center">
                        &#8635; Ketersediaan slot telah diperbarui
                    </div>

                    {{-- Date tabs --}}
                    <div class="flex gap-1.5 overflow-x-auto pb-2 mb-4" style="-ms-overflow-style:none;scrollbar-width:none;">
                        @foreach($dates as $date)
                            <button @click="selectDate('{{ $date }}')"
                                :class="selectedDate === '{{ $date }}'
                                    ? 'bg-[#0a0a0a] text-white'
                                    : 'bg-[#f5f5f5] text-[#737373] hover:bg-[#e5e5e5] hover:text-[#0a0a0a]'"
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
                    <div x-show="selectedSlots.length > 0" x-transition class="mt-4 pt-4 border-t border-[#f5f5f5] space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-[#737373]">Durasi</span>
                            <span class="font-semibold text-[#0a0a0a]" x-text="selectedSlots.length + ' jam'"></span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-[#737373]">Waktu</span>
                            <span class="font-semibold text-[#0a0a0a]" x-text="timeRange"></span>
                        </div>
                        <div class="flex justify-between text-sm mb-3">
                            <span class="text-[#737373]">Total</span>
                            <span class="font-bold text-[#0a0a0a]" x-text="formatPrice(totalPrice)"></span>
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
                                    class="w-full flex items-center justify-center gap-2 bg-[#0a0a0a] text-white text-sm font-semibold py-3 rounded-full hover:bg-[#404040] transition-colors mt-1">
                                Pesan Sekarang
                            </button>
                        @else
                            <a href="{{ route('login') }}"
                               class="w-full flex items-center justify-center gap-2 bg-[#0a0a0a] text-white text-sm font-semibold py-3 rounded-full hover:bg-[#404040] transition-colors mt-1 text-center block">
                                Login untuk Memesan
                            </a>
                        @endauth
                    </div>

                    {{-- Legend (hidden when summary shown) --}}
                    <div x-show="selectedSlots.length === 0"
                         class="mt-4 pt-4 border-t border-[#f5f5f5] flex gap-4 text-xs text-[#a3a3a3]">
                        <span class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded-sm bg-[#f0fdf4] border border-[#bbf7d0] inline-block"></span> Tersedia
                        </span>
                        <span class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded-sm bg-[#f5f5f5] inline-block"></span> Terpesan
                        </span>
                    </div>

                    @guest
                        <div class="mt-4 p-4 bg-[#f8f8f6] border border-[#e5e5e5] rounded-2xl text-center">
                            <p class="text-xs text-[#737373] font-medium mb-3">Login untuk memesan</p>
                            <a href="{{ route('login') }}" class="w-full flex items-center justify-center gap-2 bg-[#0a0a0a] text-white text-xs font-semibold py-2.5 rounded-full hover:bg-[#404040] transition-colors block">
                                Masuk Sekarang
                            </a>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
