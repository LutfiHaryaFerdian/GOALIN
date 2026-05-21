<x-app-layout>
    <x-slot name="title">Profil Saya</x-slot>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-2xl font-extrabold text-gray-900 mb-8">Profil Saya</h1>

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="card p-6 space-y-6">
            @csrf
            @method('PATCH')

            {{-- Avatar --}}
            <div class="flex items-center gap-5 pb-6 border-b border-field">
                <div class="w-20 h-20 rounded-2xl bg-primary-light flex items-center justify-center overflow-hidden border-2 border-field">
                    @if($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}" class="w-full h-full object-cover" alt="Avatar">
                    @else
                        <span class="text-3xl font-extrabold text-primary">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </span>
                    @endif
                </div>
                <div>
                    <p class="label mb-2">Foto Profil</p>
                    <input type="file" name="avatar" accept="image/*"
                        class="text-sm text-gray-500
                               file:mr-3 file:py-1.5 file:px-3
                               file:rounded-lg file:border-0
                               file:text-xs file:font-semibold
                               file:bg-primary-light file:text-primary
                               hover:file:bg-primary hover:file:text-white
                               file:transition-colors file:cursor-pointer cursor-pointer">
                    <p class="mt-1.5 text-xs text-gray-400">JPG, PNG — maks 1MB</p>
                    @error('avatar') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Fields --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label for="name" class="label">Nama Lengkap</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}"
                        class="input" required>
                    @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="label">Alamat Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}"
                        class="input" required>
                    @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="phone" class="label">No. Telepon</label>
                    <input id="phone" type="tel" name="phone" value="{{ old('phone', $user->phone) }}"
                        class="input" placeholder="08xxxxxxxxxx">
                    @error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Role badge --}}
            <div class="flex items-center gap-2 pt-2 border-t border-field">
                <x-icon name="{{ $user->isAdmin() ? 'shield' : ($user->isOwner() ? 'store' : 'user') }}" class="w-4 h-4 text-primary" />
                <span class="text-sm text-gray-500">Role: <span class="font-semibold text-gray-900 capitalize">{{ $user->role }}</span></span>
            </div>

            <button type="submit" class="btn-primary w-full justify-center py-3">
                <x-icon name="check" class="w-4 h-4" />
                Simpan Perubahan
            </button>
        </form>

        {{-- Flash messages --}}
        @if (session('success'))
            <div class="mt-4 text-sm text-primary bg-primary-light px-4 py-3 rounded-lg flex items-center gap-2">
                <x-icon name="check" class="w-4 h-4 flex-shrink-0" />
                {{ session('success') }}
            </div>
        @endif

        {{-- Keamanan Akun --}}
        <div class="card p-6 mt-6 space-y-4">
            <h2 class="text-base font-bold text-gray-900">Keamanan Akun</h2>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 p-4 rounded-xl bg-gray-50 border border-field">
                <div>
                    <p class="text-sm font-semibold text-gray-800">Password</p>
                    <p class="text-xs text-gray-500 mt-0.5">
                        Kamu akan menerima kode verifikasi ke email sebelum bisa mengubah password.
                    </p>
                </div>
                <form method="POST" action="{{ route('password.change.request') }}" class="flex-shrink-0">
                    @csrf
                    <button
                        type="submit"
                        class="btn-primary py-2 px-4 text-sm whitespace-nowrap"
                    >
                        <x-icon name="lock" class="w-4 h-4" />
                        Ganti Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
