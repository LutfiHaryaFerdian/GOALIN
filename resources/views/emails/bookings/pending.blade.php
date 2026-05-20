@component('mail::message')
# GOALIN

Halo, {{ $user->name }},

Pemesanan kamu telah diterima dan sedang **menunggu konfirmasi** dari pengelola lapangan. Kami akan menginformasikan kamu segera setelah pemesanan dikonfirmasi.

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

@component('mail::button', ['url' => route('bookings.show', $booking), 'color' => 'primary'])
Lihat Detail Pemesanan
@endcomponent

Terima kasih telah menggunakan **GOALIN**.

@component('mail::subcopy')
Jangan balas email ini. Untuk bantuan, hubungi pengelola lapangan.
@endcomponent
@endcomponent
