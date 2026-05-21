<x-guest-layout>
    <x-slot name="title">Ganti Password</x-slot>

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-extrabold text-gray-900">Buat Password Baru</h1>
        <p class="mt-1.5 text-sm text-gray-500">Masukkan password baru yang kuat untuk akun kamu.</p>
    </div>

    {{-- Flash messages --}}
    @if (session('success'))
        <div class="mb-5 text-sm text-primary bg-primary-light px-4 py-3 rounded-lg flex items-center gap-2">
            <x-icon name="check" class="w-4 h-4 flex-shrink-0" />
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-5 text-sm text-red-700 bg-red-50 border border-red-200 px-4 py-3 rounded-lg">
            {{ $errors->first() }}
        </div>
    @endif

    <form
        method="POST"
        action="{{ route('password.change.update') }}"
        class="space-y-5"
        x-data="{
            password: '',
            passwordConfirm: '',
            showPass: false,
            showConfirm: false,
            get strength() {
                const p = this.password;
                if (p.length === 0) return 0;
                let score = 0;
                if (p.length >= 8)  score++;
                if (/[A-Z]/.test(p)) score++;
                if (/[0-9]/.test(p)) score++;
                if (/[^A-Za-z0-9]/.test(p)) score++;
                return score;
            },
            get strengthLabel() {
                return ['', 'Lemah', 'Cukup', 'Kuat', 'Sangat Kuat'][this.strength] ?? '';
            },
            get strengthColor() {
                return ['', 'bg-red-400', 'bg-yellow-400', 'bg-primary', 'bg-primary'][this.strength] ?? '';
            },
            get strengthTextColor() {
                return ['', 'text-red-500', 'text-yellow-600', 'text-primary', 'text-primary'][this.strength] ?? '';
            },
        }"
    >
        @csrf

        {{-- Password Baru --}}
        <div>
            <label for="password" class="label">Password Baru</label>
            <div class="relative">
                <input
                    id="password"
                    :type="showPass ? 'text' : 'password'"
                    name="password"
                    x-model="password"
                    required
                    autocomplete="new-password"
                    placeholder="Min. 8 karakter"
                    class="input pr-10"
                >
                <button
                    type="button"
                    @click="showPass = !showPass"
                    class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-gray-600"
                    tabindex="-1"
                >
                    <x-icon name="eye" class="w-4 h-4" />
                </button>
            </div>

            {{-- Password strength indicator --}}
            <div class="mt-2" x-show="password.length > 0" x-cloak>
                <div class="flex gap-1 mb-1">
                    <template x-for="i in 4" :key="i">
                        <div
                            class="flex-1 h-1 rounded-full transition-all duration-300"
                            :class="i <= strength ? strengthColor : 'bg-gray-200'"
                        ></div>
                    </template>
                </div>
                <p class="text-xs font-medium" :class="strengthTextColor" x-text="strengthLabel"></p>
            </div>

            @error('password')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Konfirmasi Password --}}
        <div>
            <label for="password_confirmation" class="label">Konfirmasi Password Baru</label>
            <div class="relative">
                <input
                    id="password_confirmation"
                    :type="showConfirm ? 'text' : 'password'"
                    name="password_confirmation"
                    x-model="passwordConfirm"
                    required
                    autocomplete="new-password"
                    placeholder="Ulangi password baru"
                    class="input pr-10"
                >
                <button
                    type="button"
                    @click="showConfirm = !showConfirm"
                    class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-gray-600"
                    tabindex="-1"
                >
                    <x-icon name="eye" class="w-4 h-4" />
                </button>
            </div>

            {{-- Match indicator --}}
            <div class="mt-1.5" x-show="passwordConfirm.length > 0" x-cloak>
                <p
                    class="text-xs font-medium"
                    :class="password === passwordConfirm ? 'text-primary' : 'text-red-500'"
                    x-text="password === passwordConfirm ? 'Password cocok' : 'Password tidak cocok'"
                ></p>
            </div>

            @error('password_confirmation')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit --}}
        <button
            type="submit"
            class="w-full flex items-center justify-center gap-2 py-3 px-4
                   bg-primary text-white font-semibold rounded-xl
                   hover:bg-primary-dark transition-colors mt-2"
        >
            <x-icon name="check" class="w-4 h-4" />
            Simpan Password Baru
        </button>

        <p class="text-center text-sm text-gray-500">
            <a href="{{ route('profile.edit') }}" class="font-semibold text-gray-700 hover:text-primary transition-colors">
                Batal
            </a>
        </p>
    </form>
</x-guest-layout>
