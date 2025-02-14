<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Finance;
use App\Models\TransaksiDetail;
use App\Models\JumlahStok;
use App\Models\Barang;
use App\Models\Gudang;
use App\Models\Client;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource with filtering.
     */
    public function index(Request $request)
    {
        try {
            // Ambil data yang akan digunakan untuk filter di view
            $clientList = Client::all();
            $salesUsers = User::where('role', 'sales')->get();

            $saleList = [];

            if ($request->has('q')) {
                return Sale::with('client', 'user')
                    ->whereHas('client', function ($query) use ($request) {
                        $query->where('nama', 'like', '%' . $request->q . '%');
                    })->get();
            }

            $query = Sale::with('client', 'user')->orderBy('tanggal', 'desc');

            if ($request->filled('client_id')) {
                $client_id = $request->input('client_id');
                $query->where('client_id', $client_id);
            }

            if ($request->filled('user_id')) {
                $user_id = $request->input('user_id');
                $query->where('user_id', $user_id);
            }

            if ($request->filled('tahun')) {
                $query->whereYear('tanggal', $request->tahun);
            }

            if ($request->filled('bulan') && $request->filled('tahun')) {
                $query->whereMonth('tanggal', $request->bulan)
                      ->whereYear('tanggal', $request->tahun);
            }

            $saleList = $query->paginate(10);

            $tahunList = Sale::selectRaw('YEAR(tanggal) as tahun')
                ->groupBy('tahun')
                ->orderBy('tahun', 'desc')
                ->pluck('tahun');

            return view('sale.index', compact('clientList', 'salesUsers', 'saleList', 'tahunList'));
        } catch (\Exception $e) {
            Log::error('Error in SalesController@index: ' . $e->getMessage());
            return redirect()->route('sale.index')->with('error', 'Terjadi kesalahan saat memuat data. Silakan coba lagi.');
        }
    }

    public function create()
    {
        $clients = Client::all();
        $gudangs = Gudang::all();
        $barangs = Barang::all();
        
        $salesUsers = User::where('role', 'sales')->get();

        return view('sale.create', compact('clients', 'gudangs', 'barangs', 'salesUsers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'client_id'         => 'required|exists:clients,id',
        'id_gudang'         => 'required|exists:gudangs,id',
        'tanggal'           => 'required|date|before_or_equal:today',
        'user_id'           => 'required|exists:users,id',  // user dengan role sales
        'stok'              => 'required|array',
        'stok.*.id_barang'  => 'required|exists:barangs,id',
        'stok.*.kuantitas'  => 'required|integer|min:1',
    ]);

    // Pastikan user yang dipilih memiliki role sales
    $salesUser = User::find($request->user_id);
    if ($salesUser->role !== 'sales') {
        return back()->withInput()->withErrors(['user_id' => 'User yang dipilih bukan seorang sales.']);
    }

    DB::beginTransaction();

    try {
        $totalSale = 0;
        $saleDetailsData = []; // Untuk menyimpan data detail penjualan

        // Hitung total penjualan dan persiapkan data untuk sale details
        foreach ($request->stok as $stok) {
            $barang = Barang::findOrFail($stok['id_barang']);

            // Validasi: Pastikan ada stok masuk sebelumnya untuk barang ini
            $stokMasukSebelumnya = TransaksiDetail::whereHas('transaksi', function ($query) use ($stok, $request) {
                $query->where('stock_type', 'in')
                      ->where('id_gudang', $request->id_gudang)
                      ->where('tanggal', '<=', $request->tanggal);
            })->where('id_barang', $stok['id_barang'])->exists();

            if (!$stokMasukSebelumnya) {
                throw new \Exception("Stok keluar tidak bisa dilakukan sebelum ada stok masuk untuk barang: {$barang->nama}");
            }

            // Dapatkan dan perbarui stok yang tersedia
            $jumlahStok = JumlahStok::firstOrNew([
                'id_barang' => $stok['id_barang'],
                'id_gudang' => $request->id_gudang,
            ]);

            if ($jumlahStok->kuantitas < $stok['kuantitas']) {
                throw new \Exception("Stok tidak mencukupi untuk barang: {$barang->nama}");
            }

            // Kurangi stok dan simpan perubahan
            $jumlahStok->kuantitas -= $stok['kuantitas'];
            $jumlahStok->save();

            // Hitung subtotal untuk item ini
            $subtotal = $barang->harga * $stok['kuantitas'];
            $totalSale += $subtotal;

            // Siapkan data untuk SaleDetail (belum menyertakan sale_id)
            $saleDetailsData[] = [
                'barang_id'   => $stok['id_barang'],
                'gudang_id'   => $request->id_gudang,
                'kuantitas'   => $stok['kuantitas'],
                'barang_nama' => $barang->nama,
                'harga'       => $barang->harga,
                'subtotal'    => $subtotal,
            ];
        }

        // Pastikan total penjualan lebih dari 0
        if ($totalSale <= 0) {
            throw new \Exception("Total penjualan harus lebih dari 0.");
        }

        // Buat record penjualan dengan total yang sudah dihitung dan status 'completed'
        $sale = Sale::create([
            'user_id'   => $salesUser->id,
            'client_id' => $request->client_id,
            'tanggal'   => $request->tanggal,
            'total'     => $totalSale,
            'status'    => 'completed',
        ]);

        // Simpan masing-masing detail penjualan dengan menyertakan sale_id
        foreach ($saleDetailsData as $detailData) {
            $detailData['sale_id'] = $sale->id;
            SaleDetail::create($detailData);
        }

        // Buat data transaksi keuangan
        Finance::create([
            'user_id'     => $salesUser->id,
            'sale_id'     => $sale->id,
            'type'        => 'sale',
            'amount'      => $totalSale,
            'tanggal'     => $request->tanggal,
            'description' => 'Transaksi penjualan',
        ]);

        DB::commit();

        flash('Penjualan berhasil')->success();
        return redirect()->route('sale.index');
    } catch (\Exception $e) {
        DB::rollBack();
        flash('Penjualan Gagal: ' . $e->getMessage())->error();
        return back()->withInput();
    }
}



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sale = Sale::with('saleDetails', 'client', 'user')->findOrFail($id);
        return view('sale.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sale = Sale::with('saleDetails')->findOrFail($id);
        $clients = Client::all();
        $gudangs = Gudang::all();
        $barangs = Barang::all();
        $salesUsers = User::where('role', 'sales')->get();
        
        return view('sale.edit', compact('sale', 'clients', 'gudangs', 'barangs', 'salesUsers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return redirect()->route('sale.index')->with('info', 'Fungsi update belum diimplementasikan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return redirect()->route('sale.index')->with('info', 'Fungsi delete belum diimplementasikan.');
    }
}
