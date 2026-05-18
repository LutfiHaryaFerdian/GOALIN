<x-app-layout>
    <x-slot name="title">Kelola Jadwal — {{ $field->name }}</x-slot>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('owner.fields.index') }}" class="p-2 rounded-lg bg-white/5 hover:bg-white/10 text-gray-400 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-white">Kelola Jadwal</h1>
                <p class="text-sm text-gray-500">{{ $field->name }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Schedule Grid -->
            <div class="lg:col-span-3">
                <div class="bg-gray-900/60 border border-white/5 rounded-2xl overflow-hidden" x-data="{ selectedDate: '{{ $dates[0] }}' }">
                    <!-- Date tabs -->
                    <div class="flex gap-1.5 overflow-x-auto p-4 border-b border-white/5">
                        @foreach($dates as $date)
                            <button @click="selectedDate = '{{ $date }}'"
                                :class="selectedDate === '{{ $date }}' ? 'bg-emerald-500 text-white' : 'bg-white/5 text-gray-400 hover:bg-white/10'"
                                class="shrink-0 px-3 py-2 rounded-lg text-xs font-medium transition-all">
                                {{ \Carbon\Carbon::parse($date)->format('D d/m') }}
                            </button>
                        @endforeach
                    </div>

                    <!-- Slots per date -->
                    @foreach($dates as $date)
                        <div x-show="selectedDate === '{{ $date }}'" x-cloak class="p-4">
                            @if(isset($schedules[$date]) && $schedules[$date]->count() > 0)
                                <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-2">
                                    @foreach($schedules[$date] as $schedule)
                                        <div class="flex flex-col items-center p-2 rounded-xl border
                                            @if($schedule->status === 'available') border-emerald-500/30 bg-emerald-500/5 text-emerald-400
                                            @elseif($schedule->status === 'booked') border-blue-500/30 bg-blue-500/5 text-blue-400 cursor-not-allowed
                                            @else border-red-500/30 bg-red-500/5 text-red-400
                                            @endif">
                                            <span class="text-xs font-semibold">{{ substr($schedule->start_time, 0, 5) }}</span>
                                            <span class="text-[10px] opacity-70 mt-0.5">{{ ucfirst($schedule->status) }}</span>
                                            @if($schedule->status !== 'booked')
                                                <form method="POST" action="{{ route('owner.schedules.update-status', $schedule) }}" class="mt-1.5 w-full">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="{{ $schedule->status === 'available' ? 'closed' : 'available' }}">
                                                    <button type="submit" class="w-full text-[9px] px-1.5 py-0.5 rounded bg-white/10 hover:bg-white/20 transition-colors">
                                                        {{ $schedule->status === 'available' ? 'Tutup' : 'Buka' }}
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-center py-8 text-sm text-gray-500">Belum ada slot jadwal untuk tanggal ini.</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Add Slot Form -->
            <div class="lg:col-span-1">
                <div class="bg-gray-900/60 border border-white/5 rounded-2xl p-5 sticky top-24">
                    <h3 class="text-sm font-semibold text-white mb-4">Tambah Slot</h3>
                    <form method="POST" action="{{ route('owner.schedules.store', $field) }}" class="space-y-3">
                        @csrf
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Tanggal</label>
                            <input type="date" name="schedule_date" min="{{ today()->format('Y-m-d') }}"
                                class="w-full px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Jam Mulai</label>
                            <input type="time" name="start_time"
                                class="w-full px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Jam Selesai</label>
                            <input type="time" name="end_time"
                                class="w-full px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Catatan</label>
                            <input type="text" name="notes" placeholder="Opsional"
                                class="w-full px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                        </div>
                        <button type="submit" class="w-full py-2 bg-emerald-500/10 hover:bg-emerald-500/20 border border-emerald-500/20 text-emerald-400 rounded-lg text-xs font-medium transition-all">
                            Tambah Slot
                        </button>
                    </form>

                    <!-- Legend -->
                    <div class="mt-4 pt-4 border-t border-white/5 space-y-1.5">
                        <div class="flex items-center gap-2 text-[10px] text-gray-500">
                            <div class="w-3 h-3 rounded bg-emerald-500/20 border border-emerald-500/30 shrink-0"></div> Tersedia
                        </div>
                        <div class="flex items-center gap-2 text-[10px] text-gray-500">
                            <div class="w-3 h-3 rounded bg-blue-500/20 border border-blue-500/30 shrink-0"></div> Terpesan
                        </div>
                        <div class="flex items-center gap-2 text-[10px] text-gray-500">
                            <div class="w-3 h-3 rounded bg-red-500/20 border border-red-500/30 shrink-0"></div> Ditutup
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
