<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Gudang;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\JumlahStok;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        // Row 1: 
        $jumlahGudang = Gudang::count();
        $jumlahBarang = Barang::count();
        $jumlahTransaksiBulanIni = Transaksi::whereMonth('tanggal', Carbon::now()->month)
            ->whereYear('tanggal', Carbon::now()->year)
            ->count();
        $jumlahUser = User::count();
    
        // Row 2: 
        $tahunDipilih = request('tahun', Carbon::now()->year);
        $barangDipilih = request('barang_id');
        $barangs = Barang::all();
    
        $stockMovementIn = Transaksi::whereYear('tanggal', $tahunDipilih)
            ->where('stock_type', 'in')
            ->with(['transaksidetail' => function ($query) use ($barangDipilih) {
                if ($barangDipilih) {
                    $query->where('id_barang', $barangDipilih);
                }
            }])
            ->get()
            ->groupBy(fn($item) => Carbon::parse($item->tanggal)->format('F'))
            ->map(function ($group) {
                return $group->flatMap->transaksidetail->sum('kuantitas');
            });
    
        $stockMovementOut = Transaksi::whereYear('tanggal', $tahunDipilih)
            ->where('stock_type', 'out')
            ->with(['transaksidetail' => function ($query) use ($barangDipilih) {
                if ($barangDipilih) {
                    $query->where('id_barang', $barangDipilih);
                }
            }])
            ->get()
            ->groupBy(fn($item) => Carbon::parse($item->tanggal)->format('F'))
            ->map(function ($group) {
                return $group->flatMap->transaksidetail->sum('kuantitas');
            });
    
        // Weekly transactions
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $transaksiMingguan = Transaksi::whereBetween('tanggal', [$startOfWeek, $endOfWeek])
            ->select(['id', 'kode_referensi', 'tanggal'])
            ->get();
    
        // Low stock items
        $stokSedikit = JumlahStok::where('kuantitas', '<', 5)
            ->with(['barang', 'gudang'])
            ->get();
    
        // Top staff
        $topStaff = User::where('role', 'staff')
            ->withCount(['transaksi'])
            ->orderByDesc('transaksi_count')
            ->limit(5)
            ->get();
    
        return view('dashboard', compact(
            'jumlahGudang',
            'jumlahBarang',
            'jumlahTransaksiBulanIni',
            'jumlahUser',
            'barangs',
            'stockMovementIn',
            'stockMovementOut',
            'transaksiMingguan',
            'stokSedikit',
            'topStaff',
            'tahunDipilih',
            'barangDipilih'
        ));
    }
    

}
