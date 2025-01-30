<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Gudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('gudang')->orderBy('created_at', 'DESC')->get();
        return response()->json(['success' => true, 'data' => $users], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:2|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required',
            'nomor_telepon' => 'required|digits_between:10,13|unique:users,nomor_telepon',
            'no_goodang' => 'nullable|unique:users,no_goodang',
            'alamat' => 'required|max:255',
            'id_gudang' => $request->role == 'staff' ? 'required|exists:gudangs,id' : 'nullable',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'nomor_telepon' => $validated['nomor_telepon'],
            'no_goodang' => $validated['no_goodang'],
            'alamat' => $validated['alamat'],
            'id_gudang' => $validated['role'] == 'staff' ? $validated['id_gudang'] : null,
        ]);

        return response()->json(['success' => true, 'message' => 'User created successfully.', 'data' => $user], 201);
    }

    public function show($id)
    {
        $user = User::with('gudang')->find($id);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }

        return response()->json(['success' => true, 'data' => $user], 200);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|min:2|max:50',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6|confirmed',
            'role' => 'required',
            'nomor_telepon' => 'required|digits_between:10,13|unique:users,nomor_telepon,' . $id,
            'no_goodang' => 'nullable|unique:users,no_goodang,' . $id,
            'alamat' => 'required|max:255',
            'id_gudang' => $request->role == 'staff' ? 'required|exists:gudangs,id' : 'nullable',
        ]);

        if (Auth::user()->id === $user->id && Auth::user()->role === 'admin') {
            $request->merge(['role' => $user->role]); // Prevent role changes for self
        }

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $request->filled('password') ? Hash::make($validated['password']) : $user->password,
            'role' => $validated['role'],
            'nomor_telepon' => $validated['nomor_telepon'],
            'no_goodang' => $validated['no_goodang'],
            'alamat' => $validated['alamat'],
            'id_gudang' => $validated['role'] == 'staff' ? $validated['id_gudang'] : null,
        ]);

        return response()->json(['success' => true, 'message' => 'User updated successfully.', 'data' => $user], 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }

        $user->delete();

        return response()->json(['success' => true, 'message' => 'User deleted successfully.'], 200);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['success' => true, 'message' => 'Logged out successfully.'], 200);
    }
}
