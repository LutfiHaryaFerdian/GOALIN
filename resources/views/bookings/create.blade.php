<x-app-layout>
    <x-slot name="title">Konfirmasi Pemesanan</x-slot>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Header --}}
        <div class="flex items-center gap-3 mb-8">
            <a href="{{ route('fields.show', $schedule->field->slug) }}"
               class="p-2 rounded-lg hover:bg-primary-light text-gray-400 hover:text-primary transition-colors">
                <x-icon name="arrow-left" class="w-5 h-5" />
            </a>
            <div>
                <h1 class="text-2xl font-extrabold text-gray-900">Konfirmasi Pemesanan</h1>
                <p class="text-sm text-gray-500 mt-0.5">Periksa detail sebelum mengkonfirmasi</p>
            </div>
        </div>

        {{-- Booking summary card --}}
        <div class="card p-6 mb-6">
            <div class="flex items-start justify-between gap-4 mb-5">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wide text-gray-400 mb-1">
                        {{ $schedule->field->category->name }}
                    </p>
                    <h2 class="text-xl font-bold text-gray-900">{{ $schedule->field->name }}</h2>
                    <p class="flex items-center gap-1.5 text-sm text-gray-500 mt-1">
                        <x-icon name="map-pin" class="w-4 h-4 text-primary" />
                        {{ $schedule->field->location->city }}
                    </p>
                </div>
                <div class="text-right shrink-0">
                    <p class="text-xs text-gray-400 mb-1">Total</p>
                    <p class="text-2xl font-extrabold text-primary">
                        Rp {{ number_format($schedule->field->price_per_hour, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 pt-5 border-t border-field">
                <div>
                    <p class="label">Tanggal</p>
                    <p class="text-sm font-semibold text-gray-900">
                        {{ $schedule->schedule_date->locale('id')->isoFormat('dddd, D MMMM Y') }}
                    </p>
                </div>
                <div>
                    <p class="label">Waktu</p>
                    <p class="text-sm font-semibold text-gray-900 flex items-center gap-1.5">
                        <x-icon name="clock" class="w-4 h-4 text-primary" />
                        {{ substr($schedule->start_time, 0, 5) }} – {{ substr($schedule->end_time, 0, 5) }} WIB
                    </p>
                </div>
            </div>
        </div>

        {{-- Pemesan info --}}
        <div class="card p-6 mb-6">
            <h3 class="label mb-4">Informasi Pemesan</h3>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-400 text-xs mb-0.5">Nama</p>
                    <p class="font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs mb-0.5">Email</p>
                    <p class="font-semibold text-gray-900">{{ auth()->user()->email }}</p>
                </div>
                @if(auth()->user()->phone)
                    <div>
                        <p class="text-gray-400 text-xs mb-0.5">Telepon</p>
                        <p class="font-semibold text-gray-900">{{ auth()->user()->phone }}</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('bookings.store') }}" class="card p-6">
            @csrf
            <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">

            <div class="mb-6">
                <label for="notes" class="label">Catatan Tambahan <span class="text-gray-300 normal-case font-normal">(opsional)</span></label>
                <textarea id="notes" name="notes" rows="3"
                    placeholder="Contoh: Butuh bola tambahan..."
                    class="input resize-none">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <a href="{{ route('fields.show', $schedule->field->slug) }}"
                   class="btn-secondary flex-1 justify-center">Kembali</a>
                <button type="submit" class="btn-primary flex-1 justify-center">
                    <x-icon name="check" class="w-4 h-4" />
                    Konfirmasi Pemesanan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
