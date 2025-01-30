<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Gudang;
use App\Models\JumlahStok;
use App\Models\TransaksiDetail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KartuStokExport;

class StokBarangController extends Controller
{
    /**
     * Get stock card data.
     */
    public function index(Request $request)
    {
        try {
            $barangList = Barang::all();
            $gudangList = [];
            $kartuStok = [];
            $stokGudang = [];

            if ($request->filled('id_barang')) {
                $id_barang = $request->input('id_barang');
                $stokGudang = JumlahStok::where('id_barang', $id_barang)
                    ->where('kuantitas', '>', 0)
                    ->with('gudang')
                    ->get();

                $gudangList = $stokGudang->pluck('gudang', 'id_gudang');
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

            return response()->json([
                'success' => true,
                'data' => [
                    'barangList' => $barangList,
                    'gudangList' => $gudangList,
                    'kartuStok' => $kartuStok,
                    'stokGudang' => $stokGudang,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memuat data: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Export stock card to Excel.
     */
    public function exportKartuStok(Request $request)
    {
        try {
            if (!$request->filled(['id_barang', 'id_gudang'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Filter barang dan gudang wajib dipilih!',
                ], 422);
            }

            $fileName = 'kartu-stok-barang.xlsx';
            return Excel::download(new KartuStokExport($request->id_barang, $request->id_gudang), $fileName);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat export data: ' . $e->getMessage(),
            ], 500);
        }
    }
}
