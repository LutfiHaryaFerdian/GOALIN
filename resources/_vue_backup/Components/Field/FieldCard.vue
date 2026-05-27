<template>
  <Link :href="route('fields.show', field.slug)" class="card overflow-hidden group hover:shadow-md transition-shadow">
    <!-- Image -->
    <div class="aspect-video bg-primary-light overflow-hidden">
      <img v-if="field.images && field.images.length"
        :src="'/storage/' + field.images[0]"
        :alt="field.name"
        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
      <div v-else class="w-full h-full flex items-center justify-center">
        <svg class="w-10 h-10 text-primary/30" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0 0 12 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 0 1-2.031.352 5.988 5.988 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.971Zm-16.5.52c.99-.203 1.99-.377 3-.52m0 0 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 0 1-2.031.352 5.989 5.989 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L5.25 4.971Z"/>
        </svg>
      </div>
    </div>

    <!-- Info -->
    <div class="p-4">
      <div class="flex items-center gap-2 mb-2">
        <span class="text-xs font-semibold text-primary bg-primary-light px-2 py-0.5 rounded-full">
          {{ field.category?.name }}
        </span>
      </div>
      <h3 class="font-bold text-gray-900 mb-1 truncate group-hover:text-primary transition-colors">{{ field.name }}</h3>
      <div class="flex items-center gap-1.5 text-xs text-gray-500 mb-3">
        <svg class="w-3.5 h-3.5 text-primary shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
        </svg>
        {{ field.location?.city }}
      </div>
      <div class="flex items-center justify-between">
        <div>
          <p class="text-xs text-gray-400">Mulai dari</p>
          <p class="font-extrabold text-primary">Rp {{ formatPrice(field.price_per_hour) }}<span class="text-xs text-gray-400 font-normal">/jam</span></p>
        </div>
        <span class="text-xs font-semibold text-primary bg-primary-light px-3 py-1.5 rounded-lg group-hover:bg-primary group-hover:text-white transition-colors">
          Lihat →
        </span>
      </div>
    </div>
  </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({ field: { type: Object, required: true } });

const formatPrice = (v) => new Intl.NumberFormat('id-ID').format(v ?? 0);
</script>
