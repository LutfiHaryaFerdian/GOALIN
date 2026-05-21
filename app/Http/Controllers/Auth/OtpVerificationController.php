<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeMail;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class OtpVerificationController extends Controller
{
    public function __construct(private OtpService $otpService) {}

    /**
     * Tampilkan halaman input OTP registrasi.
     */
    public function showRegistrationForm(): View|RedirectResponse
    {
        // Guard: jika tidak ada session register_data, redirect ke register
        if (!session('register_data')) {
            return redirect()->route('register');
        }

        $email = session('register_data.email');

        return view('auth.verify-otp', [
            'type'  => 'registration',
            'email' => $email,
        ]);
    }

    /**
     * Proses verifikasi OTP registrasi.
     */
    public function verifyRegistration(Request $request): RedirectResponse
    {
        $request->validate(['code' => 'required|string|size:6']);

        $data = session('register_data');
        if (!$data) {
            return redirect()->route('register');
        }

        $result = $this->otpService->verify($data['email'], 'registration', $request->code);

        if ($result === 'valid') {
            $user = User::create($data);
            session()->forget('register_data');

            // Kirim welcome email
            Mail::to($user->email)->send(new WelcomeMail($user));

            Auth::login($user);

            // Redirect berdasarkan role yang dipilih saat registrasi
            $redirectTo = match ($user->role) {
                'owner' => route('owner.dashboard'),
                default => route('dashboard'),
            };

            return redirect()->intended($redirectTo);
        }

        $remaining = $this->otpService->getRemainingAttempts($data['email'], 'registration');

        $message = match ($result) {
            'invalid'      => 'Kode OTP salah. Sisa percobaan: ' . $remaining . 'x.',
            'expired'      => 'Kode OTP sudah kadaluarsa. Silakan minta kode baru.',
            'max_attempts' => 'Terlalu banyak percobaan salah. Silakan minta kode OTP baru.',
            'not_found'    => 'Kode OTP tidak ditemukan. Silakan minta kode baru.',
            default        => 'Verifikasi gagal. Silakan coba lagi.',
        };

        return back()->withErrors(['code' => $message]);
    }

    /**
     * Kirim ulang OTP registrasi.
     */
    public function resendRegistration(): RedirectResponse
    {
        $data = session('register_data');
        if (!$data) {
            return redirect()->route('register');
        }

        $this->otpService->send($data['email'], 'registration');

        return back()->with('info', 'Kode OTP baru telah dikirim ke ' . $data['email'] . '.');
    }
}
