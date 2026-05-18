<x-app-layout>
    <x-slot name="title">Lapangan Saya</x-slot>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-white">Lapangan Saya</h1>
            <a href="{{ route('owner.fields.create') }}"
                class="flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 text-white rounded-xl text-sm font-medium transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Lapangan
            </a>
        </div>

        @if($fields->isEmpty())
            <div class="text-center py-20 bg-gray-900/40 border border-white/5 rounded-2xl">
                <div class="text-5xl mb-4">🏟️</div>
                <h3 class="text-lg font-semibold text-white mb-2">Belum ada lapangan</h3>
                <p class="text-gray-500 text-sm mb-6">Mulai tambahkan lapangan olahraga Anda.</p>
                <a href="{{ route('owner.fields.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-500 hover:bg-emerald-400 text-white rounded-xl font-medium text-sm transition-all">
                    Tambah Lapangan Pertama
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($fields as $field)
                    @php
                        $statusColors = ['active' => 'text-emerald-400 bg-emerald-500/10 border-emerald-500/20','inactive' => 'text-gray-400 bg-gray-500/10 border-gray-500/20','maintenance' => 'text-yellow-400 bg-yellow-500/10 border-yellow-500/20'];
                    @endphp
                    <div class="bg-gray-900/60 border border-white/5 rounded-2xl overflow-hidden hover:border-white/10 transition-all">
                        <div class="h-32 bg-gradient-to-br from-gray-800 to-gray-900 flex items-center justify-center">
                            <span class="text-5xl">{{ $field->category->icon ?? '🏟️' }}</span>
                        </div>
                        <div class="p-4">
                            <div class="flex items-start justify-between gap-2 mb-2">
                                <h3 class="font-semibold text-white text-sm">{{ $field->name }}</h3>
                                <span class="px-2 py-0.5 rounded-full border text-[10px] font-medium {{ $statusColors[$field->status] ?? '' }}">
                                    {{ ucfirst($field->status) }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 mb-1">{{ $field->location->city }} · {{ $field->category->name }}</p>
                            <p class="text-sm font-semibold text-emerald-400 mb-4">Rp {{ number_format($field->price_per_hour, 0, ',', '.') }}/jam</p>
                            <div class="grid grid-cols-3 gap-2">
                                <a href="{{ route('owner.schedules.index', $field) }}" class="py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-lg text-gray-400 hover:text-white text-[11px] text-center transition-all">
                                    📅 Jadwal
                                </a>
                                <a href="{{ route('owner.fields.edit', $field) }}" class="py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-lg text-gray-400 hover:text-white text-[11px] text-center transition-all">
                                    ✏️ Edit
                                </a>
                                <form method="POST" action="{{ route('owner.fields.destroy', $field) }}" x-data x-on:submit.prevent="if(confirm('Nonaktifkan lapangan ini?')) $el.submit()">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full py-2 bg-white/5 hover:bg-red-500/10 border border-white/10 hover:border-red-500/20 rounded-lg text-gray-500 hover:text-red-400 text-[11px] transition-all">
                                        🗑️ Nonaktif
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6">{{ $fields->links() }}</div>
        @endif
    </div>
</x-app-layout>
