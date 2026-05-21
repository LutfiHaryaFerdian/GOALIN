<x-guest-layout>
    <x-slot name="title">
        {{ $type === 'registration' ? 'Verifikasi Email' : 'Konfirmasi Identitas' }}
    </x-slot>

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-extrabold text-gray-900">
            {{ $type === 'registration' ? 'Verifikasi Email Kamu' : 'Konfirmasi Identitas Kamu' }}
        </h1>
        <p class="mt-1.5 text-sm text-gray-500">
            Kode verifikasi 6 digit telah dikirim ke<br>
            <span class="font-semibold text-gray-700">
                @php
                    $parts  = explode('@', $email);
                    $name   = $parts[0] ?? '';
                    $domain = $parts[1] ?? '';
                    $masked = substr($name, 0, 2) . str_repeat('*', max(0, strlen($name) - 2));
                    echo e($masked . '@' . $domain);
                @endphp
            </span>
        </p>
    </div>

    {{-- Flash messages --}}
    @if (session('info'))
        <div class="mb-5 text-sm text-primary bg-primary-light px-4 py-3 rounded-lg flex items-center gap-2">
            <x-icon name="check" class="w-4 h-4 flex-shrink-0" />
            {{ session('info') }}
        </div>
    @endif

    @if ($errors->has('code'))
        <div class="mb-5 text-sm text-red-700 bg-red-50 border border-red-200 px-4 py-3 rounded-lg">
            {{ $errors->first('code') }}
        </div>
    @endif

    {{-- Badge konfirmasi role (khusus flow registrasi) --}}
    @if ($type === 'registration' && session('register_data'))
        @php $regRole = session('register_data.role', 'user'); @endphp
        <div class="mb-5 flex items-center gap-2.5 rounded-xl bg-primary-light px-4 py-2.5 text-sm text-primary border border-primary/20">
            @if ($regRole === 'owner')
                <svg class="h-4 w-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z"/>
                </svg>
                <span class="font-medium">Mendaftar sebagai <strong>Pengelola Lapangan</strong></span>
            @else
                <svg class="h-4 w-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                </svg>
                <span class="font-medium">Mendaftar sebagai <strong>Pemesan Lapangan</strong></span>
            @endif
        </div>
    @endif

    {{-- OTP Form --}}
    <div
        x-data="{
            timer: 600,
            timerDisplay: '10:00',
            expired: false,
            init() {
                this.$nextTick(() => document.getElementById('otp0').focus());
                const iv = setInterval(() => {
                    if (this.timer <= 0) {
                        clearInterval(iv);
                        this.expired = true;
                        this.timerDisplay = '0:00';
                        return;
                    }
                    this.timer--;
                    const m = Math.floor(this.timer / 60);
                    const s = this.timer % 60;
                    this.timerDisplay = m + ':' + String(s).padStart(2, '0');
                }, 1000);
            }
        }"
    >
        {{-- OTP Action Form --}}
        <form
            id="otpForm"
            method="POST"
            action="{{ $type === 'registration' ? route('register.verify.submit') : route('password.change.verify.submit') }}"
            class="space-y-6"
        >
            @csrf
            <input type="hidden" name="code" id="otpHidden" value="">

            {{-- 6 kotak OTP --}}
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-3 text-center">Masukkan Kode OTP</p>
                <div id="otpInputs" class="flex gap-2 sm:gap-3 justify-center">
                    @for ($i = 0; $i < 6; $i++)
                        <input
                            id="otp{{ $i }}"
                            type="text"
                            inputmode="numeric"
                            maxlength="1"
                            data-index="{{ $i }}"
                            class="otp-digit w-12 h-14 text-center text-2xl font-mono font-bold border-2 rounded-xl transition-all duration-150
                                   border-gray-200 bg-white text-gray-900
                                   focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20
                                   hover:border-gray-300"
                            autocomplete="{{ $i === 0 ? 'one-time-code' : 'off' }}"
                        >
                    @endfor
                </div>
            </div>

            {{-- Timer --}}
            <div class="text-center">
                <p class="text-sm text-gray-400" x-show="!expired">
                    Kode berlaku selama
                    <span class="font-semibold text-gray-600 tabular-nums" x-text="timerDisplay"></span>
                    menit
                </p>
                <p class="text-sm text-red-500 font-medium" x-show="expired" x-cloak>
                    Kode OTP sudah kadaluarsa. Silakan minta kode baru.
                </p>
            </div>

            {{-- Submit button --}}
            <button
                id="otpSubmitBtn"
                type="submit"
                :disabled="expired"
                class="w-full flex items-center justify-center gap-2 py-3 px-4
                       bg-primary text-white font-semibold rounded-xl
                       hover:bg-primary-dark transition-colors
                       disabled:opacity-40 disabled:cursor-not-allowed"
            >
                <x-icon name="check" class="w-4 h-4" />
                Verifikasi Kode
            </button>
        </form>

        {{-- Resend OTP Form --}}
        <form
            method="POST"
            action="{{ $type === 'registration' ? route('register.resend-otp') : route('password.change.resend-otp') }}"
            class="mt-4"
        >
            @csrf
            <button
                type="submit"
                :disabled="!expired"
                class="w-full text-center text-sm py-2.5 rounded-xl border-2 transition-all duration-150
                       border-gray-200 text-gray-400
                       disabled:opacity-40 disabled:cursor-not-allowed"
                :class="expired ? 'border-primary text-primary hover:bg-primary-light cursor-pointer' : ''"
            >
                Kirim Ulang Kode
            </button>
        </form>

        {{-- Back link --}}
        <p class="mt-6 text-center text-sm text-gray-500">
            @if ($type === 'registration')
                <a href="{{ route('register') }}" class="font-semibold text-gray-700 hover:text-primary transition-colors">
                    Kembali ke Registrasi
                </a>
            @else
                <a href="{{ route('profile.edit') }}" class="font-semibold text-gray-700 hover:text-primary transition-colors">
                    Batal
                </a>
            @endif
        </p>
    </div>

    <script>
    (function () {
        const inputs = document.querySelectorAll('.otp-digit');
        const hidden = document.getElementById('otpHidden');
        const form   = document.getElementById('otpForm');

        function getCode() {
            return Array.from(inputs).map(i => i.value).join('');
        }

        function updateHidden() {
            hidden.value = getCode();
        }

        inputs.forEach((input, idx) => {
            // Only allow digits
            input.addEventListener('input', function (e) {
                const val = this.value.replace(/\D/g, '');
                this.value = val.slice(-1);
                updateHidden();
                if (this.value && idx < 5) {
                    inputs[idx + 1].focus();
                }
                // Auto-submit when all filled
                if (getCode().length === 6) {
                    setTimeout(() => form.submit(), 80);
                }
            });

            input.addEventListener('keydown', function (e) {
                if (e.key === 'Backspace' && !this.value && idx > 0) {
                    inputs[idx - 1].value = '';
                    inputs[idx - 1].focus();
                    updateHidden();
                }
                if (e.key === 'ArrowLeft' && idx > 0)  inputs[idx - 1].focus();
                if (e.key === 'ArrowRight' && idx < 5) inputs[idx + 1].focus();
            });

            // Paste support on first box
            input.addEventListener('paste', function (e) {
                e.preventDefault();
                const paste = (e.clipboardData || window.clipboardData)
                    .getData('text').replace(/\D/g, '').slice(0, 6);
                paste.split('').forEach((ch, i) => {
                    if (inputs[i]) inputs[i].value = ch;
                });
                updateHidden();
                const next = Math.min(paste.length, 5);
                inputs[next].focus();
                if (paste.length === 6) {
                    setTimeout(() => form.submit(), 80);
                }
            });
        });
    })();
    </script>
</x-guest-layout>
