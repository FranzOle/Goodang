<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\ClientController;

use App\Http\Controllers\Staff\StaffKategoriController;
use App\Http\Controllers\Staff\StaffSupplierController;
use App\Http\Controllers\Staff\StaffGudangController;
use App\Http\Controllers\Staff\StaffBarangController;
use App\Http\Controllers\Staff\StaffTransaksiController;

use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LogTransaksiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StokBarangController;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard route for authenticated users
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// User logout
Route::get('user/logout', [UserController::class, 'logout'])->name('users.logout');

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::resource('kategori', KategoriController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('barang', BarangController::class);
    Route::resource('gudang', GudangController::class);
    Route::resource('users', UserController::class);

    Route::get('transaksi/{type}/create', [TransaksiController::class, 'create'])
        ->name('transaksi.create')
        ->where('type', 'in|out'); 
    Route::post('transaksi/{type}/store', [TransaksiController::class, 'store'])
        ->name('transaksi.store')
        ->where('type', 'in|out');

    Route::get('transaksi/transfer/create', [TransferController::class, 'create'])->name('transaksi.transfer.create');
    Route::post('transaksi/transfer/store', [TransferController::class, 'store'])->name('transaksi.transfer.store');

    Route::resource('settings', SettingController::class);
    Route::resource('client', ClientController::class);
});

// Staff-specific routes
Route::middleware(['auth:sanctum', 'role:staff'])->group(function () {
    Route::get('stafftransaksi/{type}/create', [StaffTransaksiController::class, 'create'])
        ->name('stafftransaksi.create')
        ->where('type', 'in|out');
    Route::post('stafftransaksi/{type}/store', [StaffTransaksiController::class, 'store'])
        ->name('stafftransaksi.store')
        ->where('type', 'in|out');
});

// Shared authenticated routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('staffkategori', StaffKategoriController::class)->only(['index', 'show']);
    Route::get('kategori-export', [KategoriController::class, 'export'])->name('kategori-export');

    Route::resource('staffsupplier', StaffSupplierController::class)->only(['index', 'show']);
    Route::get('supplier-export', [SupplierController::class, 'export'])->name('supplier.export');

    Route::resource('staffgudang', StaffGudangController::class);
    Route::get('gudang-export', [GudangController::class, 'export'])->name('gudang.export');

    Route::resource('staffbarang', StaffBarangController::class);
    Route::get('barang-export', [BarangController::class, 'export'])->name('barang.export');
    Route::get('barang-export/{id}', [BarangController::class, 'export_show'])->name('barang.export_show');

    Route::post('/theme/update', [ThemeController::class, 'update'])->name('theme.update');

    Route::resource('profiles', ProfileController::class);

    Route::get('logtransaksi-export', [LogTransaksiController::class, 'export'])->name('logtransaksi.export');
    Route::get('logtransaksi-export{id}', [LogTransaksiController::class, 'exportShow'])->name('logtransaksi.export_show');
    Route::resource('logtransaksi', LogTransaksiController::class);

    Route::resource('kartustok', StokBarangController::class);
    Route::get('/export-kartu-stok', [StokBarangController::class, 'exportKartuStok'])->name('kartustok.export');

    Route::get('client-export', [ClientController::class, 'export'])->name('client.export');

});
