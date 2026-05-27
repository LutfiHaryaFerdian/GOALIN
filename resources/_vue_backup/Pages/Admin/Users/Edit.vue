<template>
  <AppLayout>
    <Head title="Edit Pengguna" />
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="flex gap-6">
        <AppSidebar section="admin" />
        <main class="flex-1 min-w-0">
          <div class="flex items-center gap-3 mb-8">
            <Link :href="route('admin.users.index')" class="p-2 rounded-lg hover:bg-primary-light text-gray-400 hover:text-primary transition-colors">
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
            </Link>
            <div><p class="section-label">Admin Panel</p><h1 class="text-2xl font-extrabold text-gray-900">Edit Pengguna</h1></div>
          </div>

          <form @submit.prevent="submit" class="card p-6 space-y-5 max-w-xl">
            <div>
              <label class="label">Nama</label>
              <input v-model="form.name" type="text" class="input" required :class="{'border-red-400':form.errors.name}">
              <p v-if="form.errors.name" class="mt-1 text-xs text-red-600">{{ form.errors.name }}</p>
            </div>
            <div>
              <label class="label">No. Telepon</label>
              <input v-model="form.phone" type="text" class="input" placeholder="08xxxxxxxxxx" :class="{'border-red-400':form.errors.phone}">
              <p v-if="form.errors.phone" class="mt-1 text-xs text-red-600">{{ form.errors.phone }}</p>
            </div>
            <div>
              <label class="label">Role</label>
              <select v-model="form.role" class="input" required :class="{'border-red-400':form.errors.role}">
                <option value="user">User</option>
                <option value="owner">Owner</option>
                <option value="admin">Admin</option>
              </select>
              <p v-if="form.errors.role" class="mt-1 text-xs text-red-600">{{ form.errors.role }}</p>
            </div>
            <div class="flex gap-3 pt-2 border-t border-field">
              <Link :href="route('admin.users.index')" class="btn-secondary flex-1 justify-center text-center">Batal</Link>
              <AppButton type="submit" variant="primary" class="flex-1 justify-center" :loading="form.processing">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                Simpan
              </AppButton>
            </div>
          </form>
        </main>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import AppSidebar from '@/Components/UI/AppSidebar.vue';
import AppButton from '@/Components/UI/AppButton.vue';

const props = defineProps({ user: { type: Object, required: true } });
const form  = useForm({ name: props.user.name, phone: props.user.phone ?? '', role: props.user.role });
const submit = () => form.patch(route('admin.users.update', props.user.id));
</script>
