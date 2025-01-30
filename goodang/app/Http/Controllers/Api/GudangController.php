<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gudang;
use Illuminate\Http\Request;

class GudangController extends Controller
{
    public function index()
    {
        $gudang = Gudang::all();
        return response()->json(['data' => $gudang]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:gudangs|max:255',
            'alamat' => 'required',
        ]);

        $gudang = Gudang::create($request->all());
        return response()->json(['message' => 'Gudang created successfully', 'data' => $gudang], 201);
    }

    public function show($id)
    {
        $gudang = Gudang::findOrFail($id);
        return response()->json(['data' => $gudang]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|unique:gudangs,nama,' . $id,
            'alamat' => 'required',
        ]);

        $gudang = Gudang::findOrFail($id);
        $gudang->update($request->all());

        return response()->json(['message' => 'Gudang updated successfully', 'data' => $gudang]);
    }

    public function destroy($id)
    {
        $gudang = Gudang::findOrFail($id);
        $gudang->delete();

        return response()->json(['message' => 'Gudang deleted successfully']);
    }
}
