<template>
  <AppLayout>
    <Head title="Profil Saya" />
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
      <h1 class="text-2xl font-extrabold text-gray-900 mb-8">Profil Saya</h1>

      <form @submit.prevent="submit" enctype="multipart/form-data" class="card p-6 space-y-6">
        <!-- Avatar -->
        <div class="flex items-center gap-5 pb-6 border-b border-field">
          <div class="w-20 h-20 rounded-2xl bg-primary-light flex items-center justify-center overflow-hidden border-2 border-field">
            <img v-if="user.avatar" :src="user.avatar" class="w-full h-full object-cover" alt="Avatar">
            <span v-else class="text-3xl font-extrabold text-primary">{{ user.name?.[0]?.toUpperCase() }}</span>
          </div>
          <div>
            <p class="label mb-2">Foto Profil</p>
            <input type="file" name="avatar" accept="image/*" @change="onAvatar"
              class="text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary-light file:text-primary hover:file:bg-primary hover:file:text-white file:transition-colors file:cursor-pointer">
            <p v-if="form.errors.avatar" class="mt-1 text-xs text-red-600">{{ form.errors.avatar }}</p>
            <p class="mt-1.5 text-xs text-gray-400">JPG, PNG — maks 1MB</p>
          </div>
        </div>

        <!-- Fields -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
          <div class="sm:col-span-2">
            <label for="name" class="label">Nama Lengkap</label>
            <input id="name" v-model="form.name" type="text" class="input" required :class="{'border-red-400':form.errors.name}">
            <p v-if="form.errors.name" class="mt-1 text-xs text-red-600">{{ form.errors.name }}</p>
          </div>
          <div>
            <label for="email" class="label">Alamat Email</label>
            <input id="email" v-model="form.email" type="email" class="input" required :class="{'border-red-400':form.errors.email}">
            <p v-if="form.errors.email" class="mt-1 text-xs text-red-600">{{ form.errors.email }}</p>
          </div>
          <div>
            <label for="phone" class="label">No. Telepon</label>
            <input id="phone" v-model="form.phone" type="tel" class="input" placeholder="08xxxxxxxxxx" :class="{'border-red-400':form.errors.phone}">
            <p v-if="form.errors.phone" class="mt-1 text-xs text-red-600">{{ form.errors.phone }}</p>
          </div>
        </div>

        <!-- Role badge -->
        <div class="flex items-center gap-2 pt-2 border-t border-field">
          <svg class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
          </svg>
          <span class="text-sm text-gray-500">Role: <span class="font-semibold text-gray-900 capitalize">{{ user.role }}</span></span>
        </div>

        <AppButton type="submit" variant="primary" size="lg" class="w-full" :loading="form.processing">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
          Simpan Perubahan
        </AppButton>
      </form>

      <!-- Keamanan Akun -->
      <div class="card p-6 mt-6 space-y-4">
        <h2 class="text-base font-bold text-gray-900">Keamanan Akun</h2>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 p-4 rounded-xl bg-gray-50 border border-field">
          <div>
            <p class="text-sm font-semibold text-gray-800">Password</p>
            <p class="text-xs text-gray-500 mt-0.5">Kamu akan menerima kode verifikasi ke email sebelum bisa mengubah password.</p>
          </div>
          <form @submit.prevent="requestPasswordChange" class="flex-shrink-0">
            <AppButton type="submit" variant="primary" size="sm" :loading="requestingPw">
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
              Ganti Password
            </AppButton>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Head, useForm, router, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import AppButton from '@/Components/UI/AppButton.vue';

const page = usePage();
const user = computed(() => page.props.auth.user);

const form = useForm({ name: user.value?.name ?? '', email: user.value?.email ?? '', phone: user.value?.phone ?? '', avatar: null });

function onAvatar(e) { form.avatar = e.target.files[0]; }
const submit = () => form.post(route('profile.update'), { forceFormData: true });

const requestingPw = ref(false);
function requestPasswordChange() {
    requestingPw.value = true;
    router.post(route('password.change.request'), {}, { onFinish: () => { requestingPw.value = false; } });
}
</script>
