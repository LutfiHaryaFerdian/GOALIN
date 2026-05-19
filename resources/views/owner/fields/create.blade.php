@php $editing = isset($field); @endphp
<x-app-layout>
    <x-slot name="title">{{ $editing ? 'Edit Lapangan' : 'Tambah Lapangan' }}</x-slot>
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
                    <h1 class="text-2xl font-extrabold text-gray-900">
                        {{ $editing ? 'Edit Lapangan' : 'Tambah Lapangan Baru' }}
                    </h1>
                </div>
            </div>

            <form method="POST"
                  action="{{ $editing ? route('owner.fields.update', $field) : route('owner.fields.store') }}"
                  enctype="multipart/form-data"
                  class="card p-6 space-y-6 max-w-3xl">
                @csrf
                @if($editing) @method('PUT') @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="sm:col-span-2">
                        <label class="label">Nama Lapangan *</label>
                        <input type="text" name="name" value="{{ old('name', $field->name ?? '') }}"
                            class="input" placeholder="Contoh: Arena Futsal Senayan" required>
                        @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="label">Kategori *</label>
                        <select name="category_id" class="input" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ old('category_id', $field->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="label">Lokasi *</label>
                        <select name="location_id" class="input" required>
                            <option value="">Pilih Lokasi</option>
                            @foreach($locations as $loc)
                                <option value="{{ $loc->id }}"
                                    {{ old('location_id', $field->location_id ?? '') == $loc->id ? 'selected' : '' }}>
                                    {{ $loc->name }}, {{ $loc->city }}
                                </option>
                            @endforeach
                        </select>
                        @error('location_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="label">Harga per Jam (Rp) *</label>
                        <input type="number" name="price_per_hour"
                            value="{{ old('price_per_hour', $field->price_per_hour ?? '') }}"
                            class="input" min="1000" placeholder="150000" required>
                        @error('price_per_hour') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="label">Kapasitas (Pemain) *</label>
                        <input type="number" name="capacity"
                            value="{{ old('capacity', $field->capacity ?? 10) }}"
                            class="input" min="1" required>
                        @error('capacity') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="label">Status</label>
                        <select name="status" class="input">
                            <option value="active"       {{ old('status', $field->status ?? '') === 'active'       ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive"     {{ old('status', $field->status ?? '') === 'inactive'     ? 'selected' : '' }}>Nonaktif</option>
                            <option value="maintenance"  {{ old('status', $field->status ?? '') === 'maintenance'  ? 'selected' : '' }}>Maintenance</option>
                        </select>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="label">Deskripsi</label>
                        <textarea name="description" rows="3" class="input resize-none"
                            placeholder="Deskripsikan lapangan Anda...">{{ old('description', $field->description ?? '') }}</textarea>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="label">Fasilitas</label>
                        <div class="flex flex-wrap gap-3 mt-1">
                            @foreach(['parkir', 'toilet', 'mushola', 'wifi', 'ac', 'kantin', 'loker'] as $fac)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="facilities[]" value="{{ $fac }}"
                                        {{ in_array($fac, old('facilities', $field->facilities ?? [])) ? 'checked' : '' }}
                                        class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary">
                                    <span class="text-sm text-gray-700 capitalize">{{ $fac }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="label">Foto Lapangan</label>
                        <input type="file" name="images[]" multiple accept="image/*"
                            class="text-sm text-gray-500
                                   file:mr-3 file:py-1.5 file:px-4
                                   file:rounded-lg file:border-0
                                   file:text-xs file:font-semibold
                                   file:bg-primary-light file:text-primary
                                   hover:file:bg-primary hover:file:text-white
                                   file:transition-colors file:cursor-pointer cursor-pointer">
                        <p class="mt-1.5 text-xs text-gray-400">Maks 2MB per gambar. JPG, PNG, WebP.</p>
                    </div>
                </div>

                <div class="flex gap-3 pt-2 border-t border-field">
                    <a href="{{ route('owner.fields.index') }}" class="btn-secondary flex-1 justify-center">Batal</a>
                    <button type="submit" class="btn-primary flex-1 justify-center">
                        <x-icon name="check" class="w-4 h-4" />
                        {{ $editing ? 'Simpan Perubahan' : 'Simpan Lapangan' }}
                    </button>
                </div>
            </form>
        </main>
    </div>
</x-app-layout>
