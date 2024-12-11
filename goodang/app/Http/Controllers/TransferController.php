<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\JumlahStok;
use App\Models\Barang;
use App\Models\Gudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    /**
     * Menampilkan form transfer antar gudang
     */
    public function create()
    {
        // Ambil semua gudang
        $gudangs = Gudang::all();

        // Tampilkan form transfer
        return view('transaksi.transfer', compact('gudangs'));
    }

    /**
     * Menyimpan transaksi transfer antar gudang
     */
    public function store(Request $request)
    {
        // Validasi input
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
            // Simpan data utama transaksi untuk gudang asal (keluar)
            $transaksiOut = Transaksi::create([
                'id_gudang' => $request->gudang_asal,
                'kode_referensi' => $request->kode_referensi . '-OUT',
                'tanggal' => $request->tanggal,
                'deskripsi_tujuan' => 'Transfer ke Gudang ID: ' . $request->gudang_tujuan,
                'stock_type' => 'out',
            ]);

            // Simpan data utama transaksi untuk gudang tujuan (masuk)
            $transaksiIn = Transaksi::create([
                'id_gudang' => $request->gudang_tujuan,
                'kode_referensi' => $request->kode_referensi . '-IN',
                'tanggal' => $request->tanggal,
                'deskripsi_tujuan' => 'Transfer dari Gudang ID: ' . $request->gudang_asal,
                'stock_type' => 'in',
            ]);

            // Loop untuk setiap barang yang ditransfer
            foreach ($request->stok as $stok) {
                // Validasi stok tersedia di gudang asal
                $jumlahStokAsal = JumlahStok::where('id_barang', $stok['id_barang'])
                    ->where('id_gudang', $request->gudang_asal)
                    ->first();

                if (!$jumlahStokAsal || $jumlahStokAsal->kuantitas < $stok['kuantitas']) {
                    throw new \Exception("Stok tidak mencukupi untuk Barang ID: {$stok['id_barang']}");
                }

                // Kurangi stok di gudang asal
                $jumlahStokAsal->kuantitas -= $stok['kuantitas'];
                $jumlahStokAsal->save();

                // Tambah stok di gudang tujuan
                $jumlahStokTujuan = JumlahStok::firstOrNew([
                    'id_barang' => $stok['id_barang'],
                    'id_gudang' => $request->gudang_tujuan,
                ]);
                $jumlahStokTujuan->kuantitas += $stok['kuantitas'];
                $jumlahStokTujuan->save();

                // Simpan detail transaksi keluar (gudang asal)
                TransaksiDetail::create([
                    'id_transaksi' => $transaksiOut->id,
                    'id_barang' => $stok['id_barang'],
                    'kuantitas' => $stok['kuantitas'],
                ]);

                // Simpan detail transaksi masuk (gudang tujuan)
                TransaksiDetail::create([
                    'id_transaksi' => $transaksiIn->id,
                    'id_barang' => $stok['id_barang'],
                    'kuantitas' => $stok['kuantitas'],
                ]);
            }

            DB::commit();

            flash('transaksi berhasil')->success();
            return redirect()->route('barang.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
