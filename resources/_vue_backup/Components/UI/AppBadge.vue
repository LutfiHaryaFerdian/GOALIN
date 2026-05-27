<template>
  <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold" :class="styles[status] ?? styles.default">
    {{ labels[status] ?? status }}
  </span>
</template>

<script setup>
defineProps({ status: { type: String, default: 'default' } });

const labels = {
  pending:   'Pending',
  confirmed: 'Dikonfirmasi',
  cancelled: 'Dibatalkan',
  completed: 'Selesai',
  paid:      'Lunas',
  unpaid:    'Belum Bayar',
  active:    'Aktif',
  inactive:  'Nonaktif',
};

const styles = {
  pending:   'bg-amber-100 text-amber-700',
  confirmed: 'bg-primary-light text-primary',
  cancelled: 'bg-red-100 text-red-700',
  completed: 'bg-blue-100 text-blue-700',
  paid:      'bg-green-100 text-green-700',
  unpaid:    'bg-amber-100 text-amber-700',
  active:    'bg-primary-light text-primary',
  inactive:  'bg-gray-100 text-gray-600',
  default:   'bg-gray-100 text-gray-600',
};
</script>
