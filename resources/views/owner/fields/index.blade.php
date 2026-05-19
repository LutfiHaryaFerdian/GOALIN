<x-app-layout>
    <x-slot name="title">Lapangan Saya</x-slot>
    <div class="flex">
        <x-sidebar section="owner" />
        <main class="flex-1 min-w-0 py-8 px-4 sm:px-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <p class="section-label">Owner Panel</p>
                    <h1 class="text-2xl font-extrabold text-gray-900">Lapangan Saya</h1>
                </div>
                <a href="{{ route('owner.fields.create') }}" class="btn-primary">
                    <x-icon name="plus" class="w-4 h-4" />
                    Tambah Lapangan
                </a>
            </div>

            @if($fields->isEmpty())
                <div class="card p-16 text-center">
                    <div class="w-16 h-16 bg-primary-light rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <x-icon name="field" class="w-8 h-8 text-primary" />
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Belum ada lapangan</h3>
                    <p class="text-gray-500 text-sm mb-6">Mulai tambahkan lapangan olahraga Anda.</p>
                    <a href="{{ route('owner.fields.create') }}" class="btn-primary inline-flex">Tambah Lapangan Pertama</a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
                    @foreach($fields as $field)
                        @php
                            $statusColors = [
                                'active'      => 'badge-confirmed',
                                'inactive'    => 'bg-gray-100 text-gray-600 rounded-full px-3 py-0.5 text-xs font-semibold',
                                'maintenance' => 'badge-pending',
                            ];
                        @endphp
                        <div class="card overflow-hidden">
                            <div class="aspect-video bg-primary-light flex items-center justify-center">
                                <x-icon name="field" class="w-10 h-10 text-primary opacity-30" />
                            </div>
                            <div class="p-5">
                                <div class="flex items-start justify-between gap-2 mb-2">
                                    <h3 class="font-bold text-gray-900 text-sm leading-tight">{{ $field->name }}</h3>
                                    <span class="{{ $statusColors[$field->status] ?? '' }} shrink-0">{{ ucfirst($field->status) }}</span>
                                </div>
                                <p class="text-xs text-gray-500 mb-1">{{ $field->category->name }} · {{ $field->location->city }}</p>
                                <p class="text-sm font-bold text-primary mb-4">Rp {{ number_format($field->price_per_hour, 0, ',', '.') }}/jam</p>

                                <div class="grid grid-cols-3 gap-1.5">
                                    <a href="{{ route('owner.schedules.index', $field) }}"
                                       class="py-1.5 text-center text-xs font-semibold text-primary bg-primary-light rounded-lg hover:bg-primary hover:text-white transition-colors">
                                        Jadwal
                                    </a>
                                    <a href="{{ route('owner.fields.edit', $field) }}"
                                       class="py-1.5 text-center text-xs font-semibold text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('owner.fields.destroy', $field) }}"
                                          x-data x-on:submit.prevent="if(confirm('Nonaktifkan lapangan ini?')) $el.submit()">
                                        @csrf
                                        @method('DELETE')
                                        <button class="w-full py-1.5 text-xs font-semibold text-red-500 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                                            Nonaktif
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6">{{ $fields->links() }}</div>
            @endif
        </main>
    </div>
</x-app-layout>
