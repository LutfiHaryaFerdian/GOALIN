@component('mail::message')
# Pembayaran Berhasil!

Halo, **{{ $booking->user->name }}**,

Pembayaran untuk pemesanan lapangan kamu telah kami terima. Berikut detail pemesanan Anda.

@component('mail::panel')
**Kode Booking:** {{ $booking->booking_code }}

**Lapangan:** {{ $booking->field->name }}

**Tanggal:** {{ $booking->booking_date->locale('id')->isoFormat('dddd, D MMMM Y') }}

**Waktu:** {{ substr($booking->start_time, 0, 5) }} – {{ substr($booking->end_time, 0, 5) }} WIB

**Total Pembayaran:** Rp {{ number_format($booking->total_price, 0, ',', '.') }}

@if($booking->midtrans_payment_type)
**Metode Pembayaran:** {{ str_replace('_', ' ', strtoupper($booking->midtrans_payment_type)) }}
@endif
@endcomponent

@component('mail::button', ['url' => route('bookings.show', $booking), 'color' => 'green'])
Lihat Detail Pemesanan
@endcomponent

Sampai jumpa di lapangan!

Salam,
Tim **{{ config('app.name') }}**
@endcomponent
