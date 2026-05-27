<template>
  <AppLayout>
    <Head title="Admin Dashboard" />
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="flex gap-6">
        <AppSidebar section="admin" />
        <main class="flex-1 min-w-0">
          <div class="mb-8"><p class="section-label">Admin Panel</p><h1 class="text-2xl font-extrabold text-gray-900">Dashboard</h1></div>

          <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div v-for="stat in stats" :key="stat.label" class="card p-5">
              <p class="text-xs text-gray-400 mb-1">{{ stat.label }}</p>
              <p class="text-2xl font-extrabold text-gray-900">{{ stat.value }}</p>
            </div>
          </div>

          <div class="grid grid-cols-2 gap-4 mb-8">
            <div class="card p-5 flex items-center gap-4">
              <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center">
                <svg class="w-6 h-6 text-amber-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
              </div>
              <div>
                <p class="text-3xl font-extrabold text-gray-900">{{ pendingBookings }}</p>
                <p class="text-xs text-gray-400 mt-0.5">Menunggu Konfirmasi</p>
              </div>
            </div>
            <div class="card p-5 flex items-center gap-4">
              <div class="w-12 h-12 rounded-xl bg-primary-light flex items-center justify-center">
                <svg class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
              </div>
              <div>
                <p class="text-3xl font-extrabold text-gray-900">{{ confirmedBookings }}</p>
                <p class="text-xs text-gray-400 mt-0.5">Dikonfirmasi</p>
              </div>
            </div>
          </div>

          <div class="card overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-field bg-accent">
              <h2 class="font-bold text-gray-900">Pemesanan Terbaru</h2>
              <Link :href="route('admin.bookings.index')" class="text-sm text-primary hover:underline font-medium">Lihat semua</Link>
            </div>
            <div class="divide-y divide-field">
              <div v-for="b in recentBookings" :key="b.id" class="flex items-center justify-between px-6 py-3.5 hover:bg-accent transition-colors">
                <div>
                  <div class="flex items-center gap-2 mb-0.5">
                    <span class="text-xs font-mono text-gray-400">{{ b.booking_code }}</span>
                    <AppBadge :status="b.status" />
                  </div>
                  <p class="text-sm font-semibold text-gray-900">{{ b.user.name }}</p>
                  <p class="text-xs text-gray-400">{{ b.field.name }}</p>
                </div>
                <p class="text-xs text-gray-400">{{ fmtDate(b.created_at) }}</p>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import AppSidebar from '@/Components/UI/AppSidebar.vue';
import AppBadge from '@/Components/UI/AppBadge.vue';

const props = defineProps({
    totalUsers: Number, totalFields: Number, totalBookings: Number, totalRevenue: Number,
    pendingBookings: Number, confirmedBookings: Number,
    recentBookings: { type: Array, default: () => [] },
});

const fmt = (v) => new Intl.NumberFormat('id-ID').format(v ?? 0);
const fmtDate = (d) => d ? new Date(d).toLocaleDateString('id-ID',{day:'numeric',month:'short',year:'numeric'}) : '-';

const stats = computed(() => [
    { label: 'Total Pengguna',  value: props.totalUsers },
    { label: 'Total Lapangan',  value: props.totalFields },
    { label: 'Total Pemesanan', value: props.totalBookings },
    { label: 'Total Pendapatan',value: 'Rp '+fmt(props.totalRevenue) },
]);
</script>
