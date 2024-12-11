<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class GudangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gudang = Gudang::orderby('created_at', 'DESC')->get();
        return view('gudang.index', compact('gudang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gudang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|min:2|max:50|unique:gudangs,nama',
            'alamat' => 'required|min:5|max:255|unique:gudangs,alamat'
        ]);

        $gudang = new Gudang();
        $gudang->nama = $request->nama;
        $gudang->alamat = $request->alamat;
        $gudang->save();

        flash('Gudang baru telah ditambahkan')->success();
        return redirect()->route('gudang.index');
    }

        public function show(string $id)
    {
        $gudang = Gudang::with(['jumlahstok.barang'])->findOrFail($id);

        return view('gudang.show', compact('gudang'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $gudang = Gudang::findOrFail($id);
        return view('gudang.edit', compact('gudang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'nama' => 'required|min:2|max:50|unique:gudangs,nama,' . $id,
            'alamat' => 'required|min:5|max:255|unique:gudangs,alamat,' . $id
        ]);

        $gudang = Gudang::findOrFail($id);
        $gudang->nama = $request->nama;
        $gudang->alamat = $request->alamat;
        $gudang->save();

        flash('Data gudang telah diperbarui')->success();
        return redirect()->route('gudang.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gudang = Gudang::findOrFail($id);
        $gudang->jumlahstok()->delete();
        $gudang->transaksi()->delete();
        $gudang->delete();

        flash('Gudang telah dihapus')->success();
        return redirect()->route('gudang.index');
    }

    /**
     * Export data to PDF.
     */
    public function export()
    {
        $gudang = Gudang::orderby('created_at', 'DESC')->get();
        $pdf = Pdf::loadView('gudang.pdf', compact('gudang'));
        return $pdf->download('data_gudang.pdf');
    }
}
