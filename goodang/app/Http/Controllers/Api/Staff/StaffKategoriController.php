<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class StaffKategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = Kategori::orderby('created_at', 'DESC')->get();
        return response()->json([
            'success' => true,
            'data' => $kategori,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kategori = Kategori::with('barang')->findOrFail($id);
        $barang = $kategori->barang;
        return response()->json([
            'success' => true,
            'data' => [
                'kategori' => $kategori,
                'barang' => $barang,
            ],
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
     * Export data to PDF.
     */
    public function export()
    {
        $kategori = Kategori::orderby('created_at', 'DESC')->get();
        $pdf = Pdf::loadView('kategori.pdf', compact('kategori'));
        return $pdf->download('kategori.pdf');
    }
}
