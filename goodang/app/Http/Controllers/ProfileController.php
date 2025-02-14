<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Menampilkan profil pengguna yang sedang login.
     */
    public function show()
    {
        $user = Auth::user(); 
        return view('profiles.show', compact('user'));
    }

    /**
     * Menampilkan form untuk mengedit profil pengguna yang sedang login.
     */
    public function edit()
    {
        $user = Auth::user(); 
        return view('profiles.edit', compact('user'));
    }

    /**
     * Memperbarui data profil pengguna yang sedang login.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password'        => 'nullable|string|min:8|confirmed',
            'current_password'=> $request->filled('password') && $user->role !== 'admin'
                                    ? 'required|string' : '',
            'alamat'          => 'nullable|string|max:255',
            'nomor_telepon'   => 'nullable|min:10|max:19|unique:users,nomor_telepon,' . $user->id,
            'profile_photo'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Jika pengguna mengganti password, verifikasi password lama terlebih dahulu
        if ($request->filled('password') && $user->role !== 'admin') {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password lama tidak cocok.']);
            }
        }

        // Update data profil
        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Simpan tambahan data: alamat dan nomor telepon
        $user->alamat = $request->alamat;
        $user->nomor_telepon = $request->nomor_telepon;

        // Proses upload foto profil jika ada
        if ($request->hasFile('profile_photo')) {
            $photo = $request->file('profile_photo');
            $path = $photo->store('profile-photos', 'public');
            $user->profile_photo_path = $path;
        }

        $user->save();

        return redirect()->route('profiles.show', Auth::id())->with('success', 'Profil berhasil diperbarui.');
    }
}
