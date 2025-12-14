<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PencatatanPesananController;
use App\Http\Controllers\PengolahanPesananController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\HomeController;




Route::get('/', function () {
    return view('home');
});

Route::get('/PencatatanPesanan', [PencatatanPesananController::class, 'create'])->name('pesanan.create');

Route::post('/PencatatanPesanan', [PencatatanPesananController::class, 'store'])->name('pesanan.store');

Route::get('/PengolahanPesanan', [PengolahanPesananController::class, 'index'])->name('pesanan.index');

Route::put('/pesanan/{no_transaksi}', [PengolahanPesananController::class, 'update'])->name('pesanan.update');

Route::delete('/pesanan/{no_transaksi}', [PengolahanPesananController::class, 'destroy'])->name('pesanan.destroy');

Route::get('/tambahProduk', [ProdukController::class, 'create'])->name('produk.create');

Route::post('/tambahProduk', [ProdukController::class, 'store'])->name('produk.store');

Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');

Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');

Route::get('/PengolahanPesanan', [PengolahanPesananController::class, 'index'])->name('pengolahan.index');

Route::get('/', [HomeController::class, 'index'])->name('home');