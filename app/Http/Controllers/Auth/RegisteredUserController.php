<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\OtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;


class RegisteredUserController extends Controller
{
    public function __construct(private OtpService $otpService) {}

    /**
     * Display the registration view.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     * Tidak langsung buat user — simpan data di session dan kirim OTP.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'phone'    => ['nullable', 'string', 'max:20'],
            'role'     => ['required', 'in:user,owner'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Simpan data form di session (belum buat user)
        session([
            'register_data' => [
                'name'     => $request->name,
                'email'    => $request->email,
                'phone'    => $request->phone,
                'role'     => $request->role,   // dari input, bukan hardcoded
                'password' => bcrypt($request->password),
            ]
        ]);

        // Kirim OTP ke email pendaftar
        $this->otpService->send($request->email, 'registration');

        return redirect()->route('register.verify')
            ->with('info', 'Kode OTP telah dikirim ke ' . $request->email);
    }
}
