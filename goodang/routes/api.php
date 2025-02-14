<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UnifiedController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\GudangController;
use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\TransaksiController;
use App\Http\Controllers\Api\TransferController;
use App\Http\Controllers\Api\LogTransaksiController;
use App\Http\Controllers\Api\StokBarangController;
use App\Http\Controllers\Api\UserController;

use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;

use App\Http\Controllers\Api\Staff\StaffKategoriController;
use App\Http\Controllers\Api\Staff\StaffSupplierController;
use App\Http\Controllers\Api\Staff\StaffGudangController;
use App\Http\Controllers\Api\Staff\StaffBarangController;
use App\Http\Controllers\Api\Staff\StaffTransaksiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
// */
// Route::post('/register', RegisterController::class)->name('register');
// Route::post('/login', LoginController::class)->name('login');
// Route::post('/logout', LogoutController::class)->name('logout');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:api', 'role:admin'])->group(function () {

    Route::apiResource('kategori', KategoriController::class);
    Route::apiResource('supplier', SupplierController::class);
    Route::apiResource('gudang', GudangController::class);
    Route::apiResource('barang', BarangController::class);
    Route::apiResource('users', UserController::class);

    Route::post('transaksis/{type}', [TransaksiController::class, 'store'])
        ->name('transaksis.store')
        ->where('type', 'in|out');
    Route::post('transaksis/transfer', [TransferController::class, 'store'])
        ->name('transaksis.transfer.store');

});

Route::middleware(['auth:api', 'role:staff'])->group(function () {
    Route::post('stafftransaksis/{type}', [StaffTransaksiController::class, 'store'])
    ->name('stafftransaksis.store')
    ->where('type', 'in|out');
});

Route::middleware('auth:api')->group(function () {

    Route::apiResource('staffkategori', StaffKategoriController::class);
    Route::apiResource('staffsupplier', StaffSupplierController::class);
    Route::apiResource('staffgudang', StaffGudangController::class);
    Route::apiResource('staffbarang', StaffBarangController::class);

    //AI API
    Route::get('barangs', [UnifiedController::class, 'getAllBarang']);
    Route::get('barangs/{id}', [UnifiedController::class, 'getBarangById']);
    Route::get('kategoris', [UnifiedController::class, 'getAllKategori']);
    Route::get('kategoris/{id}', [UnifiedController::class, 'getKategoriById']);
    Route::get('suppliers', [UnifiedController::class, 'getAllSupplier']);
    Route::get('suppliers/{id}', [UnifiedController::class, 'getSupplierById']);

    Route::apiResource('logtransaksis', LogTransaksiController::class);
    Route::get('logtransaksis-export', [LogTransaksiController::class, 'export'])
        ->name('logtransaksis.export');
    Route::get('logtransaksis-export/{id}', [LogTransaksiController::class, 'exportShow'])
        ->name('logtransaksis.export_show');

    Route::apiResource('kartustok', StokBarangController::class);
    Route::get('export-kartu-stok', [StokBarangController::class, 'exportKartuStok'])
        ->name('kartustok.export');
});