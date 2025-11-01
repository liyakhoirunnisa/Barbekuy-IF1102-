<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PengaturanController extends Controller
{
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'first_name'  => ['nullable', 'string', 'max:100'],
            'last_name'   => ['nullable', 'string', 'max:100'],
            'email'       => ['required', 'email', 'max:191', Rule::unique('users', 'email')->ignore($user->id)],
            'phone'       => ['nullable', 'string', 'max:25'],
            'gender'      => ['nullable', Rule::in(['L', 'P'])],
            'national_id' => ['nullable', 'string', 'max:50'],
            'address'     => ['nullable', 'string', 'max:2000'],
            'avatar'      => ['nullable', 'image', 'max:2048'], // file input, bukan path
        ]);

        // Gabungkan first_name + last_name -> name (opsional)
        $displayName = trim(($validated['first_name'] ?? '') . ' ' . ($validated['last_name'] ?? ''));
        if ($displayName !== '') {
            $validated['name'] = $displayName;
        }

        // Tangani upload avatar (simpan path string ke kolom 'avatar')
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;      // ⬅️ simpan path ke kolom 'avatar'
        } else {
            unset($validated['avatar']);       // ⬅️ jangan menimpa avatar lama jika tidak upload
        }

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'old_password' => ['required'],
            'password'     => ['required', 'min:6', 'confirmed'],
        ]);

        if (! Hash::check($request->old_password, $user->password)) {
            return back()
                ->withErrors(['old_password' => 'Password lama tidak sesuai.'])
                ->withInput();
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password berhasil diperbarui.');
    }

    public function updateNotif(Request $request)
    {
        $user = $request->user();

        $user->update([
            'notif_email'   => $request->boolean('notif_email'),
            'notif_message' => $request->boolean('notif_message'),
            'notif_payment' => $request->boolean('notif_payment'),
        ]);

        return back()->with('success', 'Preferensi notifikasi disimpan.');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'verification_code' => ['required', 'string', 'max:10'],
        ]);

        $user = $request->user();

        if ($user->verification_code && $user->verification_code === $request->verification_code) {
            $user->verification_code = null;
            $user->save();

            return back()->with('success', 'Akun berhasil diverifikasi.');
        }

        return back()->withErrors([
            'verification_code' => 'Kode verifikasi salah atau sudah kadaluarsa.'
        ]);
    }
}
