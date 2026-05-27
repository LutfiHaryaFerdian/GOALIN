<template>
  <AppLayout>
    <Head title="Lapangan Saya" />
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="flex gap-6">
        <AppSidebar section="owner" />
        <main class="flex-1 min-w-0">
          <div class="flex items-center justify-between mb-8">
            <div><p class="section-label">Owner Panel</p><h1 class="text-2xl font-extrabold text-gray-900">Lapangan Saya</h1></div>
            <Link :href="route('owner.fields.create')" class="btn-primary inline-flex items-center gap-2">
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
              Tambah Lapangan
            </Link>
          </div>

          <AppEmpty v-if="!fields.data.length" title="Belum ada lapangan"
            message="Mulai tambahkan lapangan olahraga Anda."
            action-href="/owner/fields/create" action-label="Tambah Lapangan Pertama" />

          <div v-else class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
            <div v-for="field in fields.data" :key="field.id" class="card overflow-hidden">
              <div class="aspect-video bg-primary-light overflow-hidden">
                <img v-if="field.first_image" :src="'/storage/' + field.first_image" :alt="field.name" class="w-full h-full object-cover">
                <div v-else class="w-full h-full flex items-center justify-center">
                  <svg class="w-10 h-10 text-primary opacity-20" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75"/></svg>
                </div>
              </div>
              <div class="p-5">
                <div class="flex items-start justify-between gap-2 mb-2">
                  <h3 class="font-bold text-gray-900 text-sm leading-tight">{{ field.name }}</h3>
                  <AppBadge :status="field.status" />
                </div>
                <p class="text-xs text-gray-500 mb-1">{{ field.category.name }} · {{ field.location.city }}</p>
                <p class="text-sm font-bold text-primary mb-4">Rp {{ fmt(field.price_per_hour) }}/jam</p>
                <div class="grid grid-cols-3 gap-1.5">
                  <Link :href="route('owner.schedules.index', field.id)"
                    class="py-1.5 text-center text-xs font-semibold text-primary bg-primary-light rounded-lg hover:bg-primary hover:text-white transition-colors">Jadwal</Link>
                  <Link :href="route('owner.fields.edit', field.id)"
                    class="py-1.5 text-center text-xs font-semibold text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">Edit</Link>
                  <button @click="destroy(field.id)"
                    class="w-full py-1.5 text-xs font-semibold text-red-500 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">Nonaktif</button>
                </div>
              </div>
            </div>
          </div>

          <div class="mt-6"><AppPagination :links="fields.links" /></div>
        </main>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import AppSidebar from '@/Components/UI/AppSidebar.vue';
import AppBadge from '@/Components/UI/AppBadge.vue';
import AppEmpty from '@/Components/UI/AppEmpty.vue';
import AppPagination from '@/Components/UI/AppPagination.vue';

defineProps({ fields: { type: Object, required: true } });
const fmt     = (v) => new Intl.NumberFormat('id-ID').format(v ?? 0);
const destroy = (id) => {
    if (!confirm('Nonaktifkan lapangan ini?')) return;
    router.delete(route('owner.fields.destroy', id));
};
</script>
