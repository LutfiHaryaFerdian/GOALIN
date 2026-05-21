<?php

namespace App\Services;

use App\Mail\OtpMail;
use App\Models\OtpCode;
use Illuminate\Support\Facades\Mail;

class OtpService
{
    const EXPIRY_MINUTES = 10;
    const MAX_ATTEMPTS   = 3;

    /**
     * Generate OTP baru, invalidate OTP lama yang belum dipakai, kirim ke email.
     */
    public function send(string $email, string $type): void
    {
        // Hapus OTP lama yang belum dipakai untuk email + type yang sama
        OtpCode::where('email', $email)
                ->where('type', $type)
                ->where('is_used', false)
                ->delete();

        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        OtpCode::create([
            'email'      => $email,
            'type'       => $type,
            'code'       => $code,
            'attempts'   => 0,
            'is_used'    => false,
            'expires_at' => now()->addMinutes(self::EXPIRY_MINUTES),
        ]);

        Mail::to($email)->send(new OtpMail($code, $type, self::EXPIRY_MINUTES));
    }

    /**
     * Verifikasi kode OTP.
     * Return: 'valid' | 'invalid' | 'expired' | 'max_attempts' | 'not_found'
     */
    public function verify(string $email, string $type, string $code): string
    {
        $otp = OtpCode::where('email', $email)
                      ->where('type', $type)
                      ->where('is_used', false)
                      ->latest()
                      ->first();

        if (!$otp) return 'not_found';

        if ($otp->attempts >= self::MAX_ATTEMPTS) return 'max_attempts';

        if (now()->isAfter($otp->expires_at)) return 'expired';

        if ($otp->code !== $code) {
            $otp->increment('attempts');
            return 'invalid';
        }

        $otp->update(['is_used' => true]);
        return 'valid';
    }

    /**
     * Cek apakah OTP valid masih aktif untuk email + type.
     */
    public function hasPending(string $email, string $type): bool
    {
        return OtpCode::where('email', $email)
                      ->where('type', $type)
                      ->where('is_used', false)
                      ->where('expires_at', '>', now())
                      ->exists();
    }

    /**
     * Ambil sisa percobaan untuk OTP terakhir.
     */
    public function getRemainingAttempts(string $email, string $type): int
    {
        $otp = OtpCode::where('email', $email)
                      ->where('type', $type)
                      ->where('is_used', false)
                      ->latest()
                      ->first();

        if (!$otp) return 0;

        return max(0, self::MAX_ATTEMPTS - $otp->attempts);
    }
}
