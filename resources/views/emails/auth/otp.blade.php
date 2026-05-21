<x-mail::message>
{{-- Header --}}
<div style="text-align:center; padding: 0 0 24px 0;">
    <span style="font-size: 22px; font-weight: 800; color: #1a7a3c; letter-spacing: -0.5px;">GOALIN</span>
</div>

@if ($type === 'registration')
**Halo, terima kasih telah mendaftar di GOALIN.**

Gunakan kode berikut untuk menyelesaikan pendaftaran akun GOALIN kamu.
@elseif ($type === 'password_change')
**Permintaan Ganti Password**

Gunakan kode berikut untuk memverifikasi permintaan ganti password akun GOALIN kamu.
@else
Gunakan kode berikut untuk melanjutkan proses verifikasi akun GOALIN kamu.
@endif

---

{{-- Kode OTP --}}
<div style="text-align: center; margin: 32px 0;">
    <p style="font-size: 13px; color: #6b7280; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 1px;">Kode Verifikasi Kamu</p>
    <div style="display: inline-block; background: #f0fdf4; border: 2px solid #1a7a3c; border-radius: 12px; padding: 20px 40px;">
        <span style="font-family: 'Courier New', Courier, monospace; font-size: 42px; font-weight: 700; color: #1a7a3c; letter-spacing: 12px;">{{ $code }}</span>
    </div>
</div>

---

**Jangan bagikan kode ini kepada siapapun. Tim GOALIN tidak akan pernah meminta kode OTP kamu.**

Kode ini berlaku selama **{{ $expiryMinutes }} menit**. Jika kamu tidak merasa melakukan permintaan ini, abaikan email ini — akun kamu tetap aman.

<x-mail::footer>
&copy; {{ date('Y') }} GOALIN. Semua hak dilindungi.
</x-mail::footer>
</x-mail::message>
