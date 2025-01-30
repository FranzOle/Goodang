<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Gudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('gudang')->orderby('created_at', 'DESC')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $gudang = Gudang::all();
        return view('users.create', compact('gudang'));
    }
//'no_telepon' => 'required|min:10|max:17|unique:clients,no_telepon',
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:2|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required',
            'nomor_telepon' => 'required|min:10|max:19|unique:users,nomor_telepon',
            'no_goodang' => 'nullable|unique:users,no_goodang',
            'alamat' => 'required|max:255',
            'id_gudang' => $request->role == 'staff' ? 'required|exists:gudangs,id' : 'nullable',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'nomor_telepon' => $request->nomor_telepon,
            'no_goodang' => $request->no_goodang,
            'alamat' => $request->alamat,
            'id_gudang' => $request->role == 'staff' ? $request->id_gudang : null,
        ]);

        flash('User baru berhasil ditambahkan.')->success();
        return redirect()->route('users.index');
    }

    public function show($id)
    {
        $user = User::with('gudang')->findOrFail($id);
        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $gudang = Gudang::all();
        return view('users.edit', compact('user', 'gudang'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|min:2|max:50',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6|confirmed',
            'role' => 'required',
            'nomor_telepon' => 'required|min:10|max:19|unique:users,nomor_telepon,' . $id,
            'no_goodang' => 'nullable|unique:users,no_goodang,' . $id,
            'alamat' => 'required|max:255',
            'id_gudang' => $request->role == 'staff' ? 'required|exists:gudangs,id' : 'nullable',
        ]);

        $user = User::findOrFail($id);

        if (Auth::user()->id === $user->id && Auth::user()->role === 'admin') {
            $request->merge(['role' => $user->role]); // Abaikan perubahan role
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
            'role' => $request->role,
            'nomor_telepon' => $request->nomor_telepon,
            'no_goodang' => $request->no_goodang,
            'alamat' => $request->alamat,
            'id_gudang' => $request->role == 'staff' ? $request->id_gudang : null,
        ]);

        flash('Data user berhasil diperbarui.')->success();
        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        flash('User berhasil dihapus.')->success();
        return redirect()->route('users.index');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
