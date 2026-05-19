<x-guest-layout>
    <x-slot name="title">Masuk</x-slot>

    <div class="mb-8">
        <h1 class="text-2xl font-extrabold text-gray-900">Selamat datang kembali</h1>
        <p class="mt-1 text-sm text-gray-500">Masuk untuk melanjutkan ke GOALIN</p>
    </div>

    <x-auth-session-status class="mb-4 text-sm text-primary bg-primary-light px-4 py-2.5 rounded-lg" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" type="email" name="email"
                :value="old('email')" required autofocus autocomplete="username"
                placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div>
            <div class="flex items-center justify-between mb-1.5">
                <x-input-label for="password" value="Password" />
                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="text-xs font-medium text-primary hover:text-primary-dark transition-colors">
                        Lupa password?
                    </a>
                @endif
            </div>
            <x-text-input id="password" type="password" name="password"
                required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div class="flex items-center gap-2">
            <input id="remember_me" type="checkbox" name="remember"
                   class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary">
            <label for="remember_me" class="text-sm text-gray-600">Ingat saya</label>
        </div>

        <x-primary-button class="w-full justify-center py-3">
            <x-icon name="logout" class="w-4 h-4 rotate-180" />
            Masuk
        </x-primary-button>

        <p class="text-center text-sm text-gray-500">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-semibold text-primary hover:text-primary-dark transition-colors">Daftar gratis</a>
        </p>
    </form>
</x-guest-layout>
