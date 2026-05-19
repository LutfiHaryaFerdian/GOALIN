<x-guest-layout>
    <x-slot name="title">Buat Akun</x-slot>

    <div class="mb-8">
        <h1 class="text-2xl font-extrabold text-gray-900">Buat akun baru</h1>
        <p class="mt-1 text-sm text-gray-500">Bergabung dan mulai pesan lapangan olahraga</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="name" value="Nama Lengkap" />
            <x-text-input id="name" type="text" name="name" :value="old('name')"
                required autofocus autocomplete="name" placeholder="Nama lengkap Anda" />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" value="Alamat Email" />
            <x-text-input id="email" type="email" name="email" :value="old('email')"
                required autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div>
            <x-input-label for="phone" value="No. Telepon (opsional)" />
            <x-text-input id="phone" type="tel" name="phone" :value="old('phone')"
                placeholder="08xxxxxxxxxx" autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone')" />
        </div>

        <div>
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" type="password" name="password"
                required autocomplete="new-password" placeholder="Min. 8 karakter" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Konfirmasi Password" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation"
                required autocomplete="new-password" placeholder="Ulangi password" />
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>

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
