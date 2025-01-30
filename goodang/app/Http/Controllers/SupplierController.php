<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request; 
use Barryvdh\DomPDF\Facade\Pdf;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $supplier = Supplier::orderby('created_at', 'DESC')->get();
        return view('supplier.index', compact('supplier'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|min:2|max:50|unique:suppliers,nama',
            'telepon' => 'required|min:10|max:15|unique:suppliers,telepon',
            'alamat' => 'required|min:5|max:255'
        ]);

        $supplier = new Supplier();
        $supplier->nama = $request->nama;
        $supplier->telepon = $request->telepon;
        $supplier->alamat = $request->alamat;
        $supplier->save();

        flash('Supplier baru telah ditambahkan')->success();
        return redirect()->route('supplier.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $supplier = Supplier::with('barang')->findOrFail($id);
        return view('supplier.show', compact('supplier'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('supplier.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'nama' => 'required|min:2|max:50|unique:suppliers,nama,' . $id,
            'telepon' => 'required|min:10|max:15|unique:suppliers,telepon,' . $id,
            'alamat' => 'required|min:5|max:255'
        ]);

        $supplier = Supplier::findOrFail($id);
        $supplier->nama = $request->nama;
        $supplier->telepon = $request->telepon;
        $supplier->alamat = $request->alamat;
        $supplier->save();

        flash('Data supplier telah diperbarui')->success();
        return redirect()->route('supplier.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->barang()->delete();
        $supplier->delete();
        

        flash('Supplier telah dihapus')->success();
        return redirect()->route('supplier.index');
    }

    public function export()
    {
        $supplier = Supplier::orderby('created_at', 'DESC')->get();
        $pdf = Pdf::loadView('supplier.pdf', compact('supplier'));
        return $pdf->download('data_supplier.pdf');
    }
}
