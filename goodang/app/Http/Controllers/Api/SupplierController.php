<?php

namespace App\Http\Controllers\Api;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::orderby('created_at', 'DESC')->get();
        return response()->json(['data' => $suppliers], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|min:2|max:50|unique:suppliers,nama',
            'telepon' => 'required|min:10|max:15|unique:suppliers,telepon',
            'alamat' => 'required|min:5|max:255',
        ]);

        $supplier = Supplier::create($validatedData);
        return response()->json(['message' => 'Supplier created successfully', 'data' => $supplier], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $supplier = Supplier::with('barang')->find($id);

        if (!$supplier) {
            return response()->json(['message' => 'Supplier not found'], 404);
        }

        return response()->json(['data' => $supplier], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $supplier = Supplier::find($id);

        if (!$supplier) {
            return response()->json(['message' => 'Supplier not found'], 404);
        }

        $validatedData = $request->validate([
            'nama' => 'required|min:2|max:50|unique:suppliers,nama,' . $id,
            'telepon' => 'required|min:10|max:15|unique:suppliers,telepon,' . $id,
            'alamat' => 'required|min:5|max:255',
        ]);

        $supplier->update($validatedData);
        return response()->json(['message' => 'Supplier updated successfully', 'data' => $supplier], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $supplier = Supplier::find($id);

        if (!$supplier) {
            return response()->json(['message' => 'Supplier not found'], 404);
        }

        $supplier->barang()->delete();
        $supplier->delete();

        return response()->json(['message' => 'Supplier deleted successfully'], 200);
    }

    /**
     * Export supplier data to PDF.
     */
    public function export()
    {
        $suppliers = Supplier::orderby('created_at', 'DESC')->get();
        $pdf = Pdf::loadView('supplier.pdf', compact('suppliers'));

        return response()->streamDownload(
            fn() => print($pdf->output()),
            'data_supplier.pdf',
            ['Content-Type' => 'application/pdf']
        );
    }
}
