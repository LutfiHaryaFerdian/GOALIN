<template>
  <AppLayout>
    <Head title="Cari Lapangan" />

    <!-- Hero filter -->
    <div class="bg-primary border-b border-primary-dark">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-2xl font-extrabold text-white mb-1">Cari Lapangan Olahraga</h1>
        <p class="text-white/60 text-sm mb-6">Temukan lapangan terbaik di kotamu</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
          <!-- Search -->
          <div class="lg:col-span-2 flex items-center gap-3 bg-white/10 border border-white/20 rounded-xl px-4 py-2.5 focus-within:ring-2 focus-within:ring-white/40">
            <svg class="w-4 h-4 text-white/50 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 15.803a7.5 7.5 0 0 0 10.607 10.607Z"/>
            </svg>
            <input v-model="filters.search" type="text" placeholder="Cari nama lapangan..."
              class="flex-1 bg-transparent text-sm text-white placeholder-white/40 outline-none">
          </div>

          <!-- Category -->
          <select v-model="filters.category"
            class="bg-white/10 border border-white/20 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-white/40 appearance-none">
            <option value="" class="text-gray-900">Semua Kategori</option>
            <option v-for="cat in categories" :key="cat.id" :value="cat.slug" class="text-gray-900">{{ cat.name }}</option>
          </select>

          <!-- City -->
          <select v-model="filters.city"
            class="bg-white/10 border border-white/20 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-white/40 appearance-none">
            <option value="" class="text-gray-900">Semua Kota</option>
            <option v-for="city in cities" :key="city" :value="city" class="text-gray-900">{{ city }}</option>
          </select>

          <button @click="applyFilters" class="sm:col-span-2 lg:col-span-4 w-full flex items-center justify-center gap-2 py-2.5 bg-white text-primary font-semibold rounded-xl hover:bg-primary-light transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 15.803a7.5 7.5 0 0 0 10.607 10.607Z"/>
            </svg>
            Cari Lapangan
          </button>
        </div>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Active filters -->
      <div v-if="filters.search || filters.category || filters.city"
        class="flex flex-wrap items-center gap-2 mb-6 p-3 bg-primary-light rounded-xl border border-field">
        <span class="text-xs font-semibold text-primary">Filter:</span>
        <span v-if="filters.search" class="flex items-center gap-1 text-xs bg-white border border-field rounded-full px-3 py-1 text-gray-700">
          "{{ filters.search }}"
          <button @click="filters.search = ''; applyFilters()" class="text-gray-400 hover:text-red-500 ml-1">✕</button>
        </span>
        <span v-if="filters.category" class="flex items-center gap-1 text-xs bg-white border border-field rounded-full px-3 py-1 text-gray-700">
          {{ categories.find(c => c.slug === filters.category)?.name }}
          <button @click="filters.category = ''; applyFilters()" class="text-gray-400 hover:text-red-500 ml-1">✕</button>
        </span>
        <span v-if="filters.city" class="flex items-center gap-1 text-xs bg-white border border-field rounded-full px-3 py-1 text-gray-700">
          {{ filters.city }}
          <button @click="filters.city = ''; applyFilters()" class="text-gray-400 hover:text-red-500 ml-1">✕</button>
        </span>
        <button @click="filters.search = ''; filters.category = ''; filters.city = ''; applyFilters()"
          class="text-xs text-red-500 hover:underline ml-auto">Reset semua</button>
      </div>

      <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-gray-500"><span class="font-semibold text-gray-900">{{ fields.total }}</span> lapangan ditemukan</p>
      </div>

      <!-- Grid -->
      <div v-if="fields.data.length" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <FieldCard v-for="field in fields.data" :key="field.id" :field="field" />
      </div>
      <AppEmpty v-else title="Lapangan tidak ditemukan" message="Coba ubah filter pencarian Anda"
        action-href="/fields" action-label="Lihat Semua Lapangan" icon="search" />

      <div class="mt-10">
        <AppPagination :links="fields.links" />
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { reactive } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import FieldCard from '@/Components/Field/FieldCard.vue';
import AppEmpty from '@/Components/UI/AppEmpty.vue';
import AppPagination from '@/Components/UI/AppPagination.vue';

const props = defineProps({
    fields:     { type: Object, required: true },
    categories: { type: Array,  default: () => [] },
    cities:     { type: Array,  default: () => [] },
    filters:    { type: Object, default: () => ({}) },
});

const filters = reactive({
    search:   props.filters?.search   ?? '',
    category: props.filters?.category ?? '',
    city:     props.filters?.city     ?? '',
});

function applyFilters() {
    router.get(route('fields.index'), { ...filters }, { preserveState: true, replace: true });
}
</script>
