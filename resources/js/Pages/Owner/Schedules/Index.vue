<template>
  <AppLayout>
    <Head :title="'Kelola Jadwal — ' + field.name" />
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="flex gap-6">
        <AppSidebar section="owner" />
        <main class="flex-1 min-w-0">
          <div class="flex items-center gap-3 mb-8">
            <Link :href="route('owner.fields.index')" class="p-2 rounded-lg hover:bg-primary-light text-gray-400 hover:text-primary transition-colors">
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
            </Link>
            <div>
              <p class="section-label">Owner Panel</p>
              <h1 class="text-2xl font-extrabold text-gray-900">Kelola Jadwal</h1>
              <p class="text-sm text-gray-500">{{ field.name }}</p>
            </div>
          </div>

          <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Schedule grid -->
            <div class="lg:col-span-3 card overflow-hidden">
              <!-- Date tabs -->
              <div class="flex gap-1.5 overflow-x-auto p-4 border-b border-field bg-accent" style="-ms-overflow-style:none;scrollbar-width:none;">
                <button v-for="date in dates" :key="date"
                  @click="selectedDate = date"
                  class="shrink-0 px-4 py-2 rounded-lg text-xs font-semibold transition-colors whitespace-nowrap"
                  :class="selectedDate === date ? 'bg-primary text-white' : 'bg-white text-gray-600 hover:bg-primary-light hover:text-primary border border-field'">
                  {{ fmtDateTab(date) }}
                </button>
              </div>

              <!-- Slot grid per date -->
              <div v-for="date in dates" :key="date" v-show="selectedDate === date" class="p-5">
                <div v-if="schedules[date]?.length" class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-2">
                  <div v-for="slot in schedules[date]" :key="slot.id"
                    class="flex flex-col items-center p-2.5 rounded-xl border text-center"
                    :class="slotClass(slot.status)">
                    <span class="text-xs font-bold">{{ slot.start_time.slice(0,5) }}</span>
                    <span class="text-[10px] mt-0.5 capitalize">{{ slot.status }}</span>
                    <form v-if="slot.status !== 'booked'" @submit.prevent="toggleStatus(slot)" class="mt-1.5 w-full">
                      <button type="submit" class="w-full text-[10px] font-semibold px-2 py-0.5 rounded bg-white/60 hover:bg-white transition-colors border border-current/20">
                        {{ slot.status === 'available' ? 'Tutup' : 'Buka' }}
                      </button>
                    </form>
                  </div>
                </div>
                <p v-else class="text-center py-8 text-sm text-gray-400">Belum ada slot untuk tanggal ini.</p>
              </div>

              <!-- Legend -->
              <div class="px-5 pb-4 flex gap-5 text-xs text-gray-400">
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded bg-primary-light border border-field inline-block"/> Tersedia</span>
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded bg-blue-50 border border-blue-100 inline-block"/> Terpesan</span>
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded bg-gray-50 border border-gray-100 inline-block"/> Tutup</span>
              </div>
            </div>

            <!-- Add slot form -->
            <div class="lg:col-span-1">
              <div class="card p-5 sticky top-24">
                <h3 class="font-bold text-gray-900 mb-4">Tambah Slot</h3>
                <form @submit.prevent="addSlot" class="space-y-3">
                  <div><label class="label">Tanggal</label><input v-model="slotForm.schedule_date" type="date" :min="today" class="input text-sm"></div>
                  <div><label class="label">Jam Mulai</label><input v-model="slotForm.start_time" type="time" class="input text-sm"></div>
                  <div><label class="label">Jam Selesai</label><input v-model="slotForm.end_time" type="time" class="input text-sm"></div>
                  <div><label class="label">Catatan</label><input v-model="slotForm.notes" type="text" placeholder="Opsional" class="input text-sm"></div>
                  <AppButton type="submit" variant="primary" class="w-full justify-center" :loading="slotForm.processing">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Tambah Slot
                  </AppButton>
                </form>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import AppSidebar from '@/Components/UI/AppSidebar.vue';
import AppButton from '@/Components/UI/AppButton.vue';

const props = defineProps({
    field:     { type: Object, required: true },
    schedules: { type: Object, required: true },
    dates:     { type: Array,  required: true },
});

const selectedDate = ref(props.dates[0] ?? '');
const today        = new Date().toISOString().split('T')[0];

const slotForm = useForm({ schedule_date: '', start_time: '', end_time: '', notes: '' });
const addSlot  = () => slotForm.post(route('owner.schedules.store', props.field.id), { onSuccess: () => slotForm.reset() });

const fmtDateTab = (d) => {
    const dt = new Date(d);
    return dt.toLocaleDateString('id-ID', { weekday:'short', day:'2-digit', month:'2-digit' });
};

const slotClass = (status) => ({
    available: 'border-field bg-primary-light text-primary',
    booked:    'border-blue-100 bg-blue-50 text-blue-600',
    closed:    'border-gray-100 bg-gray-50 text-gray-400',
})[status] ?? 'border-gray-100 bg-gray-50';

function toggleStatus(slot) {
    const newStatus = slot.status === 'available' ? 'closed' : 'available';
    router.patch(route('owner.schedules.update-status', slot.id), { status: newStatus });
}
</script>
