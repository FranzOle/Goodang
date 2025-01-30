<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\JumlahStok;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StaffTransaksiController extends Controller
{
    /**
     * Menampilkan form transaksi (masuk/keluar)
     */
    public function create($type)
    {
        if (!in_array($type, ['in', 'out'])) {
            return response()->json([
                'error' => 'Invalid transaction type.',
            ], 404);
        }

        $user = Auth::user(); 
        $gudangAsal = $user->gudang; 
        $barangs = Barang::all(); 

        if (!$gudangAsal) {
            return response()->json([
                'error' => 'Anda tidak memiliki gudang terkait.',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'type' => $type,
                'gudangAsal' => $gudangAsal,
                'barangs' => $barangs,
            ]
        ], 200);
    }

    /**
     * Menyimpan transaksi (masuk/keluar)
     */
    public function store(Request $request, $type)
    {
        $user = Auth::user();
        $gudangAsal = $user->gudang;

        if (!$gudangAsal) {
            return response()->json([
                'error' => 'Anda tidak memiliki akses ke gudang tertentu.',
            ], 403);
        }

        // Validasi
        $validated = $request->validate([
            'kode_referensi' => 'required|unique:transaksis',
            'tanggal' => 'required|date|before_or_equal:today',
            'deskripsi_tujuan' => 'required|string|max:255',
            'stok' => 'required|array',
            'stok.*.id_barang' => 'required|exists:barangs,id',
            'stok.*.kuantitas' => 'required|integer|min:1',
        ], [
            'kode_referensi.required' => 'Kode referensi tidak boleh kosong.',
            'kode_referensi.unique' => 'Kode referensi sudah digunakan.',
            'tanggal.required' => 'Tanggal transaksi harus diisi.',
            'tanggal.before_or_equal' => 'Tanggal transaksi tidak boleh lebih dari hari ini.',
            'deskripsi_tujuan.required' => 'Deskripsi tujuan harus diisi.',
            'stok.required' => 'Barang dan kuantitas harus diisi.',
            'stok.*.id_barang.required' => 'Barang harus dipilih.',
            'stok.*.id_barang.exists' => 'Barang tidak ditemukan.',
            'stok.*.kuantitas.required' => 'Kuantitas barang harus diisi.',
            'stok.*.kuantitas.min' => 'Kuantitas barang minimal 1.',
        ]);

        DB::beginTransaction();

        try {
            $transaksi = Transaksi::create([
                'id_gudang' => $gudangAsal->id,
                'id_user' => $user->id,
                'kode_referensi' => $request->kode_referensi,
                'tanggal' => $request->tanggal,
                'deskripsi_tujuan' => $request->deskripsi_tujuan,
                'stock_type' => $type,
            ]);

            foreach ($request->stok as $stok) {
                TransaksiDetail::create([
                    'id_transaksi' => $transaksi->id,
                    'id_barang' => $stok['id_barang'],
                    'kuantitas' => $stok['kuantitas'],
                ]);

                $jumlahStok = JumlahStok::firstOrNew([
                    'id_barang' => $stok['id_barang'],
                    'id_gudang' => $gudangAsal->id,
                ]);

                if ($type === 'in') {
                    $jumlahStok->kuantitas += $stok['kuantitas'];
                } elseif ($type === 'out') {
                    if ($jumlahStok->kuantitas < $stok['kuantitas']) {
                        throw new \Exception("Stok barang ID {$stok['id_barang']} tidak mencukupi.");
                    }
                    $jumlahStok->kuantitas -= $stok['kuantitas'];
                }
                $jumlahStok->save();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil.',
                'data' => $transaksi,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => 'Transaksi Gagal: ' . $e->getMessage(),
            ], 400);
        }
    }
}
