<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LupaSandiController extends Controller
{
    // Tampilkan halaman lupa sandi
    public function showLinkRequestForm()
    {
        return view('auth.lupasandi');
    }

    // Proses kirim email reset password
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    // Tampilkan halaman password baru (dari email reset)
    public function showResetForm(Request $request, $token)
    {
        return view('auth.resetpassword', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    // Simpan password baru
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => ['required'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Kata sandi berhasil direset, silakan masuk kembali.')
            : back()->withErrors(['email' => [__($status)]]);
    }
}
