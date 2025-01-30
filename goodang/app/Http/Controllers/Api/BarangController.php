<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Supplier;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barang = Barang::with(['kategori', 'supplier'])->orderBy('created_at', 'DESC')->get();
        return response()->json($barang);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required|exists:kategoris,id',
            'id_supplier' => 'required|exists:suppliers,id',
            'kode_sku' => 'required|unique:barangs,kode_sku',
            'nama' => 'required|min:2|max:100',
            'deskripsi' => 'nullable|max:755',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:10000',
        ]);

        $barang = new Barang($request->only(['id_kategori', 'id_supplier', 'kode_sku', 'nama', 'deskripsi']));

        if ($request->hasFile('gambar')) {
            $barang->gambar = $request->file('gambar')->store('barang', 'public');
        }

        $barang->save();

        return response()->json(['message' => 'Barang berhasil ditambahkan', 'data' => $barang], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $barang = Barang::with(['kategori', 'supplier', 'jumlahstok.gudang'])->findOrFail($id);
        return response()->json($barang);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_kategori' => 'required|exists:kategoris,id',
            'id_supplier' => 'required|exists:suppliers,id',
            'kode_sku' => 'required|unique:barangs,kode_sku,' . $id,
            'nama' => 'required|min:2|max:100',
            'deskripsi' => 'nullable|max:755',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:10000',
        ]);

        $barang = Barang::findOrFail($id);
        $barang->fill($request->only(['id_kategori', 'id_supplier', 'kode_sku', 'nama', 'deskripsi']));

        if ($request->hasFile('gambar')) {
            if ($barang->gambar) {
                \Storage::delete('public/' . $barang->gambar);
            }
            $barang->gambar = $request->file('gambar')->store('barang', 'public');
        }

        $barang->save();

        return response()->json(['message' => 'Barang berhasil diperbarui', 'data' => $barang]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $barang = Barang::findOrFail($id);

        if ($barang->gambar) {
            \Storage::delete('public/' . $barang->gambar);
        }

        $barang->jumlahstok()->delete();
        $barang->transaksidetail()->delete();
        $barang->delete();

        return response()->json(['message' => 'Barang berhasil dihapus']);
    }
}
