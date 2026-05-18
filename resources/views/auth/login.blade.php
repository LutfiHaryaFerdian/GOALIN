<x-guest-layout>
    <x-slot name="title">Masuk ke GOALIN</x-slot>

    <h1 class="text-2xl font-bold text-white mb-1">Selamat Datang!</h1>
    <p class="text-sm text-gray-500 mb-6">Masuk ke akun GOALIN Anda</p>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 p-3 bg-emerald-500/10 border border-emerald-500/20 rounded-lg">
            <p class="text-sm text-emerald-400">{{ session('status') }}</p>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-medium text-gray-400 mb-1.5">Email</label>
            <input id="email" class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-lg text-white placeholder-gray-600 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500/50 transition-all"
                type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                placeholder="nama@email.com">
            @error('email')
                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-medium text-gray-400 mb-1.5">Password</label>
            <input id="password" class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-lg text-white placeholder-gray-600 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500/50 transition-all"
                type="password" name="password" required autocomplete="current-password"
                placeholder="••••••••">
            @error('password')
                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me & Forgot -->
        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 cursor-pointer">
                <input id="remember_me" type="checkbox" class="w-3.5 h-3.5 rounded border-white/20 bg-white/5 text-emerald-500 focus:ring-emerald-500/50" name="remember">
                <span class="text-xs text-gray-400">Ingat saya</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-xs text-emerald-400 hover:text-emerald-300 transition-colors">Lupa password?</a>
            @endif
        </div>

        <button type="submit"
            class="w-full py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 text-white rounded-lg font-semibold text-sm transition-all shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/30 active:scale-[0.98]">
            Masuk
        </button>

        <p class="text-center text-xs text-gray-500">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-emerald-400 hover:text-emerald-300 font-medium transition-colors">Daftar sekarang</a>
        </p>
    </form>
</x-guest-layout>
