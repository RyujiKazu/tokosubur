<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/PencatatanPesanan', function () {
    return view('pencatatanPesanan');
});

Route::get('/PengolahanPesanan', function () {
    return view('pengolahanPesanan');
});
