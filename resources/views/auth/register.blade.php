<x-guest-layout>
    <x-slot name="title">Buat Akun</x-slot>

    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-gray-900">Buat akun baru</h1>
        <p class="mt-1 text-sm text-gray-500">Bergabung dan mulai pesan lapangan olahraga</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4"
          x-data="{ selectedRole: '{{ old('role', 'user') }}' }">
        @csrf

        {{-- ===== ROLE SELECTOR ===== --}}
        <div class="mb-2">
            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 mb-3">Daftar sebagai</p>

            <div class="grid grid-cols-2 gap-3">

                {{-- Card: Pemesan Lapangan --}}
                <div
                    @click="selectedRole = 'user'"
                    :class="selectedRole === 'user'
                        ? 'border-primary bg-primary-light ring-2 ring-primary ring-offset-1'
                        : 'border-gray-200 hover:border-primary'"
                    class="border-2 rounded-xl p-4 cursor-pointer transition-all duration-150 text-center select-none"
                >
                    <svg
                        class="mx-auto mb-2 h-8 w-8 transition-colors"
                        :class="selectedRole === 'user' ? 'text-primary' : 'text-gray-300'"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.75" stroke="currentColor"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                    </svg>
                    <p class="font-semibold text-sm transition-colors"
                       :class="selectedRole === 'user' ? 'text-primary' : 'text-gray-700'">
                        Pemesan Lapangan
                    </p>
                    <p class="text-xs text-gray-400 mt-1 leading-snug">Cari dan pesan lapangan olahraga favoritmu</p>
                </div>

                {{-- Card: Pengelola Lapangan --}}
                <div
                    @click="selectedRole = 'owner'"
                    :class="selectedRole === 'owner'
                        ? 'border-primary bg-primary-light ring-2 ring-primary ring-offset-1'
                        : 'border-gray-200 hover:border-primary'"
                    class="border-2 rounded-xl p-4 cursor-pointer transition-all duration-150 text-center select-none"
                >
                    <svg
                        class="mx-auto mb-2 h-8 w-8 transition-colors"
                        :class="selectedRole === 'owner' ? 'text-primary' : 'text-gray-300'"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.75" stroke="currentColor"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z"/>
                    </svg>
                    <p class="font-semibold text-sm transition-colors"
                       :class="selectedRole === 'owner' ? 'text-primary' : 'text-gray-700'">
                        Pengelola Lapangan
                    </p>
                    <p class="text-xs text-gray-400 mt-1 leading-snug">Daftarkan dan kelola lapangan olahraga milikmu</p>
                </div>

            </div>

            {{-- Hidden input yang dikirim ke server --}}
            <input type="hidden" name="role" :value="selectedRole">

            @error('role')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Divider --}}
        <div class="relative py-1">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-100"></div>
            </div>
            <div class="relative flex justify-center">
                <span class="bg-white px-3 text-xs text-gray-400">Data Akun</span>
            </div>
        </div>

        {{-- Nama Lengkap --}}
        <div>
            <x-input-label for="name" value="Nama Lengkap" />
            <x-text-input id="name" type="text" name="name" :value="old('name')"
                required autofocus autocomplete="name" placeholder="Nama lengkap Anda" />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" value="Alamat Email" />
            <x-text-input id="email" type="email" name="email" :value="old('email')"
                required autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        {{-- Telepon --}}
        <div>
            <x-input-label for="phone" value="No. Telepon (opsional)" />
            <x-text-input id="phone" type="tel" name="phone" :value="old('phone')"
                placeholder="08xxxxxxxxxx" autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone')" />
        </div>

        {{-- Password --}}
        <div>
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" type="password" name="password"
                required autocomplete="new-password" placeholder="Min. 8 karakter" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        {{-- Konfirmasi Password --}}
        <div>
            <x-input-label for="password_confirmation" value="Konfirmasi Password" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation"
                required autocomplete="new-password" placeholder="Ulangi password" />
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>

        {{-- Submit --}}
        <x-primary-button class="w-full justify-center py-3 mt-2">
            <x-icon name="check" class="w-4 h-4" />
            Buat Akun
        </x-primary-button>

        <p class="text-center text-sm text-gray-500">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-semibold text-primary hover:text-primary-dark transition-colors">Masuk di sini</a>
        </p>
    </form>
</x-guest-layout>
