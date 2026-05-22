<x-app-layout>
    <x-slot name="title">Detail Pemesanan</x-slot>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-center gap-3 mb-8">
            <a href="{{ route('bookings.index') }}"
               class="p-2 rounded-lg hover:bg-primary-light text-gray-400 hover:text-primary transition-colors">
                <x-icon name="arrow-left" class="w-5 h-5" />
            </a>
            <div>
                <h1 class="text-2xl font-extrabold text-gray-900">Detail Pemesanan</h1>
                <p class="text-xs font-mono text-gray-400 mt-0.5">{{ $booking->booking_code }}</p>
            </div>
        </div>

        {{-- Status card --}}
        <div class="card p-6 mb-4">
            <div class="flex items-start justify-between gap-4 mb-5">
                <div>
                    <x-status-badge :status="$booking->status" />
                    <h2 class="text-xl font-bold text-gray-900 mt-2">{{ $booking->field->name }}</h2>
                    <p class="flex items-center gap-1.5 text-sm text-gray-500 mt-1">
                        <x-icon name="map-pin" class="w-4 h-4 text-primary" />
                        {{ $booking->field->location->city }}
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-400">Total</p>
                    <p class="text-2xl font-extrabold text-primary">
                        Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 pt-5 border-t border-field text-sm">
                <div>
                    <p class="label">Kategori</p>
                    <p class="font-semibold text-gray-900">{{ $booking->field->category->name }}</p>
                </div>
                <div>
                    <p class="label">Tanggal</p>
                    <p class="font-semibold text-gray-900">
                        {{ $booking->booking_date->locale('id')->isoFormat('dddd, D MMMM Y') }}
                    </p>
                </div>
                <div>
                    <p class="label">Waktu</p>
                    <p class="font-semibold text-gray-900 flex items-center gap-1.5">
                        <x-icon name="clock" class="w-4 h-4 text-primary" />
                        {{ substr($booking->start_time, 0, 5) }} – {{ substr($booking->end_time, 0, 5) }} WIB
                    </p>
                </div>
                <div>
                    <p class="label">Dipesan pada</p>
                    <p class="font-semibold text-gray-900">{{ $booking->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>

            @if($booking->notes)
                <div class="mt-4 pt-4 border-t border-field">
                    <p class="label">Catatan</p>
                    <p class="text-sm text-gray-600">{{ $booking->notes }}</p>
                </div>
            @endif

            @if($booking->cancellation_reason)
                <div class="mt-4 p-3 bg-red-50 rounded-xl border border-red-100">
                    <p class="label text-red-500">Alasan Pembatalan</p>
                    <p class="text-sm text-red-700">{{ $booking->cancellation_reason }}</p>
                </div>
            @endif
        </div>

        {{-- ══════════════════════════════════════
             PAYMENT SECTION
        ══════════════════════════════════════ --}}
        @if($booking->user_id === auth()->id())

            {{-- Tombol Bayar — hanya untuk unpaid & bukan cancelled --}}
            @if($booking->payment_status === 'unpaid' && $booking->status !== 'cancelled')
                <div class="card p-6 mb-4 border-primary/20 bg-gradient-to-br from-white to-primary-light/30"
                     x-data="paymentHandler({{ $booking->id }})">

                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Selesaikan Pembayaran</h3>
                            <p class="text-xs text-gray-500">Pembayaran belum dilakukan. Selesaikan sekarang untuk mengamankan slot Anda.</p>
                        </div>
                        {{-- Badge unpaid --}}
                        <span class="ml-auto inline-flex items-center gap-1 rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-700 shrink-0">
                            Belum Bayar
                        </span>
                    </div>

                    <button
                        id="btn-pay-{{ $booking->id }}"
                        @click="pay()"
                        :disabled="loading"
                        class="w-full rounded-xl bg-primary px-5 py-3 font-semibold text-white text-sm transition hover:bg-primary-dark active:scale-[0.98] disabled:opacity-60 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                    >
                        <svg x-show="loading" class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                        <svg x-show="!loading" class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                        </svg>
                        <span x-show="!loading">Bayar Sekarang — Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                        <span x-show="loading">Memproses...</span>
                    </button>

                    <p x-show="errorMsg" x-text="errorMsg" class="mt-3 text-sm text-red-600 text-center" x-cloak></p>

                    <p class="mt-3 text-center text-xs text-gray-400">
                        Didukung: GoPay, QRIS, Virtual Account, Kartu Kredit, dan lainnya
                    </p>
                </div>
            @endif

            {{-- Badge Lunas --}}
            @if($booking->payment_status === 'paid')
                <div class="card p-5 mb-4 bg-green-50 border-green-200">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-green-800">Pembayaran Lunas</p>
                            <p class="text-xs text-green-600">
                                Pembayaran telah diterima
                                @if($booking->midtrans_payment_type)
                                    via {{ str_replace('_', ' ', strtoupper($booking->midtrans_payment_type)) }}
                                @endif
                            </p>
                        </div>
                        <span class="ml-auto inline-flex items-center gap-1 rounded-full bg-green-100 px-3 py-1 text-sm font-semibold text-green-700">
                            Lunas
                        </span>
                    </div>
                </div>
            @endif

        @endif

        {{-- Cancel form (pending only) --}}
        @if($booking->isPending() && $booking->user_id === auth()->id())
            <div class="card p-6 border-red-100">
                <h3 class="font-bold text-gray-900 mb-1">Batalkan Pemesanan</h3>
                <p class="text-sm text-gray-500 mb-4">
                    Pembatalan akan mengembalikan slot jadwal ke status tersedia.
                </p>
                <form method="POST" action="{{ route('bookings.cancel', $booking) }}"
                      x-data x-on:submit.prevent="if(confirm('Yakin ingin membatalkan pemesanan ini?')) $el.submit()">
                    @csrf
                    @method('PATCH')
                    <input type="text" name="cancellation_reason"
                        placeholder="Alasan pembatalan (opsional)"
                        class="input mb-3">
                    <button type="submit" class="btn-danger w-full justify-center">
                        <x-icon name="x-circle" class="w-4 h-4" />
                        Batalkan Pemesanan
                    </button>
                </form>
            </div>
        @endif
    </div>

    {{-- Alpine.js Midtrans Payment Handler --}}
    <script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('paymentHandler', (bookingId) => ({
            loading: false,
            errorMsg: '',

            async pay() {
                this.loading  = true;
                this.errorMsg = '';

                try {
                    // 1. Minta snap token dari server
                    const res = await fetch(`/payment/${bookingId}/snap-token`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                    });

                    if (!res.ok) {
                        const body = await res.json().catch(() => ({}));
                        throw new Error(body.message || 'Gagal mendapatkan token pembayaran.');
                    }

                    const { snap_token } = await res.json();

                    // 2. Buka popup Snap Midtrans
                    snap.pay(snap_token, {
                        onSuccess: (result) => {
                            window.location.href = '/payment/finish?order_id=' + result.order_id;
                        },
                        onPending: (result) => {
                            window.location.reload();
                        },
                        onError: (result) => {
                            this.errorMsg = 'Pembayaran gagal. Silakan coba lagi.';
                            this.loading  = false;
                        },
                        onClose: () => {
                            this.loading = false;
                        },
                    });

                } catch (err) {
                    this.errorMsg = err.message || 'Terjadi kesalahan. Silakan coba lagi.';
                    this.loading  = false;
                }
            },
        }));
    });
    </script>
</x-app-layout>
