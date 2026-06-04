<x-guest-layout>
    <x-slot name="title">Buat Akun</x-slot>

    <div class="mb-8">
        <p class="section-label mb-3">BERGABUNG</p>
        <h1 class="font-display text-[48px] font-extrabold uppercase leading-[48px] tracking-[-0.01em] text-[#1A1A1A]">BUAT AKUN<br>BARU.</h1>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5"
          x-data="{ selectedRole: '{{ old('role', 'user') }}' }">
        @csrf

        {{-- Role Selector --}}
        <div>
            <p class="label">DAFTAR SEBAGAI</p>
            <div class="grid grid-cols-2 gap-0 border border-[#1A1A1A]">
                <div @click="selectedRole = 'user'"
                     :class="selectedRole === 'user' ? 'bg-[#C6FF00]' : 'bg-white hover:bg-[#F5F5F0]'"
                     class="p-5 cursor-pointer transition-colors text-center select-none border-r border-[#1A1A1A]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-2 h-6 w-6 text-[#1A1A1A]" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                    </svg>
                    <p class="text-xs font-bold uppercase tracking-[0.05em] text-[#1A1A1A]">PEMESAN</p>
                    <p class="text-[11px] text-[#717974] mt-0.5">Cari &amp; pesan lapangan</p>
                </div>
                <div @click="selectedRole = 'owner'"
                     :class="selectedRole === 'owner' ? 'bg-[#C6FF00]' : 'bg-white hover:bg-[#F5F5F0]'"
                     class="p-5 cursor-pointer transition-colors text-center select-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-2 h-6 w-6 text-[#1A1A1A]" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z"/>
                    </svg>
                    <p class="text-xs font-bold uppercase tracking-[0.05em] text-[#1A1A1A]">PENGELOLA</p>
                    <p class="text-[11px] text-[#717974] mt-0.5">Kelola lapangan</p>
                </div>
            </div>
            <input type="hidden" name="role" :value="selectedRole">
            @error('role')<p class="mt-1.5 text-xs text-[#BA1A1A] font-medium">{{ $message }}</p>@enderror
        </div>

        <hr class="border-[rgba(26,26,26,0.1)]">

        <div class="space-y-1.5">
            <label for="name" class="label">NAMA LENGKAP</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" class="input" placeholder="Nama lengkap" required autofocus>
            @error('name')<p class="text-xs text-[#BA1A1A] mt-1 font-medium">{{ $message }}</p>@enderror
        </div>

        <div class="space-y-1.5">
            <label for="email" class="label">EMAIL</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" class="input" placeholder="nama@email.com" required>
            @error('email')<p class="text-xs text-[#BA1A1A] mt-1 font-medium">{{ $message }}</p>@enderror
        </div>

        <div class="space-y-1.5">
            <label for="phone" class="label">NO. TELEPON <span class="normal-case font-normal text-[#717974]">(opsional)</span></label>
            <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" class="input" placeholder="08xxxxxxxxxx">
            @error('phone')<p class="text-xs text-[#BA1A1A] mt-1 font-medium">{{ $message }}</p>@enderror
        </div>

        <div class="space-y-1.5">
            <label for="password" class="label">PASSWORD</label>
            <input id="password" type="password" name="password" class="input" placeholder="Min. 8 karakter" required>
            @error('password')<p class="text-xs text-[#BA1A1A] mt-1 font-medium">{{ $message }}</p>@enderror
        </div>

        <div class="space-y-1.5">
            <label for="password_confirmation" class="label">KONFIRMASI PASSWORD</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="input" placeholder="Ulangi password" required>
        </div>

        <button type="submit" class="w-full btn-primary justify-center py-4 text-base mt-2">
            BUAT AKUN →
        </button>

        <p class="text-center text-sm text-[#717974]">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-bold text-[#1A1A1A] hover:text-[#0D3B2E] transition-colors">Masuk di sini</a>
        </p>
    </form>
</x-guest-layout>
