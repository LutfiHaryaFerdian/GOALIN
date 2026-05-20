@component('mail::message')
# GOALIN

## Terima Kasih Telah Menggunakan GOALIN!

Halo, {{ $user->name }},

Pemesananmu telah **selesai**. Bagikan pengalamanmu dengan memberikan ulasan untuk lapangan ini agar pengguna lain bisa menemukan lapangan terbaik.

@component('mail::panel')
**Detail Pemesanan**

| Keterangan   | Detail |
|:-------------|:-------|
| Kode Booking | {{ $booking->booking_code }} |
| Lapangan     | {{ $field->name }} |
| Lokasi       | {{ $location->name }} |
| Tanggal      | {{ $booking->booking_date->translatedFormat('d F Y') }} |
| Waktu        | {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} — {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }} WIB |
| Total Harga  | Rp {{ number_format($booking->total_price, 0, ',', '.') }} |
@endcomponent

@component('mail::button', ['url' => route('fields.show', $field->slug), 'color' => 'success'])
Beri Ulasan
@endcomponent

@component('mail::subcopy')
Jangan balas email ini. Untuk bantuan, hubungi pengelola lapangan.
@endcomponent
@endcomponent
