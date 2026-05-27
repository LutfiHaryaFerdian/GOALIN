<template>
  <GuestLayout>
    <Head title="Ganti Password" />
    <div class="mb-8">
      <h1 class="text-2xl font-extrabold text-gray-900">Ganti Password</h1>
      <p class="mt-1 text-sm text-gray-500">Masukkan password baru untuk akun Anda.</p>
    </div>
    <form @submit.prevent="submit" class="space-y-5">
      <AppInput v-model="form.password" id="password" type="password" label="Password Baru"
        placeholder="Min. 8 karakter" autocomplete="new-password" :error="form.errors.password" required />
      <AppInput v-model="form.password_confirmation" id="password_confirmation" type="password"
        label="Konfirmasi Password Baru" placeholder="Ulangi password"
        autocomplete="new-password" :error="form.errors.password_confirmation" required />
      <AppButton type="submit" variant="primary" size="lg" class="w-full" :loading="form.processing">Simpan Password</AppButton>
      <p class="text-center text-sm">
        <Link :href="route('profile.edit')" class="text-gray-500 hover:text-primary">Batal</Link>
      </p>
    </form>
  </GuestLayout>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import AppInput from '@/Components/UI/AppInput.vue';
import AppButton from '@/Components/UI/AppButton.vue';

const form = useForm({ password: '', password_confirmation: '' });
const submit = () => form.post(route('password.change.update'), { onFinish: () => form.reset() });
</script>
