<template>
  <AppLayout>
    <Head title="Dashboard Owner" />
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="flex gap-6">
        <AppSidebar section="owner" />
        <main class="flex-1 min-w-0">
          <div class="flex items-center justify-between mb-8">
            <div>
              <p class="section-label">Owner Panel</p>
              <h1 class="text-2xl font-extrabold text-gray-900">Selamat datang, {{ auth.user?.name }}</h1>
            </div>
            <Link :href="route('owner.fields.create')" class="btn-primary inline-flex items-center gap-2">
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
              Tambah Lapangan
            </Link>
          </div>

          <!-- Stats -->
          <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div v-for="stat in stats" :key="stat.label" class="card p-5">
              <p class="text-xs text-gray-400 mb-1">{{ stat.label }}</p>
              <p class="text-2xl font-extrabold text-gray-900">{{ stat.value }}</p>
            </div>
          </div>

          <!-- Quick nav -->
          <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            <Link v-for="item in quickNav" :key="item.route" :href="route(item.route)"
              class="card p-5 flex items-center gap-4 hover:shadow-sm transition-shadow group">
              <div class="w-10 h-10 rounded-xl bg-primary-light flex items-center justify-center">
                <svg class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" :d="item.icon"/>
                </svg>
              </div>
              <div>
                <p class="font-semibold text-gray-900 group-hover:text-primary text-sm">{{ item.label }}</p>
                <p class="text-xs text-gray-400">{{ item.sub }}</p>
              </div>
              <svg class="w-4 h-4 text-gray-300 ml-auto" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
            </Link>
          </div>

          <!-- Recent bookings -->
          <div class="card overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-field">
              <h2 class="font-bold text-gray-900">Pemesanan Terbaru</h2>
              <Link :href="route('owner.bookings.index')" class="text-sm text-primary hover:underline font-medium">Lihat semua</Link>
            </div>
            <div v-if="!recentBookings.length" class="py-12 text-center text-gray-400 text-sm">Belum ada pemesanan masuk.</div>
            <div v-else class="divide-y divide-field">
              <div v-for="b in recentBookings" :key="b.id" class="flex items-center justify-between px-6 py-3.5 hover:bg-accent transition-colors">
                <div>
                  <div class="flex items-center gap-2 mb-0.5">
                    <span class="text-xs font-mono text-gray-400">{{ b.booking_code }}</span>
                    <AppBadge :status="b.status" />
                  </div>
                  <p class="text-sm font-semibold text-gray-900">{{ b.user.name }}</p>
                  <p class="text-xs text-gray-400">{{ b.field.name }}</p>
                </div>
                <div class="text-right">
                  <p class="text-xs text-gray-400">{{ fmtDate(b.booking_date) }}</p>
                  <p class="text-sm font-bold text-gray-900">Rp {{ fmt(b.total_price) }}</p>
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
import { computed } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import AppSidebar from '@/Components/UI/AppSidebar.vue';
import AppBadge from '@/Components/UI/AppBadge.vue';

const props = defineProps({
    totalFields: Number, totalBookings: Number, pendingCount: Number, revenue: Number,
    recentBookings: { type: Array, default: () => [] },
});

const page = usePage();
const auth = computed(() => page.props.auth);

const stats = computed(() => [
    { label: 'Total Lapangan',     value: props.totalFields },
    { label: 'Total Pemesanan',    value: props.totalBookings },
    { label: 'Menunggu Konfirmasi',value: props.pendingCount },
    { label: 'Total Pendapatan',   value: 'Rp '+fmt(props.revenue) },
]);

const fieldIcon = 'M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75';
const bookIcon  = 'M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108';
const bellIcon  = 'M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022';

const quickNav = [
    { route:'owner.fields.index',   icon:fieldIcon, label:'Lapangan Saya',  sub:'Kelola lapangan Anda' },
    { route:'owner.bookings.index', icon:bookIcon,  label:'Pemesanan',       sub:'Konfirmasi & kelola' },
    { route:'notifications.index',  icon:bellIcon,  label:'Notifikasi',      sub:'Pesan & pemberitahuan' },
];

const fmt     = (v) => new Intl.NumberFormat('id-ID').format(v ?? 0);
const fmtDate = (d) => d ? new Date(d).toLocaleDateString('id-ID',{day:'numeric',month:'short',year:'numeric'}) : '-';
</script>
