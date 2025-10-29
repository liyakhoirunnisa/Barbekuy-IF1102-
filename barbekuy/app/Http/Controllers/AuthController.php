<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
        // Validasi input
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Coba login
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Ambil user yang login
            $user = Auth::user();

            // Pastikan user punya role (default user)
            if (!$user->role) {
                $user->role = 'user';
                $user->save();
            }

            // Arahkan sesuai role
            if ($user->role === 'admin') {
                return redirect()->route('admin.beranda')->with('success', 'Selamat datang, Admin!');
            } else {
                return redirect()->route('beranda')->with('success', 'Berhasil masuk!');
            }
        }

        // Jika gagal login
        return back()->with('error', 'Email atau kata sandi salah!')->onlyInput('email');
    }

    /**
     * 🚪 Logout user
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil keluar!');
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
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|string|email|max:255|unique:users',
            'password'              => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user',
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil, silakan masuk!');
    }

    /**
     * 🛠 Tambahan opsional: daftar admin (kalau mau buat admin lewat form)
     */
    // Proses daftar admin
    public function registerAdmin(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|string|email|max:255|unique:users',
            'password'              => 'required|string|min:6|confirmed',
        ]);

        // Simpan user baru dengan role admin
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'admin',
        ]);

        return redirect()->route('login')->with('success', 'Akun admin berhasil dibuat! Silakan login.');
    }

}
