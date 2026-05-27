<template>
  <div>
    <!-- Date tabs -->
    <div class="flex gap-1.5 overflow-x-auto pb-2 mb-4" style="-ms-overflow-style:none;scrollbar-width:none;">
      <button v-for="date in dates" :key="date"
        @click="selectedDate = date"
        :class="selectedDate === date ? 'bg-primary text-white' : 'bg-accent text-gray-600 hover:bg-primary-light hover:text-primary'"
        class="shrink-0 flex flex-col items-center px-3 py-2 rounded-xl text-center transition-colors min-w-[52px]">
        <span class="text-[10px] font-semibold uppercase">{{ dayName(date) }}</span>
        <span class="text-base font-extrabold leading-none mt-0.5">{{ dayNum(date) }}</span>
        <span class="text-[9px] mt-0.5 opacity-70">{{ monthName(date) }}</span>
      </button>
    </div>

    <!-- Consecutive error -->
    <Transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0 -translate-y-1" enter-to-class="opacity-100 translate-y-0"
      leave-active-class="transition ease-in duration-150" leave-to-class="opacity-0">
      <div v-if="consecutiveError"
        class="mb-3 p-2.5 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-700 text-center font-medium">
        ⚠️ Slot harus berurutan (bersebelahan)
      </div>
    </Transition>

    <!-- Live update toast -->
    <Transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0" enter-to-class="opacity-100"
      leave-to-class="opacity-0">
      <div v-if="slotUpdated"
        class="mb-3 p-2 bg-primary-light border border-primary/20 rounded-xl text-xs text-primary text-center">
        ↻ Ketersediaan slot diperbarui
      </div>
    </Transition>

    <!-- Slot grid -->
    <div v-if="slotsForDate.length" class="grid grid-cols-2 gap-2">
      <button v-for="slot in slotsForDate" :key="slot.id"
        @click="toggleSlot(slot)"
        :disabled="slot.status !== 'available'"
        class="relative flex flex-col items-center py-3 px-2 rounded-xl border text-center transition-all duration-150"
        :class="slotClass(slot)">
        <span class="text-sm font-bold">{{ slot.start_time.slice(0,5) }}</span>
        <span class="text-[10px] mt-0.5">{{ slot.end_time.slice(0,5) }}</span>
        <!-- Selected check -->
        <span v-if="isSelected(slot)"
          class="absolute top-1.5 right-1.5 w-4 h-4 bg-primary rounded-full flex items-center justify-center">
          <svg class="w-2.5 h-2.5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
          </svg>
        </span>
        <span class="text-[10px] mt-1 capitalize opacity-70">
          {{ slot.status === 'available' ? 'Tersedia' : slot.status === 'booked' ? 'Terpesan' : 'Tutup' }}
        </span>
      </button>
    </div>
    <div v-else class="py-8 text-center text-sm text-gray-400">Belum ada slot untuk tanggal ini.</div>

    <!-- Legend -->
    <div class="flex gap-4 mt-4 text-xs text-gray-400">
      <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded bg-primary-light border border-primary/20 inline-block"/>&nbsp;Tersedia</span>
      <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded bg-blue-50 border border-blue-100 inline-block"/>&nbsp;Terpesan</span>
      <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded bg-gray-50 border border-gray-100 inline-block"/>&nbsp;Tutup</span>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    schedules:    { type: Object, required: true }, // grouped by date
    dates:        { type: Array,  required: true },
    pricePerHour: { type: Number, required: true },
    maxSlots:     { type: Number, default: 4 },
    pollUrl:      { type: String, default: '' },
});

const emit = defineEmits(['update:selected']);

// State
const selectedDate    = ref(props.dates[0] ?? '');
const selectedSlots   = ref([]);
const consecutiveError= ref(false);
const slotUpdated     = ref(false);

// Mutable schedule map patched by polling
const slotMap = ref({});
watch(() => props.schedules, (s) => { slotMap.value = JSON.parse(JSON.stringify(s)); }, { immediate: true, deep: true });

const slotsForDate = computed(() => slotMap.value[selectedDate.value] ?? []);

// Helpers
function isSelected(slot) { return selectedSlots.value.some(s => s.id === slot.id); }

function slotClass(slot) {
    if (isSelected(slot)) return 'border-primary bg-primary/10 text-primary ring-2 ring-primary/30';
    if (slot.status === 'available') return 'border-field bg-primary-light text-primary hover:border-primary cursor-pointer';
    if (slot.status === 'booked')    return 'border-blue-100 bg-blue-50 text-blue-400 cursor-not-allowed opacity-70';
    return 'border-gray-100 bg-gray-50 text-gray-300 cursor-not-allowed opacity-60';
}

function toggleSlot(slot) {
    if (slot.status !== 'available') return;
    if (isSelected(slot)) {
        selectedSlots.value = selectedSlots.value.filter(s => s.id !== slot.id);
        emit('update:selected', selectedSlots.value);
        return;
    }
    if (selectedSlots.value.length >= props.maxSlots) return;

    const candidate = [...selectedSlots.value, slot].sort((a, b) => a.start_time.localeCompare(b.start_time));
    const isConsecutive = candidate.every((s, i) => i === 0 || s.start_time === candidate[i-1].end_time);
    if (!isConsecutive) {
        consecutiveError.value = true;
        setTimeout(() => consecutiveError.value = false, 3000);
        return;
    }
    selectedSlots.value.push(slot);
    emit('update:selected', selectedSlots.value);
}

// Expose computed for parent
const totalPrice = computed(() => selectedSlots.value.length * props.pricePerHour);
const timeRange  = computed(() => {
    if (!selectedSlots.value.length) return null;
    const sorted = [...selectedSlots.value].sort((a, b) => a.start_time.localeCompare(b.start_time));
    return { start: sorted[0].start_time.slice(0,5), end: sorted.at(-1).end_time.slice(0,5) };
});
defineExpose({ selectedSlots, totalPrice, timeRange });

// Date formatting
const locale = 'id-ID';
function dayName(d) { return new Date(d).toLocaleDateString(locale, { weekday: 'short' }); }
function dayNum(d)  { return new Date(d).getDate(); }
function monthName(d) { return new Date(d).toLocaleDateString(locale, { month: 'short' }); }

// Polling
let pollTimer = null;
onMounted(() => {
    if (!props.pollUrl) return;
    pollTimer = setInterval(doPoll, 30000);
});
onUnmounted(() => { if (pollTimer) clearInterval(pollTimer); });

async function doPoll() {
    try {
        const params = props.dates.map(d => `dates[]=${d}`).join('&');
        const res = await fetch(`${props.pollUrl}?${params}`, { headers: { Accept: 'application/json' } });
        if (!res.ok) return;
        const { slots } = await res.json();
        let changed = false;
        for (const date in slotMap.value) {
            slotMap.value[date].forEach(slot => {
                if (slots[slot.id] !== undefined && slots[slot.id] !== slot.status) {
                    slot.status = slots[slot.id];
                    changed = true;
                    if (slot.status !== 'available') {
                        selectedSlots.value = selectedSlots.value.filter(s => s.id !== slot.id);
                    }
                }
            });
        }
        if (changed) { slotUpdated.value = true; setTimeout(() => slotUpdated.value = false, 4000); }
    } catch { /* silent */ }
}
</script>
