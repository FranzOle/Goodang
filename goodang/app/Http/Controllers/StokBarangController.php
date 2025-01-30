<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Gudang;
use App\Models\JumlahStok;
use App\Models\TransaksiDetail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KartuStokExport;
use Illuminate\Support\Facades\Log;

class StokBarangController extends Controller
{
    public function index(Request $request)
    {
        try {
            $barangList = Barang::all();
            $gudangList = Gudang::all(); 
            $kartuStok = [];
            $stokGudang = [];
            
            if ($request->filled('id_barang')) {
                $id_barang = $request->input('id_barang');

                $stokGudang = JumlahStok::where('id_barang', $id_barang)
                    ->where('kuantitas', '>', 0)
                    ->with('gudang')
                    ->get();
            }

            if ($request->filled(['id_barang', 'id_gudang'])) {
                $id_barang = $request->input('id_barang');
                $id_gudang = $request->input('id_gudang');

                $kartuStok = TransaksiDetail::with(['transaksi', 'barang'])
                    ->where('id_barang', $id_barang)
                    ->whereHas('transaksi', function ($query) use ($id_gudang) {
                        $query->where('id_gudang', $id_gudang);
                    })
                    ->get();
            }

            return view('kartustok.index', compact('barangList', 'gudangList', 'kartuStok', 'stokGudang'));
        } catch (\Exception $e) {
            Log::error('Error pada StokBarangController@index: ' . $e->getMessage());

            return redirect()->route('kartustok.index')->with('error', 'Terjadi kesalahan saat memuat data. Silakan coba lagi.');
        }
    }

    public function exportKartuStok(Request $request)
    {
        try {
            if (!$request->filled(['id_barang', 'id_gudang'])) {
                return redirect()->back()->with('error', 'Both item and warehouse filters must be selected.');
            }

            $id_barang = $request->id_barang;
            $id_gudang = $request->id_gudang;

            return Excel::download(new KartuStokExport($id_barang, $id_gudang), 'kartu-stok-barang.xlsx');
        } catch (\Exception $e) {
            Log::error('Error in StokBarangController@exportKartuStok: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred during export: ' . $e->getMessage());
        }
    }
}
