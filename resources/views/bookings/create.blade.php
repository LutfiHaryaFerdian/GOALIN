<x-app-layout>
    <x-slot name="title">Konfirmasi Pemesanan</x-slot>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-2xl font-bold text-white mb-6">Konfirmasi Pemesanan</h1>

        <!-- Field Summary -->
        <div class="bg-gray-900/60 border border-white/5 rounded-2xl p-5 mb-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 class="font-semibold text-white text-lg mb-1">{{ $schedule->field->name }}</h2>
                    <div class="flex items-center gap-1.5 text-gray-500 text-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $schedule->field->location->city }}
                    </div>
                </div>
                <div class="text-right shrink-0">
                    <p class="text-sm text-gray-500">Total Harga</p>
                    <p class="text-xl font-bold text-emerald-400">Rp {{ number_format($schedule->field->price_per_hour, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="mt-4 pt-4 border-t border-white/5 grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-xs text-gray-600 mb-1">Tanggal</p>
                    <p class="text-white font-medium">{{ $schedule->schedule_date->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 mb-1">Waktu</p>
                    <p class="text-white font-medium">{{ substr($schedule->start_time, 0, 5) }} – {{ substr($schedule->end_time, 0, 5) }} WIB</p>
                </div>
            </div>
        </div>

        <!-- Booking Form -->
        <form method="POST" action="{{ route('bookings.store') }}" class="bg-gray-900/60 border border-white/5 rounded-2xl p-5">
            @csrf
            <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">

            <h3 class="text-sm font-semibold text-white mb-4">Informasi Pemesan</h3>
            <div class="grid grid-cols-2 gap-4 mb-4 p-3 bg-white/3 rounded-xl text-sm">
                <div>
                    <p class="text-xs text-gray-600 mb-1">Nama</p>
                    <p class="text-white">{{ auth()->user()->name }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 mb-1">Email</p>
                    <p class="text-white">{{ auth()->user()->email }}</p>
                </div>
                @if(auth()->user()->phone)
                    <div>
                        <p class="text-xs text-gray-600 mb-1">Telepon</p>
                        <p class="text-white">{{ auth()->user()->phone }}</p>
                    </div>
                @endif
            </div>

            <div class="mb-5">
                <label for="notes" class="block text-xs font-medium text-gray-400 mb-1.5">Catatan Tambahan <span class="text-gray-600">(opsional)</span></label>
                <textarea id="notes" name="notes" rows="3"
                    placeholder="Contoh: Butuh bola, atau instruksi khusus..."
                    class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-lg text-white placeholder-gray-600 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500/50 transition-all resize-none">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <a href="{{ route('fields.show', $schedule->field->slug) }}"
                    class="flex-1 py-2.5 bg-white/5 hover:bg-white/10 border border-white/10 text-gray-300 rounded-xl text-sm font-medium text-center transition-all">
                    Kembali
                </a>
                <button type="submit"
                    class="flex-1 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 text-white rounded-xl font-semibold text-sm transition-all shadow-lg shadow-emerald-500/20">
                    Konfirmasi Pemesanan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
