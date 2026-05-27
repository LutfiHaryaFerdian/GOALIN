<template>
  <AppLayout>
    <Head title="Konfirmasi Pemesanan" />
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
      <div class="flex items-center gap-3 mb-8">
        <Link :href="route('fields.show', schedule.field.slug)" class="p-2 rounded-lg hover:bg-primary-light text-gray-400 hover:text-primary transition-colors">
          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
        </Link>
        <div>
          <h1 class="text-2xl font-extrabold text-gray-900">Konfirmasi Pemesanan</h1>
          <p class="text-sm text-gray-500 mt-0.5">Periksa detail sebelum mengkonfirmasi</p>
        </div>
      </div>

      <!-- Summary card -->
      <div class="card p-6 mb-6">
        <div class="flex items-start justify-between gap-4 mb-5">
          <div>
            <p class="text-xs font-bold uppercase tracking-wide text-gray-400 mb-1">{{ schedule.field.category.name }}</p>
            <h2 class="text-xl font-bold text-gray-900">{{ schedule.field.name }}</h2>
            <p class="flex items-center gap-1.5 text-sm text-gray-500 mt-1">
              <svg class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
              {{ schedule.field.location.city }}
            </p>
          </div>
          <div class="text-right shrink-0">
            <p class="text-xs text-gray-400 mb-1">Total</p>
            <p class="text-2xl font-extrabold text-primary">Rp {{ formatPrice(totalPrice) }}</p>
            <p class="text-xs text-gray-400 mt-0.5">{{ schedules.length }} jam × Rp {{ formatPrice(schedule.field.price_per_hour) }}</p>
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4 pt-5 border-t border-field">
          <div>
            <p class="label">Tanggal</p>
            <p class="text-sm font-semibold text-gray-900">{{ formatDateLong(schedule.schedule_date) }}</p>
          </div>
          <div>
            <p class="label">Waktu</p>
            <p class="text-sm font-semibold text-gray-900 flex items-center gap-1.5">
              <svg class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
              {{ schedules[0].start_time.slice(0,5) }} – {{ schedules[schedules.length-1].end_time.slice(0,5) }} WIB
            </p>
          </div>
        </div>

        <!-- Multi-slot timeline -->
        <div v-if="schedules.length > 1" class="mt-4 pt-4 border-t border-field">
          <p class="label mb-3">Slot yang Dipesan ({{ schedules.length }} jam)</p>
          <div class="flex flex-wrap gap-2">
            <span v-for="s in schedules" :key="s.id"
              class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-primary-light text-primary rounded-lg text-xs font-semibold">
              <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
              {{ s.start_time.slice(0,5) }} – {{ s.end_time.slice(0,5) }}
            </span>
          </div>
        </div>
      </div>

      <!-- Booker info -->
      <div class="card p-6 mb-6">
        <h3 class="label mb-4">Informasi Pemesan</h3>
        <div class="grid grid-cols-2 gap-4 text-sm">
          <div><p class="text-gray-400 text-xs mb-0.5">Nama</p><p class="font-semibold text-gray-900">{{ auth.user.name }}</p></div>
          <div><p class="text-gray-400 text-xs mb-0.5">Email</p><p class="font-semibold text-gray-900">{{ auth.user.email }}</p></div>
          <div v-if="auth.user.phone"><p class="text-gray-400 text-xs mb-0.5">Telepon</p><p class="font-semibold text-gray-900">{{ auth.user.phone }}</p></div>
        </div>
      </div>

      <!-- Form submit -->
      <form @submit.prevent="submit" class="card p-6">
        <input v-for="s in schedules" :key="s.id" type="hidden" name="schedule_ids[]" :value="s.id">
        <div class="mb-6">
          <label for="notes" class="label">Catatan Tambahan <span class="text-gray-300 normal-case font-normal">(opsional)</span></label>
          <textarea id="notes" v-model="form.notes" rows="3" placeholder="Contoh: Butuh bola tambahan..."
            class="input resize-none" :class="{ 'border-red-400': form.errors.notes }"/>
          <p v-if="form.errors.notes" class="mt-1.5 text-xs text-red-600">{{ form.errors.notes }}</p>
        </div>
        <div class="flex gap-3">
          <Link :href="route('fields.show', schedule.field.slug)" class="btn-secondary flex-1 justify-center text-center">Kembali</Link>
          <AppButton type="submit" variant="primary" class="flex-1 justify-center" :loading="form.processing">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
            Konfirmasi Pemesanan
          </AppButton>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<script setup>
import { computed } from 'vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import AppButton from '@/Components/UI/AppButton.vue';

const props = defineProps({
    schedule:   { type: Object, required: true },
    schedules:  { type: Array,  required: true },
    totalPrice: { type: Number, required: true },
});

const page = usePage();
const auth = computed(() => page.props.auth);
const form = useForm({ notes: '', schedule_ids: props.schedules.map(s => s.id) });
const submit = () => form.post(route('bookings.store'));

const formatPrice    = (v) => new Intl.NumberFormat('id-ID').format(v ?? 0);
const formatDateLong = (d) => d ? new Date(d).toLocaleDateString('id-ID', { weekday:'long',day:'numeric',month:'long',year:'numeric' }) : '-';
</script>
