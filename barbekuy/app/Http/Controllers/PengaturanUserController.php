<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class PengaturanUserController extends Controller
{
    /** 🧍 Update profil pengguna */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'first_name' => ['required','string','max:100'],
            'last_name'  => ['required','string','max:100'],
            'email'      => ['required','email','max:255', Rule::unique('users','email')->ignore($user->id)],
            'phone'      => ['nullable','string','max:30'],
            'avatar'     => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar_path && Storage::disk('public')->exists($user->avatar_path)) {
                Storage::disk('public')->delete($user->avatar_path);
            }
            $validated['avatar_path'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update([
            'first_name'  => $validated['first_name'],
            'last_name'   => $validated['last_name'],
            'email'       => $validated['email'],
            'phone'       => $validated['phone'] ?? null,
            'avatar_path' => $validated['avatar_path'] ?? $user->avatar_path,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    /** 🔐 Update password */
    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'old_password'          => ['required','string'],
            'password'              => ['required','string','min:8','confirmed'],
            'password_confirmation' => ['required','string','min:8'],
        ]);

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Password lama tidak sesuai.'])->withInput();
        }

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }

    /** 🔔 Update notifikasi */
    public function updateNotif(Request $request)
    {
        $user = $request->user();

        $user->update([
            'notif_email'   => $request->boolean('notif_email'),
            'notif_message' => $request->boolean('notif_message'),
            'notif_payment' => $request->boolean('notif_payment'),
        ]);

        return back()->with('success', 'Pengaturan notifikasi tersimpan.');
    }
}
