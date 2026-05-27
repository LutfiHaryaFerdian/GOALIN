<template>
  <AppLayout>
    <Head title="Semua Pemesanan" />
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="flex gap-6">
        <AppSidebar section="admin" />
        <main class="flex-1 min-w-0">
          <div class="flex items-center justify-between mb-8">
            <div><p class="section-label">Admin Panel</p><h1 class="text-2xl font-extrabold text-gray-900">Semua Pemesanan</h1></div>
            <form class="flex gap-2" @submit.prevent="applyFilter">
              <div class="flex items-center gap-2 border border-gray-200 rounded-lg px-3 py-2 bg-white">
                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 15.803a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
                <input v-model="f.search" type="text" placeholder="Kode booking..." class="text-sm outline-none bg-transparent w-32 text-gray-700 placeholder-gray-400">
              </div>
              <select v-model="f.status" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary outline-none bg-white">
                <option value="">Semua Status</option>
                <option v-for="(l,v) in statusMap" :key="v" :value="v">{{ l }}</option>
              </select>
              <button type="submit" class="btn-primary py-2 px-4 text-sm flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432"/></svg>
              </button>
            </form>
          </div>

          <div class="card overflow-hidden">
            <table class="w-full text-sm">
              <thead>
                <tr class="border-b border-field bg-accent">
                  <th class="text-left px-5 py-3">Kode</th>
                  <th class="text-left px-5 py-3">Pengguna</th>
                  <th class="text-left px-5 py-3">Lapangan</th>
                  <th class="text-left px-5 py-3 hidden md:table-cell">Tanggal</th>
                  <th class="text-left px-5 py-3 hidden sm:table-cell">Total</th>
                  <th class="text-left px-5 py-3">Status</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-field">
                <template v-if="bookings.data.length">
                  <tr v-for="b in bookings.data" :key="b.id"
                    class="hover:bg-accent transition-colors cursor-pointer"
                    @click="router.visit(route('admin.bookings.show', b.id))">
                    <td class="px-5 py-3 font-mono text-xs text-gray-400">{{ b.booking_code }}</td>
                    <td class="px-5 py-3 text-xs font-semibold text-gray-900">{{ b.user.name }}</td>
                    <td class="px-5 py-3 text-xs text-gray-600">{{ b.field.name }}</td>
                    <td class="px-5 py-3 text-xs text-gray-400 hidden md:table-cell">{{ fmtDate(b.booking_date) }}</td>
                    <td class="px-5 py-3 text-xs font-bold text-gray-900 hidden sm:table-cell">Rp {{ fmt(b.total_price) }}</td>
                    <td class="px-5 py-3">
                      <div class="flex items-center gap-2">
                        <AppBadge :status="b.status" />
                        <span v-if="b.payment_status === 'paid'" class="hidden lg:inline-flex items-center rounded-full bg-green-100 px-2 py-0.5 text-xs font-semibold text-green-700">Lunas</span>
                      </div>
                    </td>
                  </tr>
                </template>
                <tr v-else><td colspan="6" class="px-5 py-12 text-center text-sm text-gray-400">Tidak ada data pemesanan.</td></tr>
              </tbody>
            </table>
          </div>
          <div class="mt-6"><AppPagination :links="bookings.links" /></div>
        </main>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { reactive } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import AppSidebar from '@/Components/UI/AppSidebar.vue';
import AppBadge from '@/Components/UI/AppBadge.vue';
import AppPagination from '@/Components/UI/AppPagination.vue';

const props = defineProps({ bookings: Object, filters: { type: Object, default: () => ({}) } });
const statusMap = { pending:'Pending', confirmed:'Dikonfirmasi', cancelled:'Dibatalkan', completed:'Selesai' };
const f = reactive({ search: props.filters?.search ?? '', status: props.filters?.status ?? '' });

const fmt     = (v) => new Intl.NumberFormat('id-ID').format(v ?? 0);
const fmtDate = (d) => d ? new Date(d).toLocaleDateString('id-ID',{day:'numeric',month:'short',year:'numeric'}) : '-';

const applyFilter = () => router.get(route('admin.bookings.index'), { ...f }, { preserveState: true });
</script>
