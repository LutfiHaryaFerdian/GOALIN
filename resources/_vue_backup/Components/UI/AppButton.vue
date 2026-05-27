<template>
  <button
    :type="type"
    :disabled="disabled || loading"
    class="inline-flex items-center justify-center gap-2 font-semibold rounded-xl transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed"
    :class="[variantClass, sizeClass]">
    <svg v-if="loading" class="animate-spin w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24">
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
    </svg>
    <slot />
  </button>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    variant: { type: String, default: 'primary' },
    size:    { type: String, default: 'md' },
    type:    { type: String, default: 'button' },
    loading: { type: Boolean, default: false },
    disabled:{ type: Boolean, default: false },
});

const variantClass = computed(() => ({
    primary:   'bg-primary text-white hover:bg-primary-dark focus:ring-primary active:scale-[0.98]',
    secondary: 'bg-white text-gray-700 border border-gray-200 hover:bg-gray-50 focus:ring-gray-300',
    danger:    'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500 active:scale-[0.98]',
    ghost:     'text-gray-600 hover:bg-gray-100 focus:ring-gray-300',
})[props.variant] ?? '');

const sizeClass = computed(() => ({
    sm: 'px-3 py-1.5 text-xs',
    md: 'px-4 py-2.5 text-sm',
    lg: 'px-5 py-3 text-sm',
})[props.size] ?? 'px-4 py-2.5 text-sm');
</script>
