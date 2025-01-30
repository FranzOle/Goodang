<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class StaffBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barang = Barang::with(['kategori', 'supplier'])->orderBy('created_at', 'DESC')->get();
        return response()->json([
            'success' => true,
            'data' => $barang,
        ], 200);
    }

    /**
     * Show the specified resource.
     */
    public function show(string $id)
    {
        $barang = Barang::with(['kategori', 'supplier', 'jumlahstok.gudang'])->findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $barang,
        ], 200);
    }

        /**
     * Redirect access denied for creating new resource.
     */
    public function create()
    {
        return response()->json([
            'error' => 'Access denied.',
        ], 403);
    }

    /**
     * Redirect access denied for storing new resource.
     */
    public function store(Request $request)
    {
        return response()->json([
            'error' => 'Access denied.',
        ], 403);
    }

    /**
     * Redirect access denied for editing resource.
     */
    public function edit(string $id)
    {
        return response()->json([
            'error' => 'Access denied.',
        ], 403);
    }

    /**
     * Redirect access denied for updating resource.
     */
    public function update(Request $request, string $id)
    {
        return response()->json([
            'error' => 'Access denied.',
        ], 403);
    }

    /**
     * Redirect access denied for deleting resource.
     */
    public function destroy(string $id)
    {
        return response()->json([
            'error' => 'Access denied.',
        ], 403);
    }

    /**
     * Generate a PDF for the specified resource.
     */
    public function generatePdf(string $id)
    {
        $barang = Barang::with(['kategori', 'supplier', 'jumlahstok.gudang'])->findOrFail($id);
        $pdf = Pdf::loadView('nonadmin.barang.show', compact('barang'));
        return $pdf->download('barang_'.$id.'_detail.pdf');
    }
}
