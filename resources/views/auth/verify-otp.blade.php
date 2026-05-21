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
