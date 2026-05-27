<template>
  <AppLayout>
    <Head title="Kelola Pemesanan" />
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="flex gap-6">
        <AppSidebar section="owner" />
        <main class="flex-1 min-w-0">
          <div class="flex items-center justify-between mb-8">
            <div><p class="section-label">Owner Panel</p><h1 class="text-2xl font-extrabold text-gray-900">Kelola Pemesanan</h1></div>
            <form class="flex items-center gap-2" @submit.prevent="applyFilter">
              <select v-model="statusFilter" class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary focus:border-transparent outline-none">
                <option value="">Semua Status</option>
                <option v-for="(l,v) in statusMap" :key="v" :value="v">{{ l }}</option>
              </select>
              <button type="submit" class="btn-secondary py-2 px-4 text-xs flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z"/></svg>
                Filter
              </button>
            </form>
          </div>

          <AppEmpty v-if="!bookings.data.length" title="Belum ada pemesanan masuk." icon="clipboard" />

          <div v-else class="card overflow-hidden">
            <table class="w-full text-sm">
              <thead>
                <tr class="border-b border-field bg-accent">
                  <th class="text-left px-5 py-3">Kode</th>
                  <th class="text-left px-5 py-3">Pemesan</th>
                  <th class="text-left px-5 py-3">Lapangan</th>
                  <th class="text-left px-5 py-3">Tanggal & Waktu</th>
                  <th class="text-left px-5 py-3">Total</th>
                  <th class="text-left px-5 py-3">Status</th>
                  <th class="text-left px-5 py-3">Aksi</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-field">
                <tr v-for="b in bookings.data" :key="b.id" class="hover:bg-accent transition-colors">
                  <td class="px-5 py-3 font-mono text-xs text-gray-400">{{ b.booking_code }}</td>
                  <td class="px-5 py-3 font-semibold text-gray-900 text-xs">{{ b.user.name }}</td>
                  <td class="px-5 py-3 text-gray-600 text-xs">{{ b.field.name }}</td>
                  <td class="px-5 py-3 text-xs text-gray-500">{{ fmtDate(b.booking_date) }}<br>{{ b.start_time.slice(0,5) }} – {{ b.end_time.slice(0,5) }}</td>
                  <td class="px-5 py-3 text-xs font-bold text-gray-900">Rp {{ fmt(b.total_price) }}</td>
                  <td class="px-5 py-3"><AppBadge :status="b.status" /></td>
                  <td class="px-5 py-3">
                    <div v-if="b.status === 'pending'" class="flex items-center gap-1.5">
                      <button @click="confirm_(b.id)"
                        class="px-2.5 py-1 bg-primary-light text-primary text-xs font-semibold rounded-lg hover:bg-primary hover:text-white transition-colors">Konfirmasi</button>
                      <button @click="cancel_(b.id)"
                        class="px-2.5 py-1 bg-red-50 text-red-500 text-xs font-semibold rounded-lg hover:bg-red-100 transition-colors">Batalkan</button>
                    </div>
                    <span v-else class="text-xs text-gray-300">—</span>
                  </td>
                </tr>
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
import { ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import AppSidebar from '@/Components/UI/AppSidebar.vue';
import AppBadge from '@/Components/UI/AppBadge.vue';
import AppEmpty from '@/Components/UI/AppEmpty.vue';
import AppPagination from '@/Components/UI/AppPagination.vue';

const props = defineProps({ bookings: Object, filters: { type: Object, default: () => ({}) } });
const statusMap = { pending:'Pending', confirmed:'Dikonfirmasi', cancelled:'Dibatalkan', completed:'Selesai' };
const statusFilter = ref(props.filters?.status ?? '');

const fmt     = (v) => new Intl.NumberFormat('id-ID').format(v ?? 0);
const fmtDate = (d) => d ? new Date(d).toLocaleDateString('id-ID',{day:'numeric',month:'short',year:'numeric'}) : '-';

const applyFilter = () => router.get(route('owner.bookings.index'), { status: statusFilter.value }, { preserveState: true });
const confirm_    = (id) => router.patch(route('owner.bookings.confirm', id));
const cancel_     = (id) => { if (confirm('Batalkan pemesanan ini?')) router.patch(route('owner.bookings.cancel', id), { cancellation_reason: 'Dibatalkan oleh owner' }); };
</script>
