<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\JumlahStok;
use App\Models\Barang;
use App\Models\Gudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    /**
     * Menampilkan form transaksi (masuk/keluar)
     */
        public function create($type)
    {
        if (!in_array($type, ['in', 'out'])) {
            abort(404);
        }
        $gudangs = Gudang::all();
        $barangs = Barang::all();

        // Tampilkan form dengan tipe transaksi
        return view("transaksi.{$type}", compact('type', 'gudangs', 'barangs'));
    }

    public function store(Request $request, $type)
    {
        // Validasi
        $validated = $request->validate([
            'id_gudang' => 'required|exists:gudangs,id',
            'kode_referensi' => 'required|unique:transaksis',
            'tanggal' => 'required|date',
            'deskripsi_tujuan' => 'required|string|max:255',
            'stok' => 'required|array',  // Barang dan kuantitas
            'stok.*.id_barang' => 'required|exists:barangs,id',
            'stok.*.kuantitas' => 'required|integer|min:1',
        ], [
            // Pesan error kustom
            'id_gudang.required' => 'Gudang harus dipilih.',
            'kode_referensi.required' => 'Kode referensi tidak boleh kosong.',
            'kode_referensi.unique' => 'Kode referensi sudah digunakan.',
            'tanggal.required' => 'Tanggal transaksi harus diisi.',
            'deskripsi_tujuan.required' => 'Deskripsi tujuan harus diisi.',
            'stok.required' => 'Barang dan kuantitas harus diisi.',
            'stok.*.id_barang.required' => 'Barang harus dipilih.',
            'stok.*.kuantitas.required' => 'Kuantitas barang harus diisi.',
            'stok.*.kuantitas.min' => 'Kuantitas barang minimal 1.',
        ]);
    
        // Mulai transaksi database
        DB::beginTransaction();
    
        try {
            // Simpan data utama transaksi
            $transaksi = Transaksi::create([
                'id_gudang' => $request->id_gudang,
                'kode_referensi' => $request->kode_referensi,
                'tanggal' => $request->tanggal,
                'deskripsi_tujuan' => $request->deskripsi_tujuan,
                'stock_type' => $type,
            ]);
    
            // Loop untuk menyimpan detail transaksi
            foreach ($request->stok as $stok) {
                TransaksiDetail::create([
                    'id_transaksi' => $transaksi->id,
                    'id_barang' => $stok['id_barang'],
                    'kuantitas' => $stok['kuantitas'],
                ]);
    
                // Perbarui jumlah stok di gudang
                $jumlahStok = JumlahStok::firstOrNew([
                    'id_barang' => $stok['id_barang'],
                    'id_gudang' => $request->id_gudang,
                ]);
    
                if ($type === 'in') {
                    $jumlahStok->kuantitas += $stok['kuantitas'];
                } elseif ($type === 'out') {
                    if ($jumlahStok->kuantitas < $stok['kuantitas']) {
                        throw new \Exception("Stok tidak mencukupi untuk barang ID: {$stok['id_barang']}");
                    }
                    $jumlahStok->kuantitas -= $stok['kuantitas'];
                }
                $jumlahStok->save();
            }
    
            DB::commit();
            flash('transaksi berhasil')->success();
            return redirect()->route('barang.index');
        } catch (\Exception $e) {
            DB::rollBack();
    
            // Notifikasi error
            return back()->with('error', $e->getMessage());
        }
    }
    
}