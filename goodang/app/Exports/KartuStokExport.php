<?php

namespace App\Exports;

use App\Models\TransaksiDetail;
use App\Models\Barang;
use App\Models\Gudang;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class KartuStokExport implements FromView
{
    protected $id_barang;
    protected $id_gudang;

    public function __construct($id_barang, $id_gudang)
    {
        $this->id_barang = $id_barang;
        $this->id_gudang = $id_gudang;
    }

    public function view(): View
    {
        $barang = Barang::findOrFail($this->id_barang);
        $gudang = Gudang::findOrFail($this->id_gudang);

        $kartuStok = TransaksiDetail::with(['transaksi', 'barang'])
            ->where('id_barang', $this->id_barang)
            ->whereHas('transaksi', function ($query) {
                $query->where('id_gudang', $this->id_gudang);
            })
            ->orderBy('created_at', 'asc')
            ->get();
            // dd($kartuStok);
            // die();

        // Alternative to logging warnings (using exception here)
        if ($kartuStok->isEmpty()) {
            throw new \Exception("Kartu stok kosong untuk barang ID {$this->id_barang} dan gudang ID {$this->id_gudang}");
        }

        return view('exports.kartu_stok', compact('barang', 'gudang', 'kartuStok'));
    }
}
