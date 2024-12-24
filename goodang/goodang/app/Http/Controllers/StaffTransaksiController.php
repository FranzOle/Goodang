<?php

namespace App\Http\Controllers;

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
            abort(404);
        }

        $user = Auth::user(); 
        $gudangAsal = $user->gudang; 
        $barangs = Barang::all(); 

        if (!$gudangAsal) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki gudang terkait.');
        }

        return view("stafftransaksi.{$type}", compact('type', 'gudangAsal', 'barangs'));
    }

    /**
     * Menyimpan transaksi (masuk/keluar)
     */
    public function store(Request $request, $type)
    {
        $user = Auth::user();
        $gudangAsal = $user->gudang;

        if (!$gudangAsal) {
            return back()->with('error', 'Anda tidak memiliki akses ke gudang tertentu.');
        }

        // Validasi
        $validated = $request->validate([
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
            
            flash('Transaksi berhasil')->success();
            return redirect()->route('staffgudang.show', $gudangAsal->id);
        } catch (\Exception $e) {
            DB::rollBack();
            flash($e->getMessage())->error(); 
            return back();
        }
    }
}
