<template>
  <div class="min-h-screen flex">
    <!-- Left panel — green brand side -->
    <div class="hidden lg:flex lg:w-5/12 xl:w-1/2 flex-col relative overflow-hidden bg-primary">
      <!-- Pitch decoration -->
      <div class="absolute inset-0 bg-primary/40"/>
      <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 border-2 border-white/15 rounded-full"/>
      <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-4 h-4 bg-white/20 rounded-full"/>
      <div class="absolute top-0 bottom-0 left-1/2 w-px bg-white/10"/>
      <div class="absolute top-1/2 -translate-y-1/2 left-0 w-24 h-40 border-2 border-white/15 border-l-0"/>
      <div class="absolute top-1/2 -translate-y-1/2 right-0 w-24 h-40 border-2 border-white/15 border-r-0"/>

      <!-- Content -->
      <div class="relative z-10 flex flex-col h-full px-12 py-10">
        <div class="mb-auto">
          <Link :href="route('fields.index')" class="flex items-center gap-2">
            <svg class="w-7 h-7 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="2" y="3" width="20" height="18" rx="2"/><line x1="2" y1="12" x2="22" y2="12"/>
              <line x1="12" y1="3" x2="12" y2="21"/><circle cx="12" cy="12" r="3"/>
            </svg>
            <span class="text-white font-extrabold text-lg">GOALIN</span>
          </Link>
        </div>
        <div class="mb-auto text-center">
          <div class="flex items-center justify-center gap-3 mb-4">
            <svg class="w-12 h-12 text-white/90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
              <rect x="2" y="3" width="20" height="18" rx="2"/><line x1="2" y1="12" x2="22" y2="12"/>
              <line x1="12" y1="3" x2="12" y2="21"/><circle cx="12" cy="12" r="3"/>
            </svg>
            <span class="text-white font-extrabold text-3xl tracking-tight">GOALIN</span>
          </div>
          <p class="text-white/70 text-lg font-medium leading-relaxed">
            Platform reservasi lapangan olahraga.<br>Temukan, pesan, dan bermain.
          </p>
        </div>
        <p class="text-white/40 text-xs">&copy; {{ new Date().getFullYear() }} GOALIN</p>
      </div>
    </div>

    <!-- Right panel — form -->
    <div class="flex-1 flex flex-col justify-center py-12 px-6 sm:px-12 lg:px-16 xl:px-24">
      <!-- Mobile logo -->
      <div class="lg:hidden mb-10 flex justify-center">
        <Link :href="route('fields.index')" class="flex items-center gap-2">
          <svg class="w-7 h-7 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="2" y="3" width="20" height="18" rx="2"/><line x1="2" y1="12" x2="22" y2="12"/>
            <line x1="12" y1="3" x2="12" y2="21"/><circle cx="12" cy="12" r="3"/>
          </svg>
          <span class="font-extrabold text-primary text-xl">GOALIN</span>
        </Link>
      </div>

      <div class="mx-auto w-full max-w-sm">
        <slot />
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>
