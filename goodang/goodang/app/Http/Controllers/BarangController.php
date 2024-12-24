<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\JumlahStok;
use App\Models\Gudang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barang = Barang::with(['kategori', 'supplier'])->orderBy('created_at', 'DESC')->get();
        return view('barang.index', compact('barang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = Kategori::all();
        $supplier = Supplier::all();
        return view('barang.create', compact('kategori', 'supplier'));
    }

    /**
     * Store a newly created resource in storage.
     */

     /**
 * Display the specified resource along with stock details.
 */
    public function show(string $id)
    {
        $barang = Barang::with(['kategori', 'supplier', 'jumlahstok.gudang'])->findOrFail($id);
        return view('barang.show', compact('barang'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'id_kategori' => 'required|exists:kategoris,id',
            'id_supplier' => 'required|exists:suppliers,id',
            'kode_sku' => 'required|unique:barangs,kode_sku',
            'nama' => 'required|min:2|max:100',
            'deskripsi' => 'nullable|max:755',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:10000'
        ]);

        $barang = new Barang();
        $barang->id_kategori = $request->id_kategori;
        $barang->id_supplier = $request->id_supplier;
        $barang->kode_sku = $request->kode_sku;
        $barang->nama = $request->nama;
        $barang->deskripsi = $request->deskripsi;

        if ($request->hasFile('gambar')) {
            $barang->gambar = $request->file('gambar')->store('barang', 'public');
        }

        $barang->save();

        flash('Barang baru telah ditambahkan')->success();
        return redirect()->route('barang.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $barang = Barang::findOrFail($id);
        $kategori = Kategori::all();
        $supplier = Supplier::all();
        return view('barang.edit', compact('barang', 'kategori', 'supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'id_kategori' => 'required|exists:kategoris,id',
            'id_supplier' => 'required|exists:suppliers,id',
            'kode_sku' => 'required|unique:barangs,kode_sku,' . $id,
            'nama' => 'required|min:2|max:100',
            'deskripsi' => 'nullable|max:755',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:10000'
        ]);

        $barang = Barang::findOrFail($id);
        $barang->id_kategori = $request->id_kategori;
        $barang->id_supplier = $request->id_supplier;
        $barang->kode_sku = $request->kode_sku;
        $barang->nama = $request->nama;
        $barang->deskripsi = $request->deskripsi;

        if ($request->hasFile('gambar')) {
            if ($barang->gambar) {
                \Storage::delete('public/' . $barang->gambar);
            }
            $barang->gambar = $request->file('gambar')->store('barang', 'public');
        }

        $barang->save();

        flash('Data barang telah diperbarui')->success();
        return redirect()->route('barang.index');
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

        flash('Barang telah dihapus')->success();
        return redirect()->route('barang.index');
    }

    public function export()
    {
        $barang = Barang::with(['kategori', 'supplier'])->orderBy('created_at', 'DESC')->get();
        $pdf = Pdf::loadView('barang.pdf', compact('barang'));
        return $pdf->download('data_barang.pdf');
    }

    public function export_show(string $id)
    {
        $barang = Barang::with(['kategori', 'supplier', 'jumlahstok.gudang'])->findOrFail($id);

        $pdf = Pdf::loadView('barang.pdf_show', compact('barang'));
        return $pdf->download('barang_' . $barang->kode_sku . '.pdf');
    }

}
