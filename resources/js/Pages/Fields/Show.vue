<template>
  <AppLayout>
    <Head :title="field.name" />

    <!-- Hero image -->
    <div class="relative h-72 md:h-96 bg-primary-light overflow-hidden">
      <img v-if="field.images?.length" :src="'/storage/' + field.images[0]" :alt="field.name" class="w-full h-full object-cover">
      <div v-else class="w-full h-full flex items-center justify-center">
        <svg class="w-20 h-20 text-primary opacity-20" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75"/>
        </svg>
      </div>
      <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"/>
      <div class="absolute bottom-0 inset-x-0 px-4 sm:px-6 lg:px-8 pb-6 max-w-7xl mx-auto">
        <span class="inline-block px-3 py-1 bg-white/95 text-primary text-xs font-bold rounded-full mb-3 uppercase tracking-wide">
          {{ field.category?.name }}
        </span>
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">{{ field.name }}</h1>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
      <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8">
        <Link :href="route('fields.index')" class="hover:text-primary transition-colors">Lapangan</Link>
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
        <span class="text-gray-700">{{ field.name }}</span>
      </nav>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left: Info -->
        <div class="lg:col-span-2 space-y-6">
          <!-- Meta -->
          <div class="flex flex-wrap gap-4 text-sm text-gray-500">
            <span class="flex items-center gap-1.5">
              <svg class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
              </svg>
              {{ field.location?.name }}, {{ field.location?.city }}
            </span>
            <span class="flex items-center gap-1.5">
              <svg class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z"/>
              </svg>
              Rp {{ formatPrice(field.price_per_hour) }}/jam
            </span>
          </div>

          <!-- Description -->
          <div v-if="field.description" class="card p-6">
            <h2 class="text-sm font-bold uppercase tracking-wide text-gray-400 mb-3">Tentang Lapangan</h2>
            <p class="text-gray-600 text-sm leading-relaxed">{{ field.description }}</p>
          </div>

          <!-- Facilities -->
          <div v-if="field.facilities?.length" class="card p-6">
            <h2 class="text-sm font-bold uppercase tracking-wide text-gray-400 mb-4">Fasilitas</h2>
            <div class="flex flex-wrap gap-2">
              <span v-for="fac in field.facilities" :key="fac"
                class="flex items-center gap-2 px-3 py-1.5 bg-primary-light text-primary rounded-lg text-sm font-medium capitalize">
                {{ fac }}
              </span>
            </div>
          </div>

          <!-- Owner info -->
          <div class="card p-6">
            <h2 class="text-sm font-bold uppercase tracking-wide text-gray-400 mb-4">Pengelola</h2>
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-xl bg-primary-light flex items-center justify-center font-bold text-primary">
                {{ field.owner?.name?.[0]?.toUpperCase() }}
              </div>
              <div>
                <p class="font-semibold text-gray-900">{{ field.owner?.name }}</p>
                <p v-if="field.owner?.phone" class="text-sm text-gray-500">{{ field.owner?.phone }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Right: Booking panel -->
        <div class="lg:col-span-1">
          <div class="card p-5 sticky top-24">
            <div class="flex items-center justify-between mb-4">
              <h2 class="font-bold text-gray-900">Pilih Jadwal</h2>
              <span class="text-sm font-extrabold text-primary">Rp {{ formatPrice(field.price_per_hour) }}<span class="text-xs text-gray-400 font-normal">/jam</span></span>
            </div>

            <!-- Slot grid -->
            <SlotGrid v-if="dates.length"
              :schedules="schedules"
              :dates="dates"
              :price-per-hour="field.price_per_hour"
              :poll-url="pollUrl"
              @update:selected="onSlotsSelected"
              ref="slotGrid" />
            <p v-else class="text-sm text-gray-400 text-center py-8">Belum ada jadwal tersedia.</p>

            <!-- Selected summary -->
            <Transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0 translate-y-1" enter-to-class="opacity-100 translate-y-0">
              <div v-if="selectedSlots.length" class="mt-4 p-3 bg-primary-light rounded-xl border border-primary/20">
                <div class="flex items-center justify-between text-sm mb-1">
                  <span class="text-gray-600">{{ selectedSlots.length }} jam × Rp {{ formatPrice(field.price_per_hour) }}</span>
                  <span class="font-extrabold text-primary">Rp {{ formatPrice(totalPrice) }}</span>
                </div>
                <div class="text-xs text-gray-500">
                  {{ timeRange?.start }} – {{ timeRange?.end }} WIB
                </div>
              </div>
            </Transition>

            <!-- Book button -->
            <template v-if="auth.user">
              <form v-if="selectedSlots.length" @submit.prevent="confirmBooking" class="mt-4">
                <input v-for="s in selectedSlots" :key="s.id" type="hidden" name="schedule_ids[]" :value="s.id">
                <AppButton type="submit" variant="primary" size="lg" class="w-full">
                  Pesan Sekarang
                </AppButton>
              </form>
              <div v-else class="mt-4 text-xs text-gray-400 text-center">Pilih slot waktu di atas untuk memesan</div>
            </template>
            <div v-else class="mt-4">
              <Link :href="route('login')" class="btn-primary w-full text-center block py-3 text-sm font-semibold">
                Masuk untuk Memesan
              </Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import SlotGrid from '@/Components/Field/SlotGrid.vue';
import AppButton from '@/Components/UI/AppButton.vue';

const props = defineProps({
    field:     { type: Object, required: true },
    schedules: { type: Object, default: () => ({}) },
    dates:     { type: Array,  default: () => [] },
    pollUrl:   { type: String, default: '' },
});

const page       = usePage();
const auth       = computed(() => page.props.auth);
const slotGrid   = ref(null);
const selectedSlots = ref([]);

const totalPrice = computed(() => selectedSlots.value.length * props.field.price_per_hour);
const timeRange  = computed(() => {
    if (!selectedSlots.value.length) return null;
    const sorted = [...selectedSlots.value].sort((a, b) => a.start_time.localeCompare(b.start_time));
    return { start: sorted[0].start_time.slice(0,5), end: sorted.at(-1).end_time.slice(0,5) };
});

function onSlotsSelected(slots) { selectedSlots.value = slots; }

function confirmBooking() {
    const ids = selectedSlots.value.map(s => s.id);
    router.get(route('bookings.create'), { schedule_ids: ids });
}

const formatPrice = (v) => new Intl.NumberFormat('id-ID').format(v ?? 0);
</script>
