<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Gudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = user::orderby('created_at', 'DESC')->get();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gudang = Gudang::all();
        return view('users.create', compact('gudang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:2|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required',
            'id_gudang' => $request->role == 'staff' ? 'required' : 'nullable',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->id_gudang = $request->role == 'staff' ? $request->id_gudang : null;
        $user->save();

        flash('User  baru telah ditambahkan')->success();
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $gudang = Gudang::all();
        return view('users.edit', compact('user', 'gudang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required|min:2|max:50',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6|confirmed',
            'role' => 'required',
            'id_gudang' => $request->role == 'staff' ? 'required' : 'nullable',
        ]);
    
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->role = $request->role;
        $user->id_gudang = $request->role == 'staff' ? $request->id_gudang : null;
        $user->save();
    
        flash('Data user telah diperbarui')->success();
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        flash('User telah dihapus')->success();
        return redirect()->route('users.index');
    }

    public function logout () {
        Auth::logout();
        return redirect('/login');
    }
}
