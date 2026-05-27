<template>
  <Teleport to="body">
    <Transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0" enter-to-class="opacity-100"
      leave-active-class="transition ease-in duration-150" leave-from-class="opacity-100" leave-to-class="opacity-0">
      <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="$emit('close')"/>
        <Transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0 scale-95" enter-to-class="opacity-100 scale-100">
          <div v-if="show" class="relative bg-white rounded-2xl shadow-xl w-full max-w-md p-6 z-10">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-lg font-bold text-gray-900">{{ title }}</h3>
              <button @click="$emit('close')" class="p-1.5 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                </svg>
              </button>
            </div>
            <slot />
          </div>
        </Transition>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
defineProps({ show: Boolean, title: { type: String, default: '' } });
defineEmits(['close']);
</script>
