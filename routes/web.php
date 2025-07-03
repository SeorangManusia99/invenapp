<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware(['auth'])->group( function () {
    Route::resource('users', UserController::class);

    Route::resource('barang', BarangController::class);
    Route::get('get-barang', [BarangController::class, 'getBarang'])->name('get.barang');

    Route::get('barang-print', [BarangController::class, 'cetakBarangPdf'])->name('cetak.barang');
    Route::get('export-barang', [BarangController::class, 'exportBarang'])->name('export.barang');

    Route::get('import-barang', [BarangController::class, 'importBarang'])->name('import.barang');
});
