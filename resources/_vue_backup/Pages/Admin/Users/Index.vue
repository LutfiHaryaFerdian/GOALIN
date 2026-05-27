<template>
  <AppLayout>
    <Head title="Kelola Pengguna" />
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="flex gap-6">
        <AppSidebar section="admin" />
        <main class="flex-1 min-w-0">
          <div class="flex items-center justify-between mb-8">
            <div><p class="section-label">Admin Panel</p><h1 class="text-2xl font-extrabold text-gray-900">Kelola Pengguna</h1></div>
          </div>

          <form class="flex flex-wrap gap-3 mb-6" @submit.prevent="applyFilter">
            <div class="flex items-center gap-2 border border-gray-200 rounded-lg px-3 py-2 focus-within:ring-2 focus-within:ring-primary flex-1 min-w-48 bg-white">
              <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 15.803a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
              <input v-model="f.search" type="text" placeholder="Cari nama atau email..." class="flex-1 text-sm outline-none bg-transparent text-gray-700 placeholder-gray-400">
            </div>
            <select v-model="f.role" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary outline-none bg-white">
              <option value="">Semua Role</option>
              <option value="user">User</option>
              <option value="owner">Owner</option>
              <option value="admin">Admin</option>
            </select>
            <button type="submit" class="btn-primary py-2 px-4 text-sm flex items-center gap-2">
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432"/></svg>
              Filter
            </button>
          </form>

          <div class="card overflow-hidden">
            <table class="w-full text-sm">
              <thead>
                <tr class="border-b border-field bg-accent">
                  <th class="text-left px-5 py-3">Pengguna</th>
                  <th class="text-left px-5 py-3">Email</th>
                  <th class="text-left px-5 py-3 hidden md:table-cell">Telepon</th>
                  <th class="text-left px-5 py-3">Role</th>
                  <th class="text-left px-5 py-3 hidden sm:table-cell">Bergabung</th>
                  <th class="text-left px-5 py-3">Aksi</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-field">
                <tr v-for="u in users.data" :key="u.id" class="hover:bg-accent transition-colors">
                  <td class="px-5 py-3">
                    <div class="flex items-center gap-2.5">
                      <div class="w-8 h-8 rounded-lg bg-primary-light flex items-center justify-center text-xs font-bold text-primary shrink-0">{{ u.name[0]?.toUpperCase() }}</div>
                      <span class="font-semibold text-gray-900 text-xs">{{ u.name }}</span>
                    </div>
                  </td>
                  <td class="px-5 py-3 text-xs text-gray-500">{{ u.email }}</td>
                  <td class="px-5 py-3 text-xs text-gray-400 hidden md:table-cell">{{ u.phone ?? '—' }}</td>
                  <td class="px-5 py-3">
                    <span class="rounded-full px-2.5 py-0.5 text-xs font-semibold" :class="roleColors[u.role] ?? 'bg-gray-100 text-gray-600'">{{ u.role }}</span>
                  </td>
                  <td class="px-5 py-3 text-xs text-gray-400 hidden sm:table-cell">{{ fmtDate(u.created_at) }}</td>
                  <td class="px-5 py-3">
                    <div class="flex items-center gap-1.5">
                      <Link :href="route('admin.users.edit', u.id)" class="p-1.5 rounded-lg hover:bg-primary-light text-gray-400 hover:text-primary transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/></svg>
                      </Link>
                      <button v-if="u.id !== authUser?.id" @click="deleteUser(u.id)" class="p-1.5 rounded-lg hover:bg-red-50 text-gray-400 hover:text-red-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                      </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="mt-6"><AppPagination :links="users.links" /></div>
        </main>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { reactive, computed } from 'vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import AppSidebar from '@/Components/UI/AppSidebar.vue';
import AppPagination from '@/Components/UI/AppPagination.vue';

const props = defineProps({ users: Object, filters: { type: Object, default: () => ({}) } });
const page    = usePage();
const authUser = computed(() => page.props.auth.user);
const roleColors = { user:'bg-gray-100 text-gray-600', owner:'bg-blue-50 text-blue-600', admin:'bg-primary-light text-primary' };
const f = reactive({ search: props.filters?.search ?? '', role: props.filters?.role ?? '' });
const fmtDate = (d) => d ? new Date(d).toLocaleDateString('id-ID',{day:'numeric',month:'short',year:'numeric'}) : '-';
const applyFilter = () => router.get(route('admin.users.index'), { ...f }, { preserveState: true });
const deleteUser  = (id) => { if (confirm('Hapus pengguna ini?')) router.delete(route('admin.users.destroy', id)); };
</script>
