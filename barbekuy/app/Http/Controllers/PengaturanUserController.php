<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PengaturanUserController extends Controller
{
    /**
     * Tampilkan halaman pengaturan user (customer).
     */
    public function index(Request $request)
    {
        $user = $request->user(); // kalau mau dipakai di view

        return view('pengaturan', compact('user'));
    }

    /** 🧍 Update profil pengguna */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        // ✅ Field disesuaikan dengan form di pengaturan.blade.php
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'phone' => ['nullable', 'string', 'max:30'],
            'gender' => ['nullable', Rule::in(['L', 'P'])],
            'address' => ['nullable', 'string', 'max:2000'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_avatar' => ['nullable', 'boolean'],
        ]);

        // ✅ Handle avatar (opsional)
        if ($request->boolean('remove_avatar')) {
            if ($user->avatar_path && Storage::disk('public')->exists($user->avatar_path)) {
                Storage::disk('public')->delete($user->avatar_path);
            }

            $validated['avatar_path'] = null;
        }

        if ($request->hasFile('avatar')) {
            // hapus file lama jika ada
            if ($user->avatar_path && Storage::disk('public')->exists($user->avatar_path)) {
                Storage::disk('public')->delete($user->avatar_path);
            }

            $validated['avatar_path'] = $request->file('avatar')->store('avatars', 'public');
        }

        // avatar bukan kolom di tabel, jadi kita buang
        unset($validated['avatar'], $validated['remove_avatar']);

        // ✅ Update user dengan data tervalidasi
        $user->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? $user->phone,
            'gender' => $validated['gender'] ?? $user->gender,
            'address' => $validated['address'] ?? $user->address,
            'avatar_path' => array_key_exists('avatar_path', $validated) ? $validated['avatar_path'] : $user->avatar_path,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    /** 🔐 Update password */
    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'old_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:8'],
        ]);

        // cek password lama
        if (! Hash::check($request->old_password, $user->password)) {
            return back()
                ->withErrors(['old_password' => 'Password lama tidak sesuai.'])
                ->withInput();
        }

        // simpan password baru
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }

    // 🗑️ Method updateNotif() dan verify() tidak dipakai lagi
    // karena bagian Notifikasi & Verifikasi sudah dihapus dari view.
}
