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
use Carbon\Carbon;

class StokBarangController extends Controller
{
    public function index(Request $request)
    {
        try {
            $barangList = Barang::all();
            $gudangList = Gudang::all(); 
            $kartuStok = [];
            $stokGudang = [];
            
            // Fitur 2: Select2 - Ambil data barang berdasarkan pencarian
            if ($request->has('q')) {
                return Barang::where('nama', 'like', '%'.$request->q.'%')->get();
            }

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

                $query = TransaksiDetail::with(['transaksi', 'barang'])
                    ->where('id_barang', $id_barang)
                    ->whereHas('transaksi', function ($query) use ($id_gudang) {
                        $query->where('id_gudang', $id_gudang);
                    });

                // Fitur 3: Filter tanggal
                if ($request->filled('tahun')) {
                    $query->whereHas('transaksi', function ($q) use ($request) {
                        $q->whereYear('tanggal', $request->tahun);
                    });
                }

                if ($request->filled('bulan') && $request->filled('tahun')) {
                    $query->whereHas('transaksi', function ($q) use ($request) {
                        $q->whereMonth('tanggal', $request->bulan)
                          ->whereYear('tanggal', $request->tahun);
                    });
                }

                $kartuStok = $query->get()->map(function ($item, $key) {
                    $item->transaksi->tanggal = Carbon::parse($item->transaksi->tanggal)->format('Y-m-d');
                    return $item;
                });

                // Fitur 1: Hitung pergerakan stok
                $saldo = 0;
                $kartuStok = $kartuStok->sortBy('transaksi.tanggal')->map(function ($item) use (&$saldo) {
                    $saldo += $item->transaksi->stock_type == 'in' ? $item->kuantitas : -$item->kuantitas;
                    $item->saldo = $saldo;
                    return $item;
                });
            }

            // Ambil tahun unik untuk filter
            $tahunList = TransaksiDetail::with('transaksi')
                ->get()
                ->pluck('transaksi.tanggal')
                ->filter()
                ->map(function ($date) {
                    return Carbon::parse($date)->year;
                })
                ->unique()
                ->sortDesc()
                ->values();

            return view('kartustok.index', compact('barangList', 'gudangList', 'kartuStok', 'stokGudang', 'tahunList'));
        } catch (\Exception $e) {
            Log::error('Error pada StokBarangController@index: ' . $e->getMessage());
            return redirect()->route('kartustok.index')->with('error', 'Terjadi kesalahan saat memuat data. Silakan coba lagi.');
        }
    }

    // ... (method exportKartuStok tetap sama)
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