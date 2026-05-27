<template>
  <AppLayout>
    <Head title="Pemesanan Saya" />
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
      <div class="flex items-center justify-between mb-8">
        <div>
          <h1 class="text-2xl font-extrabold text-gray-900">Pemesanan Saya</h1>
          <p class="text-sm text-gray-500 mt-0.5">Riwayat dan status pemesanan lapangan Anda</p>
        </div>
        <Link :href="route('fields.index')" class="btn-primary hidden sm:inline-flex items-center gap-2">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
          Pesan Baru
        </Link>
      </div>

      <AppEmpty v-if="!bookings.data.length"
        title="Belum ada pemesanan"
        message="Anda belum pernah memesan lapangan olahraga."
        action-href="/fields" action-label="Cari Lapangan Sekarang" icon="clipboard" />

      <div v-else class="space-y-3">
        <div v-for="booking in bookings.data" :key="booking.id" class="card p-5 hover:shadow-sm transition-shadow">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex-1 min-w-0">
              <div class="flex flex-wrap items-center gap-2 mb-2">
                <AppBadge :status="booking.status" />
                <span class="text-xs text-gray-400 font-mono">{{ booking.booking_code }}</span>
              </div>
              <h3 class="font-bold text-gray-900 truncate">{{ booking.field.name }}</h3>
              <div class="flex flex-wrap items-center gap-3 mt-1.5 text-xs text-gray-500">
                <span class="flex items-center gap-1">
                  <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/></svg>
                  {{ formatDate(booking.booking_date) }}
                </span>
                <span class="flex items-center gap-1">
                  <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                  {{ booking.start_time.slice(0,5) }} – {{ booking.end_time.slice(0,5) }}
                </span>
                <span class="flex items-center gap-1">
                  <svg class="w-3.5 h-3.5 text-primary" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                  {{ booking.field.location.city }}
                </span>
              </div>
            </div>
            <div class="flex items-center gap-4 shrink-0">
              <div class="text-right">
                <p class="text-xs text-gray-400">Total</p>
                <p class="text-base font-extrabold text-gray-900">Rp {{ formatPrice(booking.total_price) }}</p>
              </div>
              <Link :href="route('bookings.show', booking.id)" class="btn-secondary py-2 px-4 text-xs inline-flex items-center gap-1">
                Detail <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
              </Link>
            </div>
          </div>
        </div>
      </div>

      <div class="mt-8">
        <AppPagination :links="bookings.links" />
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import AppBadge from '@/Components/UI/AppBadge.vue';
import AppEmpty from '@/Components/UI/AppEmpty.vue';
import AppPagination from '@/Components/UI/AppPagination.vue';

defineProps({ bookings: { type: Object, required: true } });

const formatPrice = (v) => new Intl.NumberFormat('id-ID').format(v ?? 0);
const formatDate  = (d) => d ? new Date(d).toLocaleDateString('id-ID', { day:'numeric',month:'short',year:'numeric' }) : '-';
</script>
