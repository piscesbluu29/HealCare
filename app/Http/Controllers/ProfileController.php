<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage; // Import ini buat urusan hapus file

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        // 1. Isi data teks (nama, email, dll)
        $user->fill($request->validated());

        // 2. Cek kalau email berubah, reset verifikasi (bawaan Laravel)
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // 3. LOGIKA UPLOAD AVATAR
        if ($request->hasFile('avatar')) {
            // Validasi manual di sini atau bisa taruh di ProfileUpdateRequest
            $request->validate([
                'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            ]);

            // Hapus foto lama dari storage kalau ada (biar gak menu-nuhi server)
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Simpan foto baru ke folder 'avatars' di disk public
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Opsional: Hapus avatar sebelum user dihapus permanen
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}