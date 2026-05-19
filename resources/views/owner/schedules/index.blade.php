<x-app-layout>
    <x-slot name="title">Kelola Jadwal — {{ $field->name }}</x-slot>
    <div class="flex">
        <x-sidebar section="owner" />
        <main class="flex-1 min-w-0 py-8 px-4 sm:px-8">
            <div class="flex items-center gap-3 mb-8">
                <a href="{{ route('owner.fields.index') }}"
                   class="p-2 rounded-lg hover:bg-primary-light text-gray-400 hover:text-primary transition-colors">
                    <x-icon name="arrow-left" class="w-5 h-5" />
                </a>
                <div>
                    <p class="section-label">Owner Panel</p>
                    <h1 class="text-2xl font-extrabold text-gray-900">Kelola Jadwal</h1>
                    <p class="text-sm text-gray-500">{{ $field->name }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                {{-- Schedule grid --}}
                <div class="lg:col-span-3 card overflow-hidden" x-data="{ selectedDate: '{{ $dates[0] }}' }">
                    {{-- Date tabs --}}
                    <div class="flex gap-1.5 overflow-x-auto p-4 border-b border-field bg-accent"
                         style="-ms-overflow-style:none;scrollbar-width:none;">
                        @foreach($dates as $date)
                            <button @click="selectedDate = '{{ $date }}'"
                                :class="selectedDate === '{{ $date }}'
                                    ? 'bg-primary text-white'
                                    : 'bg-white text-gray-600 hover:bg-primary-light hover:text-primary border border-field'"
                                class="shrink-0 px-4 py-2 rounded-lg text-xs font-semibold transition-colors whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($date)->format('D, d/m') }}
                            </button>
                        @endforeach
                    </div>

                    {{-- Slot grid per date --}}
                    @foreach($dates as $date)
                        <div x-show="selectedDate === '{{ $date }}'" x-cloak class="p-5">
                            @if(isset($schedules[$date]) && $schedules[$date]->count() > 0)
                                <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-2">
                                    @foreach($schedules[$date] as $schedule)
                                        <div class="flex flex-col items-center p-2.5 rounded-xl border text-center
                                            @if($schedule->status === 'available') border-field bg-primary-light text-primary
                                            @elseif($schedule->status === 'booked')  border-blue-100 bg-blue-50 text-blue-600
                                            @else border-gray-100 bg-gray-50 text-gray-400
                                            @endif">
                                            <span class="text-xs font-bold">{{ substr($schedule->start_time, 0, 5) }}</span>
                                            <span class="text-[10px] mt-0.5 capitalize">{{ $schedule->status }}</span>
                                            @if($schedule->status !== 'booked')
                                                <form method="POST" action="{{ route('owner.schedules.update-status', $schedule) }}" class="mt-1.5 w-full">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status"
                                                        value="{{ $schedule->status === 'available' ? 'closed' : 'available' }}">
                                                    <button type="submit"
                                                        class="w-full text-[10px] font-semibold px-2 py-0.5 rounded
                                                               bg-white/60 hover:bg-white transition-colors border border-current/20">
                                                        {{ $schedule->status === 'available' ? 'Tutup' : 'Buka' }}
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-center py-8 text-sm text-gray-400">Belum ada slot untuk tanggal ini.</p>
                            @endif
                        </div>
                    @endforeach

                    {{-- Legend --}}
                    <div class="px-5 pb-4 flex gap-5 text-xs text-gray-400">
                        <span class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded bg-primary-light border border-field inline-block"></span> Tersedia
                        </span>
                        <span class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded bg-blue-50 border border-blue-100 inline-block"></span> Terpesan
                        </span>
                        <span class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded bg-gray-50 border border-gray-100 inline-block"></span> Tutup
                        </span>
                    </div>
                </div>

                {{-- Add slot form --}}
                <div class="lg:col-span-1">
                    <div class="card p-5 sticky top-24">
                        <h3 class="font-bold text-gray-900 mb-4">Tambah Slot</h3>
                        <form method="POST" action="{{ route('owner.schedules.store', $field) }}" class="space-y-3">
                            @csrf
                            <div>
                                <label class="label">Tanggal</label>
                                <input type="date" name="schedule_date"
                                    min="{{ today()->format('Y-m-d') }}"
                                    class="input text-sm">
                            </div>
                            <div>
                                <label class="label">Jam Mulai</label>
                                <input type="time" name="start_time" class="input text-sm">
                            </div>
                            <div>
                                <label class="label">Jam Selesai</label>
                                <input type="time" name="end_time" class="input text-sm">
                            </div>
                            <div>
                                <label class="label">Catatan</label>
                                <input type="text" name="notes" placeholder="Opsional" class="input text-sm">
                            </div>
                            <button type="submit" class="btn-primary w-full justify-center text-sm">
                                <x-icon name="plus" class="w-4 h-4" />
                                Tambah Slot
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
