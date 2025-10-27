<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PencatatanPesananController;

Route::get('/', function () {
    return view('home');
});

Route::get('/PengolahanPesanan', function () {
    return view('pengolahanPesanan');
});

Route::get('/PencatatanPesanan', [PencatatanPesananController::class, 'create'])->name('pesanan.create');

Route::post('/PencatatanPesanan', [PencatatanPesananController::class, 'store'])->name('pesanan.store');
