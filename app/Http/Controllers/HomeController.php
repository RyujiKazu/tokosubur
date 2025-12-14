<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; // Tambahkan ini untuk fungsi raw SQL

class HomeController extends Controller
{
    public function index()
    {
        $hariIni = Carbon::now()->format('Y-m-d');

        // --- DATA WIDGET ATAS (Sama seperti sebelumnya) ---
        $pendapatanHariIni = Transaksi::whereDate('tanggal', $hariIni)->sum('total');
        $jumlahTransaksi = Transaksi::whereDate('tanggal', $hariIni)->count();
        $riwayatTransaksi = Transaksi::with('produk')->orderBy('tanggal', 'desc')->take(5)->get();
        $totalProduk = Produk::count();

        // --- BAGIAN BARU: DATA UNTUK GRAFIK ---

        // 1. Grafik Area (Pendapatan 7 Hari Terakhir)
        // Kita butuh array tanggal dan array total pendapatan
        $tglArea = [];
        $dataArea = [];

        // Loop 7 hari ke belakang
        for ($i = 6; $i >= 0; $i--) {
            $tgl = Carbon::now()->subDays($i)->format('Y-m-d');
            $total = Transaksi::whereDate('tanggal', $tgl)->sum('total');
            
            $tglArea[] = Carbon::parse($tgl)->format('d M'); // Label (misal: 27 Okt)
            $dataArea[] = $total; // Data (misal: 500000)
        }

        // 2. Grafik Batang (Penjualan per Produk)
        // Kita butuh Nama Produk dan Total Qty yang terjual
        $produkJual = Transaksi::select('id_product', DB::raw('SUM(qty) as total_qty'))
                        ->groupBy('id_product')
                        ->with('produk') // Load relasi biar dapat namanya
                        ->get();

        $labelBar = [];
        $dataBar = [];

        foreach ($produkJual as $item) {
            // Cek jika produknya masih ada di database
            $nama = $item->produk ? $item->produk->nama_product : 'Produk Dihapus';
            $labelBar[] = $nama;
            $dataBar[] = $item->total_qty;
        }

        // Kirim semua variabel ke view, termasuk data grafik
        return view('home', compact(
            'pendapatanHariIni', 
            'jumlahTransaksi', 
            'riwayatTransaksi',
            'totalProduk',
            'tglArea', 'dataArea', // Data Grafik Area
            'labelBar', 'dataBar'  // Data Grafik Bar
        ));
    }
}