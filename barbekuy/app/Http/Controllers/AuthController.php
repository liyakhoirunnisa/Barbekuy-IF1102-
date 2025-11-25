<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * 🧩 Tampilkan halaman login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * 🔐 Proses login
     */
    public function login(Request $request)
    {
        // ✅ Validasi input
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Ambil kredensial & status "ingat saya"
        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember'); // true kalau checkbox dicentang

        // 🔑 Coba login dengan fitur remember bawaan Laravel
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Ambil user yang login
            $user = Auth::user();

            // Pastikan user punya role (default user)
            if (! $user->role) {
                $user->role = 'user';
                $user->save();
            }

            // 🍪 Kelola cookie untuk "ingat email"
            if ($remember) {
                // Simpan email di cookie 30 hari
                // 60 menit * 24 jam * 30 hari
                cookie()->queue('remember_email', $request->email, 60 * 24 * 30);
            } else {
                // Jika tidak dicentang, hapus cookie email
                cookie()->queue(cookie()->forget('remember_email'));
            }

            // Arahkan sesuai role
            if ($user->role === 'admin') {
                return redirect()->route('admin.beranda')
                    ->with('success', 'Selamat datang, Admin!');
            }

            return redirect()->route('beranda')
                ->with('success', 'Berhasil masuk!');
        }

        // ❌ Jika gagal login
        return back()
            ->with('error', 'Email atau kata sandi salah!')
            ->withInput($request->only('email')); // supaya email tetap keisi
    }

    /**
     * 🚪 Logout user
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // (Opsional) bisa sekalian hapus cookie email kalau mau:
        // cookie()->queue(cookie()->forget('remember_email'));

        return redirect()->route('login')->with('success', 'Berhasil keluar!');
    }

    /**
     * 🌐 Redirect ke Google
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * 🌐 Callback dari Google
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal login dengan Google.');
        }

        $user = User::where('email', $googleUser->getEmail())->first();

        if (! $user) {
            $user = User::create([
                'name' => $googleUser->getName() ?? $googleUser->getNickname() ?? 'Pengguna Google',
                'email' => $googleUser->getEmail(),
                'password' => Hash::make(Str::random(32)),
                'role' => 'user',
            ]);
        }

        Auth::login($user, true);

        if ($user->role === 'admin') {
            return redirect()->route('admin.beranda')->with('success', 'Selamat datang, Admin!');
        }

        return redirect()->route('beranda')->with('success', 'Berhasil masuk dengan Google!');
    }

    /**
     * 📝 Tampilkan halaman daftar
     */
    public function showRegisterForm()
    {
        return view('auth.daftar');
    }

    /**
     * 🧑‍💻 Proses daftar akun baru (role default: user)
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil, silakan masuk!');
    }

    /**
     * 🛠 Daftar admin lewat form
     */
    public function registerAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Simpan user baru dengan role admin
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return redirect()->route('login')->with('success', 'Akun admin berhasil dibuat! Silakan login.');
    }
}
