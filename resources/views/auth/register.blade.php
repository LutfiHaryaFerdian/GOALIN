<x-guest-layout>
    <x-slot name="title">Buat Akun</x-slot>

    <div class="mb-8 text-center">
        <h1 class="font-display text-4xl font-bold uppercase tracking-tight text-[#0a0a0a]">BUAT AKUN<br>BARU</h1>
        <p class="mt-2 text-sm text-[#737373]">Bergabung dan mulai pesan lapangan olahraga</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5"
          x-data="{ selectedRole: '{{ old('role', 'user') }}' }">
        @csrf

        {{-- Role Selector --}}
        <div>
            <p class="label">Daftar sebagai</p>
            <div class="grid grid-cols-2 gap-3">
                {{-- User --}}
                <div @click="selectedRole = 'user'"
                     :class="selectedRole === 'user' ? 'border-[#0a0a0a] bg-[#f8f8f6]' : 'border-[#e5e5e5] hover:border-[#0a0a0a]'"
                     class="border-2 rounded-2xl p-4 cursor-pointer transition-all duration-150 text-center select-none">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="mx-auto mb-2 h-7 w-7 transition-colors"
                         :class="selectedRole === 'user' ? 'text-[#0a0a0a]' : 'text-[#d4d4d4]'"
                         fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                    </svg>
                    <p class="font-semibold text-xs transition-colors" :class="selectedRole === 'user' ? 'text-[#0a0a0a]' : 'text-[#737373]'">Pemesan</p>
                    <p class="text-[11px] text-[#a3a3a3] mt-0.5 leading-snug">Cari &amp; pesan lapangan</p>
                </div>
                {{-- Owner --}}
                <div @click="selectedRole = 'owner'"
                     :class="selectedRole === 'owner' ? 'border-[#0a0a0a] bg-[#f8f8f6]' : 'border-[#e5e5e5] hover:border-[#0a0a0a]'"
                     class="border-2 rounded-2xl p-4 cursor-pointer transition-all duration-150 text-center select-none">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="mx-auto mb-2 h-7 w-7 transition-colors"
                         :class="selectedRole === 'owner' ? 'text-[#0a0a0a]' : 'text-[#d4d4d4]'"
                         fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z"/>
                    </svg>
                    <p class="font-semibold text-xs transition-colors" :class="selectedRole === 'owner' ? 'text-[#0a0a0a]' : 'text-[#737373]'">Pengelola</p>
                    <p class="text-[11px] text-[#a3a3a3] mt-0.5 leading-snug">Kelola lapangan</p>
                </div>
            </div>
            <input type="hidden" name="role" :value="selectedRole">
            @error('role')<p class="mt-1.5 text-xs text-[#dc2626]">{{ $message }}</p>@enderror
        </div>

        {{-- Divider --}}
        <div class="flex items-center gap-3">
            <div class="flex-1 h-px bg-[#f5f5f5]"></div>
            <span class="text-xs text-[#a3a3a3]">Data Akun</span>
            <div class="flex-1 h-px bg-[#f5f5f5]"></div>
        </div>

        <div class="space-y-1.5">
            <label for="name" class="label">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}"
                   class="input" placeholder="Nama lengkap Anda" required autofocus autocomplete="name">
            @error('name')<p class="text-xs text-[#dc2626] mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="space-y-1.5">
            <label for="email" class="label">Alamat Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   class="input" placeholder="nama@email.com" required autocomplete="username">
            @error('email')<p class="text-xs text-[#dc2626] mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="space-y-1.5">
            <label for="phone" class="label">No. Telepon <span class="normal-case font-normal text-[#a3a3a3]">(opsional)</span></label>
            <input id="phone" type="tel" name="phone" value="{{ old('phone') }}"
                   class="input" placeholder="08xxxxxxxxxx" autocomplete="tel">
            @error('phone')<p class="text-xs text-[#dc2626] mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="space-y-1.5">
            <label for="password" class="label">Password</label>
            <input id="password" type="password" name="password"
                   class="input" placeholder="Min. 8 karakter" required autocomplete="new-password">
            @error('password')<p class="text-xs text-[#dc2626] mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="space-y-1.5">
            <label for="password_confirmation" class="label">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation"
                   class="input" placeholder="Ulangi password" required autocomplete="new-password">
        </div>

        <button type="submit" class="w-full flex items-center justify-center gap-2 bg-[#0a0a0a] text-white text-sm font-semibold py-3.5 rounded-full hover:bg-[#404040] transition-colors duration-200 mt-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
            </svg>
            Buat Akun
        </button>

        <p class="text-center text-sm text-[#737373]">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-semibold text-[#0a0a0a] hover:text-[#16a34a] transition-colors">Masuk di sini</a>
        </p>
    </form>
</x-guest-layout>
