<?php

namespace App\Http\Controllers;


use App\Models\Kategori;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; 

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = Kategori::orderby('created_at', 'DESC')->get();
        return view('kategori.index', compact('kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Validasi
        $this->validate($request, [
            'nama' => 'required|min:2|max:50|unique:kategoris'
        ]);

        $kategori = new Kategori();
        $kategori->nama = $request->nama;
        $kategori->save();
        flash('Kategori Baru telah dibuat')->success();

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kategori = Kategori::with('barang')->findOrFail($id);
        $barang = $kategori->barang;

        return view('kategori.show', compact('kategori', 'barang'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'nama' => 'required|min:2|max:50|unique:kategoris,nama, ' . $id
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->nama = $request->nama;
        $kategori->save();

        flash('Kategori telah diedit')->success();
        return redirect()->route('kategori.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->barang()->delete();
        $kategori->delete();

        flash('Kategori dihapus')->success();
        return redirect()->route('kategori.index');
    }

    public function export()
    {
        $kategori = Kategori::orderby('created_at', 'DESC')->get();
        $pdf = Pdf::loadView('kategori.pdf', compact('kategori'));
        return $pdf->download('kategori.pdf');
    }
}
