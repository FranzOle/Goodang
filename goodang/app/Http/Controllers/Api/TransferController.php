<?php

namespace App\Http\Controllers\Api;

use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\JumlahStok;
use App\Models\Barang;
use App\Models\Gudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TransferController extends Controller
{
    /**
     * Store a new transfer transaction between warehouses.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'gudang_asal' => 'required|exists:gudangs,id',
            'gudang_tujuan' => 'required|exists:gudangs,id|different:gudang_asal',
            'kode_referensi' => 'required|unique:transaksis',
            'tanggal' => 'required|date',
            'stok' => 'required|array',
            'stok.*.id_barang' => 'required|exists:barangs,id',
            'stok.*.kuantitas' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $transaksiOut = Transaksi::create([
                'id_gudang' => $request->gudang_asal,
                'kode_referensi' => $request->kode_referensi . '-OUT',
                'tanggal' => $request->tanggal,
                'deskripsi_tujuan' => 'Transfer ke Gudang ID: ' . $request->gudang_tujuan,
                'stock_type' => 'out',
                'id_user' => Auth::id(),
            ]);

            $transaksiIn = Transaksi::create([
                'id_gudang' => $request->gudang_tujuan,
                'kode_referensi' => $request->kode_referensi . '-IN',
                'tanggal' => $request->tanggal,
                'deskripsi_tujuan' => 'Transfer dari Gudang ID: ' . $request->gudang_asal,
                'stock_type' => 'in',
                'id_user' => Auth::id(),
            ]);

            foreach ($request->stok as $stok) {
                $jumlahStokAsal = JumlahStok::where('id_barang', $stok['id_barang'])
                    ->where('id_gudang', $request->gudang_asal)
                    ->first();

                if (!$jumlahStokAsal || $jumlahStokAsal->kuantitas < $stok['kuantitas']) {
                    return response()->json(['message' => "Stok tidak mencukupi untuk Barang ID: {$stok['id_barang']}"], 400);
                }

                $jumlahStokAsal->kuantitas -= $stok['kuantitas'];
                $jumlahStokAsal->save();

                $jumlahStokTujuan = JumlahStok::firstOrNew([
                    'id_barang' => $stok['id_barang'],
                    'id_gudang' => $request->gudang_tujuan,
                ]);
                $jumlahStokTujuan->kuantitas += $stok['kuantitas'];
                $jumlahStokTujuan->save();

                TransaksiDetail::create([
                    'id_transaksi' => $transaksiOut->id,
                    'id_barang' => $stok['id_barang'],
                    'kuantitas' => $stok['kuantitas'],
                ]);
                TransaksiDetail::create([
                    'id_transaksi' => $transaksiIn->id,
                    'id_barang' => $stok['id_barang'],
                    'kuantitas' => $stok['kuantitas'],
                ]);
            }

            DB::commit();

            return response()->json(['message' => 'Transaksi berhasil', 'data' => $transaksiOut], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Transaksi gagal', 'error' => $e->getMessage()], 500);
        }
    }
}
