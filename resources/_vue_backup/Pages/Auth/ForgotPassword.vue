<template>
  <GuestLayout>
    <Head title="Lupa Password" />
    <div class="mb-8">
      <h1 class="text-2xl font-extrabold text-gray-900">Lupa Password</h1>
      <p class="mt-1 text-sm text-gray-500">Masukkan email Anda dan kami akan mengirim link reset.</p>
    </div>
    <div v-if="status" class="mb-4 text-sm text-primary bg-primary-light px-4 py-2.5 rounded-lg">{{ status }}</div>
    <form @submit.prevent="submit" class="space-y-5">
      <AppInput v-model="form.email" id="email" type="email" label="Email" placeholder="nama@email.com"
        autocomplete="username" :error="form.errors.email" required />
      <AppButton type="submit" variant="primary" size="lg" class="w-full" :loading="form.processing">Kirim Link Reset</AppButton>
      <p class="text-center text-sm text-gray-500">
        <Link :href="route('login')" class="font-semibold text-primary hover:text-primary-dark">Kembali ke Login</Link>
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
const form = useForm({ email: '' });
const submit = () => form.post(route('password.email'));
</script>
