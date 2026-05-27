<template>
  <div>
    <label v-if="label" :for="id" class="label">{{ label }}<span v-if="required" class="text-red-400 ml-0.5">*</span></label>
    <input
      :id="id"
      :type="type"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      :placeholder="placeholder"
      :required="required"
      :disabled="disabled"
      :autocomplete="autocomplete"
      class="input"
      :class="{ 'border-red-400 focus:border-red-400 focus:ring-red-400/20': error }"
    />
    <p v-if="error" class="mt-1 text-xs text-red-600">{{ error }}</p>
  </div>
</template>

<script setup>
defineProps({
    modelValue: { type: [String, Number], default: '' },
    label:      { type: String, default: '' },
    id:         { type: String, default: '' },
    type:       { type: String, default: 'text' },
    placeholder:{ type: String, default: '' },
    error:      { type: String, default: '' },
    required:   { type: Boolean, default: false },
    disabled:   { type: Boolean, default: false },
    autocomplete:{ type: String, default: 'off' },
});
defineEmits(['update:modelValue']);
</script>
