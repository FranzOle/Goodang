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

class TransaksiController extends Controller
{
    /**
     * Store a newly created transaksi (in/out).
     */
    public function store(Request $request, $type)
    {
        if (!in_array($type, ['in', 'out'])) {
            return response()->json(['message' => 'Invalid transaction type'], 400);
        }

        $validated = $request->validate([
            'id_gudang' => 'required|exists:gudangs,id',
            'kode_referensi' => 'required|unique:transaksis',
            'tanggal' => 'required|date',
            'deskripsi_tujuan' => 'required|string|max:255',
            'stok' => 'required|array', 
            'stok.*.id_barang' => 'required|exists:barangs,id',
            'stok.*.kuantitas' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $transaksi = Transaksi::create([
                'id_gudang' => $request->id_gudang,
                'kode_referensi' => $request->kode_referensi,
                'tanggal' => $request->tanggal,
                'deskripsi_tujuan' => $request->deskripsi_tujuan,
                'stock_type' => $type,
                'id_user' => Auth::id(),
            ]);

            foreach ($request->stok as $stok) {
                TransaksiDetail::create([
                    'id_transaksi' => $transaksi->id,
                    'id_barang' => $stok['id_barang'],
                    'kuantitas' => $stok['kuantitas'],
                ]);

                $jumlahStok = JumlahStok::firstOrNew([
                    'id_barang' => $stok['id_barang'],
                    'id_gudang' => $request->id_gudang,
                ]);

                if ($type === 'in') {
                    $jumlahStok->kuantitas += $stok['kuantitas'];
                } elseif ($type === 'out') {
                    if ($jumlahStok->kuantitas < $stok['kuantitas']) {
                        return response()->json(['message' => "Stok tidak mencukupi untuk barang ID: {$stok['id_barang']}"], 400);
                    }
                    $jumlahStok->kuantitas -= $stok['kuantitas'];
                }

                $jumlahStok->save();
            }

            DB::commit();

            return response()->json(['message' => 'Transaksi berhasil', 'data' => $transaksi], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['message' => 'Transaksi gagal', 'error' => $e->getMessage()], 500);
        }
    }
}
