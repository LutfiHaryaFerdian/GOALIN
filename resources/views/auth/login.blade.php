<x-guest-layout>
    <x-slot name="title">Masuk</x-slot>

    <div class="mb-10">
        <p class="section-label mb-3">SELAMAT DATANG</p>
        <h1 class="font-display text-[48px] font-extrabold uppercase leading-[48px] tracking-[-0.01em] text-[#1A1A1A]">MASUK<br>KE GOALIN.</h1>
    </div>

    <x-auth-session-status class="mb-4 text-xs font-bold uppercase tracking-[0.05em] text-[#0D3B2E] bg-[#C6FF00] px-4 py-2.5" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <div class="space-y-1.5">
            <label for="email" class="label">EMAIL</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   class="input" placeholder="kamu@email.com" required autofocus autocomplete="username">
            @error('email')
                <p class="text-xs text-[#BA1A1A] mt-1 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-1.5">
            <div class="flex items-center justify-between">
                <label for="password" class="label mb-0">PASSWORD</label>
                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs font-bold uppercase tracking-[0.05em] text-[#717974] hover:text-[#0D3B2E] transition-colors">
                        Lupa?
                    </a>
                @endif
            </div>
            <input id="password" type="password" name="password"
                   class="input" placeholder="••••••••" required autocomplete="current-password">
            @error('password')
                <p class="text-xs text-[#BA1A1A] mt-1 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-2">
            <input id="remember_me" type="checkbox" name="remember"
                   class="w-4 h-4 border border-[#1A1A1A] text-[#0D3B2E] focus:ring-[#C6FF00] cursor-pointer">
            <label for="remember_me" class="text-sm text-[#717974] cursor-pointer">Ingat saya</label>
        </div>

        <button type="submit" class="w-full btn-primary justify-center py-4 text-base">
            MASUK →
        </button>
    </form>

    <p class="text-center text-sm text-[#717974] mt-8">
        Belum punya akun?
        <a href="{{ route('register') }}" class="font-bold text-[#1A1A1A] hover:text-[#0D3B2E] transition-colors">Daftar gratis</a>
    </p>
</x-guest-layout>
