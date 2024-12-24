<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class StaffKategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = Kategori::orderby('created_at', 'DESC')->get();
        return view('nonadmin.kategori.index', compact('kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('/staffkategori')->with('error', 'Access denied.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return redirect()->route('/staffkategori')->with('error', 'Access denied.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return redirect()->route('/staffkategori')->with('error', 'Access denied.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return redirect()->route('/staffkategori')->with('error', 'Access denied.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return redirect()->route('/staffkategori')->with('error', 'Access denied.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return redirect()->route('/staffkategori')->with('error', 'Access denied.');
    }

    public function export()
    {
        $kategori = Kategori::orderby('created_at', 'DESC')->get();
        $pdf = Pdf::loadView('kategori.pdf', compact('kategori'));
        return $pdf->download('kategori.pdf');
    }
}
