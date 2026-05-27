<template>
  <GuestLayout>
    <Head title="Reset Password" />
    <div class="mb-8">
      <h1 class="text-2xl font-extrabold text-gray-900">Reset Password</h1>
      <p class="mt-1 text-sm text-gray-500">Buat password baru untuk akun Anda.</p>
    </div>
    <form @submit.prevent="submit" class="space-y-5">
      <AppInput v-model="form.email" id="email" type="email" label="Email" :error="form.errors.email" required />
      <AppInput v-model="form.password" id="password" type="password" label="Password Baru"
        placeholder="Min. 8 karakter" autocomplete="new-password" :error="form.errors.password" required />
      <AppInput v-model="form.password_confirmation" id="password_confirmation" type="password"
        label="Konfirmasi Password" placeholder="Ulangi password baru"
        autocomplete="new-password" :error="form.errors.password_confirmation" required />
      <AppButton type="submit" variant="primary" size="lg" class="w-full" :loading="form.processing">Reset Password</AppButton>
    </form>
  </GuestLayout>
</template>

<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import AppInput from '@/Components/UI/AppInput.vue';
import AppButton from '@/Components/UI/AppButton.vue';

const props = defineProps({ token: String, email: String });
const form = useForm({ token: props.token, email: props.email ?? '', password: '', password_confirmation: '' });
const submit = () => form.post(route('password.store'), { onFinish: () => form.reset('password','password_confirmation') });
</script>
