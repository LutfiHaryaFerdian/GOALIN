<x-app-layout>
    <x-slot name="title">Profil Saya</x-slot>

    {{-- Header --}}
    <div class="bg-[#0D3B2E] texture-field">
        <div class="max-w-[1280px] mx-auto px-5 md:px-12 py-16">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#C6FF00] mb-4">AKUN</p>
            <h1 class="font-display font-extrabold uppercase leading-none text-white" style="font-size:clamp(40px,5vw,64px)">PROFIL SAYA.</h1>
        </div>
    </div>

    <div class="max-w-2xl mx-auto px-5 md:px-12 py-12">

        @if(session('success'))
            <div class="mb-6 bg-[#C6FF00] text-[#1A1A1A] px-5 py-3 text-xs font-bold uppercase tracking-[0.05em] border border-[#1A1A1A]">
                {{ session('success') }}
            </div>
        @endif

        {{-- Profile form --}}
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data"
              class="bg-white border border-[rgba(26,26,26,0.1)] p-8 space-y-6">
            @csrf
            @method('PATCH')

            {{-- Avatar --}}
            <div class="flex items-center gap-5 pb-6 border-b border-[rgba(26,26,26,0.1)]">
                <div class="w-16 h-16 avatar-circle bg-[#0D3B2E] flex items-center justify-center overflow-hidden shrink-0">
                    @if($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}" class="w-full h-full object-cover avatar-circle" alt="Avatar">
                    @else
                        <span class="font-display text-2xl font-extrabold text-[#C6FF00]">{{ strtoupper(substr($user->name,0,1)) }}</span>
                    @endif
                </div>
                <div>
                    <p class="label mb-2">FOTO PROFIL</p>
                    <input type="file" name="avatar" accept="image/*"
                           class="text-sm text-[#717974]
                                  file:mr-3 file:py-1.5 file:px-3 file:border file:border-[#1A1A1A]
                                  file:text-xs file:font-bold file:uppercase file:tracking-[0.05em]
                                  file:bg-transparent file:text-[#1A1A1A]
                                  hover:file:bg-[#1A1A1A] hover:file:text-[#F5F5F0]
                                  file:transition-colors file:cursor-pointer cursor-pointer">
                    <p class="mt-1.5 text-xs text-[#717974]">JPG, PNG — maks 1MB</p>
                    @error('avatar')<p class="mt-1 text-xs text-[#BA1A1A] font-medium">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Fields --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2 space-y-1.5">
                    <label for="name" class="label">NAMA LENGKAP</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" class="input" required>
                    @error('name')<p class="mt-1 text-xs text-[#BA1A1A] font-medium">{{ $message }}</p>@enderror
                </div>
                <div class="space-y-1.5">
                    <label for="email" class="label">ALAMAT EMAIL</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" class="input" required>
                    @error('email')<p class="mt-1 text-xs text-[#BA1A1A] font-medium">{{ $message }}</p>@enderror
                </div>
                <div class="space-y-1.5">
                    <label for="phone" class="label">NO. TELEPON</label>
                    <input id="phone" type="tel" name="phone" value="{{ old('phone', $user->phone) }}" class="input" placeholder="08xxxxxxxxxx">
                    @error('phone')<p class="mt-1 text-xs text-[#BA1A1A] font-medium">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Role --}}
            <div class="flex items-center gap-3 pt-2 border-t border-[rgba(26,26,26,0.1)]">
                <span class="text-xs font-bold uppercase tracking-[0.05em] bg-[#0D3B2E] text-[#C6FF00] px-3 py-1">{{ strtoupper($user->role) }}</span>
                <span class="text-xs text-[#717974]">Role akun Anda</span>
            </div>

            <button type="submit" class="btn-primary w-full justify-center py-4 text-base">
                SIMPAN PERUBAHAN →
            </button>
        </form>

        {{-- Keamanan Akun --}}
        <div class="bg-white border border-[rgba(26,26,26,0.1)] p-8 mt-4">
            <h2 class="text-sm font-bold uppercase tracking-[0.05em] text-[#1A1A1A] mb-4">KEAMANAN AKUN</h2>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 p-5 bg-[#F5F5F0] border border-[rgba(26,26,26,0.1)]">
                <div>
                    <p class="text-sm font-bold uppercase tracking-[0.03em] text-[#1A1A1A]">PASSWORD</p>
                    <p class="text-xs text-[#717974] mt-0.5 leading-relaxed">
                        Kode verifikasi akan dikirim ke email sebelum mengubah password.
                    </p>
                </div>
                <form method="POST" action="{{ route('password.change.request') }}" class="shrink-0">
                    @csrf
                    <button type="submit" class="btn-forest py-2.5 px-5 text-xs">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/>
                        </svg>
                        GANTI PASSWORD
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
