<template>
  <AppLayout>
    <Head title="Notifikasi" />
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
      <div class="flex items-center justify-between mb-8">
        <div>
          <h1 class="text-2xl font-extrabold text-gray-900">Notifikasi</h1>
          <p class="text-sm text-gray-500 mt-0.5">Pemberitahuan pemesanan dan aktivitas akun</p>
        </div>
        <form v-if="notifications.total > 0" @submit.prevent="readAll">
          <AppButton type="submit" variant="ghost" size="sm" :loading="readingAll">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
            Tandai semua dibaca
          </AppButton>
        </form>
      </div>

      <AppEmpty v-if="!notifications.data.length"
        title="Belum ada notifikasi"
        message="Anda akan mendapat notifikasi saat ada pemesanan baru atau perubahan status."
        icon="bell" />

      <div v-else class="space-y-2">
        <div v-for="notif in notifications.data" :key="notif.id"
          class="flex items-start gap-4 p-4 rounded-xl bg-white border transition-colors hover:border-primary/30"
          :class="notif.is_unread ? 'border-l-4 border-l-primary border-field bg-accent' : 'border-field'">

          <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0"
            :class="typeStyle(notif.type).bg">
            <svg class="w-5 h-5" :class="typeStyle(notif.type).icon" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" :d="typeStyle(notif.type).path"/>
            </svg>
          </div>

          <div class="flex-1 min-w-0">
            <div class="flex items-start justify-between gap-3">
              <p class="text-sm text-gray-900" :class="notif.is_unread ? 'font-semibold' : 'font-medium'">
                {{ notif.title }}
              </p>
              <span v-if="notif.is_unread" class="w-2 h-2 rounded-full bg-primary shrink-0 mt-1.5"/>
            </div>
            <p class="text-xs text-gray-500 mt-0.5 leading-relaxed">{{ notif.message }}</p>
            <div class="flex items-center justify-between mt-2">
              <span class="text-xs text-gray-400">{{ notif.created_at_human }}</span>
              <form v-if="notif.is_unread" @submit.prevent="markRead(notif.id)">
                <button type="submit" class="text-xs text-primary hover:underline font-medium">Tandai dibaca</button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="mt-6">
        <AppPagination :links="notifications.links" />
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import AppButton from '@/Components/UI/AppButton.vue';
import AppEmpty from '@/Components/UI/AppEmpty.vue';
import AppPagination from '@/Components/UI/AppPagination.vue';

defineProps({ notifications: { type: Object, required: true } });

const readingAll = ref(false);
function readAll() {
    readingAll.value = true;
    router.patch(route('notifications.read-all'), {}, { onFinish: () => { readingAll.value = false; } });
}
function markRead(id) { router.patch(route('notifications.read', id)); }

const typeConfig = {
    booking_pending:   { bg:'bg-amber-50', icon:'text-amber-500', path:'M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z' },
    booking_confirmed: { bg:'bg-primary-light', icon:'text-primary', path:'m4.5 12.75 6 6 9-13.5' },
    booking_cancelled: { bg:'bg-red-50', icon:'text-red-500', path:'m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z' },
    booking_completed: { bg:'bg-blue-50', icon:'text-blue-500', path:'M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108' },
    payment_reminder:  { bg:'bg-orange-50', icon:'text-orange-500', path:'M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75' },
};
const defaultType = { bg:'bg-gray-50', icon:'text-gray-400', path:'M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31' };
function typeStyle(type) { return typeConfig[type] ?? defaultType; }
</script>
