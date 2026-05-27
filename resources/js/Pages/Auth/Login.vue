<template>
  <GuestLayout>
    <Head title="Masuk" />
    <div class="mb-8">
      <h1 class="text-2xl font-extrabold text-gray-900">Selamat datang kembali</h1>
      <p class="mt-1 text-sm text-gray-500">Masuk untuk melanjutkan ke GOALIN</p>
    </div>

    <div v-if="status" class="mb-4 text-sm text-primary bg-primary-light px-4 py-2.5 rounded-lg">{{ status }}</div>

    <form @submit.prevent="submit" class="space-y-5">
      <AppInput v-model="form.email" id="email" type="email" label="Email" placeholder="nama@email.com"
        autocomplete="username" :error="form.errors.email" required />

      <div>
        <div class="flex items-center justify-between mb-1.5">
          <label for="password" class="label">Password</label>
          <Link :href="route('password.request')" class="text-xs font-medium text-primary hover:text-primary-dark">Lupa password?</Link>
        </div>
        <input id="password" v-model="form.password" type="password" autocomplete="current-password"
          placeholder="••••••••" class="input" :class="{ 'border-red-400': form.errors.password }" required>
        <p v-if="form.errors.password" class="mt-1 text-xs text-red-600">{{ form.errors.password }}</p>
      </div>

      <div class="flex items-center gap-2">
        <input id="remember" v-model="form.remember" type="checkbox" class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary">
        <label for="remember" class="text-sm text-gray-600">Ingat saya</label>
      </div>

      <AppButton type="submit" variant="primary" size="lg" class="w-full" :loading="form.processing">
        Masuk
      </AppButton>

      <p class="text-center text-sm text-gray-500">
        Belum punya akun?
        <Link :href="route('register')" class="font-semibold text-primary hover:text-primary-dark">Daftar gratis</Link>
      </p>
    </form>
  </GuestLayout>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import AppInput from '@/Components/UI/AppInput.vue';
import AppButton from '@/Components/UI/AppButton.vue';

defineProps({ status: String });

const form = useForm({ email: '', password: '', remember: false });
const submit = () => form.post(route('login'), { onFinish: () => form.reset('password') });
</script>
