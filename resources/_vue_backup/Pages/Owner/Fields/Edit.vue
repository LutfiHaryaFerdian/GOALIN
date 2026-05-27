<template>
  <AppLayout>
    <Head title="Edit Lapangan" />
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="flex gap-6">
        <AppSidebar section="owner" />
        <main class="flex-1 min-w-0">
          <div class="flex items-center gap-3 mb-8">
            <Link :href="route('owner.fields.index')" class="p-2 rounded-lg hover:bg-primary-light text-gray-400 hover:text-primary transition-colors">
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
            </Link>
            <div><p class="section-label">Owner Panel</p><h1 class="text-2xl font-extrabold text-gray-900">Edit Lapangan</h1></div>
          </div>

          <form @submit.prevent="submit" enctype="multipart/form-data" class="card p-6 space-y-6 max-w-3xl">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
              <div class="sm:col-span-2">
                <label class="label">Nama Lapangan *</label>
                <input v-model="form.name" type="text" class="input" required :class="{'border-red-400':form.errors.name}">
                <p v-if="form.errors.name" class="mt-1 text-xs text-red-600">{{ form.errors.name }}</p>
              </div>
              <div>
                <label class="label">Kategori *</label>
                <select v-model="form.category_id" class="input" required>
                  <option value="">Pilih Kategori</option>
                  <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                </select>
              </div>
              <div>
                <label class="label">Lokasi *</label>
                <select v-model="form.location_id" class="input" required>
                  <option value="">Pilih Lokasi</option>
                  <option v-for="loc in locations" :key="loc.id" :value="loc.id">{{ loc.name }}, {{ loc.city }}</option>
                </select>
              </div>
              <div>
                <label class="label">Harga per Jam (Rp) *</label>
                <input v-model="form.price_per_hour" type="number" class="input" min="1000" required>
              </div>
              <div>
                <label class="label">Kapasitas *</label>
                <input v-model="form.capacity" type="number" class="input" min="1" required>
              </div>
              <div>
                <label class="label">Status</label>
                <select v-model="form.status" class="input">
                  <option value="active">Aktif</option>
                  <option value="inactive">Nonaktif</option>
                  <option value="maintenance">Maintenance</option>
                </select>
              </div>
              <div class="sm:col-span-2">
                <label class="label">Deskripsi</label>
                <textarea v-model="form.description" rows="3" class="input resize-none"/>
              </div>
              <div class="sm:col-span-2">
                <label class="label">Fasilitas</label>
                <div class="flex flex-wrap gap-3 mt-1">
                  <label v-for="fac in facilityOptions" :key="fac" class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" :value="fac" v-model="form.facilities" class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary">
                    <span class="text-sm text-gray-700 capitalize">{{ fac }}</span>
                  </label>
                </div>
              </div>
              <div class="sm:col-span-2">
                <label class="label">Tambah Foto Lapangan</label>
                <input type="file" multiple accept="image/*" @change="onImages" class="text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary-light file:text-primary hover:file:bg-primary hover:file:text-white file:transition-colors">
              </div>
            </div>
            <div class="flex gap-3 pt-2 border-t border-field">
              <Link :href="route('owner.fields.index')" class="btn-secondary flex-1 justify-center text-center">Batal</Link>
              <AppButton type="submit" variant="primary" class="flex-1 justify-center" :loading="form.processing">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                Simpan Perubahan
              </AppButton>
            </div>
          </form>
        </main>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import AppSidebar from '@/Components/UI/AppSidebar.vue';
import AppButton from '@/Components/UI/AppButton.vue';

const props = defineProps({ field: Object, categories: Array, locations: Array });
const facilityOptions = ['parkir','toilet','mushola','wifi','ac','kantin','loker'];

const form = useForm({
    _method:       'PUT',
    name:          props.field?.name          ?? '',
    category_id:   props.field?.category_id   ?? '',
    location_id:   props.field?.location_id   ?? '',
    price_per_hour:props.field?.price_per_hour ?? '',
    capacity:      props.field?.capacity      ?? 10,
    status:        props.field?.status        ?? 'active',
    description:   props.field?.description   ?? '',
    facilities:    props.field?.facilities    ?? [],
    images:        [],
});

function onImages(e) { form.images = Array.from(e.target.files); }
const submit = () => form.post(route('owner.fields.update', props.field.id), { forceFormData: true });
</script>
