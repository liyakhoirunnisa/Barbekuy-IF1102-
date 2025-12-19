<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PengaturanController extends Controller
{
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:191', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:25'],
            'gender' => ['nullable', Rule::in(['L', 'P'])],
            'address' => ['nullable', 'string', 'max:2000'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], // file input, bukan path
            'remove_avatar' => ['nullable', 'boolean'],
        ]);

        // Gabungkan first_name + last_name -> name (opsional)
        $validated['name'] = trim($validated['first_name'].' '.$validated['last_name']);

        // Hapus avatar jika diminta (set jadi null + hapus file lama)
        if ($request->boolean('remove_avatar')) {
            if ($user->avatar_path && Storage::disk('public')->exists($user->avatar_path)) {
                Storage::disk('public')->delete($user->avatar_path);
            }
            $validated['avatar_path'] = null;
        }

        // Tangani upload avatar (simpan path string ke kolom 'avatar_path')
        if ($request->hasFile('avatar')) {
            if ($user->avatar_path && Storage::disk('public')->exists($user->avatar_path)) {
                Storage::disk('public')->delete($user->avatar_path);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar_path'] = $path;
            $validated['avatar'] = $path;      // ⬅️ simpan path ke kolom 'avatar'
        } else {
            unset($validated['avatar']);       // ⬅️ jangan menimpa avatar lama jika tidak upload
        }

        unset($validated['avatar'], $validated['remove_avatar']);

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'old_password' => ['required'],
            'password' => ['required', 'min:6', 'confirmed'],
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
}
