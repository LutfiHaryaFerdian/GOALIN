<template>
  <div class="min-h-screen flex flex-col">
    <!-- NAVBAR -->
    <header class="fixed top-0 inset-x-0 z-50 bg-primary border-b border-primary-dark">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between gap-6">

          <!-- Logo -->
          <Link :href="route('fields.index')" class="shrink-0 flex items-center gap-2">
            <svg class="w-7 h-7 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="2" y="3" width="20" height="18" rx="2"/><line x1="2" y1="12" x2="22" y2="12"/>
              <line x1="12" y1="3" x2="12" y2="21"/>
              <circle cx="12" cy="12" r="3"/>
            </svg>
            <span class="text-white font-extrabold text-lg tracking-tight">GOALIN</span>
          </Link>

          <!-- Desktop Nav -->
          <nav class="hidden md:flex items-center gap-1">
            <Link :href="route('fields.index')"
              class="px-3 py-2 text-sm font-medium transition-colors"
              :class="$page.url.startsWith('/fields') ? 'text-white border-b-2 border-white/60' : 'text-white/80 hover:text-white'">
              Cari Lapangan
            </Link>
            <template v-if="user">
              <Link v-if="isOwner" :href="route('owner.dashboard')"
                class="px-3 py-2 text-sm font-medium transition-colors"
                :class="$page.url.startsWith('/owner') ? 'text-white border-b-2 border-white/60' : 'text-white/80 hover:text-white'">
                Dashboard Owner
              </Link>
              <Link v-if="isAdmin" :href="route('admin.dashboard')"
                class="px-3 py-2 text-sm font-medium transition-colors"
                :class="$page.url.startsWith('/admin') ? 'text-white border-b-2 border-white/60' : 'text-white/80 hover:text-white'">
                Admin
              </Link>
              <Link :href="route('bookings.index')"
                class="px-3 py-2 text-sm font-medium transition-colors"
                :class="$page.url.startsWith('/bookings') ? 'text-white border-b-2 border-white/60' : 'text-white/80 hover:text-white'">
                Pemesanan Saya
              </Link>
            </template>
          </nav>

          <!-- Right side -->
          <div class="flex items-center gap-2">
            <template v-if="user">
              <!-- Bell icon -->
              <Link :href="route('notifications.index')"
                class="relative p-2 text-white/70 hover:text-white transition-colors rounded-lg hover:bg-white/10">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"/>
                </svg>
                <span v-if="unreadCount > 0"
                  class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-400 rounded-full ring-2 ring-primary"/>
              </Link>

              <!-- Avatar dropdown -->
              <div class="relative" ref="dropdownRef">
                <button @click="dropdownOpen = !dropdownOpen"
                  class="flex items-center gap-2 py-1.5 pl-1.5 pr-3 rounded-lg hover:bg-white/10 transition-colors">
                  <div class="w-7 h-7 rounded-lg bg-white/20 flex items-center justify-center text-white text-xs font-bold overflow-hidden">
                    <img v-if="user.avatar" :src="user.avatar" class="w-full h-full object-cover" alt="">
                    <span v-else>{{ user.name[0]?.toUpperCase() }}</span>
                  </div>
                  <span class="text-sm font-medium text-white hidden sm:block">{{ user.name }}</span>
                  <svg class="w-3.5 h-3.5 text-white/60" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                  </svg>
                </button>
                <Transition enter-active-class="transition ease-out duration-100" enter-from-class="opacity-0 scale-95" enter-to-class="opacity-100 scale-100"
                  leave-active-class="transition ease-in duration-75" leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
                  <div v-show="dropdownOpen"
                    class="absolute right-0 mt-1 w-52 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50">
                    <Link :href="route('profile.edit')" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                      <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                      </svg>
                      Profil Saya
                    </Link>
                    <div class="border-t border-gray-100 my-1"/>
                    <Link :href="route('logout')" method="post" as="button"
                      class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors text-left">
                      <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75"/>
                      </svg>
                      Keluar
                    </Link>
                  </div>
                </Transition>
              </div>
            </template>
            <template v-else>
              <Link :href="route('login')" class="text-sm font-medium text-white/80 hover:text-white px-3 py-2 transition-colors">Masuk</Link>
              <Link :href="route('register')" class="text-sm font-semibold bg-white text-primary px-4 py-2 rounded-lg hover:bg-primary-light transition-colors">Daftar</Link>
            </template>

            <!-- Mobile toggle -->
            <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 text-white/70 hover:text-white rounded-lg hover:bg-white/10">
              <svg v-if="!mobileOpen" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
              </svg>
              <svg v-else class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Mobile drawer -->
      <Transition enter-active-class="transition ease-out duration-150" enter-from-class="opacity-0 -translate-y-2" enter-to-class="opacity-100 translate-y-0"
        leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
        <div v-show="mobileOpen" class="md:hidden border-t border-primary-dark bg-primary px-4 py-3 space-y-1">
          <Link :href="route('fields.index')" class="block px-3 py-2 text-sm font-medium text-white/80 hover:text-white rounded-lg hover:bg-white/10 transition-colors">Cari Lapangan</Link>
          <template v-if="user">
            <Link :href="route('bookings.index')" class="block px-3 py-2 text-sm font-medium text-white/80 hover:text-white rounded-lg hover:bg-white/10 transition-colors">Pemesanan Saya</Link>
            <Link :href="route('notifications.index')" class="block px-3 py-2 text-sm font-medium text-white/80 hover:text-white rounded-lg hover:bg-white/10 transition-colors">Notifikasi</Link>
            <Link v-if="isOwner" :href="route('owner.dashboard')" class="block px-3 py-2 text-sm font-medium text-white/80 hover:text-white rounded-lg hover:bg-white/10 transition-colors">Dashboard Owner</Link>
            <Link v-if="isAdmin" :href="route('admin.dashboard')" class="block px-3 py-2 text-sm font-medium text-white/80 hover:text-white rounded-lg hover:bg-white/10 transition-colors">Admin</Link>
            <Link :href="route('profile.edit')" class="block px-3 py-2 text-sm font-medium text-white/80 hover:text-white rounded-lg hover:bg-white/10 transition-colors">Profil</Link>
            <Link :href="route('logout')" method="post" as="button" class="w-full text-left px-3 py-2 text-sm font-medium text-red-300 hover:text-white rounded-lg hover:bg-white/10 transition-colors">Keluar</Link>
          </template>
          <template v-else>
            <Link :href="route('login')" class="block px-3 py-2 text-sm font-medium text-white/80 hover:text-white rounded-lg hover:bg-white/10 transition-colors">Masuk</Link>
            <Link :href="route('register')" class="block px-3 py-2 text-sm font-medium text-white rounded-lg bg-white/10 transition-colors">Daftar</Link>
          </template>
        </div>
      </Transition>
    </header>

    <!-- Flash messages -->
    <Transition enter-active-class="transition ease-out duration-300" enter-from-class="opacity-0 translate-y-[-8px]" enter-to-class="opacity-100 translate-y-0"
      leave-active-class="transition ease-in duration-200" leave-from-class="opacity-100" leave-to-class="opacity-0 translate-y-[-8px]">
      <div v-if="activeFlash"
        class="fixed top-20 right-4 z-50 flex items-center gap-3 bg-white px-4 py-3 rounded-xl shadow-lg max-w-sm text-sm border-l-4"
        :class="flashStyle.border">
        <svg class="w-5 h-5 shrink-0" :class="flashStyle.icon" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
          <path v-if="flashType === 'success'" stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
          <path v-else-if="flashType === 'error'" stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/>
          <path v-else stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"/>
        </svg>
        <span class="flex-1 text-gray-800">{{ activeFlash }}</span>
        <button @click="activeFlash = null" class="text-gray-400 hover:text-gray-600 ml-auto">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>
    </Transition>

    <!-- Page content -->
    <main class="pt-16 min-h-screen">
      <slot />
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 mt-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
          <div>
            <div class="flex items-center gap-2 mb-3">
              <svg class="w-6 h-6 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="2" y="3" width="20" height="18" rx="2"/><line x1="2" y1="12" x2="22" y2="12"/>
                <line x1="12" y1="3" x2="12" y2="21"/><circle cx="12" cy="12" r="3"/>
              </svg>
              <span class="font-extrabold text-gray-900">GOALIN</span>
            </div>
            <p class="text-sm text-gray-500 leading-relaxed max-w-xs">Platform reservasi lapangan olahraga. Temukan, pesan, dan bermain.</p>
          </div>
          <div>
            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 mb-3">Layanan</p>
            <ul class="space-y-2">
              <li><Link :href="route('fields.index')" class="text-sm text-gray-500 hover:text-primary transition-colors">Cari Lapangan</Link></li>
              <li v-if="user"><Link :href="route('bookings.index')" class="text-sm text-gray-500 hover:text-primary transition-colors">Pemesanan Saya</Link></li>
              <li v-else><Link :href="route('register')" class="text-sm text-gray-500 hover:text-primary transition-colors">Daftar Gratis</Link></li>
            </ul>
          </div>
          <div>
            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 mb-3">Untuk Owner</p>
            <ul class="space-y-2">
              <li><Link :href="route('register')" class="text-sm text-gray-500 hover:text-primary transition-colors">Daftarkan Lapangan</Link></li>
            </ul>
          </div>
        </div>
        <div class="border-t border-gray-100 pt-6 flex flex-col sm:flex-row items-center justify-between gap-3">
          <p class="text-xs text-gray-400">&copy; {{ new Date().getFullYear() }} GOALIN. All rights reserved.</p>
          <p class="text-xs text-gray-400">Bangun dengan semangat untuk pecinta olahraga.</p>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted, onUnmounted } from 'vue';
