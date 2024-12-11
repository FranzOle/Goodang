<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\StaffKategoriController;
use App\Http\Controllers\StaffSupplierController;
use App\Http\Controllers\StaffGudangController;
use App\Http\Controllers\StaffBarangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\TransferController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

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
});

Route::middleware(['auth:sanctum',])->group(function () {
    Route::resource('staffkategori', StaffKategoriController::class)->only(['index']);;
    Route::get('kategori-export', [KategoriController::class, 'export'])->name('kategori-export');

    Route::resource('staffsupplier', StaffSupplierController::class)->only(['index']);
    Route::get('supplier-export', [SupplierController::class, 'export'])->name('supplier.export');

    Route::resource('staffgudang', StaffGudangController::class);
    Route::get('gudang-export', [GudangController::class, 'export'])->name('gudang.export');
    // Route::get('supplier/export', [SupplierController::class, 'export'])->name('supplier.export');

    Route::resource('staffbarang', StaffBarangController::class);
    Route::get('barang-export', [BarangController::class, 'export'])->name('barang.export');
    Route::get('barang-export/{id}', [BarangController::class, 'export_show'])->name('barang.export_show');

});

