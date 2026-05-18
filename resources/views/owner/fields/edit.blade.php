<x-app-layout>
    <x-slot name="title">Edit Lapangan</x-slot>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-2xl font-bold text-white mb-6">Edit Lapangan</h1>

        <form method="POST" action="{{ route('owner.fields.update', $field) }}" enctype="multipart/form-data"
            class="bg-gray-900/60 border border-white/5 rounded-2xl p-6 space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-medium text-gray-400 mb-1.5">Nama Lapangan *</label>
                    <input type="text" name="name" value="{{ old('name', $field->name) }}" required
                        class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-lg text-white text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                    @error('name') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5">Kategori *</label>
                    <select name="category_id" required class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-lg text-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $field->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5">Lokasi *</label>
                    <select name="location_id" required class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-lg text-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                        @foreach($locations as $loc)
                            <option value="{{ $loc->id }}" {{ old('location_id', $field->location_id) == $loc->id ? 'selected' : '' }}>{{ $loc->name }}, {{ $loc->city }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5">Harga per Jam (Rp) *</label>
                    <input type="number" name="price_per_hour" value="{{ old('price_per_hour', $field->price_per_hour) }}" min="1000" required
                        class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-lg text-white text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5">Kapasitas *</label>
                    <input type="number" name="capacity" value="{{ old('capacity', $field->capacity) }}" min="1" required
                        class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-lg text-white text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5">Status</label>
                    <select name="status" class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-lg text-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                        <option value="active" {{ old('status', $field->status) === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('status', $field->status) === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                        <option value="maintenance" {{ old('status', $field->status) === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-medium text-gray-400 mb-1.5">Deskripsi</label>
                    <textarea name="description" rows="3"
                        class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-lg text-white text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all resize-none">{{ old('description', $field->description) }}</textarea>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-medium text-gray-400 mb-2">Fasilitas</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['parkir', 'toilet', 'mushola', 'wifi', 'ac', 'kantin', 'loker'] as $fac)
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="checkbox" name="facilities[]" value="{{ $fac }}"
                                    {{ in_array($fac, old('facilities', $field->facilities ?? [])) ? 'checked' : '' }}
                                    class="w-4 h-4 rounded border-white/20 bg-white/5 text-emerald-500">
                                <span class="text-sm text-gray-300 capitalize">{{ $fac }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-medium text-gray-400 mb-1.5">Tambah Foto Baru</label>
                    <input type="file" name="images[]" multiple accept="image/*"
                        class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-emerald-500/10 file:text-emerald-400 file:text-sm hover:file:bg-emerald-500/20">
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('owner.fields.index') }}" class="flex-1 py-2.5 bg-white/5 hover:bg-white/10 border border-white/10 text-gray-300 rounded-xl text-sm font-medium text-center transition-all">
                    Batal
                </a>
                <button type="submit" class="flex-1 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 text-white rounded-xl font-semibold text-sm transition-all shadow-lg shadow-emerald-500/20">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
