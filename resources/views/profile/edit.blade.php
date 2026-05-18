<x-app-layout>
    <x-slot name="title">Profil Saya</x-slot>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-2xl font-bold text-white mb-6">Profil Saya</h1>

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data"
            class="bg-gray-900/60 border border-white/5 rounded-2xl p-6 space-y-5">
            @csrf
            @method('PATCH')

            <!-- Avatar -->
            <div class="flex items-center gap-5">
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-600 flex items-center justify-center font-bold text-2xl text-white overflow-hidden shadow-lg shadow-emerald-500/20">
                    @if($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}" class="w-full h-full object-cover" alt="Avatar">
                    @else
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    @endif
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1.5">Foto Profil</label>
                    <input type="file" name="avatar" accept="image/*"
                        class="text-sm text-gray-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-emerald-500/10 file:text-emerald-400 file:text-xs hover:file:bg-emerald-500/20 cursor-pointer">
                    <p class="mt-1 text-xs text-gray-600">Maks 1MB. Format: JPG, PNG</p>
                    @error('avatar') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="name" class="block text-xs font-medium text-gray-400 mb-1.5">Nama Lengkap</label>
                <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required
                    class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-lg text-white text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                @error('name') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="block text-xs font-medium text-gray-400 mb-1.5">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required
                    class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-lg text-white text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                @error('email') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="phone" class="block text-xs font-medium text-gray-400 mb-1.5">No. Telepon</label>
                <input id="phone" type="tel" name="phone" value="{{ old('phone', $user->phone) }}"
                    class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-lg text-white text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all"
                    placeholder="08xxxxxxxxxx">
                @error('phone') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            <div class="pt-1">
                <div class="inline-block px-3 py-1 bg-white/5 border border-white/10 rounded-full text-xs text-gray-500">
                    Role: <span class="text-gray-300 font-medium capitalize">{{ $user->role }}</span>
                </div>
            </div>

            <button type="submit"
                class="w-full py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 text-white rounded-xl font-semibold text-sm transition-all shadow-lg shadow-emerald-500/20">
                Simpan Perubahan
            </button>
        </form>
    </div>
</x-app-layout>
