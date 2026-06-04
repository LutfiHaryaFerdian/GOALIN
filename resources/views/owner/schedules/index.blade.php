<x-app-layout>
    <x-slot name="title">Kelola Jadwal — {{ $field->name }}</x-slot>

    <div class="flex min-h-screen bg-[#F5F5F0]" x-data="{
        showEditModal: false,
        editUrl: '',
        startTime: '',
        endTime: '',
        notes: ''
    }">
        <x-sidebar section="owner" />

        <main class="flex-1 min-w-0">
            {{-- Top bar --}}
            <div class="bg-white border-b border-[rgba(26,26,26,0.1)] px-8 py-5 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('owner.fields.index') }}"
                       class="p-2 border border-[rgba(26,26,26,0.1)] hover:bg-[#F5F5F0] transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#1A1A1A]" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                        </svg>
                    </a>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.15em] text-[#717974]">OWNER PANEL</p>
                        <h1 class="font-display text-2xl font-bold uppercase text-[#1A1A1A] leading-tight mt-0.5">KELOLA JADWAL</h1>
                        <p class="text-xs text-[#717974] font-mono mt-0.5">{{ $field->name }}</p>
                    </div>
                </div>
            </div>

            <div class="p-8">
                @if(session('success'))
                    <div class="mb-6 bg-[#C6FF00] text-[#1A1A1A] px-5 py-3 text-xs font-bold uppercase tracking-[0.05em] border border-[#1A1A1A]">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-6 bg-[#BA1A1A] text-white px-5 py-3 text-xs font-bold uppercase tracking-[0.05em] border border-[#BA1A1A]">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                    {{-- Schedule Grid --}}
                    <div class="lg:col-span-3 bg-white border border-[rgba(26,26,26,0.1)]" x-data="{ selectedDate: '{{ $dates[0] }}' }">
                        {{-- Date Tabs --}}
                        <div class="flex gap-0.5 overflow-x-auto p-4 bg-[#F5F5F0] border-b border-[rgba(26,26,26,0.1)]"
                             style="-ms-overflow-style:none;scrollbar-width:none;">
                            @foreach($dates as $date)
                                <button @click="selectedDate = '{{ $date }}'"
                                    :class="selectedDate === '{{ $date }}'
                                        ? 'bg-[#0D3B2E] text-[#C6FF00] border-[#0D3B2E]'
                                        : 'bg-white text-[#717974] hover:bg-[#F5F5F0] hover:text-[#1A1A1A] border-[rgba(26,26,26,0.1)]'"
                                    class="shrink-0 px-4 py-2.5 border text-xs font-bold uppercase tracking-[0.05em] transition-colors whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($date)->locale('id')->isoFormat('ddd, DD MMM') }}
                                </button>
                            @endforeach
                        </div>

                        {{-- Slot List per Date --}}
                        @foreach($dates as $date)
                            <div x-show="selectedDate === '{{ $date }}'" x-cloak class="p-6">
                                @if(isset($schedules[$date]) && $schedules[$date]->count() > 0)
                                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                                        @foreach($schedules[$date] as $schedule)
                                            <div class="border p-4 bg-white flex flex-col justify-between min-h-[140px]
                                                @if($schedule->status === 'available') border-[rgba(26,26,26,0.15)]
                                                @elseif($schedule->status === 'booked') border-[#1A1A1A] bg-[#1A1A1A]/5
                                                @else border-[#BA1A1A]/30 bg-[#BA1A1A]/5
                                                @endif">
                                                <div>
                                                    <div class="flex justify-between items-start mb-2">
                                                        <span class="font-display text-2xl font-extrabold text-[#1A1A1A] tracking-tight leading-none">
                                                            {{ substr($schedule->start_time, 0, 5) }} – {{ substr($schedule->end_time, 0, 5) }}
                                                        </span>
                                                        <span class="text-[10px] font-bold uppercase tracking-[0.05em] px-2 py-0.5
                                                            @if($schedule->status === 'available') bg-[#C6FF00] text-[#1A1A1A]
                                                            @elseif($schedule->status === 'booked') bg-[#1A1A1A] text-white
                                                            @else bg-[#BA1A1A] text-white
                                                            @endif">
                                                            {{ $schedule->status === 'available' ? 'Tersedia' : ($schedule->status === 'booked' ? 'Terpesan' : 'Tutup') }}
                                                        </span>
                                                    </div>
                                                    @if($schedule->notes)
                                                        <p class="text-[11px] text-[#717974] italic leading-tight mb-2">"{{ $schedule->notes }}"</p>
                                                    @endif
                                                </div>

                                                <div class="pt-3 border-t border-[rgba(26,26,26,0.06)] flex items-center justify-between gap-2 mt-auto">
                                                    @if($schedule->status !== 'booked')
                                                        {{-- Toggle Status --}}
                                                        <form method="POST" action="{{ route('owner.schedules.update-status', $schedule) }}" class="inline-block">
                                                            @csrf @method('PATCH')
                                                            <input type="hidden" name="status"
                                                                value="{{ $schedule->status === 'available' ? 'closed' : 'available' }}">
                                                            <button type="submit"
                                                                class="text-[10px] font-bold uppercase tracking-[0.05em] text-[#0d3b2e] hover:text-[#C6FF00] transition-colors">
                                                                {{ $schedule->status === 'available' ? 'TUTUP' : 'BUKA' }}
                                                            </button>
                                                        </form>

                                                        <div class="flex items-center gap-2.5">
                                                            {{-- Edit Hours Trigger --}}
                                                            <button type="button"
                                                                    @click="
                                                                        showEditModal = true;
                                                                        editUrl = '{{ route('owner.schedules.update-hours', $schedule) }}';
                                                                        startTime = '{{ substr($schedule->start_time, 0, 5) }}';
                                                                        endTime = '{{ substr($schedule->end_time, 0, 5) }}';
                                                                        notes = '{{ $schedule->notes }}';
                                                                    "
                                                                    class="text-[10px] font-bold uppercase tracking-[0.05em] text-[#717974] hover:text-[#1a1a1a] transition-colors">
                                                                EDIT
                                                            </button>

                                                            {{-- Delete Form --}}
                                                            <form method="POST" action="{{ route('owner.schedules.destroy', $schedule) }}"
                                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus slot jadwal ini?')"
                                                                  class="inline-block">
                                                                @csrf @method('DELETE')
                                                                <button type="submit"
                                                                    class="text-[10px] font-bold uppercase tracking-[0.05em] text-[#BA1A1A] hover:text-red-700 transition-colors">
                                                                    HAPUS
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @else
                                                        <span class="text-[9px] text-[#717974] uppercase tracking-[0.05em]">LOCKED BY BOOKING</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-16 border border-dashed border-[rgba(26,26,26,0.15)]">
                                        <p class="font-display font-extrabold uppercase text-[rgba(26,26,26,0.06)]" style="font-size:clamp(24px,4vw,48px)">BELUM ADA SLOT</p>
                                        <p class="text-[#717974] text-xs mt-1">Silakan tambah slot jadwal baru di panel sebelah kanan.</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach

                        {{-- Legend --}}
                        <div class="px-6 py-4 bg-[#F5F5F0] border-t border-[rgba(26,26,26,0.1)] flex gap-4 text-xs text-[#717974]">
                            <span class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 bg-[#C6FF00] inline-block border border-[rgba(26,26,26,0.1)]"></span> Tersedia
                            </span>
                            <span class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 bg-[#1A1A1A] inline-block"></span> Terpesan
                            </span>
                            <span class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 bg-[#BA1A1A] inline-block"></span> Tutup
                            </span>
                        </div>
                    </div>

                    {{-- Add Slot Sidebar --}}
                    <div class="lg:col-span-1">
                        <div class="bg-white border border-[rgba(26,26,26,0.1)] p-6 sticky top-8">
                            <h3 class="font-display text-xl font-bold uppercase text-[#1A1A1A] mb-4">TAMBAH SLOT</h3>
                            <form method="POST" action="{{ route('owner.schedules.store', $field) }}" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="label">TANGGAL</label>
                                    <input type="date" name="schedule_date"
                                        min="{{ today()->format('Y-m-d') }}"
                                        value="{{ old('schedule_date', today()->format('Y-m-d')) }}"
                                        class="input text-sm" required>
                                    @error('schedule_date')<p class="mt-1 text-xs text-[#BA1A1A] font-medium">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="label">JAM MULAI</label>
                                    <input type="time" name="start_time" value="{{ old('start_time') }}" class="input text-sm" required>
                                    @error('start_time')<p class="mt-1 text-xs text-[#BA1A1A] font-medium">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="label">JAM SELESAI</label>
                                    <input type="time" name="end_time" value="{{ old('end_time') }}" class="input text-sm" required>
                                    @error('end_time')<p class="mt-1 text-xs text-[#BA1A1A] font-medium">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="label">CATATAN (OPSIONAL)</label>
                                    <input type="text" name="notes" placeholder="Contoh: Perbaikan lapangan" value="{{ old('notes') }}" class="input text-sm">
                                    @error('notes')<p class="mt-1 text-xs text-[#BA1A1A] font-medium">{{ $message }}</p>@enderror
                                </div>
                                <button type="submit" class="btn-primary w-full justify-center text-sm py-3.5">
                                    TAMBAH SLOT +
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        {{-- Alpine.js Edit Hours Modal --}}
        <div x-show="showEditModal"
             class="fixed inset-0 z-50 flex items-center justify-center bg-[#1A1A1A]/80"
             x-cloak
             @keydown.escape.window="showEditModal = false">
            <div class="bg-white border-2 border-[#1A1A1A] p-8 max-w-md w-full relative"
                 @click.away="showEditModal = false">
                <button type="button" @click="showEditModal = false" class="absolute top-4 right-4 text-[#717974] hover:text-[#1A1A1A]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                    </svg>
                </button>

                <h3 class="font-display text-2xl font-extrabold uppercase text-[#1A1A1A] mb-5">EDIT JAM SLOT</h3>

                <form method="POST" :action="editUrl" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="label">JAM MULAI</label>
                        <input type="time" name="start_time" x-model="startTime" class="input text-sm" required>
                    </div>
                    <div>
                        <label class="label">JAM SELESAI</label>
                        <input type="time" name="end_time" x-model="endTime" class="input text-sm" required>
                    </div>
                    <div>
                        <label class="label">CATATAN (OPSIONAL)</label>
                        <input type="text" name="notes" x-model="notes" placeholder="Contoh: Sedang diperbaiki" class="input text-sm">
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="button" @click="showEditModal = false" class="btn-forest w-1/2 justify-center py-3 text-xs">
                            BATAL
                        </button>
                        <button type="submit" class="btn-primary w-1/2 justify-center py-3 text-xs">
                            SIMPAN →
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