import { Link, usePage, router } from '@inertiajs/vue3';
import { useAuth } from '@/Composables/useAuth';

const { user, isOwner, isAdmin } = useAuth();
const page = usePage();

// Navbar state
const mobileOpen = ref(false);
const dropdownOpen = ref(false);
const dropdownRef = ref(null);

// Unread notification count (polling every 60s)
const unreadCount = computed(() => page.props.unread_notifications ?? 0);
let notifTimer = null;
onMounted(() => {
    notifTimer = setInterval(() => {
        router.reload({ only: ['unread_notifications'] });
    }, 60000);

    // Close dropdown on outside click
    document.addEventListener('click', handleOutsideClick);
});
onUnmounted(() => {
    clearInterval(notifTimer);
    document.removeEventListener('click', handleOutsideClick);
});

function handleOutsideClick(e) {
    if (dropdownRef.value && !dropdownRef.value.contains(e.target)) {
        dropdownOpen.value = false;
    }
}

// Flash messages — auto-dismiss
const activeFlash = ref(null);
const flashType   = ref('success');

const flashStyle = computed(() => ({
    success: { border: 'border-primary', icon: 'text-primary' },
    error:   { border: 'border-red-500', icon: 'text-red-500' },
    info:    { border: 'border-blue-500', icon: 'text-blue-500' },
})[flashType.value] ?? { border: 'border-gray-300', icon: 'text-gray-500' });

function showFlash(msg, type) {
    activeFlash.value = msg;
    flashType.value   = type;
    setTimeout(() => { activeFlash.value = null; }, type === 'error' ? 5000 : 4000);
}

watch(() => page.props.flash, (flash) => {
    if (flash?.success) showFlash(flash.success, 'success');
    else if (flash?.error) showFlash(flash.error, 'error');
    else if (flash?.info) showFlash(flash.info, 'info');
}, { immediate: true, deep: true });
</script>
