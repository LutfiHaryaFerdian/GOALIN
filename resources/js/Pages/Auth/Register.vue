<template>
  <GuestLayout>
    <Head title="Buat Akun" />
    <div class="mb-6">
      <h1 class="text-2xl font-extrabold text-gray-900">Buat akun baru</h1>
      <p class="mt-1 text-sm text-gray-500">Bergabung dan mulai pesan lapangan olahraga</p>
    </div>

    <form @submit.prevent="submit" class="space-y-4">
      <!-- Role selector -->
      <div class="mb-2">
        <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 mb-3">Daftar sebagai</p>
        <div class="grid grid-cols-2 gap-3">
          <div v-for="r in roles" :key="r.value"
            @click="form.role = r.value"
            class="border-2 rounded-xl p-4 cursor-pointer transition-all duration-150 text-center select-none"
            :class="form.role === r.value
              ? 'border-primary bg-primary-light ring-2 ring-primary ring-offset-1'
              : 'border-gray-200 hover:border-primary'">
            <svg class="mx-auto mb-2 h-8 w-8 transition-colors" :class="form.role === r.value ? 'text-primary' : 'text-gray-300'"
              xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" :d="r.icon"/>
            </svg>
            <p class="font-semibold text-sm" :class="form.role === r.value ? 'text-primary' : 'text-gray-700'">{{ r.label }}</p>
            <p class="text-xs text-gray-400 mt-1 leading-snug">{{ r.desc }}</p>
          </div>
        </div>
        <p v-if="form.errors.role" class="mt-1.5 text-xs text-red-600">{{ form.errors.role }}</p>
      </div>

      <div class="relative py-1">
        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-100"/></div>
        <div class="relative flex justify-center"><span class="bg-white px-3 text-xs text-gray-400">Data Akun</span></div>
      </div>

      <AppInput v-model="form.name" id="name" label="Nama Lengkap" placeholder="Nama lengkap Anda"
        autocomplete="name" :error="form.errors.name" required />
      <AppInput v-model="form.email" id="email" type="email" label="Alamat Email" placeholder="nama@email.com"
        autocomplete="username" :error="form.errors.email" required />
      <AppInput v-model="form.phone" id="phone" type="tel" label="No. Telepon (opsional)" placeholder="08xxxxxxxxxx"
        autocomplete="tel" :error="form.errors.phone" />
      <AppInput v-model="form.password" id="password" type="password" label="Password" placeholder="Min. 8 karakter"
        autocomplete="new-password" :error="form.errors.password" required />
      <AppInput v-model="form.password_confirmation" id="password_confirmation" type="password"
        label="Konfirmasi Password" placeholder="Ulangi password"
        autocomplete="new-password" :error="form.errors.password_confirmation" required />

      <AppButton type="submit" variant="primary" size="lg" class="w-full mt-2" :loading="form.processing">Buat Akun</AppButton>

      <p class="text-center text-sm text-gray-500">
        Sudah punya akun?
        <Link :href="route('login')" class="font-semibold text-primary hover:text-primary-dark">Masuk di sini</Link>
      </p>
    </form>
  </GuestLayout>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import AppInput from '@/Components/UI/AppInput.vue';
import AppButton from '@/Components/UI/AppButton.vue';

const form = useForm({ name: '', email: '', phone: '', password: '', password_confirmation: '', role: 'user' });
const submit = () => form.post(route('register'), { onFinish: () => form.reset('password', 'password_confirmation') });

const roles = [
  { value: 'user',  label: 'Pemesan Lapangan',  desc: 'Cari dan pesan lapangan olahraga favoritmu',
    icon: 'M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z' },
  { value: 'owner', label: 'Pengelola Lapangan', desc: 'Daftarkan dan kelola lapangan olahraga milikmu',
    icon: 'M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614' },
];
</script>
