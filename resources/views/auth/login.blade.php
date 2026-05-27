<x-guest-layout>
    <x-slot name="title">Masuk</x-slot>

    {{-- Header --}}
    <div class="mb-8 text-center">
        <h1 class="font-display text-4xl font-bold uppercase tracking-tight text-[#0a0a0a]">SELAMAT DATANG<br>KEMBALI</h1>
        <p class="mt-2 text-sm text-[#737373]">Masuk untuk melanjutkan ke GOALIN</p>
    </div>

    <x-auth-session-status class="mb-4 text-sm text-[#16a34a] bg-[#f0fdf4] px-4 py-2.5 rounded-xl border border-[#bbf7d0]" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div class="space-y-1.5">
            <label for="email" class="label">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   class="input" placeholder="kamu@email.com" required autofocus autocomplete="username">
            @error('email')
                <p class="text-xs text-[#dc2626] mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-1.5">
            <div class="flex items-center justify-between">
                <label for="password" class="label mb-0">Password</label>
                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs font-medium text-[#16a34a] hover:underline underline-offset-2">
                        Lupa password?
                    </a>
                @endif
            </div>
            <input id="password" type="password" name="password"
                   class="input" placeholder="••••••••" required autocomplete="current-password">
            @error('password')
                <p class="text-xs text-[#dc2626] mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-2">
            <input id="remember_me" type="checkbox" name="remember"
                   class="w-4 h-4 rounded border-[#e5e5e5] text-[#16a34a] focus:ring-[#16a34a]">
            <label for="remember_me" class="text-sm text-[#737373]">Ingat saya</label>
        </div>

        <button type="submit" class="w-full flex items-center justify-center gap-2 bg-[#0a0a0a] text-white text-sm font-semibold py-3.5 rounded-full hover:bg-[#404040] transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 rotate-180" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9"/>
            </svg>
            Masuk
        </button>
    </form>

    <p class="text-center text-sm text-[#737373] mt-6">
        Belum punya akun?
        <a href="{{ route('register') }}" class="font-semibold text-[#0a0a0a] hover:text-[#16a34a] transition-colors">Daftar gratis</a>
    </p>
</x-guest-layout>
