<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();
        return response()->json(['data' => $kategori]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:kategoris|max:255',
        ]);

        $kategori = Kategori::create($request->all());
        return response()->json(['message' => 'Kategori created successfully', 'data' => $kategori], 201);
    }

    public function show($id)
    {
        $kategori = Kategori::findOrFail($id);
        return response()->json(['data' => $kategori]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|unique:kategoris,nama,' . $id,
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update($request->all());

        return response()->json(['message' => 'Kategori updated successfully', 'data' => $kategori]);
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return response()->json(['message' => 'Kategori deleted successfully']);
    }
}
