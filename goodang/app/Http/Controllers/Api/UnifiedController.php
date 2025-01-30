<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Supplier;

class UnifiedController extends Controller
{
    public function getAllBarang()
    {
        $barang = Barang::with(['kategori:id,nama', 'supplier:id,nama'])->get();
        return response()->json($barang, 200);
    }
    

    public function getBarangById($id)
    {
        $barang = Barang::with('kategori', 'supplier')->find($id);
        if (!$barang) {
            return response()->json(['message' => 'Barang not found'], 404);
        }
        return response()->json($barang, 200);
    }

    // Kategori APIs
    public function getAllKategori()
    {
        $kategori = Kategori::all();
        return response()->json($kategori, 200);
    }

    public function getKategoriById($id)
    {
        $kategori = Kategori::find($id);
        if (!$kategori) {
            return response()->json(['message' => 'Kategori not found'], 404);
        }
        return response()->json($kategori, 200);
    }

    // Supplier APIs
    public function getAllSupplier()
    {
        $supplier = Supplier::all();
        return response()->json($supplier, 200);
    }

    public function getSupplierById($id)
    {
        $supplier = Supplier::find($id);
        if (!$supplier) {
            return response()->json(['message' => 'Supplier not found'], 404);
        }
        return response()->json($supplier, 200);
    }
}
