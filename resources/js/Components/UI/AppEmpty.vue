<template>
  <div class="text-center py-16">
    <div class="w-16 h-16 bg-primary-light rounded-2xl flex items-center justify-center mx-auto mb-4">
      <svg class="w-8 h-8 text-primary" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" :d="iconPath"/>
      </svg>
    </div>
    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ title }}</h3>
    <p class="text-gray-500 text-sm mb-6">{{ message }}</p>
    <Link v-if="actionHref" :href="actionHref" class="btn-primary inline-flex">{{ actionLabel }}</Link>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    title:       { type: String, default: 'Data tidak ditemukan' },
    message:     { type: String, default: '' },
    icon:        { type: String, default: 'search' },
    actionHref:  { type: String, default: '' },
    actionLabel: { type: String, default: 'Kembali' },
});

const iconPath = computed(() => ({
    search:    'M21 21l-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 15.803a7.5 7.5 0 0 0 10.607 10.607z',  // approximation
    bell:      'M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0',
    clipboard: 'M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z',
})[props.icon] ?? '');
</script>
