<template>
  <nav v-if="links && links.length > 3" class="flex items-center justify-center gap-1 flex-wrap">
    <template v-for="link in links" :key="link.label">
      <span v-if="!link.url"
        class="px-3 py-1.5 text-sm text-gray-300 rounded-lg select-none"
        v-html="link.label"/>
      <Link v-else
        :href="link.url"
        class="px-3 py-1.5 text-sm rounded-lg transition-colors"
        :class="link.active
          ? 'bg-primary text-white font-semibold'
          : 'text-gray-600 hover:bg-primary-light hover:text-primary'"
        v-html="link.label"
        preserve-scroll/>
    </template>
  </nav>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({ links: { type: Array, default: () => [] } });
</script>
