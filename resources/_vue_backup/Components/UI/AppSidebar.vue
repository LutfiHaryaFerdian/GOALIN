<template>
  <nav class="w-56 shrink-0 hidden md:block">
    <div class="sticky top-20 space-y-1 p-4 bg-white rounded-2xl border border-gray-100 shadow-sm">
      <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 px-3 mb-2">
        {{ section === 'owner' ? 'Owner Panel' : 'Admin Panel' }}
      </p>
      <Link v-for="item in navItems" :key="item.route"
        :href="route(item.route)"
        class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors"
        :class="$page.url.startsWith(item.prefix)
          ? 'bg-primary-light text-primary'
          : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'">
        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" :d="item.icon"/>
        </svg>
        {{ item.label }}
      </Link>
    </div>
  </nav>
</template>

<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({ section: { type: String, default: 'owner' } });

const dashIcon = 'M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6Z';
const bookIcon = 'M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z';
const bellIcon = 'M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0';
const userIcon = 'M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Z';
const fieldIcon = 'M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0 0 12 4.5c-2.291 0-4.545.16-6.75.47';

const ownerNav = [
  { label: 'Dashboard',  route: 'owner.dashboard',      prefix: '/owner/dashboard', icon: dashIcon },
  { label: 'Lapangan',   route: 'owner.fields.index',   prefix: '/owner/fields',    icon: fieldIcon },
  { label: 'Pemesanan',  route: 'owner.bookings.index', prefix: '/owner/bookings',  icon: bookIcon },
  { label: 'Notifikasi', route: 'notifications.index',  prefix: '/notifications',   icon: bellIcon },
];

const adminNav = [
  { label: 'Dashboard',  route: 'admin.dashboard',      prefix: '/admin/dashboard', icon: dashIcon },
  { label: 'Pemesanan',  route: 'admin.bookings.index', prefix: '/admin/bookings',  icon: bookIcon },
  { label: 'Pengguna',   route: 'admin.users.index',    prefix: '/admin/users',     icon: userIcon },
];

const navItems = computed(() => props.section === 'owner' ? ownerNav : adminNav);
</script>
