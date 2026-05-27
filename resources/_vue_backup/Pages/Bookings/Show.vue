<template>
  <AppLayout>
    <Head title="Detail Pemesanan" />
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
      <div class="flex items-center gap-3 mb-8">
        <Link :href="route('bookings.index')" class="p-2 rounded-lg hover:bg-primary-light text-gray-400 hover:text-primary transition-colors">
          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
        </Link>
        <div>
          <h1 class="text-2xl font-extrabold text-gray-900">Detail Pemesanan</h1>
          <p class="text-xs font-mono text-gray-400 mt-0.5">{{ booking.booking_code }}</p>
        </div>
      </div>

      <div class="card p-6 mb-4">
        <div class="flex items-start justify-between gap-4 mb-5">
          <div>
            <AppBadge :status="booking.status" />
            <h2 class="text-xl font-bold text-gray-900 mt-2">{{ booking.field.name }}</h2>
            <p class="text-sm text-gray-500 mt-1">{{ booking.field.location.city }}</p>
          </div>
          <div class="text-right">
            <p class="text-xs text-gray-400">Total</p>
            <p class="text-2xl font-extrabold text-primary">Rp {{ fmt(booking.total_price) }}</p>
          </div>
        </div>
        <div class="grid grid-cols-2 gap-4 pt-5 border-t border-field text-sm">
          <div><p class="label">Kategori</p><p class="font-semibold text-gray-900">{{ booking.field.category.name }}</p></div>
          <div><p class="label">Tanggal</p><p class="font-semibold text-gray-900">{{ fmtDate(booking.booking_date) }}</p></div>
          <div><p class="label">Waktu</p><p class="font-semibold text-gray-900">{{ booking.start_time.slice(0,5) }} – {{ booking.end_time.slice(0,5) }} WIB</p></div>
          <div><p class="label">Dipesan pada</p><p class="font-semibold text-gray-900">{{ fmtDatetime(booking.created_at) }}</p></div>
        </div>
        <div v-if="booking.notes" class="mt-4 pt-4 border-t border-field">
          <p class="label">Catatan</p><p class="text-sm text-gray-600">{{ booking.notes }}</p>
        </div>
        <div v-if="booking.cancellation_reason" class="mt-4 p-3 bg-red-50 rounded-xl border border-red-100">
          <p class="label text-red-500">Alasan Pembatalan</p>
          <p class="text-sm text-red-700">{{ booking.cancellation_reason }}</p>
        </div>
      </div>

      <!-- Payment -->
      <template v-if="isOwn">
        <div v-if="booking.payment_status === 'unpaid' && booking.status !== 'cancelled'"
          class="card p-6 mb-4 border-primary/20 bg-gradient-to-br from-white to-primary-light/30">
          <h3 class="font-bold text-gray-900 mb-3">Selesaikan Pembayaran</h3>
          <AppButton variant="primary" size="lg" class="w-full" :loading="paying" @click="handlePay">
            Bayar Sekarang — Rp {{ fmt(booking.total_price) }}
          </AppButton>
          <p v-if="payError" class="mt-3 text-sm text-red-600 text-center">{{ payError }}</p>
          <p class="mt-3 text-center text-xs text-gray-400">GoPay, QRIS, Virtual Account, Kartu Kredit</p>
        </div>

        <div v-if="booking.payment_status === 'paid'" class="card p-5 mb-4 bg-green-50 border-green-200">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center shrink-0">
              <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
            </div>
            <div>
              <p class="font-bold text-green-800">Pembayaran Lunas</p>
              <p class="text-xs text-green-600">Pembayaran telah diterima</p>
            </div>
          </div>
        </div>

        <div v-if="isPending" class="card p-6 border-red-100">
          <h3 class="font-bold text-gray-900 mb-1">Batalkan Pemesanan</h3>
          <p class="text-sm text-gray-500 mb-4">Pembatalan akan mengembalikan slot jadwal ke status tersedia.</p>
          <form @submit.prevent="cancelBooking">
            <input v-model="cancelReason" type="text" placeholder="Alasan pembatalan (opsional)" class="input mb-3">
            <AppButton type="submit" variant="danger" class="w-full" :loading="cancelling">Batalkan Pemesanan</AppButton>
          </form>
        </div>
      </template>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import AppBadge from '@/Components/UI/AppBadge.vue';
import AppButton from '@/Components/UI/AppButton.vue';

const props = defineProps({ booking: { type: Object, required: true } });
const page  = usePage();
const auth  = computed(() => page.props.auth);
const isOwn = computed(() => auth.value.user?.id === props.booking.user_id);
const isPending = computed(() => props.booking.status === 'pending' && isOwn.value);

const fmt        = (v) => new Intl.NumberFormat('id-ID').format(v ?? 0);
const fmtDate    = (d) => d ? new Date(d).toLocaleDateString('id-ID',{weekday:'long',day:'numeric',month:'long',year:'numeric'}) : '-';
const fmtDatetime= (d) => d ? new Date(d).toLocaleString('id-ID',{day:'numeric',month:'short',year:'numeric',hour:'2-digit',minute:'2-digit'}) : '-';

const paying  = ref(false);
const payError = ref('');
async function handlePay() {
    paying.value = true; payError.value = '';
    try {
        const res = await fetch(`/payment/${props.booking.id}/snap-token`, {
            method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]')?.content}
        });
        if (!res.ok) throw new Error((await res.json().catch(()=>({}))).message || 'Gagal mendapatkan token');
        const { snap_token } = await res.json();
        window.snap.pay(snap_token, {
            onSuccess:(r)=>{ window.location.href='/payment/finish?order_id='+r.order_id; },
            onPending:()=>{ window.location.reload(); },
            onError:()=>{ payError.value='Pembayaran gagal. Silakan coba lagi.'; paying.value=false; },
            onClose:()=>{ paying.value=false; }
        });
    } catch(err) { payError.value=err.message||'Terjadi kesalahan.'; paying.value=false; }
}

const cancelReason = ref('');
const cancelling   = ref(false);
function cancelBooking() {
    if (!confirm('Yakin ingin membatalkan pemesanan ini?')) return;
    cancelling.value = true;
    router.patch(route('bookings.cancel', props.booking.id), { cancellation_reason: cancelReason.value }, {
        onFinish: () => { cancelling.value = false; }
    });
}
</script>
