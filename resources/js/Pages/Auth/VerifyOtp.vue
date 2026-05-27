<template>
  <GuestLayout>
    <Head :title="type === 'registration' ? 'Verifikasi Email' : 'Konfirmasi Identitas'" />

    <div class="mb-8">
      <h1 class="text-2xl font-extrabold text-gray-900">
        {{ type === 'registration' ? 'Verifikasi Email Kamu' : 'Konfirmasi Identitas Kamu' }}
      </h1>
      <p class="mt-1.5 text-sm text-gray-500">
        Kode verifikasi 6 digit telah dikirim ke<br>
        <span class="font-semibold text-gray-700">{{ maskedEmail }}</span>
      </p>
    </div>

    <!-- Flash info -->
    <div v-if="$page.props.flash?.info" class="mb-5 text-sm text-primary bg-primary-light px-4 py-3 rounded-lg flex items-center gap-2">
      <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
      </svg>
      {{ $page.props.flash.info }}
    </div>

    <!-- Validation error -->
    <div v-if="$page.props.errors?.code" class="mb-5 text-sm text-red-700 bg-red-50 border border-red-200 px-4 py-3 rounded-lg">
      {{ $page.props.errors.code }}
    </div>

    <!-- Role badge -->
    <div v-if="type === 'registration' && registerRole"
      class="mb-5 flex items-center gap-2.5 rounded-xl bg-primary-light px-4 py-2.5 text-sm text-primary border border-primary/20">
      <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" :d="registerRole === 'owner'
          ? 'M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614'
          : 'M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z'" />
      </svg>
      <span class="font-medium">Mendaftar sebagai <strong>{{ registerRole === 'owner' ? 'Pengelola Lapangan' : 'Pemesan Lapangan' }}</strong></span>
    </div>

    <!-- OTP boxes -->
    <div class="mb-6">
      <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-3 text-center">Masukkan Kode OTP</p>
      <div class="flex gap-2 sm:gap-3 justify-center">
        <input v-for="i in 6" :key="i"
          ref="inputRefs"
          type="text" inputmode="numeric" maxlength="1"
          @input="onInput($event, i-1)"
          @keydown="onKeydown($event, i-1)"
          @paste="onPaste($event)"
          class="w-12 h-14 text-center text-2xl font-mono font-bold border-2 rounded-xl transition-all duration-150
                 border-gray-200 bg-white text-gray-900 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
      </div>
    </div>

    <!-- Timer -->
    <div class="text-center mb-4">
      <p v-if="!expired" class="text-sm text-gray-400">
        Kode berlaku selama <span class="font-semibold text-gray-600 tabular-nums">{{ timerDisplay }}</span> menit
      </p>
      <p v-else class="text-sm text-red-500 font-medium">Kode OTP sudah kadaluarsa. Silakan minta kode baru.</p>
    </div>

    <!-- Verify button -->
    <form :action="verifyAction" method="POST" ref="verifyForm">
      <input type="hidden" name="_token" :value="csrfToken">
      <input type="hidden" name="code" :value="code">
      <AppButton type="submit" variant="primary" size="lg" class="w-full mb-3" :disabled="expired || code.length < 6">
        Verifikasi Kode
      </AppButton>
    </form>

    <!-- Resend -->
    <form :action="resendAction" method="POST">
      <input type="hidden" name="_token" :value="csrfToken">
      <AppButton type="submit" variant="secondary" size="lg" class="w-full" :disabled="!expired">Kirim Ulang Kode</AppButton>
    </form>

    <p class="mt-6 text-center text-sm text-gray-500">
      <Link :href="type === 'registration' ? route('register') : route('profile.edit')"
        class="font-semibold text-gray-700 hover:text-primary transition-colors">
        {{ type === 'registration' ? 'Kembali ke Registrasi' : 'Batal' }}
      </Link>
    </p>
  </GuestLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import AppButton from '@/Components/UI/AppButton.vue';

const props = defineProps({
    type:         { type: String, required: true },
    email:        { type: String, required: true },
    registerRole: { type: String, default: '' },
});

const csrfToken  = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
const verifyAction = computed(() => props.type === 'registration' ? '/register/verify' : '/password/change/verify');
const resendAction = computed(() => props.type === 'registration' ? '/register/resend-otp' : '/password/change/resend-otp');

const maskedEmail = computed(() => {
    const [name, domain] = props.email.split('@');
    return (name?.slice(0,2) ?? '') + '*'.repeat(Math.max(0, (name?.length ?? 0) - 2)) + '@' + domain;
});

// OTP inputs
const inputRefs = ref([]);
const digits    = ref(['','','','','','']);
const code      = computed(() => digits.value.join(''));
const verifyForm = ref(null);

onMounted(() => { inputRefs.value[0]?.focus(); });

function onInput(e, idx) {
    const val = e.target.value.replace(/\D/g,'').slice(-1);
    e.target.value = val;
    digits.value[idx] = val;
    if (val && idx < 5) inputRefs.value[idx+1]?.focus();
    if (code.value.length === 6) setTimeout(() => verifyForm.value?.submit(), 80);
}

function onKeydown(e, idx) {
    if (e.key === 'Backspace' && !digits.value[idx] && idx > 0) {
        digits.value[idx-1] = '';
        inputRefs.value[idx-1].value = '';
        inputRefs.value[idx-1]?.focus();
    }
    if (e.key === 'ArrowLeft' && idx > 0) inputRefs.value[idx-1]?.focus();
    if (e.key === 'ArrowRight' && idx < 5) inputRefs.value[idx+1]?.focus();
}

function onPaste(e) {
    e.preventDefault();
    const paste = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g,'').slice(0,6);
    paste.split('').forEach((ch, i) => {
        digits.value[i] = ch;
        if (inputRefs.value[i]) inputRefs.value[i].value = ch;
    });
    inputRefs.value[Math.min(paste.length, 5)]?.focus();
    if (paste.length === 6) setTimeout(() => verifyForm.value?.submit(), 80);
}

// Timer
const timer   = ref(600);
const expired = ref(false);
const timerDisplay = computed(() => {
    const m = Math.floor(timer.value / 60);
    const s = timer.value % 60;
    return `${m}:${String(s).padStart(2,'0')}`;
});

onMounted(() => {
    const iv = setInterval(() => {
        if (timer.value <= 0) { clearInterval(iv); expired.value = true; return; }
        timer.value--;
    }, 1000);
});
</script>
