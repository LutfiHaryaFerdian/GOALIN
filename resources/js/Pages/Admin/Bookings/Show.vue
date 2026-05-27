<template>
  <AppLayout>
    <Head title="Detail Pemesanan — Admin" />
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="flex gap-6">
        <AppSidebar section="admin" />
        <main class="flex-1 min-w-0">
          <div class="flex items-center gap-3 mb-8">
            <Link :href="route('admin.bookings.index')" class="p-2 rounded-lg hover:bg-primary-light text-gray-400 hover:text-primary transition-colors">
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
            </Link>
            <div><p class="section-label">Admin Panel</p><h1 class="text-2xl font-extrabold text-gray-900">Detail Pemesanan</h1></div>
            <span class="ml-auto font-mono text-xs text-gray-400 bg-gray-100 px-3 py-1 rounded-lg">{{ booking.booking_code }}</span>
          </div>

          <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-4">
              <div class="card p-6">
                <div class="flex items-start justify-between gap-4 mb-5">
                  <div>
                    <div class="flex items-center gap-2 mb-2">
                      <AppBadge :status="booking.status" />
                      <span v-if="booking.payment_status === 'paid'" class="inline-flex items-center gap-1 rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700">Lunas</span>
                      <span v-else class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-700">Belum Bayar</span>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">{{ booking.field.name }}</h2>
                    <p class="text-sm text-gray-500 mt-0.5">{{ booking.field.location.city }}</p>
                  </div>
                  <div class="text-right shrink-0">
                    <p class="text-xs text-gray-400">Total</p>
                    <p class="text-2xl font-extrabold text-primary">Rp {{ fmt(booking.total_price) }}</p>
                  </div>
                </div>
                <div class="grid grid-cols-2 gap-4 pt-5 border-t border-field text-sm">
                  <div><p class="label">Kategori</p><p class="font-semibold text-gray-900">{{ booking.field.category.name }}</p></div>
                  <div><p class="label">Tanggal</p><p class="font-semibold text-gray-900">{{ fmtDateLong(booking.booking_date) }}</p></div>
                  <div><p class="label">Waktu</p><p class="font-semibold text-gray-900">{{ booking.start_time.slice(0,5) }} – {{ booking.end_time.slice(0,5) }} WIB</p></div>
                  <div><p class="label">Dipesan pada</p><p class="font-semibold text-gray-900">{{ fmtDatetime(booking.created_at) }}</p></div>
                  <div v-if="booking.midtrans_order_id"><p class="label">Order ID Midtrans</p><p class="font-mono text-xs text-gray-600">{{ booking.midtrans_order_id }}</p></div>
                </div>
                <div v-if="booking.notes" class="mt-4 pt-4 border-t border-field"><p class="label">Catatan</p><p class="text-sm text-gray-600">{{ booking.notes }}</p></div>
                <div v-if="booking.cancellation_reason" class="mt-4 p-3 bg-red-50 rounded-xl border border-red-100">
                  <p class="label text-red-500">Alasan Pembatalan</p><p class="text-sm text-red-700">{{ booking.cancellation_reason }}</p>
                </div>
              </div>

              <!-- Payment logs -->
              <div v-if="booking.payment_logs?.length" class="card overflow-hidden">
                <div class="px-6 py-4 border-b border-field"><h3 class="font-bold text-gray-900">Riwayat Pembayaran</h3></div>
                <div class="overflow-x-auto">
                  <table class="w-full text-sm">
                    <thead><tr class="border-b border-field bg-accent"><th class="text-left px-5 py-3 text-xs">Waktu</th><th class="text-left px-5 py-3 text-xs">Status</th><th class="text-left px-5 py-3 text-xs">Metode</th><th class="text-left px-5 py-3 text-xs">Jumlah</th></tr></thead>
                    <tbody class="divide-y divide-field">
                      <tr v-for="log in booking.payment_logs" :key="log.id" class="hover:bg-accent transition-colors">
                        <td class="px-5 py-3 text-xs text-gray-500">{{ fmtDatetime(log.created_at) }}</td>
                        <td class="px-5 py-3"><span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold" :class="logColor(log.transaction_status)">{{ log.transaction_status?.toUpperCase() }}</span></td>
                        <td class="px-5 py-3 text-xs text-gray-600">{{ log.payment_type?.replace(/_/g,' ').toUpperCase() ?? '—' }}</td>
                        <td class="px-5 py-3 text-xs font-bold text-gray-900">{{ log.gross_amount ? 'Rp '+fmt(log.gross_amount) : '—' }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <div class="space-y-4">
              <div class="card p-5">
                <h3 class="font-bold text-gray-900 mb-3">Data Pemesan</h3>
                <div class="space-y-2 text-sm">
                  <div><p class="label">Nama</p><p class="font-semibold text-gray-900">{{ booking.user.name }}</p></div>
                  <div><p class="label">Email</p><p class="text-gray-600 break-all">{{ booking.user.email }}</p></div>
                  <div v-if="booking.user.phone"><p class="label">Telepon</p><p class="text-gray-600">{{ booking.user.phone }}</p></div>
                </div>
              </div>
              <div class="card p-5">
                <h3 class="font-bold text-gray-900 mb-3">Data Owner</h3>
                <div class="space-y-2 text-sm">
                  <div><p class="label">Nama</p><p class="font-semibold text-gray-900">{{ booking.field.owner.name }}</p></div>
                  <div><p class="label">Email</p><p class="text-gray-600 break-all">{{ booking.field.owner.email }}</p></div>
                </div>
              </div>
              <div class="card p-5">
                <h3 class="font-bold text-gray-900 mb-3">Info Pembayaran</h3>
                <div class="space-y-2 text-sm">
                  <div class="flex justify-between"><p class="label">Status</p><span :class="booking.payment_status==='paid'?'text-green-600':'text-amber-600'" class="font-semibold text-xs">{{ booking.payment_status==='paid'?'Lunas':'Belum Bayar' }}</span></div>
                  <div v-if="booking.midtrans_payment_type" class="flex justify-between"><p class="label">Metode</p><p class="text-xs font-semibold text-gray-900">{{ booking.midtrans_payment_type.replace(/_/g,' ').toUpperCase() }}</p></div>
                  <div class="flex justify-between pt-2 border-t border-field"><p class="label">Total</p><p class="font-extrabold text-primary">Rp {{ fmt(booking.total_price) }}</p></div>
                </div>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import AppSidebar from '@/Components/UI/AppSidebar.vue';
import AppBadge from '@/Components/UI/AppBadge.vue';

defineProps({ booking: { type: Object, required: true } });

const fmt         = (v) => new Intl.NumberFormat('id-ID').format(v ?? 0);
const fmtDateLong = (d) => d ? new Date(d).toLocaleDateString('id-ID',{weekday:'long',day:'numeric',month:'long',year:'numeric'}) : '-';
const fmtDatetime = (d) => d ? new Date(d).toLocaleString('id-ID',{day:'numeric',month:'short',year:'numeric',hour:'2-digit',minute:'2-digit'}) : '-';
const logColor    = (s) => ({settlement:'bg-green-100 text-green-700',capture:'bg-green-100 text-green-700',pending:'bg-amber-100 text-amber-700',cancel:'bg-red-100 text-red-700',expire:'bg-red-100 text-red-700'})[s] ?? 'bg-gray-100 text-gray-600';
</script>
