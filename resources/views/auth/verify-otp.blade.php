<x-guest-layout>
    <x-slot name="title">
        {{ $type === 'registration' ? 'Verifikasi Email' : 'Konfirmasi Identitas' }}
    </x-slot>

    <div class="mb-8">
        <p class="section-label mb-3">KEAMANAN AKUN</p>
        <h1 class="font-display text-[40px] font-extrabold uppercase leading-[40px] tracking-[-0.01em] text-[#1A1A1A]">
            {{ $type === 'registration' ? 'VERIFIKASI EMAIL.' : 'KONFIRMASI IDENTITAS.' }}
        </h1>
        <p class="mt-3 text-sm text-[#717974]">
            Kode 6 digit dikirim ke
            <span class="font-bold text-[#1A1A1A]">
                @php
                    $parts = explode('@', $email);
                    $name = $parts[0] ?? '';
                    $domain = $parts[1] ?? '';
                    echo e(substr($name,0,2) . str_repeat('*', max(0,strlen($name)-2)) . '@' . $domain);
                @endphp
            </span>
        </p>
    </div>

    @if(session('info'))
        <div class="mb-5 text-xs font-bold uppercase tracking-[0.05em] bg-[#C6FF00] text-[#1A1A1A] px-4 py-3">
            {{ session('info') }}
        </div>
    @endif
    @if($errors->has('code'))
        <div class="mb-5 text-xs font-bold uppercase tracking-[0.05em] bg-[#BA1A1A] text-white px-4 py-3">
            {{ $errors->first('code') }}
        </div>
    @endif

    <div x-data="{
        timer: 600,
        timerDisplay: '10:00',
        expired: false,
        init() {
            this.$nextTick(() => document.getElementById('otp0').focus());
            const iv = setInterval(() => {
                if (this.timer <= 0) { clearInterval(iv); this.expired = true; this.timerDisplay = '0:00'; return; }
                this.timer--;
                const m = Math.floor(this.timer/60);
                const s = this.timer%60;
                this.timerDisplay = m + ':' + String(s).padStart(2,'0');
            }, 1000);
        }
    }">
        <form id="otpForm" method="POST"
              action="{{ $type === 'registration' ? route('register.verify.submit') : route('password.change.verify.submit') }}"
              class="space-y-6">
            @csrf
            <input type="hidden" name="code" id="otpHidden" value="">

            {{-- 6 OTP boxes --}}
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.1em] text-[#717974] mb-4 text-center">MASUKKAN KODE OTP</p>
                <div id="otpInputs" class="flex gap-2 sm:gap-3 justify-center">
                    @for($i = 0; $i < 6; $i++)
                        <input id="otp{{ $i }}" type="text" inputmode="numeric" maxlength="1"
                               data-index="{{ $i }}"
                               class="otp-digit w-12 h-14 text-center font-display text-2xl font-bold border-2 border-[#1A1A1A] bg-white text-[#1A1A1A] focus:outline-none focus:border-b-[3px] focus:border-b-[#C6FF00] transition-all"
                               autocomplete="{{ $i === 0 ? 'one-time-code' : 'off' }}">
                    @endfor
                </div>
            </div>

            {{-- Timer --}}
            <div class="text-center">
                <p class="text-sm text-[#717974]" x-show="!expired">
                    Berlaku selama <span class="font-bold text-[#1A1A1A] tabular-nums" x-text="timerDisplay"></span>
                </p>
                <p class="text-sm font-bold text-[#BA1A1A] uppercase tracking-[0.05em]" x-show="expired" x-cloak>
                    Kode sudah kadaluarsa.
                </p>
            </div>

            <button id="otpSubmitBtn" type="submit" :disabled="expired"
                    class="w-full btn-primary justify-center py-4 text-base disabled:opacity-40 disabled:cursor-not-allowed">
                VERIFIKASI KODE
            </button>
        </form>

        <form method="POST"
              action="{{ $type === 'registration' ? route('register.resend-otp') : route('password.change.resend-otp') }}"
              class="mt-3">
            @csrf
            <button type="submit" :disabled="!expired"
                    class="w-full btn-ghost justify-center py-3 text-sm disabled:opacity-40 disabled:cursor-not-allowed">
                KIRIM ULANG KODE
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-[#717974]">
            @if($type === 'registration')
                <a href="{{ route('register') }}" class="font-bold text-[#1A1A1A] hover:text-[#0D3B2E] transition-colors">← Kembali ke Registrasi</a>
            @else
                <a href="{{ route('profile.edit') }}" class="font-bold text-[#1A1A1A] hover:text-[#0D3B2E] transition-colors">Batal</a>
            @endif
        </p>
    </div>

    <script>
    (function(){
        const inputs = document.querySelectorAll('.otp-digit');
        const hidden = document.getElementById('otpHidden');
        const form   = document.getElementById('otpForm');
        function getCode(){ return Array.from(inputs).map(i=>i.value).join(''); }
        function updateHidden(){ hidden.value = getCode(); }
        inputs.forEach((input,idx) => {
            input.addEventListener('input', function(){
                this.value = this.value.replace(/\D/g,'').slice(-1);
                updateHidden();
                if(this.value && idx < 5) inputs[idx+1].focus();
                if(getCode().length === 6) setTimeout(() => form.submit(), 80);
            });
            input.addEventListener('keydown', function(e){
                if(e.key==='Backspace' && !this.value && idx>0){ inputs[idx-1].value=''; inputs[idx-1].focus(); updateHidden(); }
                if(e.key==='ArrowLeft' && idx>0) inputs[idx-1].focus();
                if(e.key==='ArrowRight' && idx<5) inputs[idx+1].focus();
            });
            input.addEventListener('paste', function(e){
                e.preventDefault();
                const paste = (e.clipboardData||window.clipboardData).getData('text').replace(/\D/g,'').slice(0,6);
                paste.split('').forEach((ch,i)=>{ if(inputs[i]) inputs[i].value=ch; });
                updateHidden();
                inputs[Math.min(paste.length,5)].focus();
                if(paste.length===6) setTimeout(()=>form.submit(),80);
            });
        });
    })();
    </script>
</x-guest-layout>
