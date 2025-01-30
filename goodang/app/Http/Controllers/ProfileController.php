<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the profile of the currently authenticated user.
     */
    public function show()
    {
        $user = Auth::user(); 
        return view('profiles.show', compact('user'));
    }

    /**
     * Show the form for editing the authenticated user's profile.
     */
    public function edit()
    {
        $user = Auth::user(); 
        return view('profiles.edit', compact('user'));
    }

    /**
     * Update the authenticated user's profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'current_password' => $request->filled('password') && $user->role !== 'admin'
                ? 'required|string' : '',
            'alamat' => 'nullable|max:255', 
            'nomor_telepon' => 'nullable|digits_between:10,13|unique:users,nomor_telepon,' . $user->id, // Pastikan atribut ini ada
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->filled('password') && $user->role !== 'admin') {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password lama tidak cocok.']);
            }
        }

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->alamat = $request->alamat; 
        $user->nomor_telepon = $request->nomor_telepon; 

        if ($request->hasFile('profile_photo')) {
            $photo = $request->file('profile_photo');
            $path = $photo->store('profile-photos', 'public');
            $user->profile_photo_path = $path;
        }

        $user->save();

        return redirect()->route('profiles.show', Auth::id())->with('success', 'Profil berhasil diperbarui.');
    }
}
