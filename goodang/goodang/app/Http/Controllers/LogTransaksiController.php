<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Barang;
use App\Models\Gudang;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LogTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $barangId = $request->input('barang_id');
        $gudangId = $request->input('gudang_id');
        $userId = $request->input('user_id');
        $tanggalFilter = $request->input('tanggal');
        $tanggalSpesifik = $request->input('tanggal_spesifik'); 

        $query = Transaksi::with(['gudang', 'user', 'transaksidetail.barang']);

        if ($tanggalFilter === 'hari') {
            $query->whereDate('tanggal', Carbon::today());
        } elseif ($tanggalFilter === 'bulan') {
            $query->whereMonth('tanggal', Carbon::now()->month)
                  ->whereYear('tanggal', Carbon::now()->year);
        } elseif ($tanggalFilter === 'tahun') {
            $query->whereYear('tanggal', Carbon::now()->year);
        }

        if ($tanggalSpesifik) {
            $query->whereDate('tanggal', $tanggalSpesifik);
        }

        if ($barangId) {
            $query->whereHas('transaksidetail', function ($q) use ($barangId) {
                $q->where('id_barang', $barangId);
            });
        }
        if ($gudangId) {
            $query->where('id_gudang', $gudangId);
        }
        if ($userId) {
            $query->where('id_user', $userId);
        }

        $transaksi = $query->latest()->get();

        $barangs = Barang::all();
        $gudangs = Gudang::all();
        $users = User::all();

        return view('logtransaksi.index', compact('transaksi', 'barangs', 'gudangs', 'users'));
    }

    public function show($id)
    {
        $transaksi = Transaksi::with(['gudang', 'user', 'transaksidetail.barang'])->findOrFail($id);
        return view('logtransaksi.show', compact('transaksi'));
    }

    public function export()
    {
        $transaksi = Transaksi::with(['gudang', 'user', 'transaksidetail.barang'])
            ->orderBy('tanggal', 'DESC')
            ->get();

        $pdf = Pdf::loadView('logtransaksi.pdf', compact('transaksi'));
        return $pdf->download('log_transaksi.pdf');
    }

    /**
     * Export specific transaction details to PDF.
     */
    public function exportShow($id)
    {
        $transaksi = Transaksi::with(['gudang', 'user', 'transaksidetail.barang'])->findOrFail($id);

        $pdf = Pdf::loadView('logtransaksi.show_pdf', compact('transaksi'));
        return $pdf->download("detail_transaksi_{$id}.pdf");
    }
}
