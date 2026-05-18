<x-guest-layout>
    <x-slot name="title">Daftar ke GOALIN</x-slot>

    <h1 class="text-2xl font-bold text-white mb-1">Buat Akun Baru</h1>
    <p class="text-sm text-gray-500 mb-6">Daftar dan mulai pesan lapangan olahraga favoritmu</p>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-xs font-medium text-gray-400 mb-1.5">Nama Lengkap</label>
            <input id="name" class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-lg text-white placeholder-gray-600 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500/50 transition-all"
                type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                placeholder="Nama lengkap Anda">
            @error('name')
                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-medium text-gray-400 mb-1.5">Email</label>
            <input id="email" class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-lg text-white placeholder-gray-600 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500/50 transition-all"
                type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                placeholder="nama@email.com">
            @error('email')
                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Phone -->
        <div>
            <label for="phone" class="block text-xs font-medium text-gray-400 mb-1.5">No. Telepon <span class="text-gray-600">(opsional)</span></label>
            <input id="phone" class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-lg text-white placeholder-gray-600 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500/50 transition-all"
                type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel"
                placeholder="08xxxxxxxxxx">
            @error('phone')
                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-medium text-gray-400 mb-1.5">Password</label>
            <input id="password" class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-lg text-white placeholder-gray-600 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500/50 transition-all"
                type="password" name="password" required autocomplete="new-password"
                placeholder="Minimal 8 karakter">
            @error('password')
                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-xs font-medium text-gray-400 mb-1.5">Konfirmasi Password</label>
            <input id="password_confirmation" class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-lg text-white placeholder-gray-600 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500/50 transition-all"
                type="password" name="password_confirmation" required autocomplete="new-password"
                placeholder="Ulangi password">
            @error('password_confirmation')
                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
            class="w-full py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 text-white rounded-lg font-semibold text-sm transition-all shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/30 active:scale-[0.98]">
            Buat Akun
        </button>

        <p class="text-center text-xs text-gray-500">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-emerald-400 hover:text-emerald-300 font-medium transition-colors">Masuk di sini</a>
        </p>
    </form>
</x-guest-layout>
