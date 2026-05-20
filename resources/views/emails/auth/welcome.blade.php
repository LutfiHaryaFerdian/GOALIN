@component('mail::message')
# GOALIN

## Halo, {{ $user->name }}! Selamat Datang di GOALIN.

Akun kamu telah **berhasil dibuat**. Sekarang kamu bisa mencari dan memesan lapangan olahraga favoritmu kapan saja, di mana saja.

@component('mail::panel')
**Detail Akun Kamu**

| Keterangan | Detail |
|:-----------|:-------|
| Nama       | {{ $user->name }} |
| Email      | {{ $user->email }} |
| Tipe Akun  | {{ ucfirst($user->role) }} |
@endcomponent

@component('mail::button', ['url' => route('fields.index'), 'color' => 'success'])
Mulai Cari Lapangan
@endcomponent

Selamat bermain dan sampai jumpa di lapangan!

@component('mail::subcopy')
Jangan balas email ini. Untuk bantuan, hubungi tim GOALIN.
@endcomponent
@endcomponent
