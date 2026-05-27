<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\OtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;


class PasswordChangeController extends Controller
{
    public function __construct(private OtpService $otpService) {}

    /**
     * Step 1: Kirim OTP ke email user yang sedang login.
     */
    public function requestOtp(Request $request): RedirectResponse
    {
        $user = $request->user();
        $this->otpService->send($user->email, 'password_change');

        return redirect()->route('password.change.verify')
            ->with('info', 'Kode OTP telah dikirim ke ' . $user->email . '.');
    }

    /**
     * Step 2: Tampilkan halaman input OTP ganti password.
     */
    public function showVerifyForm(Request $request)
    {
        $user = $request->user();

        return view('auth.verify-otp', [
            'type'  => 'password_change',
            'email' => $user->email,
        ]);
    }

    /**
     * Step 3: Verifikasi OTP ganti password.
     */
    public function verifyOtp(Request $request): RedirectResponse
    {
        $request->validate(['code' => 'required|string|size:6']);

        $user   = $request->user();
        $result = $this->otpService->verify($user->email, 'password_change', $request->code);

        if ($result === 'valid') {
            session(['password_otp_verified' => true]);
            return redirect()->route('password.change.form')
                ->with('success', 'Verifikasi berhasil. Silakan masukkan password baru.');
        }

        $remaining = $this->otpService->getRemainingAttempts($user->email, 'password_change');

        $message = match ($result) {
            'invalid'      => 'Kode OTP salah. Sisa percobaan: ' . $remaining . 'x.',
            'expired'      => 'Kode OTP sudah kadaluarsa. Silakan minta kode baru.',
            'max_attempts' => 'Terlalu banyak percobaan salah. Silakan minta kode OTP baru.',
            default        => 'Verifikasi gagal.',
        };

        return back()->withErrors(['code' => $message]);
    }

    /**
     * Step 4: Tampilkan form input password baru.
     */
    public function showChangeForm()
    {
        // Guard: jika belum verifikasi OTP, redirect ke profil
        if (!session('password_otp_verified')) {
            return redirect()->route('profile.edit')
                ->withErrors(['otp' => 'Silakan verifikasi OTP terlebih dahulu.']);
        }

        return view('auth.change-password');
    }

    /**
     * Step 5: Simpan password baru.
     */
    public function update(Request $request): RedirectResponse
    {
        // Guard: cek session OTP verified
        if (!session('password_otp_verified')) {
            return redirect()->route('profile.edit');
        }

        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $request->user()->update([
            'password' => bcrypt($request->password),
        ]);

        session()->forget('password_otp_verified');

        // Logout semua session lain (keamanan)
        Auth::logoutOtherDevices($request->password);

        return redirect()->route('profile.edit')
            ->with('success', 'Password berhasil diubah. Semua perangkat lain telah dikeluarkan.');
    }

    /**
     * Kirim ulang OTP ganti password.
     */
    public function resendOtp(Request $request): RedirectResponse
    {
        $user = $request->user();
        $this->otpService->send($user->email, 'password_change');

        return back()->with('info', 'Kode OTP baru telah dikirim ke ' . $user->email . '.');
    }
}
