<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\JumlahStok;
use App\Models\Barang;
use App\Models\Gudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;  
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    /**
     * Menampilkan form transaksi (masuk/keluar).
     */
    public function create($type)
    {
        if (!in_array($type, ['in', 'out'])) {
            abort(404);
        }
        $gudangs = Gudang::all();
        $barangs = Barang::all();

        return view("transaksi.{$type}", compact('type', 'gudangs', 'barangs'));
    }

    public function store(Request $request, $type)
    {
        // Validasi
        $validated = $request->validate([
            'id_gudang' => 'required|exists:gudangs,id',
            'kode_referensi' => 'required|unique:transaksis',
            'tanggal' => 'required|date|before_or_equal:today',
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
                $barang = Barang::find($stok['id_barang']); // Ambil nama barang
                
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
                    
                    $stokMasukSebelumnya = TransaksiDetail::whereHas('transaksi', function ($query) use ($stok, $request) {
                        $query->where('stock_type', 'in')
                              ->where('id_gudang', $request->id_gudang)
                              ->where('tanggal', '<=', $request->tanggal);
                    })->where('id_barang', $stok['id_barang'])->exists();

                    if (!$stokMasukSebelumnya) {
                        throw new \Exception("Stok keluar tidak bisa dilakukan sebelum ada stok masuk untuk barang: {$barang->nama}");
                    }

                    if ($jumlahStok->kuantitas < $stok['kuantitas']) {
                        throw new \Exception("Stok tidak mencukupi untuk barang: {$barang->nama}");
                    }

                    $jumlahStok->kuantitas -= $stok['kuantitas'];
                }

                $jumlahStok->save();
            }

            DB::commit();

            flash('Transaksi berhasil')->success();
            return redirect()->route('gudang.show', $request->id_gudang);
        } catch (\Exception $e) {
            DB::rollBack();

            flash('Transaksi Gagal: ' . $e->getMessage())->error();
            return back()->withInput();
        }
    }
}
